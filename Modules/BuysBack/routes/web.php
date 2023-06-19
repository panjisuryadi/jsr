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

Route::group(['middleware' => 'auth'], function () {
    $module_name = 'buysback';
    $controller_name = 'BuysBacksController';
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    //save type
    Route::post('buys-back/save-customer', 'BuysBacksController@saveTypeCustomer')->name('buysback.save.customer');
    //type
    Route::get('/buys-back-type/{type}', 'BuysBacksController@type')->name('buys-back.type');
    Route::resource("$module_name", "$controller_name");

});


