<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UserEmailRequests;
use App\Http\Requests\Admin\Users\UserSignInRequests;
use App\Mail\ForgetPassword;
use App\Models\Admin;
use App\Models\Warehouse;
use App\Models\Otp;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
class WarehouseController extends Controller
{
   public function index(Request $request)
   {
    $pageCount = config('app.admin_record_per_page', 10);
        $currentPage = $request->input('page', 1);
        $query = Warehouse::orderBy('id','desc');
        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $count = ($currentPage - 1) * $pageCount + 1;
        try {
            $users = $query->paginate($pageCount);
        } catch (\Exception $e) {
            Log::error('Error retrieving categories: ' . $e->getMessage());
            return redirect()->route('admin.category')->with('error', 'Failed to retrieve categories.');
        }
        return view('admin.warehouse.index', compact('users', 'count'));
   }
   //////////////////////////////////////////////
   public function create()
   {
    return view('admin.warehouse.create');
   }
   //////////////////////////////////////////////
public function store(Request $request)
{
    // Validate incoming request data
    $request->validate([
        'name' => 'required|max:30',
        'email' => 'required|email|unique:admins,email',
        'status' => 'required',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);
    try {
        $data = $request->only(['name', 'email', 'status']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('warehouse', 'public');
        }
        // $data['type'] = 'warehouse';
        $data['email_verified_at'] = now();
        // $password = Str::random(8);
        $data['dummy_password']= 'Admin@1234';
        $data['password'] = bcrypt('Admin@1234');
        $admin = Warehouse::create($data);
        return redirect()->route('admin.warehouse')->with('success', 'Warehouse created successfully. Password: Admin@1234');
    } catch (\Exception $e) {
       
        Log::error('Error creating Warehouse: ' . $e->getMessage());

        return redirect()->route('admin.warehouse.create')->with('error', 'Failed to create Warehouse. Please try again.');
    }
}
////////////////////////////////////////////////////////////////////////////
 public function destroy($id)
    {
        $decodedId = base64_decode($id);
        try {
            $category = Warehouse::findOrFail($decodedId);
            $category->delete();
            return redirect()->route('admin.warehouse')->with('success', 'Warehouse deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            return redirect()->route('admin.warehouse')->with('error', 'Failed to delete warehouse.');
        }
    }
    ///////////////////////////////////////////////
    public function edit($id)
    {
    $decodedId = base64_decode($id);
    $warehouse = Warehouse::where('id', $decodedId)->firstOrFail();
    return view('admin.warehouse.edit', compact('warehouse'));
    }
////////////////////////////////////////////////////
public function update(Request $request, $id)
{
    $admin = Warehouse::where('id', $id)->firstOrFail();
    $request->validate([
        'name' => 'required|max:30',
        'email' => 'required|email|unique:admins,email,' . $admin->id,
        'status' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);
    try {
        $data = $request->only(['name', 'email', 'status']);
        if ($request->hasFile('image')) {
            if ($admin->image) {
                Storage::disk('public')->delete($admin->image);
            }
            $data['image'] = $request->file('image')->store('warehouse', 'public');
        }
        $admin->update($data);
        return redirect()->route('admin.warehouse')->with('success', 'Warehouse updated successfully.');
    } catch (\Exception $e) {
        Log::error('Error updating Warehouse: ' . $e->getMessage());
        return redirect()->route('admin.warehouse.edit', $id)->with('error', 'Failed to update Warehouse. Please try again.');
    }
}
//////////////////////////////////////////////////////////////////////////
}
