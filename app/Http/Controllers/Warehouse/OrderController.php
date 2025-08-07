<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartOrderSummary;
use App\Models\Product;
use App\Models\Cart;
use PDF;

class OrderController extends Controller
{
   public function index(Request $request) {
    // Retrieve filters from the request
    $order_id = $request->input('order_id');
    $order_status = $request->input('order_status');

    // Build the query with optional filters
    $CartOrderSummary = CartOrderSummary::with('user')
        ->when($order_id, function ($query, $order_id) {
            return $query->where('order_id', 'LIKE', "%{$order_id}%");
        })
        ->when($order_status, function ($query, $order_status) {
            return $query->where('order_status', $order_status);
        })->orderBy('created_at', 'desc')
        ->paginate(10);

    // Return the view with filtered data
    return view('warehouse.order.index', compact('CartOrderSummary'));
}

    /////////////////////////////////////////////
    public function show($id)   
    {
        $decodedId = base64_decode($id);
        $CartOrderSummary = CartOrderSummary::with('user')->find($decodedId);
        return view('warehouse.order.view', compact('CartOrderSummary'));
    }
    ///////////////////////////////////////////////////////
    public function edit($id)
    {
        $decodedId = base64_decode($id);
        $CartOrderSummary = CartOrderSummary::with('user')->find($decodedId);
        return view('warehouse.order.edit', compact('CartOrderSummary'));
    }
    //////////////////////////////////
    public function update(Request $request, $id)
{
    $decodedId = base64_decode($id);

    // Find the order
    $CartOrderSummary = CartOrderSummary::findOrFail($decodedId);
    //dd($request->all());
    // Update only the order_status field
    $CartOrderSummary->order_status = $request->input('order_status');
    $CartOrderSummary->save();

    // Redirect back with a success message
    return redirect()->route('warehouse.order')->with('success', 'Order status updated successfully.');
}
public function ordercancel(Request $request, $id)
{
    try {
        // dd($id);
        // Find the cart item by ID
        $cartItem = Cart::findOrFail($id);

        // Check if the cart item is already cancelled
        if ($cartItem->order_status === 'cancelled') {
            return redirect()->back()->with('error', 'This item is already cancelled.');
        }

        // Update the cart item status to 'cancelled'
        $cartItem->update(['order_status' => 'cancelled']);

        // Check if all cart items in the order are cancelled
        $order = CartOrderSummary::find($cartItem->order_id);
        if ($order) {
            $remainingItems = $order->cartItems()->where('order_status', '!=', 'cancelled')->count();
            if ($remainingItems === 0) {
                // If all items are cancelled, update the order status
                $order->update(['order_status' => 'Cancelled']);
            }
        }

        return redirect()->back()->with('success', 'Item cancelled successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to cancel item: ' . $e->getMessage());
    }
}


public function downloadInvoice($order_id, $product_id)
    {
        try {
            // Fetch product details
            $product = Product::findOrFail($product_id);

            // Fetch the order details for admin
            $order = CartOrderSummary::with(['cartItems.product'])
                ->where('id', $order_id)
                ->whereHas('cartItems', function ($query) use ($product) {
                    $query->where('product_sku', $product->sku);
                })
                ->firstOrFail();

            // Define the data to be passed to the PDF view
            $data = [
                'order' => $order,
                'ordered_date' => $order->created_at->format('jS M Y'),
                'delivered_date' => $order->delivered_at ? $order->delivered_at->format('jS M Y') : 'Pending',
                'shipping_address' => $order->shipping_address ?? 'No shipping address available',
            ];

            // Generate the PDF using the view
            $pdf = PDF::loadView('website.invoice', $data);

            // Download the PDF file
            return $pdf->download('invoice_order_' . $order_id . '.pdf');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Invoice Download Error: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Unable to generate the invoice. Please try again later.');
        }
    }

}