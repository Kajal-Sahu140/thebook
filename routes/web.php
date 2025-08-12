<?php
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductofferController;
use App\Http\Controllers\Admin\ContactusController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\PlanController;

use App\Http\Controllers\Admin\whatsupController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\LibraryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');
    return '<h1>Cache cleared</h1>';
});

Route::get('lang/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'ar', 'cku'])) {
        Session::put('locale', $lang);
        App::setLocale($lang);
    }
    return redirect()->back();
})->name('changeLang');
    Route::controller(WebsiteController::class)->group(function () {
    Route::get('/', 'index')->name('website.index');
    Route::get('/signin', 'login')->name('website.signin');
    Route::get('/signup', 'signup')->name('website.signup');
      Route::get('/forget-password', 'forgetpassword')->name('website.forgetpassword');
    Route::post('/change-forget-password', 'userchangepassword')->name('website.userchangepassword');
    Route::post('/store', 'store')->name('website.store');
    Route::post('/signin', 'signin')->name('website.signin');
    Route::post('/verifyOtp', 'verifyOtp')->name('website.verifyOtp');
    Route::post('/resendOtp', 'resendOtp')->name('website.resendOtp');
    Route::get('/aboutus', 'aboutus')->name('website.aboutus');
    Route::get('/privacypolicy', 'privacypolicy')->name('website.privacypolicy');
    Route::get('/tremscondition', 'tremscondition')->name('website.tremscondition');
    Route::get('/faq', 'faq')->name('website.faq');
    Route::get('/contact', 'contactus')->name('website.contactus');
    Route::get('/brand', 'brand')->name('website.brand');
    Route::get('/branddetail/{id}', 'branddetail')->name('website.branddetail');
    Route::get('/librarydetail/{id}', 'librarydetail')->name('website.librarydetail');
     Route::get('/library-list', 'librarylist')->name('website.librarylist');
    Route::get('/categoryproductlist/{id}', 'categoryproductlist')->name('website.categoryproductlist');
    Route::get('/productdetail/{id}', 'productdetail')->name('website.productdetail');
    Route::get('/phoneverification', 'phoneverification')->name('website.phoneverification');
    Route::get('/search', 'search')->name('website.search');
    Route::get('/blog', 'Blog')->name('website.blog');
    
       Route::get('/tbdclub', 'tbdclub')->name('website.tbdclub');
        Route::post('/palnmodule',  'planuser')->name('website.planuser');
    Route::get('/blog/blogdetail/{id}', 'blogview')->name('website.blogdetail');
     Route::post('/productwishlist', 'productwishlist')->name('website.productwishlist');
     Route::get('/productwishlist', function () {
    return response()->json(['message' => 'This endpoint only supports POST requests.'], 405);
});

    Route::get('/deeplink', 'deeplink')->name('website.deeplink');
        Route::middleware(['website.login'])->group(function () {
        Route::get('/signOut', 'signOut')->name('website.signOut');
        Route::get('/myprofile', 'myprofile')->name('website.myprofile');
        Route::get('/myorder', 'order')->name('website.order');
        Route::get('/myaddress', 'myaddress')->name('website.myaddress');
        Route::get('/mysavecard', 'mysavecard')->name('website.mysavecard');
        Route::get('/addnewcard', 'addnewcard')->name('website.addnewcard');
        Route::get('/addnewaddress', 'addnewaddress')->name('website.addnewaddress');
        Route::get('/rating', 'rating')->name('website.rating');
        Route::get('/wishlist', 'wishlist')->name('website.wishlist');
        Route::get('/orderDetail/{order_id}/{product_id}', 'orderDetail')->name('website.orderDetail');
        Route::get('/order-summary', 'orderSummary')->name('website.orderSummary');
        Route::post('/order/pay-now','payNow')->name('order.payNow');
        Route::post('/payment', 'payment')->name('website.payment');
        Route::get('/payment-status/{paymentId}', 'checkPaymentStatus')->name('website.checkPaymentStatus');
        Route::post('/sendMessage', 'sendMessage')->name('website.sendMessage');
        Route::post('/productreturn', 'productreturn')->name('website.productreturn');
        Route::post('/addreview', 'addreview')->name('website.addreview');
        Route::get('/download-invoice/{order_id}/{product_id}', 'downloadInvoice')->name('website.download.invoice');
        Route::post('/updateCartQuantity', 'updateCartQuantity')->name('website.updateCartQuantity');
        Route::get('/productcart/{sku}', 'productcart')->name('website.productcart');
        Route::get('/mycart', 'mycart')->name('website.mycart');
        Route::post('/applyCoupon', 'applyCoupon')->name('website.applyCoupon');
        Route::post('/buyNow', 'buyNow')->name('website.buyNow');
        Route::post('/saveaddress', 'saveaddress')->name('website.saveaddress');
        Route::put('/updateaddress/{id}', 'updateaddress')->name('website.updateaddress');
        Route::get('/editaddress/{id}', 'editaddress')->name('website.editaddress');
        Route::delete('cartproductremove/{id}', 'cartproductremove')->name('website.cartproductremove');
        Route::delete('deleteaddress/{id}', 'deleteaddress')->name('website.deleteaddress');
        Route::put('/myprofileupdate', 'myprofileupdate')->name('website.myprofileupdate');
        Route::post('/order-cancel/{id}', 'ordercancel')->name('order.cancel');
        Route::post('/removeCoupon',  'removeCoupon')->name('website.removeCoupon');
        });
    });
//  Route::get('/fib/payment', 'PaymentController@createPayment');
// Route::post('/payment/callback', 'PaymentController@paymentCallback')->name('payment.callback');

    Route::controller(HomeController::class)->group(function () {
                Route::get('/admin/', 'index')->name('admin.access.login');
                Route::get('/admin/login', 'index')->name('admin.access.login');
                Route::post('/login', 'signIn')->name('admin.signIn');
                Route::get('/logout', 'signOut')->name('admin.signOut');
                Route::get('/admin/forget-password', 'createForgetPassword')->name('admin.access.forgetPassword');
                Route::post('/forget-password', 'storeForgetPassword')->name('admin.access.forgetPasswordProcess');
                Route::get('/admin/reset-password', 'editForgetPassword')->name('admin.access.changePassword');
                Route::post('/admin/reset-password','sendOtp')->name('admin.access.forgetPasswordProcess');
                Route::post('/admin/change-password', 'changePassword')->name('admin.access.changePasswordProcess');
                
    Route::controller(PagesController::class)->group(function () {
        Route::get('/about_us', 'aboutus');
        Route::get('/privacy_policy', 'privacypolicy');
        Route::get('/trems_condition', 'tremscondition');
        Route::get('/faq_page','faq');
    });

    Route::controller(PaymentController::class)->group(function () {
        Route::post('/payment/initiate', 'initiatePayment');
Route::post('/payment/status', 'checkPaymentStatus');
    });
    Route::prefix('admin')->middleware(['admin.login','admin.session'])->group(function () {
        Route::fallback(function () {
        return abort(404, 'Page Not Found');
    });
        ///////////////////////homecontroller///////////////////////////
             Route::controller(HomeController::class)->group(function () {
             Route::get('/dashboard', 'dashboard')->name('admin.dashboard');
             Route::get('/logout', 'signOut')->name('admin.signOut');
             });



 Route::controller(whatsupController::class)->group(function () {
             Route::get('/send-multiple', 'index')->name('admin.sendMultipleWhatsget');
             Route::post('/send-multiple-whatsapp', 'sendMultipleWhatsApp')->name('admin.sendMultipleWhatsApp');
             });



             ////////////////////////ProfileController ///////////////////
             Route::controller(ProfileController::class)->group(function () {
             Route::get('/profiles', 'index')->name('admin.profiles');
             Route::post('/profiles/updatePassword', 'updatePassword')->name('admin.profiles.updatePassword');
             Route::put('/profiles/updateProfile', 'updateProfile')->name('admin.profiles.updateProfile');     
             });
             ///////////////////// user controller ///////////////////
             Route::controller(UserController::class)->group(function () {
             Route::get('/users', 'index')->name('admin.users');
             Route::get('/users/view/{id}', 'view')->name('admin.users.view');
             Route::get('/users/edit/{id}', 'edit')->name('admin.users.edit');
             Route::delete('/users/destroy/{id}', 'destroy')->name('admin.users.destory'); 
             Route::put('/users/update/{id}', 'update')->name('admin.users.update');      
             });
             //////////////////////////////////////////////////////////////////
             Route::controller(PageController::class)->group(function () {
             Route::get('pages/{slug}', 'edit')->name('admin.pages.edit');
             Route::put('pages/{slug}', 'update')->name('admin.pages.update');
             Route::get('faq', 'index')->name('admin.faq');
             Route::delete('faq/destroy/{id}', 'destroy')->name('admin.faq.destory');
             Route::get('faq/create', 'create')->name('admin.faq.create');
             Route::get('faq/view/{id}', 'faqview')->name('admin.faq.view');
             Route::get('faq/edit/{id}', 'faqedit')->name('admin.faq.edit');
             Route::put('faq/update/{id}', 'faqupdate')->name('admin.faq.update');
             Route::post('faq/store', 'store')->name('admin.faq.store');
             });
             /////////////////////////////////////
             Route::controller(CategoryController::class)->group(function () {
             Route::get('/category', 'index')->name('admin.category');
             Route::get('/category/create', 'create')->name('admin.category.create');
             Route::get('/category/edit/{id}', 'edit')->name('admin.category.edit');
             Route::delete('/category/destroy/{id}', 'destroy')->name('admin.category.destory');      
             Route::post('/category/store', 'store')->name('admin.category.store');
             Route::patch('/category/update/{id}', 'update')->name('admin.category.update');
             ////////////////////sub category /////////////////////////////////
             Route::get('/subcategory/{id}', 'subcategorylist')->name('admin.subcategory');
             });
            ///////////////////////////////////////////////////BrandController///////////////////////
             Route::controller(BrandController::class)->group(function () {
             Route::get('/brand', 'index')->name('admin.brand');
             Route::get('/brand/create', 'create')->name('admin.brand.create');
             Route::get('/brand/edit/{id}', 'edit')->name('admin.brand.edit');
             Route::post('/brand/store', 'store')->name('admin.brand.store');
             Route::patch('/brand/update/{id}', 'update')->name('admin.brand.update');
             Route::delete('/brand/destroy/{id}', 'destroy')->name('admin.brand.destory');    
             });
             //////////////////////////////WarehouseController//////////////////////////////////////////
             Route::controller(WarehouseController::class)->group(function () {
             Route::get('/warehouse', 'index')->name('admin.warehouse');
             Route::get('/warehouse/create', 'create')->name('admin.warehouse.create');
             Route::get('/warehouse/edit/{id}', 'edit')->name('admin.warehouse.edit');
             Route::post('/warehouse/store', 'store')->name('admin.warehouse.store');
             Route::patch('/warehouse/update/{id}', 'update')->name('admin.warehouse.update');
             Route::delete('/warehouse/destroy/{id}', 'destroy')->name('admin.warehouse.destory');    
             });
             ///////////////////////BannerController//////////////////////////////////////////////////
             Route::controller(BannerController::class)->group(function () {
             Route::get('/banner', 'index')->name('admin.banner');
             Route::get('/banner/create', 'create')->name('admin.banner.create');
             Route::post('/banner/store', 'store')->name('admin.banner.store');
             Route::delete('/banner/destroy/{id}', 'destroy')->name('admin.banner.destory');    
             Route::get('/banner/view/{id}', 'show')->name('admin.banner.view');
             Route::get('/banner/edit/{id}', 'edit')->name('admin.banner.edit');
             Route::put('/banner/update/{id}', 'update')->name('admin.banner.update');
             });
             //////////////////////////ProductController////////////////////////////////////
              Route::controller(ProductController::class)->group(function () {
              Route::get('/product', 'index')->name('admin.product');
              Route::get('/product/create', 'create')->name('admin.product.create');
              Route::post('/product/store', 'store')->name('admin.product.store');
              Route::put('/product/update/{id}', 'update')->name('admin.product.update');
              Route::delete('/product/destroy/{id}', 'destroy')->name('admin.product.destory');   
              Route::get('/product/view/{id}', 'show')->name('admin.product.view');
              Route::get('/product/edit/{id}', 'edit')->name('admin.product.edit');
              Route::post('/get-subcategories', 'getSubcategories')->name('admin.getSubcategories');
              Route::post('/removeImage',  'removeImage')->name('admin.product.removeImage');
             });       
              ///////////////////////CouponController//////////////////////////////
              Route::controller(CouponController::class)->group(function () {
              Route::get('/coupon', 'index')->name('admin.coupon');
              Route::get('/coupon/create', 'create')->name('admin.coupon.create');
              Route::post('/coupon/store', 'store')->name('admin.coupon.store');
              Route::delete('/coupon/destroy/{id}', 'destroy')->name('admin.coupon.destory');   
              Route::get('/coupon/edit/{id}', 'edit')->name('admin.coupon.edit');
              Route::patch('/coupon/update/{id}', 'update')->name('admin.coupon.update');
              Route::get('/coupon/view/{id}', 'show')->name('admin.coupon.view');
              });
              /////////////////////////BlogController////////////////////////////////
               Route::controller(BlogController::class)->group(function () {
               Route::get('/blog', 'index')->name('admin.blog');
               Route::get('/blog/create', 'create')->name('admin.blog.create');
               Route::get('/blog/view/{id}', 'view')->name('admin.blog.view');
               Route::get('/blog/edit/{id}', 'edit')->name('admin.blog.edit');
               Route::post('/blog/store', 'store')->name('admin.blog.store');
               Route::put('/blog/update/{id}', 'update')->name('admin.blog.update');
               Route::delete('/blog/destroy/{id}', 'destroy')->name('admin.blog.destory');   
              });
              ///////////////////////////ContactusController///////////////////////////
               Route::controller(ContactusController::class)->group(function () {
               Route::get('/contactus', 'index')->name('admin.contactus');
               Route::get('/contactus/view/{id}', 'view')->name('admin.contactus.view');
               Route::post('/contactus/replyToContactUs/{id}', 'replyToContactUs')->name('admin.contactus.replyToContactUs');
               
              });
              /////////////////////////////ProductofferController//////////////////////////////
               Route::controller(ProductofferController::class)->group(function () {
               Route::get('/productoffer', 'index')->name('admin.productoffer');
               Route::get('/productoffer/view/{id}', 'view')->name('admin.productoffer.view');
               Route::get('/productoffer/edit/{id}', 'edit')->name('admin.productoffer.edit');
               Route::get('/productoffer/create', 'create')->name('admin.productoffer.create');
               Route::post('/productoffer/store', 'store')->name('admin.productoffer.store');
               Route::put('/productoffer/update/{id}', 'update')->name('admin.productoffer.update');
               Route::delete('/productoffer/destroy/{id}', 'destroy')->name('admin.productoffer.destory');   
              });
              /////////////////////////////OrderController//////////////////////////////
               Route::controller(OrderController::class)->group(function () {
               Route::get('/order', 'index')->name('admin.order');
               Route::get('/order/view/{id}', 'view')->name('admin.order.view');
               Route::get('/order/edit/{id}', 'edit')->name('admin.order.edit');
               Route::put('/order/update/{id}', 'update')->name('admin.order.update');
               Route::delete('/order/destroy/{id}', 'destroy')->name('admin.order.destory');   
               Route::put('/order/cancel/{id}', 'ordercancel')->name('admin.order.ordercancel');
               Route::get('/admin/order/invoice/{order_id}/{product_id}', 'downloadInvoice')->name('admin.download.invoice');
              });

               Route::controller(RatingController::class)->group(function () {
               Route::get('/rating', 'index')->name('admin.rating');
               Route::get('/rating/view/{id}', 'view')->name('admin.rating.view');
               Route::get('/rating/edit/{id}', 'edit')->name('admin.rating.edit');
               Route::put('/rating/update/{id}', 'update')->name('admin.rating.update');
               Route::delete('/rating/destroy/{id}', 'delete')->name('admin.rating.destory');   
              });


             Route::controller(LibraryController::class)->group(function () {
             Route::get('/library', 'index')->name('admin.library.index');
             Route::get('/library/add', 'create')->name('admin.library.create');
             Route::post('/library/store', 'store')->name('admin.library.store');
             Route::get('/library/edit/{id}', 'edit')->name('admin.library.edit');
             Route::put('/library/update', 'update')->name('admin.library.update');     
             });
             
             
                  Route::controller(PlanController::class)->group(function () {
             Route::get('/plan', 'index')->name('admin.plan.index');
             Route::get('/plan/add', 'create')->name('admin.plan.create');
             Route::post('/plan/store', 'store')->name('admin.plan.store');
             Route::get('/plan/edit/{id}', 'edit')->name('admin.plan.edit');
             Route::put('/plan/update', 'update')->name('admin.plan.update');   
             
              Route::get('/user-plan', 'userplanindex')->name('admin.plan.userplanindex');
             });
             
               Route::controller(ReturnController::class)->group(function () {
               Route::get('/return', 'index')->name('admin.return');
               Route::get('/return/view/{id}', 'view')->name('admin.return.view');
               Route::get('/return/edit/{id}', 'edit')->name('admin.return.edit');
               Route::put('/refund/create/{id}', 'create')->name('admin.refund.create');
               Route::put('/return/updateStatus/{id}', 'updateStatus')->name('admin.return.updateStatus');
               Route::delete('/return/destroy/{id}', 'delete')->name('admin.return.destory');   
              });
                Route::controller(TransactionController::class)->group(function () {
                     Route::get('/transaction', 'index')->name('admin.transaction');
                });

    });
});