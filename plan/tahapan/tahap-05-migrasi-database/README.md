# Tahap 05: Perancangan & Eksekusi Migrasi Basis Data
**Status:** 🟢 Selesai  
**Tanggal Penyelesaian:** 28 September 2026

---

## 🎯 1. Deskripsi Tahapan
Merancang dan mengeksekusi 8 skema migrasi tabel basis data relasional di MySQL untuk mendukung modul Surat Masuk, Surat Keluar, Disposisi Pimpinan, Permohonan Legalisir Dokumen Online, Riwayat Status (*Audit Trail*), Klasifikasi Kategori Surat, serta Manajemen Akun Multi-Role.

---

## 📋 2. Target & Indikator Keberhasilan (Deliverables)
- [x] Pembaruan skema `users` dengan atribut multi-role (`admin`, `kepala_sekolah`, `pemohon`), NIP/NISN, nomor WhatsApp, dan avatar.
- [x] Skema `kategori_surat` (klasifikasi kode surat dinas sekolah).
- [x] Skema `surat_masuk` dengan metadata penomoran agenda, tanggal terima, pengirim, perihal, dan relasi file path.
- [x] Skema `surat_keluar` dengan status persetujuan Kepala Sekolah (`draft`, `menunggu_persetujuan`, `disetujui`, `ditolak`).
- [x] Skema `disposisi_surat_masuk` untuk lembar instruksi Kepala Sekolah kepada unit kerja.
- [x] Skema `pengajuan_legalisir` dengan nomor resi unik (`LEG-YYYYMM-XXXX`) dan tahapan proses legalisir.
- [x] Skema `riwayat_legalisir` untuk melacak jejak perubahan status (*timeline tracking*).
- [x] Skema `log_aktivitas` untuk audit keamanan data arsip.
- [x] Eksekusi migrasi sukses (`php artisan migrate:status` -> 10 tabel [1] Ran di MySQL).

---

## 💻 3. Langkah Teknis & Perintah Eksekusi
1. Pembuatan berkas migrasi:
   - `0001_01_01_000000_create_users_table.php` (Updated)
   - `2026_09_28_000001_create_kategori_surat_table.php`
   - `2026_09_28_000002_create_surat_masuk_table.php`
   - `2026_09_28_000003_create_surat_keluar_table.php`
   - `2026_09_28_000004_create_disposisi_surat_masuk_table.php`
   - `2026_09_28_000005_create_pengajuan_legalisir_table.php`
   - `2026_09_28_000006_create_riwayat_legalisir_table.php`
   - `2026_09_28_000007_create_log_aktivitas_table.php`
2. Eksekusi migrasi ke MySQL:
   ```bash
   php artisan migrate:fresh
   php artisan migrate:status
   ```

---

## 🧪 4. Hasil Pengujian & Bukti Eksekusi

```text
 Migration name ............................................................................ Batch / Status 
 0001_01_01_000000_create_users_table ............................................................. [1] Ran 
 0001_01_01_000001_create_cache_table ............................................................. [1] Ran 
 0001_01_01_000002_create_jobs_table .............................................................. [1] Ran 
 2026_09_28_000001_create_kategori_surat_table .................................................... [1] Ran 
 2026_09_28_000002_create_surat_masuk_table ....................................................... [1] Ran 
 2026_09_28_000003_create_surat_keluar_table ...................................................... [1] Ran 
 2026_09_28_000004_create_disposisi_surat_masuk_table ............................................. [1] Ran 
 2026_09_28_000005_create_pengajuan_legalisir_table ............................................... [1] Ran 
 2026_09_28_000006_create_riwayat_legalisir_table ................................................. [1] Ran 
 2026_09_28_000007_create_log_aktivitas_table ..................................................... [1] Ran 
```

---

## 📝 5. Riwayat Komit Git
- **Commit Message:** `feat(tahap-05): migrasi basis data mysql 8 tabel kearsipan smkn 1 subang selesai`
- **Branch:** `main`
