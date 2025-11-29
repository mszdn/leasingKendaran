<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\KontrakLeasingController;
use App\Http\Controllers\AngsuranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfilController;

Route::get('/', function () {
    return view('welcome');
});

// LOGIN
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Halaman utama



//dashboard admin
Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])
    ->name('admin.dashboard');

Route::get('/admin/DataPengguna', [UserController::class, 'indexAdmin'])
    ->name('admin.DataPengguna');

Route::get('/admin/DataPelanggan', [PelangganController::class, 'index'])
    ->name('admin.DataPelanggan');

Route::get('/admin/DataKendaraan', [KendaraanController::class, 'index'])
    ->name('admin.DataKendaraan');

Route::get('/admin/KontrakLeasing', [KontrakLeasingController::class, 'index'])
    ->name('admin.KontrakLeasing');
Route::put('/kontrak/verifikasi/{kontrak}', [KontrakLeasingController::class, 'verifikasi'])
    ->name('admin.KontrakLeasing.verifikasi');
Route::put('/kontrak/reject/{kontrak}', [KontrakLeasingController::class, 'reject'])
    ->name('admin.KontrakLeasing.reject');
Route::post('/admin/kontrak/store', [KontrakLeasingController::class, 'store'])->name('kontrak.store');
Route::put('/admin/kontrak/update/{kontrak}', [KontrakLeasingController::class, 'update'])->name('kontrak.update');
Route::delete('/admin/kontrak/delete/{kontrak}', [KontrakLeasingController::class, 'destroy'])->name('kontrak.delete');



Route::get('/admin/Pembayaran', [AngsuranController::class, 'index'])->name('admin.Pembayaran');
Route::post('/admin/Pembayaran', [AngsuranController::class, 'store'])->name('admin.Pembayaran.store');

Route::get('/admin/Laporan', [LaporanController::class, 'index'])->name('admin.Laporan');

Route::get('/admin/profil', [ProfilController::class, 'index'])->name('admin.profil');
Route::post('/admin/profil/update', [ProfilController::class, 'update'])->name('admin.profil.update');
Route::post('/admin/profil/password', [ProfilController::class, 'updatePassword'])->name('admin.profil.password');


Route::get('/marketing/dashboard', function () {
    return view('marketing.dashboard');
})->name('marketing.dashboard');

Route::get('/pelanggan/home', function () {
    return view('pelanggan.dashboard');
})->name('pelanggan.home');

Route::get('/manajer/dashboard', function () {
    return view('manajer.dashboard');
})->name('manajer.dashboard');


//crudnya
Route::resource('user', UserController::class);
Route::resource('pelanggan', PelangganController::class);
Route::resource('kendaraan', KendaraanController::class);
Route::resource('kontrak', KontrakLeasingController::class);
