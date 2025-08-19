<?php
namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Banner;
use App\Mail\ContactUsMail;
use App\Models\User;
use App\Models\Otp;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Blog;
use App\Models\Wishlist;
use App\Models\UserAddress;
use App\Models\ProductRating;
use App\Models\CartOrderSummary;
use App\Models\ProductReturnOrder;
use App\Models\Faq;
use Illuminate\Support\Facades\Hash;
use App\Models\CountryCode;
use App\Models\OrderItem;
use App\Models\ReturnReason;
use App\Models\ContactUs;
use App\Models\Pages;
use App\Models\PlanUser;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Color;
use App\Models\Size;
use App\Models\Libraries;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use carbon\Carbon;
use PDF;
use Mail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Services\FirebaseService;
use App\Services\FibPaymentService;
use GuzzleHttp\Client;
use App\Services\FedExService;
use Illuminate\Support\Facades\Http;


class WebsiteController extends Controller
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
    public function index()
    {
        $excludedIds = [17, 74, 80];
        $category = Category::where('status', '1')->whereNull('category_id')->whereNotIn('id', $excludedIds)->orderBy('id', 'DESC')->get();
        $bath=Category::where('status', '1')->where('category_id', '68')->orderBy('id', 'DESC')->where('status', '1')->get();
        $maternity=Category::where('status', '1')->where('category_id', '74')->orderBy('id', 'DESC')->where('status', '1')->get();
        $dalicate=Category::where('status', '1')->where('category_id', '80')->orderBy('id', 'DESC')->where('status', '1')->get();
        $banner=Banner::where('status','active')->where('position' ,'homepage')->orderBy('id','ASC')->get();
        $library =Libraries::where('status','1')->orderBy('id','ASC')->get();
     
        $delic=Banner::where('status','active')->where('id','8')->first();
        $newarrival=Banner::where('status','active')->where('id','9')->first();
        $mater=Banner::where('status','active')->where('id','10')->first();
        $babe_care=Banner::where('status','active')->where('id','11')->first();
        $magical=Banner::where('status','active')->where('id','12')->first();
        $perfact=Banner::where('status','active')->where('id','13')->first();
      
        $letestproduct = Product::with('images', 'category' ,'wishlists')
        ->whereHas('category', function ($query) {
        $query->where('status', 1); // Assumes 'active' column is used to check if the category is active
        })
        ->where('status', 1)->where('language','hindi')
        ->where('type','popular')
        ->limit(10)
       // ->orderBy('product_id', 'DESC')
        ->get();




 $combo = Product::with('images', 'category' ,'wishlists')
        ->whereHas('category', function ($query) {
        $query->where('status', 1); // Assumes 'active' column is used to check if the category is active
        })
        ->where('status', 1)->where('product_type','combo')
        
        ->limit(10)
       // ->orderBy('product_id', 'DESC')
        ->get();








 $currentreading = Product::with('images', 'category' ,'wishlists')
        ->whereHas('category', function ($query) {
        $query->where('status', 1); // Assumes 'active' column is used to check if the category is active
        })
        ->where('status', 1)->where('quantity','!=',0)->where('type','popular')
        ->limit(10)
        ->orderBy('product_id', 'asc')
        ->get();



$bestseller = Product::with('images', 'category' ,'wishlists')
        ->whereHas('category', function ($query) {
        $query->where('status', 1)->where('id', '!=',17); // Assumes 'active' column is used to check if the category is active
        })
        ->where('status', 1)->where('quantity','!=',0)->where('product_type','!=','combo')
        ->limit(5)
        ->orderBy('product_id', 'DESC')
        ->get();







        if (Auth::check()) {
            $userId = Auth::id();
            // Attach a 'is_wishlisted' attribute to each product
            foreach ($letestproduct as $product) {
                $product->is_wishlisted = $product->wishlists()->where('user_id', $userId)->exists();
            }
        }
    
      
    //   dd( $letestproduct);
        $brand=Brand::where('status','active')->orderBy('id','DESC')->get();
        
    //   $brand=  Product::with('images', 'category','brand')
    //              ->whereHas('category', function ($query) {
    //                 $query->where('status', 1); // Assumes 'active' column is used to check if the category is active
    //                 })
    //                 ->where('status', 1)
    //                 ->limit(10)
    //                 ->orderBy('product_id', 'DESC')
    //                 ->get();
        
        
        return view('website.index',compact('category','banner','letestproduct','brand','bath','maternity','dalicate','delic','mater','newarrival','babe_care','magical','perfact','library','currentreading','bestseller','combo'));
    }
   public function login()
    {
        // Fetch country codes and prioritize +971 at the top
        $country_codes = DB::table('countries')
            ->select('code')
            ->distinct()
            ->orderByRaw("CASE WHEN code = '+91' THEN 0 ELSE 1 END")
            ->get();

        // Pass the country codes to the view
        return view('website.login', compact('country_codes'));
    }





public function forgetpassword(){

    return view('website.forgetpassword');
}



public function userchangepassword(Request $request){
    // $request->validate([
    //     'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
    // ]);

    $user = User::where('phone',$request->phone)->first();
    if (!$user) {
        return back()->with('error', 'Phone number not found.');
    } 
    //  dd($user);
    $user->password = Hash::make($request->new);
    $user->save();

    return back()->with('success', 'Password updated successfully.');
}


// public function signin(Request $request)
// {
//     try {
//         $request->validate([
//             'phone' => 'required',
//             'country_code' => 'required',
//         ]);
        
//         $input = $request->phone;
//         if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
//             $user = User::where('email', $input)->first();
//             if (!$user) {
//                 return redirect()->route('website.signin')->with('error', __('messages.email_not_found'));
//             }
//         } else {
//             $user = User::where('phone', $input)->where('country_code',$request->country_code)->first();
//             if (!$user) {
//                 return redirect()->route('website.signin')->with('error', __('messages.phone_not_found'));
//             }
//         }
//         if ($user->status !== 'active') {
//             return redirect()->route('website.signin')->with('error', __('messages.account_inactive'));
//         }
//         $otp = rand(1000, 9999); 
//         Otp::where('type', 'phone')->where('user_id', $user->id)->delete();
//         Otp::insert([
//             'type' => 'phone',
//             'value' => $otp,
//             'user_id' => $user->id,
//             'models_type' => 'user',
//         ]);
//         if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
//             // Mail::to($user->email)->send(new OtpMail($otp));
//         } else {
//             // $this->sendSms($user->phone, $otp);
//         }

//         // Here, we pass dynamic type (email or phone) to the message.
//         return redirect()->route('website.phoneverification')->with([
//           // 'message' => __('messages.otp_sent', ['type' => filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone']),
//             'otp' => $otp,
//             'user_id' => $user->id,
//             'phone' => $request->phone,
//             'country_code' => $request->country_code
//         ]);
//     } catch (\Illuminate\Validation\ValidationException $e) {
//         Log::error('Validation errors: ' . json_encode($e->errors()));
//         return redirect()->back()->withErrors(__('messages.validation_error'))->withInput();
//     } catch (\Exception $e) {
//         Log::error('Error during sign-in OTP request: ' . $e->getMessage());
//         return redirect()->route('website.signin')->with('error', __('messages.otp_failed'));
//     }
// }

//   public function signup()
//     {
//         $country_codes = DB::table('countries')
//         ->select('code')
//         ->distinct()
//         ->orderByRaw("CASE WHEN code = '+91' THEN 0 ELSE 1 END")
//         ->get();
//         return view('website.signup', compact('country_codes'));
//     }
//  public function store(Request $request)
// {
//     try {
//         // Validate the incoming request
//         $validatedData = $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => [
//                 'required',
//                 'email',
//                   Rule::unique('users')->whereNull('deleted_at'),
//             ],
//             'phone' => [
//                 'required',
//                 'digits_between:8,15',
//                 Rule::unique('users')->whereNull('deleted_at'),
//             ],
//             'country_code' => 'required|string',
//             'whatsapp_country_code' => 'nullable|string',
//             'whatsapp' => 'nullable|numeric|digits_between:10,15',
//             'terms' => 'required|accepted',
//             'fcm_token' => 'nullable|string',
//         ]);

//         // Check if a soft-deleted user exists with the same phone or email
//         $softDeletedUser = User::onlyTrashed()
//             ->where('phone', $request->phone)
//             ->orWhere('email', $request->email)
//             ->first();

//         if ($softDeletedUser) {
//             // Soft deleted user exists, create a new entry instead of restoring it
//             $newUser = User::create([
//                 'name' => $validatedData['name'],
//                 'email' => $validatedData['email'],
//                 'phone' => $validatedData['phone'],
//                 'country_code' => $validatedData['country_code'],
//                 'whatsapp' => $validatedData['whatsapp'] ?? null,
//                 'whatsapp_country_code' => $validatedData['whatsapp_country_code'] ?? null,
                
//                 'status' => 'active',  // User is active until OTP verification
//             ]);
//         } else {
//             // Create a new user if no soft-deleted record exists
//             $newUser = User::create([
//                 'name' => $validatedData['name'],
//                 'email' => $validatedData['email'],
//                 'phone' => $validatedData['phone'],
//                 'country_code' => $validatedData['country_code'],
//                 'whatsapp' => $validatedData['whatsapp'] ?? null,
//                 'whatsapp_country_code' => $validatedData['whatsapp_country_code'] ?? null,
//               'fcm_token' => $validatedData['fcm_token'],
//                 'status' => 'active', 
//             ]);
//         }

//         // Generate and store OTP
//         $otp = rand(1000, 9999);

//         // Remove any previous OTPs for this user
//         Otp::where('type', 'registration')
//             ->where('user_id', $newUser->id)
//             ->delete();

//         // Store the new OTP
//         Otp::create([
//             'type' => 'registration',
//             'value' => $otp,
//             'user_id' => $newUser->id,
//             'models_type' => User::class,  // Store model reference correctly
//         ]);

//         // Redirect with success message and OTP data
//         return redirect()->route('website.phoneverification')->with([
//          //   'message' => 'OTP sent successfully to your ' . 
//                          (filter_var($validatedData['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone number'),
//             'otp' => $otp,
//             'user_id' => $newUser->id,
//             'phone' => $validatedData['phone'],
//             'country_code' => $validatedData['country_code'],
//         ]);

//     } catch (\Illuminate\Validation\ValidationException $e) {
//         // Log validation errors
//         Log::error('Validation errors: ' . json_encode($e->errors()));

//         return redirect()->back()
//             ->withErrors($e->errors())
//             ->withInput();
//     } catch (\Exception $e) {
//         dd($e);
//         // Handle unexpected errors
//         Log::error('User registration failed: ' . $e->getMessage());

//         return redirect()->back()
//             ->with('error', 'An unexpected error occurred. Please try again later.')
//             ->withInput();
//     }
// }


public function signin(Request $request)
{
    try {
        $request->validate([
            'phone' => 'required',
            'country_code' => 'required', // ✅ Make sure this is required if your DB uses it
            'password' => 'required',
        ]);

        $user = User::where('phone', $request->phone)
                    ->where('country_code', $request->country_code)
                  //  ->where('password', $request->password)
                    ->first();

        if (!$user) {
            return redirect()->route('website.signin')->with('error', __('messages.invalid_credentials'));
        }

          if (!$user || !Hash::check($request->password, $user->password)) {
                return redirect()->route('website.signin')->with('error', __('messages.invalid_credentials'));
            }

        Auth::login($user); // ✅ Make sure to actually log the user in

        return redirect()->route('website.index')->with('message', __('messages.login_successful'));

    } catch (\Illuminate\Validation\ValidationException $e) {
        dd($e);
        Log::error('Validation errors: ' . json_encode($e->errors()));
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
         dd($e);
        Log::error('Error during sign-in: ' . $e->getMessage());
        return redirect()->route('website.signin')->with('error', __('messages.login_failed'));
    }
}




  public function signup()
    {
        $country_codes = DB::table('countries')
        ->select('code')
        ->distinct()
        ->orderByRaw("CASE WHEN code = '+91' THEN 0 ELSE 1 END")
        ->get();
        return view('website.signup', compact('country_codes'));
    }
    
    public function store(Request $request)
{
    try {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'phone' => [
                'required',
                'digits_between:8,15',
                Rule::unique('users')->whereNull('deleted_at'),
            ],
            'country_code' => 'required|string',
            'whatsapp_country_code' => 'nullable|string',
            'whatsapp' => 'nullable|numeric|digits_between:10,15',
            'terms' => 'required|accepted',
            'fcm_token' => 'nullable|string',
        ]);

        // Check for soft-deleted user
        $softDeletedUser = User::onlyTrashed()
            ->where('phone', $request->phone)
            ->orWhere('email', $request->email)
            ->first();

        $userData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']), // ✅ Hash the password
            'country_code' => $validatedData['country_code'],
            'whatsapp' => $validatedData['whatsapp'] ?? null,
            'whatsapp_country_code' => $validatedData['whatsapp_country_code'] ?? null,
            'fcm_token' => $validatedData['fcm_token'] ?? null,
            'status' => 'active',
        ];

        // Create user
        $newUser = User::create($userData);

        // Optional: Remove OTP code if not needed
        // Otp::where('type', 'registration')->where('user_id', $newUser->id)->delete();
        // Otp::create([
        //     'type' => 'registration',
        //     'value' => rand(1000, 9999),
        //     'user_id' => $newUser->id,
        //     'models_type' => User::class,
        // ]);

        return redirect()->route('website.signin')->with('success', 'Registration successful. Please log in.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation errors: ' . json_encode($e->errors()));

        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput();
    } catch (\Exception $e) {
        Log::error('User registration failed: ' . $e->getMessage());

        return redirect()->back()
            ->with('error', 'An unexpected error occurred. Please try again later.')
            ->withInput();
    }
}


     public function aboutus()
    {
        $page=Pages::where('slug','about-us-home-page')->first();
        return view('website.about_us',compact('page'));
    }
     public function privacypolicy()
    {
        $page=Pages::where('slug','privacy_policy')->first();
        return view('website.privacypolicy',compact('page'));
    }
    public function tremscondition()
    {
        $page=Pages::where('slug','terms-and-conditions')->first();
        return view('website.tremscondition',compact('page'));
    }
    public function faq()
    {
        $faq=Faq::orderBy('id','desc')->where('status','active')->get();
        //dd($faq);
        return view('website.faq',compact('faq'));
    }
    public function contactus()
    {
        return view('website.contactus');
    }
    public function cart()
    {
        return view('website.cart');
    }
     public function sendMessage(Request $request)
        {
            try {
                if (!Auth::check()) {
                    return redirect()->route('website.signin')->with('error', 'please first login.');
                }
                // dd($request);die;
                // Validate the input
                $request->validate([
                    'name' => 'required|string|max:255',
                   'email' => [
                                'required',
                                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                                'max:70'
                            ],
                                                'subject' => 'required|string|max:255',
                                                'description' => 'required|string',
                                            ]);
                                            $messages = [
                            
                                'email.required' => 'The email field is required.',
                                'email.regex' => 'Please enter a valid email address.',
                                'email.max' => 'The email cannot be longer than 70 characters.',
                            
                            ];
 
                $contact = ContactUs::create([
                    'user_id' => auth()->id() ?? null, // Authenticated user ID or null for guests
                    'name' => $request->name,
                    'email' => $request->email,
                    'subject' => $request->subject,
                    'description' => $request->description,
                    'replay' => null, // Leave blank until admin replies
                ]);
                // Prepare email data
                $contactData = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'subject' => $request->subject,
                    'description' => $request->description,
                ];
                // Send email to admin
                Mail::to('gomommy18@gmail.com')->send(new ContactUsMail($contactData));
                
                return redirect()->back()->with('success', 'Your message has been sent successfully');
            } catch (\Illuminate\Validation\ValidationException $e) {
                dd($e);
                    Log::error('Validation errors: ' . json_encode($e->errors()));
                    return redirect()->back()->withErrors($e->errors())->withInput();
                        }
        }
    ///////////////////////////////////
   public function brand()
   {
    $brand = Brand::where('status', 'active')->orderBy('id', 'DESC')->get();
    return view('website.brand', compact('brand'));
    }
    /////////////////////////////////////////////////////
    public function phoneverification()
    {
        return view('website.phoneverification');
    }
    /////////////////////////////////////////////
  public function order(Request $request)
{ 
    $user = Auth::user();

    // Initialize the query builder for orders
    $query = CartOrderSummary::where('user_id', $user->id)
        ->with([
            'cartItems.product.images', // Include product images
            'productReturnOrders.refund', // Include refunds
            'productReturnOrders.reason'  // Include return reasons
        ]);
        
    // Apply filter if status is selected
    if ($request->has('status')) {
        
        $status = $request->input('status');
        $statusArray = explode(',', $status); // Split comma-separated string into an array

        // Make sure to clean up the array and filter any unwanted empty values
        $statusArray = array_filter($statusArray, function($value) {
            return in_array($value, ['delivered', 'cancelled', 'refunded', 'pending', 'processing', 'shipped', 'return']);
        });

        // Apply the filter to the query
        if (count($statusArray) > 0) {
            
            $query->whereIn('order_status', $statusArray);
        }
    }

    // Get filtered orders sorted by the latest order first
    $orders = $query->orderBy('created_at', 'desc')->get();
    //dd($orders);
    // foreach ($orders as $order) {
    //     if ($order->tracking_id) { // Ensure order has a tracking ID
    //         $order->tracking_status = $this->getFedExTrackingStatus($order->tracking_id);

    //     }
    // }
     //dd($orders);
    // dd($orders);
    if ($request->ajax()) {
        return response()->json(['orders' => $orders]);
    }

    return view('website.order', compact('user', 'orders'));
}

private function getFedExTrackingStatus($trackingNumber)
{
    try {
        $accessToken = app(FedExService::class)->getAccessToken(); // Get FedEx API Token
        $fedexApiUrl = "https://apis.fedex.com/track/v1/trackingnumbers"; // FedEx Tracking API

        $client = new \GuzzleHttp\Client();

        $body = [
            "trackingInfo" => [
                [
                    "trackingNumberInfo" => [
                        "trackingNumber" => 794970845067
                    ]
                ]
            ],
            "includeDetailedScans" => true // Get all status updates
        ];

        $response = $client->post($fedexApiUrl, [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json'
            ],
            'json' => $body
        ]);
        dd($response);
        $result = json_decode($response->getBody(), true);
        \Log::info('FedEx Tracking Response:', $result); // Log for debugging

        // ✅ Extract tracking status details
        if (!empty($result['output']['completeTrackResults'][0]['trackResults'][0])) {
            return $result['output']['completeTrackResults'][0]['trackResults'][0]['latestStatusDetail']['statusByLocale'] ?? "Unknown";
        }

        \Log::error('FedEx Tracking Error: No status found.', $result);
        return "Tracking status not available";

    } catch (\Exception $e) {
        \Log::error('FedEx Tracking API Error: ' . $e->getMessage());
        return "Tracking error";
    }
}

    ////////////////////////////////////
public function orderDetail($order_id, $product_id)
{
    try {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to access your orders.');
        }
        $product = Product::where('product_id', $product_id)->first();
        // Fetch order details with only the specific product
        $order = CartOrderSummary::where('id', $order_id)
    ->where('user_id', $user->id)
    ->with([
        'cartItems' => function ($query) use ($product) {
            $query->where('product_sku', $product->sku)
                ->with([
                    'product.images',
                    'product.category',
                    'product.brand',
                    'product.variants' => function ($variantQuery) {
                        $variantQuery->select('variant_id', 'product_id', 'color', 'size'); // Include color & size
                    },
                    'product.productReturnOrders.refund',
                    'product.productReturnOrders.reason',
                    'product.productRatings',
                ]);
        },
    ])
    ->firstOrFail();


        // Ensure the cart item with the specific product exists in the order
        $cartItem = $order->cartItems->first();
        if (!$cartItem) {
            return redirect()->back()->with('error', 'Product not found in the specified order.');
        }

        $product = $cartItem->product;

        // Add formatted dates
        $order->ordered_date = $order->created_at->format('jS M Y');
        $order->delivered_date = $order->delivered_at ? $order->delivered_at->format('jS M Y') : 'Pending';

        // Fetch product return details, if any
        $productReturnOrder = ProductReturnOrder::where('order_id', $order_id)
            ->where('product_id', $product_id)
            ->where('user_id', $user->id)
            ->first();

        // Get available return reasons
        $reason = ReturnReason::where('status', 'active')->get();

        // Fetch product rating if available
        $productRating = ProductRating::where('product_id', $product_id)
        ->where('order_id', $order_id)
            ->where('user_id', $user->id)
            ->first();

        return view('website.orderdetail', compact('user', 'order', 'reason', 'product', 'productReturnOrder', 'productRating'));
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        Log::warning('Order or Product not found: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Order or product not found.');
    } catch (\Exception $e) {
        dd($e);
        Log::error('Order Detail Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Unable to fetch order details. Please try again later.');
    }
}



/////////////////////// product invoice////////////////////////
public function downloadInvoice($order_id, $product_id)
{
    try {
        $user = Auth::user();
  $product = Product::findOrFail($product_id);
        // Fetch the order details
         $order = CartOrderSummary::with(['cartItems.product'])
            ->where('id', $order_id)
            ->where('user_id', $user->id)
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
        dd($e);
        // Handle exceptions
        return redirect()->back()->with('error', 'Unable to generate the invoice. Please try again later.');
    }
}


/////////////////////////////product return///////////////////////////////
public function productreturn(Request $request)
    {
      
        // Validate the incoming data
        $request->validate([
            'order_id' => 'required|integer|exists:cart_order_summary,id',
            'product_id' => 'required|integer|exists:products,product_id',
            'user_id' => 'required|integer|exists:users,id',
            'reason_id' => 'required|integer|exists:return_reasons,id',
            'return_comments' => 'nullable|string|max:255',
        ]);

        try {
            // Save the product return order
            $returnOrder = ProductReturnOrder::create([
                'order_id' => $request->input('order_id'),
                'product_id' => $request->input('product_id'),
                'user_id' => $request->input('user_id'),
                'reason_id' => $request->input('reason_id'),
                'return_status' => 'Pending', // Default status
                'return_comments' => $request->input('return_comments'),
            ]);

            // Redirect with success message
            return redirect()->back()->with('success', 'Return request submitted successfully.');

        } catch (\Exception $e) {
            // Handle exceptions
            return redirect()->back()->with('error', 'An error occurred while submitting the return request.');
        }
    }
/////////// addreview 
    public function addreview(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'required|exists:products,product_id', // Make sure the product exists
            'rating' => 'required|integer|min:1|max:5',         // Ensure the rating is between 1 and 5
            'review' => 'nullable|string|min:3|max:250',        // Review is optional but must be a string if provided
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the user has already rated this product
        $existingRating = ProductRating::where('product_id', $request->product_id)
                                        ->where('order_id', $request->order_id)
                                        ->where('user_id', $user->id)
                                        ->first();

        if ($existingRating) {
            return redirect()->back()->with('error', 'You have already rated this product.');
        }

        // Create a new rating record
        ProductRating::create([
            'product_id' => $request->product_id,
            'user_id' => $user->id,
            'order_id'=>$request->order_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Your review and rating have been submitted!');
    }
    ///////////my address all function///////////
     public function myaddress()
    {
        $user = Auth::user();
         $addresses = UserAddress::where('user_id', $user->id)->get();
        return view('website.myaddress',compact('user','addresses'));
    }
   public function addnewaddress()
    {
        $user = Auth::user();
   $country_codes = DB::table('countries')
        ->select('code')
        ->distinct()
        ->orderByRaw("CASE WHEN code = '+91' THEN 0 ELSE 1 END")
        ->get();
        return view('website.addnewaddress',compact('user','country_codes'));
    }
    public function editaddress($id)
    {
        $user = Auth::user();
        $country_codes = DB::table('countries')
        ->select('code')
        ->distinct()
        ->orderByRaw("CASE WHEN code = '+91' THEN 0 ELSE 1 END")
        ->get();
        $address = UserAddress::where('user_id', $user->id)->where('id', $id)->first();        
        return view('website.editaddress',compact('user','address','country_codes'));
    }
   public function updateaddress(Request $request, $id)
{
    try {
        $request->validate([
            'name' => 'required|min:2|max:50',
            'address' => 'required|min:5|max:150',
            'phone' => 'required|digits_between:10,15',
            'house_number' => 'required|min:1|max:50',
            'street_name' => 'required|min:3|max:100',
            'city' => 'required|min:2|max:50',
            'country' => 'required|min:2|max:50',
            'country_code' => 'required',
            'zip_code' => 'required|digits_between:5,10',
        ]);

        $user = Auth::user();
        $address = UserAddress::where('user_id', $user->id)->where('id', $id)->first();

        if (!$address) {
            return redirect()->route('website.myaddress')->with('error', 'Address not found.');
        }

        // Handle default address
        if ($request->has('make_as_default') && $request->make_as_default == 1) {
            UserAddress::where('user_id', $user->id)
                ->where('make_as_default', 1)
                ->update(['make_as_default' => 0]);
        }

        // Update the address
        $address->update([
            'name' => $request->name,
            'address' => $request->address,
            'mobile' => $request->phone,
            'house_number' => $request->house_number,
            'street_name' => $request->street_name,
            'landmark' => $request->landmark,
            'city' => $request->city,
            'country' => $request->country,
            'country_code' => $request->country_code,
            'zip_code' => $request->zip_code,
            'make_as_default' => $request->has('make_as_default') ? 1 : 0,
        ]);

        return redirect()->route('website.myaddress')->with('success', 'Address updated successfully.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        dd($e);
        return redirect()->back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        return redirect()->route('website.myaddress')->with('error', 'Something went wrong. Please try again later.');
    }
}

   public function saveAddress(Request $request)
{
    // dd($request);die;
    // Validate the incoming request
    $request->validate([
    'name' => 'required|min:2|max:50',

    'address' => 'required|min:5|max:255',

    'mobile' => [
        'required',
        'digits_between:10,15', // Ensure it has digits between 10 and 15
        'regex:/^\d+$/' // Ensure it contains only digits
    ],

    'house_number' => 'required|min:1|max:50',

    'street_name' => 'required|min:3|max:100',

    'city' => 'required|min:2|max:100',

    'country' => 'required|min:2|max:100',

    'zip_code' => [
        'required',
        'digits_between:5,10', // Ensure it has between 5 and 10 digits
        'regex:/^\d+$/' // Ensure it contains only digits
    ],
]);

    // dd($request->all());
    try {
        // Get the authenticated user
        $user = Auth::user();
        $existingAddresses = UserAddress::where('user_id', $user->id)->count();

        // Determine the default status
        $makeAsDefault = $existingAddresses === 0 || $request->input('make_as_default', false);

        if ($makeAsDefault) {
            // Reset other default addresses if this address is to be default
            UserAddress::where('user_id', $user->id)->update(['make_as_default' => 0]);
        }

        // Create the new address
        $useraddress = UserAddress::create([
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'user_id' => $user->id,
            'address'=>$request->input('address'),
            'name'=>$request->input('name'),
            'country_code'=>$request->input('country_code'),
            'house_number' => $request->input('house_number'),
            'street_name' => $request->input('street_name'),
            'zip_code' => $request->input('zip_code'),
            'landmark' => $request->input('landmark'),
            'country' => $request->input('country'),
            'mobile_number' => $request->input('mobile'),
            'make_as_default' => $makeAsDefault ? 1 : 0,
        ]);
        if($request->ordersummary==1)
        {
              return redirect()->back()->with('success', 'Address saved successfully.');
        }
        else{
            return redirect()->route('website.myaddress')->with('success', 'Address saved successfully.');
        }
        
    } catch (\Exception $e) {
        // Log the error message
        Log::error('Error saving address: ' . $e->getMessage());

        // Return error message to the user
        return back()->withErrors(['error' => 'An error occurred while saving the address. Please try again.']);
    }
}
public function deleteaddress($id)
{
    $user = Auth::user();
    // Find the address associated with the authenticated user
    $address = UserAddress::where('user_id', $user->id)->where('id', $id)->first();
    if (!$address) {
        // Address not found, return an error message
        return redirect()->route('website.myaddress')->with('error', 'Address not found.');
    }
    if ($address->make_as_default) {
        // If the address to be deleted is the default one, set another address as default
        $nextAddress = UserAddress::where('user_id', $user->id)->where('id', '!=', $id)->first();
        if ($nextAddress) {
            $nextAddress->update(['make_as_default' => 1]);
        }
    }
    // Delete the address
    $address->delete();
    // Redirect back with a success message
    return redirect()->route('website.myaddress')->with('success', 'Address deleted successfully.');
}
//////////////////////////////////////////////////
    public function mysavecard()
    {
        $user = Auth::user();
        return view('website.mysavecard',compact('user'));
    }
    public function addnewcard()
    {
        $user = Auth::user();
        return view('website.addnewcard',compact('user'));
    }
   
   public function rating()
{
    $user = Auth::user();
    $productrating = ProductRating::where('user_id', $user->id)
                                  ->with('product', 'product.images')
                                  ->get();

    return view('website.rating', compact('user', 'productrating'));
}

  public function wishlist(Request $request)
{
    $user = Auth::user();
    $userId = $user->id;

    // Get the current page or default to 1
    $currentPage = $request->input('page', 1);
    $perPage = 8;

    // Fetch wishlist items with products having status = 1
    $wishlistItemsQuery = Wishlist::with(['product.images'])
        ->where('user_id', $userId)
        ->whereHas('product', function ($query) {
            $query->where('status', 1);  // Exclude inactive products
        });

    // Paginate only active products
    $wishlistItems = $wishlistItemsQuery->paginate($perPage);

    // If the current page is empty after deletion, redirect to the previous page
    if ($wishlistItems->isEmpty() && $currentPage > 1) {
        return redirect()->route('website.wishlist', ['page' => $currentPage - 1]);
    }

    // Check if each product is in the cart and set cart details
    foreach ($wishlistItems as $item) {
        if (isset($item->product)) {
            $cartItem = Cart::where('user_id', $userId)
                ->where('product_sku', $item->product->sku)
                ->where('orderplace', 0)
                ->first();

            $item->is_in_cart = $cartItem ? true : false;
            $item->cart_quantity = $cartItem ? $cartItem->quantity : 0;
        }
    }

    return view('website.wishlist', compact('user', 'wishlistItems'));
}

 public function branddetail(Request $request, $id)
{
    try {
        $decodedId = base64_decode($id);
        $brand = Brand::where('id', $decodedId)->firstOrFail();
        $color = Color::get();
        $size = Size::get();

        $min_price = Product::where('status', 1)->min('base_price');
        $max_price = Product::where('status', 1)->max('base_price');

        // Build product query
        $products = Product::with('images', 'variants', 'wishlists', 'category')
            ->where('brand_id', $decodedId)
            ->where('status', 1)
            ->whereHas('category', fn($query) => $query->where('status', 1));

        // Apply Age Group Filter
        if ($request->filled('age_group')) {
            $ageGroups = explode(',', $request->input('age_group'));
            $products->whereHas('variants', fn($query) => $query->whereIn('size', $ageGroups));
        }

        // Apply Color Filter
        if ($request->filled('colors')) {
            $colors = explode(',', $request->input('colors'));
            $products->whereHas('variants', fn($query) => $query->whereIn('color', $colors));
        }

        // Apply Price Filters
        if ($request->filled('price_min')) {
            $products->where('base_price', '>=', (int)$request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $products->where('base_price', '<=', (int)$request->input('price_max'));
        }

        $products = $products->paginate(9)->appends($request->query());

        // Handle Wishlist and Ratings
        if (Auth::check()) {
            $userId = Auth::id();
            foreach ($products as $product) {
                $productRating = ProductRating::where('product_id', $product->product_id)->avg('rating');
                $product->rating = number_format($productRating, 1);
                $product->is_wishlisted = $product->wishlists()->where('user_id', $userId)->exists();
            }
        }

        return view('website.branddetail', compact('brand', 'products', 'size', 'color', 'min_price', 'max_price'));

    } catch (\Exception $e) {
        \Log::error('Error in branddetail method: ' . $e->getMessage(), ['stack_trace' => $e->getTraceAsString()]);
        return redirect()->route('website.index')->with('error', 'Something went wrong while fetching the brand details.');
    }
}

////////////////////////////////////////////////////

    public function verifyOtp(Request $request)
    {
        // Get input values
        $user_id = $request->input('user_id');
        $phone = $request->input('phone');
        $country_code = $request->input('country_code');
        $inputOtp = implode('', $request->otp);  // Concatenate OTP input

        // Find OTP record
        $otpRecord = Otp::where('value', $inputOtp)->first();

        // If OTP is invalid or expired
        if (!$otpRecord || $otpRecord->isExpired()) {
            return redirect()->back()->with([
                'error' => 'Invalid or expired OTP.',
                'user_id' => $user_id,
                'phone' => $phone,
                'country_code' => $country_code,
            ]);
        }

        // Get user and login
        $user = User::find($user_id);
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        Auth::login($user);
        // dd($user->fcm_token);
        // Send Push Notification
       

        // Redirect to homepage on successful login
        return redirect()->route('website.index')->with('success', 'Login Successful');
    }
/////////////////////////////////////////
public function signOut()
{
    Auth::logout();
    return redirect()->route('website.index')->with('success', 'You have been logged out successfully.');
}
/////////////////////////////////
public function resendOtp(Request $request)
{
    $user_id = $request->input('user_id');
    $phone = $request->input('phone');
    $country_code = $request->input('country_code');
    if (empty($user_id)) {
        return redirect()->route('website.signin')->with([
            'error','Your session has expired. Please log in again.',
        ]);
    }
    $otp = rand(1000, 9999); 
    Otp::where('type', 'phone')->where('user_id', $user_id)->delete();
    Otp::insert([
        'type' => 'phone', 
        'value' => $otp, 
        'user_id' => $user_id, 
        'models_type' => 'user'
    ]);
    // Redirect back with success message and new data
    return redirect()->back()->with([
        'success' => 'A new OTP has been sent to your email/phone.',
        'otp' => $otp,
        'user_id' => $user_id,
        'phone' => $phone,
        'country_code' => $country_code,
    ]);
}
//////////////////////////////////////
public function myprofile()
{
    $user = Auth::user();
    return view('website.myprofile',compact('user'));
}
public function productdetail(Request $request, $id)
{
    try {
        $user = Auth::user();
        $userId = Auth::id();
        $size_id = $request->input('size_id');
        $color_id = $request->input('color_id');

        // Fetch product with related data
        $products = Product::with([
            'images', 'wishlists',
            'brand' => function ($query) {
                $query->where('status', 'active');
            },
            'offers' => function ($query) {
                $query->where('status', 'active');
            }
        ])->where('status', 1)->where('sku', $id)->first();

        if (!$products) {
            return redirect()->route('website.index')->with('error', 'Product not found.');
        }

        // Fetch product variants (size & color)
        $productvariant = ProductVariant::where('product_id', $products->product_id)->get();
        //dd($productvariant);
        // If no size or color is selected, use the first available variant
        if (!$size_id || !$color_id) {
            $firstVariant = $productvariant->first();
            $size_id = $firstVariant->size ?? null;
            $color_id = $firstVariant->color ?? null;
        }

        // Check if product is already in cart with the selected size & color
        $is_already_cart = false;
        if ($size_id && $color_id) {
            $is_already_cart = Cart::where('user_id', $userId)
                ->where('product_sku', $products->sku)
               // ->where('product_color', $color_id)
               // ->where('product_size', $size_id)
                ->whereNull('order_id')
                ->exists();
        }

        // Check if the product is wishlisted
        if (Auth::check()) {
            $products->is_wishlisted = $products->wishlists()->where('user_id', $userId)->exists();
        }

        // Calculate product rating
        $productrating = ProductRating::where('product_id', $products->product_id)->avg('rating');
        $products->rating = number_format($productrating, 1);

        // Add color and size details to product variants
        foreach ($productvariant as $variant) {
            $color= Color::find($variant->color);
            $size = Size::find($variant->size);
            $variant->color_code = $color->hex_code ?? 'N/A';
            $variant->color_name = $color->color_name ?? 'N/A';
            $variant->size_name = $size->name ?? 'N/A';
            $variant->size_name_ar = $size->name_ar ?? 'N/A';
            $variant->size_name_cku = $size->name_cku ?? 'N/A';
            $variant->color_id = $color->id ?? null;
            $variant->size_id = $size->id ?? null;
        }

        // Fetch related products (latest 4 excluding current product)
        $relatedProducts = Product::with('images')
            ->where('sku', '<>', $id)
            ->where('status', 1)
            ->orderBy('product_id', 'DESC')
            ->limit(4)
            ->get();

        // Add wishlist and rating details for related products
        if (Auth::check()) {
            foreach ($relatedProducts as $prod) {
                $prod->rating = number_format(ProductRating::where('product_id', $prod->product_id)->avg('rating'), 1);
                $prod->is_wishlisted = $prod->wishlists()->where('user_id', $userId)->exists();
            }
        }

        // Fetch product reviews
        $ProductRating = ProductRating::with('user')->where('product_id', $products->product_id)->get();

        return view('website.productdetail', compact('products', 'productvariant', 'relatedProducts', 'ProductRating', 'is_already_cart'));
    } catch (\Exception $e) {
        \Log::error('Error in productdetail method: ' . $e->getMessage());
        return redirect()->route('website.index')->with('error', 'An error occurred while fetching product details. Please try again later.');
    }
}


public function categoryproductlist(Request $request, $id)
{
    try {
        
        // Fetch all sizes, colors, and the maximum price of products
        $size = Size::all();
        $color = Color::all();
        $maxPrice = Product::max('base_price');
        $minPrice = Product::min('base_price');
        $category = Category::where('id', $id)->first();
        $cat_id = $request->input('category_id');

        // Initialize the product query
        $productsQuery = Product::with('images', 'variants', 'wishlists')->where('status', 1);

        // Apply category and subcategory filters
        if (!empty($cat_id)) {
            // If category ID is provided, filter by sub_category_id
            $productsQuery->where('sub_category_id', $cat_id);
        } elseif ($category) {
            // If no subcategory ID is provided, show products for the selected category
            $productsQuery->where(function ($query) use ($id) {
    $query->whereNotNull('sub_category_id')->where('sub_category_id', $id)
          ->orWhereNull('sub_category_id')->where('category_id', $id);
});
        }

        // Filter by price range
        if ($request->has('price_min') && !is_null($request->input('price_min'))) {
            $productsQuery->where('base_price', '>=', (int) $request->input('price_min'));
        }

        if ($request->has('price_max') && !is_null($request->input('price_max'))) {
            $productsQuery->where('base_price', '<=', (int) $request->input('price_max'));
        }

        // Filter by brand
        if ($request->has('brands') && !is_null($request->input('brands'))) {
            // Get the brands input, split by comma, and convert to an array
            $brands = is_array($request->input('brands')) 
                ? $request->input('brands') 
                : explode(',', $request->input('brands'));

            // Filter products by the provided brand IDs
            $productsQuery->whereIn('brand_id', $brands);
        }

        // Apply filters to product variants
        $productsQuery->whereHas('variants', function ($query) use ($request) {
            // Filter by age group
            if ($request->has('age_group') && !empty($request->input('age_group'))) {
                $ageGroups = is_array($request->input('age_group'))
                    ? $request->input('age_group')
                    : explode(',', $request->input('age_group'));

                $query->whereIn('size', $ageGroups);
            }

            // Filter by colors
            if ($request->has('colors') && !empty($request->input('colors'))) {
                $colors = is_array($request->input('colors'))
                    ? $request->input('colors')
                    : explode(',', $request->input('colors'));

                $query->whereIn('color', $colors);
            }
        });

        // Paginate the result
        $products = $productsQuery->paginate(15);

        // Check if user is logged in and get wishlist and ratings
        if (Auth::check()) {
            $userId = Auth::id();
            foreach ($products as $product) {
                $productrating = ProductRating::where('product_id', $product->product_id)->avg('rating');
                $formattedRating = number_format($productrating, 1);
                $product->rating = $formattedRating;
                $product->is_wishlisted = $product->wishlists()->where('user_id', $userId)->exists();
            }
        }

        // Fetch the relevant category and brand data
        $category = Category::where('category_id', $id)->get(); // Fixed to fetch by 'id'
        $brand = Brand::where('status', 'active')->orderBy('id', 'DESC')->get();

        // Return the view with the required data
        return view('website.categoryproductlist', compact('size', 'color', 'products', 'category', 'brand', 'maxPrice','minPrice'));

    } catch (\Exception $e) {
        Log::error('Error fetching category product list: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching the products. Please try again later.');
    }
}

//////////////////////////////////////////////////
public function myprofileupdate(Request $request)
{
    // Get the authenticated user
    $user = Auth::user();
    // Validation rules
    $request->validate([
        'name' => 'required|string|max:50',
         'email' => 'nullable|email:rfc,dns|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
        'whatsapp' => 'nullable|digits_between:10,15',
    ]);
// dd($request->all());
    try {
        // Update user data only if provided
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email') ?: $user->email, // Keep existing email if not updated
            'whatsapp' => $request->input('whatsapp'),
        ]);

        // Redirect to profile page with success message
        return redirect()->route('website.myprofile')->with('success', 'Profile updated successfully!');
    } catch (\Exception $e) {
        dd($e);
        // Log the error
        \Log::error('Error updating profile: ' . $e->getMessage());
        
        // Redirect with error message
        return redirect()->back()->with('error', 'An error occurred while updating your profile.');
    }
}
//////////////////////////////////////////////
// public function Blog(Request $request)
// {
//     $blog = Blog::where('status','active')->get();
//     return view('website.blog',compact('blog'));
// }

public function Blog(Request $request)
{
    // Load only 6 blogs at a time
    $blog = Blog::where('status', 'active')
                ->latest()
                ->paginate(6);

    if ($request->ajax()) {
        // Return only the blog items when AJAX is used
        return view('website.partials.blog_list', compact('blog'))->render();
    }

    return view('website.blog', compact('blog'));
}

public function blogview($id)
{
    try {
        $decodedId = base64_decode($id);

        // Check if the decoded ID is a valid numeric value
        if (!is_numeric($decodedId)) {
            return redirect()->route('website.blog')->with('error', 'Invalid blog ID.');
        }

        // Find the specific blog by decoded ID
        $blog = Blog::find($decodedId);

        if (!$blog) {
            return redirect()->route('website.blog')->with('error', 'Blog not found.');
        }

        // Fetch related blogs, excluding the current blog
        $relatedblog = Blog::where('id', '!=', $decodedId)
                            ->where('status', 'active')
                            ->limit(4)
                            ->get();

        return view('website.blogdetail', compact('blog', 'relatedblog'));
    
    } catch (\Exception $e) {
        \Log::error('Error fetching blog: ' . $e->getMessage());
        return redirect()->route('website.blog')->with('error', 'Something went wrong. Please try again.');
    }
}

/////////////////////////////////////////////////////////
public function search(Request $request)
{
    $query = $request->input('query');
    $products = Product::with('images','category','brand')->where('status', 1)
    ->whereHas('category', function ($query) {
        $query->where('status', 1); // Assumes 'active' column is used to check if the category is active
        })
        ->where('product_name', 'like', '%' . $query . '%')
        ->paginate(8); 
         if (Auth::check()) {
            $userId = Auth::id();
            // Attach a 'is_wishlisted' attribute to each product
            foreach ($products as $product) {
                $productrating=ProductRating::where('product_id',$product->product_id)->avg('rating');
        $formattedRating = number_format($productrating, 1);
        $products->rating=$formattedRating;
                $product->is_wishlisted = $product->wishlists()->where('user_id', $userId)->exists();
            }
        }
    return view('website.search', compact('products', 'query'));
}
///////////////////////////////////////////////////////////////////
public function deeplink(Request $request) 
{
    
    $iosAppId = 'com.example.my_babe'; 
    $androidPackageName = 'com.example.my_babe'; 
    $userAgent = "Android";
    if (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
       
        $appSchemeUrl = 'myapp://'; 
        $storeUrl = "https://apps.apple.com/app/id{$iosAppId}"; 
    } elseif (strpos($userAgent, 'Android') !== false) {
       
        $appSchemeUrl = "intent://#Intent;scheme=myapp;package={$androidPackageName};end"; 
        $storeUrl = "https://play.google.com/store/apps/details?id={$androidPackageName}"; 
    } else {
       
        $appSchemeUrl = 'https://play.google.com/store';
        $storeUrl = "https://play.google.com/store/apps/details?id={$androidPackageName}";
    }
    return view('deep-link', [
        'storeUrl' => $storeUrl,
        'appSchemeUrl' => $appSchemeUrl,
    ]);
}
//////////////////////////////////////////////////////////
//Wishlist Product one click wishlist add and second time add remove function


public function productwishlist(Request $request)
{
    if (!Auth::check()) {
        return response()->json(['message' => 'Please login to add product to wishlist.'], 401); // Correct status code
    }
    $product_id = $request->input('product_id');
    $user_id = Auth::user()->id;
    $wishlist = Wishlist::where('user_id', $user_id)->where('product_id', $product_id)->first();
    if ($wishlist) {
        $wishlist->delete();
        return response()->json(['status' => 'removed', 'message' => 'Product removed from wishlist successfully.'], 200);
    } else {
        $wishlist = new Wishlist();
        $wishlist->user_id = $user_id;
        $wishlist->product_id = $product_id;
        $wishlist->save();
        return response()->json(['status' => 'added', 'message' => 'Product added to wishlist successfully.'], 200);
    }
}
////////////

//////////////////////////////////////
//  product cart one click cart add and second time add remove function try catch
public function productcart($sku ,Request $request)
{
    $sizeId = $request->query('size_id');
    $colorId = $request->query('color_id');
    //   dd($sizeId.'-------->'.$colorId);
    
    try {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to add products to your cart.');
        }
        // Fetch the product by SKU
        $product = Product::where('sku', $sku)->where('status', 1)->first();
        // If product doesn't exist
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }
        // Get the authenticated user's ID
        $user_id = Auth::id();
        // Check if the product is already in the cart
        $cart = Cart::where('user_id', $user_id)->where('product_sku', $sku)->where('product_color',$colorId)->where('product_size',$sizeId)->whereNull('order_id')->first();
        if ($cart) {
            // If the product is already in the cart, increase the quantity
            $cart->quantity += 1;
            $cart->save();
            return redirect()->back()->with('success', 'Product quantity updated in the cart.');
        } else {
            // Add the product to the cart
            $cart = new Cart();
            $cart->user_id = $user_id;
            $cart->product_sku = $product->sku;
            $cart->product_color = $colorId;
            $cart->product_size = $sizeId;
            $cart->quantity = 1;
            $cart->price = $product->base_price;
      //      dd($cart);
            $cart->save();
            return redirect()->back()->with('success', 'Product added to cart successfully.');
        }
    } catch (\Exception $e) {
        dd($e);
        // Log the exception and redirect with an error message
        Log::error('Add to Cart Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}
/// my cart in product cart list
public function mycart()
{
    $user_id = Auth::id();
    
    // Fetch cart with relationships
    $cart = Cart::with([
        'product.images',
        'product.category',
        'product.brand',
        'user'
    ])
    ->where('user_id', $user_id)
    ->whereNull('order_id')
    ->whereHas('product', function ($query) {
        $query->where('status', 1);
        $query->where('quantity', '>', 0);
    })
    ->get();

    // Filter out products with quantity 0
    $filteredCart = $cart->filter(function ($item) {
        return $item->product->quantity > 0;
    });

    // Calculate Subtotal (using discount price)
    $subtotal = $filteredCart->sum(function ($item) {
        $discountedPrice = $item->product->base_price ;
        return $discountedPrice * $item->quantity;
    });

    // Calculate the total discount
    $totalDiscount = $filteredCart->sum(function ($item) {
        return ($item->product->base_price * ($item->product->discount / 100)) * $item->quantity;
    });

    // Initialize total delivery fee (flat fee per product)
    $totalDeliveryFee = $filteredCart->count() * 50;

    // Set delivery date for each product
    $now = Carbon::now();
    foreach ($filteredCart as $item) {
        $products = Product::where('sku', $item->product_sku)->where('status', 1)->first();
        if (!empty($products)) {
            //$color = Color::where('id', $item->product_color)->first();
           // $size = Size::where('id', $item->product_size)->first();
            // $item->color_code = $color ? $color->hex_code : 'N/A';
            // $item->color_name = $color ? $color->color_name : 'N/A';
            // $item->size_name = $size ? $size->name : 'N/A';
            // $item->size_name_ar = $size ? $size->name_ar : 'N/A';
            // $item->size_name_cku = $size ? $size->name_cku : 'N/A';
            $item->delivery_date = $now->addDays(5)->format('M d, Y');
        }
    }

    // Fetch active coupons
    $coupons = Coupon::where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->get();

    // Apply coupon discount
    $couponDiscount = 0;
    foreach ($filteredCart as $item) {
        $latestProduct = Product::where('product_id', $item->product_id)->first();

        if ($latestProduct) {
            // Update the cart item's product price dynamically
            $item->product->base_price = $latestProduct->base_price;
            $item->product->discount = $latestProduct->discount; // Ensure the discount is up-to-date
        }
        $productrating = ProductRating::where('product_id', $item->product->product_id)->avg('rating');
        $formattedRating = number_format($productrating, 1);
        $item->rating = $formattedRating;
        $item->coupon_applied = false;

        if ($item->coupon_code) {
            // Fetch the coupon details
            $coupon = Coupon::where('coupon_code', $item->coupon_code)->first();

            if ($coupon) {
                $currentDate = now();

                // Check if coupon is active
                if ($coupon->start_date <= $currentDate && $coupon->end_date >= $currentDate) {
                    // Check customer's coupon usage limit
                    $customerUsedCount = \App\Models\CartOrderSummary::where('user_id', auth()->id())
                        ->where('coupon_code', $coupon->coupon_code)
                        ->count();

                    if ($customerUsedCount < $coupon->usage_limit_per_customer) {
                        // Calculate total cart value using discounted price
                        $cartTotal = $cart->sum(function ($item) {
                            $discountedPrice = $item->product->base_price - ($item->product->base_price * ($item->product->discount / 100));
                            return $discountedPrice * $item->quantity;
                        });

                        // Check minimum purchase amount condition
                        if ($cartTotal >= $coupon->min_purchase_amount) {
                            if ($coupon->discount_type === 'percentage') {
                                $discountAmount = ($cartTotal * ($coupon->discount_value / 100));
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
            }
        }
    }

    // Calculate the total
    $total = $subtotal - $couponDiscount + $totalDeliveryFee;

    // Fetch product recommendations
    $recommendations = Product::with('images', 'wishlists')->where('status', 1)->limit(6)->get();
    foreach ($recommendations as $prod) {
        $productrating = ProductRating::where('product_id', $prod->product_id)->avg('rating');
        $formattedRating = number_format($productrating, 1);
        $prod->rating = $formattedRating;
        $prod->is_wishlisted = $prod->wishlists()->where('user_id', $user_id)->exists();
    }

    // Pass data to the view
    return view('website.cart', compact(
        'filteredCart',
        'recommendations',
        'coupons',
        'subtotal',
        'totalDiscount',
        'couponDiscount',
        'totalDeliveryFee',
        'total',
        'cart'
    ));
}

////////////////////////////////////////////////////
public function updateCartQuantity(Request $request)
{
    try {
        $itemId = $request->input('item_id');
        $quantity = $request->input('quantity');
        // Find the item in the cart
        $cartItem = Cart::with('product')->where('id', $itemId)->first();
        if ($cartItem) {
            $product = $cartItem->product;
            // Check if the requested quantity exceeds available stock
            if ($quantity > $product->quantity) {
                dd("ddsdsds");
                return response()->json([
                    'success' => false,
                    'message' => "Insufficient stock for product: {$product->product_name}"
                ], 400); // 400 Bad Request
            }
            // Update the quantity on the cart item instance
            $cartItem->update(['quantity' => $quantity]);
            // Get updated total price
            $totalPrice = $cartItem->price * $quantity; // Assuming each cart item has a price field
            return response()->json([
                'success' => true,
                'total_price' => $totalPrice,
                'message' => 'Cart quantity updated successfully.'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Cart item not found.'
        ], 404); // 404 Not Found
    } catch (\Exception $e) {
        dd($e);
        // Log the error for debugging
        Log::error('Error updating cart quantity: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'An error occurred while updating the cart.'
        ], 500); // 500 Internal Server Error
    }
}
///////////////////////////////////////////
public function cartproductremove($id)
{
  
    $cartItem = Cart::find($id);
    if ($cartItem) {
        $cartItem->delete(); // Delete the cart item
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false], 404); // Return error if item not found
}
////////////////////
public function applyCoupon(Request $request)
{
    $user_id = Auth::id();
    $coupon_code = $request->input('coupon_code');
    $coupon = Coupon::where('coupon_code', $coupon_code)
                    ->where('start_date', '<=', Carbon::now())
                    ->where('end_date', '>=', Carbon::now())
                    ->first();

    if (!$coupon) {
        return response()->json(['error' => 'Invalid or expired coupon code.'], 400);
    }
    if ($coupon->usage_limit_per_coupon <= $coupon->used_count) {
        return response()->json(['error' => 'Coupon usage limit exceeded.'], 400);
    }
    $userCouponUsage = Cart::where('user_id', $user_id)
                           ->where('coupon_code', $coupon_code)
                           ->count();
    // dd($userCouponUsage);
    
    if ($coupon->usage_limit_per_customer <= $userCouponUsage) {
        return response()->json(['error' => 'Coupon usage limit reached for this customer.'], 400);
    }
    $cart = Cart::where('user_id', $user_id)->get();

    if ($cart->isEmpty()) {
        return response()->json(['error' => 'Cart is empty. Add items before applying a coupon.'], 400);
    }

    $totalCartValue = $cart->sum(function ($item) {
        return $item->product->base_price * $item->quantity;
    });

    if ($totalCartValue <= 0) {
        return response()->json(['error' => 'Invalid cart total.'], 400);
    }
    $totalDiscount = 0;
    foreach ($cart as $item) {
        if ($coupon->discount_type == "percentage") {
            $item_discount = $item->product->base_price * ($coupon->discount_value / 100) * $item->quantity;
        } elseif ($coupon->discount_type == "fixed") {
            $item_discount = $coupon->discount_value * $item->quantity;
        } else {
            $item_discount = 0;
        }
        $totalDiscount += $item_discount;
    }
    if ($totalDiscount >= $totalCartValue) {
        return response()->json(['error' => 'Coupon discount cannot exceed total cart value.'], 400);
    }
    foreach ($cart as $item) {
        $item->coupon_code = $coupon_code;
        $item->save();
    }
    $coupon->used_count += 1;
    $coupon->save();
    $request->session()->put('applied_coupon', $coupon_code);

    return response()->json([
        'message' => 'Coupon applied successfully.',
        'totalDiscount' => $totalDiscount
    ]);
}


//////////////////////////////////////////
public function buyNow(Request $request)
{
    try {
        
        $userId = $request->input('user_id');
        $cartItems = Cart::where('user_id', $userId)->with('product')->whereNull('order_id')->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.']);
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
                                            ->where('order_id',$request->input('order_id'))
                                         ->where('order_status', 'pending')
                                         ->first();
        if ($existingOrder) {
            $existingOrder->update([
                'total_items' => $totalItems,
                'subtotal_price' => $subtotalPrice,
                'total_discount' => $totalDiscount,
                'coupon_discount' => $couponDiscount,
                'delivery_fee' => $existingOrder->delivery_fee,
                'delivery_date' => Carbon::now()->addDays(5)->format('M d, Y'),
                'grand_total' => $grandTotal,
                'coupon_code' => $cartItems->first()->coupon_code ?? $existingOrder->coupon_code,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Existing order updated successfully! Redirecting to Order Summary...',
                'order_id' => $existingOrder->id,
            ]);
        }
        else
        {
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
        }
        return response()->json([
            'success' => true,
            'message' => 'Order created successfully! Redirecting to Order Summary...',
            'order_id' => $newOrder->id,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while placing the order.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
///////////////////////////////////////
public function orderSummary()
{
    $user_id = Auth::id();
    
    // Fetch cart with relationships
    $cart = Cart::with([
        'product.images',
        'product.category',
        'product.brand',
        'user'
    ])
    ->where('user_id', $user_id)
    ->whereNull('order_id')
    ->whereHas('product', function ($query) {
        $query->where('status', 1);
        $query->where('quantity', '>', 0);
    })
    ->get();

    // Adjust cart quantity based on available stock
    foreach ($cart as $item) {
        $availableStock = $item->product->quantity;

        if ($item->quantity > $availableStock) {
            $item->quantity = $availableStock;
            $item->save();
        }

        if ($item->quantity <= 0) {
            $item->delete();
        }
    }

    $filteredCart = $cart->filter(fn($item) => $item->quantity > 0);

    // Calculate subtotal
    $subtotal = $filteredCart->sum(fn($item) => $item->product->base_price * $item->quantity);

    // Calculate total discount
    $totalDiscount = $filteredCart->sum(fn($item) => $item->product->base_price * ($item->product->discount / 100) * $item->quantity); 

    $now = Carbon::now();

    // Initialize delivery fee
    $totalDeliveryFee = 0;

    foreach ($filteredCart as $item) {
        $product = Product::where('sku', $item->product_sku)->first();
        $productVariants = ProductVariant::with(['size', 'color'])->where('product_id', $product->product_id)->get();

        foreach ($productVariants as $variant) {
            $color = Color::where('id', $item->product_color)->first();
            $size = Size::where('id', $item->product_size)->first();

            $item->color_code = $color ? $color->hex_code : 'N/A';
            $item->color_name = $color ? $color->color_name : 'N/A';
            $item->size_name = $size ? $size->name : 'N/A';
            $item->size_name_ar = $size ? $size->name_ar : 'N/A';
            $item->size_name_cku = $size ? $size->name_cku : 'N/A';
        }

        // Get FedEx shipping cost
        $deliveryFee = $this->getFedExShippingCost($item->product, $item->quantity);
        $totalDeliveryFee += $deliveryFee;

        $item->delivery_date = $now->addDays(5)->format('M d, Y');
    }

    // Fetch active coupons
    $coupons = Coupon::where('start_date', '<=', now())
                     ->where('end_date', '>=', now())
                     ->get();

    // Calculate coupon discounts
    $couponDiscount = 0;

    foreach ($filteredCart as $item) {
        $item->rating = ProductRating::where('product_id', $item->product->product_id)->avg('rating') ?? 0;
        $item->coupon_applied = false;

        if ($item->coupon_code) {
            $coupon = Coupon::where('coupon_code', $item->coupon_code)->first();

            if ($coupon) {
                $currentDate = now();

                if ($coupon->start_date <= $currentDate && $coupon->end_date >= $currentDate) {
                    $customerUsedCount = \App\Models\CartOrderSummary::where('user_id', auth()->id())
                        ->where('coupon_code', $coupon->coupon_code)
                        ->count();

                    if ($customerUsedCount < $coupon->usage_limit_per_customer) {
                        $cartTotal = $cart->sum(function($item) {
                            $discountedPrice = $item->product->base_price - ($item->product->base_price * ($item->product->discount / 100));
                            return $discountedPrice * $item->quantity;
                        });

                        if ($cartTotal >= $coupon->min_purchase_amount) {
                            if ($coupon->discount_type === 'percentage') {
                                $discountAmount = ($cartTotal * ($coupon->discount_value / 100));
                            } elseif ($coupon->discount_type === 'flat') {
                                $discountAmount = $coupon->discount_value;
                            } else {
                                $discountAmount = 0;
                            }

                            if ($coupon->max_discount_amount > 0) {
                                $discountAmount = min($discountAmount, $coupon->max_discount_amount);
                            }

                            $couponDiscount = $discountAmount;
                            $item->coupon_applied = true;
                            $coupon->increment('used_count');
                        }
                    }
                } else {
                    return back()->with('error', 'Coupon has expired or is not yet active.');
                }
            }
        }
    }

    // Calculate grand total
    $grandTotal = $subtotal - $totalDiscount - $couponDiscount + $totalDeliveryFee;

    // Fetch product recommendations
    $recommendations = Product::with('images', 'wishlists')->limit(6)->get();
    foreach ($recommendations as $prod) {
        $prod->rating = ProductRating::where('product_id', $prod->product_id)->avg('rating') ?? 0;
        $prod->is_wishlisted = $prod->wishlists()->where('user_id', $user_id)->exists();
    }

    // Fetch user address with default first
    $useraddress = UserAddress::where('user_id', $user_id)->orderBy('make_as_default', 'desc')->get();
    $country_codes = DB::table('countries')->get();

    return view('website.orderSummary', compact(
        'filteredCart',
        'recommendations',
        'coupons',
        'subtotal',
        'totalDiscount',
        'couponDiscount',
        'totalDeliveryFee',
        'grandTotal',
        'cart',
        'useraddress',
        'country_codes'
    ));
}

////////////////////////fedex delivery fee /////////////////////////

private function getFedExShippingCost($product, $quantity)
{
    try {
        $accessToken = app(FedExService::class)->getAccessToken();
       
        $fedexApiUrl = "https://apis.fedex.com/rate/v1/rates/quotes"; // Correct API URL

        $client = new \GuzzleHttp\Client();

        $body = [
            "accountNumber" => ["value" => "740561073"],
            "requestedShipment" => [
                "dropoffType" => "REGULAR_PICKUP",
                "serviceType" => "FEDEX_GROUND",
                "packagingType" => "YOUR_PACKAGING",
                "totalWeight" => [
                    "units" => "LB",
                    "value" => 5 * $quantity
                ],
                "shipper" => ["address" => ["postalCode" => "38116", "countryCode" => "US"]],
                "recipient" => ["address" => ["postalCode" => "10001", "countryCode" => "US"]],
                "rateRequestTypes" => ["LIST"],
                "packageCount" => $quantity,
                "requestedPackageLineItems" => [[
                    "weight" => ["units" => "LB", "value" => 5],
                    "dimensions" => [
                        "length" => 5,
                        "width" => 5,
                        "height" => 5,
                        "units" => "IN"
                    ]
                ]]
            ]
        ];
        $response = $client->post($fedexApiUrl, ['headers' => ['Authorization' => "Bearer $accessToken", 'Content-Type' => 'application/json'], 'json' => $body])->getBody()->add($response->getBody());
        $result = json_decode($response, true);
        // Return the shipping cost
        return $result['output']['rateReplyDetails'][0]['ratedShipmentDetails'][0]['totalNetCharge']['amount'] ?? 50;

    } catch (\Exception $e) {
        // Handle errors and return a default cost
        \Log::error('FedEx API Error: ' . $e->getMessage());
        return 50; // Default shipping cost if API fails
    }
}


///////////////////////
public function payment(Request $request)
    {
        $userId = Auth::id();

        // Fetch valid cart items
        $cartItems = Cart::whereHas('product', function ($query) {
                $query->where('status', 1); // Only fetch active products
            })
            ->with('product','product.images','product.variants')  // Load product details
            ->where('user_id', $userId)
            ->whereNull('order_id')  // Ensure no order is linked
            ->where('orderplace', 0)  // Ensure the orderplace flag is 0
            ->get();

        // If cart is empty or contains only inactive products, return error
        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty or contains inactive products.']);
        }

        // Calculate order totals
        $subtotalPrice = $cartItems->sum('total_price');

        $totalDiscount = $cartItems->sum(function ($item) {
            return optional($item->product)->base_price * (optional($item->product)->discount / 100) * $item->quantity ?? 0;
        });

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

        // Calculate delivery fee and final total
        $deliveryFee = count($cartItems) * 50;
        $grandTotal = $subtotalPrice - $totalDiscount - $couponDiscount + $deliveryFee;
        // dd($grandTotal);die;
        // Get website URL dynamically
        $websiteUrl = env('APP_URL', 'https://yourwebsite.com');

        // Call FibPaymentService to initiate payment
        $paymentResponse = $this->fibPaymentService->initiatePayment(
            (int) $grandTotal,
            'IQD',
            'https://your-callback-url.com',
            'Payment for Order #123'
        );

        if (isset($paymentResponse['error'])) {
            Log::error('FIB Payment Error:', ['message' => $paymentResponse['message']]);
            return response()->json([
                'success' => false,
                'message' => 'Payment request failed',
                'error' => $paymentResponse['message']
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment initiated successfully',
            'paymentData' => $paymentResponse,
            'qrCode' => $paymentResponse['qrCode'] ?? '',
            'paymentId' => $paymentResponse['paymentId']
        ]);
    }
/////////////////////
public function checkPaymentStatus($transactionId)
{
    try {
        // Fetch payment status from the payment service
        $paymentResponse = $this->fibPaymentService->checkPaymentStatus($transactionId);

        // Ensure $paymentResponse is an array and contains 'status'
        if (!is_array($paymentResponse) || !isset($paymentResponse['status'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid payment response format'
            ]);
        }

        // Extract status from the response
        $paymentStatus = $paymentResponse['status'];

        // Update payment status in the database
        // PaymentTransaction::where('transaction_id', $transactionId)->update([
        //     'status' => $paymentStatus
        // ]);

        return response()->json([
            'success' => true,
            'status' => $paymentStatus, // Can be 'pending', 'success', or 'failed'
            'message' => 'Payment status retrieved successfully'
        ]);
    } catch (RequestException $e) {
        return response()->json([
            'success' => false,
            'error' => 'Failed to get payment status',
            'message' => $e->getMessage()
        ]);
    }
}



public function paynow(Request $request)
{
    DB::beginTransaction();
    try {
        $userId = Auth::id();

        // Validate required fields
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
        ]);

        // Get only cart items with active products (status = 1)
        $cartItems = Cart::whereHas('product', function ($query) {
                $query->where('status', 1); // Only fetch active products
            })
            ->with('product')  // Ensure product details are loaded
            ->where('user_id', $userId)
            ->whereNull('order_id')  // Ensure no order is linked
            ->where('orderplace', 0)  // Ensure the orderplace flag is 0
            ->get();

        // If no valid items exist, return an error
        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty or contains inactive products.']);
        }

        // Calculate order totals safely
        $totalItems = $cartItems->sum('quantity');
        // dd($totalItems);
        $subtotalPrice = $cartItems->sum('total_price');

        $totalDiscount = $cartItems->sum(function ($item) {
            return optional($item->product)->base_price * (optional($item->product)->discount / 100) * $item->quantity ?? 0;
        });

        $couponDiscount = $cartItems->sum(function ($item) {
            if ($item->coupon_code && $item->product) {
                $coupon = \App\Models\Coupon::where('coupon_code', $item->coupon_code)->first();
                if ($coupon) {
                    $discountAmount = $item->product->base_price * ($coupon->discount_value / 100) * $item->quantity;
                    return min($discountAmount, $coupon->max_discount_amount);
                }
            }
            return 0;
        });

        // Calculate delivery fee
        $deliveryFee = count($cartItems) * 50;
        $grandTotal = $subtotalPrice - $totalDiscount - $couponDiscount + $deliveryFee;
       
        // Create a new order
        $newOrder = CartOrderSummary::create([
            'user_id' => $userId,
            'order_id' => Str::random(10),
            'total_items' => $totalItems,
            'subtotal_price' => $subtotalPrice,
            'total_discount' => $totalDiscount,
            'coupon_discount' => $couponDiscount,
            'delivery_fee' => $deliveryFee,
            'grand_total' => $grandTotal,
            'delivery_date' => Carbon::now()->addDays(5)->format('M d, Y'),
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'coupon_code' => optional($cartItems->first())->coupon_code ?? null,
        ]);
        $orderId = $newOrder->id;

        // Fetch address details
        $address = UserAddress::find($request->input('address_id'));
        if (!$address) {
            return response()->json(['error' => 'Address not found.'], 404);
        }
        $addressData = "{$address->name}, {$address->address}, {$address->city}, {$address->zip_code}, {$address->country}, {$address->mobile_number}";
        $trackingId = 'TRK-' . rand(1000000000, 9999999999);
        // $trackingId = $this->createFedExShipment($address, $cartItems);
    //  dd($trackingId);
        if (!$trackingId) {
            return response()->json(['error' => 'Failed to generate FedEx tracking ID.'], 500);
        }
        // Update order with address and payment status
        $order = CartOrderSummary::find($orderId);
        $order->update([
            'payment_status' => 'paid',
            'order_status' => 'pending',
            'tracking_id' => $trackingId,
            'order_address' => $addressData
        ]);

        // Process cart items and update product stock
        foreach ($cartItems as $item) {
            if ($item->product) {
                // Reduce product quantity safely
                $item->product->decrement('quantity', $item->quantity);

                // Create order item
                OrderItem::create([
                    'order_id' => $orderId,
                    'product_id' => $item->product->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->base_price,
                ]);

                // Update cart item
                $item->update([
                    'order_id' => $orderId,
                    'orderplace' => 1
                ]);
            }
        }

        // Delete cart items after order placement
        Cart::where('user_id', $userId)->whereNull('order_id')->delete();

        // Update coupon usage limit if applied
        if ($order->coupon_code) {
            Coupon::where('coupon_code', $order->coupon_code)->decrement('usage_limit_per_coupon');
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Order placed and payment processed successfully!',
            'order_id' => $orderId,
        ]);

    }
     catch (\Exception $e) {
        dd($e);
        DB::rollBack();
        \Log::error('PlaceOrderAndPay Error: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while processing the order. Please try again.'], 500);
    }


}


private function createFedExShipment($address, $cartItems)
{
    try {
        $accessToken = app(FedExService::class)->getAccessToken();
        $fedexApiUrl = "https://apis.fedex.com/ship/v1/shipments"; // Correct FedEx API Endpoint

       $shipmentData = [
                "labelResponseOptions" => "URL_ONLY",
                "requestedShipment" => [
                    "shipper" => [
                        "contact" => [
                            "personName" => "SHIPPER NAME",
                            "phoneNumber" => "+911234567890",
                            "companyName" => "Shipper Company Name",
                        ],
                        "address" => [
                            "streetLines" => ["SHIPPER STREET LINE 1"],
                            "city" => "HARRISON",
                            "stateOrProvinceCode" => "RJ", // Valid state for "IN"
                            "postalCode" => 302001,
                            "countryCode" => "IN",
                        ],
                    ],
                    "recipients" => [
                        [
                            "contact" => [
                                "personName" => "RECIPIENT NAME",
                                "phoneNumber" => "+911234567890",
                                "companyName" => "Recipient Company Name",
                            ],
                            "address" => [
                                "streetLines" => [
                                    "RECIPIENT STREET LINE 1",
                                    "RECIPIENT STREET LINE 2",
                                ],
                                "city" => "Collierville",
                                "stateOrProvinceCode" => "RJ",
                                "postalCode" => 302002,
                                "countryCode" => "IN",
                            ],
                        ],
                    ],
                    "shipDatestamp" => "2024-11-25",
                    "serviceType" => "STANDARD_OVERNIGHT",
                    "packagingType" => "FEDEX_SMALL_BOX",
                    "pickupType" => "USE_SCHEDULED_PICKUP",
                    "blockInsightVisibility" => false,
                    "shippingChargesPayment" => ["paymentType" => "SENDER"],
                    "labelSpecification" => [
                        "imageType" => "PDF",
                        "labelStockType" => "PAPER_85X11_TOP_HALF_LABEL",
                    ],
                    "requestedPackageLineItems" => [
                        [
                            "weight" => ["units" => "KG", "value" => 5.0],
                            "dimensions" => [
                                "length" => 30,
                                "width" => 20,
                                "height" => 10,
                                "units" => "CM",
                            ],
                        ],
                    ],
                ],
                "accountNumber" => ["value" => 740561073],
            ];



            $labelResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post('https://apis-sandbox.fedex.com/ship/v1/shipments', $shipmentData);

            // Output the response to debug
            $response = json_decode($labelResponse->body(), true);
            
            if (isset($response['output']['transactionShipments'][0]['masterTrackingNumber'])) {
                return $response['output']['transactionShipments'][0]['masterTrackingNumber'];
            } else {
                return response()->json(['error' => 'Failed to generate FedEx tracking ID.'], 500);
            }

    } catch (\GuzzleHttp\Exception\GuzzleException $e) {
        dd($e);
        $responseBody = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response';
        \Log::error('FedEx API Error:', ['message' => $e->getMessage(), 'response' => $responseBody]);

        $result = [
            'error' => 'FedEx API error: ' . $e->getMessage(),
            'response' => $responseBody,
        ];

    } 
}



//////////////////my address //////////////////
public function ordercancel(Request $request, $id)
{
    try {
        $ids= $request->cart_id;
        //dd($request->all());
        $cartItem = Cart::findOrFail($ids);

        // Update the cart item status to 'Cancelled'
        $cartItem->update(['order_status' => 'cancelled']);

        // Check if all cart items in the order are cancelled
        $order = CartOrderSummary::find($cartItem->order_id);
        if ($order) {
            $remainingItems = $order->cartItems()->where('order_status', '!=', 'cancelled')->count();
            if ($remainingItems === 1) {
                // If all items are canceled, update the order status
                $cartItem->update(['order_status' => 'cancelled']);
                $order->update(['order_status' => 'cancelled']);
            }
        }

        return redirect()->back()->with('success', 'Item cancelled successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to cancel item: ' . $e->getMessage());
    }
}

////////////////////////
public function removeCoupon(Request $request)
{
    $user_id = Auth::id();
    $appliedCoupon = $request->session()->get('applied_coupon');
    // dd($appliedCoupon);
    if (!$appliedCoupon) {
        return response()->json(['error' => 'No coupon applied.'], 400);
    }

    // Step 1: Get the cart items for the user
    $cartItems = Cart::where('user_id', $user_id)->where('coupon_code', $appliedCoupon)->get();

    // Step 2: Remove coupon from cart items
    foreach ($cartItems as $item) {
        $item->coupon_code = null; // Remove the coupon code
        $item->save();
    }

    // Step 3: Remove the applied coupon from the session
    $request->session()->forget('applied_coupon');

    // Optionally, you can handle any additional actions here, like refunding the discount
    // if you have a discount system that tracks the amount deducted, etc.

    // Step 4: Return success response
    return response()->json([
        'message' => 'Coupon removed successfully.',
    ]);
}

public function librarydetail(Request $request, $id)
{
    try {
        // Fetch the main library by ID
        $library = Libraries::where('id', $id)->firstOrFail();
// return  $library;
        // Fetch other libraries excluding the current one, with pagination
        $libraries = Libraries::where('id', '!=', $id)
            ->paginate(9)
            ->appends($request->query());

        // Return the view with both the main library and related libraries
        return view('website.librarydetail', compact('library', 'libraries'));

    } catch (\Exception $e) {
        \Log::error('Error in librarydetail method: ' . $e->getMessage(), [
            'stack_trace' => $e->getTraceAsString()
        ]);
        return redirect()->route('website.index')->with('error', 'Something went wrong while fetching the library details.');
    }
}

public function librarylist(Request $request)
{
    try {
        $perPage = 9;
        $libraries = Libraries::paginate($perPage);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('website.partials.library_item', compact('libraries'))->render(),
                'nextPageUrl' => $libraries->nextPageUrl()
            ]);
        }

        return view('website.librarylist', compact('libraries'));
    } catch (\Exception $e) {
        \Log::error('Error in librarylist method: ' . $e->getMessage());
        return redirect()->route('website.index')->with('error', 'Something went wrong while fetching the library.');
    }
}






public function tbdclub(){


return view('website.tbdclub');

}


public function planuser(Request $request)
{
    $request->validate([
        'plan_id'  => 'required',
        'name'     => 'required|string|max:255',
        'mobile'   => 'required|max:16',
        'address'  => 'required|string|max:500',
    ]);

    try {
        $planuser = new PlanUser;
       // $planuser->user_id = auth()->id(); // or $request->user_id if applicable
        $planuser->plan_id = $request->plan_id;
        $planuser->name = $request->name;
        $planuser->mobile = $request->mobile;
        $planuser->address = $request->address;
        $planuser->save();

        return back()->with('success', 'Plan subscription successfully !');
    } catch (\Exception $e) {
        dd($e);
        \Log::error('Plan Subscription Failed: ' . $e->getMessage());

        return back()->withInput()->with('error', 'Something went wrong. Please try again.');
    }
}





}
