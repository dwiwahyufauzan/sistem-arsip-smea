<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Publik & Autentikasi
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Pengaturan Profil & Kata Sandi Mandiri (Semua Role)
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// 2. Rute Khusus Admin / Petugas TU
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Master Data Kategori Surat Klasifikasi Dinas
    Route::resource('kategori', KategoriSuratController::class)->except(['show']);

    // Manajemen Pengguna Sistem
    Route::resource('pengguna', UserController::class)->except(['show']);
});

// 3. Rute Khusus Kepala Sekolah (Pimpinan)
Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepala-sekolah')->name('kepsek.')->group(function () {
    Route::get('/dashboard', function () {
        return view('kepsek.dashboard');
    })->name('dashboard');
});

// 4. Rute Khusus Pemohon Legalisir (Alumni / Siswa)
Route::middleware(['auth', 'role:pemohon'])->prefix('pemohon')->name('pemohon.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pemohon.dashboard');
    })->name('dashboard');
});
