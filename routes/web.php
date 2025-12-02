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
use App\Http\Controllers\CustomerController;

use App\Http\Controllers\ManajerController;
use App\Http\Controllers\MarketingDashboardController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\PengajuanKontrakController;
use App\Http\Controllers\marketingpelanggancontroller;

use Maatwebsite\Excel\Facades\Excel;
// Export Files
use App\Exports\AnalisisKontrakExport;
use App\Exports\AnalisisPembayaranExport;
use App\Exports\MarketingPerformanceExport;
use App\Exports\PendapatanBulananExport;


Route::get('/', function () {
    return redirect()->route('login');
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

Route::post('/admin/DataPelanggan/store', [PelangganController::class, 'store'])
    ->name('admin.DataPelanggan.store');

Route::put('/admin/DataPelanggan/{pelanggan}/update', [PelangganController::class, 'update'])
    ->name('admin.DataPelanggan.update');

Route::delete('/admin/DataPelanggan/{pelanggan}/delete', [PelangganController::class, 'destroy'])
    ->name('admin.DataPelanggan.delete');


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
Route::post('/admin/Laporan/generate', [LaporanController::class, 'generate'])
    ->name('admin.Laporan.generate');


Route::get('/profil/profil', [ProfilController::class, 'index'])->name('profil.profil');
Route::post('/profil/profil/update', [ProfilController::class, 'update'])->name('profil.profil.update');
Route::post('/profil/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.profil.password');


Route::prefix('marketing')->name('marketing.')->group(function () {

    // Dashboard utama Marketing
    Route::get('/dashboard', [MarketingDashboardController::class, 'index'])
        ->name('dashboard');

    // Pelanggan Marketing (INI YANG BENAR)
    Route::get('/pelanggan', [MarketingPelangganController::class, 'index'])
        ->name('pelanggan.index');
    Route::post('/pelanggan', [MarketingPelangganController::class, 'store'])
        ->name('pelanggan.store');
    Route::put('/pelanggan/{pelanggan}/update', [MarketingPelangganController::class, 'update'])
        ->name('pelanggan.update');
    Route::delete('/pelanggan/{pelanggan}/delete', [MarketingPelangganController::class, 'destroy'])
        ->name('pelanggan.delete');

    // Ajuan
    Route::get('/ajuan', [MarketingController::class, 'ajuan'])
        ->name('ajuan');

    // Pengingat
    Route::get('/pengingat', [MarketingController::class, 'pengingat'])
        ->name('pengingat');
    Route::post('/pengingat/kirim/{id}', [MarketingController::class, 'kirimPengingat'])
        ->name('pengingat.kirim');

    // Profil
    Route::get('/profil', [MarketingController::class, 'profil'])
        ->name('profil');

    // Ajuan Saya
    Route::get('/ajuan-saya', [PengajuanKontrakController::class, 'ajuanSaya'])
        ->name('ajuanSaya');

    // Form Ajukan Kontrak Leasing
    Route::get('/ajukan-kontrak', [PengajuanKontrakController::class, 'create'])
        ->name('ajukanKontrak');

    // Simpan Kontrak
    Route::post('/kontrak/store', [PengajuanKontrakController::class, 'store'])
        ->name('kontrak.store');
});



Route::get('/pelanggan/home', [CustomerController::class, 'home'])->name('pelanggan.home');
Route::get('/pelanggan/riwayat', [CustomerController::class, 'riwayat'])->name('pelanggan.riwayat');
Route::get('/pelanggan/bayar', [CustomerController::class, 'bayar'])
    ->name('pelanggan.bayar');
Route::post('/pelanggan/bayar/process', [CustomerController::class, 'processBayar'])
    ->name('pelanggan.bayar.process');


//dashboard manajer
// =======================
//     DASHBOARD MANAJER
// =======================
Route::prefix('manajer')->group(function () {

    // Halaman utama dashboard manajer
    Route::get('/dashboard', [ManajerController::class, 'dashboard'])->name('manajer.dashboard');

    // Halaman analisis
    Route::get('/AnalisisKontrak', [ManajerController::class, 'analisisKontrak'])
        ->name('manajer.AnalisisKontrak');

    Route::get('/AnalisisPembayaran', [ManajerController::class, 'analisisPembayaran'])
        ->name('manajer.AnalisisPembayaran');

    Route::get('/LaporanPendapatan', [ManajerController::class, 'laporanPendapatan'])
        ->name('manajer.LaporanPendapatan');

    Route::get('/MarketingPerformance', [ManajerController::class, 'marketingPerformance'])
        ->name('manajer.MarketingPerformance');


    // ====================================
    //            EXPORT FILES
    // ====================================

    // Export Analisis Pembayaran
    Route::get('/export/analisis-pembayaran', function () {
        return Excel::download(new AnalisisPembayaranExport, 'analisis_pembayaran.xlsx');
    })->name('export.AnalisisPembayaran');

    // Export Analisis Kontrak
    Route::get('/export/analisis-kontrak', function () {
        return Excel::download(new AnalisisKontrakExport, 'analisis_kontrak.xlsx');
    })->name('export.AnalisisKontrak');

    // Export Marketing Performance
    Route::get('/export/marketing-performance', function () {
        return Excel::download(new MarketingPerformanceExport, 'marketing_performance.xlsx');
    })->name('export.MarketingPerformance');

    // Export Pendapatan Bulanan (Line chart)
    Route::get('/export/pendapatan-bulanan', function () {
        return Excel::download(new PendapatanBulananExport, 'pendapatan_bulanan.xlsx');
    })->name('export.PendapatanBulanan');
});

//crudnya
Route::resource('user', UserController::class);
Route::resource('kendaraan', KendaraanController::class);
Route::resource('kontrak', KontrakLeasingController::class);
