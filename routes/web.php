<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\KategoriSuratController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LegalisirAdminController;
use App\Http\Controllers\LegalisirKepsekController;
use App\Http\Controllers\PencarianKmpController;
use App\Http\Controllers\PengajuanLegalisirController;
use App\Http\Controllers\PersetujuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifikasiDokumenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Publik, Legalisir Mandiri & Autentikasi
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Verifikasi Dokumen Kedinasan & Tanda Terima Legalisir via QR Code Publik
Route::get('/verifikasi/surat-keluar/{identifier}', [VerifikasiDokumenController::class, 'verifikasiSuratKeluar'])->name('verifikasi.surat-keluar');
Route::get('/verifikasi/legalisir/{nomor_pengajuan}', [VerifikasiDokumenController::class, 'verifikasiLegalisir'])->name('verifikasi.legalisir');

// Portal Publik Layanan Legalisir Online (SRS-L01..05)
Route::get('/legalisir/buat', [PengajuanLegalisirController::class, 'create'])->name('legalisir.create');
Route::post('/legalisir/kirim', [PengajuanLegalisirController::class, 'store'])->name('legalisir.store');
Route::get('/legalisir/sukses/{nomor_pengajuan}', [PengajuanLegalisirController::class, 'sukses'])->name('legalisir.sukses');
Route::get('/legalisir/tracking', [PengajuanLegalisirController::class, 'tracking'])->name('legalisir.tracking');
Route::get('/legalisir/tanda-terima/{nomor_pengajuan}', [PengajuanLegalisirController::class, 'cetakTandaTerima'])->name('legalisir.tanda-terima');
Route::get('/legalisir/{legalisir}/download', [PengajuanLegalisirController::class, 'downloadDokumen'])->name('legalisir.download');

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

    // Live Search API KMP
    Route::get('/api/pencarian-kmp/live', [PencarianKmpController::class, 'liveSearch'])->name('api.pencarian-kmp.live');
});

// 2. Rute Khusus Admin / Petugas TU
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // Modul Surat Masuk (SRS-P02, SRS-P03)
    Route::get('surat-masuk/{surat_masuk}/download', [SuratMasukController::class, 'download'])->name('surat-masuk.download');
    Route::get('surat-masuk/{surat_masuk}/cetak', [SuratMasukController::class, 'cetak'])->name('surat-masuk.cetak');
    Route::resource('surat-masuk', SuratMasukController::class);

    // Modul Surat Keluar (SRS-P04, SRS-P05)
    Route::post('surat-keluar/{surat_keluar}/ajukan', [SuratKeluarController::class, 'ajukanPersetujuan'])->name('surat-keluar.ajukan');
    Route::get('surat-keluar/{surat_keluar}/download', [SuratKeluarController::class, 'download'])->name('surat-keluar.download');
    Route::get('surat-keluar/{surat_keluar}/cetak', [SuratKeluarController::class, 'cetak'])->name('surat-keluar.cetak');
    Route::resource('surat-keluar', SuratKeluarController::class);

    // Monitoring & Tindak Lanjut Disposisi oleh Staf TU
    Route::get('disposisi', [DisposisiController::class, 'indexAdmin'])->name('disposisi.index');
    Route::get('disposisi/{disposisi}', [DisposisiController::class, 'showAdmin'])->name('disposisi.show');
    Route::patch('disposisi/{disposisi}/status', [DisposisiController::class, 'updateStatus'])->name('disposisi.status');
    Route::get('disposisi/{disposisi}/cetak', [DisposisiController::class, 'cetak'])->name('disposisi.cetak');

    // Modul Verifikasi & Pengelolaan Legalisir TU (SRS-P06, SRS-P07)
    Route::get('legalisir', [LegalisirAdminController::class, 'index'])->name('legalisir.index');
    Route::get('legalisir/{legalisir}', [LegalisirAdminController::class, 'show'])->name('legalisir.show');
    Route::patch('legalisir/{legalisir}/verifikasi', [LegalisirAdminController::class, 'verifikasi'])->name('legalisir.verifikasi');
    Route::patch('legalisir/{legalisir}/proses-cetak', [LegalisirAdminController::class, 'prosesCetak'])->name('legalisir.proses-cetak');
    Route::patch('legalisir/{legalisir}/siap-diambil', [LegalisirAdminController::class, 'siapDiambil'])->name('legalisir.siap-diambil');
    Route::patch('legalisir/{legalisir}/selesai', [LegalisirAdminController::class, 'selesai'])->name('legalisir.selesai');
    Route::patch('legalisir/{legalisir}/tolak', [LegalisirAdminController::class, 'tolak'])->name('legalisir.tolak');

    // Master Data Kategori Surat Klasifikasi Dinas
    Route::resource('kategori', KategoriSuratController::class)->except(['show']);

    // Manajemen Pengguna Sistem
    Route::resource('pengguna', UserController::class)->except(['show']);

    // Pencarian Cerdas Terpadu KMP (SRS-P08, SRS-P09, NFR-07)
    Route::get('/pencarian-kmp', [PencarianKmpController::class, 'indexAdmin'])->name('pencarian-kmp');

    // Rekapitulasi Laporan & Agenda Kearsipan (SRS-P10, SRS-P11)
    Route::get('/laporan', [LaporanController::class, 'indexAdmin'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetakAdmin'])->name('laporan.cetak');

    // Jejak Audit Aktivitas Kearsipan
    Route::get('/log-aktivitas', [LaporanController::class, 'logAktivitasAdmin'])->name('log-aktivitas.index');
});

// 3. Rute Khusus Kepala Sekolah (Pimpinan)
Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepala-sekolah')->name('kepsek.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'kepsek'])->name('dashboard');

    // Pencarian Cepat Terpadu KMP (SRS-KS08, NFR-07)
    Route::get('/pencarian-kmp', [PencarianKmpController::class, 'indexKepsek'])->name('pencarian-kmp');

    // Rekapitulasi Agenda Eksekutif Kepala Sekolah (SRS-KS09)
    Route::get('/laporan', [LaporanController::class, 'indexKepsek'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetakKepsek'])->name('laporan.cetak');

    // Jejak Audit Aktivitas Eksekutif
    Route::get('/log-aktivitas', [LaporanController::class, 'logAktivitasKepsek'])->name('log-aktivitas.index');

    // Pemantauan & Tinjauan Surat Masuk (SRS-KS02)
    Route::get('/surat-masuk', [SuratMasukController::class, 'indexKepsek'])->name('surat-masuk.index');
    Route::get('/surat-masuk/{surat_masuk}', [SuratMasukController::class, 'showKepsek'])->name('surat-masuk.show');
    Route::get('/surat-masuk/{surat_masuk}/download', [SuratMasukController::class, 'download'])->name('surat-masuk.download');
    Route::get('/surat-masuk/{surat_masuk}/cetak', [SuratMasukController::class, 'cetak'])->name('surat-masuk.cetak');

    // Pemantauan & Tinjauan Surat Keluar (SRS-KS03)
    Route::get('/surat-keluar', [SuratKeluarController::class, 'indexKepsek'])->name('surat-keluar.index');
    Route::get('/surat-keluar/{surat_keluar}', [SuratKeluarController::class, 'showKepsek'])->name('surat-keluar.show');
    Route::get('/surat-keluar/{surat_keluar}/download', [SuratKeluarController::class, 'download'])->name('surat-keluar.download');
    Route::get('/surat-keluar/{surat_keluar}/cetak', [SuratKeluarController::class, 'cetak'])->name('surat-keluar.cetak');

    // Modul Otorisasi Persetujuan Surat Keluar (SRS-KS05, SRS-KS07)
    Route::get('/persetujuan', [PersetujuanController::class, 'index'])->name('persetujuan.index');
    Route::get('/persetujuan/{surat_keluar}', [PersetujuanController::class, 'show'])->name('persetujuan.show');
    Route::post('/persetujuan/{surat_keluar}/approve', [PersetujuanController::class, 'approve'])->name('persetujuan.approve');
    Route::post('/persetujuan/{surat_keluar}/reject', [PersetujuanController::class, 'reject'])->name('persetujuan.reject');

    // Modul Disposisi Surat Masuk Pimpinan (SRS-KS06)
    Route::get('/disposisi', [DisposisiController::class, 'index'])->name('disposisi.index');
    Route::get('/disposisi/create', [DisposisiController::class, 'create'])->name('disposisi.create');
    Route::post('/disposisi', [DisposisiController::class, 'store'])->name('disposisi.store');
    Route::get('/disposisi/{disposisi}', [DisposisiController::class, 'show'])->name('disposisi.show');
    Route::get('/disposisi/{disposisi}/edit', [DisposisiController::class, 'edit'])->name('disposisi.edit');
    Route::put('/disposisi/{disposisi}', [DisposisiController::class, 'update'])->name('disposisi.update');
    Route::delete('/disposisi/{disposisi}', [DisposisiController::class, 'destroy'])->name('disposisi.destroy');
    Route::patch('/disposisi/{disposisi}/status', [DisposisiController::class, 'updateStatus'])->name('disposisi.status');
    Route::get('/disposisi/{disposisi}/cetak', [DisposisiController::class, 'cetak'])->name('disposisi.cetak');

    // Modul Pengesahan Legalisir Kepala Sekolah (SRS-KS04, SRS-KS06)
    Route::get('/legalisir', [LegalisirKepsekController::class, 'index'])->name('legalisir.index');
    Route::get('/legalisir/{legalisir}', [LegalisirKepsekController::class, 'show'])->name('legalisir.show');
    Route::post('/legalisir/{legalisir}/approve', [LegalisirKepsekController::class, 'approve'])->name('legalisir.approve');
    Route::post('/legalisir/{legalisir}/reject', [LegalisirKepsekController::class, 'reject'])->name('legalisir.reject');
});

// 4. Rute Khusus Pemohon Legalisir (Alumni / Siswa)
Route::middleware(['auth', 'role:pemohon'])->prefix('pemohon')->name('pemohon.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'pemohon'])->name('dashboard');
    Route::get('/permohonan-saya', [PengajuanLegalisirController::class, 'indexPemohon'])->name('legalisir.index');
    Route::get('/permohonan-saya/{legalisir}', [PengajuanLegalisirController::class, 'showPemohon'])->name('legalisir.show');
    Route::get('/legalisir', [PengajuanLegalisirController::class, 'indexPemohon']);
    Route::get('/legalisir/create', [DashboardController::class, 'redirectCreate']);
});
