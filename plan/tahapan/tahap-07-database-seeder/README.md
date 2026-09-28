# Tahap 07: Database Seeder Data Awal & Pengguna Default
**Status:** 🟢 Selesai  
**Tanggal Penyelesaian:** 28 September 2026

---

## 🎯 1. Deskripsi Tahapan
Menyemai (*seeding*) data awal ke basis data MySQL `sistem_arsip_smea`, mencakup 3 akun pengguna default untuk masing-masing hak akses (`admin`, `kepala_sekolah`, `pemohon`), 6 kode klasifikasi kategori surat dinas resmi SMKN 1 Subang, serta sampel arsip realistis (Surat Masuk, Surat Keluar, Disposisi, dan Permohonan Legalisir Online).

---

## 📋 2. Target & Indikator Keberhasilan (Deliverables)
- [x] Akun Petugas TU: `petugas@smkn1subang.sch.id` | Password: `password` | Role: `admin`.
- [x] Akun Kepala Sekolah: `kepsek@smkn1subang.sch.id` | Password: `password` | Role: `kepala_sekolah`.
- [x] Akun Pemohon Sampel: `alumni@smkn1subang.sch.id` | Password: `password` | Role: `pemohon`.
- [x] 6 Kategori Surat Dinas SMKN 1 Subang:
  - `421.5/KUR` (Kurikulum & Pembelajaran)
  - `421.5/KSW` (Kesiswaan & Ekstrakurikuler)
  - `421.5/HUMAS` (Hubungan Industri & Kerja Sama DUDI / Prakerin)
  - `421.5/SARPRAS` (Sarana & Prasarana)
  - `421.5/TU` (Tata Usaha & Kepegawaian)
  - `421.5/DISDIK` (Dinas Pendidikan Provinsi Jawa Barat)
- [x] 3 Sampel Surat Masuk realistis beserta riwayat disposisi tindak lanjut.
- [x] 2 Sampel Surat Keluar (status disetujui & menunggu persetujuan).
- [x] 2 Sampel Pengajuan Legalisir Online (status proses & verifikasi) beserta timeline riwayat audit.
- [x] Berkas fisik sampel PDF resmi (7 dokumen) di-generate dan tersimpan di `storage/app/public/` (`dokumen-surat-masuk/`, `dokumen-surat-keluar/`, `dokumen-legalisir/`) sehingga link pratinjau dan unduh tidak menghasilkan error 404.
- [x] Eksekusi `php artisan db:seed` berhasil tanpa error.

---

## 💻 3. Langkah Teknis & Perintah Eksekusi
1. Implementasi `database/seeders/DatabaseSeeder.php`
2. Eksekusi perintah seeder:
   ```bash
   php artisan db:seed
   ```
3. Verifikasi jumlah data terisi:
   ```bash
   php artisan tinker --execute="echo 'Users: ' . App\Models\User::count();"
   ```

---

## 🧪 4. Hasil Pengujian & Bukti Eksekusi
- **Hasil Verifikasi Database:**
  - `Users:` 3 akun
  - `Kategori Surat:` 6 kategori
  - `Surat Masuk:` 3 data
  - `Surat Keluar:` 2 data
  - `Disposisi:` 1 data
  - `Legalisir:` 2 data
  - `Riwayat Legalisir:` 3 log audit
  - `Log Aktivitas:` 1 rekaman inisialisasi

---

## 📝 5. Riwayat Komit Git
- **Commit Message:** `feat(tahap-07): penyemaian data awal database pengguna multi-role dan kategori resmi smkn 1 subang selesai`
- **Branch:** `main`
