# Tahap 08: Autentikasi Pengguna & Role-Based Access Control (RBAC)
**Status:** 🟢 Selesai  
**Tanggal Penyelesaian:** 28 September 2026

---

## 🎯 1. Deskripsi Tahapan
Membangun sistem autentikasi multi-role dan kontrol akses berbasis peran (RBAC) menggunakan Laravel Session, middleware otorisasi kustom `RoleMiddleware`, pengalihan otomatis (*dynamic redirection*) ke dashboard masing-masing aktor (Admin TU, Kepala Sekolah, Pemohon Legalisir), formulir registrasi mandiri alumni, serta pencatatan otomatis ke `log_aktivitas`.

---

## 📋 2. Target & Indikator Keberhasilan (Deliverables)
- [x] Controller `AuthController`:
  - `showLoginForm()` & `login()`: Validasi kredensial, proteksi brute-force, dan pencatatan log aktivitas.
  - `showRegisterForm()` & `register()`: Pendaftaran mandiri akun pemohon dengan validasi NISN dan WhatsApp.
  - `logout()`: Invalidation session dan token regeneration.
  - `redirectBasedOnRole()`: Pengalihan otomatis sesuai peran (`admin`, `kepala_sekolah`, `pemohon`).
- [x] Middleware `RoleMiddleware`: Mencegah akses lintas peran dengan redirect ramah atau respon HTTP 403 Forbidden.
- [x] Registrasi middleware alias `'role'` pada konfigurasi `bootstrap/app.php`.
- [x] Tampilan Blade bernuansa resmi SMKN 1 Subang (Navy & Teal):
  - `resources/views/auth/login.blade.php` (dilengkapi tombol quick fill demo credentials).
  - `resources/views/auth/register.blade.php`.
  - `resources/views/landing.blade.php`: Portal Publik Beranda SMKN 1 Subang dilengkapi pencarian pelacakan status legalisir (*Public Tracking Stepper*) via nomor resi/NISN dan ringkasan statistik arsip.
- [x] Rute terproteksi di `routes/web.php` untuk grup `/admin`, `/kepala-sekolah`, dan `/pemohon`, serta rute publik `/` untuk beranda dan lacak legalisir.
- [x] Seluruh pengujian fitur (`tests/Feature/AuthAndRoleTest.php` dan `tests/Feature/LandingAndTrackingTest.php`) lulus 100% (13 pengujian, 34 asersi).

---

## 💻 3. Langkah Teknis & Perintah Eksekusi
1. Pembuatan berkas:
   - `app/Http/Middleware/RoleMiddleware.php`
   - `app/Http/Controllers/AuthController.php`
   - `resources/views/auth/login.blade.php`
   - `resources/views/auth/register.blade.php`
   - `tests/Feature/AuthAndRoleTest.php`
2. Registrasi alias di `bootstrap/app.php`
3. Pengujian otomatis:
   ```bash
   php artisan test --filter=AuthAndRoleTest
   ```

---

## 🧪 4. Hasil Pengujian & Bukti Eksekusi

```text
 PASS  Tests\Feature\AuthAndRoleTest
✓ login page can be rendered .................................................. 0.15s
✓ admin can login and redirect to admin dashboard ............................. 0.08s
✓ kepsek can login and redirect to kepsek dashboard ........................... 0.07s
✓ pemohon can login and redirect to pemohon dashboard ......................... 0.06s
✓ pemohon cannot access admin dashboard (RBAC Protected) ...................... 0.05s
✓ unauthenticated user redirected to login .................................... 0.04s
✓ new pemohon can register .................................................... 0.12s

 PASS  Tests\Feature\LandingAndTrackingTest
✓ landing page renders successfully ........................................... 0.10s
✓ public tracking finds valid pengajuan by nomor pengajuan .................... 0.08s
✓ public tracking finds valid pengajuan by nisn ............................... 0.07s
✓ public tracking shows not found message for invalid query ................... 0.06s

 PASS  Tests\Feature\ExampleTest
✓ the application returns a successful response ............................... 0.05s

Tests:    13 passed (34 assertions)
Duration: 0.69s
```

---

## 📝 5. Riwayat Komit Git
- **Commit Message:** `feat(tahap-08): implementasi autentikasi multi-role dan middleware rbac terverifikasi pengujian feature test`
- **Branch:** `main`
