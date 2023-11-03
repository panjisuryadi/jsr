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
    $module_name = 'distribusitoko';
    $controller_name = 'DistribusiTokosController';

    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);

     Route::get("$module_name/index_data_table", ['as' => "$module_name.index_data_table", 'uses' => "$controller_name@index_data_table"]);

    

    Route::get("$module_name/detail/{dist_toko}", ['as' => "$module_name.detail", 'uses' => "$controller_name@detail"]);

  Route::get("$module_name/detail-distribusi/{dist_toko}", ['as' => "$module_name.detail_distribusi", 'uses' => "$controller_name@detail_distribusi"]);



    Route::post("$module_name/approve-distribusi/{id}", ['as' => "$module_name.approve_distribusi", 'uses' => "$controller_name@approve_distribusi"]);


    

    Route::get("$module_name/kategori/{slug}", ['as' => "$module_name.kategori", 'uses' => "$controller_name@kategori"]);

  Route::get("$module_name/cetak/{id}", ['as' => "$module_name.cetak", 'uses' => "$controller_name@cetak"]);


    Route::get("$module_name/send/{dist_toko}", ['as' => "$module_name.send", 'uses' => "$controller_name@send"]);
    Route::resource("$module_name", "$controller_name");

});


