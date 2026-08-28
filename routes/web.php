<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\PenjualanHistoryController;
use App\Http\Controllers\JenisController;

// ROUTE BAGI YANG BELUM LOGIN
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});

// ROUTE BAGI YANG SUDAH LOGIN
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('produk', ProdukController::class);

    // ROUTE KHUSUS ADMIN
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Manajemen User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Manajemen Jenis Produk
        Route::resource('jenis', JenisController::class);

        // Fitur History Penjualan
        Route::get('/history', [PenjualanHistoryController::class, 'index'])->name('history.index');
        Route::get('/history/week', [PenjualanHistoryController::class, 'showWeek'])->name('history.week');
        Route::get('/history/date/{tanggal}', [PenjualanHistoryController::class, 'showDateDetail'])->name('history.date');
        Route::get('/history/{tahun}/{bulan}', [PenjualanHistoryController::class, 'showMonth'])->name('history.month');
    });
});

// ROUTE BAGI ADMIN & KASIR
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::resource('penjualan', PenjualanController::class);

    // Item Penjualan / Detail Penjualan Route
    Route::post('/detail-penjualan', [ItemPenjualanController::class, 'store'])->name('detail-penjualan.store');
    Route::put('/detail-penjualan/{id}', [ItemPenjualanController::class, 'update'])->name('detail-penjualan.update');
    Route::delete('/detail-penjualan/{id}', [ItemPenjualanController::class, 'destroy'])->name('detail-penjualan.destroy');

    Route::get('/about', function () {
        return view('about');
    })->name('about');
});