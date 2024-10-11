<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes([
    'login'    => true,
    'logout'   => true,
    'register' => true,
    'reset'    => false,
    'confirm'  => false,
    'verify'   => false,
]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/user/passwords/reset', [App\Http\Controllers\HomeController::class,'passwordReset'])->name('password.reset');
    Route::post('/user/passwords/update', [App\Http\Controllers\HomeController::class,'updatePassword'])->name('password.update');

    Route::group(['middleware' => 'superadmin'], function () {

        //Index
        Route::get('/superadmin', [App\Http\Controllers\SuperadminPagesController::class,'index'])->name('superadmin.index');
        //PagesController To Views
        Route::get('/superadmin/products', [App\Http\Controllers\SuperadminPagesController::class,'products'])->name('superadmin.products');
        Route::get('/superadmin/categories', [App\Http\Controllers\SuperadminPagesController::class,'categories'])->name('superadmin.categories');
        Route::get('/superadmin/customers', [App\Http\Controllers\SuperadminPagesController::class,'customers'])->name('superadmin.customers');
        Route::get('/superadmin/suppliers', [App\Http\Controllers\SuperadminPagesController::class,'suppliers'])->name('superadmin.suppliers');


        //Suppliers VUE URLS
        Route::get('/superadmin/suppliers/get', [App\Http\Controllers\Superadmin\SupplierController::class,'get']);
        Route::post('/superadmin/suppliers/store', [App\Http\Controllers\Superadmin\SupplierController::class,'store']);
        Route::put('/superadmin/suppliers/update', [App\Http\Controllers\Superadmin\SupplierController::class,'update']);
        Route::put('/superadmin/suppliers/active', [App\Http\Controllers\Superadmin\SupplierController::class,'active']);
        Route::put('/superadmin/suppliers/deactive', [App\Http\Controllers\Superadmin\SupplierController::class,'deactive']);

        //Customers VUE URLS
        Route::get('/superadmin/customers/get', [App\Http\Controllers\Superadmin\CustomerController::class,'get']);
        Route::post('/superadmin/customers/store', [App\Http\Controllers\Superadmin\CustomerController::class,'store']);
        Route::put('/superadmin/customers/update', [App\Http\Controllers\Superadmin\CustomerController::class,'update']);
        Route::put('/superadmin/customers/active', [App\Http\Controllers\Superadmin\CustomerController::class,'active']);
        Route::put('/superadmin/customers/deactive', [App\Http\Controllers\Superadmin\CustomerController::class,'deactive']);

        //Categories VUE URLS
        Route::get('/superadmin/categories/get', [App\Http\Controllers\Superadmin\CategoryController::class,'get']);
        Route::post('/superadmin/categories/store', [App\Http\Controllers\Superadmin\CategoryController::class,'store']);
        Route::put('/superadmin/categories/update', [App\Http\Controllers\Superadmin\CategoryController::class,'update']);
        Route::put('/superadmin/categories/active', [App\Http\Controllers\Superadmin\CategoryController::class,'active']);
        Route::put('/superadmin/categories/deactive', [App\Http\Controllers\Superadmin\CategoryController::class,'deactive']);

        //Product VUE URLS
        Route::get('/superadmin/products/get', [App\Http\Controllers\Superadmin\ProductController::class,'get']);
        Route::post('/superadmin/products/store', [App\Http\Controllers\Superadmin\ProductController::class,'store']);
        Route::put('/superadmin/products/update', [App\Http\Controllers\Superadmin\ProductController::class,'update']);
        Route::put('/superadmin/products/active', [App\Http\Controllers\Superadmin\ProductController::class,'active']);
        Route::put('/superadmin/products/deactive', [App\Http\Controllers\Superadmin\ProductController::class,'deactive']);

    });//./Routes Middleware superadmin

});#./Middlware AUTH
