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
    //Product Adjustment
    Route::resource('adjustments', 'AdjustmentController');
    Route::get('adjustment/getdatatable', 'AdjustmentController@getdata')->name('adjustment.datatable');
    Route::post('adjustment/getbyqr', 'AdjustmentController@getbyqr')->name('adjustment.getbyqr');
    Route::get('adjustment/print/{id}', 'AdjustmentController@print')->name('adjustment.print');
    
    //Stock Transfer
    Route::get('stocktransfer', 'StockTransferController@index')->name('stocktransfer.index');
    Route::get('stocktransfer/create', 'StockTransferController@create')->name('stocktransfer.create');
    Route::get('stocktransfer/show/{id}', 'StockTransferController@show')->name('stocktransfer.show');
    Route::post('stocktransfer/create', 'StockTransferController@store')->name('stocktransfer.store');
    Route::get('stocktransfer/getdata', 'StockTransferController@getdata')->name('stocktransfer.getdata');
    Route::get('stocktransfer/getlocation/{location_id}', 'StockTransferController@getlocation')->name('stocktransfer.getlocation');
    
    //Product Stock
    Route::get('stocks', 'StocksController@index')->name('stocks.index');
    Route::get('stocks/getdata', 'StocksController@getdata')->name('stock.datatable');
    Route::get('stocks/getsummary', 'StocksController@getsummary')->name('stock.getsummary');
    Route::get('stocks/getone/{id}', 'StocksController@getone')->name('stock.getone');
    
    //adjustment setting
    Route::get('adjustments-setting', 'AdjustmentController@getsetting')->name('adjustment.getsetting');
    Route::get('adjustments/create/qrcode', 'AdjustmentController@create2')->name('adjustments.create.qrcode');
    Route::get('adjustments-setting2', 'AdjustmentController@getsetting2')->name('adjustment.getsetting2');
    Route::get('adjustments-setsetting', 'AdjustmentController@setsetting')->name('adjustment.setadjustment');

});
