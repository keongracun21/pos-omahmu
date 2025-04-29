<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    // Hanya bisa diakses jika user sudah login
    Route::get('/pengaturan', [ProfileController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan', [ProfileController::class, 'update'])->name('pengaturan.update');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
