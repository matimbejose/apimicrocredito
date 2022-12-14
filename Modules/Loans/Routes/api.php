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

Route::post('/loans/simulate', 'LoansController@simulate')->middleware('auth:api');
Route::post('loans/disburse', 'LoansController@disburse')->middleware('auth:api');
Route::post('loans/restruct', 'LoansController@restruct')->middleware('auth:api');
Route::post('loans/monthly_recognization', 'LoansController@monthly_recognization')->middleware('auth:api');
Route::post('loans/forget_loan', 'LoansController@forget_loan')->middleware('auth:api');
Route::get('loans/reports_filter', 'LoansController@reports_filter')->middleware('auth:api');
Route::get('dashboard', 'LoansController@dashboard')->middleware('auth:api');
Route::get('loans/showall', 'LoansController@showitall')->middleware('auth:api');
Route::get('loans/credit_wallet', 'LoansController@reports')->middleware('auth:api');
Route::post('loans/approve_or_disapprove', 'LoansController@approveOrDisapprove')->middleware('auth:api');
Route::resource('/loans', 'LoansController')->middleware('auth:api');
Route::resource('/credit_types', 'CreditTypesController')->middleware('auth:api');

//Loans transactions
Route::get('payments_bill/{id}', 'LoanPaymentsController@payments_bill')->middleware('auth:api');
Route::get('loans_payments/next/{id}', 'LoanPaymentsController@next_payment')->middleware('auth:api');
Route::get('customer_deposits', 'LoanPaymentsController@payments')->middleware('auth:api');
Route::resource('loans_payments', 'LoanPaymentsController')->middleware('auth:api');