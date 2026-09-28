# MASTER PLAN PENGEMBANGAN SISTEM INFORMASI PENGELOLAAN ARSIP DENGAN ALGORITMA KNUTH-MORRIS-PRATT (KMP)
**Lokasi Studi Kasus: SMKN 1 SUBANG**  
*Berdasarkan Dokumen Proposal Skripsi (Ridwan Kurniawan - D1A230009, Universitas Subang)*

---

## 📌 1. Dokumen Perancangan Arsitektur & Kebutuhan

Seluruh dokumen landasan teoritis, analisis SRS/NFR, perancangan database, pemodelan UML, dan algoritma KMP tersimpan pada folder ini:

| No | Dokumen Rencana | Deskripsi Utama |
|---|---|---|
| 00 | [00_OVERVIEW_DAN_ANALISIS_SKRIPSI.md](./00_OVERVIEW_DAN_ANALISIS_SKRIPSI.md) | Analisis menyeluruh proposal skripsi: latar belakang, masalah sistem berjalan, aktor, SRS fungsional (SRS-P, SRS-KS, SRS-L), dan NFR. |
| 01 | [01_TECH_STACK_DAN_ARSITEKTUR_SISTEM.md](./01_TECH_STACK_DAN_ARSITEKTUR_SISTEM.md) | Spesifikasi teknologi (Laravel, PHP, MySQL, Tailwind CSS, Node.js), arsitektur MVC + Service Layer, sistem autentikasi & RBAC multi-role. |
| 02 | [02_PERANCANGAN_DATABASE_DAN_ERD.md](./02_PERANCANGAN_DATABASE_DAN_ERD.md) | Perancangan skema database MySQL lengkap, kamus data, relasi antar tabel (users, surat masuk, surat keluar, persetujuan, legalisir, log). |
| 03 | [03_IMPLEMENTASI_ALGORITMA_KMP.md](./03_IMPLEMENTASI_ALGORITMA_KMP.md) | Teori dan formula Knuth-Morris-Pratt (KMP), pembentukan tabel LPS (Prefix Function), desain `KmpSearchService.php`, dan strategi pengujian performa pencarian. |
| 04 | [04_DESAIN_WORKFLOW_DAN_UML.md](./04_DESAIN_WORKFLOW_DAN_UML.md) | Pemodelan UML: Use Case Diagram & Skenario, Activity Diagram (Surat Masuk, Surat Keluar, Legalisir, Approval), alur status & perancangan UI/UX Tailwind. |
| 05 | [05_ROADMAP_DAN_FASE_IMPLEMENTASI_RUP.md](./05_ROADMAP_DAN_FASE_IMPLEMENTASI_RUP.md) | Panduan langkah teknis rinci 17 tahap implementasi sistem. |
| 06 | [06_ATURAN_DAN_SOP_DOKUMENTASI_IMPLEMENTASI.md](./06_ATURAN_DAN_SOP_DOKUMENTASI_IMPLEMENTASI.md) | Aturan operasional pembaruan README utama dan README per tahap pada setiap siklus implementasi. |

---

## 📊 2. Matriks Tracking Status Implementasi Per Tahap

> **Aturan Dokumentasi**: Setiap kali sebuah tahapan selesai diimplementasikan, file `README.md` pada tahapan tersebut diperbarui dengan bukti pengujian dan komit Git, serta status di bawah ini diubah menjadi `🟢 Selesai`.

| No | Tahapan Implementasi | Berkas Dokumentasi Tahapan | Status |
|:---:|---|---|:---:|
| **01** | Verifikasi & Penyiapan Lingkungan Pengembangan | [tahap-01-environment-setup/README.md](./tahapan/tahap-01-environment-setup/README.md) | 🟢 Selesai |
| **02** | Inisialisasi Proyek Laravel & Struktur Workspace | [tahap-02-inisialisasi-laravel/README.md](./tahapan/tahap-02-inisialisasi-laravel/README.md) | 🟢 Selesai |
| **03** | Instalasi Frontend Tech Stack (Tailwind CSS & Vite) | [tahap-03-frontend-tailwind/README.md](./tahapan/tahap-03-frontend-tailwind/README.md) | 🟢 Selesai |
| **04** | Konfigurasi Environment (.env) & Basis Data MySQL | [tahap-04-koneksi-database/README.md](./tahapan/tahap-04-koneksi-database/README.md) | 🟢 Selesai |
| **05** | Perancangan & Eksekusi Migrasi Basis Data | [tahap-05-migrasi-database/README.md](./tahapan/tahap-05-migrasi-database/README.md) | 🟢 Selesai |
| **06** | Pembuatan Model Eloquent & Relasi Data | [tahap-06-model-eloquent/README.md](./tahapan/tahap-06-model-eloquent/README.md) | 🟢 Selesai |
| **07** | Database Seeder Data Awal & Pengguna Default | [tahap-07-database-seeder/README.md](./tahapan/tahap-07-database-seeder/README.md) | 🟢 Selesai |
| **08** | Autentikasi Pengguna & Role-Based Access Control (RBAC) | [tahap-08-autentikasi-rbac/README.md](./tahapan/tahap-08-autentikasi-rbac/README.md) | 🟢 Selesai |
| **09** | Pembangunan Master Layout & UI Components (Tailwind CSS) | [tahap-09-master-layout-ui/README.md](./tahapan/tahap-09-master-layout-ui/README.md) | 🟢 Selesai |
| **10** | Pembangunan Core Engine Algoritma Knuth-Morris-Pratt (KMP) | [tahap-10-engine-algoritma-kmp/README.md](./tahapan/tahap-10-engine-algoritma-kmp/README.md) | 🟢 Selesai |
| **11** | Implementasi Modul Master Data Kategori & Pengguna | [tahap-11-master-data/README.md](./tahapan/tahap-11-master-data/README.md) | 🔴 Belum Dimulai |
| **12** | Implementasi Modul Surat Masuk (SRS-P02, SRS-P03, SRS-KS02) | [tahap-12-modul-surat-masuk/README.md](./tahapan/tahap-12-modul-surat-masuk/README.md) | 🔴 Belum Dimulai |
| **13** | Implementasi Modul Surat Keluar (SRS-P04, SRS-P05, SRS-KS03) | [tahap-13-modul-surat-keluar/README.md](./tahapan/tahap-13-modul-surat-keluar/README.md) | 🔴 Belum Dimulai |
| **14** | Implementasi Modul Persetujuan & Disposisi Kepala Sekolah | [tahap-14-persetujuan-disposisi-kepsek/README.md](./tahapan/tahap-14-persetujuan-disposisi-kepsek/README.md) | 🔴 Belum Dimulai |
| **15** | Implementasi Modul Layanan Legalisir Online (SRS-L01..05) | [tahap-15-layanan-legalisir-online/README.md](./tahapan/tahap-15-layanan-legalisir-online/README.md) | 🔴 Belum Dimulai |
| **16** | Integrasi Fitur Pencarian Cerdas Terpadu KMP | [tahap-16-pencarian-cerdas-kmp/README.md](./tahapan/tahap-16-pencarian-cerdas-kmp/README.md) | 🔴 Belum Dimulai |
| **17** | Modul Rekapitulasi Cetak Agenda, Pengujian Black Box, & Skripsi | [tahap-17-cetak-agenda-pengujian-skripsi/README.md](./tahapan/tahap-17-cetak-agenda-pengujian-skripsi/README.md) | 🔴 Belum Dimulai |
