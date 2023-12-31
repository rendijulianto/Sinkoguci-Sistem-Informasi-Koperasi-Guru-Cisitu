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
Route::post('/reset-password', 'AuthController@resetPassword')->name('resetPassword');

// route group for admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'petugasauth:admin'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('/petugas', 'PetugasController')->names('petugas');
    Route::resource('/sekolah', 'SekolahController')->names('sekolah');
    Route::resource('/kategori_simpanan', 'KategoriSimpananController')->names('kategori-simpanan');
    Route::get('/simpanan', 'SimpananController@indexAdmin')->name('simpanan.index');
    Route::put('/simpanan/{id}', 'SimpananController@update')->name('simpanan.update');
    Route::delete('/simpanan/{id}', 'SimpananController@destroy')->name('simpanan.destroy');
    Route::post('/kategori_simpanan/ubah/masal/jumlah', 'KategoriSimpananController@ubahMasalJumlah')->name('kategori-simpanan.ubah-masal-jumlah');
    Route::get('/pinjaman', 'PinjamanController@indexAdmin')->name('pinjaman.index');
    Route::get('/pinjaman/{id}/angsuran', 'PinjamanController@angsuran')->name('pinjaman.angsuran');
    Route::delete('/pinjaman/{id}', 'PinjamanController@destroy')->name('pinjaman.destroy');
    Route::delete('/pinjaman/{id}/angsuran/{tgl_bayar}/{bayar_pokok}/{bayar_jasa}/{setelah_pokok}/{setelah_jasa}', 'PinjamanController@destroyAngsuran')->name('pinjaman.destroy-angsuran');
});


// route group for staff
Route::group(['prefix' => 'petugas', 'as' => 'petugas.', 'middleware' => 'petugasauth:petugas'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('/anggota', 'AnggotaController')->names('anggota');
    Route::post('anggota/update_nominal_default_simpanan/{id}', 'AnggotaController@updateNominalDefaultSimpanan')->name('anggota.update-nominal-default-simpanan');
    Route::get('/cetak/anggota/{id}', 'AnggotaController@cetak')->name('anggota.cetak');
    Route::resource('/simpanan', 'SimpananController')->names('simpanan');
    Route::get('/pinjaman/tambah-jasa-tagihan-bulan-baru', 'PinjamanController@tambahJasaTagihanBulanBaru')->name('pinjaman.tambah-jasa-tagihan-bulan-baru');
    Route::resource('/pinjaman', 'PinjamanController')->names('pinjaman');
    Route::resource('/angsuran', 'AngsuranController')->names('angsuran');
    Route::get('/penarikan/simpanan', 'PenarikanController@simpanan')->name('penarikan.simpanan');
    Route::post('/penarikan/simpanan', 'PenarikanController@store')->name('penarikan.store');
    Route::get('/penarikan/simpanan/{id}', 'PenarikanController@show')->name('penarikan.show');
    Route::get('/penarikan/dana-sosial', 'PenarikanController@danaSosial')->name('penarikan.dana-sosial');
    Route::post('/penarikan/dana-sosial', 'PenarikanController@storeDanaSosial')->name('penarikan.store-dana-sosial');
    Route::get('/laporan/tagihan', 'LaporanController@tagihan')->name('laporan.tagihan');
    Route::get('/laporan/pembayaran', 'LaporanController@pembayaran')->name('laporan.pembayaran');
    Route::get('/laporan/rekap_pembayaran', 'LaporanController@rekapPembayaran')->name('laporan.rekap-pembayaran');
});

