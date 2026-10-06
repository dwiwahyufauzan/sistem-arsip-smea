# Sistem Informasi Pengelolaan Arsip SMKN 1 Subang
### Penerapan Algoritma Knuth-Morris-Pratt (KMP) & Metode Rational Unified Process (RUP)

Repository ini berisi kode sumber dan dokumentasi rancang bangun **Sistem Informasi Pengelolaan Arsip berbasis Web** pada **SMK Negeri 1 Subang**. Sistem ini dikembangkan untuk mengoptimalkan pengelolaan dokumen arsip sekolah, meliputi pengelolaan **Surat Masuk**, **Surat Keluar**, dan **Layanan Legalisir Dokumen Online** dengan memanfaatkan algoritma pencarian string matching **Knuth-Morris-Pratt (KMP)** serta arsitektur kearsipan jangka panjang yang aman, andal, dan terverifikasi secara digital.

---

## 📌 Ringkasan Fitur Utama

1. **Pengelolaan Surat Masuk**
   - Pencatatan metadata surat masuk, pengunggahan scan dokumen fisik (PDF/JPG), lembar disposisi Kepala Sekolah terstandarisasi, dan pratinjau dokumen langsung di peramban.
2. **Pengelolaan Surat Keluar & Digital Seal**
   - Pembuatan konsep/draf surat keluar, pengunggahan dokumen, alur verifikasi & otorisasi (*approval*) pimpinan (Kepala Sekolah), penerbitan nomor agenda resmi, serta lembar cetak surat dinas resmi dengan stempel digital QR Code.
3. **Layanan Legalisir Dokumen Online & Tracking Resi**
   - Formulir permohonan legalisir mandiri bagi alumni/siswa, unggah scan ijazah/transkrip asli, verifikasi data oleh petugas TU, pengesahan Kepala Sekolah, pencetakan kartu tanda terima ber-QR Code, serta fitur *Live Tracking* status permohonan menggunakan nomor resi.
4. **Pencarian Cerdas Algoritma Knuth-Morris-Pratt (KMP)**
   - Engine pencarian teks berkecepatan tinggi ($\mathcal{O}(n+m)$) memanfaatkan tabel prefix-suffix (LPS array) pada seluruh data arsip dengan penanda warna (*highlighting*) kata kunci serta modul komparasi kinerja ilmiah terhadap algoritma *Brute Force*.
5. **Verifikasi Keabsahan Dokumen Publik (QR Code Verification)**
   - Halaman verifikasi publik mandiri tanpa login untuk memeriksa keaslian Surat Keluar dinas dan Permohonan Legalisir sekolah secara instan dan transparan.
6. **Integritas Kearsipan (Soft Deletes & Data Retention)**
   - Pengamanan dokumen arsip dari kehilangan tidak sengaja dengan retensi file fisik dan jejak audit (*audit trail*).
7. **Otomasi Notifikasi Pelayanan (WhatsApp Gateway Quick-Action)**
   - Layanan pengiriman notifikasi pembaruan status legalisir ke nomor WhatsApp pemohon secara instan dengan format pesan resmi.
8. **Disaster Recovery & Otomasi Pencadangan Data Harian**
   - Perintah pencadangan data mandiri (`arsip:backup`) yang terjadwal otomatis setiap hari dengan rotasi retensi cadangan 30 hari.

---

## 🛠️ Tech Stack

- **Backend:** Laravel Framework (PHP 8.4) - Arsitektur MVC + Service Layer
- **Basis Data:** MySQL 8.x
- **Frontend:** Tailwind CSS, Blade Templates, JavaScript / Alpine.js, Vite
- **Algoritma:** Knuth-Morris-Pratt (KMP) String Matching
- **Metodologi:** Rational Unified Process (RUP)
- **Testing Suite:** PHPUnit (138 Feature & Unit Tests, 628 Assertions - 100% Green)
- **Code Style:** Laravel Pint (PSR-12 Compliant)

---

## 🛡️ 5 Pilar Arsitektur & Peningkatan Jangka Panjang (Enterprise Ready)

Untuk menjamin sistem dapat digunakan secara berkelanjutan, aman, dan siap pakai dalam operasional institusi pendidikan jangka panjang, telah diimplementasikan 5 pilar arsitektur kearsipan:

### 1. Pilar Integritas Data & Retensi Kearsipan (Soft Deletes Architecture)
- **Implementasi:** Penerapan trait `Illuminate\Database\Eloquent\SoftDeletes` pada model inti kearsipan:
  - `SuratMasuk` (`surat_masuk`)
  - `SuratKeluar` (`surat_keluar`)
  - `PengajuanLegalisir` (`pengajuan_legalisir`)
  - `DisposisiSuratMasuk` (`disposisi_surat_masuk`)
- **Kebijakan Retensi File Fisik:** Saat petugas menghapus rekaman arsip, sistem menandai kolom `deleted_at` tanpa menghapus berkas fisik pindaian (PDF/JPG) dari `Storage`. Hal ini mencegah *human error* (penghapusan tidak sengaja) dan mematuhi kaidah retensi kearsipan dinas sehingga data dapat dipulihkan (*restore*) kapan saja jika diperlukan investigasi audit.
- **Proteksi Integritas Relasional:** Penghapusan Kategori Surat dan Pengguna memeriksa seluruh rekaman aktif maupun inaktif (`withTrashed()`) untuk mencegah terjadinya *orphan record*.

### 2. Pilar Keabsahan Dokumen & Digital Seal (QR Code Verification Engine)
- **Mesin Verifikasi Publik:** Tersedia rute verifikasi terbuka tanpa memerlukan autentikasi login guna memvalidasi keaslian dokumen di hadapan pihak ketiga (Dinas, Perguruan Tinggi, Instansi Kerja):
  - **Surat Keluar:** `/verifikasi/surat-keluar/{identifier}` (menampilkan keabsahan nomor surat, perihal, penandatangan, tanggal terbit, dan status pengesahan Kepala Sekolah).
  - **Legalisir Dokumen:** `/verifikasi/legalisir/{nomor_pengajuan}` (menampilkan keaslian legalisir ijazah/transkrip, nama pemohon, NISN, dan tanggal pengesahan).
- **Proteksi Privasi Pemohon (Data Masking):** Pada tampilan verifikasi publik, data sensitif pemohon (nama dan NISN) disamarkan secara otomatis (contoh: `R*** K*******`, `00****2134`) guna mematuhi prinsip pelindungan data pribadi (UU PDP).
- **Integrasi Cetak Fisik:**
  - Lembar cetak Surat Keluar resmi sekolah dilengkapi blok tanda tangan 3 kolom dengan **QR Code Digital Seal** resmi di bagian tengah.
  - Kartu Tanda Terima Registrasi Legalisir memuat QR Code yang dapat langsung dipindai oleh kamera ponsel alumni/siswa untuk memantau status pengerjaan secara *live*.

### 3. Pilar Otomasi Komunikasi Pelayanan (Notification Service & WhatsApp Gateway)
- **Arsitektur Service Layer:** Disediakan class layanan [`app/Services/NotificationService.php`](file:///c:/Users/Dwi%20Wahyu%20Fauzan/sistem-arsip-smea/app/Services/NotificationService.php) untuk:
  - Normalisasi nomor telepon lokal Indonesia ke format standar internasional (`08xx` $\rightarrow$ `628xx`).
  - Penyusunan otomatis draf pesan WhatsApp resmi yang ramah dan informatif berdasarkan status permohonan (`menunggu_verifikasi`, `diverifikasi`, `disetujui`, `siap_diambil`, `selesai`, atau `ditolak`).
  - Penyertaan tautan langsung ke halaman *Live Tracking* resi pengajuan (`nomor_pengajuan`).
- **Aksi Cepat Admin:** Pada halaman rincian legalisir admin (`/admin/legalisir/{id}`), tersedia panel **"Kirim Pembaruan WhatsApp"** yang memungkinkan petugas mengirim pesan konfirmasi ke alumni hanya dengan 1 kali klik via WhatsApp Web / WhatsApp Desktop.

### 4. Pilar Disaster Recovery & Otomasi Pencadangan Data (`arsip:backup`)
- **Perintah Artisan Kustom:** Sistem dilengkapi command khusus:
  ```bash
  # Melakukan backup database SQL + metadata JSON:
  php artisan arsip:backup

  # Melakukan backup database dan kompresi seluruh dokumen fisik scan (ZIP):
  php artisan arsip:backup --with-files

  # Melakukan backup sekaligus merotasi/membersihkan backup yang berusia > 30 hari:
  php artisan arsip:backup --clean --with-files
  ```
- **Karakteristik Backup Mandiri:**
  - Menghasilkan dump SQL murni (*DDL + INSERT statements*) yang dapat direstore langsung di DBMS MySQL mana saja tanpa ketergantungan pada binary eksternal `mysqldump`.
  - Menghasilkan ekspor data JSON terstruktur untuk kemudahan interoperabilitas antar-sistem.
  - Opsi kompresi dokumen fisik (`--with-files`) membungkus berkas scan surat dan ijazah ke dalam file ZIP terkompresi.
  - Berkas cadangan disimpan aman di direktori `storage/app/backups/`.
- **Penjadwalan Otomatis (Cron Job):**
  - Terdaftar pada [`routes/console.php`](file:///c:/Users/Dwi%20Wahyu%20Fauzan/sistem-arsip-smea/routes/console.php) untuk dieksekusi setiap hari pada pukul **01:00 dini hari WIB** secara otomatis (`Schedule::command('arsip:backup --clean --with-files')->dailyAt('01:00')`).

### 5. Pilar Jaminan Kualitas & Pengujian Otomatis (Automated Testing Suite)
- **Cakupan Pengujian:** Sistem diverifikasi dengan **138 Feature & Unit Tests** dengan **628 Assertions** yang mencakup:
  - Otentikasi, Rate Limiter Anti-Brute Force, dan Penolakan Akun Nonaktif (`is_active`).
  - Role-Based Access Control (Admin TU, Kepala Sekolah, Pemohon) & Otorisasi Policy (`PengajuanLegalisirPolicy`).
  - Proteksi IDOR pemohon dan pembatasan download berkas publik via *Signed URL*.
  - Penguncian draf surat keluar yang telah disetujui pimpinan dan pencegahan bypass status.
  - Validasi State Transition Matrix pada alur legalisir dan persetujuan pimpinan.
  - Validasi CRUD Surat Masuk & Surat Keluar berserta alur disposisi.
  - Kecepatan dan akurasi logika Algoritma KMP (Pencarian Eksak, LPS Array, Substring Matching).
  - Keamanan rute verifikasi publik dan integritas file backup (SQL, JSON, ZIP).
- **Hasil Uji:** 100% Lolos (*138 of 138 Tests Passed Green*).

---

## 🎨 Standarisasi Identitas Visual & Format Cetak Resmi

1. **Logo Resmi Instansi:**
   - Seluruh kop surat dinas, lembar disposisi pimpinan, cetak agenda arsip, dan kartu tanda terima legalisir telah distandarisasi menggunakan:
     - **Logo Pemerintah Provinsi Jawa Barat** (kiri kop surat).
     - **Logo Resmi SMK Negeri 1 Subang** (kanan kop surat).
2. **Kerapihan Antarmuka (UI/UX) & Navbar:**
   - Dropdown profil pada navbar atas telah diperbarui dengan tata letak vertikal hierarkis (*Nama Petugas* di atas, *NIP / Jabatan* di bawah) dengan latar belakang kontras dan jarak (*padding*) proporsional.
   - Tombol *Logout* ditempatkan secara ergonomis di dalam menu dropdown profil pengguna.
   - Tanda panah dropdown yang tidak perlu telah dibersihkan untuk menciptakan tampilan antarmuka yang bersih, minimalis, dan profesional.
3. **Format Cetak Terstandar (*Print Layout*):**
   - Format cetak surat dinas dan disposisi menggunakan standar kertas F4/A4 dengan margin resmi dinas kearsipan, stempel digital QR Code, dan pratinjau ramah cetak (*print-friendly CSS*).

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
| **06** | Pembuatan Model Eloquent & Relasi Data | [Tahap 06](./plan/tahapan/tahap-06-model-eloquent/README.md) | 🟢 Selesai |
| **07** | Database Seeder Data Awal & Pengguna Default | [Tahap 07](./plan/tahapan/tahap-07-database-seeder/README.md) | 🟢 Selesai |
| **08** | Autentikasi Pengguna & Role-Based Access Control (RBAC) | [Tahap 08](./plan/tahapan/tahap-08-autentikasi-rbac/README.md) | 🟢 Selesai |
| **09** | Pembangunan Master Layout & UI Components (Tailwind CSS) | [Tahap 09](./plan/tahapan/tahap-09-master-layout-ui/README.md) | 🟢 Selesai |
| **10** | Pembangunan Core Engine Algoritma Knuth-Morris-Pratt (KMP) | [Tahap 10](./plan/tahapan/tahap-10-engine-algoritma-kmp/README.md) | 🟢 Selesai |
| **11** | Implementasi Modul Master Data Kategori & Pengguna | [Tahap 11](./plan/tahapan/tahap-11-master-data/README.md) | 🟢 Selesai |
| **12** | Implementasi Modul Surat Masuk (SRS-P02, SRS-P03, SRS-KS02) | [Tahap 12](./plan/tahapan/tahap-12-modul-surat-masuk/README.md) | 🟢 Selesai |
| **13** | Implementasi Modul Surat Keluar (SRS-P04, SRS-P05, SRS-KS03) | [Tahap 13](./plan/tahapan/tahap-13-modul-surat-keluar/README.md) | 🟢 Selesai |
| **14** | Implementasi Modul Persetujuan & Disposisi Kepala Sekolah | [Tahap 14](./plan/tahapan/tahap-14-persetujuan-disposisi-kepsek/README.md) | 🟢 Selesai |
| **15** | Implementasi Modul Layanan Legalisir Online (SRS-L01..05) | [Tahap 15](./plan/tahapan/tahap-15-layanan-legalisir-online/README.md) | 🟢 Selesai |
| **16** | Integrasi Fitur Pencarian Cerdas Terpadu KMP | [Tahap 16](./plan/tahapan/tahap-16-pencarian-cerdas-kmp/README.md) | 🟢 Selesai |
| **17** | Modul Rekapitulasi Cetak Agenda, Pengujian Black Box, & Skripsi | [Tahap 17](./plan/tahapan/tahap-17-cetak-agenda-pengujian-skripsi/README.md) | 🟢 Selesai |
| **18** | Penguatan Arsitektur Jangka Panjang (Soft Deletes, QR Code, Backup) | Dokumentasi [README.md](./README.md) | 🟢 Selesai |
| **19** | Penguatan Keamanan, Tata Kelola & Integritas Kearsipan | Dokumentasi [README.md](./README.md) & [penilaian_proyek.md](./penilaian_proyek.md) | 🟢 Selesai |

---

## 🔍 Panduan Lengkap Penggunaan Fitur Pencarian Cerdas KMP

Sistem kearsipan ini mengintegrasikan **Algoritma Knuth-Morris-Pratt (KMP)** sebagai inti pencocokan string (*string matching*) linear $\mathcal{O}(n + m)$ untuk membedah data arsip secara presisi tanpa langkah mundur (*backtracking*).

### 1. Titik Akses Fitur Pencarian KMP
1. **Live Search Navbar (Cepat / Instan):**
   - Terletak pada kolom pencarian di bagian atas dashboard (Admin TU & Kepala Sekolah).
   - Cukup ketik minimal 2 karakter (misal: `prakerin`, `ukk`, `dahana`).
   - Sistem akan langsung menampilkan pratinjau dropdown hasil pencocokan KMP secara *real-time*.
2. **Halaman Pencarian Cerdas Terpadu (Penuh & Ilmiah):**
   - **Admin / Petugas TU:** Akses menu sidebar `Pencarian KMP` atau buka URL `/admin/pencarian-kmp`.
   - **Kepala Sekolah:** Akses menu sidebar `Pencarian KMP` atau buka URL `/kepala-sekolah/pencarian-kmp`.

### 2. Langkah Penggunaan & Parameter Pencarian
1. **Masukkan Kata Kunci (*Pattern*):**
   - Ketik kata kunci yang ingin dicari, contoh: `PRAKERIN`, `KURIKULUM`, `DAHANA`, `PINDAD`, `BEASISWA`, `IJAZAH`, `UKK`, `SARPRAS`, atau `SUBANG`.
2. **Pilih Lingkup Modul Kearsipan:**
   - **Semua Modul:** Menyisir simultan data Surat Masuk, Surat Keluar, dan Permohonan Legalisir.
   - **Surat Masuk Saja:** Memeriksa kolom `nomor_surat`, `pengirim`, `perihal`, dan `isi_ringkas`.
   - **Surat Keluar Saja:** Memeriksa kolom `nomor_surat`, `tujuan`, `perihal`, dan `isi_ringkas`.
   - **Permohonan Legalisir Saja:** Memeriksa `nomor_pengajuan`, `nama_pemohon`, `nisn`, dan `keperluan`.
3. **Opsi Pengujian Komparasi Ilmiah (Bab IV Skripsi):**
   - Centang opsi **"Bandingkan dengan Algoritma Brute Force (50 Iterasi Benchmark)"**.
   - Sistem akan melakukan 50 iterasi perbandingan komputasi KMP vs Brute Force pada teks korpus arsip.
4. **Klik Tombol "Mulai Pencarian KMP":**
   - Sistem mengeksekusi pencarian dalam hitungan fraksi milidetik.

### 3. Cara Membaca Hasil Pencarian KMP
- **Tabel Nilai LPS ($\pi$ / Longest Proper Prefix which is also Suffix):**
  - Menampilkan tabel prefix-suffix pola kata kunci sebagai bukti matematis algoritma KMP yang menentukan indeks lompatan saat terjadi *mismatch*.
- **Metrik Kinerja & Efisiensi Komputasi (Jika Komparasi Dicentang):**
  - **Waktu Rata-rata KMP:** Menunjukkan kecepatan linear $\mathcal{O}(n + m)$ dalam milidetik (misal: `0.0012 ms`).
  - **Waktu Rata-rata Brute Force:** Menunjukkan waktu komputasi kuadratik $\mathcal{O}(n \times m)$ (misal: `0.0035 ms`).
  - **Peningkatan Efisiensi (*Speedup*):** Menampilkan persentase keunggulan KMP (misal: `+65.7% Lebih Cepat`).
- **Penanda Teks (*Keyword Highlighting*):**
  - Setiap kemunculan kata kunci pada nomor surat, instansi, atau perihal ditandai dengan sorotan warna kuning `<mark>` yang rapi.
- **Aksi Cepat:**
  - Tombol **Lihat Detail** untuk memeriksa metadata arsip dan lembar disposisi.
  - Tombol **Pratinjau / Unduh Berkas** untuk membuka dokumen PDF langsung di browser.

---

## 👥 Kebijakan & Alur Registrasi Akun Siswa & Alumni

Sesuai dengan **Standar Operasional Prosedur (SOP) Tata Kelola Arsip SMKN 1 Subang**, pendaftaran akun sistem diatur sebagai berikut:

1. **Registrasi Mandiri Publik Dinonaktifkan:**
   - Formulir pendaftaran publik (`/register`) ditiadakan guna menjaga keaslian identitas buku induk kelulusan sekolah dan mencegah akun fiktif.
2. **Pendaftaran Terpusat oleh Admin Tata Usaha:**
   - Staf Tata Usaha dapat mendaftarkan akun Siswa dan Alumni secara resmi melalui menu **Manajemen Pengguna** (`/admin/pengguna`) dengan memilih peran `Pemohon (Siswa / Alumni SMKN 1 Subang)`, menginputkan nama lengkap, email, NISN 10 digit, nomor WhatsApp, serta kata sandi awal.
3. **Layanan Legalisir Tanpa Akun (Mandiri):**
   - Siswa dan alumni yang belum memiliki akun **tetap dapat mengajukan legalisir secara online** melalui formulir publik [`/legalisir/buat`](file:///c:/Users/Dwi%20Wahyu%20Fauzan/sistem-arsip-smea/resources/views/legalisir/create.blade.php).
   - Perkembangan verifikasi dokumen fisik dapat dipantau langsung kapan saja menggunakan nomor resi pengajuan pada fitur **Live Tracking** [`/legalisir/tracking`](file:///c:/Users/Dwi%20Wahyu%20Fauzan/sistem-arsip-smea/resources/views/legalisir/tracking.blade.php).

---

## ⚙️ Panduan Pemeliharaan & Operasional Sistem (Maintenance Guide)

### 1. Menjalankan Server Pengembangan Lokal
```bash
# Menjalankan server lokal Laravel:
php artisan serve

# Menjalankan Vite hot-reload (di terminal terpisah):
npm run dev

# Membangun bundle aset produksi:
npm run build
```

### 2. Menjalankan Pengujian Otomatis (Automated Testing)
```bash
# Menjalankan seluruh 129 test suite PHPUnit:
php vendor/bin/phpunit

# Atau menggunakan artisan test runner:
php artisan test
```

### 3. Eksekusi Pencadangan Data (Database & Arsip Backup)
```bash
# Melakukan backup instan ke direktori storage/app/backups/:
php artisan arsip:backup

# Melakukan backup sekaligus merotasi cadangan lama (> 30 hari):
php artisan arsip:backup --clean
```

### 4. Konfigurasi Task Scheduler di Server Produksi (Linux Cron)
Tambahkan entri cron berikut pada server Linux produksi (`crontab -e`):
```cron
* * * * * cd /path/to/sistem-arsip-smea && php artisan schedule:run >> /dev/null 2>&1
```
*Scheduler akan secara otomatis mengeksekusi `arsip:backup --clean` setiap hari pada pukul 01:00 WIB.*

### 5. Standardisasi Format Kode (Laravel Pint)
```bash
vendor/bin/pint --format agent
```

---

## 💾 Data Dummy Kearsipan SMKN 1 Subang (Seeder)

Proyek ini telah dilengkapi dengan data dummy kearsipan komprehensif untuk memfasilitasi pengujian pencarian KMP pada volume data yang representatif:

- **Total Surat Masuk:** 60 dokumen surat dinas dari Cabang Dinas Pendidikan Wilayah IV, Kemendikbud, PT Dahana, PT Pindad, PTDI, Telkom, Astra Honda, Perguruan Tinggi (ITB, UPI, Unsub, Polsub), serta pemohon alumni.
- **Total Surat Keluar:** 60 draf dan surat dinas resmi sekolah mencakup surat tugas UKK, rekomendasi beasiswa, pengantar magang industri, edaran dinas, dan pengesahan kurikulum.
- **Total Akun Siswa & Alumni (Role `pemohon`):** 20 akun siswa/alumni lengkap dengan NISN dan nomor telepon.
- **Permohonan Legalisir:** 15+ permohonan legalisir dengan beragam status verifikasi dan jejak audit (*Audit Trail*).
- **Disposisi Kepala Sekolah:** 12+ lembar disposisi instruksi tindak lanjut pimpinan.

### Perintah Menjalankan Seeder Data Dummy:
```bash
# Menjalankan seeder kearsipan dummy saja:
php artisan db:seed --class=DummyArsipSeeder

# Atau menjalankan seeder lengkap seluruh sistem:
php artisan db:seed
```

### Kredensial Akun Default untuk Pengujian:
| Peran (*Role*) | Alamat Email | Kata Sandi | Deskripsi |
|---|---|---|---|
| **Admin / Petugas TU** | `petugas@smkn1subang.sch.id` | `password` | Pengelolaan arsip masuk/keluar, verifikasi legalisir, manajemen pengguna, cetak agenda |
| **Kepala Sekolah** | `kepsek@smkn1subang.sch.id` | `password` | Deden Suryanto, M.Pd. — Disposisi pimpinan, persetujuan surat keluar, pengesahan legalisir |
| **Alumni / Siswa (Default)** | `alumni@smkn1subang.sch.id` | `password` | Ridwan Kurniawan (NPM: D1A230009 / NISN: 0045892134) — Dashboard pemohon |
| **Alumni Dummy (Contoh)** | `ahmad.fauzi@alumni.smkn1subang.sch.id` | `password` | Ahmad Fauzi Rahman (NISN: 0051287901) |
| **Siswa Dummy (Contoh)** | `siti.nurhaliza@siswa.smkn1subang.sch.id` | `password` | Siti Nurhaliza Putri (NISN: 0061298450) |

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
