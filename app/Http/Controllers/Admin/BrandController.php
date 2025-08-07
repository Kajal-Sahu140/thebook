<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Log;
class BrandController extends Controller
{
    public function index(Request $request)
    {
        $pageCount = config('app.admin_record_per_page', 10);
        $currentPage = $request->input('page', 1);
        $query = Brand::orderBy('id','desc');
        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $count = ($currentPage - 1) * $pageCount + 1;
        try {
            $users = $query->paginate($pageCount);
        } catch (\Exception $e) {
            Log::error('Error retrieving categories: ' . $e->getMessage());
            return redirect()->route('admin.brand')->with('error', 'Failed to retrieve categories.');
        }
        return view('admin.brand.index', compact('users', 'count'));
    }
    //////////////////////////////////////////////
    public function create()
    {
         return view('admin.brand.create');
    }
    /////////////////////////
   public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|max:30',
        'name_ar' => 'required|max:30',
        'name_cku' => 'required|max:30',
        'description' => 'required|max:1000',
        'description_ar' => 'required|max:1000',
        'description_cku' => 'required|max:1000',
        'status' => 'required|boolean',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    try {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brand_temp', 'public');
            session(['temp_image' => $imagePath]);
        } else {
            $imagePath = $request->input('old_image') ?? null;
        }

        $brand = Brand::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'name_cku' => $request->name_cku,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'status' => $request->status,
            'image' => $imagePath ?? null,
        ]);

        session()->forget('temp_image');

        return redirect()->route('admin.brand')->with('success', 'Brand created successfully.');

    } catch (\Exception $e) {
        \Log::error('Error creating brand: ' . $e->getMessage());
        return redirect()->route('admin.brand.create')
            ->withInput()
            ->with('error', 'Failed to create brand.');
    }
}


    ////////////////////////////////////////////
    public function edit($id)
    {
        $decodedId = base64_decode($id);
        try {
            $category = Brand::findOrFail($decodedId);
            // dd($category);die;
            return view('admin.brand.edit', compact('category'));
        } catch (\Exception $e) {
            Log::error('Error retrieving category for edit: ' . $e->getMessage());
            return redirect()->route('admin.brand')->with('error', 'Failed to retrieve category for editing.');
        }
    }
    //////////////////////////////
   public function update(Request $request, $id)
{
    // $request->validate([
    //     'name' => 'required|max:30',
    //     'name_ar' => 'required|max:30',
    //     'name_cku' => 'required|max:30',
    //     'description' => 'required|max:1000',
    //     'description_ar' => 'required|max:1000',
    //     'description_cku' => 'required|max:1000',
    //     'status' => 'required|boolean',
    //     'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //     'image_ar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //     'image_cku' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    // ]);
    try {
        $category = Brand::findOrFail($id);
        $category->name = $request->name;
        $category->name_ar = $request->name_ar;
        $category->name_cku = $request->name_cku;
        $category->description = $request->description;
        $category->description_ar = $request->description_ar;
        $category->description_cku = $request->description_cku;
        $category->status = $request->status;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('brand', 'public');
            $category->image = $imagePath;
        }
         if ($request->hasFile('image_ar')) {
            $imagePath = $request->file('image_ar')->store('brand', 'public');
            $category->image_ar = $imagePath;
        }
         if ($request->hasFile('image_cku')) {
            $imagePath = $request->file('image_cku')->store('brand', 'public');
            $category->image_cku = $imagePath;
        }
        $category->save();
        return redirect()->route('admin.brand')->with('success', 'Brand updated successfully.');  
    } catch (\Exception $e) {
        Log::error('Error updating category: ' . $e->getMessage());
        return redirect()->route('admin.brand.edit', base64_encode($id))
                         ->with('error', 'Failed to update Brand.');
    }
}
/////////////////////////////////////
   public function destroy($id)
    {
        $decodedId = base64_decode($id);
        try {
            $category = Brand::findOrFail($decodedId);
            $category->delete();
            return redirect()->route('admin.brand')->with('success', 'Brand deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            return redirect()->route('admin.brand')->with('error', 'Failed to delete Brand.');
        }
    }
       /////////////////////////////////////////////
}
