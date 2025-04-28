<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes(['register' => false]);
Route::get('language/{language}', 'LanguageController@switch')->name('language.switch');



Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')
        ->name('home');  
    Route::get('/home/distribusi', 'HomeController@distribusi')
        ->name('home.distribusi');
    Route::get('/home/buys-backnota', 'HomeController@buysbacknota')
        ->name('home.buysbacknota');

    Route::get('/sales-purchases/chart-data', 'HomeController@salesPurchasesChart')
        ->name('sales-purchases.chart');

    Route::get('/current-month/chart-data', 'HomeController@currentMonthChart')
        ->name('current-month.chart');

    Route::get('/payment-flow/chart-data', 'HomeController@paymentChart')
        ->name('payment-flow.chart');

    Route::get('/sale', 'JualController@list')
        ->name('sale.list');

    Route::get('/config/index_data', 'ConfigController@index_data')
        ->name('config.index_data');

    Route::get('/config/nota', 'ConfigController@test_nota')
        ->name('config.nota');

    Route::get('/config', 'ConfigController@list')
        ->name('config.index');

    Route::post('/config/insert', 'ConfigController@insert')
        ->name('config.insert');

    Route::post('/config/update', 'ConfigController@update')
        ->name('config.update');

    Route::post('/config', 'ConfigController@create')
        ->name('config.index');

    Route::get('/buyback', 'BuybackController@list')
        ->name('buyback.list');

    Route::get('/buyback_index_data', 'BuybackController@index_data')
        ->name('buyback.index_data');

    Route::post('/buyback_insert', 'BuybackController@insert')
        ->name('buyback.insert');

    Route::get('/product_history', 'HistoryProductsController@list')
        ->name('history_product.list');

    Route::get('/product_history_data', 'HistoryProductsController@product_data')
        ->name('history_product.product_data');

    Route::get('/test_pdf', 'JualController@test_pdf')
        ->name('sale.test_pdf');

    Route::get('/sale/index_data', 'JualController@index_data')
        ->name('sale.index_data');

    Route::get('/sale/action', 'JualController@action')
        ->name('sale.action');

    Route::post('/sale/insert', 'JualController@insert')
        ->name('sale.insert');

    Route::get('/products_nota', 'ProductController@list')
        ->name('products.list');
    
    Route::get('/products_emas', 'ProductController@list_emas')
        ->name('products.emas');

    Route::get('/products_all', 'ProductController@list_all')
        ->name('products.all');

    Route::get('/products_luar', 'ProductController@list_luar')
        ->name('products.luar');

    Route::get('/products_dataluar', 'ProductController@index_dataluar')
        ->name('products.dataluar');

    Route::post('/products_insert_luar', 'ProductController@insert_luar')
        ->name('products.insert_luar');

    Route::get('/products_pending', 'ProductController@list_pending')
        ->name('products.pending');

    Route::post('/products_insert', 'ProductController@insert')
        ->name('products.insert');

    Route::post('/products_insert', 'ProductController@insert')
        ->name('products.insert');

    Route::get('/products_data/{id}', 'ProductController@data_nota')
        ->name('products.data');

    Route::post('/products_all_data', 'ProductController@data_all')
        ->name('products.all_data');

    Route::get('/karats', 'KaratController@list')
        ->name('karats.list');

    Route::post('/karats', 'KaratController@insert')
        ->name('karats.insert');

    Route::post('/karats_update', 'KaratController@update')
        ->name('karats.update');

    Route::get('/karats_history', 'KaratController@history')
        ->name('karats.history');

    Route::get('/karats_history_data', 'KaratController@history_data')
        ->name('karats.history_data');

    Route::get('/penerimaan-barangs', 'GoodReceiptController@create')
        ->name('penerimaan.create');

    Route::get('/penerimaan-barangs/qr/{id}', 'GoodReceiptController@qr')
        ->name('penerimaan.qr');

    Route::get('/penerimaan-barangs/qr_data/{id}', 'GoodReceiptController@qr_data')
        ->name('penerimaan.qr_data');

    Route::get('/penerimaan-barangs/detail/{id}', 'GoodReceiptController@detail')
        ->name('penerimaan.detail');

    Route::get('/penerimaan-barangs/product/{id}', 'GoodReceiptController@products')
        ->name('penerimaan.product');
    
    Route::post('/penerimaan-barangs/product', 'GoodReceiptController@product_update')
        ->name('penerimaan.product_update');
    
    Route::post('/penerimaan-barangs', 'GoodReceiptController@insert')
        ->name('penerimaan.insert');

    Route::get('/penerimaan-barangs/tambah', 'GoodReceiptController@tambah')
        ->name('penerimaan.tambah');
});

