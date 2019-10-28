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

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', function () {
        return view('pages.index');
    })->name('dashboard');

    Route::resource('items', 'ItemController');
    Route::resource('brands', 'BrandsController');
    Route::resource('categories', 'CategoryController');
    Route::resource('types', 'TypeController');
    Route::resource('transactions', 'TransactionController');



    Route::get('/transaction-history', function(){
        return view('pages.history.index');
    })->name('transaction.history');
    Route::get('forms/create', function(){
        return view('pages.forms.create');
    });

    Route::get('invoice', function () {
        return view('invoice.orders');
    });
    
    
});
