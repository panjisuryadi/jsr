<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'auth'], function () {
    //Print Barcode
    Route::get('/products/print-barcode', 'BarcodeController@printBarcode')->name('barcode.print');

    //Product
      Route::get("products/index_data", ['as' => "products.index_data", 'uses' => "ProductController@index_data"]);
    Route::resource('products', 'ProductController');

    //Product Category
     Route::get("product-categories/index_data", ['as' => "categories.index_data", 'uses' => "CategoriesController@index_data"]);
    Route::resource('product-categories', 'CategoriesController')->except('create', 'show');
});

