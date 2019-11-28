<?php

Auth::routes([
    'register' => false
]);

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
     * *********** [ ROUTE FOR APPLYING DISCOUNTS ON ITEMS ] ***********
     */
    Route::post('items/{item}', 'ItemController@applyDiscount')->name('item.discount');
    Route::delete('items/{item}', 'ItemController@removeDiscount')->name('discount.destroy');


    /**
     ******** [THIS ROUTE IS FOR MAKING PURCHASE_ORDER IN SESSION ONLY YOU MIGHT GET CONFUSE] **********
     */
    Route::resource('orders','PurchaseOrder\PurchaseOrderController')->only(['index', 'create', 'store']);
    /**
     * *********** [ ROUTE FOR CREATE VIEW OF PURCHASE ORDER ITEMS TOSESSION ] ***********
     */
    Route::get('orders/add-item','PurchaseOrder\PurchaseOrderController@addItems')->name('order.add');
    /**
     * *********** [ ROUTE FOR STORING PURCHASE ORDER ITEMS IN SESSION ] ***********
     */
    Route::get('order', 'PurchaseOrder\PurchaseOrderController@storeItems')->name('order.item');
    /**
     * *********** [ ROUTE FOR STORING PURCHASE ORDER TO DATABASE ] ***********
     */
    Route::post('order', 'PurchaseOrder\PurchaseOrderController@storePurchaseOrder')->name('store.item');

    Route::get('purchase-order/{purchase}', 'PurchaseOrder\PurchaseOrderController@showPurchaseOrder')->name('purchase.order');

    Route::get('show-session','PurchaseOrder\PurchaseOrderController@showSession');
    /**
     * *********** [ PURCHASE_ORDER ] ***************
     */
    
});

    /**
     * *********** [ ROUTES FOR DOWNLOADING EXCEL DATAS AND STORING TO DATABASE ] ***********
     */
    Route::get('download-list', 'AdminController@loadList');
    Route::get('download-type', 'AdminController@loadType');
    Route::get('download-brand', 'AdminController@loadBrand');
    Route::get('download-item', 'AdminController@loadItem');
    Route::get('download-all', 'AdminController@loadAll')->name('download.all');

    Route::get('response', 'AdminController@responseData');
