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




Route::get('/', 'AuthController@index')->name('login');
Route::post('/login', 'AuthController@isLogin')->name('isLogin');
Route::get('/logout', 'AuthController@logout')->name('logout');
Route::get('/lupa-password', 'AuthController@lupaPassword')->name('lupaPassword');

// route group for staff
Route::group(['prefix' => 'petugas', 'as' => 'petugas.', 'middleware' => 'petugasauth:petugas'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('/anggota', 'AnggotaController')->names('anggota');
});