<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\ProductVariantController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FedExController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\FaqController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/payment/initiate', [PaymentController::class, 'makePayment']);
Route::get('/fib/payment-status/{paymentId}', [PaymentController::class, 'getPaymentStatus']);
Route::get('/payment/status', [PaymentController::class, 'checkPaymentStatus']);
Route::post('/payment/callback', [PaymentController::class, 'paymentCallback']);
Route::post('/fib/payment/process', [PaymentController::class, 'processPayment']);
Route::get('/fedex/token', [FedExController::class, 'getFedExToken']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/otp-verify', [AuthController::class, 'otpVerify']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
Route::post('/login/request-otp', [AuthController::class, 'requestOtp']);
Route::post('/login/verify-otp', [AuthController::class, 'verifyOtp']);
Route::get('/home/homepage', [HomeController::class, 'index']);
Route::get('/home/categorylist/{id}', [HomeController::class, 'categorylist']);
Route::get('/home/productDetail/{id}', [HomeController::class, 'productDetail']);
Route::get('/home/brandProductDetail/{id}', [HomeController::class, 'brandProductDetail']);
Route::get('/home/brandlist', [HomeController::class, 'brandlist']);
Route::get('/home/bloglist', [HomeController::class, 'bloglist']);
Route::get('/home/searchproduct', [HomeController::class, 'searchproduct']);
Route::get('/home/homePageProducts', [HomeController::class, 'homePageProducts']);
Route::post('/user/contactus', [UserController::class, 'contactus']);
Route::middleware(['auth:sanctum', 'check.auth.token'])->group(function () {
    Route::prefix('user')->controller(UserController::class)->group(function () {
        Route::get('/profile', 'index');
        Route::post('/profileCreateUpdate', 'profileCreateUpdate');
    });
    Route::prefix('home')->controller(HomeController::class)->group(function () {
        Route::get('/mywishlist', 'mywishlist');
        Route::post('/productwishlist', 'productwishlist');
        Route::post('/updateCartQuantity', 'updateCartQuantity');
        Route::post('/applyCoupon', 'applyCoupon');
        Route::post('/placeOrder', 'placeOrder');
        Route::get('/productcart/{sku}', 'productcart');
        Route::get('/mycart', 'mycart');
        Route::get('/order', 'order');
        Route::get('/downloadInvoice/{order_id}', 'downloadInvoice');
        Route::get('/orderDetail/{order_id}/{product_id}', 'orderDetail');
        Route::get('/orderSummary/{order_id}', 'orderSummary');
        Route::post('/order/pay-now','payNow');
        Route::post('/addReview', 'addReview');
        Route::post('/saveAddress', 'saveAddress');
        Route::post('/productreturn', 'productreturn');
        Route::get('/sendSmsNotification', 'sendSmsNotification');
        Route::post('/removeCoupon', 'removeCoupon');
        Route::post('/updateaddress/{id}', 'updateaddress');
        Route::get('/rating', 'rating');
        Route::get('/coupons', 'coupons');
        Route::post('/ordercancel', 'ordercancel');
        Route::post('/deleteAccount', 'deleteAccount');
        Route::get('/UserAddress', 'UserAddress');
        Route::get('/notifications', 'notificationlist');
        Route::post('/notificationread', 'notificationread');
        Route::post('/userlanguage', 'userlanguage');
        Route::delete('/cartProductRemove/{id}', 'cartProductRemove');
        Route::delete('/deleteAddress/{id}', 'deleteAddress');
        Route::post('/userlogout', 'userlogout');
        Route::get('/getFedExTrackingStatus', 'getFedExTrackingStatus');
        Route::post('/payment', 'payment');
        Route::get('/payment-status/{transactionId}','checkPaymentStatus');
    });
});


