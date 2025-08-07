<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductRating;
use App\Models\Product;
use App\Models\User;

class RatingController extends Controller
{
    public function index(Request $request)
{
    // Set pagination page count (you can adjust the value as needed)
    $pageCount = config('app.admin_record_per_page', 10);
    
    // Get current page or default to 1 if not provided
    $currentPage = $request->input('page', 1);
    
    // Start the query for ProductRating
    $query = ProductRating::with('product')
    ->join('products', 'products.product_id', '=', 'product_ratings.product_id') // Join with the products table
    ->orderBy('product_ratings.id', 'DESC');

if ($search = $request->input('search')) {
    $query->where(function($q) use ($search) {
        $q->where('products.product_name', 'like', '%' . $search . '%')  // Searching by product name
          ->orWhere('product_ratings.rating', 'like', '%' . $search . '%')
          ->orWhere('product_ratings.review', 'like', '%' . $search . '%');
    });
}

    // Calculate the starting count for pagination display
    $count = ($currentPage - 1) * $pageCount + 1;
    
    // Fetch paginated product ratings
    $productRatings = $query->paginate($pageCount);

    // Return view with data
    return view('admin.rating.index', compact('productRatings', 'count'));
}
///////////////////////////////
public function view($id)
{
    $id = base64_decode($id);
    $rating = ProductRating::with('product','user','product.images')->find($id);
    return view('admin.rating.view', compact('rating'));
}
public function delete($id)
{
    $id = base64_decode($id);
    $rating = ProductRating::find($id);
    $rating->delete();
    return redirect()->route('admin.rating')->with('success', 'Rating deleted successfully');
}
/////////////////////////
public function edit($id)
{
    $id = base64_decode($id);
    $rating = ProductRating::with('product','user','product.images')->find($id);
    return view('admin.rating.edit', compact('rating'));
}
//////////////////////////////////
public function update(Request $request, $id)
{
    try {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5', 
            'review' => 'required|string|max:500|regex:/\S/', 
        ]);
       
        $rating = ProductRating::find($id); 
       /// validate error message in input tag
        
        if (!$rating) {
           
            return redirect()->route('admin.rating')->with('error', 'Rating not found.');
        }

        // Update the rating with the request data
        $rating->update($request->all());
        
        // Redirect with success message
        return redirect()->route('admin.rating')->with('success', 'Rating updated successfully');
    } catch (\Exception $e) {
        dd($e);
        // Log the exception message for debugging purposes (optional)
        \Log::error("Error updating product rating: " . $e->getMessage());

        // Redirect back with error message
        return redirect()->route('admin.rating')->with('error', 'There was an error updating the rating. Please try again later.');
    }
}
/////////////////////////////////////////////
}