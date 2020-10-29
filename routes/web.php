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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'items', 'middleware' => 'auth'], function(){
    Route::get('index', 'ItemController@index')->name('items.index');
    Route::get('create', 'ItemController@create')->name('items.create');
    Route::post('store', 'ItemController@store')->name('items.store');
    Route::get('{item_id}/start', 'ItemController@start')->name('items.start');
    Route::get('{item_id}/end', 'ItemController@end')->name('items.end');
});

Route::get('/home', 'HomeController@index')->name('home');
