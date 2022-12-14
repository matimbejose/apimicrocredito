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

Route::middleware('auth:api')->get('/accounts', function (Request $request) {
    return $request->user();
});

Route::post('/accounts/extractacc', 'AccountsController@extractacc')->middleware('auth:api');
Route::get('/accounts/extracts', 'AccountsController@extracts')->middleware('auth:api');
Route::get('/accounts/search', 'AccountsController@search_accounts')->middleware('auth:api');
Route::get('/accounts/retrieve_entire_pgc', 'AccountsController@get_all')->middleware('auth:api');
Route::get('/accounting/dashboard', 'DashboardController@index')->middleware('auth:api');
Route::resource('/accounts', 'AccountsController')->middleware('auth:api');
Route::resource('/journals', 'JournalController')->middleware('auth:api');