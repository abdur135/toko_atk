<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Autentikasi (Bisa diakses publik)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Rute Terlindungi (Hanya untuk pengguna yang login / Auth Middleware)
Route::middleware('auth')->group(function () {
    
    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Utama
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']); // Alias

    // Master Data Terpusat
    Route::get('/master', [MasterController::class, 'index'])->name('master.index');
    Route::post('/master/batch-delete', [MasterController::class, 'batchDelete'])->name('master.batch-delete');

    // Master Data: Kategori (CRUD Lengkap)
    Route::resource('categories', CategoryController::class);

    // Master Data: Barang (CRUD Lengkap)
    Route::resource('products', ProductController::class);

    // Master Data: Manajemen Pengguna (CRUD Lengkap)
    // Note: Pengecekan role admin dilakukan langsung di Controller atau view
    Route::resource('users', UserController::class);

    // Persediaan Barang (Manajemen Stok)
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::get('/stocks/create', [StockController::class, 'create'])->name('stocks.create');
    Route::post('/stocks', [StockController::class, 'store'])->name('stocks.store');

    // Laporan Mutasi Barang
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
