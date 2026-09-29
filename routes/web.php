<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
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

    // Modul Surat Masuk (SRS-P02, SRS-P03)
    Route::get('surat-masuk/{surat_masuk}/download', [SuratMasukController::class, 'download'])->name('surat-masuk.download');
    Route::resource('surat-masuk', SuratMasukController::class);

    // Modul Surat Keluar (SRS-P04, SRS-P05)
    Route::post('surat-keluar/{surat_keluar}/ajukan', [SuratKeluarController::class, 'ajukanPersetujuan'])->name('surat-keluar.ajukan');
    Route::get('surat-keluar/{surat_keluar}/download', [SuratKeluarController::class, 'download'])->name('surat-keluar.download');
    Route::resource('surat-keluar', SuratKeluarController::class);

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

    // Pemantauan & Tinjauan Surat Masuk (SRS-KS02)
    Route::get('/surat-masuk', [SuratMasukController::class, 'indexKepsek'])->name('surat-masuk.index');
    Route::get('/surat-masuk/{surat_masuk}', [SuratMasukController::class, 'showKepsek'])->name('surat-masuk.show');
    Route::get('/surat-masuk/{surat_masuk}/download', [SuratMasukController::class, 'download'])->name('surat-masuk.download');

    // Pemantauan & Tinjauan Surat Keluar (SRS-KS03)
    Route::get('/surat-keluar', [SuratKeluarController::class, 'indexKepsek'])->name('surat-keluar.index');
    Route::get('/surat-keluar/{surat_keluar}', [SuratKeluarController::class, 'showKepsek'])->name('surat-keluar.show');
    Route::get('/surat-keluar/{surat_keluar}/download', [SuratKeluarController::class, 'download'])->name('surat-keluar.download');
});

// 4. Rute Khusus Pemohon Legalisir (Alumni / Siswa)
Route::middleware(['auth', 'role:pemohon'])->prefix('pemohon')->name('pemohon.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pemohon.dashboard');
    })->name('dashboard');
});
