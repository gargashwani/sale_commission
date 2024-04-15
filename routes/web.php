<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SaletypeController;
use Illuminate\Support\Facades\Route;

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

Auth::routes([
    // 'register' => false
]);

Route::group(['as'=>'admin.', 'middleware'=>['auth','admin'], 'prefix'=>'admin'], function(){

	Route::get('employee/{employee}/remove',[EmployeeController::class, 'remove'])->name('employee.remove');
	Route::get('employee/trash', [EmployeeController::class, 'trash'])->name('employee.trash');
    Route::get('employee/recover/{id}', [EmployeeController::class, 'recoverEmp'])->name('employee.recover');

	Route::get('saletype/{saletype}/remove',[SaletypeController::class, 'remove'])->name('saletype.remove');
	Route::get('saletype/trash', [SaletypeController::class, 'trash'])->name('saletype.trash');
    Route::get('saletype/recover/{id}', [SaletypeController::class, 'recoverSaletype'])->name('saletype.recover');

	Route::get('sale/{sale}/remove','SaleController@remove')->name('sale.remove');
	Route::get('sale/trash', 'SaleController@trash')->name('sale.trash');
    Route::get('sale/recover/{id}', 'SaleController@recoverSale')->name('sale.recover');

    Route::post('sale/sortdata', 'SaleController@getrange')->name('sale.getrange');
    Route::post('home/sortdata', [HomeController::class, 'index'])->name('home.getrange');

    // On home.blade.php
    Route::PUT('home/getdatabyyear', [HomeController::class, 'index'])->name('home.getdatabyyear');


    Route::get('/managerprofile', 'ProfileController@getmanager')->name('managerprofile');
    Route::PUT('/managerprofile', 'ProfileController@update')->name('managerprofile.update');
    Route::PUT('/managerprofile/updatepassword', 'ProfileController@updatepassword')->name('managerprofile.updatepassword');

    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::PUT('/profile', 'ProfileController@update')->name('profile.update');
    Route::PUT('/profile/updatepassword', 'ProfileController@updatepassword')->name('profile.updatepassword');

	Route::resource('/home','HomeController');
	Route::resource('/employee','EmployeeController');
	Route::resource('/sale','SaleController');
	Route::resource('/saletype','SaletypeController');
});
