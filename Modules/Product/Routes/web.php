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
      Route::post("products/save", ['as' => "products.save", 'uses' => "ProductController@save"]);

  //Product
      Route::post("products/saveajax", ['as' => "products.saveajax", 'uses' => "ProductController@saveAjax"]);




      Route::get("products/index_data", ['as' => "products.index_data", 'uses' => "ProductController@index_data"]);

      Route::get("products/list-reparasi", ['as' => "products.reparasi", 'uses' => "ProductController@listReparasi"]);

     Route::get("products/list-rfid", ['as' => "products.rfid", 'uses' => "ProductController@listRfid"]);

       Route::get("products/list-sortir", ['as' => "products.sortir", 'uses' => "ProductController@sortir"]);

  Route::get("products/ajax-list-sortir", ['as' => "products.ajax_sortir", 'uses' => "ProductController@index_data_sortir"]);



    Route::get("products/show-sortir/{product}", ['as' => "products.show_sortir", 'uses' => "ProductController@show_sortir"]);


   Route::patch("products/sortir_update/{id}", ['as' => "products.sortir_update", 'uses' => "ProductController@sortirUpdate"]);



///data RFID

    Route::patch("products/rfid_update/{id}", ['as' => "products.rfid_update", 'uses' => "ProductController@rfidUpdate"]);



     Route::get("products/ajax-list-rfid", ['as' => "products.ajax_rfid", 'uses' => "ProductController@index_data_rfid"]);

    Route::get("products/show-rfid/{product}", ['as' => "products.show_rfid", 'uses' => "ProductController@show_rfid"]);

//=============================================

      Route::post("products/code-generate", ['as' => "products.code_generate", 'uses' => "ProductController@codeGenerate"]);


      Route::get("products/create-modal", ['as' => "products.create-modal", 'uses' => "ProductController@createModal"]);

      Route::get("products/getproduct", ['as' => "products.getsalesProduct", 'uses' => "ProductController@getsalesProduct"]);
      Route::get("products/getone/{id}", ['as' => "products.getone", 'uses' => "ProductController@getone"]);


       Route::get("add-products-categories/{id}",
        ['as' => "products.add_products_categories",
         'uses' => "ProductController@add_products_categories"]);


       Route::get("add-products-modal-categories/{id}",
        ['as' => "products.add_products_modal_categories",
         'uses' => "ProductController@add_products_modal_categories"]);


    Route::resource('products', 'ProductController');
    //Product Category
     Route::get("product-categories/index_data", ['as' => "categories.index_data", 'uses' => "CategoriesController@index_data"]);
    Route::resource('product-categories', 'CategoriesController')->except('create', 'show');


 //Product Transfer
     Route::get("product-transfer/index_data", ['as' => "products.transfer.index_data", 'uses' => "ProductTransferController@index_data"]);

     Route::get("product-transfer/detail/{id}", ['as' => "products.transfer.detail", 'uses' => "ProductTransferController@detail"]);

      Route::get("product-transfer/approve/{id}", ['as' => "products.transfer.approve", 'uses' => "ProductTransferController@approveModal"]);

      Route::post("product-transfer/approve-barang", ['as' => "products.transfer.approvebarang", 'uses' => "ProductTransferController@ApproveProducts"]);



    Route::get('/products-transfer-type/{type}', 'ProductTransferController@type')->name('products.transfer.type');


      Route::resource('product-transfer', 'ProductTransferController')->except('create', 'show');





});

