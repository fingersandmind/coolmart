<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['cors']], function () {
    Route::resource('brands', 'Api\BrandsController');

    Route::group(['prefix' => 'items'], function(){
        Route::get('featured', 'Api\ItemsController@isFeatured');
        Route::get('discounted', 'Api\ItemsController@isDiscounted');
    });
    Route::resource('items', 'Api\ItemsController');

    Route::resource('types', 'Api\TypesController');

    Route::resource('details', 'Api\DetailController');

    Route::resource('categories', 'Api\CategoriesController');

    Route::get('terms', 'Api\TermsController@index');

    Route::get('faqs', 'Api\FaqsController@index');

    Route::post('register', 'Api\AuthController@register');
    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout');
    
    Route::resource('cart', 'Api\CartController');

    Route::get('payment', 'Api\PayPalController@payment')->name('payment');
    Route::get('cancel', 'Api\PayPalController@cancel')->name('payment.cancel');
    Route::get('payment/success', 'Api\PayPalController@success')->name('payment.success');
});

// Route::fallback(function(){
//     return response()->json([
//         'message' => 'Page Not Found. If error persists, contact info@coolmart.com'], 404);
// });