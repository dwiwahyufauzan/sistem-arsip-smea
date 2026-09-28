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

## 📂 Master Plan & Dokumentasi

Perencanaan sistem yang komprehensif dapat dipelajari pada folder [`plan/`](./plan):
- [`plan/README.md`](./plan/README.md) - Daftar isi dan ringkasan eksekutif master plan
- [`plan/00_OVERVIEW_DAN_ANALISIS_SKRIPSI.md`](./plan/00_OVERVIEW_DAN_ANALISIS_SKRIPSI.md) - Analisis kebutuhan (SRS & NFR)
- [`plan/01_TECH_STACK_DAN_ARSITEKTUR_SISTEM.md`](./plan/01_TECH_STACK_DAN_ARSITEKTUR_SISTEM.md) - Arsitektur sistem & RBAC
- [`plan/02_PERANCANGAN_DATABASE_DAN_ERD.md`](./plan/02_PERANCANGAN_DATABASE_DAN_ERD.md) - Skema basis data & ERD
- [`plan/03_IMPLEMENTASI_ALGORITMA_KMP.md`](./plan/03_IMPLEMENTASI_ALGORITMA_KMP.md) - Logika matematis & Service KMP
- [`plan/04_DESAIN_WORKFLOW_DAN_UML.md`](./plan/04_DESAIN_WORKFLOW_DAN_UML.md) - Pemodelan UML & Wireframe UI
- [`plan/05_ROADMAP_DAN_FASE_IMPLEMENTASI_RUP.md`](./plan/05_ROADMAP_DAN_FASE_IMPLEMENTASI_RUP.md) - 17 Tahap urutan implementasi teknis

---

## 👥 Pengembang & Peneliti
- **Penyusun Skripsi:** Ridwan Kurniawan (NPM: D1A230009)
- **Program Studi:** Sistem Informasi, Fakultas Ilmu Komputer, Universitas Subang
- **Instansi Mitra:** SMK Negeri 1 Subang (SMEA)
