<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartOrderSummary;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Notification;
use App\Services\FirebaseService;
use PDF;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{

 protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
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
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Return the view with filtered data
    return view('admin.order.index', compact('CartOrderSummary'));
}
    /////////////////////////////////////////////
    public function view($id)   
    {
        $decodedId = base64_decode($id);
        $CartOrderSummary = CartOrderSummary::with('user','cartItems','cartItems.product','cartItems.product.images')->find($decodedId);
        return view('admin.order.view', compact('CartOrderSummary'));
    }
    ///////////////////////////////////////////////////////
    public function edit($id)
    {
        $decodedId = base64_decode($id);
        $CartOrderSummary = CartOrderSummary::with('user')->find($decodedId);
        return view('admin.order.edit', compact('CartOrderSummary'));
    }
    //////////////////////////////////
   public function update(Request $request, $id)
{
    $locale=$request->header('Accept-Language', 'en');
    // dd($locale);die;
    $decodedId = base64_decode($id);
    // Find the order
    $CartOrderSummary = CartOrderSummary::findOrFail($decodedId);
    // Get the new and previous order status
    $newStatus = $request->input('order_status');
    $previousStatus = $CartOrderSummary->order_status;
    // Update the order status
    $CartOrderSummary->order_status = $newStatus;
    $CartOrderSummary->save();
    // If the order is cancelled or returned, restore product quantities
   
    if (in_array($newStatus, ['cancelled', 'return']) && !in_array($previousStatus, ['cancelled', 'return'])) {
        foreach ($CartOrderSummary->cartItems as $item) {
            $product = $item->product;
            if ($product) {
                $product->quantity += $item->quantity;
                $product->save();
            }
        }
    }
    // Define notification messages for each status
    // Define localized notification messages
$notificationMessages = [
    'booked' => [
        'en'  => "Your order #{$CartOrderSummary->order_id} has been booked.",
        'ar'  => "تم حجز طلبك رقم #{$CartOrderSummary->order_id}.",
        'cku' => "فەرمانی تۆ #{$CartOrderSummary->order_id} تۆمار کرا."
    ],
    'shipped' => [
        'en'  => "Your order #{$CartOrderSummary->order_id} has been shipped.",
        'ar'  => "تم شحن طلبك رقم #{$CartOrderSummary->order_id}.",
        'cku' => "فەرمانی تۆ #{$CartOrderSummary->order_id} نێردرا."
    ],
    'delivered' => [
        'en'  => "Your order #{$CartOrderSummary->order_id} has been delivered.",
        'ar'  => "تم تسليم طلبك رقم #{$CartOrderSummary->order_id}.",
        'cku' => "فەرمانی تۆ #{$CartOrderSummary->order_id} گەشتووە."
    ],
    'cancelled' => [
        'en'  => "Your order #{$CartOrderSummary->order_id} has been cancelled.",
        'ar'  => "تم إلغاء طلبك رقم #{$CartOrderSummary->order_id}.",
        'cku' => "فەرمانی تۆ #{$CartOrderSummary->order_id} هەڵوەشایەوە."
    ],
    'return' => [
        'en'  => "Your order #{$CartOrderSummary->order_id} has been returned.",
        'ar'  => "تم إرجاع طلبك رقم #{$CartOrderSummary->order_id}.",
        'cku' => "فەرمانی تۆ #{$CartOrderSummary->order_id} گەڕاوەتەوە."
    ],
    'completed' => [
        'en'  => "Your order #{$CartOrderSummary->order_id} is completed. Please rate and review the products you purchased.",
        'ar'  => "اكتمل طلبك رقم #{$CartOrderSummary->order_id}. يرجى تقييم ومراجعة المنتجات التي اشتريتها.",
        'cku' => "فەرمانی تۆ #{$CartOrderSummary->order_id} تەواو بوو. تکایه‌ هەڵسەنگاندن و بازدان بنوسە."
    ]
];

// Get user language or default to English
$lang = $CartOrderSummary->user->lang ?? 'en';
//$message = $notificationMessages[$newStatus][$lang] ?? $notificationMessages[$newStatus]['en'];
if (!isset($notificationMessages[$newStatus])) {
    $message = "Your order status has been updated.";
} else {
    $message = $notificationMessages[$newStatus][$lang] ?? $notificationMessages[$newStatus]['en'];
}
// Fetch product details
$cartItem = $CartOrderSummary->cartItems->first();
$product = $cartItem ? Product::where('sku', $cartItem->product_sku)->first() : null;

// Create notification in the database
Notification::create([
    'user_id'   => $CartOrderSummary->user->id,
    'type'      => 'order',
    'title'     => [
        'en'  => "Order " . ucfirst($newStatus),
        'ar'  => "الطلب " . ucfirst($newStatus),
        'cku' => "داواکردن " . ucfirst($newStatus)
    ][$lang],
    'message'   => $message,
    'order_id'  => $CartOrderSummary->id,
    'product_id'=> optional($product)->product_id,
    'status'    => 'unread',
]);

// Send Firebase push notification
if ($CartOrderSummary->user->fcm_token) {
    $payload = [
        'order_id'     => $CartOrderSummary->order_id,
        'product_id'   => optional($product)->product_id,
        'user_id'      => $CartOrderSummary->user->id,
        'status'       => $newStatus,
        'type'         => 'order',
        'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
    ];

    $this->firebaseService->sendNotification(
        $CartOrderSummary->user->fcm_token,
        [
            'en'  => "Order " . ucfirst($newStatus),
            'ar'  => "الطلب " . ucfirst($newStatus),
            'cku' => "داواکردن " . ucfirst($newStatus)
        ][$lang],
        $message,
        $payload
    );
}

    // **Send rating & review notification only once after order completion**
    if ($newStatus === 'completed') {
        Notification::create([
            'user_id' => $CartOrderSummary->user->id,
            'type' => 'product',
            'title' => "Review Your Purchase",
            'message' => "Your order #{$CartOrderSummary->order_id} is complete. Please review your purchased products.",
            'order_id' => $CartOrderSummary->id,
            'product_id' => optional($product)->product_id, // Use optional() to prevent errors
            'status' => 'unread',
        ]);

        if ($CartOrderSummary->user->fcm_token) {
            $payload = [
        'order_id'     => $CartOrderSummary->order_id,
        'product_id'   => optional($product)->product_id,
        'user_id'      => $CartOrderSummary->user->id,
        'status'       => $newStatus,
        'type'         => 'product',
        'click_action' => 'FLUTTER_NOTIFICATION_CLICK' // Used for handling taps in the app
    ];
            $this->firebaseService->sendNotification(
                $CartOrderSummary->user->fcm_token,
                "Review Your Purchase",
                "Your order #{$CartOrderSummary->order_id} is complete. Please review your purchased products.",
                $payload
            );
        }
    }
    return redirect()->route('admin.order')->with('success', 'Order status updated successfully.');
}
//////////////////////////////


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

}
