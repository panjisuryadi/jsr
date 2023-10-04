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
    $module_name = 'stok';
    $controller_name = 'StoksController';

    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);

   Route::get("$module_name/nolate", ['as' => "$module_name.nolate", 'uses' => "$controller_name@nolate"]);


 Route::get("$module_name/office", ['as' => "$module_name.office", 'uses' => "$controller_name@office"]);

 Route::get("$module_name/index_data_office", ['as' => "$module_name.index_data_office", 'uses' => "$controller_name@index_data_office"]);


 Route::get("$module_name/pending", ['as' => "$module_name.pending", 'uses' => "$controller_name@pending"]);

Route::get("$module_name/pending/{id}", ['as' => "$module_name.view_pending", 'uses' => "$controller_name@view_pending"]);



 Route::get("$module_name/index_data_pending", ['as' => "$module_name.index_data_pending", 'uses' => "$controller_name@index_data_pending"]);

 Route::get("$module_name/sales", ['as' => "$module_name.sales", 'uses' => "$controller_name@sales"]);

 Route::get("$module_name/index_data_sales", ['as' => "$module_name.index_data_sales", 'uses' => "$controller_name@index_data_sales"]);



 Route::get("$module_name/dp", ['as' => "$module_name.dp", 'uses' => "$controller_name@dp"]);

 Route::get("$module_name/index_data_dp", ['as' => "$module_name.index_data_dp", 'uses' => "$controller_name@index_data_dp"]);



 Route::get("$module_name/kroom", ['as' => "$module_name.kroom", 'uses' => "$controller_name@kroom"]);

 Route::get("$module_name/index_data_kroom", ['as' => "$module_name.index_data_kroom", 'uses' => "$controller_name@index_data_kroom"]);






    Route::resource("$module_name", "$controller_name");

});


