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

Route::get('/search_managers', 'ManagersController@search_managers')->middleware('auth:api');
Route::get('/managers/loans/{id}', 'ManagersController@loans')->middleware('auth:api');
Route::resource('/managers', 'ManagersController')->middleware('auth:api');