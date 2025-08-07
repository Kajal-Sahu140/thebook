<?php
use App\Http\Controllers\Warehouse\HomeController;
use App\Http\Controllers\Warehouse\ProfileController;
use App\Http\Controllers\Warehouse\CategoryController;
use App\Http\Controllers\Warehouse\ProductController;
use App\Http\Controllers\Warehouse\OrderController;
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
  Route::controller(HomeController::class)->group(function () {
  Route::get('/warehouse/', 'index')->name('warehouse.access.login');
  Route::get('/warehouse/login', 'index')->name('warehouse.access.login');
  Route::post('/warehouse/login', 'signIn')->name('warehouse.signIn');
  Route::get('/logout', 'signOut')->name('warehouse.signOut');
  Route::get('/warehouse/forget-password', 'createForgetPassword')->name('warehouse.access.forgetPassword');
  Route::post('/warehouse/reset-password','sendOtp')->name('warehouse.access.forgetPasswordProcess');
  Route::get('/warehouse/reset-password', 'editForgetPassword')->name('warehouse.access.changePassword');
  Route::post('/change-password', 'changePassword')->name('warehouse.access.changePasswordProcess');
  Route::prefix('warehouse')->middleware(['warehouse.login'])->group(function () {
    Route::fallback(function () {
        return abort(404, 'Page Not Found');
    });
             Route::controller(HomeController::class)->group(function () {
             Route::get('/dashboard', 'dashboard')->name('warehouse.dashboard');
             });
             Route::controller(ProfileController::class)->group(function () {
             Route::get('/myprofile', 'index')->name('warehouse.profiles');
             Route::post('/profiles/updatePassword', 'updatePassword')->name('warehouse.profiles.updatePassword');
             Route::put('/profiles/updateProfile', 'updateProfile')->name('warehouse.profiles.updateProfile');     
             });
            //  Route::controller(CategoryController::class)->group(function () {
            //  Route::get('/category', 'index')->name('warehouse.category');
            //  Route::get('/category/subcategory/{id}', 'subcategory')->name('warehouse.category.subcategory');
            //  Route::get('/category/create', 'create')->name('warehouse.category.create');
            //  Route::get('/category/edit/{id}', 'edit')->name('warehouse.category.edit');
            //  Route::post('/category/store', 'store')->name('warehouse.category.store');
            //  Route::patch('/category/update/{id}', 'update')->name('warehouse.category.update');
            //  Route::delete('/category/destroy/{id}', 'destroy')->name('warehouse.category.destory');    
            //  });
              Route::controller(ProductController::class)->group(function () {
              Route::get('/product', 'index')->name('warehouse.product');
              Route::get('/product/create', 'create')->name('warehouse.product.create');
              Route::post('/product/store', 'store')->name('warehouse.product.store');
              Route::put('/product/update/{id}', 'update')->name('warehouse.product.update');
              Route::delete('/product/destroy/{id}', 'destroy')->name('warehouse.product.destory');   
              Route::get('/product/view/{id}', 'show')->name('warehouse.product.view');
              Route::get('/product/edit/{id}', 'edit')->name('warehouse.product.edit');
              Route::post('/get-subcategories', 'getSubcategories')->name('warehouse.getSubcategories');
              Route::post('/removeImage',  'removeImage')->name('warehouse.product.removeImage');
             });    
             Route::controller(OrderController::class)->group(function () {
             Route::get('/order', 'index')->name('warehouse.order');
             Route::get('/order/view/{id}', 'show')->name('warehouse.order.view');
             Route::get('/order/edit/{id}', 'edit')->name('warehouse.order.edit');
             Route::put('/order/update/{id}', 'update')->name('warehouse.order.update');
             Route::delete('/order/destroy/{id}', 'destroy')->name('warehouse.order.destory');   
             Route::put('/order/cancel/{id}', 'ordercancel')->name('warehouse.order.ordercancel'); 
             Route::get('/admin/order/invoice/{order_id}/{product_id}', 'downloadInvoice')->name('admin.download.invoice');
             });
    });
});
