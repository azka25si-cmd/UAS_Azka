<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Halaman utama
Route::get('/', function () {
    return redirect()->route('login');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Dashboard admin
Route::middleware('guard:admin')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard');

    Route::post('/admin/logout', [AuthController::class, 'logoutAdmin'])
        ->name('admin.logout');
});

// Dashboard pelanggan
Route::middleware('guard:web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'user'])
        ->name('user.dashboard');

    Route::post('/logout', [AuthController::class, 'logoutUser'])
        ->name('user.logout');
});
