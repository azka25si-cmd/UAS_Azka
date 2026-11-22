<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PembayaranController;

// Halaman utama
Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Logout
Route::post('/logout/admin', [AuthController::class, 'logoutAdmin'])->name('admin.logout');
Route::post('/logout/user', [AuthController::class, 'logoutUser'])->name('user.logout');

// === ADMIN ROUTES ===
Route::middleware('admin.guard:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // Kamar CRUD (admin)
    Route::get('/kamars', [KamarController::class, 'adminIndex'])->name('kamars.index');
    Route::get('/kamars/create', [KamarController::class, 'create'])->name('kamars.create');
    Route::post('/kamars', [KamarController::class, 'store'])->name('kamars.store');
    Route::get('/kamars/{kamar}/edit', [KamarController::class, 'edit'])->name('kamars.edit');
    Route::put('/kamars/{kamar}', [KamarController::class, 'update'])->name('kamars.update');
    Route::delete('/kamars/{kamar}', [KamarController::class, 'destroy'])->name('kamars.destroy');

    // Reservasi admin
    Route::get('/reservasis', [ReservasiController::class, 'adminIndex'])->name('reservasis.index');
    Route::put('/reservasis/{reservasi}', [ReservasiController::class, 'adminUpdate'])->name('reservasis.update');

    // Pembayaran admin
    Route::get('/pembayarans', [PembayaranController::class, 'adminIndex'])->name('pembayarans.index');
    Route::put('/pembayarans/{pembayaran}/verifikasi', [PembayaranController::class, 'verifikasi'])->name('pembayarans.verifikasi');
    Route::get('/reservasis/{reservasi}', [ReservasiController::class, 'adminShow'])->name('reservasis.show');    

    // Laporan
    //Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan');
});

// === PELANGGAN ROUTES ===
Route::middleware('web.guard:web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'user'])->name('user.dashboard');

    // Kamar (hanya lihat tersedia)
    Route::get('/kamars', [KamarController::class, 'index'])->name('kamars.index');
    Route::get('/kamars/{kamar}', [KamarController::class, 'show'])->name('kamars.show');

    // Reservasi
    Route::get('/reservasi/create/{kamar}', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/{reservasi}', [ReservasiController::class, 'show'])->name('reservasi.show');
    Route::get('/reservasi/{reservasi}/edit', [ReservasiController::class, 'edit'])->name('reservasi.edit');
    Route::put('/reservasi/{reservasi}', [ReservasiController::class, 'update'])->name('reservasi.update');
    Route::delete('/reservasi/{reservasi}', [ReservasiController::class, 'destroy'])->name('reservasi.destroy');

    // Pembayaran
    Route::get('/pembayaran/{reservasi}', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
});