<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// LOGIN
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//CRUDNYA USER
Route::resource('user', UserController::class);

// Dashboard-route sesuai role
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
Route::get('/admin/DataPengguna', function () {
    return view('admin.DataPengguna');
});
Route::get('/admin/DataPelanggan', function () {
    return view('admin.DataPelanggan');
});
Route::get('/admin/DataKendaraan', function () {
    return view('admin.DataKendaraan');
});
Route::get('/admin/KontrakLeasing', function () {
    return view('admin.KontrakLeasing');
});
Route::get('/admin/Pembayaran', function () {
    return view('admin.Pembayaran');
});
Route::get('/admin/Laporan', function () {
    return view('admin.Laporan');
});
Route::get('/admin/profil', function () {
    return view('admin.profil');
});

Route::get('/marketing/dashboard', function () {
    return view('marketing.dashboard');
})->name('marketing.dashboard');

Route::get('/pelanggan/home', function () {
    return view('pelanggan.dashboard');
})->name('pelanggan.home');

Route::get('/manajer/dashboard', function () {
    return view('manajer.dashboard');
})->name('manajer.dashboard');

