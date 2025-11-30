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
use App\Http\Controllers\BayarPelangganController;


Route::get('/', function () {
    return view('welcome');
});

// LOGIN
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// DASHBOARD ADMIN
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

Route::put('/admin/KontrakLeasing/{kontrak:kontrak_id}/verifikasi', [KontrakLeasingController::class, 'verifikasi'])
    ->name('admin.KontrakLeasing.verifikasi');

Route::get('/admin/Pembayaran', [AngsuranController::class, 'index'])->name('admin.Pembayaran');
Route::post('/admin/Pembayaran', [AngsuranController::class, 'store'])->name('admin.Pembayaran.store');

Route::get('/admin/Laporan', [LaporanController::class, 'index'])->name('admin.Laporan');

Route::get('/admin/profil', [ProfilController::class, 'index'])->name('admin.profil');
Route::post('/admin/profil/update', [ProfilController::class, 'update'])->name('admin.profil.update');
Route::post('/admin/profil/password', [ProfilController::class, 'updatePassword'])->name('admin.profil.password');

// DASHBOARD MARKETING
Route::get('/marketing/dashboard', function () {
    return view('marketing.dashboard');
})->name('marketing.dashboard');

// DASHBOARD PELANGGAN
Route::get('/pelanggan/home', [PelangganController::class, 'home'])->name('pelanggan.home');
Route::get('/pelanggan/riwayat', [PelangganController::class, 'riwayat'])->name('pelanggan.riwayat');
Route::get('/pelanggan/bayar', [PelangganController::class, 'bayar'])
        ->name('pelanggan.bayar');

Route::post('/pelanggan/bayar/proses/{id}', [PelangganController::class, 'prosesBayar'])
    ->name('pelanggan.bayar.proses');


// DASHBOARD MANAJER
Route::get('/manajer/dashboard', function () {
    return view('manajer.dashboard');
})->name('manajer.dashboard');

// CRUD
Route::resource('user', UserController::class);
Route::resource('pelanggan', PelangganController::class)->except(['show']); // FIX conflict
Route::resource('kendaraan', KendaraanController::class);
Route::resource('kontrak', KontrakLeasingController::class);