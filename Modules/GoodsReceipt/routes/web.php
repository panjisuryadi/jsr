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
    $module_name = 'goodsreceipt';
    $controller_name = 'GoodsReceiptsController';

    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);


     Route::get("$module_name/get_produk", ['as' => "$module_name.get_produk", 'uses' => "$controller_name@get_produk"]);




    Route::resource("$module_name", "$controller_name");

});


