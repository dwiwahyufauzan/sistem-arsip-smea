# MASTER PLAN PENGEMBANGAN SISTEM INFORMASI PENGELOLAAN ARSIP DENGAN ALGORITMA KNUTH-MORRIS-PRATT (KMP)
**Lokasi Studi Kasus: SMKN 1 SUBANG**  
*Berdasarkan Dokumen Proposal Skripsi (Ridwan Kurniawan - D1A230009, Universitas Subang)*

---

## 📌 Daftar Dokumen Rencana (Implementation Plans)

Dokumentasi rencana ini disusun secara mendalam dan terstruktur berdasarkan metodologi **Rational Unified Process (RUP)** untuk memandu seluruh alur pembangunan sistem dari awal hingga tahap deployment dan pengujian:

| No | Dokumen Rencana | Deskripsi Utama |
|---|---|---|
| 00 | [00_OVERVIEW_DAN_ANALISIS_SKRIPSI.md](./00_OVERVIEW_DAN_ANALISIS_SKRIPSI.md) | Analisis menyeluruh proposal skripsi: latar belakang, masalah sistem berjalan, aktor, SRS fungsional (SRS-P, SRS-KS, SRS-L), dan NFR. |
| 01 | [01_TECH_STACK_DAN_ARSITEKTUR_SISTEM.md](./01_TECH_STACK_DAN_ARSITEKTUR_SISTEM.md) | Spesifikasi teknologi (Laravel, PHP, MySQL, Tailwind CSS, Node.js), arsitektur MVC + Service Layer, sistem autentikasi & RBAC multi-role. |
| 02 | [02_PERANCANGAN_DATABASE_DAN_ERD.md](./02_PERANCANGAN_DATABASE_DAN_ERD.md) | Perancangan skema database MySQL lengkap, kamus data, relasi antar tabel (users, surat masuk, surat keluar, persetujuan, legalisir, log). |
| 03 | [03_IMPLEMENTASI_ALGORITMA_KMP.md](./03_IMPLEMENTASI_ALGORITMA_KMP.md) | Teori dan formula Knuth-Morris-Pratt (KMP), pembentukan tabel LPS (Prefix Function), desain `KmpSearchService.php`, dan strategi pengujian performa pencarian. |
| 04 | [04_DESAIN_WORKFLOW_DAN_UML.md](./04_DESAIN_WORKFLOW_DAN_UML.md) | Pemodelan UML: Use Case Diagram & Skenario, Activity Diagram (Surat Masuk, Surat Keluar, Legalisir, Approval), alur status & perancangan UI/UX Tailwind. |
| 05 | [05_ROADMAP_DAN_FASE_IMPLEMENTASI_RUP.md](./05_ROADMAP_DAN_FASE_IMPLEMENTASI_RUP.md) | **URUTAN LENGKAP 17 TAHAP IMPLEMENTASI**: Mulai dari setup tech stack, autentikasi multi-role, CRUD surat masuk/keluar, approval kepsek, portal legalisir, engine KMP, hingga pengujian Black Box. |

---

## 🚀 17 Langkah Eksekusi Berurutan

1. **Tahap 1**: Verifikasi & Penyiapan Lingkungan Pengembangan (PHP 8.4, Composer 2.9, Node.js 24, Laragon/MySQL).
2. **Tahap 2**: Inisialisasi Proyek Laravel & Integrasi Workspace (Preservasi berkas skripsi & setup direktori).
3. **Tahap 3**: Instalasi & Konfigurasi Frontend Tech Stack (Tailwind CSS, PostCSS, Autoprefixer, Vite).
4. **Tahap 4**: Konfigurasi Environment (`.env`) & Koneksi Database MySQL (`sistem_arsip_smea`).
5. **Tahap 5**: Perancangan & Eksekusi Migrasi Basis Data (8 Tabel Utama & Foreign Keys).
6. **Tahap 6**: Pembuatan Model Eloquent & Relasi Data (User, Surat, Legalisir, Disposisi, Riwayat, Log).
7. **Tahap 7**: Pembuatan Database Seeder (Akun Default 3 Role, Kategori Surat Resmi SMKN 1 Subang, Sampel Data).
8. **Tahap 8**: Implementasi Autentikasi Pengguna & Role-Based Access Control / RBAC (`admin`, `kepala_sekolah`, `pemohon`).
9. **Tahap 9**: Pembangunan Master Layout & UI Components (Admin, Kepsek, Pemohon - Tailwind CSS).
10. **Tahap 10**: Pembangunan Core Engine Algoritma Knuth-Morris-Pratt (KMP) Service & Unit Testing.
11. **Tahap 11**: Implementasi Modul Master Data (Kategori Surat & Profil Pengguna).
12. **Tahap 12**: Implementasi Modul Surat Masuk (CRUD, Upload Scan PDF, Previewer Modal, Disposisi).
13. **Tahap 13**: Implementasi Modul Surat Keluar (CRUD, Draf, Upload Berkas, Pengajuan Persetujuan).
14. **Tahap 14**: Implementasi Modul Persetujuan & Disposisi Kepala Sekolah (Approval Workflow).
15. **Tahap 15**: Implementasi Modul Layanan Legalisir Online (Portal Publik, Live Tracking Resi, Verifikasi TU, Pengesahan Kepsek).
16. **Tahap 16**: Integrasi Fitur Pencarian Cerdas Terpadu KMP (Multi-Tabel Matching, Highlighting, & Komparasi Brute Force).
17. **Tahap 17**: Modul Rekapitulasi Cetak Agenda, Pengujian Black Box Testing, & Dokumentasi Skripsi.

---

## 👥 Pengguna Sistem (Hak Akses)
- **Admin / Petugas Arsip TU**: Akses operasional penuh pencatatan, upload dokumen scan, verifikasi berkas legalisir, pembaruan status pengerjaan, pencarian KMP, dan cetak agenda.
- **Kepala Sekolah**: Akses pemantauan eksekutif, tinjauan berkas surat masuk, otorisasi persetujuan/penolakan surat keluar, otorisasi pengesahan legalisir, dan lembar disposisi.
- **Pemohon (Alumni/Siswa)**: Akses publik mandiri permohonan legalisir, upload scan berkas ijazah asli, dan pemantauan status proses (*live tracking*) dengan nomor resi tanpa kendala.

---
*Dokumen ini merupakan acuan resmi pengembangan aplikasi sistem arsip SMKN 1 Subang.*
