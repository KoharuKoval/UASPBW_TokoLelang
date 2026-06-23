<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LelangController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama / Landing Page (Mengarahkan langsung ke Login)
Route::get('/', function () {
    return redirect()->route('login');
});

// --- RUTE OTENTIKASI (GUEST / BELUM LOGIN) ---
Route::middleware('guest')->group(function () {
    // Register
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// --- RUTE APLIKASI (WAJIB LOGIN) ---
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Dashboard Utama (Menampilkan Katalog Lelang)
    Route::get('/dashboard', [BarangController::class, 'index'])->name('dashboard');

    // Manajamen CRUD Barang (Create, Read, Update, Delete)
    Route::resource('barang', BarangController::class);

    // Proses Pengajuan Penawaran (Bid) Lelang
    Route::post('/barang/{barang}/tawar', [LelangController::class, 'store'])->name('lelang.store');

    // Rute Bawaan Profile (Opsional, jika ingin digunakan nanti)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});