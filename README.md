# Sistem Informasi Pengelolaan Arsip SMKN 1 Subang
### Penerapan Algoritma Knuth-Morris-Pratt (KMP) & Metode Rational Unified Process (RUP)

Repository ini berisi kode sumber dan dokumentasi rancang bangun **Sistem Informasi Pengelolaan Arsip berbasis Web** pada **SMK Negeri 1 Subang**. Sistem ini dikembangkan untuk mengoptimalkan pengelolaan dokumen arsip sekolah, meliputi pengelolaan **Surat Masuk**, **Surat Keluar**, dan **Layanan Legalisir Dokumen Online** dengan memanfaatkan algoritma pencarian string matching **Knuth-Morris-Pratt (KMP)**.

---

## 📌 Ringkasan Fitur Utama

1. **Pengelolaan Surat Masuk**
   - Pencatatan metadata, pengunggahan scan dokumen fisik (PDF/JPG), lembar disposisi Kepala Sekolah, dan pratinjau dokumen langsung di peramban.
2. **Pengelolaan Surat Keluar**
   - Pembuatan konsep/draf surat keluar, pengunggahan dokumen, alur verifikasi & otorisasi (*approval*) pimpinan (Kepala Sekolah), dan penerbitan nomor agenda resmi.
3. **Layanan Legalisir Dokumen Online**
   - Formulir permohonan legalisir mandiri bagi alumni/siswa, unggah scan ijazah asli, verifikasi data oleh petugas TU, pengesahan Kepala Sekolah, serta fitur *Live Tracking* status permohonan menggunakan nomor resi.
4. **Pencarian Cerdas Algoritma Knuth-Morris-Pratt (KMP)**
   - Engine pencarian teks berkecepatan tinggi ($\mathcal{O}(n+m)$) memanfaatkan tabel prefix-suffix (LPS array) pada seluruh data arsip dengan penanda warna (*highlighting*) kata kunci serta modul komparasi kinerja terhadap algoritma *Brute Force*.

---

## 🛠️ Tech Stack

- **Backend:** Laravel Framework (PHP 8.4) - Arsitektur MVC + Service Layer
- **Basis Data:** MySQL 8.x
- **Frontend:** Tailwind CSS, Blade Templates, JavaScript / Alpine.js, Vite
- **Algoritma:** Knuth-Morris-Pratt (KMP) String Matching
- **Metodologi:** Rational Unified Process (RUP)

---

## 📊 Matriks Status Implementasi Sistem (Live Progress)

> *Tabel ini diperbarui secara berkala pada setiap penyelesaian tahapan implementasi.*

| No | Tahapan Implementasi | Dokumentasi Rinci Tahapan | Status |
|:---:|---|---|:---:|
| **01** | Verifikasi & Penyiapan Lingkungan Pengembangan | [Tahap 01](./plan/tahapan/tahap-01-environment-setup/README.md) | 🟢 Selesai |
| **02** | Inisialisasi Proyek Laravel & Struktur Workspace | [Tahap 02](./plan/tahapan/tahap-02-inisialisasi-laravel/README.md) | 🟢 Selesai |
| **03** | Instalasi Frontend Tech Stack (Tailwind CSS & Vite) | [Tahap 03](./plan/tahapan/tahap-03-frontend-tailwind/README.md) | 🟢 Selesai |
| **04** | Konfigurasi Environment (.env) & Basis Data MySQL | [Tahap 04](./plan/tahapan/tahap-04-koneksi-database/README.md) | 🟢 Selesai |
| **05** | Perancangan & Eksekusi Migrasi Basis Data | [Tahap 05](./plan/tahapan/tahap-05-migrasi-database/README.md) | 🟢 Selesai |
| **06** | Pembuatan Model Eloquent & Relasi Data | [Tahap 06](./plan/tahapan/tahap-06-model-eloquent/README.md) | 🔴 Belum Dimulai |
| **07** | Database Seeder Data Awal & Pengguna Default | [Tahap 07](./plan/tahapan/tahap-07-database-seeder/README.md) | 🔴 Belum Dimulai |
| **08** | Autentikasi Pengguna & Role-Based Access Control (RBAC) | [Tahap 08](./plan/tahapan/tahap-08-autentikasi-rbac/README.md) | 🔴 Belum Dimulai |
| **09** | Pembangunan Master Layout & UI Components (Tailwind CSS) | [Tahap 09](./plan/tahapan/tahap-09-master-layout-ui/README.md) | 🔴 Belum Dimulai |
| **10** | Pembangunan Core Engine Algoritma Knuth-Morris-Pratt (KMP) | [Tahap 10](./plan/tahapan/tahap-10-engine-algoritma-kmp/README.md) | 🔴 Belum Dimulai |
| **11** | Implementasi Modul Master Data Kategori & Pengguna | [Tahap 11](./plan/tahapan/tahap-11-master-data/README.md) | 🔴 Belum Dimulai |
| **12** | Implementasi Modul Surat Masuk (SRS-P02, SRS-P03, SRS-KS02) | [Tahap 12](./plan/tahapan/tahap-12-modul-surat-masuk/README.md) | 🔴 Belum Dimulai |
| **13** | Implementasi Modul Surat Keluar (SRS-P04, SRS-P05, SRS-KS03) | [Tahap 13](./plan/tahapan/tahap-13-modul-surat-keluar/README.md) | 🔴 Belum Dimulai |
| **14** | Implementasi Modul Persetujuan & Disposisi Kepala Sekolah | [Tahap 14](./plan/tahapan/tahap-14-persetujuan-disposisi-kepsek/README.md) | 🔴 Belum Dimulai |
| **15** | Implementasi Modul Layanan Legalisir Online (SRS-L01..05) | [Tahap 15](./plan/tahapan/tahap-15-layanan-legalisir-online/README.md) | 🔴 Belum Dimulai |
| **16** | Integrasi Fitur Pencarian Cerdas Terpadu KMP | [Tahap 16](./plan/tahapan/tahap-16-pencarian-cerdas-kmp/README.md) | 🔴 Belum Dimulai |
| **17** | Modul Rekapitulasi Cetak Agenda, Pengujian Black Box, & Skripsi | [Tahap 17](./plan/tahapan/tahap-17-cetak-agenda-pengujian-skripsi/README.md) | 🔴 Belum Dimulai |

---

## 📂 Master Plan & Dokumen Perancangan

Perencanaan sistem yang komprehensif dapat dipelajari pada folder [`plan/`](./plan):
- [`plan/README.md`](./plan/README.md) - Daftar isi dan ringkasan eksekutif master plan
- [`plan/00_OVERVIEW_DAN_ANALISIS_SKRIPSI.md`](./plan/00_OVERVIEW_DAN_ANALISIS_SKRIPSI.md) - Analisis kebutuhan (SRS & NFR)
- [`plan/01_TECH_STACK_DAN_ARSITEKTUR_SISTEM.md`](./plan/01_TECH_STACK_DAN_ARSITEKTUR_SISTEM.md) - Arsitektur sistem & RBAC
- [`plan/02_PERANCANGAN_DATABASE_DAN_ERD.md`](./plan/02_PERANCANGAN_DATABASE_DAN_ERD.md) - Skema basis data & ERD
- [`plan/03_IMPLEMENTASI_ALGORITMA_KMP.md`](./plan/03_IMPLEMENTASI_ALGORITMA_KMP.md) - Logika matematis & Service KMP
- [`plan/04_DESAIN_WORKFLOW_DAN_UML.md`](./plan/04_DESAIN_WORKFLOW_DAN_UML.md) - Pemodelan UML & Wireframe UI
- [`plan/05_ROADMAP_DAN_FASE_IMPLEMENTASI_RUP.md`](./plan/05_ROADMAP_DAN_FASE_IMPLEMENTASI_RUP.md) - 17 Tahap urutan implementasi teknis
- [`plan/06_ATURAN_DAN_SOP_DOKUMENTASI_IMPLEMENTASI.md`](./plan/06_ATURAN_DAN_SOP_DOKUMENTASI_IMPLEMENTASI.md) - Standar SOP dokumentasi berkelanjutan per tahap

---

## 👥 Pengembang & Peneliti
- **Penyusun Skripsi:** Ridwan Kurniawan (NPM: D1A230009)
- **Program Studi:** Sistem Informasi, Fakultas Ilmu Komputer, Universitas Subang
- **Instansi Mitra:** SMK Negeri 1 Subang (SMEA)
