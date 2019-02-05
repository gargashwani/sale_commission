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

Auth::routes(['register' => false]);

Route::group(['as'=>'admin.', 'middleware'=>['auth','admin'], 'prefix'=>'admin'], function(){

	Route::get('employee/{employee}/remove','EmployeeController@remove')->name('employee.remove');
	Route::get('employee/trash', 'EmployeeController@trash')->name('employee.trash');
    Route::get('employee/recover/{id}', 'EmployeeController@recoverEmp')->name('employee.recover');

	Route::get('saletype/{saletype}/remove','SaletypeController@remove')->name('saletype.remove');
	Route::get('saletype/trash', 'SaleTypeController@trash')->name('saletype.trash');
    Route::get('saletype/recover/{id}', 'SaleTypeController@recoverSaletype')->name('saletype.recover');

	Route::get('sale/{sale}/remove','SaleController@remove')->name('sale.remove');
	Route::get('sale/trash', 'SaleController@trash')->name('sale.trash');
    Route::get('sale/recover/{id}', 'SaleController@recoverSale')->name('sale.recover');

    Route::post('sale/sortdata', 'SaleController@getrange')->name('sale.getrange');
    Route::post('home/sortdata', 'HomeController@index')->name('home.getrange');

    // On home.blade.php
    Route::PUT('home/getdatabyyear', 'HomeController@index')->name('home.getdatabyyear');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::PUT('/profile', 'ProfileController@update')->name('profile.update');
    Route::PUT('/profile/updatepassword', 'ProfileController@updatepassword')->name('profile.updatepassword');

	Route::resource('/home','HomeController');
	Route::resource('/employee','EmployeeController');
	Route::resource('/sale','SaleController');
	Route::resource('/saletype','SaletypeController');
});
