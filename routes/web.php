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

// route group for admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'petugasauth:admin'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('/petugas', 'PetugasController')->names('petugas');
    Route::resource('/sekolah', 'SekolahController')->names('sekolah');
    Route::resource('/kategori_simpanan', 'KategoriSimpananController')->names('kategori-simpanan');
    Route::get('/laporan/simpanan', 'LaporanController@simpananBulanan')->name('laporan.simpanan-bulanan');
    Route::get('/laporan/simpanan_tahunan', 'LaporanController@simpananTahunan')->name('laporan.simpanan-tahunan');
});


// route group for staff
Route::group(['prefix' => 'petugas', 'as' => 'petugas.', 'middleware' => 'petugasauth:petugas'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('/anggota', 'AnggotaController')->names('anggota');
    Route::resource('/simpanan', 'SimpananController')->names('simpanan');
    Route::resource('/pinjaman', 'PinjamanController')->names('pinjaman');
    Route::resource('/cicilan', 'CicilanController')->names('cicilan');
    Route::get('/penarikan/simpanan', 'PenarikanController@simpanan')->name('penarikan.simpanan');
    Route::get('/penarikan/dana-sosial', 'PenarikanController@danaSosial')->name('penarikan.dana-sosial');
    Route::get('/laporan/tagihan', 'LaporanController@tagihan')->name('laporan.tagihan');
    
});

