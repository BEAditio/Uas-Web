<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify'=>true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::name('admin.')->group(function (){
    Route::group(['prefix' => 'admin'], function(){
        Route::resource('products', 'Admin\ProductController');
        Route::get('/products/image/{imageName}','Admin\ProductController@image')->name('products.image');

	Route::resource('orders','Admin\OrderController');
    });
});

Route::get('post','PostController@index');

Route::get('products','ProductController@index')->name('products.index');
Route::get('products/{id}', 'ProductController@show')->name('products.show');
Route::post('products', 'ProductController@store')->name('products.store');
Route::get('products/image/{imageName}', 'ProductController@image')->name('products.image');
Route::get('/ajax-product-review', 'AjaxRequest@product_review')->name('ajax.products.review');

Route::get('/carts', 'CartController@index')->name('carts.index');
Route::get('/carts/add/{id}', 'CartController@add')->name('carts.add');
Route::patch('carts/update', 'CartController@update')->name('carts.update');
Route::delete('carts/remove', 'CartController@remove')->name('carts.remove');

// Route::get('image','ImageController@index')->name('image');
// Route::get('image/insert', 'ImageController@create')->name('image_insert');
// Route::post('iamge/save', 'ImageController@store')->name('image_save');
// Route::get('image/view/{fileImage}', 'ImageController@viewImage')->name('image_view');
