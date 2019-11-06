<?php



Auth::routes([
    'register' => false
]);

Route::group(['middleware' => 'auth'], function(){
    Route::get('/','AdminController@index')->name('dashboard');
    Route::resource('items', 'ItemController');
    Route::resource('brands', 'BrandsController');
    Route::resource('categories', 'CategoryController');
    Route::resource('types', 'TypeController');
    Route::resource('transactions', 'TransactionController');
    Route::resource('faqs', 'FaqController');
    Route::resource('terms', 'TermController');
    Route::resource('profile', 'ProfileController');

    /**
     * Route for item discounts
     */
    Route::post('items/{item}', 'ItemController@applyDiscount')->name('item.discount');
    Route::delete('items/{item}', 'ItemController@removeDiscount')->name('discount.destroy');

    /**
     * Transactions
     */
    Route::get('/transaction-history', function(){
        return view('pages.history.index');
    })->name('transaction.history');
    Route::get('forms/create', function(){
        return view('pages.forms.create');
    });

    /**
     * Invoice
     */
    Route::get('invoice', function () {
        return view('invoice.orders');
    });
    
    
});
