<?php
namespace App\Http\Controllers\Warehouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
class CategoryController extends Controller
{
   public function index()
   {
      $categories = Category::where('warehouse_id',Auth::guard('warehouse')->user()->id)->whereNull('category_id')->paginate(10);
      return view('warehouse.category.index',compact('categories'));
   }
   ////////////////////////////////////////
   public function subcategory($id)
   {  
      try {
         $category = Category::findOrFail($id);
         $categories = Category::where('category_id', $id)
            ->where('warehouse_id', Auth::guard('warehouse')->user()->id)
            ->paginate(10);
            if ($categories->isEmpty()) {
               return redirect()->route('warehouse.category')->with('error', 'Subcategories not found.');
            }  
         return view('warehouse.category.subcategory', compact('categories', 'id','category'));
      } catch (\Exception $e) {
         Log::error('Error retrieving subcategories: ' . $e->getMessage());
         return redirect()->route('warehouse.category')->with('error', 'Failed to retrieve subcategories.');
      }
   }
   ///////////////////////////////////////////////
   public function create()
   {
      try {
         $categories = Category::where('warehouse_id', Auth::guard('warehouse')->user()->id)
            ->whereNull('category_id')
            ->get();
         return view('warehouse.category.create', compact('categories'));
      } catch (\Exception $e) {
         Log::error('Error retrieving categories for creation: ' . $e->getMessage());
         return redirect()->route('warehouse.category')->with('error', 'Failed to retrieve categories for creation.');
      }
   }
   ///////////////////////////////////////////////
   public function store(Request $request)
{

    // Validate incoming data
    $request->validate([
        'name' => 'required|string|max:30',
        'description' => 'required|string|max:150',
        'category_id' => 'nullable|exists:categories,id', // Nullable for main categories
        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'status' => 'required|boolean',
    ]);

    $data = $request->all();
    $data['warehouse_id'] = Auth::guard('warehouse')->user()->id;
    try {
        // Define subcategory limits for specific categories dynamically
        $subcategoryLimits = [
            1 => 5, // Example: Category ID 1 can have up to 5 subcategories
            2 => 3, // Example: Category ID 2 can have up to 3 subcategories
        ];

        // Check subcategory limits
        if ($request->category_id && isset($subcategoryLimits[$request->category_id])) {
            $subcategoryCount = Category::where('category_id', $request->category_id)->count();
            $limit = $subcategoryLimits[$request->category_id];

            if ($subcategoryCount >= $limit) {
                return redirect()->route('warehouse.category.create')
                    ->with('error', "Subcategory limit reached for category ID {$request->category_id}. Only {$limit} subcategories are allowed.");
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category_images', 'public');
            $data['image'] = $imagePath;
        }

        // Create the category or subcategory
        Category::create($data);

        // Success message
        $message = $request->category_id
            ? 'Subcategory created successfully.'
            : 'Category created successfully.';

        return redirect()->route('warehouse.category')->with('success', $message);

    } catch (\Exception $e) {
      dd($e);
        // Log the error for debugging
        \Log::error('Error creating category: ' . $e->getMessage());

        return redirect()->route('warehouse.category.create')->with('error', 'Failed to create category.');
    }
}

   public function edit($id)
   {
      $category = Category::findOrFail($id);
      $categories = Category::where('warehouse_id',Auth::guard('warehouse')->user()->id)->whereNull('category_id')->get();
      return view('warehouse.category.edit',compact('category','categories'));
   }
   /////////////////////////////////////////////////
   public function update(Request $request, $id)
{
   $request->validate([
        'name' => 'required|max:30',
        'description' => 'required|max:1000',
        'status' => 'required|boolean',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);
    try {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category_images', 'public');
            $category->image = $imagePath;
        }
        $category->save();
        if ($category->category_id !== null) {
            // Redirect to subcategory list for the parent category
            return redirect()->route('warehouse.subcategory', ['id' => base64_encode($category->category_id)])
                             ->with('success', 'Subcategory updated successfully.');
        }
        return redirect()->route('warehouse.category')->with('success', 'Category updated successfully.');  
    } catch (\Exception $e) {
        Log::error('Error updating category: ' . $e->getMessage());
        return redirect()->route('warehouse.category.edit', base64_encode($id))
                         ->with('error', 'Failed to update category.');
    }
}
}
