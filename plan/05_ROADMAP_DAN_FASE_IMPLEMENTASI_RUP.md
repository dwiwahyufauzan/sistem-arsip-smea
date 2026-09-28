# 05. ROADMAP DAN URUTAN IMPLEMENTASI SISTEM (LENGKAP & TERSTRUKTUR)
**Sistem Informasi Pengelolaan Arsip SMKN 1 Subang**  
*Penerapan Algoritma Knuth-Morris-Pratt (KMP) & Metodologi Rational Unified Process (RUP)*

---

## 🧭 Ikhtisar Filosofi Urutan Pengembangan

Agar pengembangan sistem berjalan teratur, bebas galat (*bug-free*), dan sesuai dengan target luaran skripsi di SMKN 1 Subang, seluruh implementasi dibagi menjadi **17 Langkah Berurutan (Step-by-Step Sequence)** yang mencakup 4 fase RUP (*Inception, Elaboration, Construction, Transition*):

```
+---------------------------------------------------------------------------------------------------+
|                                 URUTAN ALUR IMPLEMENTASI SISTEM                                   |
+---------------------------------------------------------------------------------------------------+
| 1. Environment & Prerequisite Check (PHP 8.4, Composer, Node.js, Laragon/MySQL)                   |
| 2. Inisialisasi Proyek Laravel (Preservasi Berkas Skripsi & Setup Struktur Bersih)               |
| 3. Instalasi & Konfigurasi Frontend Tech Stack (Tailwind CSS, PostCSS, Autoprefixer, Vite)        |
| 4. Konfigurasi Environment (.env) & Koneksi Database MySQL                                       |
| 5. Pembuatan Skema Migrasi Basis Data (8 Tabel Utama & Relasi Foreign Key)                        |
| 6. Pembuatan Model Eloquent & Relasi Data (User, Surat, Legalisir, Disposisi, Log)                |
| 7. Pembuatan Database Seeder (Akun Default 3 Role, Kategori Surat Resmi, Sampel Data)             |
| 8. Implementasi Autentikasi Pengguna & Role-Based Access Control (RBAC)                           |
| 9. Pembangunan Master Layout & UI Components (Admin, Kepsek, Pemohon - Tailwind CSS)              |
| 10. Pembangunan Engine Algoritma Knuth-Morris-Pratt (KMP) Service & Unit Testing                  |
| 11. Implementasi Modul Master Data (Kategori Surat & Profil Pengguna)                             |
| 12. Implementasi Modul Surat Masuk (CRUD, Upload Scan PDF, Previewer, Disposisi)                 |
| 13. Implementasi Modul Surat Keluar (CRUD, Draf, Upload Berkas, Pengajuan Persetujuan)             |
| 14. Implementasi Modul Persetujuan & Disposisi Kepala Sekolah (Approval Workflow)                 |
| 15. Implementasi Modul Layanan Legalisir Online (Portal Publik, Live Tracking, Verifikasi TU)     |
| 16. Integrasi Fitur Pencarian Cerdas Terpadu KMP (Multi-Tabel Matching & Highlighting)            |
| 17. Modul Rekapitulasi Cetak Agenda, Pengujian Black Box Testing, & Dokumentasi Skripsi           |
+---------------------------------------------------------------------------------------------------+
```

---

## 📋 Rincian Langkah Demi Langkah (Step-by-Step Implementation)

### TAHAP 1: Verifikasi & Penyiapan Lingkungan Pengembangan (Environment Setup)
- [ ] **Langkah 1.1: Pemeriksaan Versi Runtime & Package Manager**
  - Pastikan PHP versi 8.2+ aktif (`php -v` -> terpasang PHP 8.4.6).
  - Pastikan ekstensi PHP wajib aktif: `pdo_mysql`, `mbstring`, `fileinfo`, `openssl`, `curl`, `gd`.
  - Pastikan Composer versi 2.x aktif (`composer -v` -> terpasang Composer 2.9.5).
  - Pastikan Node.js dan npm aktif (`node -v` -> v24.14.1, `npm -v` -> 11.3.0).
- [ ] **Langkah 1.2: Pemeriksaan Layanan Database MySQL (Laragon / Service)**
  - Mengaktifkan layanan MySQL pada port `3306` melalui panel Laragon (atau menjalankan instance MySQL lokal).
  - Memastikan user `root` tanpa password dapat diakses untuk pembuatan basis data proyek.

---

### TAHAP 2: Inisialisasi Proyek Laravel & Integrasi Workspace
- [ ] **Langkah 2.1: Pembuatan Kerangka Proyek Laravel**
  - Mengunduh kerangka kerja Laravel terbaru menggunakan Composer ke dalam workspace `sistem-arsip-smea`.
  - Memastikan folder yang sudah ada (`DOKUMEN-SKRIPSI/` dan `plan/`) tetap aman dan tidak terhapus.
- [ ] **Langkah 2.2: Pembuatan Tautan Simbolik Penyimpanan (Storage Symlink)**
  - Menjalankan `php artisan storage:link` untuk menghubungkan `storage/app/public` ke `public/storage`.
  - Membuat subfolder direktori penyimpanan khusus:
    - `storage/app/public/dokumen-surat-masuk/`
    - `storage/app/public/dokumen-surat-keluar/`
    - `storage/app/public/dokumen-legalisir/`
    - `storage/app/public/avatars/`

---

### TAHAP 3: Instalasi & Konfigurasi Frontend Tech Stack (Tailwind CSS & Vite)
- [ ] **Langkah 3.1: Instalasi Package Frontend**
  - Menjalankan `npm install -D tailwindcss postcss autoprefixer @tailwindcss/forms @tailwindcss/typography`.
  - Menginisialisasi file konfigurasi Tailwind: `npx tailwindcss init -p`.
- [ ] **Langkah 3.2: Konfigurasi `tailwind.config.js`**
  - Mengatur path content pada seluruh file Blade:
    ```js
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ]
    ```
  - Menambahkan palet warna resmi instansi SMKN 1 Subang:
    - `primary`: Navy Blue (`#1E3A8A` / `#1E40AF`)
    - `accent`: Modern Teal (`#0D9488` / `#0F766E`)
    - `success`: Emerald (`#059669`)
    - `warning`: Amber (`#D97706`)
    - `danger`: Rose Red (`#E11D48`)
- [ ] **Langkah 3.3: Konfigurasi `resources/css/app.css` & `vite.config.js`**
  - Mengimpor `@tailwind base;`, `@tailwind components;`, `@tailwind utilities;`.
  - Mengatur konfigurasi build Vite untuk integrasi Laravel Blade.
- [ ] **Langkah 3.4: Uji Coba Kompilasi Frontend**
  - Menjalankan `npm run build` untuk memastikan tidak ada kesalahan kompilasi CSS dan JS.

---

### TAHAP 4: Konfigurasi Environment & Database MySQL
- [ ] **Langkah 4.1: Konfigurasi File `.env`**
  - Mengatur identitas aplikasi:
    ```ini
    APP_NAME="Sistem Informasi Arsip SMKN 1 Subang"
    APP_ENV=local
    APP_DEBUG=true
    APP_URL=http://localhost:8000
    ```
  - Mengatur koneksi basis data MySQL:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sistem_arsip_smea
    DB_USERNAME=root
    DB_PASSWORD=
    ```
- [ ] **Langkah 4.2: Pembuatan Basis Data MySQL**
  - Mengeksekusi pembuatan database `sistem_arsip_smea` pada server MySQL lokal.
  - Memastikan hak akses penuh user `root` terhadap database tersebut.

---

### TAHAP 5: Perancangan & Eksekusi Migrasi Basis Data (8 Tabel Utama)
- [ ] **Langkah 5.1: Migrasi `users` (Pembaruan Skema Akun)**
  - Menambahkan kolom: `role` (ENUM: `admin`, `kepala_sekolah`, `pemohon`), `nip_nisn`, `phone_number`, `avatar`.
- [ ] **Langkah 5.2: Migrasi `kategori_surat`**
  - Kolom: `id`, `kode_kategori` (Unique), `nama_kategori`, `deskripsi`, timestamps.
- [ ] **Langkah 5.3: Migrasi `surat_masuk`**
  - Kolom: `id`, `nomor_agenda` (Unique), `nomor_surat`, `tanggal_surat`, `tanggal_terima`, `pengirim`, `penerima`, `perihal`, `isi_ringkas`, `kategori_id` (FK), `file_path`, `file_name`, `file_size`, `status` (ENUM: `diterima`, `didisposisikan`, `diarsipkan`), `user_id` (FK), timestamps.
- [ ] **Langkah 5.4: Migrasi `surat_keluar`**
  - Kolom: `id`, `nomor_agenda` (Unique), `nomor_surat`, `tanggal_surat`, `tujuan`, `perihal`, `isi_ringkas`, `kategori_id` (FK), `file_path`, `file_name`, `file_size`, `status_persetujuan` (ENUM: `draft`, `menunggu_persetujuan`, `disetujui`, `ditolak`), `catatan_kepsek`, `disetujui_oleh` (FK to users), `tanggal_disetujui`, `user_id` (FK), timestamps.
- [ ] **Langkah 5.5: Migrasi `disposisi_surat_masuk`**
  - Kolom: `id`, `surat_masuk_id` (FK on delete cascade), `diberikan_oleh` (FK to users), `tujuan_disposisi`, `instruksi`, `catatan`, `batas_waktu`, `status` (ENUM: `menunggu`, `ditindaklanjuti`, `selesai`), timestamps.
- [ ] **Langkah 5.6: Migrasi `pengajuan_legalisir`**
  - Kolom: `id`, `nomor_pengajuan` (Unique, cth: `LEG-202609-0001`), `user_id` (FK, Nullable), `nama_pemohon`, `nisn`, `tahun_lulus`, `nomor_whatsapp`, `email`, `jenis_dokumen` (ENUM: `ijazah`, `transkrip_nilai`, `rapor`, `sertifikat_keahlian`), `jumlah_lembar`, `keperluan`, `file_dokumen_path`, `status` (ENUM: `menunggu_verifikasi`, `diverifikasi`, `menunggu_approval_kepsek`, `disetujui_kepsek`, `sedang_diproses`, `siap_diambil`, `selesai`, `ditolak`), `catatan_petugas`, `catatan_kepsek`, `tanggal_siap_ambil`, `tanggal_pengambilan`, `petugas_id` (FK to users), timestamps.
- [ ] **Langkah 5.7: Migrasi `riwayat_legalisir`**
  - Kolom: `id`, `pengajuan_legalisir_id` (FK), `status_sebelumnya`, `status_baru`, `diubah_oleh` (FK), `catatan`, timestamp `created_at`.
- [ ] **Langkah 5.8: Migrasi `log_aktivitas`**
  - Kolom: `id`, `user_id` (FK), `aksi`, `modul`, `deskripsi`, `ip_address`, `user_agent`, timestamp `created_at`.
- [ ] **Langkah 5.9: Eksekusi Migrasi**
  - Menjalankan `php artisan migrate:fresh` dan memvalidasi keutuhan struktur tabel di MySQL.

---

### TAHAP 6: Pembuatan Model Eloquent & Relasi Data
- [ ] **Langkah 6.1: Model `User`**
  - Menambahkan relasi: `suratMasukInput()`, `suratKeluarInput()`, `disposisiDiberikan()`, `pengajuanLegalisir()`.
  - Menambahkan method helper: `isAdmin()`, `isKepalaSekolah()`, `isPemohon()`.
- [ ] **Langkah 6.2: Model `KategoriSurat`**
  - Menambahkan relasi `hasMany` ke `SuratMasuk` dan `SuratKeluar`.
- [ ] **Langkah 6.3: Model `SuratMasuk`**
  - Menambahkan relasi `belongsTo` ke `KategoriSurat`, `belongsTo` ke `User`, dan `hasMany` ke `DisposisiSuratMasuk`.
- [ ] **Langkah 6.4: Model `SuratKeluar`**
  - Menambahkan relasi `belongsTo` ke `KategoriSurat`, `belongsTo` ke pembuat (`User`), dan `belongsTo` ke Kepala Sekolah yang menyetujui.
- [ ] **Langkah 6.5: Model `DisposisiSuratMasuk`**
  - Menambahkan relasi `belongsTo` ke `SuratMasuk` dan `belongsTo` ke `User` (Kepala Sekolah).
- [ ] **Langkah 6.6: Model `PengajuanLegalisir`**
  - Menambahkan relasi `belongsTo` ke pemohon (`User`), `belongsTo` ke `petugas`, dan `hasMany` ke `RiwayatLegalisir`.
- [ ] **Langkah 6.7: Model `RiwayatLegalisir`**
  - Menambahkan relasi `belongsTo` ke `PengajuanLegalisir` dan `User`.
- [ ] **Langkah 6.8: Model `LogAktivitas`**
  - Menambahkan relasi `belongsTo` ke `User` dan static helper `LogAktivitas::catat(...)`.

---

### TAHAP 7: Database Seeder (Data Awal & Pengguna Default)
- [ ] **Langkah 7.1: Seeder Pengguna Default (Multi-Role)**
  - Akun Petugas TU: `petugas@smkn1subang.sch.id` | Password: `password` | Role: `admin`.
  - Akun Kepala Sekolah: `kepsek@smkn1subang.sch.id` | Password: `password` | Role: `kepala_sekolah`.
  - Akun Pemohon Sampel: `alumni@smkn1subang.sch.id` | Password: `password` | Role: `pemohon`.
- [ ] **Langkah 7.2: Seeder Master Kategori Surat Resmi SMKN 1 Subang**
  - `421.5/KUR` - Kurikulum & Pembelajaran
  - `421.5/KSW` - Kesiswaan & Ekstrakurikuler
  - `421.5/HUMAS` - Hubungan Industri & Kerja Sama Industri (Prakerin)
  - `421.5/SARPRAS` - Sarana & Prasarana
  - `421.5/TU` - Tata Usaha & Kepegawaian
  - `421.5/DISDIK` - Dinas Pendidikan & Instansi Pemerintah
- [ ] **Langkah 7.3: Seeder Sampel Arsip Riil**
  - Menyiapkan data sampel surat masuk dan surat keluar berformat realistis untuk bahan pengujian pencarian KMP.
- [ ] **Langkah 7.4: Eksekusi Seeder**
  - Menjalankan `php artisan db:seed` untuk mengisi data awal ke basis data.

---

### TAHAP 8: Autentikasi Pengguna & Role-Based Access Control (RBAC)
- [ ] **Langkah 8.1: Controller Autentikasi (`AuthController.php`)**
  - Method `showLoginForm()`: Menampilkan formulir login bernuansa SMKN 1 Subang.
  - Method `login()`: Validasi kredensial, proteksi *rate limiting*, dan pengalihan dinamis berdasarkan peran:
    - `admin` $\rightarrow$ dialihkan ke rute `/admin/dashboard`
    - `kepala_sekolah` $\rightarrow$ dialihkan ke rute `/kepala-sekolah/dashboard`
    - `pemohon` $\rightarrow$ dialihkan ke rute `/pemohon/dashboard`
  - Method `logout()`: Invalidation session & regenerasi CSRF token.
  - Fitur registrasi mandiri akun pemohon (khusus alumni/siswa).
- [ ] **Langkah 8.2: Pembuatan Middleware Otorisasi (`RoleMiddleware.php`)**
  - Mendaftarkan alias middleware di `bootstrap/app.php` (Laravel 11) atau `Kernel.php`.
  - Memastikan pengecekan otorisasi: pengguna yang tidak memiliki peran berhak langsung dicegah dengan kode `403 Forbidden` atau dialihkan ke halaman yang sesuai.
- [ ] **Langkah 8.3: Pengelompokan Rute (`routes/web.php`)**
  - Grup Rute Publik (Landing Page, Form Pengajuan Legalisir Publik, Tracking Resi Publik).
  - Grup Rute `admin` (Prefix: `/admin`, Middleware: `auth`, `role:admin`).
  - Grup Rute `kepala_sekolah` (Prefix: `/kepala-sekolah`, Middleware: `auth`, `role:kepala_sekolah`).
  - Grup Rute `pemohon` (Prefix: `/pemohon`, Middleware: `auth`, `role:pemohon`).

---

### TAHAP 9: Pembangunan Master Layout & UI Components (Tailwind CSS)
- [ ] **Langkah 9.1: Layout Admin/Petugas (`resources/views/layouts/admin.blade.php`)**
  - Sidebar vertikal terstruktur: Dashboard, Surat Masuk, Surat Keluar, Layanan Legalisir, Pencarian Cerdas KMP, Kategori Arsip, Pengguna, Laporan.
  - Header: Search bar KMP instan, info profil pengguna, tombol logout.
  - Flash Toast Notification (Pesan Sukses, Peringatan, Error).
- [ ] **Langkah 9.2: Layout Kepala Sekolah (`resources/views/layouts/kepsek.blade.php`)**
  - Navigasi eksekutif pimpinan: Ringkasan Pengawasan, Antrean Persetujuan Surat Keluar, Antrean Pengesahan Legalisir, Disposisi Surat Masuk, Pencarian KMP.
  - Badge counter warna merah/amber untuk surat yang sedang menunggu persetujuan.
- [ ] **Langkah 9.3: Layout Publik & Pemohon (`resources/views/layouts/public.blade.php`)**
  - Tampilan hero banner SMKN 1 Subang, form interaktif yang ramah ponsel, informasi jam layanan kearsipan sekolah.
- [ ] **Langkah 9.4: Reusable Blade Components**
  - Component `status-badge`: Render badge warna dinamis sesuai status arsip.
  - Component `pdf-modal`: Modal JavaScript untuk pratinjau (*preview*) dokumen PDF langsung tanpa meninggalkan halaman.
  - Component `kmp-highlight`: Helper render kata kunci pencocokan yang diberi warna terang.

---

### TAHAP 10: Pembangunan Core Engine Algoritma Knuth-Morris-Pratt (KMP)
- [ ] **Langkah 10.1: Pembuatan Service `app/Services/KmpSearchService.php`**
  - Implementasi metode murni `computeLpsArray(string $pattern): array`.
  - Implementasi metode pencarian `search(string $pattern, string $text): array`.
  - Implementasi metode pencarian multi-field `searchInCollection(...)` untuk mencocokkan pattern pada nomor surat, perihal, pengirim, dan isi ringkas.
  - Implementasi metode penanda teks `highlightMatches(string $text, string $keyword): string`.
- [ ] **Langkah 10.2: Implementasi Modul Benchmark KMP vs Brute Force**
  - Metode `compareWithBruteForce(string $pattern, string $text): array` yang menghitung perbandingan durasi komputasi (dalam milidetik) dan persentase efisiensi.
- [ ] **Langkah 10.3: Pembuatan Unit Testing Algoritma KMP**
  - Menguji kebenaran komputasi LPS array pada berbagai pola string.
  - Menguji akurasi indeks pencocokan substring teks arsip.

---

### TAHAP 11: Implementasi Modul Master Data Kategori & Pengguna
- [ ] **Langkah 11.1: Controller `KategoriSuratController.php`**
  - CRUD Kategori Surat lengkap dengan kode klasifikasi arsip.
- [ ] **Langkah 11.2: Controller `UserController.php`**
  - Manajemen akun staf petugas TU dan Kepala Sekolah.
  - Pembaruan password dan profil akun pengguna.

---

### TAHAP 12: Implementasi Modul Surat Masuk (SRS-P02, SRS-P03, SRS-KS02)
- [ ] **Langkah 12.1: Controller `SuratMasukController.php`**
  - Method `index()`: Menampilkan tabel surat masuk dilengkapi filter kategori, tanggal terima, dan pencarian cepat.
  - Method `create()` & `store()`: Formulir input dengan generator nomor agenda otomatis dan validasi upload berkas PDF/Gambar (maks 5MB).
  - Method `show()`: Lembar detail informasi arsip, riwayat disposisi, dan PDF Viewer interaktif.
  - Method `edit()` & `update()`: Pembaruan metadata atau pergantian berkas scan.
  - Method `destroy()`: Penghapusan record database serta pembersihan file fisik di `storage/app/public/dokumen-surat-masuk/`.
  - Method `download()`: Pengunduhan aman berkas arsip surat masuk.

---

### TAHAP 13: Implementasi Modul Surat Keluar (SRS-P04, SRS-P05, SRS-KS03)
- [ ] **Langkah 13.1: Controller `SuratKeluarController.php`**
  - Method `index()`: Daftar seluruh surat keluar dengan badge status persetujuan pimpinan.
  - Method `create()` & `store()`: Pembuatan draf surat keluar, pemilihan nomor klasifikasi, dan pengunggahan berkas dokumen draf.
  - Method `ajukanPersetujuan()`: Mengubah status surat keluar menjadi `menunggu_persetujuan` agar muncul di dashboard Kepala Sekolah.
  - Method `show()`: Tinjauan draf surat keluar beserta riwayat catatan pimpinan.
  - Method `edit()`, `update()`, `destroy()`, dan `download()`.

---

### TAHAP 14: Implementasi Modul Persetujuan & Disposisi Kepala Sekolah (SRS-KS05, SRS-KS06, SRS-KS07)
- [ ] **Langkah 14.1: Controller `PersetujuanController.php`**
  - Halaman daftar antrean surat keluar yang membutuhkan persetujuan Kepala Sekolah.
  - Aksi `approveSuratKeluar()`: Kepala Sekolah menyetujui surat keluar, sistem mencatat waktu persetujuan dan mengubah status menjadi `disetujui`.
  - Aksi `rejectSuratKeluar()`: Kepala Sekolah menolak / meminta revisi surat keluar disertai catatan perbaikan, sistem mengubah status menjadi `ditolak`.
  - Aksi `approveLegalisir()`: Kepala Sekolah memberikan otorisasi pengesahan legalisir ijazah secara digital.
- [ ] **Langkah 14.2: Controller `DisposisiController.php`**
  - Fitur Kepala Sekolah memberikan lembar disposisi pada Surat Masuk: instruksi penanganan, pejabat/staf tujuan (cth: Waka Kurikulum, Pembina OSIS), batas waktu tindak lanjut, dan catatan pimpinan.
  - Tampilan cetak lembar disposisi standar instansi sekolah.

---

### TAHAP 15: Implementasi Modul Layanan Legalisir Online (SRS-L01..05, SRS-P06, SRS-P07, SRS-KS04)
- [ ] **Langkah 15.1: Controller `PengajuanLegalisirController.php` (Publik & Pemohon)**
  - Halaman publik formulir pengajuan legalisir mandiri (Nama, NISN, Tahun Lulus, Nomor WhatsApp aktif, Jenis Dokumen, Keperluan, Upload Scan Ijazah Asli).
  - Generator otomatis Kode Resi Pelacakan (Format: `LEG-YYYYMM-XXXX`).
  - Halaman `tracking`: Alumni memasukkan nomor resi $\rightarrow$ menampilkan visual status stepper real-time:
    `Pengajuan Diterima` $\rightarrow$ `Diverifikasi TU` $\rightarrow$ `Disetujui Kepsek` $\rightarrow$ `Sedang Dicetak/Distempel` $\rightarrow$ `Siap Diambil di Loket SMKN 1 Subang` $\rightarrow$ `Selesai`.
- [ ] **Langkah 15.2: Panel Verifikasi Petugas TU (`LegalisirAdminController.php`)**
  - Daftar antrean verifikasi legalisir masuk.
  - Pemeriksaan kelayakan berkas scan pemohon terhadap buku induk arsip sekolah.
  - Pembaruan status berkas: Menyetujui verifikasi berkas, menolak jika berkas buram/palsu (disertai catatan alasan), menentukan tanggal kesiapan pengambilan fisik di sekolah.
  - Riwayat audit trail pada tabel `riwayat_legalisir`.

---

### TAHAP 16: Integrasi Fitur Pencarian Cerdas Terpadu KMP (SRS-P08, SRS-P09, SRS-KS08, NFR-07)
- [ ] **Langkah 16.1: Controller `KmpSearchController.php`**
  - Menghubungkan search input global dengan `KmpSearchService`.
  - Melakukan pencarian terpadu secara simultan pada:
    1. Arsip Surat Masuk (field: `nomor_surat`, `perihal`, `pengirim`, `isi_ringkas`).
    2. Arsip Surat Keluar (field: `nomor_surat`, `perihal`, `tujuan`, `isi_ringkas`).
    3. Arsip Pengajuan Legalisir (field: `nomor_pengajuan`, `nama_pemohon`, `nisn`, `keperluan`).
- [ ] **Langkah 16.2: Antarmuka Hasil Pencarian Cerdas**
  - Menampilkan total temuan data, waktu eksekusi dalam milidetik (contoh: *Ditemukan 6 data dalam 1.28 ms menggunakan Algoritma KMP*).
  - Penyorotan teks kata kunci (*highlighting*) menggunakan tag `<mark>` Tailwind.
  - Tab navigasi hasil: Semua Hasil, Surat Masuk, Surat Keluar, Legalisir.
- [ ] **Langkah 16.3: Halaman Khusus Eksperimen & Komparasi KMP vs Brute Force**
  - Menyediakan halaman demo pengujian string matching bagi penguji skripsi untuk membuktikan keunggulan efisiensi algoritma KMP dibandingkan Brute Force secara langsung.

---

### TAHAP 17: Modul Rekapitulasi Cetak Agenda, Pengujian Black Box, & Dokumentasi Skripsi
- [ ] **Langkah 17.1: Fitur Cetak Buku Agenda & Laporan**
  - Cetak Agenda Surat Masuk per periode (Bulan/Tahun) berformat standar kearsipan pemerintah/sekolah.
  - Cetak Agenda Surat Keluar per periode.
  - Laporan Rekapitulasi Pelayanan Legalisir.
- [ ] **Langkah 17.2: Pengujian Fungsional Sistem (Black Box Testing)**
  - Menguji kesesuaian seluruh kebutuhan fungsional Petugas (SRS-P01 s/d SRS-P11).
  - Menguji kesesuaian seluruh kebutuhan fungsional Kepala Sekolah (SRS-KS01 s/d SRS-KS10).
  - Menguji kesesuaian seluruh kebutuhan fungsional Pemohon Legalisir (SRS-L01 s/d SRS-L05).
  - Mengisi tabel hasil pengujian Black Box untuk disematkan pada Bab IV dokumen skripsi.
- [ ] **Langkah 17.3: Dokumentasi Teknis & Panduan Pengguna**
  - Penyusunan `USER_GUIDE.md` (Panduan pengoperasian untuk Admin, Kepala Sekolah, dan Pemohon).
  - Penyusunan ringkasan teknis untuk bahan presentasi sidang skripsi.

---

## 🚀 Status Kesiapan Eksekusi
Seluruh tahapan di atas telah disusun berurutan secara ketat sesuai metodologi RUP. Kita dapat langsung mengeksekusi **Tahap 1 & Tahap 2 (Setup Environment & Inisialisasi Proyek Laravel)** sekarang!
