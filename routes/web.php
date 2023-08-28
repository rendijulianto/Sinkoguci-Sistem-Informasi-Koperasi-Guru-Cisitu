<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', 'AuthController@index')->name('test');

// route group for staff
Route::group(['prefix' => 'staff', 'as' => 'staff.'], function () {
    Route::get('/dashboard', 'Staff\DashboardController@index')->name('dashboard');
    // simpanan
    Route::get('/deposit', 'Staff\DepositController@index')->name('deposit');
});