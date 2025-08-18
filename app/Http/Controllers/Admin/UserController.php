<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallethistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; // Import the validator
class UserController extends Controller
{
   public function index(Request $request)
{
    $pageCount = config('app.admin_record_per_page', 10);
    $currentPage = $request->input('page', 1);
    $query = User::with('profile');

    // Apply search filter if provided
    if ($search = $request->input('search')) {
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('phone', 'like', '%' . $search . '%')
              ->orWhere('whatsapp', 'like', '%' . $search . '%');
        });
    }

    // Apply status filter if provided
    if ($status = $request->input('status')) {
        $query->where('status', $status);
    }

    $count = ($currentPage - 1) * $pageCount + 1;
    $users = $query->orderBy('id', 'DESC')->paginate($pageCount);

    return view('admin.customer.index', compact('users', 'count'));
}

////////////////////////////////////
public function view($id)
{
    $userId = base64_decode($id);
    $user=User::with('profile')->where('id',$userId)->first();
    return view('admin.customer.view', compact('user'));
}
////////////////////////////////////////
public function edit($id)
{
    $userId = base64_decode($id);
    $user=User::with('profile')->where('id',$userId)->first();
    return view('admin.customer.edit', compact('user'));
}
public function update(Request $request, $id)
{
    try {
        // Find the user with profile relationship
        $user = User::with('profile')->find($id);

        if (!$user) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }
         $request->validate([
            'name' => 'required|min:3|max:255',
            //'phone' => 'required|regex:/^[0-9]+$/',
            //'whatsapp' => 'required|regex:/^[0-9]+$/',
            'email' => 'nullable|email|unique:users,email,' . $id, // Ignore uniqueness for current user's email
            'status' => 'required|in:active,de-active',
        ]);
       
         
        // dd($request);die;
        $user->update([
            'name' => $request->input('name'),
            // 'phone' => $request->input('phone'),
            // 'whatsapp' => $request->input('whatsapp'),
            'email' => $request->input('email'),
            'status' => $request->input('status'),
        ]);
        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
        
    } catch (\Exception $e) {
        // dd($e);
        // Log the exception for debugging
        Log::error('User update failed: ' . $e->getMessage());
        return redirect()->back()->with('error', $e->getMessage())->withInput();
    }
}


public function editwallet(Request $request){

$wallet = User::where('id',$request->id)->first();
  return view('admin.customer.wallet', compact('wallet'));
}





public function addwallet(Request $request)
{
    $request->validate([
        'id' => 'required|exists:users,id',
        'wallet' => 'required|numeric|min:1'
    ]);

    // Find user
    $user = User::findOrFail($request->id);

    // Increase wallet balance
    $user->wallet += $request->wallet;
    $user->save();

    // Save wallet history
    Wallethistory::create([
        'wallet_id'        => $user->id,
        'type'             => 'credit', // since we're adding
        'transaction_type' => 'add_to_wallet',
        'amount'           => $request->wallet,
    ]);

    return redirect()->route('admin.users')
        ->with('success', 'Wallet amount added successfully!');
}
























//////////////////////////////////////
public function destroy($id)
{
    $decodedId = base64_decode($id);
    $user = User::findOrFail($decodedId);

    // Revoke all tokens for the user (Sanctum)
    $user->tokens()->delete();

    $user->delete();

    return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
}
}
