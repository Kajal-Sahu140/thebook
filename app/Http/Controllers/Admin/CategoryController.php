<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
    public function index(Request $request)
    {   
        $pageCount = config('app.admin_record_per_page', 10);
        $currentPage = $request->input('page', 1);
        $query = Category::with('subcategories')->whereNull('category_id');
        if ($search = $request->input('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        $count = ($currentPage - 1) * $pageCount + 1;
        try {
            $users = $query->orderBy('id', 'DESC')->paginate($pageCount);
        } catch (\Exception $e) {
            Log::error('Error retrieving categories: ' . $e->getMessage());
            return redirect()->route('admin.category')->with('error', 'Failed to retrieve categories.');
        }
        // dd($users);
        return view('admin.category.index', compact('users', 'count'));
    }
    public function create()
    {
        $categories = Category::whereNull('category_id')->get();
        return view('admin.category.create', compact('categories'));
    }
    public function store(Request $request)
{
    // Validate incoming data
    $request->validate([
        'name' => 'required|string|max:30',
        // 'name_ar' => 'required|string|max:30',
        // 'name_cku' => 'required|string|max:30',
        // 'description_ar' => 'required|string|max:1000',
        // 'description_cku' => 'required|string|max:1000',
        'description' => 'required|string|max:1000',
        'category_id' => 'nullable|exists:categories,id',
        'image' => 'required|image|mimes:jpeg,png,jpg',
        // 'image_ar' => 'required|image|mimes:jpeg,png,jpg',
        // 'image_cku' => 'required|image|mimes:jpeg,png,jpg',

        'status' => 'required|boolean',
    ]);

    $data = $request->all();

    try {
        // Define subcategory limits
        $subcategoryLimits = [
            68 => 5, // For category ID 68, max 5 subcategories
            74 => 5, // For category ID 74, max 5 subcategories
            80 => 4, // For category ID 80, max 4 subcategories
        ];

        // Check subcategory limits dynamically
        foreach ($subcategoryLimits as $categoryId => $limit) {
            if ($request->category_id == $categoryId) {
                $bannercount = Category::where('category_id', $categoryId)->count();
                if ($bannercount >= $limit) {
                    return redirect()->route('admin.category.create')
                        ->with('error', "Subcategory limit reached for category ID $categoryId. Only $limit subcategories can be created.");
                }
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category_images', 'public');
            $data['image'] = $imagePath;
        }
         if ($request->hasFile('image_ar')) {
            $imagePath = $request->file('image_ar')->store('category_images', 'public');
            $data['image_ar'] = $imagePath;
        }
         if ($request->hasFile('image_cku')) {
            $imagePath = $request->file('image_cku')->store('category_images', 'public');
            $data['image_cku'] = $imagePath;
        }

        // Create the category or subcategory
        Category::create($data);

        // Success response
        $message = $request->category_id
            ? 'Subcategory created successfully.'
            : 'Category created successfully.';

        return redirect()->route('admin.category')->with('success', $message);

    } catch (\Exception $e) {
        // Log the error and return failure response
        \Log::error('Error creating category: ' . $e->getMessage());
        return redirect()->route('admin.category.create')->with('error', 'Failed to create category.');
    }
}
    ////////////////////////////////////////////////
    public function edit($id)
    {
        $decodedId = base64_decode($id);
        try {
            $category = Category::findOrFail($decodedId);
            $categories = Category::whereNull('category_id')->get();
            return view('admin.category.edit', compact('category', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error retrieving category for edit: ' . $e->getMessage());
            return redirect()->route('admin.category')->with('error', 'Failed to retrieve category for editing.');
        }
    }
    //////////////////////////////
   public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|max:30',
        // 'name_ar' => 'required|max:30',
        // 'name_cku' => 'required|max:30',
        // 'description_ar' => 'required|max:1000',
        // 'description_cku' => 'required|max:1000',
        'description' => 'required',
        'status' => 'required|boolean',
        'image' => 'nullable|image',
        // 'image_ar' => 'nullable|image|mimes:jpg,jpeg,png',
        // 'image_cku' => 'nullable|image|mimes:jpg,jpeg,png',
    ]);
    try {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->name_ar = $request->name_ar;
        $category->name_cku = $request->name_cku;
        $category->description = $request->description;
        $category->description_ar = $request->description_ar;
        $category->description_cku = $request->description_cku;
        $category->status = $request->status;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category_images', 'public');
            $category->image = $imagePath;
        }
        if ($request->hasFile('image_ar')) {
            $imagePath = $request->file('image_ar')->store('category_images', 'public');
            $category->image_ar = $imagePath;
        }
        if ($request->hasFile('image_cku')) {
            $imagePath = $request->file('image_cku')->store('category_images', 'public');
            $category->image_cku = $imagePath;
        }
        $category->save();
        if ($category->category_id !== null) {
            // Redirect to subcategory list for the parent category
            return redirect()->route('admin.subcategory', ['id' => base64_encode($category->category_id)])
                             ->with('success', 'Subcategory updated successfully.');
        }
        return redirect()->route('admin.category')->with('success', 'Category updated successfully.');  
    } catch (\Exception $e) {
        dd($e);
        Log::error('Error updating category: ' . $e->getMessage());
        return redirect()->route('admin.category.edit', base64_encode($id))
                         ->with('error', 'Failed to update category.');
    }
}
    public function destroy($id)
{
    $decodedId = base64_decode($id);
    try {
        $category = Category::findOrFail($decodedId);

        $category->delete();
        if (!empty($category->category_id)) {
            return redirect()->route('admin.subcategory', ['id' => base64_encode($category->category_id)])
                ->with('success', 'Sub Category deleted successfully.');
        }
        else{
            return redirect()->route('admin.category')->with('success', 'Category deleted successfully.');
        }
       
    } catch (\Exception $e) {
        dd($e);
        Log::error('Error deleting category: ' . $e->getMessage());
        return redirect()->route('admin.category')->with('error', 'Failed to delete category.');
    }
}
    //////////////////////////////////////////////////////////////
    public function subcategorylist(Request $request, $id)
    {
        $decodedId = base64_decode($id);
        $pageCount = config('app.admin_record_per_page', 10);
        $currentPage = $request->input('page', 1);
        try {
            $category = Category::with('subcategories')->findOrFail($decodedId);
            $query = $category->subcategories();
            if ($search = $request->input('search')) {
                $query->where('name', 'like', '%' . $search . '%');
            }
            $count = ($currentPage - 1) * $pageCount + 1;
            $users = $query->paginate($pageCount);
            return view('admin.subcategory.index', compact('users', 'count', 'category'));
        } catch (\Exception $e) {
            Log::error('Error retrieving subcategories: ' . $e->getMessage());
            return redirect()->route('admin.category')->with('error', 'Failed to retrieve subcategories.');
        }
    }
    //////////////////////////////////////////////////
}
