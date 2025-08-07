<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProductReturnOrder;
use App\Models\ReturnReason;
use App\Models\ProductRefund;


class ReturnController extends Controller
{
    public function index(Request $request)
{
    // Start building the query
    $query = ProductReturnOrder::with('product', 'order', 'reason', 'user', 'product.images', 'refund')
        ->orderBy('id', 'desc');

    // Check if there's a search query and apply it
    if ($request->has('search') && $request->input('search') != '') {
        $searchTerm = $request->input('search');
        
        // Add conditions for searching by product name and return status
        $query->whereHas('product', function ($query) use ($searchTerm) {
            $query->where('product_name', 'like', '%' . $searchTerm . '%');
        })
        ->orWhereHas('user', function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        })
        ->orWhere('return_status', 'like', '%' . $searchTerm . '%');
    }

    // Paginate the results (10 per page for example)
    $returnOrders = $query->paginate(10);
    // dd($returnOrders);die;
    // Return the view with the paginated results and the search term
    return view('admin.return.index', compact('returnOrders'));
}

public function view($id)
{
    $id = base64_decode($id);
    // Find the return order by ID
    $returnOrder = ProductReturnOrder::with('product', 'order', 'reason', 'user', 'product.images', 'refund')->findOrFail($id);

    // Return the view with the return order data
    return view('admin.return.view', compact('returnOrder'));
}
/// updateStatus

public function updateStatus(Request $request, $id)
{
    $returnOrder = ProductReturnOrder::findOrFail($id); 
    $returnOrder->update([
        'return_status' => $request->input('return_status'),
    ]);
    return redirect()->back()->with('success', 'Return status updated successfully');   

}
//////////////////////////refund     //////////////////
public function create($id, Request $request)
{
    $request->validate([
        'refund_amount' => 'required|numeric',
        'refund_comments' => 'required|string',
    ]);

    // Find the return order
    $returnOrder = ProductReturnOrder::findOrFail($id);
 
    // Check if a refund already exists
    $existingRefund = ProductRefund::where('product_return_order_id', $id)->first();
    if ($existingRefund) {
        return redirect()->back()->with('error', 'Refund already exists for this return order.');
    }

    // Create the refund
    $refund = new ProductRefund();
    $refund->product_return_order_id = $returnOrder->id;
    $refund->refund_status = 'pending'; // Default status
    $refund->refund_amount = $request->refund_amount;
    $refund->refund_comments = $request->refund_comments;
    $refund->save();

    return redirect()->back()->with('success', 'Refund initiated successfully.');
}


}