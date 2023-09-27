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
    $module_name = 'datasale';
    $controller_name = 'DataSalesController';
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/show_data/{detail}", ['as' => "$module_name.show_data", 'uses' => "$controller_name@show_data"]);
    Route::get("$module_name/show_stock/{detail}", ['as' => "$module_name.show_stock", 'uses' => "$controller_name@show_stock"]);
    Route::resource("$module_name", "$controller_name");

});


