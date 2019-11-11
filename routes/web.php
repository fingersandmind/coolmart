<?php



Auth::routes([
    'register' => false
]);
Route::get('test/{id}', function($id){
    $user = auth()->user();
    $item = App\Item::findOrFail($id);
    return $item->isPurchasedByAuth();
});

Route::get('home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'is_admin']], function(){
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
