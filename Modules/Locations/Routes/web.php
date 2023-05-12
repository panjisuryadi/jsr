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
    //Product
    Route::resource('locations', 'LocationsController');
     Route::get('/locations/parent/{parent}', 'LocationsController@getParent')->name('locations.parent');
     Route::get('/locations/getone/{id}', 'LocationsController@getone')->name('locations.getone');
    //Product Category

});

