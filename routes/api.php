<?php

use App\Http\Resources\UserFullResource;
use App\Product;
use App\User;
use Illuminate\Http\Request;
//use Cart ;

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
Route::post('auth/register','Api\AuthController@register');
Route::post('auth/login','Api\AuthController@login');
Route::post('update/user','Api\UserController@update');
// user route -------------------------------------------------------------
Route::get('categories','Api\CategoryController@index');
Route::get('users','Api\AuthController@index');
Route::get('categories/{id}','Api\CategoryController@show');
Route::get('subCategories/categories/{id}','Api\CategoryController@subCategory');

Route::get('categories/{id}/products','Api\CategoryController@products');



Route::post('addProductReview','Api\ProductController@addProductReview');

Route::post('search/Product','Api\ProductController@search');
Route::post('update/Product','Api\ProductController@update');
Route::post('addtocart','Api\ProductController@addtocart');
Route::post('addproduct','Api\ProductController@store');
Route::get('product/{id}','Api\ProductController@show');

Route::get('store/{id}','Api\ProductController@show');
// product -------------------------------------------------------------


Route::get('products','Api\ProductController@index');
Route::post('delete/product','Api\ProductController@delete');


Route::post('checkout','Api\CheckoutController@store');


Route::post('addtocart','Api\ProductController@addtocart');
Route::post('destoryCart','Api\ProductController@destoryCart');
Route::post('deleteItem','Api\ProductController@deleteItem');



Route::get('cart','Api\ProductController@cart');

Route::get('countries','Api\CountryController@index');
Route::get('countries/{id}/cities','Api\CountryController@showCities');
Route::get('countries/{id}/states','Api\CountryController@showStates');




Route::post('delete/category','Api\CategoryController@delete');
Route::post('store/category','Api\CategoryController@store');
Route::post('update/category','Api\CategoryController@update');
Route::post('categories','Api\CategoryController@index');

//
Route::post('delete/store','Api\StoreController@delete');
Route::post('store/store','Api\StoreController@store');
Route::post('update/store','Api\StoreController@update');
Route::get('search-srores','Api\StoreController@search');
Route::get('stores','Api\StoreController@show');
Route::get('store/products','Api\StoreController@products');


//Route::post('store','Api\CheckoutController@store');

Route::post('store/brand','Api\BrandController@store');
Route::post('update/brand','Api\BrandController@update');
Route::post('delete/brand','Api\BrandController@delete');

Route::post('carts','Api\CartController@AddProductToCart');


Route::get('tags','Api\TagController@index');
Route::get('tags/{id}','Api\TagController@show');
Route::get('addCart','Api\CartController@addCart');
Route::post('edit/follow','Api\FollowerController@edit');
//Route::post('checkout','Api\CheckoutController@checkout');
Route::get('followers','Api\FollowerController@followers');
Route::get('carts','Api\CartController@index');

Route::post('edit/fav','Api\FavouriteController@edit');
Route::get('fav/list','Api\FavouriteController@favourites');
Route::middleware('auth:api')->group(function (){
    
    

    

});

