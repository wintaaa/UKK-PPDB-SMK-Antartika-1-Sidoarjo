<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Panitia\FormulirController;
use App\Http\Controllers\Panitia\PendaftaranController;
use App\Http\Controllers\Panitia\ValidasiController; 
use App\Http\Controllers\Panitia\JurusanPricingController;
use App\Http\Controllers\Bendahara\PembayaranController;
use App\Http\Controllers\Bendahara\CicilanController;
use App\Http\Controllers\Ketua\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Panitia\DashboardPanitiaController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Publik & Utama
Route::get('/', function(){
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// ==========================================
// Rute Panitia
// ==========================================
Route::middleware('auth')->prefix('panitia')->name('panitia.')->group(function () {
    Route::get('/', [DashboardPanitiaController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardPanitiaController::class, 'index'])->name('dashboard');

    Route::get('/input-data', [DashboardPanitiaController::class, 'showFormInput'])->name('input_form_number');
    Route::post('/input-data', [DashboardPanitiaController::class, 'redirectToForm'])->name('redirect_to_form');
    Route::get('/formulir/{no_formulir}/input', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran/store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

    Route::prefix('validasi')->name('validasi.')->group(function () {
        Route::get('/', [ValidasiController::class, 'index'])->name('index');
        Route::get('/{pendaftar}', [ValidasiController::class, 'show'])->name('show');
        Route::put('/{pendaftar}', [ValidasiController::class, 'update'])->name('update');
    });

    Route::get('/cetak-formulir', [FormulirController::class, 'cetak'])->name('cetak.formulir');

    Route::prefix('pricing')->name('pricing.')->group(function () {
        Route::get('/', [JurusanPricingController::class, 'index'])->name('index');
        Route::get('/{jurusan}/edit', [JurusanPricingController::class, 'edit'])->name('edit');
        Route::put('/{jurusan}', [JurusanPricingController::class, 'update'])->name('update');
    });
});

// ==========================================
// Rute Bendahara (SUDAH DIPERBAIKI)
// ==========================================
Route::middleware('auth')->prefix('bendahara')->name('bendahara.')->group(function () {
    // Dashboard & List Pembayaran
    Route::get('/', [PembayaranController::class, 'index'])->name('home');
    Route::get('/dashboard', [PembayaranController::class, 'index'])->name('dashboard.index');
    Route::get('/pembayaran/belum-lunas', [PembayaranController::class, 'showBelumLunas'])->name('pembayaran.belum_lunas');
    Route::get('/pembayaran/lunas', [PembayaranController::class, 'showLunas'])->name('pembayaran.lunas');
    Route::get('/pembayaran/refund', [PembayaranController::class, 'showRefund'])->name('pembayaran.refund_list');

    // Proses Pembayaran Utama
    Route::get('/pembayaran/{pendaftar}/form', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{pendaftar}/proses', [PembayaranController::class, 'prosesPembayaran'])->name('pembayaran.proses');
    Route::post('/pembayaran/{pendaftar}/proses-refund', [PembayaranController::class, 'prosesRefund'])->name('pembayaran.refund');

    // GRUP CICILAN & KWITANSI
    Route::prefix('cicilan')->name('cicilan.')->group(function () {
        Route::get('/{pendaftar}/create', [CicilanController::class, 'create'])->name('create');
        Route::post('/{pendaftar}', [CicilanController::class, 'store'])->name('store');
        Route::get('/{pendaftar}/history', [CicilanController::class, 'history'])->name('history');
        
        // Rute Cetak PDF (Nama Route: bendahara.cicilan.cetak)
        Route::get('/{pendaftar}/cetak/{cicilan}', [CicilanController::class, 'cetakKwitansiCicilan'])->name('cetak');

        Route::post('/{pendaftar}/cicilan/{cicilan}/approve', [CicilanController::class, 'approveCicilan'])->name('approve');
        Route::post('/{pendaftar}/cicilan/{cicilan}/reject', [CicilanController::class, 'rejectCicilan'])->name('reject');
    });
});

// ==========================================
// Rute Ketua/Admin
// ==========================================
Route::middleware('auth')->prefix('ketua')->name('ketua.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan/pdf', [DashboardController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/backup', [DashboardController::class, 'backupData'])->name('backup');
});