# 01. TECH STACK DAN ARSITEKTUR SISTEM
**Sistem Informasi Pengelolaan Arsip SMKN 1 Subang**  
*Penerapan Algoritma Knuth-Morris-Pratt (KMP) & Metode RUP*

---

## 1. Spesifikasi Tech Stack Resmi Dokumen Skripsi

Berdasarkan **Tabel 10 (Analisa Kebutuhan Perangkat Lunak)** pada Bab IV Proposal Skripsi, sistem dibangun menggunakan teknologi terstandar:

```
+-----------------------------------------------------------------------------------+
|                            KOMPOSISI TECH STACK                                   |
+-------------------+---------------------------------------------------------------+
| Komponen          | Teknologi / Versi Acuan                                       |
+-------------------+---------------------------------------------------------------+
| Sistem Operasi    | Windows 10 / 11                                               |
| Code Editor       | Visual Studio Code                                            |
| Local Server      | Laragon / PHP CLI Server                                      |
| Bahasa Pemrograman| PHP 8.2+ / PHP 8.4 (Sesuai environment mesin terpasang)       |
| Backend Framework | Laravel Framework (MVC Architecture)                          |
| Basis Data (DBMS) | MySQL 8.x                                                     |
| Frontend Style    | Tailwind CSS (Utility-First CSS)                              |
| JS Runtime & Build| Node.js & Vite Build Tool                                     |
| Browser Testing   | Google Chrome / Chromium Modern                               |
| Version Control   | Git (Repository Management)                                   |
+-------------------+---------------------------------------------------------------+
```

---

## 2. Arsitektur Perangkat Lunak (Layered Architecture)

Untuk menjaga kode program tetap bersih, mudah dirawat (*maintainable*), dan sesuai dengan prinsip rekayasa perangkat lunak akademik, sistem menerapkan arsitektur berlapis: **MVC + Service Layer Pattern**.

```
+----------------------------------------------------------------------------+
|                       PRESENTATION LAYER (VIEW)                            |
|  - Laravel Blade Templates                                                 |
|  - Tailwind CSS Styling (Clean, Professional, Dashboard Theme)             |
|  - Alpine.js / Vanilla JS (Dynamic Modal, File Preview, Instant Filter)    |
+----------------------------------------------------------------------------+
                                      |
                                      v
+----------------------------------------------------------------------------+
|                      APPLICATION LAYER (CONTROLLER)                        |
|  - AuthController (Login, Logout, Role Redirection)                        |
|  - SuratMasukController (CRUD & Metadata Agenda)                           |
|  - SuratKeluarController (CRUD & Pengajuan Persetujuan)                    |
|  - LegalisirController (Pengajuan, Verifikasi, Update Status)              |
|  - PersetujuanController (Review & Approval Kepala Sekolah)                |
|  - KmpSearchController (Pencarian Cerdas Antarmuka KMP)                    |
+----------------------------------------------------------------------------+
                                      |
                                      v
+----------------------------------------------------------------------------+
|                        BUSINESS & SERVICE LAYER                            |
|  - KmpSearchService.php (Algoritma Pencocokan Pola Knuth-Morris-Pratt)     |
|  - FileStorageService.php (Upload Validasi Dokumen PDF/JPG & Storage)      |
|  - ApprovalWorkflowService.php (Transisi Status & Logging Riwayat)         |
+----------------------------------------------------------------------------+
                                      |
                                      v
+----------------------------------------------------------------------------+
|                       DATA PERSISTENCE LAYER (MODEL)                       |
|  - Eloquent ORM: User, SuratMasuk, SuratKeluar, Legalisir, Disposisi, dll.  |
|  - Database Migrations & Seeders                                           |
+----------------------------------------------------------------------------+
                                      |
                                      v
+----------------------------------------------------------------------------+
|                            DATABASE (STORAGE)                              |
|  - MySQL Database Engine (InnoDB, Foreign Key Constrains, B-Tree Indexes)  |
|  - File Storage System (`storage/app/public/...`)                          |
+----------------------------------------------------------------------------+
```

---

## 3. Desain Autentikasi dan Role-Based Access Control (RBAC)

Sistem membedakan tiga level otorisasi dengan hak istimewa yang terisolasi:

### 3.1. Pembagian Peran (Role Mapping)
1. **Peran `admin` (Petugas Tata Usaha / Arsiparis)**
   - Dashboard: Statistik surat masuk bulanan, surat keluar, antrean legalisir baru, rekapitulasi berkas.
   - Akses rute: `/admin/*`
   - Otorisasi: Kelola master data, tambah/edit/hapus surat masuk & keluar, upload dokumen, validasi berkas legalisir, ubah status pengerjaan, eksekusi pencarian KMP.
2. **Peran `kepala_sekolah` (Pimpinan)**
   - Dashboard: Ringkasan dokumen yang butuh persetujuan (*Pending Approvals*), grafik rekapitulasi surat tahunan, log disposisi.
   - Akses rute: `/kepala-sekolah/*`
   - Otorisasi: Melihat semua surat & dokumen berkas, memberikan persetujuan/penolakan surat keluar, memberikan persetujuan legalisir ijazah, pencarian KMP.
3. **Peran `pemohon` (Alumni / Siswa / Masyarakat)**
   - Dashboard / Portal: Formulir pengajuan legalisir mandiri, status berkas (*live tracking tracker timeline*), panduan layanan legalisir SMKN 1 Subang.
   - Akses rute: `/pemohon/*` dan portal publik `/legalisir/track`
   - Otorisasi: Mengajukan legalisir, upload berkas scan identitas & ijazah, memantau nomor resi/token pengajuan.

### 3.2. Middleware Proteksi Rute
- `auth`: Memastikan user telah login.
- `role:admin`: Membatasi rute operasional khusus petugas.
- `role:kepala_sekolah`: Membatasi rute eksekutif pimpinan.
- `role:pemohon`: Membatasi rute portal permohonan alumni.

---

## 4. Standar Penyimpanan Dokumen Digital (Digital Archive Storage)

Arsip di SMKN 1 Subang berupa dokumen penting (SK, Surat Dinas, Berita Acara, Ijazah, Transkrip Nilai). Oleh karena itu, penanganan file harus mengikuti standar keamanan:

1. **Format File yang Didukung:**
   - Dokumen Berkas: `PDF` (Sangat disarankan untuk arsip legal & surat dinas).
   - Dokumen Gambar: `JPG`, `JPEG`, `PNG` (Untuk hasil scan stempel atau surat singkat).
2. **Batas Ukuran:**
   - Maksimum per file: `5 MB` (Mencegah beban server berlebih namun kualitas gambar tetap terbaca jelas).
3. **Struktur Direktori Penyimpanan:**
   ```
   storage/app/public/
   ├── dokumen-surat-masuk/
   │   └── YYYY/MM/uuid-surat-masuk.pdf
   ├── dokumen-surat-keluar/
   │   └── YYYY/MM/uuid-surat-keluar.pdf
   ├── dokumen-legalisir/
   │   ├── pemohon/uuid-berkas-asli.pdf
   │   └── hasil/uuid-berkas-legalisir.pdf
   └── temp/
   ```
4. **Keamanan URL & Tautan Simbolik:**
   - File diakses melalui tautan simbolik publik `php artisan storage:link` atau controller khusus dengan otorisasi unduh (`download-secure`) untuk mencegah akses publik ilegal.

---

## 5. Standar Antarmuka dan Desain UI/UX (Tailwind CSS)

Sistem dirancang dengan identitas visual profesional bernuansa instansi pendidikan:
- **Palet Warna:**
  - *Primary*: Deep Navy Blue (`#1E3A8A` / `blue-900`) melambangkan formalitas, keandalan, dan wibawa SMKN 1 Subang.
  - *Accent / Teal*: Energetic Teal (`#0D9488` / `teal-600`) memberikan kesan sistem modern dan ramah pengguna.
  - *Neutral*: Slate Grey (`slate-50` s/d `slate-900`) untuk keterbacaan teks maksimal.
  - *Status Indicators*:
    - Sukses/Disetujui: Emerald Green (`emerald-600`)
    - Menunggu/Pending: Amber Gold (`amber-500`)
    - Ditolak/Revisi: Rose Red (`rose-600`)
    - Sedang Diproses: Sky Blue (`sky-600`)
- **Tipografi:** Google Font *Plus Jakarta Sans* atau *Inter* untuk tampilan teks yang modern, bersih, dan mudah dibaca pada monitor administrasi sekolah.
- **Responsivitas:** Kompatibel penuh dari resolusi 1366x768 (standar PC administrasi) hingga layar laptop full HD dan ponsel.
