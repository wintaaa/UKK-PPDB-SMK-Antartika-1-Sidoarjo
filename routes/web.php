<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Panitia\FormulirController;
use App\Http\Controllers\Panitia\PendaftaranController;
use App\Http\Controllers\Panitia\ValidasiController; 
use App\Http\Controllers\Bendahara\PembayaranController;
use App\Http\Controllers\Ketua\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Panitia\DashboardPanitiaController;
use App\Http\Controllers\HomeController; // Tambahkan ini

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda.
|
*/

// Rute Otentikasi
Auth::routes(); // Rute ini sudah mencakup login dan logout yang aman

// Redirect setelah login

Route::get('/', function(){
    return redirect()->route('home');
});

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Rute Panitia (Memerlukan autentikasi)
Route::middleware('auth')->prefix('panitia')->name('panitia.')->group(function () {
    // Rute utama untuk Panitia, mengarahkan '/' dan '/dashboard' ke dashboard
    Route::get('/', [DashboardPanitiaController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardPanitiaController::class, 'index'])->name('dashboard');

    // Rute untuk input formulir dan pendaftaran
    Route::get('/input-data', [DashboardPanitiaController::class, 'showFormInput'])->name('input_form_number');
    Route::post('/input-data', [DashboardPanitiaController::class, 'redirectToForm'])->name('redirect_to_form');
    Route::get('/formulir/{no_formulir}/input', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran/store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    // Rute untuk Validasi Data dan Daftar Pendaftar
    Route::prefix('validasi')->name('validasi.')->group(function () {
        Route::get('/', [ValidasiController::class, 'index'])->name('index');
        Route::get('/{pendaftar}', [ValidasiController::class, 'show'])->name('show');
        Route::put('/{pendaftar}', [ValidasiController::class, 'update'])->name('update');
    });

    // Rute untuk mencetak formulir
    Route::get('/cetak-formulir', [FormulirController::class, 'cetak'])->name('cetak.formulir');
});
// Perbaikan Rute Bendahara**
Route::middleware('auth')->prefix('bendahara')->name('bendahara.')->group(function () {
    // Rute utama dashboard bendahara
    Route::get('/', [PembayaranController::class, 'index'])->name('home');
    Route::get('/dashboard', [PembayaranController::class, 'index'])->name('dashboard.index');
    
    // Rute untuk menampilkan pendaftar yang belum lunas (manajemen pembayaran)
    Route::get('/pembayaran/belum-lunas', [PembayaranController::class, 'showBelumLunas'])->name('pembayaran.belum_lunas');
    
    // Rute untuk menampilkan pendaftar yang sudah lunas
    Route::get('/pembayaran/lunas', [PembayaranController::class, 'showLunas'])->name('pembayaran.lunas');
    
    // Rute untuk menampilkan pendaftar yang sudah di-refund
    Route::get('/pembayaran/refund', [PembayaranController::class, 'showRefund'])->name('pembayaran.refund_list');

    // Rute untuk detail formulir pembayaran
    Route::get('/pembayaran/{pendaftar}/form', [PembayaranController::class, 'show'])->name('pembayaran.show');
    
    // Rute untuk memproses pembayaran
    Route::post('/pembayaran/{pendaftar}/proses', [PembayaranController::class, 'prosesPembayaran'])->name('pembayaran.proses');
    
    // Rute untuk mencetak kwitansi
    Route::get('/pembayaran/{pendaftar}/kwitansi', [PembayaranController::class, 'cetakKwitansi'])->name('pembayaran.kwitansi');
    
    // Rute untuk memproses refund
    Route::post('/pembayaran/{pendaftar}/proses-refund', [PembayaranController::class, 'prosesRefund'])->name('pembayaran.refund');
});

// Rute Ketua/Admin (Memerlukan autentikasi)
Route::middleware('auth')->prefix('ketua')->name('ketua.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan/pdf', [DashboardController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/backup', [DashboardController::class, 'backupData'])->name('backup');
});