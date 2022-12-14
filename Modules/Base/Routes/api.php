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


Route::post('login', 'UsersController@login');

Route::post('logout', 'UsersController@logout')->middleware('auth:api');

Route::resource('users', 'UsersController')->middleware('auth:api');

/*
|
| Roles Routes
|
*/
Route::get('permissions', 'RolesController@permissions')->middleware('auth:api');
Route::get('roles/listrolesmultiselect', 'RolesController@listRolesVueFormMultiselect')->middleware('auth:api');
Route::resource('roles', 'RolesController')->middleware('auth:api');

