<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    AuthController,
    ProfileController,
    DashboardController,
    UserController,
    StokMenuController
};

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.submit');
    Route::post('/logout', 'logout')->name('logout');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // StokMenu Routes (menggunakan resource untuk route CRUD otomatis)
    Route::resource('stok_menu', StokMenuController::class)->except(['create', 'edit']); // Menyembunyikan create/edit jika menggunakan modal

    // Profile Settings
    Route::prefix('pengaturan')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'index')->name('pengaturan');
        Route::put('/update', 'update')->name('pengaturan.update');
    });

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/create', [UserController::class, 'create'])->name('create'); // Jika ingin form terpisah
    });

    // Tambahkan route authenticated lainnya di sini
});
