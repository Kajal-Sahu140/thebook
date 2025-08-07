<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use DB;
use App\Models\Cart;
use App\Models\CartOrderSummary;
use App\Models\Wishlist;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Size;
use App\Models\Color;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
  public function index(Request $request)
{
    $pageCount = config('app.admin_record_per_page', 10);
    $currentPage = $request->input('page', 1);

    $query = Product::orderBy('product_id', 'desc');
    if ($search = $request->input('search')) {
        $query->where('product_name', 'like', '%' . $search . '%');
    }
    $count = ($currentPage - 1) * $pageCount + 1;
    try {
        $products = $query->paginate($pageCount);
        $productImages = [];
        $productVariants = [];
        foreach ($products as $product) {
            if (!empty($product->product_id)) {
                $productImage = ProductImage::where('product_id', $product->product_id)->first();
                $productVariant = ProductVariant::where('product_id', $product->product_id)->first();
                \Log::info("Product ID: " . $product->product_id);
                \Log::info("Images: ", $productImage ? $productImage->toArray() : []);
                \Log::info("Variants: ", $productVariant ? $productVariant->toArray() : []);
                $productImages[$product->product_id] = $productImage;
                $productVariants[$product->product_id] = $productVariant;
            }
        }
    } catch (\Exception $e) {
        dd($e);
        \Log::error('Error retrieving products: ' . $e->getMessage());
        return redirect()->route('admin.product')->with('error', 'Failed to retrieve products.');
    }
    return view('admin.product.index', compact('products', 'productImages', 'productVariants', 'count'));
}
////////////////////////////////////////////////////////////
public function create()
{
    $brands=Brand::where('status','active')->get();
    $categories=Category::where('status',1)->whereNull('category_id')->get();
    $colors=Color::get();
    $sizes=Size::get();
     return view('admin.product.create',compact('brands','categories','colors','sizes'));
}
///////////////////////////////////////////////////
public function store(Request $request)
{
    try {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            // 'product_name_ar' => 'required|string|max:50',
            // 'product_name_cku' => 'required|string|max:50',
            'description' => 'bail|required|string', 
            // 'description_ar' => 'bail|required|string|max:500',
            // 'description_cku' => 'bail|required|string|max:500',
            'brand_id' => 'required|exists:brands,id',
            'categories' => 'required|integer',
            'quantity' => 'required|integer|min:0|max:999999',
            'base_price' => 'required|numeric|min:0.01|max:99999999.99',
            'discount' => 'required|numeric|min:0|max:100',
            'subcategories' => 'nullable|integer',
            'variant_colors' => 'required|array',
            'variant_colors.*' => 'exists:colors,id',
            'variant_sizes' => 'required|array',
            'variant_sizes.*' => 'exists:sizes,id',
            'variant_prices' => 'required|array',
        //    'variant_prices.*' => 'numeric|min:1',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif', // Validate images
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
if ($request->hasFile('images')) {
    $uploadedImages = [];
    foreach ($request->file('images') as $file) {
        $uploadedImages[] = base64_encode(file_get_contents($file));
    }
    session()->flash('old_images', $uploadedImages);
}
        // Retrieve validated data
        $validated = $validator->validated();

        // Generate SKU
        $sku = $this->generateSKU($validated['product_name'], $validated['categories'], $validated['brand_id']);

        // Create product
        $product = Product::create([
            'product_name' => $validated['product_name'],
            // 'product_name_ar' => $validated['product_name_ar'],
            // 'product_name_cku' => $validated['product_name_cku'],
            'description' => $validated['description'],
            // 'description_ar' => $validated['description_ar'],
            // 'description_cku' => $validated['description_cku'],
            'base_price' => $validated['base_price'],
            'brand_id' => $validated['brand_id'],
            'sku' => $sku,
            'category_id' => $validated['categories'],
            'sub_category_id' => $validated['subcategories'] ?? null,
            'quantity' => $validated['quantity'],
            'discount' => $validated['discount'],
           'language' => $request->language,
            'type' =>  $request->type,
              'product_type' =>  $request->product_type,
        ]);

      if ($request->hasFile('images')) {
    $uploadedImages = [];
    foreach ($request->file('images') as $file) {
        $uploadedImages[] = base64_encode(file_get_contents($file));
    }
    session()->flash('old_images', $uploadedImages);  // Save image base64 in session for page reload
}

        // Store images if present
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $product->images()->create(['image_url' => $path]);
            }
        }

        // Handle variants
        $variants = [];
        foreach ($validated['variant_colors'] as $index => $colorId) {
            // Check if the price is provided
            $price = $validated['variant_prices'][$index] ?? null;
            if (!$price || empty($price)) {
                return redirect()->route('admin.product.create')
                    ->with('error', 'Please enter a valid price for each variant.')
                    ->withInput();
            }

            $variants[] = [
                'color' => $colorId,
                'size' => $validated['variant_sizes'][$index],
                'price' => $price,
                'product_id' => $product->product_id, // Use `$product->id` to reference the product
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert variants
        ProductVariant::insert($variants);

        return redirect()->route('admin.product')->with('success', 'Product created successfully.');

    } catch (ValidationException $e) {
        dd($e);
        \Log::error('Validation error: ' . $e->getMessage());
        return redirect()->route('admin.product.create')->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
           dd($e);
        \Log::error('Error creating product: ' . $e->getMessage());
        return redirect()->route('admin.product.create')->with('error', 'Failed to create Product.');
    }
}



/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
public function destroy($id)
{
    // Decode the base64-encoded ID
    $decodedId = base64_decode($id);

    try {
        // Fetch the product by its ID
        $product = Product::where('product_id', $decodedId)->first();

        if (!$product) {
            return redirect()->route('admin.product')->with('error', 'Product not found.');
        }

        // Start transaction for safe deletion
        DB::beginTransaction();

        // Delete associated product images
        $product->images()->delete();

        // Delete associated product variants
        $product->variants()->delete();

        // Delete associated product return orders
        $product->productReturnOrders()->delete();

        // Delete product from cart
        Cart::where('product_sku', $product->sku)->delete();

        // Delete product from cart order summaries
        //CartOrderSummary::where('product_sku', $product->sku)->delete();

        // Delete product from wishlists
        Wishlist::where('product_id', $product->product_id)->delete();

        // Delete product ratings
        $product->productRatings()->delete();

        // Finally, delete the product itself
        $product->delete();

        // Commit the transaction
        DB::commit();

        return redirect()->route('admin.product')->with('success', 'Product and its associated data deleted successfully.');
    } catch (\Exception $e) {
        dd($e);
        // Rollback transaction in case of an error
        DB::rollBack();

        // Log the error and return with a failure message
        Log::error('Error deleting product: ' . $e->getMessage());
        return redirect()->route('admin.product')->with('error', 'Failed to delete product.');
    }
}


/////////////////////////////////////////////////////////////////
public function removeImage(Request $request)
{
    $imageId = $request->input('image_id');
    // Find the image record by its ID
    $image = ProductImage::where('image_id', $imageId)->first(); // Assuming 'id' is the primary key in ProductImage
    if ($image) {
        // Delete the image file from the storage (if it exists)
        if (Storage::exists($image->image_url)) {
            Storage::delete($image->image_url);
        }
        // Delete the image record from the database
        $image->delete();
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false, 'message' => 'Image not found.']);
}
////////////////////////////////////////////////////////
public function show($productId)
{
    $decodedId = base64_decode($productId);
    $product = Product::where('product_id', $decodedId)->first();
    $productImages = ProductImage::where('product_id', $decodedId)->get();
    $productVariants = ProductVariant::where('product_id', $decodedId)->get();
    foreach ($productVariants as $variant) {
        $color = Color::where('id', $variant->color)->first();
        $size = Size::where('id', $variant->size)->first();
        $variant->color_name = $color ? $color->name : 'N/A';
        $variant->size_name = $size ? $size->name : 'N/A';  
    }
    return view('admin.product.view', compact('product', 'productImages', 'productVariants'));
}
////////////////////
public function getSubcategories(Request $request)
{
    $subcategories = Category::where('category_id', $request->category_id)->get();
    return response()->json($subcategories);
}
/////////////////////////////////////////
function edit($id) {
    $decodedId = base64_decode($id);
    $product = Product::with('images','variants','subCategory')->where('product_id', $decodedId)->first();
    $brands=Brand::where('status','active')->get();
    $categories=Category::where('status',1)->whereNull('category_id')->get();
    $colors=Color::get();
    $sizes=Size::get();
    return view('admin.product.edit', compact('product','brands','categories','colors','sizes'));
}
//////////////////////////////////////////////

public function update(Request $request, $id)
{
    \Log::info('Product ID: ' . $id); // Debugging: Log the ID passed
  $decodedId = base64_decode($id);
    try {
        // Validate the request
       $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:50',
            // 'product_name_ar' => 'required|string|max:50',
            // 'product_name_cku' => 'required|string|max:50',
            'description' => 'required|string',
            // 'description_ar' => 'required|string',
            // 'description_cku' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'categories' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0|max:999999', // Limit quantity to 6 digits
            'base_price' => 'required', // Limit base price to 10 digits, 2 decimal places
            'discount' => 'required|numeric|min:0|max:100',
            'subcategory_id' => 'nullable|exists:categories,id',
            // 'images' => 'nullable|array|max:5',
            // 'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8048',
            // 'variant_colors' => 'required|array',
            // 'variant_colors.*' => 'exists:colors,id',
            // 'variant_sizes' => 'required|array',
            // 'variant_sizes.*' => 'exists:sizes,id',
            // 'variant_prices' => 'required|array',
            // 'variant_prices.*' => ['required', 'numeric', 'min:1', 'max:999999.99', 'regex:/^\d{0,6}(\.\d{1,2})?$/'],
        ]);
        // dd($request->all(), $request->file('images'));
       // dd($validator);
         if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
        // Find the product to update
        $product = Product::findOrFail($decodedId);

        // If $product is null, return an error response or handle it accordingly
        if (!$product) {
            return redirect()->route('admin.product.index')->with('error', 'Product not found');
        }

        // Generate SKU and update the product
        // $sku = $this->generateSKU($validated['product_name'], $validated['categories'], $validated['brand_id']);
        
        // Update product details
        $product->update([
            'product_name' => $request->product_name,
            'product_name_ar' => $request->product_name_ar,
            'product_name_cku' => $request->product_name_cku,
            'description' => $request->description,
            'description_ar' => $request->description_ar,
            'description_cku' => $request->description_cku,
            'base_price' => $request->base_price,
            'brand_id' => $request->brand_id,
            //  'sku' => $sku,
            'category_id' => $request->categories,
            'sub_category_id' => $request->subcategory_id,
            'quantity' => $request->quantity,
            'discount' => $request->discount,
            'status' => $request->status,
             'language' => $request->language,
                'type' => $request->type,
                'product_type' =>  $request->product_type,
        ]);
        
        // Handle images update
         if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $path = $image->store('product_images', 'public');
                $product->images()->create(['image_url' => $path]);
            }
        }
        // Handle variants update
        // First, delete existing variants
        $product->variants()->delete();

        // Prepare new variants
   

// Insert the new variants


        // Redirect with success message
        return redirect()->route('admin.product')->with('success', 'Product updated successfully.');
        
    } catch (\Exception $e) {
        dd($e);
        // Log the error message
        \Log::error('Error updating product: ' . $e->getMessage());

        // Redirect with error message
        return redirect()->route('admin.product.edit', $decodedId)->with('error', 'Failed to update Product.');
    }
}
// Add this method in your ProductController
private function generateSKU($productName, $categoryId, $brandId)
{
    // Create a basic SKU pattern (you can adjust this logic as per your needs)
    $productNamePart = substr(strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $productName)), 0, 3); // Take the first 3 letters of the product name
    $categoryPart = substr($categoryId, -2); // Get the last 2 digits of the category ID
    $brandPart = substr($brandId, -2); // Get the last 2 digits of the brand ID
    $randomPart =  Str::random(4); // Generate a random 4 character string
    // Combine the parts to form a unique SKU
    $sku = $productNamePart . $categoryPart . $brandPart . $randomPart;
    return $sku;
}
/////////////////////////////////////////////
}

