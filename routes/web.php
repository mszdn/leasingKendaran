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

Route::get('/marketing/dashboard', function () {
    return view('marketing.dashboard');
})->name('marketing.dashboard');

Route::get('/pelanggan/home', function () {
    return view('pelanggan.dashboard');
})->name('pelanggan.home');

Route::get('/manajer/dashboard', function () {
    return view('manajer.dashboard');
})->name('manajer.dashboard');

