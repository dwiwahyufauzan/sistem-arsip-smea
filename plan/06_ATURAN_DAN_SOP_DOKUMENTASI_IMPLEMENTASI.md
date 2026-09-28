# 06. ATURAN DAN STANDAR OPERASIONAL PROSEDUR (SOP) DOKUMENTASI IMPLEMENTASI
**Sistem Informasi Pengelolaan Arsip SMKN 1 Subang**  
*Mekanisme Dokumentasi Berkelanjutan Per Tahap (Per-Stage Documentation Standard)*

---

## 📌 1. Prinsip Utama Alur Dokumentasi

Sesuai instruksi pengembangan, setiap proses implementasi harus terdokumentasi secara transparan, terukur, dan dapat diverifikasi secara ilmiah untuk kebutuhan penyusunan laporan Skripsi:

1. **Satu Berkas Dokumentasi Per Tahap (`README.md` Per Tahapan)**
   - Setiap tahapan memiliki subfolder tersendiri di dalam direktori `plan/tahapan/tahap-XX-.../README.md`.
   - File tersebut memuat:
     - Deskripsi tujuan dan target fungsionalitas (SRS/NFR yang diimplementasikan).
     - Rincian berkas yang dibuat/dimodifikasi (*Deliverables*).
     - Perintah eksekusi (*Terminal Commands*).
     - Hasil pengujian (*Verification & Test Results*).
     - Status tahapan: `🔴 Belum Dimulai`, `🟡 Sedang Dikerjakan`, `🟢 Selesai`.

2. **Sinkronisasi Otomatis ke `README.md` Utama (Root & Plan Index)**
   - Setiap kali sebuah tahapan selesai diimplementasikan:
     - Tabel **Tracking Status Implementasi** pada [`README.md`](file:///c:/Users/Dwi%20Wahyu%20Fauzan/sistem-arsip-smea/README.md) di root project wajib diperbarui statusnya (`🟢 Selesai`).
     - Tautan menuju `plan/tahapan/tahap-XX-.../README.md` dipastikan aktif.
     - Ringkasan perubahan (*progress summary*) diperbarui.

3. **Komit Git Per Tahap (Atomic Commits)**
   - Setiap penyelesaian satu tahap implementasi harus diakhiri dengan komit Git berformat konvensional:
     `git commit -m "feat(tahap-XX): deskripsi implementasi fitur"`
     dan segera di-push ke repository GitHub:
     `git push origin main`

---

## 🧭 2. Struktur Direktori Dokumentasi Tahapan

```
plan/
├── README.md                                  # Index Master Plan & Status Matrix
├── 00_OVERVIEW_DAN_ANALISIS_SKRIPSI.md
├── 01_TECH_STACK_DAN_ARSITEKTUR_SISTEM.md
├── 02_PERANCANGAN_DATABASE_DAN_ERD.md
├── 03_IMPLEMENTASI_ALGORITMA_KMP.md
├── 04_DESAIN_WORKFLOW_DAN_UML.md
├── 05_ROADMAP_DAN_FASE_IMPLEMENTASI_RUP.md
├── 06_ATURAN_DAN_SOP_DOKUMENTASI_IMPLEMENTASI.md
└── tahapan/
    ├── tahap-01-environment-setup/README.md
    ├── tahap-02-inisialisasi-laravel/README.md
    ├── tahap-03-frontend-tailwind/README.md
    ├── tahap-04-koneksi-database/README.md
    ├── tahap-05-migrasi-database/README.md
    ├── tahap-06-model-eloquent/README.md
    ├── tahap-07-database-seeder/README.md
    ├── tahap-08-autentikasi-rbac/README.md
    ├── tahap-09-master-layout-ui/README.md
    ├── tahap-10-engine-algoritma-kmp/README.md
    ├── tahap-11-master-data/README.md
    ├── tahap-12-modul-surat-masuk/README.md
    ├── tahap-13-modul-surat-keluar/README.md
    ├── tahap-14-persetujuan-disposisi-kepsek/README.md
    ├── tahap-15-layanan-legalisir-online/README.md
    ├── tahap-16-pencarian-cerdas-kmp/README.md
    └── tahap-17-cetak-agenda-pengujian-skripsi/README.md
```
