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

Route::group(['middleware' => ['cors']], function () {
    Route::resource('brands', 'Api\BrandsController')->only('index','show');

    Route::group(['prefix' => 'items'], function(){
        Route::get('reviewable', 'Api\ReviewsController@toBeReviewed');         /** [Checkedout Items and available for reviews] */
        Route::get('reviewed', 'Api\ReviewsController@withReview');             /** [Checkedout Items that already have a review] */
        Route::get('review/{item}', 'Api\ReviewsController@show');              /** [Display items that has review] */
        Route::get('review/{item}/create', 'Api\ReviewsController@create');     /** [Passing item information for creating review] */
        Route::post('reviews', 'Api\ReviewsController@store');                  /** [Store or Update a user's review] */

        Route::get('featured', 'Api\ItemsController@isFeatured');
        Route::get('discounted', 'Api\ItemsController@isDiscounted');
        Route::get('top-rated', 'Api\ItemsController@topRated');

    /** 
     * ******* [ Displays all reviews of a specified Items ] ******* 
     */

        Route::get('reviews/{item}', 'Api\ReviewsController@index');
    });

    /** 
     * ******* [ Update Or Create User Billing Address ] ******* 
     */
    
    Route::post('billing-address', 'Api\BillingAddressesController@store');
    Route::put('billing-address', 'Api\BillingAddressesController@update');
    Route::get('user-address', 'Api\BillingAddressesController@index');
    Route::get('user-address/{address}/edit','Api\BillingAddressesController@edit');
    Route::put('default-address/{address}', 'Api\BillingAddressesController@defaultAddress');
    Route::delete('user-address/{address}','Api\BillingAddressesController@destroooooooy');

    Route::get('checkout-address', 'Api\BillingAddressesController@displayDefaultAddress');



    Route::resource('items', 'Api\ItemsController');

    Route::resource('types', 'Api\TypesController');
    Route::resource('details', 'Api\DetailController')->only('index', 'show');
    Route::resource('categories', 'Api\CategoriesController')->only('index', 'show');
    Route::get('terms', 'Api\TermsController@index');
    Route::get('faqs', 'Api\FaqsController@index');
    
    Route::resource('cart', 'Api\CartController');

    /**
     * ******* [ITEM TRANSACTIONS] *******
     */
    Route::resource('transactions', 'Api\TransactionController')->only(['index', 'show', 'store']);
    Route::get('transactions/{transaction}/cancelled', 'Api\TransactionController@cancelled');
    Route::get('transactions/{transaction}/pending', 'Api\TransactionController@pending');
    Route::get('transactions/{transaction}/returned', 'Api\TransactionController@returned');

    Route::get('cancellations', 'Api\TransactionController@cancellations');
    Route::put('cart-cancellation/{cart}', 'Api\TransactionController@cancel');

    Route::get('myreturns', 'Api\TransactionController@myreturns');

    Route::get('transaction-item/{cart}', 'Api\TransactionController@display');

    /**
     * 
     * ******* [PAYPAL PAYMENT INTEGRATION] *******
     * 
     */
    Route::get('payment', 'Api\PayPalController@prepare')->name('payment');
    Route::get('cancel', 'Api\PayPalController@cancel')->name('payment.cancel');
    Route::get('payment/success', 'Api\PayPalController@success')->name('payment.success');



    /**
     * ******* [API AUTH] *******
     */
    Route::post('register', 'Api\AuthController@register');
    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout');
    Route::get('email/resend','Api\VerificationController@resend')->name('verification.resend');
    Route::get('email/verify/{id}/{hash}','Api\VerificationController@verify')->name('verification.verify');
    
});

Route::fallback('Api\FallBackController@index');