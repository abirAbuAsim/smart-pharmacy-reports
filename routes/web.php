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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/sales', 'SalesOrderController@index')->name('sales');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/sales', 'SalesOrderController@showSearchResult');

Route::get('/purchase', 'PurchaseOrderController@index')->name('purchase');
Route::post('/purchase-search', 'PurchaseOrderController@showSearchResult');
