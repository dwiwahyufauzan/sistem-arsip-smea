# Tahap 04: Konfigurasi Environment (.env) & Basis Data MySQL
**Status:** 🟢 Selesai  
**Tanggal Penyelesaian:** 28 September 2026

---

## 🎯 1. Deskripsi Tahapan
Mengonfigurasi parameter koneksi basis data pada berkas `.env`, membuat basis data MySQL `sistem_arsip_smea` dengan *charset* `utf8mb4`, dan memvalidasi konektivitas driver PDO Laravel.

---

## 📋 2. Target & Indikator Keberhasilan (Deliverables)
- [x] Basis data `sistem_arsip_smea` berhasil dibuat di MySQL lokal.
- [x] Konfigurasi `.env` terarah ke driver `mysql`, host `127.0.0.1:3306`, dan database `sistem_arsip_smea`.
- [x] Konfigurasi identitas aplikasi (`APP_NAME`, `APP_LOCALE=id`) disesuaikan untuk SMKN 1 Subang.
- [x] Perintah `php artisan db:show` merespons sukses dan menunjukkan status koneksi aktif.

---

## 💻 3. Langkah Teknis & Perintah Eksekusi
1. Pembuatan basis data:
   ```sql
   CREATE DATABASE IF NOT EXISTS `sistem_arsip_smea` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Konfigurasi `.env`:
   ```ini
   APP_NAME="Sistem Informasi Arsip SMKN 1 Subang"
   APP_LOCALE=id

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sistem_arsip_smea
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Pengujian koneksi:
   ```bash
   php artisan db:show
   ```

---

## 🧪 4. Hasil Pengujian & Bukti Eksekusi
- **Status Koneksi:** Berhasil terhubung ke server database.
- **Rincian `php artisan db:show`:**
  - Engine: MySQL 8.4.3
  - Connection: `mysql`
  - Host / Port: `127.0.0.1:3306`
  - Database: `sistem_arsip_smea`
  - Username: `root`
  - Open Connections: 1

---

## 📝 5. Riwayat Komit Git
- **Commit Message:** `feat(tahap-04): konfigurasi env dan pembuatan database mysql sistem_arsip_smea selesai`
- **Branch:** `main`
