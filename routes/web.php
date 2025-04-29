<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaletypeController;

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
    'register' => false
]);

Route::group(['as'=>'admin.', 'middleware'=>['auth'], 'prefix'=>'admin'], function(){

	Route::get('employee/{employee}/remove',[EmployeeController::class, 'remove'])->name('employee.remove');
	Route::get('employee/trash', [EmployeeController::class, 'trash'])->name('employee.trash');
    Route::get('employee/recover/{id}', [EmployeeController::class, 'recoverEmp'])->name('employee.recover');

	Route::get('saletype/{saletype}/remove',[SaletypeController::class, 'remove'])->name('saletype.remove');
	Route::get('saletype/trash', [SaletypeController::class, 'trash'])->name('saletype.trash');
    Route::get('saletype/recover/{id}', [SaletypeController::class, 'recoverSaletype'])->name('saletype.recover');

	Route::get('sale/{sale}/remove',[SaleController::class, 'remove'])->name('sale.remove');
	Route::get('sale/trash', [SaleController::class, 'trash'])->name('sale.trash');
    Route::get('sale/recover/{id}', [SaleController::class, 'recoverSale'])->name('sale.recover');

    Route::post('sale/sortdata', [SaleController::class, 'getrange'])->name('sale.getrange');
    Route::post('home/sortdata', [HomeController::class, 'index'])->name('home.getrange');

    // On home.blade.php
    Route::PUT('home/getdatabyyear', [HomeController::class, 'index'])->name('home.getdatabyyear');


    Route::get('/managerprofile', [ProfileController::class, 'getmanager'])->name('managerprofile');
    Route::PUT('/managerprofile', [ProfileController::class, 'update'])->name('managerprofile.update');
    Route::PUT('/managerprofile/updatepassword', [ProfileController::class, 'updatepassword'])->name('managerprofile.updatepassword');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::PUT('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::PUT('/profile/updatepassword', [ProfileController::class, 'updatepassword'])->name('profile.updatepassword');

	Route::resource('/home',HomeController::class);
	Route::resource('/employee',EmployeeController::class);
	Route::resource('/sale',SaleController::class);
    Route::post('/sale/report_filter', [SaleController::class, 'report_filter'])->name('sale.report_filter');
	Route::resource('/saletype',SaletypeController::class);
});
