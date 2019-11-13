<?php



Auth::routes([
    'register' => false
]);
Route::get('test/{id}', function($id){
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
    Route::resource('lists', 'AirconListController');

    /**
     * Route for item discounts
     */
    Route::post('items/{item}', 'ItemController@applyDiscount')->name('item.discount');
    Route::delete('items/{item}', 'ItemController@removeDiscount')->name('discount.destroy');

    
    Route::get('orders/create','PurchaseOrder\PurchaseOrderController@create')->name('orders.create');
    Route::post('orders','PurchaseOrder\PurchaseOrderController@store')->name('orders.store');
    /**
     * Route for adding item template
     */
    Route::get('orders/add-item','PurchaseOrder\PurchaseOrderController@addItems')->name('order.add');
    /**
     * Route for storing item
     */
    Route::get('order', 'PurchaseOrder\PurchaseOrderController@storeItems')->name('order.item');

    Route::get('show-session','PurchaseOrder\PurchaseOrderController@showSession');

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

    /**
     * Download List of Aircon Brand and Model
     */
    Route::get('download-list', 'AdminController@loadList');
    Route::get('download-type', 'AdminController@loadType');
    Route::get('download-brand', 'AdminController@loadBrand');
    Route::get('download-item', 'AdminController@loadItem');
    Route::get('download-all', 'AdminController@loadAll');
