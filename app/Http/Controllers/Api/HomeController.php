<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Profile;
use App\Models\ContactUs;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\UserAddress;
use App\Models\CartOrderSummary;
use App\Models\Wishlist;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\Transaction;
use App\Models\ProductReturnOrder;
use App\Models\ProductRating;
use App\Models\ReturnReason;
use App\Models\Blog;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\Product;
use App\Models\Banner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use PDF;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Str;
use App\Services\FirebaseService;
use App\Services\TwilioService;
use Twilio\Rest\Client;
use App\Services\FibPaymentService;
use App\Services\FedExService;

class HomeController extends Controller
{
    protected $firebaseService;
    protected $fibPaymentService;
   protected $fedExService;

    public function __construct(FirebaseService $firebaseService, FibPaymentService $fibPaymentService,FedExService $fedExService)
    {
      
        $this->firebaseService = $firebaseService;
        $this->fibPaymentService = $fibPaymentService;
        $this->fedExService = $fedExService;
    }
    ///////////////////////////home page api/////////////////////////////
public function payment(Request $request)
    {
        $userId = Auth::id();

        // Fetch valid cart items
        $cartItems = Cart::whereHas('product', function ($query) {
                $query->where('status', 1); // Only fetch active products
            })
            ->with('product')
            ->where('user_id', $userId)
            ->whereNull('order_id')
            ->where('orderplace', 0)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty or contains inactive products.'], 400);
        }

        // Calculate order totals
        $subtotalPrice = $cartItems->sum('total_price');
        $totalDiscount = $cartItems->sum(fn($item) => optional($item->product)->base_price * (optional($item->product)->discount / 100) * $item->quantity ?? 0);
        $couponDiscount = $cartItems->sum(function ($item) {
            if ($item->coupon_code && $item->product) {
                $coupon = Coupon::where('coupon_code', $item->coupon_code)->first();
                if ($coupon) {
                    $discountAmount = $item->product->base_price * ($coupon->discount_value / 100) * $item->quantity;
                    return min($discountAmount, $coupon->max_discount_amount);
                }
            }
            return 0;
        });

        $deliveryFee = count($cartItems) * 50;
        $grandTotal = $subtotalPrice - $totalDiscount - $couponDiscount + $deliveryFee;

        // Call FibPaymentService to initiate payment
        $paymentResponse = $this->fibPaymentService->initiatePayment(
            (int) $grandTotal,
            'IQD',
            "https://your-callback-url.com",
            'Payment for Order'
        );

        if (isset($paymentResponse['error'])) {
            Log::error('FIB Payment Error:', ['message' => $paymentResponse['message']]);
            return response()->json([
                'success' => false,
                'message' => 'Payment request failed',
                'error' => $paymentResponse['message']
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment initiated successfully',
            'amount' => $grandTotal,
            'client_id'=>'baby-center',
            'client_secret'=>'77c2f6fb-f1d5-4872-81e6-703176164e91',
            'paymentData' => $paymentResponse,
            // 'qrCode' => $paymentResponse['qrCode'] ?? '',
            // 'paymentId' => $paymentResponse['paymentId']
        ]);
    }

    /**
     * Check Payment Status API
     */
    public function checkPaymentStatus($transactionId)
    {
        try {
            $paymentResponse = $this->fibPaymentService->checkPaymentStatus($transactionId);

            if (!is_array($paymentResponse) || !isset($paymentResponse['status'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment response format'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'status' => $paymentResponse['status'],
                'message' => 'Payment status retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to get payment status',
                'message' => $e->getMessage()
            ], 500);
        }
    }

public function index(Request $request)
{
    try {
        $excludedIds = [68, 74, 80];
        $bearerToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($bearerToken);
        $user_id = null;

        if ($token) {
            $user = $token->tokenable;
            $user_id = $user->id;
        }

        $locale = $request->header('Accept-Language', 'en');
        $productsQuery = Product::with('images', 'category')->where('status', 1)
            ->whereHas('category', function ($query) {
                $query->where('status', 1);
            });
        if($locale == 'en'){
            $categories = Category::whereNull('category_id')
            ->where('status', 1)
            ->whereNotIn('id', $excludedIds)
            ->get(['id', "name", 'image', 'description']);
           $brands = Brand::where('status', 'active')->get(['id', "name", "image", 'description']);
            $letestproduct = (clone $productsQuery)->limit(5)->orderBy('product_id', 'DESC')->get();
        $bestseller = (clone $productsQuery)->limit(5)->orderBy('product_id', 'DESC')->get();
        $amazingproduct = (clone $productsQuery)->limit(5)->orderBy('product_id', 'ASC')->get();
        }
        else{
            $categories = Category::whereNull('category_id')
            ->where('status', 1)
            ->whereNotIn('id', $excludedIds)
            ->get(['id', "name_{$locale} as name", "image_{$locale} as image", 'description']);
            $brands = Brand::where('status', 'active')->get(['id', "name_{$locale} as name", "image_{$locale} as image", 'description']);
            $letestproduct = (clone $productsQuery)->limit(5)->orderBy('product_id', 'DESC')->get(['*', "product_name_{$locale} as product_name"]);
        $bestseller = (clone $productsQuery)->limit(5)->orderBy('product_id', 'DESC')->get(['*', "product_name_{$locale} as product_name"]);
        $amazingproduct = (clone $productsQuery)->limit(5)->orderBy('product_id', 'ASC')->get(['*', "product_name_{$locale} as product_name"]);
        }
        if ($locale == 'en')
        {
        $banners = Banner::where('status', 'active')
            ->where('position', 'homepage')
            ->with(['category:id,name'])
            ->get([
                'id',
                'category_id',
                'title',
                'description',
                'web_banner_image',
                'app_banner_image',
                'position',
                'discount',
                'banner_link',
                'click_status'
            ]);

        }
        else{
           $banners = Banner::where('status', 'active')
            ->where('position', 'homepage')
            ->with(["category:id,name_{$locale} as name"])
            ->get([
                'id',
                'category_id',
                'title',
                'description',
                'web_banner_image',
                'app_banner_image',
                'position',
                'discount',
                'banner_link',
                'click_status'
            ]); 
        }
        if (!empty($user_id)) {
            foreach ([$letestproduct, $bestseller, $amazingproduct] as $productList) {
                foreach ($productList as $product) {
                    $product->is_wishlisted = $product->wishlists()->where('user_id', $user_id)->exists();
                }
            }
        }

        $noticationcount = !empty($user_id) ? Notification::where('status', 'unread')->where('user_id', $user_id)->count() : 0;

        $bannerIds = [8 => 'delic', 9 => 'newarrival', 10 => 'mater', 11 => 'babe_care', 12 => 'magical', 13 => 'perfact'];
        $bannersData = [];
        foreach ($bannerIds as $id => $key) {
            if($locale == 'en'){
                $bannersData[$key] = Banner::with('category:id,name')->where('status', 'active')->where('id', $id)->first();
            }
            else{
              $bannersData[$key] = Banner::with([
    'category' => function ($query) use ($locale) {
        $query->select('id', "name_{$locale} as name");
    }
])->where('status', 'active')->where('id', $id)->first();

            }
            
        }

        if ($locale == 'en') {
    $categoriesData = [
        'bath' => Category::where('status', '1')->where('category_id', '68')->orderBy('id', 'DESC')->get(),
        'maternity' => Category::where('status', '1')->where('category_id', '74')->orderBy('id', 'DESC')->get(),
        'dalicate' => Category::where('status', '1')->where('category_id', '80')->orderBy('id', 'DESC')->get(),
    ];
} else {
    $categoriesData = [
        'bath' => Category::where('status', '1')->where('category_id', '68')->orderBy('id', 'DESC')->get(['*', "name_{$locale} as name", "image_{$locale} as image"]),
        'maternity' => Category::where('status', '1')->where('category_id', '74')->orderBy('id', 'DESC')->get(['*', "name_{$locale} as name", "image_{$locale} as image"]),
        'dalicate' => Category::where('status', '1')->where('category_id', '80')->orderBy('id', 'DESC')->get(['*', "name_{$locale} as name", "image_{$locale} as image"]),
    ];
}
        $name = $user_id ? User::where('id', $user_id)->value('name') : null;

        return response()->json([
            'success' => true,
            'data' => array_merge([
                'name' => $name ?? '',
                'categories' => $categories,
                'banners' => $banners,
                'brands' => $brands,
                'letestproduct' => $letestproduct,
                'amazingproduct' => $amazingproduct,
                'bestseller' => $bestseller,
                'noticationcount' => $noticationcount
            ], $bannersData, $categoriesData),
            'message' => __('messages.data_success'),
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error retrieving data: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => __('messages.data_failed'),
            'error' => $e->getMessage(),
        ], 500);
    }
}


    ////////////////////category list api ////////////////////////
public function brandProductDetail($id, Request $request)
{
    try {
         $locale = $request->header('Accept-Language', 'en');
        // Find the brand by ID
        if($locale=='en')
        {
            $brand = Brand::find($id);
        }
        else
        {
            $brand = Brand::select('*', "name_{$locale} as name","image_{$locale} as image")->find($id);
        }
       
        
        $bearerToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($bearerToken);
        $user_id = null;
        if ($token) {
            $user = $token->tokenable;
            $user_id = $user->id;
        }

        // Get subcategory ID from the request (if provided)
        $cat_id = $request->input('subcategory_id');
        $category = null;
        if (!empty($cat_id)) {
            $category = Category::find($cat_id);
        }
        // dd($request->all());
        // Get available sizes and colors
        $size = Size::get();
        $color = [];
        $ProductVariant = ProductVariant::get();
        if ($ProductVariant->isNotEmpty()) {
            foreach ($ProductVariant as $variant) {
                $color[] = $variant->color;   
            }
            $uniqueColorIds = array_unique($color);
            $color = Color::whereIn('id', $uniqueColorIds)->get();
        }
        // Calculate min and max price using product base prices only
        $min_price = Product::where('status', 1)->min('base_price');
        $max_price = Product::where('status', 1)->max('base_price');


        $perPage = $request->input('per_page', 10);
        if($locale=='en'){
            $products = Product::select('*', "product_name as product_name")->with(['images', 'variants', 'category'])
            ->where('brand_id', $id)
            ->where('status', 1);
        }
        else
        {
            $products = Product::select('*', "product_name_{$locale} as product_name")->with(['images', 'variants', 'category'])
            ->where('brand_id', $id)
            ->where('status', 1);
        }
        // Apply subcategory filter if provided
        if (!empty($cat_id)) {
            $products->where('sub_category_id', $cat_id);
        }
        if ($request->has('sizes') && !empty($request->input('sizes')) && !in_array(null, $request->input('sizes'))) {
            $products->whereHas('variants', function ($query) use ($request) {
                $query->whereIn('size', $request->input('sizes'));
            });
        }
        if ($request->has('colors') && !empty($request->input('colors')) && !in_array(null, $request->input('colors'))) {
            $products->whereHas('variants', function ($query) use ($request) {
                $query->whereIn('color', $request->input('colors'));
            });
        }
        if ($request->has('price_min') && !is_null($request->input('price_min'))) {
            $products->where('base_price', '>=', $request->input('price_min'));
        }
        if ($request->has('price_max') && !is_null($request->input('price_max'))) {
            $products->where('base_price', '<=', $request->input('price_max'));
        }
        $products = $products->paginate($perPage);
        if (!empty($user_id)) {
            foreach ($products as $product) {
                $productRating = ProductRating::where('product_id', $product->product_id)->avg('rating');
                $product->rating = number_format($productRating, 1);
                $product->is_wishlisted = $product->wishlists()->where('user_id', $user_id)->exists();
            }
        }
        // if ($products->isEmpty()) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'No products found for the given filters',
        //         'data' => []
        //     ], 404);
        // }
        $filter = [];
        if ($products->currentPage() == 1) {
            if ($category != null) {
                $subcategories = Category::where('category_id', $category->category_id)->get(['id', 'name', 'image']);
            } else {
                $subcategories = Category::whereNotNull('category_id')->get(['id', 'name', 'image']);
            }
            $filter = [
                'subcategories' => $subcategories,
                'size' => $size,
                'color' => $color,
                'min_price' => $min_price,
                'max_price' => $max_price
            ];
        }
        return response()->json([
            'status' => true,
            'brand' => $brand,
            'filter' => $filter,
            'products' => $products,
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error fetching brand product detail: ' . $e->getMessage());
        return response()->json([
            'status' => false,
            'message' =>  __('messages.data_failed'),
            'error_message' => $e->getMessage(),
        ], 500);
    }
}
///////////////////////////////////
 public function categorylist(Request $request, $id)
{
    try {
         $locale = $request->header('Accept-Language', 'en');
        $categoryId = $id;
        $size = Size::get();
        $bearerToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($bearerToken);
        $user_id = null;
        if ($token) {
            $user = $token->tokenable;
            $user_id = $user->id;
        }
        $cat_id = $request->input('subcategory_id');
        $brand = Brand::where('status', 'active')->get();
        $color = [];
        $ProductVariant = ProductVariant::get();
        if ($ProductVariant->isNotEmpty()) {
            foreach ($ProductVariant as $variant) {
                $color[] = $variant->color;
                
            }
            $uniqueColorIds = array_unique($color);
            $color = Color::whereIn('id', $uniqueColorIds)->get();
        }
        // Calculate min and max price from product base_price
        $min_price = Product::where('status', 1)->min('base_price');
        $max_price = Product::where('status', 1)->max('base_price');
        if($locale=='en'){
            $products = Product::with(['brand', 'offers', 'wishlists'])->where('status', 1);
        }
        else{
           $products = Product::select('*', "product_name_{$locale} as product_name")->with(['brand', 'offers', 'wishlists'])->where('status', 1);
        }
        
        if (!empty($cat_id)) {
            $products->where('sub_category_id', $cat_id);
        } elseif($categoryId) {
            $products->where(function ($query) use ($id) {
                $query->whereNotNull('sub_category_id')->where('sub_category_id', $id)
                    ->orWhereNull('sub_category_id')->where('category_id', $id);
            });
        }
        if ($request->has('sizes') && !empty($request->input('sizes')) && !in_array(null, $request->input('sizes'))) {
            $products->whereHas('variants', function ($query) use ($request) {
                $query->whereIn('size', $request->input('sizes'));
            });
        }
         if ($request->has('colors') && !empty($request->input('colors')) && !in_array(null, $request->input('colors'))) {
            $products->whereHas('variants', function ($query) use ($request) {
                $query->whereIn('color', $request->input('colors'));
            });
        }
        if ($request->has('price_min') && !is_null($request->input('price_min'))) {
            $products->where('base_price', '>=', $request->input('price_min'));
        }
        if ($request->has('price_max') && !is_null($request->input('price_max'))) {
            $products->where('base_price', '<=', $request->input('price_max'));
        }
        if ($request->has('brand_id') && !is_null($request->input('brand_id'))) {
            $products->whereIn('brand_id', $request->input('brand_id'));
        }
        $products = $products->paginate(10);
        foreach ($products as $product) {
            $productRating = ProductRating::where('product_id', $product->product_id)->avg('rating');
            $product->rating = number_format($productRating, 1);
            
            if (!empty($user_id)) {
                $product->is_wishlisted = $product->wishlists()->where('user_id', $user_id)->exists();
            }
            $product->images = ProductImage::where('product_id', $product->product_id)->get(['image_id', 'product_id', 'image_url']);
            $product->variants = ProductVariant::with(['color', 'size'])->where('product_id', $product->product_id)->get();
            $product->category_name = optional(Category::find($product->category_id))->name ?? 'N/A';
            $product->brand_name = optional($product->brand)->name ?? 'N/A';
            $product->subcategory_name = optional(Category::find($product->sub_category_id))->name ?? 'N/A';
        }
        $filter = [];
        if ($products->currentPage() == 1) {
            if($locale=='en'){
                $subcategories = Category::where('category_id', $categoryId)->get(['id', 'name', 'image']);
            }
            else{   
$subcategories = Category::where('category_id', $categoryId)->get(['id', "name_{$locale} as name", "image_{$locale} as image"]);
            }
            
            $filter = [
                'subcategories' => $subcategories,
                'size' => $size,
                'brand' => $brand,
                'color' => $color,
                'min_price' => $min_price,
                'max_price' => $max_price
            ];
        }
        return response()->json([
            'status' => true,
            'filter' => $filter,
            'products' => $products,
        ], 200);
    } catch (\Exception $e) {
        Log::error('Error in categorylist API: ' . $e->getMessage());
        return response()->json([
            'status' => false,
            'message' => __('messages.data_failed'),
        ], 500);
    }
}
////////////////// category accoding product detail api /////////////////////////////////
public function productDetail(Request $request, $id)
{
    try {
        $locale = $request->header('Accept-Language', 'en');
        $bearerToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($bearerToken);
        $user_id = $token ? $token->tokenable->id : null;

        if ($user_id && !User::where('id', $user_id)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid user_id provided'
            ], 400);
        }
if($locale == 'en'){
    $products = Product::with([
                'images',
                'wishlists',
                'brand' => function ($query) use ($locale) {
                    $query->where('status', 'active')->select(['id', 'name']);
                },
                'offers' => function ($query) {
                    $query->where('status', 'active')->where(function ($q) {
                        $q->where('end_date', '>=', now())->orWhereNull('end_date');
                    });
                },
                'category' => function ($query) use ($locale) {
                    $query->select(['id', "name"]);
                }
            ])
            ->where(function($query) use ($id) {
                $query->where('product_id', $id)->orWhere('sku', $id);
            })
            ->where('status', 1)
            ->first(['*',  "product_name"]);

            $relatedProducts = Product::with('images')
            ->where('product_id', '<>', $products->product_id)
            ->where('status', 1)
            ->limit(4)
            ->orderBy('product_id', 'DESC')
            ->get(['*', "product_name"]);

        foreach ($relatedProducts as $relatedProduct) {
            $relatedProduct->rating = number_format(ProductRating::where('product_id', $relatedProduct->product_id)->avg('rating'), 1);
            $relatedProduct->is_wishlisted = $user_id ? $relatedProduct->wishlists()->where('user_id', $user_id)->exists() : false;
            $relatedProduct->is_cart = $user_id ? Cart::where('user_id', $user_id)->where('product_sku', $relatedProduct->sku)->where('orderplace', 1)->exists() : false;
        }

 
}
else{
    $products = Product::with([
                'images',
                'wishlists',
                'brand' => function ($query) use ($locale) {
                    $query->where('status', 'active')->select(['id', "name_{$locale} as name"]);
                },
                'offers' => function ($query) {
                    $query->where('status', 'active')->where(function ($q) {
                        $q->where('end_date', '>=', now())->orWhereNull('end_date');
                    });
                },
                'category' => function ($query) use ($locale) {
                    $query->select(['id', "name_{$locale} as name"]);
                }
            ])
            ->where(function($query) use ($id) {
                $query->where('product_id', $id)->orWhere('sku', $id);
            })
            ->where('status', 1)
            ->first(['*', "product_name_{$locale} as product_name","description_{$locale} as description"]);

            $relatedProducts = Product::with('images')
            ->where('product_id', '<>', $products->product_id)
            ->where('status', 1)
            ->limit(4)
            ->orderBy('product_id', 'DESC')
            ->get(['*', "product_name_{$locale} as product_name","description_{$locale} as description"]);

        foreach ($relatedProducts as $relatedProduct) {
            $relatedProduct->rating = number_format(ProductRating::where('product_id', $relatedProduct->product_id)->avg('rating'), 1);
            $relatedProduct->is_wishlisted = $user_id ? $relatedProduct->wishlists()->where('user_id', $user_id)->exists() : false;
            $relatedProduct->is_cart = $user_id ? Cart::where('user_id', $user_id)->where('product_sku', $relatedProduct->sku)->where('orderplace', 1)->exists() : false;
        }

}
       
        if (!$products) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $productRating = ProductRating::where('product_id', $products->product_id)->avg('rating');
        $products->rating = number_format($productRating, 1);
        $products->is_wishlisted = $user_id ? $products->wishlists()->where('user_id', $user_id)->exists() : false;
        $products->is_already_in_cart = $user_id ? Cart::where('user_id', $user_id)->where('product_sku', $products->sku)
            ->where('orderplace', 0)->where('product_color', $request->product_color)
            ->where('product_size', $request->product_size)->whereNull('order_id')->exists() : false;

        $productvariant = ProductVariant::with(['size', 'color'])
            ->where('product_id', $products->product_id)
            ->get();

        foreach ($productvariant as $variant) {
            $color = Color::find($variant->color);
            $size = Size::find($variant->size);

            $variant->color_code = $color->hex_code ?? 'N/A';
            $variant->color_name = $color ? $color->{"color_name_{$locale}"} : 'N/A';
           if($locale == 'en'){
               $variant->size_name = $size ? $size->name : 'N/A';
           }
           else{
               $variant->size_name = $size ? $size->{"name_{$locale}"} : 'N/A';
           }
            
            $variant->is_cart = $user_id ? Cart::where('user_id', $user_id)->where('product_sku', $variant->sku)->exists() : false;
        }
        $ProductRating = ProductRating::with('user')->where('product_id', $products->product_id)->get();
        return response()->json([
            'status' => true,
            'data' => [
                'product' => $products,
                'variants' => $productvariant,
                'related_products' => $relatedProducts,
                'ratings' => $ProductRating
            ]
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error in productDetail: ' . $e->getMessage());
        return response()->json([
            'status' => false,
            'message' => __('messages.data_failed'),
        ], 500);
    }
}

//////////////////////////////brand list api  /////////////////////////////////////////
public function brandlist(Request $request)
{
    try {
        $locale = $request->header('Accept-Language', 'en');
        if($locale == 'en'){
            $brands = Brand::where('status', 'active')->orderBy('id', 'DESC')->get();
        }
        else{
            $brands = Brand::select('*','image_'.$locale.' as image')->where('status', 'active')->orderBy('id', 'DESC')->get();
        }
        if ($brands->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No brands found',
                'data' => []
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Brands retrieved successfully',
            'data' => $brands
        ], 200);
    } catch (\Exception $e) {
        dd($e);
        Log::error('Error fetching brands: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' =>  __('messages.data_failed')
        ], 500);
    }
}
///////////////////////////////////brand accoding product detail api///////////////////////////////////////////////////////////////////////////////////////brand accoding product detail api////////////////////////////////////////////////////
/////////////////////////home page in view all api create accoding product Best Seller and Latest Product and Amazing deals/////////////////////
public function homePageProducts(Request $request)
{
    $locale= $request->header('Accept-Language', 'en');
    $producttypeid = $request->input('producttypeid');
    $perPage = 10; 
    $page = $request->input('page', 1);
    $bearerToken = $request->bearerToken();
    $token = PersonalAccessToken::findToken($bearerToken);
    $user_id = null;
    if ($token) {
        $user = $token->tokenable;
        $user_id = $user->id;
    }
    $products = [];
    $title = __('messages.no_products'); // Use the translated "No products found"
    switch ($producttypeid) {
        case 1:
            $products = Product::with(['images', 'wishlists', 'category'])
                ->where('status', 1)
                ->whereHas('category', function ($query) {
                    $query->where('status', 1);
                })
                ->paginate($perPage, ['*'], 'page', $page);

            $title = __('messages.amazing_deals'); // "Amazing Deals" in the selected language
            break;
        case 2:
            $products = Product::with(['images', 'wishlists', 'category'])
                ->where('status', 1)
                ->whereHas('category', function ($query) {
                    $query->where('status', 1);
                })
                ->orderBy('created_at', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

            $title = __('messages.latest_products'); // "Latest Products" in the selected language
            break;
        case 3:
            $products = Product::with(['images', 'wishlists', 'category'])
                ->where('status', 1)
                ->whereHas('category', function ($query) {
                    $query->where('status', 1);
                })
                ->paginate($perPage, ['*'], 'page', $page);

            $title = __('messages.best_sellers'); // "Best Sellers" in the selected language
            break;
        default:
            break;
    }
    if (!empty($user_id)) {
        foreach ($products as $relatedProduct) {
   
            if($locale=='en'){
                $relatedProduct->product_name=$relatedProduct->product_name; 
                //$relatedProduct->catgory->name=$relatedProduct->catgory->name;
            }
            else{
                $productname='product_name_'.$locale;
                $relatedProduct->product_name=$relatedProduct->{$productname};
               // $relatedProduct->catgory->name=$relatedProduct->catgory->{'name_'.$locale};
            }   
            $relatedProduct->is_wishlisted = $relatedProduct->wishlists()
                ->where('user_id', $user_id)
                ->exists();
        }
    }
    // Return response with translated messages
    return response()->json([
        'success' => true,
        'message' => __('messages.home_products_success'), // "Home page products retrieved successfully"
        'data' => [
            'title' => $title,
            'products' => $products->items(),
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
                'next_page_url' => $products->nextPageUrl(),
                'prev_page_url' => $products->previousPageUrl(),
            ],
        ],
    ], 200);
}
//////////////////////////////////////////search product api///////////////////////////////////////////////////////
//////////////////////////////////////////search product api///////////////////////////////////////////////////////
public function searchproduct(Request $request)
{
    try {
        $locale = $request->header('Accept-Language', 'en');
        $search = $request->input('search');
        $bearerToken = $request->bearerToken();
        $token = PersonalAccessToken::findToken($bearerToken);
        $user_id = null;

        if ($token) {
            $user = $token->tokenable;
            $user_id = $user->id;
        }
        $perPage = 10;
        $page = $request->input('page', 1);
        if($locale=='en'){
            $products = Product::with(['images', 'category', 'wishlists'])
            ->where('status', 1)
            ->whereHas('category', function ($query) {
                $query->where('status', 1);
            })
            ->where('product_name', 'LIKE', "%{$search}%")
            ->paginate($perPage, ['*'], 'page', $page);
        }
        else{
            $products = Product::select('*', "product_name_{$locale} as product_name")->with(['images', 'category', 'wishlists'])
            ->where('status', 1)
            ->whereHas('category', function ($query) {
                $query->where('status', 1);
            })
            ->where('product_name', 'LIKE', "%{$search}%")
            ->paginate($perPage, ['*'], 'page', $page);
        }
       

        if (!empty($user_id)) {
            foreach ($products as $product) {
                $productRating = ProductRating::where('product_id', $product->product_id)->avg('rating');
                $formattedRating = number_format($productRating, 1);
                $product->rating = $formattedRating;
                $product->is_wishlisted = $product->wishlists()->where('user_id', $user_id)->exists();
            }
        }

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => __('messages.no_products'),
                'data' => [
                    'products' => [],
                    'pagination' => [
                        'total' => 0,
                        'per_page' => $perPage,
                        'current_page' => $page,
                        'last_page' => 0,
                        'from' => null,
                        'to' => null,
                        'next_page_url' => null,
                        'prev_page_url' => null,
                    ],
                ]
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => __('messages.products_success'),
            'data' => [
                'products' => $products->items(),
                'pagination' => [
                    'total' => $products->total(),
                    'per_page' => $products->perPage(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'from' => $products->firstItem(),
                    'to' => $products->lastItem(),
                    'next_page_url' => $products->nextPageUrl(),
                    'prev_page_url' => $products->previousPageUrl(),
                ],
            ]
        ], 200);
    } catch (\Exception $e) {
        dd($e);
        Log::error('Error fetching products: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => __('messages.error_fetching_products'),
        ], 500);
    }
}
////////////////////////////////////////////
/// blog list api create
public function bloglist(Request $request)
{
    try {
        $locale = $request->header('Accept-Language', 'en');
        $perPage = 10;
        $page = $request->input('page', 1);
        if($locale=='en'){
            $blogs = Blog::where('status', 'active')->paginate($perPage, ['*'], 'page', $page);
        }
        else{
            $blogs = Blog::select('*', "title_{$locale} as title", "description_{$locale} as description")->where('status', 'active')->paginate($perPage, ['*'], 'page', $page);
        }
        

        return response()->json([
            'success' => true,
            'message' => __('messages.blogs_success'),
            'data' => [
                'blogs' => $blogs->items(),
                'pagination' => [
                    'total' => $blogs->total(),
                    'per_page' => $blogs->perPage(),
                    'current_page' => $blogs->currentPage(),
                    'last_page' => $blogs->lastPage(),
                    'from' => $blogs->firstItem(),
                    'to' => $blogs->lastItem(),
                    'next_page_url' => $blogs->nextPageUrl(),
                    'prev_page_url' => $blogs->previousPageUrl(),
                ],
            ]   
        ], 200);
    } catch (\Exception $e) {
        Log::error('Error fetching blogs: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => __('messages.error_fetching_blogs'),
        ], 500);
    }       
}
///////////////////////////////////////////////////////////////
public function mywishlist(Request $request)
{
    try {
        $locale = $request->header('Accept-Language', 'en');
        $user_id = Auth::user()->id; // Fetch authenticated user's ID
        $perPage = 10;
        $page = $request->input('page', 1);

        $wishlist = Wishlist::with('product.images')
            ->where('user_id', $user_id)
            ->whereHas('product', function($query) {
                $query->where('status', 1);
            })
            ->paginate($perPage, ['*'], 'page', $page);

        $wishlist->getCollection()->transform(function ($item) use ($locale, $user_id) { 
            if ($item->product) {
                $productRating = ProductRating::where('product_id', $item->product->product_id)->avg('rating');
                $item->product->product_name = ($locale == 'en') ? $item->product->product_name : $item->product->{"product_name_{$locale}"};
                $item->rating = number_format($productRating, 1);
                $item->is_wishlisted = true;
                $item->is_already_in_cart = Cart::where('product_sku', $item->product->sku)
                     ->where('user_id', $user_id) // Correct usage of $user_id inside the closure
                    ->where('orderplace', 0)
                    ->whereNull('order_id')
                    ->exists();
            } else {
                $item->rating = 0;
                $item->is_already_in_cart = false;
            }
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Wishlist retrieved successfully',
            'data' => [
                'wishlist' => $wishlist->items(),
                'pagination' => [
                    'total' => $wishlist->total(),
                    'per_page' => $wishlist->perPage(),
                    'current_page' => $wishlist->currentPage(),
                    'last_page' => $wishlist->lastPage(),
                    'from' => $wishlist->firstItem(),
                    'to' => $wishlist->lastItem(),
                    'next_page_url' => $wishlist->nextPageUrl(),
                    'prev_page_url' => $wishlist->previousPageUrl(),
                ],
            ]
        ], 200);
    } catch (\Exception $e) {
        Log::error('Error fetching wishlist: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while fetching the wishlist',
        ], 500);
    }
}


//////////////////////////
public function productwishlist(Request $request)
{
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => __('messages.wishlist_login')
        ], 401); // Unauthorized status
    }

    $product_id = $request->input('product_id');
    $user_id = Auth::user()->id;

    // Check if the product exists in the Product model
    $product = Product::where('status', 1)->find($product_id);
    if (!$product) {
        return response()->json([
            'success' => false,
            'message' => __('messages.wishlist_product_not_found'),
        ], 404); // Not Found status
    }

    // Check if the product already exists in the user's wishlist
    $wishlist = Wishlist::where('user_id', $user_id)->where('product_id', $product_id)->first();
    if ($wishlist) {
        // If product is in the wishlist, remove it
        $wishlist->delete();
        return response()->json([
            'success' => true,
            'status' => 'removed',
            'message' => __('messages.wishlist_removed'),
        ], 200); // OK status
    } else {
        // If product is not in the wishlist, add it
        $wishlist = new Wishlist();
        $wishlist->user_id = $user_id;
        $wishlist->product_id = $product_id;
        $wishlist->save();
        return response()->json([
            'success' => true,
            'status' => 'added',
            'message' => __('messages.wishlist_added'),
        ], 200); // OK status
    }
}

/////////////////////////////////////////////////
public function productcart(Request $request,$sku)
{
    try {
        // if (!Auth::check()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Please login to add products to your cart.',
        //     ], 401); // Unauthorized
        // }
        // if(!$sku)
        // {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'sku is required.',
        //     ], 404);
        // }
        $product = Product::where('sku', $sku)->where('status', 1)->first();
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404); // Not Found
        }
        $user_id = Auth::id();
        $cart = Cart::where('user_id', $user_id)->where('product_sku', $sku)->where('product_color',$request->product_color)->where('product_size',$request->product_size)->whereNull('order_id')->first();
        if ($cart) {
            $cart->quantity += 1;
            $cart->save();
            return response()->json([
                'success' => true,
                'message' => __('messages.product_quantity_updated_in_the_cart'),
                'cart' => $cart, // Optionally return the updated cart
            ], 200); // OK
        } else {
            // Add the product to the cart
            $cart = new Cart();
            $cart->user_id = $user_id;
            $cart->product_sku = $product->sku;
            $cart->quantity = 1;
            $cart->product_size=$request->product_size;
            $cart->product_color=$request->product_color;
            $cart->price = $product->base_price;
            $cart->save();
            return response()->json([
                'success' => true,
                'message' => __('messages.product_added_to_cart_successfully'),
                'cart' => $cart, // Optionally return the new cart
            ], 200); // Created
        }
    } catch (\Exception $e) {
        // Log the exception and return a JSON error response
        Log::error('Add to Cart Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => __('messages.something_went_wrong_please_try_again'),
            'error' => $e->getMessage(), // Optional: Include the error message for debugging
        ], 500); // Internal Server Error
    }
}
////////////////////////////
public function mycart(Request $request)
{
    try {
        $locale= $request->header('Accept-Language', 'en');
        $user_id = Auth::id();
        if (!$user_id) {
            return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
        }

        // Fetch cart items with relationships including color & size
        $cart = Cart::with(['product', 'product.images', 'product.category', 'product.brand', 'user', 'color', 'size'])
            ->where('user_id', $user_id)
            ->whereNull('order_id')
            ->whereHas('product', function ($query) {
                $query->where('status', 1);
            })
            ->get();

        $now = Carbon::now();
        $totalDeliveryFee = 0;
        $couponDiscount = 0;
        $totalDiscount = 0;
        $subtotal = 0;

        foreach ($cart as $item) {
            if ($item->product) {
                $productRating = ProductRating::where('product_id', $item->product->product_id)->avg('rating');
                $item->rating = number_format($productRating, 1);
            }

            // Fetch color and size from CartItem
            $item->color_code = optional($item->color)->hex_code ?? Null;
            $item->color_name = optional($item->color)->color_name ?? Null;
            if ($locale == 'en') {
            $item->size_name = optional($item->size)->name ?? null;
            $item->product->product_name= optional($item->product)->product_name ?? null;
            } else {
                $property = 'name_' . $locale;
                $productname='product_name_'.$locale;
                $item->size_name = optional($item->size)->$property ?? null;
                $item->product->product_name= optional($item->product)->$productname ?? null;
            }
            $productPrice = $item->product->base_price * $item->quantity;
            $productDiscount = $item->product->base_price * ($item->product->discount / 100) * $item->quantity;
            $subtotal += $productPrice;
            $totalDiscount += $productDiscount;
            $deliveryFee = 50;
            $totalDeliveryFee += $deliveryFee;

            // Set estimated delivery date
            $item->delivery_date = $now->addDays(5)->format('M d, Y');
        }

        // Fetch available coupons
        $coupons = Coupon::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        foreach ($cart as $item) {
            $coupon = Coupon::where('coupon_code', $item->coupon_code)->first();

            if ($coupon && $coupon->start_date <= now() && $coupon->end_date >= now()) {
                if ($subtotal >= $coupon->min_purchase_amount) {
                    
                    // Calculate the discount based on the discount type
                    if ($coupon->discount_type === 'percentage') {
                        $discountAmount = ($subtotal * ($coupon->discount_value / 100));
                    } elseif ($coupon->discount_type === 'flat') {
                        $discountAmount = $coupon->discount_value;
                    } else {
                        $discountAmount = 0;
                    }

                    // Apply maximum discount limit if set
                    if ($coupon->max_discount_amount > 0) {
                        $discountAmount = min($discountAmount, $coupon->max_discount_amount);
                    }

                    // Apply the discount to the cart
                    $couponDiscount = $discountAmount;
                    $item->coupon_applied = true;

                    // Increment coupon usage count
                    $coupon->increment('used_count');
                }
            }
        }

        // Fetch recommendations
        $recommendations = Product::with('images', 'wishlists')->where('status', 1)->limit(6)->get();
        foreach ($recommendations as $prod) {
            $productRating = ProductRating::where('product_id', $prod->product_id)->avg('rating');
            $prod->rating = number_format($productRating, 1);
            $prod->is_wishlisted = $prod->wishlists()->where('user_id', $user_id)->exists();
            if ($locale == 'en') {
                $prod->product_name = $prod->product_name;
            } else {
                $property = 'product_name_' . $locale;
                $prod->product_name = $prod->$property;
            }
        }

        // Calculate grand total
        $grandTotal = $subtotal - $totalDiscount - $couponDiscount + $totalDeliveryFee;
        $userAddress = UserAddress::where('user_id', $user_id)->orderBy('make_as_default', 'desc')->get();

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'recommendations' => $recommendations,
            'coupons' => $coupons,
            'subtotal' => number_format($subtotal, 2),
            'totalDiscount' => number_format($totalDiscount, 2),
            'couponDiscount' => number_format($couponDiscount, 2),
            'totalDeliveryFee' => number_format($totalDeliveryFee, 2),
            'grandTotal' => number_format($grandTotal, 2),
            'userAddress' => $userAddress
        ], 200);

    } catch (\Exception $e) {
        Log::error('MyCart API Error: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong. Please try again later.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
/////////////////////////////////////////////
public function cartProductRemove($id)
{
    try {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();
        return response()->json([
            'success' => true,
            'message' => 'Cart item removed successfully.',
        ], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Cart item not found.',
        ], 404);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while removing the cart item.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
////////////////////////////////
public function updateCartQuantity(Request $request)
{
    try {
        $request->validate([
            'item_id' => 'required|integer|exists:cart,id', // Ensure item_id exists in the 'cart' table (singular name)
            'quantity' => 'required|integer', // Quantity must be at least 1
        ]);
        $itemId = $request->input('item_id');
        $quantity = $request->input('quantity');
        $cartItem = Cart::where('id', $itemId)->first();
        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.',
            ], 404);
        }
        $cartItem->update(['quantity' => $quantity]);
        $totalPrice = $cartItem->price * $quantity;
        return response()->json([
            'success' => true,
            'message' => 'Cart item quantity updated successfully.',
            'total_price' => $totalPrice,
        ], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors
        return response()->json([
            'success' => false,
            'message' => 'Invalid input.',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Handle case where cart item is not found
        return response()->json([
            'success' => false,
            'message' => 'Cart item not found.',
        ], 404);
    } catch (\Exception $e) {
        // Handle any unexpected errors
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while updating the cart quantity.',
            'error' => $e->getMessage(), // Optional: include error details for debugging
        ], 500);
    }
}
//////////////////////////////////////
public function applyCoupon(Request $request)
{
    try {
        $user_id = Auth::id();
        $coupon_code = $request->input('coupon_code');
        if (!$coupon_code) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon code is required.',
            ], 400);
        }
        $coupon = Coupon::where('coupon_code', $coupon_code)
                        ->where('start_date', '<=', Carbon::now())
                        ->where('end_date', '>=', Carbon::now())
                        ->first();
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code.',
            ], 400);
        }
        if ($coupon->usage_limit_per_coupon <= $coupon->used_count) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon usage limit exceeded.',
            ], 400);
        }
        $userCouponUsage = Cart::where('user_id', $user_id)
                               ->where('coupon_code', $coupon_code)
                               ->count();
        if ($coupon->usage_limit_per_customer <= $userCouponUsage) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon usage limit reached for this customer.',
            ], 400);
        }
        $cart = Cart::where('user_id', $user_id)->get();
        $totalDiscount = 0;
        foreach ($cart as $item) {
            // Calculate the discount for each item based on the coupon
            $item_discount = $item->product->base_price * ($coupon->discount_value / 100) * $item->quantity;
            $totalDiscount += $item_discount;
            $item->coupon_code = $coupon_code;
            $item->save();
        }
        $coupon->used_count += 1;
        $coupon->save();
        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully.',
            'totalDiscount' => $totalDiscount,
        ], 200);
    } catch (\Exception $e) {
        // Handle any unexpected errors
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while applying the coupon.',
            'error' => $e->getMessage(), // Optional: include error details for debugging
        ], 500);
    }
}
/////////////////////////////
public function placeOrder(Request $request)
{
    try {
        $userId = Auth::id();;
        $cartItems = Cart::where('user_id', $userId)->with('product')->get();
        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.',
            ], 400);
        }
        $totalItems = $cartItems->sum('quantity');
        $subtotalPrice = $cartItems->sum('total_price');

        $totalDiscount = $cartItems->sum(function ($item) {
            return $item->product->base_price * ($item->product->discount / 100) * $item->quantity;
        });

        $couponDiscount = $cartItems->sum(function ($item) {
            if ($item->coupon_code) {
                $coupon = \App\Models\Coupon::where('coupon_code', $item->coupon_code)->first();
                return $coupon ? $item->product->base_price * ($coupon->discount_value / 100) * $item->quantity : 0;
            }
            return 0;
        });

        $deliveryFee = $totalItems * 50;

        $grandTotal = $subtotalPrice - $totalDiscount - $couponDiscount + $deliveryFee;
        $existingOrder = CartOrderSummary::where('user_id', $userId)
                                         ->where('order_status', 'pending')
                                         ->first();

        if ($existingOrder) {
            // Step 7: Update the existing order
            $existingOrder->update([
                'total_items' => $totalItems,
                'subtotal_price' => $subtotalPrice,
                'total_discount' => $totalDiscount,
                'coupon_discount' => $couponDiscount,
                'delivery_fee' => $deliveryFee,
                'delivery_date' => Carbon::now()->addDays(5)->format('M d, Y'),
                'grand_total' => $grandTotal,
                'coupon_code' => $cartItems->first()->coupon_code ?? $existingOrder->coupon_code,
            ]);

            // Return JSON response for the updated order
            return response()->json([
                'success' => true,
                'message' => 'Existing order updated successfully! Redirecting to Order Summary...',
                'order_id' => $existingOrder->id,
            ], 200);
        }

        // Step 8: Create a new order if no pending order exists
        $newOrder = CartOrderSummary::create([
            'user_id' => $userId,
            'order_id' => Str::random(10), // Generate a unique order ID
            'total_items' => $totalItems,
            'subtotal_price' => $subtotalPrice,
            'total_discount' => $totalDiscount,
            'coupon_discount' => $couponDiscount,
            'delivery_fee' => $deliveryFee,
            'grand_total' => $grandTotal,
            'delivery_date' => Carbon::now()->addDays(5)->format('M d, Y'),
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'coupon_code' => $cartItems->first()->coupon_code ?? null,
        ]);

        // Return JSON response for the new order
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully! Redirecting to Order Summary...',
            'order_id' => $newOrder->id,
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $validationException) {
        // Handle validation errors
        return response()->json([
            'success' => false,
            'message' => __('messages.validation_error'),
            'errors' => $validationException->errors(),
        ], 422);
    } catch (\Exception $e) {
        // Handle unexpected errors
        return response()->json([
            'success' => false,
            'message' => __('messages.order_place_error'),
            'error' => $e->getMessage(),
        ], 500);
    }
}
///////////////////////order summary//////////////////////////
public function orderSummary(Request $request, $order_id)
{
    try {
        $user = Auth::user();
        // Step 1: Fetch the order details
        $order = CartOrderSummary::find($order_id);
        // dd($order->user_id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }
        $userAddress = UserAddress::where('user_id', $user->id)->orderBy('make_as_default', 'desc')->get();
        // Step 2: Fetch cart items for the user associated with the order
        $cartItems = Cart::where('user_id', $order->user_id)
            ->with(['product', 'product.images']) // Eager load product and images
            ->whereNull('order_id') // Ensure cart items are not yet linked to another order
            ->get();

        // Step 3: Process each cart item
        $cartItems->each(function ($item) {
            $productRating = ProductRating::where('product_id', $item->product->product_id)->avg('rating');
            $formattedRating = number_format($productRating, 1); // Format the rating to one decimal place
            $item->rating = $formattedRating;
            // Fetch the product ID from the cart item
            $product_id = $item->product->id;
            // Fetch variants for the product, eager loading color and size relationships
            $variants = ProductVariant::where('product_id', $product_id)
                ->with(['color', 'size'])
                ->get();
            // Attach additional data to each variant
            foreach ($variants as $variant) {
                $variant->color_code = $variant->color ? $variant->color->hex_code : 'N/A';
                $variant->color_name = $variant->color ? $variant->color->color_name : 'N/A';
                $variant->size_name = $variant->size ? $variant->size->name : 'N/A';
            }
            // Assign the first variant to the cart item (if available)
            $item->variant = $variants->first();
            // Assign size_name and color_code to the cart item for display
            $item->size_name = $item->variant ? $item->variant->size_name : 'N/A';
            $item->color_code = $item->variant ? $item->variant->color_code : 'N/A';
        });

        // Step 4: Return the response with order and cart item details
        return response()->json([
            'success' => true,
            'message' => __('messages.order_summary_success'),
            'data' => [
                'user_address' => $userAddress,
                'order' => $order,
                'cart_items' => $cartItems,
            ],
        ], 200);
    } catch (\Exception $e) {
        // Handle unexpected errors
        return response()->json([
            'success' => false,
            'message' => __('messages.order_summary_error'),
            'error' => $e->getMessage(),
        ], 500);
    }
}
////////////////////////////////////////

/////////////////pay now////////////////////////////////////////////
public function paynow(Request $request)
{
    DB::beginTransaction();
    try {
        $userId = Auth::id();
        $user= User::find($userId);
        // Validate required fields
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
        ]);
            $cartItem = Cart::where('user_id', $userId)
            ->whereNotNull('order_id') // Ensure order_id is not NULL
            ->exists();
            $is_ordered=false;
            if ($cartItem) {
                $is_ordered=true;
            }
            
        $cartItems = Cart::where('user_id', $userId)
            ->with('product') // Eager load product details
            ->whereNull('order_id')
            ->get();



        $totalProductCount = $cartItems->unique('product_id')->count();
        // If the cart is empty, return a failure response
        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'is_ordered'=>$is_ordered,
                'message' => 'Your cart is empty.'
            ], 200); // 400 is for bad request
        }

        // Calculate order totals
       
        $totalItems = $cartItems->sum('quantity');
        $subtotalPrice = $cartItems->sum('total_price');
        $totalDiscount = $cartItems->sum(function ($item) {
            return $item->product->base_price * ($item->product->discount / 100) * $item->quantity;
        });
        $couponDiscount = $cartItems->sum(function ($item) {
            if ($item->coupon_code) {
                $coupon = \App\Models\Coupon::where('coupon_code', $item->coupon_code)->first();
                return $coupon ? $item->product->base_price * ($coupon->discount_value / 100) * $item->quantity : 0;
            }
            return 0;
        });
        $deliveryFee = $totalProductCount * 50;
        $grandTotal = $subtotalPrice - $totalDiscount - $couponDiscount + $deliveryFee;

        // Check if an existing pending order exists
        $existingOrder = CartOrderSummary::where('user_id', $userId)
            ->where('order_status', 'pending')
            ->first();

        // if ($existingOrder) {
        //     // Update existing order with the calculated details
        //     $existingOrder->update([
        //         'total_items' => $totalItems,
        //         'subtotal_price' => $subtotalPrice,
        //         'total_discount' => $totalDiscount,
        //         'coupon_discount' => $couponDiscount,
        //         'delivery_fee' => $deliveryFee,
        //         'delivery_date' => Carbon::now()->addDays(5)->format('M d, Y'),
        //         'grand_total' => $grandTotal,
        //         'coupon_code' => $cartItems->first()->coupon_code ?? $existingOrder->coupon_code,
        //     ]);
        //     $orderId = $existingOrder->id;
        // } else {
            // Create a new order if no pending order exists
            $newOrder = CartOrderSummary::create([
                'user_id' => $userId,
                'order_id' => Str::random(10), // Generate a unique order ID
                'total_items' => $totalItems,
                'subtotal_price' => $subtotalPrice,
                'total_discount' => $totalDiscount,
                'coupon_discount' => $couponDiscount,
                'delivery_fee' => $deliveryFee,
                'grand_total' => $grandTotal,
                'delivery_date' => Carbon::now()->addDays(5)->format('M d, Y'),
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'coupon_code' => $cartItems->first()->coupon_code ?? null,
            ]);
            $orderId = $newOrder->id;
        // }

        // Fetch address details and validate
        $address = UserAddress::find($request->input('address_id'));
        if (!$address) {
            return response()->json([
                'error' => 'Address not found.',
                'is_ordered'=>$is_ordered,
            ], 404); // 404 for not found
        }

        $addressData = $address->name . ', ' . $address->address . ', ' . $address->city . ', ' . $address->zip_code . ', ' . $address->country . ', ' .$address->country_code . '-'. $address->mobile_number;

        // Update order with address and payment status
        $order = CartOrderSummary::find($orderId);
        $order->payment_status = 'paid';
        $order->order_status = 'pending';
        $order->order_address = $addressData;
        $order->save();

        // Process cart items and update product stock
        foreach ($cartItems as $item) {
            $product = $item->product;
            if ($product) {
                $product->quantity -= $item->quantity;
                $product->save();
                OrderItem::create([
                    'order_id' => $orderId,
                    'product_id' => $product->product_id,
                    'quantity' => $item->quantity,
                    'price' => $product->base_price,
                ]);

               
                $item->order_id = $orderId;
                $item->orderplace = 1;
                $item->save();
            }
        }

        // Clear cart items after the order is placed
        Cart::where('user_id', $userId)->whereNull('order_id')->delete();

        // Update coupon usage if a coupon was applied
        if ($order->coupon_code) {
            $coupon = Coupon::where('coupon_code', $order->coupon_code)->first();
            if ($coupon) {
                $coupon->usage_limit_per_coupon -= 1;
                $coupon->save();
            }
        }


        Transaction::create([
            'order_id' => $order->order_id,
            'user_id' => $userId,
            'transaction_id' => $request->input('transaction_id') ?? Str::uuid(),
            'payment_method' => 'cod',
            'amount' => $grandTotal,
            'currency' => 'IQD',
            'payment_status' => 'success',
        ]);

        // Commit the transaction
            DB::commit();
           $messages = [
            'en'  => "Your order #{$order->order_id} has been booked.",
            'ar'  => "تم حجز طلبك رقم #{$order->order_id}.",
            'cku' => "فەرمانی تۆ #{$order->order_id} تۆمار کرا.",
        ];

// Set default to English if no valid lang is found
$lang = $user->lang ?? 'en';
$message = $messages[$lang] ?? $messages['en'];

// Create notification in the database
Notification::create([
    'user_id' => $user->id,
    'type'    => 'order',
    'title'   => ['en' => 'Order Booked', 'ar' => 'تم الحجز', 'cku' => 'داواكراو تۆمار كرا'][$lang],
    'message' => $message,
    'order_id' => $order->id,
    'status'   => 'unread',
]);

// Send Firebase push notification if FCM token exists
if ($user->fcm_token) {
    $title = ['en' => "Order Booked", 'ar' => "تم الحجز", 'cku' => "داواكراو تۆمار كرا"][$lang];

    $payload = [
        'order_id'     => $order->order_id,
        'user_id'      => $user->id,
        'status'       => 'booked',
        'type'         => 'order',
        'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
    ];
        $this->firebaseService->sendNotification($user->fcm_token, $title, $message, $payload);

        }
        // Return success response with order ID and success message
        return response()->json([
            'success' => true,
            'message' => __('messages.order_placed_successfully'),
            'delivered_date'=>$order->delivery_date,
            'is_ordered'=>$is_ordered,
            'order_id' => $orderId,
        ], 200); // 200 OK
    } catch (\Exception $e) {
        dd($e);
        // Rollback the transaction in case of error
        DB::rollBack();

        // Log the error for debugging
        \Log::error('PlaceOrderAndPay Error: ' . $e->getMessage());

        // Return error response with a message
        return response()->json([
            'error' => 'An error occurred while processing the order. Please try again.'
        ], 500); // 500 for internal server error
    }
}

//////////////////////////////////////////
public function order(Request $request)
{
    try {
        $locale = $request->header('Accept-Language', 'en');
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.unauthorized')
            ], 401);
        }

        $query = CartOrderSummary::where('user_id', $user->id)
            ->with([
                'cartItems.product.images',
                'productreturnorders.refund',
                'productReturnOrders.reason',
            ]);

        if ($request->has('status')) {
            $status = is_string($request->input('status')) ? explode(',', $request->input('status')) : $request->input('status');
            $query->whereIn('order_status', $status);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $orders->transform(function ($order) use ($locale) {
            $order->cartItems->transform(function ($item) use ($locale) {
                if ($item->product) {
                    $item->product->product_name = ($locale == 'en') 
                        ? $item->product->product_name 
                        : $item->product->{"product_name_{$locale}"};
                }
                return $item;
            });
            return $order;
        });

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'orders' => $orders
            ]
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => __('messages.error_fetching_orders'),
            'error' => $e->getMessage()
        ], 500);
    }
}
////////////////////////////////////
public function orderDetail(Request $request,$order_id, $product_id)
{
    try {
        // Authenticate user
        $locale = $request->header('Accept-Language', 'en');
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please login to access your orders.'
            ], 401);
        }
        // Fetch the product
        if($locale=='en'){
            $product = Product::with('images')->findOrFail($product_id);
        }
        else{
            $product = Product::select('*', "product_name_{$locale} as product_name")->with('images')->findOrFail($product_id);
        }
        
        // Fetch the order along with cart items and related product data
        $order = CartOrderSummary::where('id', $order_id)
            ->where('user_id', $user->id)
            ->with([
                'cartItems' => function ($query) use ($product) {
                    $query->where('product_sku', $product->sku)
                        ->with([
                            'product.images',
                            'product.category',
                            'product.brand',
                            'product.productReturnOrders',
                            'product.productRatings',
                        ]);
                },
            ])
            ->firstOrFail();

        // Format order details
        $order->ordered_date = $order->created_at->format('jS M Y');
        $order->delivered_date = $order->delivered_at ? $order->delivered_at->format('jS M Y') : 'Pending';
        $order->shipping_address = $order->shipping_address ?? 'No shipping address available';
        
        // Get the specific cart item
        $cartItem = $order->cartItems->first();
        if (!$cartItem || !$cartItem->product) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.product_not_found')
            ], 404);
        }
        // Get the product from the cart item
        $product = $cartItem->product;
        $product->product_name=($locale=='en')?$product->product_name:$product->{"product_name_{$locale}"};
        // Check if a product return order exists for the specific product, order, and user
        $productReturnOrder = ProductReturnOrder::where('order_id', $order_id)
            ->where('product_id', $product_id)
            ->where('user_id', $user->id)
            ->first();

        // Fetch reasons for product return
        $reason = ReturnReason::where('status', 'active')->get();
        // If a return order exists, pass its status
        $returnStatus = $productReturnOrder ? $productReturnOrder->return_status : '';
        // Check if the product has been rated by the user for this order
        $productRating = ProductRating::where('product_id', $product_id)
            ->where('user_id', $user->id)
            ->first();
        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'order' => $order,
                'reason' => $reason,
                'product' => $product,
                'returnStatus' => $returnStatus,
                'productRating' => $productRating,
            ]
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Handle cases where records are not found
        Log::warning('Order or Product not found: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => __('messages.order_not_found') ,
        ], 404);
    } catch (\Exception $e) {
        dd($e);
        // Log other exceptions for debugging
        Log::error('Order Detail Error: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => __('messages.invoice_error'),
        ], 500);
    }
}
/////////////////////////////////////////////////////////////
public function downloadInvoice($order_id)
{
    try {
        // Fetch the order details
        $order = CartOrderSummary::with(['cartItems.product'])
            ->where('id', $order_id)
            ->firstOrFail();
        $data = [
            'order' => $order,
            'ordered_date' => $order->created_at->format('jS M Y'),
            'delivered_date' => $order->delivered_at ? $order->delivered_at->format('jS M Y') : 'Pending',
            'shipping_address' => $order->shipping_address ?? __('messages.shipping_address_missing'),
        ];
        // Generate the PDF using the view
        $pdf = PDF::loadView('website.invoice', $data);
        // Return the PDF file as a response
        return response()->streamDownload(
            fn () => print($pdf->output()),
            'invoice_order_' . $order_id . '.pdf',
            ['Content-Type' => 'application/pdf']
        );
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Handle case where order is not found
        return response()->json([
            'status' => 'error',
            'message' => __('messages.order_not_found')
        ], 404);
    } catch (\Exception $e) {
        // Handle generic exceptions
        Log::error('Invoice Generation Error: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => __('messages.invoice_error')
        ], 500);
    }
}
///////////////////////////////////////
public function addReview(Request $request)
{
    try {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'required|exists:products,product_id', // Ensure the product exists
            'rating' => 'required|integer|min:1|max:5',   // Rating must be between 1 and 5
            'review' => 'nullable|string|max:1000',       // Optional but must be a string if provided
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user has already rated this product
        $existingRating = ProductRating::where('product_id', $request->product_id)
                                        ->where('user_id', $user->id)
                                        ->first();

        if ($existingRating) {
            return response()->json([
                'success' => false,
                'message' => __('messages.review_already_exists')
            ], 400);
        }

        // Create a new rating record
        ProductRating::create([
            'product_id' => $request->product_id,
            'user_id' => $user->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => __('messages.review_submitted')
        ], 201);
    } catch (ValidationException $e) {
        // Handle validation errors
        return response()->json([
            'success' => false,
            'message' => __('messages.review_validation_error'),
            'errors' => $e->errors()
        ], 422);
    } catch (Exception $e) {
        // Handle general exceptions
        return response()->json([
            'success' => false,
            'message' => __('messages.review_submission_error')
        ], 500);
    }
}

/////////////////////////////////////////


public function rating()
{
    try {
        // Ensure the user is authenticated
        $user = Auth::user();

        // If the user is not authenticated, return an error response
        if (!$user) {
            return response()->json([
                'message' => __('messages.unauthorized_access'),
            ], 401); // Unauthorized status code
        }

        // Fetch product ratings with related product and product images
        $productrating = ProductRating::where('user_id', $user->id)
                                      ->with('product', 'product.images')
                                      ->get();

        // If no ratings are found, return an empty array with a message
        if ($productrating->isEmpty()) {
            return response()->json([
                'message' => __('messages.no_ratings_found'),
                'data' => [],
            ], 200); // Success status code
        }

        // Return the product ratings
        return response()->json([
            'message' => __('messages.ratings_fetched'),
            'data' => $productrating,
        ], 200); // Success status code
    } catch (\Exception $e) {
        // Catch any exceptions and return an error response
        return response()->json([
            'message' => __('messages.fetching_ratings_error'),
            'error' => $e->getMessage(),
        ], 500); // Server error status code
    }
}

///////////my address///////////////
public function UserAddress(Request $request)
{
    try {
        $user = Auth::user();
        // Fetch addresses with pagination and prioritize `make_as_default`
        $addresses = UserAddress::where('user_id', $user->id)
            ->orderBy('make_as_default', 'DESC') // Default address comes first
            ->paginate(10); // Paginate with 10 items per page (adjust as needed)
        return response()->json([
            'message' => __('messages.addresses_fetched'),
            'data' => $addresses,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => __('messages.error_fetching_addresses'),
            'error' => $e->getMessage(),
        ], 500);
    }
}
//////////////////////////////
public function deleteAddress($id)
{
    try {
        $user = Auth::user();
        $address = UserAddress::findOrFail($id);
        $address->delete();
        return response()->json([
            'status' => true,
            'message' => __('messages.address_deleted'),
           
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => __('messages.error_deleting_address'),
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function saveAddress(Request $request)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'address' => 'required|min:5|max:255',
        'city' => 'required|min:2|max:100',
        'state' => 'nullable|min:2|max:100',
        'country' => 'required|min:2|max:100',
        'mobile' => 'required|min:8|max:15',
        'country_code'=>'required'
    ]);

    // If validation fails, return validation errors as a response
    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors('message')->first(),
           
        ], 400);
    }

    try {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the user already has addresses
        $existingAddresses = UserAddress::where('user_id', $user->id)->count();

        // Determine the default status
        $makeAsDefault = $existingAddresses === 0 || $request->input('make_as_default', false);

        if ($makeAsDefault) {
            // Reset other default addresses if this address is to be default
            UserAddress::where('user_id', $user->id)->update(['make_as_default' => 0]);
        }

        // Create the new address
        $userAddress = UserAddress::create([
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'user_id' => $user->id,
            'name' => $request->input('name'),
            'house_number' => $request->input('house_number'),
            'street_name' => $request->input('street_name'),
            'zip_code' => $request->input('zip_code'),
            'landmark' => $request->input('landmark'),
            'country' => $request->input('country'),
            'country_code' => $request->input('country_code'),
            'mobile_number' => $request->input('mobile'),
            'make_as_default' => $makeAsDefault ? 1 : 0,
        ]);

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => __('messages.address_saved'),
            'data' => $userAddress
        ], 201);

    } catch (\Exception $e) {
        // Log the error message
        Log::error('Error saving address: ' . $e->getMessage());

        // Return error message to the user
        return response()->json([
            'status' => 'error',
            'message' => __('messages.error_saving_address'),
            'error' => $e->getMessage()
        ], 500);
    }
}
/////////////////////////////////////////////
public function updateaddress(Request $request, $id)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'name' => 'required|min:2|max:50',
        'address' => 'required|min:5|max:255',
        'mobile' => 'required|digits_between:8,15',
        'house_number' => 'required|min:1|max:50',
        'street_name' => 'required|min:3|max:100',
        'city' => 'required|min:2|max:100',
        'country' => 'required|min:2|max:100',
        'zip_code' => 'required|digits_between:5,10',
    ]);

    // If validation fails, return validation errors as a response
    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed.',
            'errors' => $validator->errors()
        ], 400);
    }

    try {
        // Get the authenticated user
        $user = Auth::user();

        // Find the address by ID
        $address = UserAddress::where('user_id', $user->id)->where('id', $id)->first();

        // If the address is not found, return an error response
        if (!$address) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.address_not_found'),
            ], 404);
        }
        // Check if the current address should be the default
        $makeAsDefault = $request->has('make_as_default') && $request->make_as_default == 1;
        if ($makeAsDefault) {
            // Set all other addresses for the user as not default
            UserAddress::where('user_id', $user->id)
                ->where('id', '!=', $id)
                ->update(['make_as_default' => 0]);
        }

        // Update the address
        $address->update([
            'name' => $request->name,
            'address' => $request->address,
            'mobile_number' => $request->mobile,
            'house_number' => $request->house_number,
            'street_name' => $request->street_name,
            'landmark' => $request->landmark ?? null,
            'city' => $request->city,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
            'make_as_default' => $makeAsDefault ? 1 : 0, // Set as default if requested, otherwise 0
        ]);

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => __('messages.address_updated'),
            'data' => $address
        ], 200);

    } catch (\Exception $e) {
        // Log the error message
        Log::error('Error updating address: ' . $e->getMessage());

        // Return error response with exception message
        return response()->json([
            'status' => 'error',
            'message' => __('messages.error_updating_address'),
            'error' => $e->getMessage()
        ], 500);
    }
}

//////////////////////////////////////////////////
public function productreturn(Request $request)
{
    // Validate the incoming data
    $validated = $request->validate([
        'order_id' => 'required|integer|exists:cart_order_summary,id',
        'product_id' => 'required|integer|exists:products,product_id',
        'reason_id' => 'required|integer|exists:return_reasons,id',
        'return_comments' => 'nullable|string|max:255',
    ]);

    $user_id = Auth::id();

    try {
        // Save the product return order
        $returnOrder = ProductReturnOrder::create([
            'order_id' => $validated['order_id'],
            'product_id' => $validated['product_id'],
            'user_id' => $user_id,
            'reason_id' => $validated['reason_id'],
            'return_status' => 'Pending', // Default status
            'return_comments' => $validated['return_comments'] ?? null,
        ]);

        // Return a JSON response with success message
        return response()->json([
            'success' => true,
            'message' => __('messages.return_success'),
            'data' => $returnOrder
        ], 201); // 201 Created status

    } catch (\Exception $e) {
        // Handle exceptions and return an error response
        return response()->json([
            'success' => false,
            'message' => __('messages.return_error'),
            'error' => $e->getMessage()
        ], 500); // 500 Internal Server Error
    }
}


////////////////////////////////////////////////
public function coupons()
{
    try {
        // Fetch all active coupons that have not expired
        $coupons = Coupon::whereDate('end_date', '>=', now())  // Exclude expired coupons
            ->get();
        return response()->json([
            'success' => true,
             'message' => __('messages.coupons_fetched'),
            'data' => $coupons
        ], 200);
    }
    catch (\Exception $e) {
        return response()->json([
            'success' => false,
              'message' => __('messages.error_fetching_coupons'),
            'error' => $e->getMessage()
        ], 500); // 500 Internal Server Error
    }
}
////////////////////////
public function ordercancel(Request $request)
{
    try {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => __('messages.unauthorized')
            ], 401);
        }

        // Validate cart item ID
        if (!$request->has('cart_id')) {
            return response()->json([
                'success' => false,
                'message' => __('messages.cart_id_required')
            ], 400);
        }

        $cartItem = Cart::findOrFail($request->cart_id);
        
        // Update the single cart item status to 'Cancelled'
        $cartItem->update(['order_status' => 'cancelled']);

        // Fetch the associated order
        $order = CartOrderSummary::with('cartItems')->find($cartItem->order_id);
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => __('messages.order_not_found'),
            ], 404);
        }

        // Check if all cart items in the order are cancelled
        $remainingItems = $order->cartItems()->where('order_status', '!=', 'cancelled')->count();
        if ($remainingItems === 1) {
            // If all items are cancelled, update the order status
                $cartItem->update(['order_status' => 'cancelled']);
                $order->update(['order_status' => 'cancelled']);
        }

        // Fetch product details if product_id is provided
        $product = $request->product_id ? Product::find($request->product_id) : null;

        // Create notification
        Notification::create([
            'user_id' => $user->id,
            'type' => 'order',
            'title' => __('messages.order_cancelled_title'),
            'message' => __('messages.order_cancelled_message', [
                'product_name' => $product ? $product->product_name : __('messages.unknown_product'),
                'product_id' => $product ? $product->product_id : null,
                'order_id' => $order->id
            ]),
            'product_id' => $product ? $product->product_id : null,
            'order_id' => $order->id,
            'status' => 'unread',
        ]);

        // Send push notification
        if ($user->fcm_token) {
            $title = __('messages.order_cancelled_title');
            $body = __('messages.order_cancelled_message', [
                'product_name' => $product ? $product->product_name : __('messages.unknown_product'),
                'product_id' => $product ? $product->product_id : null,
                'order_id' => $order->id
            ]);
            $payload = [
                'order_id'   => $order->id,
                'product_id' => $product ? $product->product_id : null,
                'status'     => 'cancelled',
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK'
            ];
            $this->firebaseService->sendNotification($user->fcm_token, $title, $body, $payload);
        }

        return response()->json([
            'success' => true,
            'message' => __('messages.order_cancelled'),
            'data' => $order
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error cancelling order: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => __('messages.error_cancelling'),
            'error' => $e->getMessage()
        ], 500);
    }
}


////////////////////////////////////
public function deleteAccount(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['success'=>false,'message' => 'User not found'], 404);
            }

            // Check if user has any pending orders
            $pendingOrders = CartOrderSummary::where('user_id', $user->id)
                                  ->where('order_status', 'pending') // Adjust this status based on your DB
                                  ->exists();

            if ($pendingOrders) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your account while you have pending orders.'
                ], 200);
            }

            // Begin Transaction
            DB::beginTransaction();

            // Delete user
            $user->delete();

            // Commit Transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('messages.account_deleted'),
            ], 200);

        } catch (\Exception $e) {
            // Rollback Transaction on Error
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => __('messages.error_something_went_wrong'),
                'error' => $e->getMessage()
            ], 500);
        }
    }
    ////////////////////////////////////////
   public function notificationlist(Request $request)
{
    try {
        $user = Auth::user();
        $query = Notification::where('user_id', $user->id);

        // Apply type filter if provided
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        $notifications = $query->orderBy('created_at', 'desc')->get();

        $groupedNotifications = [
            'Today' => [],
            'Yesterday' => [],
            'Older' => []
        ];

        foreach ($notifications as $notification) {
            $date = \Carbon\Carbon::parse($notification->created_at);

            if ($date->isToday()) {
                $groupedNotifications['Today'][] = [
                    'date' => $date->format('Y-m-d'),
                    'notification' => $notification
                ];
            } elseif ($date->isYesterday()) {
                $groupedNotifications['Yesterday'][] = [
                    'date' => $date->format('Y-m-d'),
                    'notification' => $notification
                ];
            } else {
                $groupedNotifications['Older'][] = [
                    'date' => $date->format('Y-m-d'),
                    'notification' => $notification
                ];
            }
        }

        return response()->json([
            'success' => true,
            'message' =>__('messages.notifications_fetched'),
            'data' => $groupedNotifications
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' =>__('messages.error_fetching_notifications'),
            'error' => $e->getMessage()
        ], 500);
    }
}
    ///////////////////////////////////////////
   public function notificationread()
{
    try {
        $user = Auth::user();

        // Update all unread notifications for the user
        Notification::where('user_id', $user->id)
            ->where('status', 'unread')
            ->update(['status' => 'read']);

        return response()->json([
            'success' => true,
            'message' => __('messages.notifications_marked_read'),
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error updating notifications: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => __('messages.error_updating_notifications'),
            'error' => $e->getMessage()
        ], 500);
    }
}
///////////////////////////////////////
public function sendSmsNotification()
{
    try {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');

        $client = new Client($sid, $token);

        $client->messages->create(
            '+919664302538', // Recipient number
            [
                'from' => $from, // Must be a purchased Twilio number
                'body' => 'This is a test message from Twilio in Laravel.'
            ]
        );

        return response()->json(['success' => true, 'message' => 'Message sent successfully']);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}
//////////////////////////////////////////////////////////
public function removeCoupon(Request $request)
{
    try {
        $user_id = Auth::id();
        // dd($user_id);die;
        $appliedCoupon = $request->applied_coupon;
        if (!$appliedCoupon) {
            return response()->json(['error' => 'No coupon applied.'], 400);
        }
        $cartItems = Cart::where('user_id', $user_id)->where('coupon_code', $appliedCoupon)->whereNull('order_id')->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'No cart items found with the applied coupon.'], 200);
        }
        foreach ($cartItems as $item) {
            $item->coupon_code = null;
            $item->save();
        }
        return response()->json([
            'status' => true,
            'message' => 'Coupon removed successfully.',
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Error removing coupon: ' . $e->getMessage());
        return response()->json([
            'status' => false,
            'error' => 'An error occurred while removing the coupon.',
            'details' => $e->getMessage()
        ], 500);
    }
}
public function userlanguage(Request $request)
{
    try {
        $user_id = Auth::id();
        $lang = $request->lang;
        if (!$lang) {
            return response()->json(['error' => 'No language specified.'], 400);
        }
        $user = User::findOrFail($user_id);
        $user->lang = $lang;
        $user->save();
        return response()->json([
            'status' => true,
            'message' => 'Language updated successfully.',
        ], 200);
    } catch (\Exception $e) {
        \Log::error('Error updating language: ' . $e->getMessage());
        return response()->json([
            'status' => false,
            'error' => 'An error occurred while updating the language.',
            'details' => $e->getMessage()
        ], 500);
    }
}
///////////////////////////
   public function userlogout(Request $request)
{
    try {
         $user = Auth::user(); // Use the correct guard

        if ($user) {
            // Clear FCM Token
            if ($request->header("fcm_token")) {
                $user->update(['fcm_token' => null]);
            }

            // Revoke user's tokens (for Sanctum or Passport)
            $user->tokens()->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully.',
        ], 200);
    } catch (\Exception $e) {
        \Log::error('Error logging out user: ' . $e->getMessage());
        return response()->json([
            'status' => false,
            'error' => 'An error occurred while logging out the user.',
            'details' => $e->getMessage()
        ], 500);
    }
}

public function getFedExTrackingStatus()
{
   try {
            
            $accessToken = app(FedExService::class)->getAccessToken(); 

           
            $fedexApiUrl = 'https://apis-sandbox.fedex.com/track/v1/associatedshipments';

           
            $body = [
                "trackingInfo" => [
                    [
                        "trackingNumberInfo" => [
                            "trackingNumber" => '794123456789' // Get tracking ID from request
                        ]
                    ]
                ],
                "includeDetailedScans" => true
            ];

           
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'X-locale' => 'en_US',
                'Content-Type' => 'application/json'
            ])->post($fedexApiUrl, $body);

            
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'FedEx API request failed',
                    'details' => $response->body()
                ], $response->status());
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Exception occurred',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
///////////////////////////////////////////////////////
