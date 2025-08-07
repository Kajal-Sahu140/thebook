<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductOffer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class ProductofferController extends Controller
{
        public function index(Request $request)
{
    $pageCount = config('app.admin_record_per_page', 10); // Number of records per page
    $currentPage = $request->input('page', 1); // Current page number

    // Base query with relationship and ordering
    $query = ProductOffer::with('product')->orderBy('id', 'DESC');

    // Search filter
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('offer_title', 'like', '%' . $search . '%') // Search by offer title
              ->orWhereHas('product', function ($q) use ($search) { // Search by product name
                  $q->where('product_name', 'like', '%' . $search . '%');
              });
        });
    }

    // Calculate starting count for serial numbers
    $count = ($currentPage - 1) * $pageCount + 1;

    try {
        // Paginate the results
        $product_offers = $query->paginate($pageCount);
    } catch (\Exception $e) {
        // Log any errors that occur
        Log::error('Error retrieving product offers: ' . $e->getMessage());
        return redirect()->route('admin.productoffer.index')->with('error', 'Failed to retrieve product offers.');
    }

    // Return view with data
    return view('admin.productoffer.index', compact('product_offers', 'count'));
}

         ///////////////////////////////////////////////////////
         public function create()
         {
            $products=Product::get();
            return view('admin.productoffer.create', compact('products'));
         }
         ////////////////////////////////////////////////////////
         public function store(Request $request)
            {
            $validator = Validator::make($request->all(), [
                    'offer_title' => 'required|max:50',
                    'product_id' => 'required|exists:products,product_id',
                    'offer_type' => 'required|in:percentage,fixed',
                    'discount_value' => 'required|numeric|between:0,99',
                    'description' => 'required|max:150',
                    'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                    'status' => 'required|in:active,inactive',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after:start_date',
                ]);
                
                if ($validator->fails()) {
                    //dd($validator->errors());
                    return back()->withErrors($validator)->withInput();
                }

                try {
                    // Prepare data for saving
                    $data = $request->all();
                    if ($request->hasFile('image')) {
                        $imagePath = $request->file('image')->store('product_offer', 'public');
                        $data['image'] = $imagePath; // Save the image path
                    } else {
                        $data['image'] = null; // Set image as null if not provided
                    }
                    ProductOffer::create($data);
                    // Redirect to the product offer list page with a success message
                    return redirect()->route('admin.productoffer')->with('success', 'Product offer created successfully.');

                } catch (\Exception $e) {
                    // Log the error
                    \Log::error('Error creating product offer: ' . $e->getMessage());

                    // Redirect back with an error message
                    return back()->withInput()->with('error', 'There was an issue creating the product offer. Please try again.');
                }
            }


//////////////////////////////////////////////////////////////////////////////////////
public function view($id)
{
    $offer=Productoffer::find($id);
    return view('admin.productoffer.view', compact('offer'));
}
//////////////////////////////////////////////////////
 public function destroy($id)
    {
        $decodedId = base64_decode($id);
        $blog = Productoffer::findOrFail($decodedId);
        if ($blog->image && Storage::exists($blog->image)) {
            Storage::delete($blog->image);
        }
        $blog->delete();
        return redirect()->route('admin.productoffer')->with('success', 'Product offer deleted successfully.');
    }
/////////////////////////////////////////////
function edit($id)
{
    $decodedId = base64_decode($id);
    $offer = ProductOffer::find($decodedId);
    if (!$offer) {
        return redirect()->route('admin.productoffer')->with('error', 'Product offer not found.');
    }
    $products = Product::all();
    return view('admin.productoffer.edit', compact('offer', 'products'));
}
//////////////////////////////////
public function update(Request $request, $id)
{
    $offer = ProductOffer::findOrFail($id);

    $request->validate([
        'offer_title' => 'required|max:100',
        'product_id' => 'required|exists:products,product_id', // Validate using the correct column
        'offer_type' => 'required|in:percentage,fixed',
        'discount_value' => 'required|numeric|between:0,99.99',
        'description' => 'required|max:500',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'status' => 'required|in:active,inactive',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
    ]);

    try {
        $data = $request->except(['_token', '_method', 'image']);

        if ($request->hasFile('image')) {
            if ($offer->image && Storage::exists($offer->image)) {
                Storage::delete($offer->image);
            }
            $data['image'] = $request->file('image')->store('uploads/product_offers', 'public');
        }

        $offer->update($data);

        return redirect()->route('admin.productoffer')->with('success', 'Product offer updated successfully.');
    } catch (\Exception $e) {
        dd($e);
        Log::error('Error updating product offer: ' . $e->getMessage());
        return back()->with('error', 'There was an issue updating the product offer.')->withInput();
    }
}

///////////////////////////////////////////////////////
}
