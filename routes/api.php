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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors']], function () {
    Route::resource('brands', 'Api\BrandsController');
    Route::resource('items', 'Api\ItemsController');
    Route::resource('types', 'Api\TypesController');

    Route::post('register', 'Api\AuthController@register');
    Route::post('login', 'Api\AuthController@login');
    Route::post('logout', 'Api\AuthController@logout');
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@coolmart.com'], 404);
});