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

Route::middleware('auth:api')->get('/business', function (Request $request) {
    return $request->user();
});

//Route::resource('accounts', 'AccountController')->middleware('auth:api');
Route::get('businesses/listbusinessesmultiselect', 'BusinessController@listBusinessesVueFormMultiselect')->middleware('auth:api');
Route::get('businesses/show_default_prices', 'BusinessController@show_default_prices')->middleware('auth:api');
Route::post('businesses/default_prices', 'BusinessController@default_prices')->middleware('auth:api');
Route::post('businesses/rules', 'BusinessController@update_rules')->middleware('auth:api');
Route::resource('businesses', 'BusinessController')->middleware('auth:api');
Route::resource('settings/documents', 'DocumentController')->middleware('auth:api');
