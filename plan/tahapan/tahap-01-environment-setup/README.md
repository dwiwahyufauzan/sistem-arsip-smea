# Tahap 01: Verifikasi & Penyiapan Lingkungan Pengembangan
**Status:** 🟢 Selesai  
**Tanggal Verifikasi:** 28 September 2026

---

## 🎯 1. Deskripsi Tahapan
Memastikan seluruh dependensi perangkat lunak inti, runtime, ekstensi PHP, package manager, dan server basis data MySQL telah terpasang dengan versi yang kompatibel dan siap digunakan untuk pengembangan sistem informasi kearsipan SMKN 1 Subang.

---

## 📋 2. Target & Indikator Keberhasilan (Deliverables)
- [x] PHP versi 8.2+ terpasang beserta ekstensi wajib (`pdo_mysql`, `mbstring`, `fileinfo`, `openssl`).
- [x] Composer versi 2.x terpasang dan dapat diakses dari terminal.
- [x] Node.js dan npm terpasang untuk build asset frontend.
- [x] Layanan MySQL aktif pada port 3306 dengan kredensial akses lokal (`root`).
- [x] Git terkonfigurasi dengan remote repository GitHub yang valid.

---

## 💻 3. Langkah Teknis & Perintah Eksekusi

### 3.1. Pemeriksaan Runtime & Tools
```bash
php -v
composer -v
node -v
npm -v
git --version
```

### 3.2. Pengujian Koneksi Database MySQL
Skrip pengujian koneksi PDO dijalankan pada port `3306`:
```php
<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
echo "MySQL Version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n";
```

---

## 🧪 4. Hasil Pengujian & Bukti Eksekusi

| Komponen | Target Spesifikasi | Hasil Verifikasi Aktual | Status |
|---|---|---|:---:|
| **PHP** | Minimal PHP 8.2 | **PHP 8.4.6** (cli, Visual C++ 2022 x64) | ✅ Lolos |
| **Composer** | Minimal 2.x | **Composer version 2.9.5** | ✅ Lolos |
| **Node.js** | Minimal v18+ | **Node.js v24.14.1** | ✅ Lolos |
| **npm** | Minimal 9+ | **npm 11.3.0** | ✅ Lolos |
| **Database Engine** | MySQL 8.x | **MySQL 8.4.3** (Laragon x64, Port 3306 aktif) | ✅ Lolos |
| **Git & Remote** | GitHub Connected | `origin -> https://github.com/dwiwahyufauzan/sistem-arsip-smea.git` | ✅ Lolos |

---

## 📝 5. Riwayat Komit Git
- **Commit Message:** `docs(tahap-01): verifikasi lingkungan pengembangan PHP 8.4, Composer 2.9, Node 24, MySQL 8.4 selesai`
- **Branch:** `main`
