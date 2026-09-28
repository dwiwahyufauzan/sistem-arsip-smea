# Tahap 06: Pembuatan Model Eloquent & Relasi Data
**Status:** 🟢 Selesai  
**Tanggal Penyelesaian:** 28 September 2026

---

## 🎯 1. Deskripsi Tahapan
Membangun 8 Model Eloquent yang memetakan tabel basis data, mendefinisikan relasi `hasMany` dan `belongsTo`, mengonfigurasi casting data, menambahkan helper pengecekan hak akses pengguna, serta menyediakan static helper pencatatan log aktivitas sistem.

---

## 📋 2. Target & Indikator Keberhasilan (Deliverables)
- [x] Model `User`: helper role (`isAdmin()`, `isKepalaSekolah()`, `isPemohon()`), relasi ke surat masuk, surat keluar, disposisi, legalisir, dan log aktivitas.
- [x] Model `KategoriSurat`: relasi ke surat masuk dan surat keluar.
- [x] Model `SuratMasuk`: relasi ke kategori, user penginput, disposisi, dan helper ukuran berkas.
- [x] Model `SuratKeluar`: relasi ke kategori, pembuat, dan Kepala Sekolah yang menyetujui.
- [x] Model `DisposisiSuratMasuk`: relasi ke surat masuk dan Kepala Sekolah pemberi instruksi.
- [x] Model `PengajuanLegalisir`: relasi ke pemohon, petugas verifikator, dan riwayat status legalisir.
- [x] Model `RiwayatLegalisir`: relasi audit trail perubahan status permohonan.
- [x] Model `LogAktivitas`: helper `LogAktivitas::catat(...)` untuk kemudahan pencatatan riwayat aksi.
- [x] Validasi instansiasi seluruh model melalui Tinker berhasil tanpa galat.

---

## 💻 3. Langkah Teknis & Perintah Eksekusi
1. Pembuatan / Pembaruan berkas model di `app/Models/`:
   - `User.php`
   - `KategoriSurat.php`
   - `SuratMasuk.php`
   - `SuratKeluar.php`
   - `DisposisiSuratMasuk.php`
   - `PengajuanLegalisir.php`
   - `RiwayatLegalisir.php`
   - `LogAktivitas.php`
2. Validasi via Laravel Tinker:
   ```bash
   php artisan tinker --execute="..."
   ```

---

## 🧪 4. Hasil Pengujian & Bukti Eksekusi
```text
User: App\Models\User
SuratMasuk: App\Models\SuratMasuk
SuratKeluar: App\Models\SuratKeluar
KategoriSurat: App\Models\KategoriSurat
PengajuanLegalisir: App\Models\PengajuanLegalisir
Disposisi: App\Models\DisposisiSuratMasuk
Riwayat: App\Models\RiwayatLegalisir
Log: App\Models\LogAktivitas
```

---

## 📝 5. Riwayat Komit Git
- **Commit Message:** `feat(tahap-06): pembuatan 8 model eloquent dan relasi data kearsipan selesai`
- **Branch:** `main`
