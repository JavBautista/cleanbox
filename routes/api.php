<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('categories-x/get','App\Http\Controllers\HomeController@catgoriesX');
Route::get('products-x/get','App\Http\Controllers\HomeController@productsX');
Route::get('categorias/get','App\Http\Controllers\AppController@getCategories');

/*------------------------------------------------------------------
/* BEGIN RUTAS PROTEGIDAS
/*------------------------------------------------------------------*/
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', '\App\Http\Controllers\AuthController@login');
    Route::post('signup', '\App\Http\Controllers\AuthController@signUp');

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        /*USER*/
        Route::get('logout', '\App\Http\Controllers\AuthController@logout');
        Route::get('user', '\App\Http\Controllers\AuthController@user');
        Route::post('user', '\App\Http\Controllers\AuthController@update');

        Route::post('user/update-terminos', '\App\Http\Controllers\AuthController@updateTerminos');

        /*CLIENTES*/
        Route::resource('client','App\Http\Controllers\ClientController')->except(['show']);
        Route::post('client/edit/update','App\Http\Controllers\ClientController@update');
        Route::post('client/inactive','App\Http\Controllers\ClientController@inactive');
        Route::post('client/upload-location-image','App\Http\Controllers\ClientController@uploadLocationImageClient');
        Route::post('client/delete-location-image','App\Http\Controllers\ClientController@deleteLocationImage');

        Route::get('client/verify-user-email','App\Http\Controllers\ClientController@verifyUserEmail');
        Route::post('client/store-user-app','App\Http\Controllers\ClientController@storeUserApp');

        /*CATEGORIAS*/
        Route::resource('category','App\Http\Controllers\CategoryController');
        Route::get('/category/get/all','App\Http\Controllers\CategoryController@all');
        Route::post('category/edit/update','App\Http\Controllers\CategoryController@update');
        Route::post('category/delete','App\Http\Controllers\CategoryController@inactive');

        /*PRODUCTOS*/
        Route::resource('product','App\Http\Controllers\ProductController');
        Route::post('product/edit/update','App\Http\Controllers\ProductController@update');
        Route::post('product/edit/update-stock','App\Http\Controllers\ProductController@updateStock');
        Route::post('product/delete','App\Http\Controllers\ProductController@inactive');

        Route::post('product/upload-image','App\Http\Controllers\ProductController@uploadImageProduct');
        Route::post('product/delete-image','App\Http\Controllers\ProductController@deleteImageProduct');


    });
});
/*------------------------------------------------------------------
/* ./ END RUTAS PROTEGIDAS
/*------------------------------------------------------------------*/
