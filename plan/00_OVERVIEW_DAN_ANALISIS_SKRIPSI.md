# 00. OVERVIEW DAN ANALISIS DOKUMEN SKRIPSI
**Judul Skripsi:** Pengembangan Sistem Informasi Pengelolaan Arsip dengan Penerapan Algoritma Knuth-Morris-Pratt (KMP) pada SMKN 1 Subang  
**Penyusun:** Ridwan Kurniawan (NPM: D1A230009)  
**Program Studi:** Sistem Informasi, Fakultas Ilmu Komputer, Universitas Subang  
**Objek Penelitian:** SMK Negeri 1 Subang (SMEA)  

---

## 1. Konteks dan Latar Belakang Masalah
Berdasarkan hasil observasi dan wawancara di SMKN 1 Subang yang diuraikan dalam proposal skripsi:
1. **Pencatatan Masih Manual / Semi-Digital Terpisah:** Pencatatan arsip surat masuk, surat keluar, dan permohonan legalisir masih menggunakan aplikasi perkantoran sederhana (Microsoft Word dan Microsoft Excel) secara terpisah.
2. **Dokumen Fisik Rawan Tercecer:** Dokumen fisik disimpan dalam lemari berkas / map arsip tanpa sistem pengindeksan digital terpusat, menyebabkan potensi kerusakan dan kehilangan dokumen berharga.
3. **Pencarian Dokumen Lambat dan Melelahkan:** Ketika jumlah arsip bertambah seiring berjalannya tahun ajaran, proses pencarian dokumen surat maupun riwayat legalisir membutuhkan waktu lama karena belum ada fitur pencarian kata kunci (*keyword search*) yang terstruktur dan optimal.
4. **Alur Legalisir Belum Terintegrasi:** Proses layanan legalisir ijazah/transkrip bagi alumni masih bergantung pada pencatatan manual di buku agenda, status pemrosesan dokumen tidak transparan, dan pemohon kesulitan memantau apakah dokumennya sudah selesai diproses atau disetujui Kepala Sekolah.
5. **Kebutuhan Otorisasi Digital Kepala Sekolah:** Kepala Sekolah memerlukan media untuk memantau arus surat masuk, meninjau rancangan surat keluar, dan memberikan persetujuan (approval) secara terintegrasi tanpa harus bergantung pada map disposisi fisik setiap saat.

---

## 2. Batasan Masalah (Scope System)
Sesuai batasan masalah dalam dokumen proposal skripsi:
1. Sistem yang dikembangkan berbasis **Web**.
2. Fokus pengelolaan arsip dibatasi pada **3 modul utama**:
   - **Surat Masuk:** Pencatatan metadata, penyimpanan/unggah berkas digital, verifikasi, dan pencarian dokumen.
   - **Surat Keluar:** Pencatatan draft/agenda, unggah berkas, alur persetujuan Kepala Sekolah, pengarsipan resmi, dan pencarian.
   - **Legalisir:** Pengajuan layanan legalisir oleh pemohon, unggah berkas persyaratan, pencatatan verifikasi petugas, persetujuan Kepala Sekolah, dan pemantauan status proses legalisir.
3. Fitur **pencarian arsip cerdas** menerapkan **Algoritma Knuth-Morris-Pratt (KMP)** untuk pencocokan string kata kunci pada arsip.
4. Sistem tidak mencakup seluruh administrasi Tata Usaha (seperti penggajian atau keuangan internal), melainkan fokus khusus pada ketiga kategori arsip tersebut.

---

## 3. Analisis Aktor dan Hak Akses (User Roles)

Sistem memiliki 3 (tiga) peran pengguna utama dengan wewenang yang tegas:

```
+---------------------------------------------------------------------------------+
|                                SISTEM ARSIP SMKN 1 SUBANG                       |
+--------------------------+------------------------------+-----------------------+
|    ADMIN / PETUGAS TU    |        KEPALA SEKOLAH        |   PEMOHON LEGALISIR   |
+--------------------------+------------------------------+-----------------------+
| - Kelola Surat Masuk     | - Monitoring Surat Masuk     | - Registrasi / Login  |
| - Kelola Surat Keluar    | - Monitoring Surat Keluar    | - Ajukan Legalisir    |
| - Kelola Layanan Legalisir| - Monitoring Legalisir       | - Upload Berkas Syarat|
| - Upload Berkas Arsip    | - Beri Persetujuan Surat     | - Cek Status Tracking |
| - Update Status Legalisir| - Beri Persetujuan Legalisir | - Lihat Info Layanan  |
| - Pencarian Arsip (KMP)  | - Pencarian Arsip (KMP)      |                       |
| - Download Berkas Arsip  | - Lihat Detail Arsip         |                       |
| - Kelola Master Data     |                              |                       |
+--------------------------+------------------------------+-----------------------+
```

---

## 4. Analisis Kebutuhan Fungsional (Software Requirements Specification)

### 4.1. Kebutuhan Fungsional Petugas (Admin)
| Kode | Kebutuhan Fungsional | Deskripsi Rinci dalam Sistem |
|---|---|---|
| **SRS-P01** | Login | Petugas dapat melakukan autentikasi ke dalam sistem menggunakan username/email dan password yang aman. |
| **SRS-P02** | Mengelola Surat Masuk | Petugas dapat menambah (*create*), melihat (*read*), mengubah (*update*), dan menghapus (*delete*) data surat masuk. |
| **SRS-P03** | Mengunggah Surat Masuk | Petugas dapat mengunggah dokumen digital (PDF/gambar scan) berkas surat masuk ke server penyimpanan. |
| **SRS-P04** | Mengelola Surat Keluar | Petugas dapat menambah, melihat, mengubah, dan menghapus data surat keluar resmi sekolah. |
| **SRS-P05** | Mengunggah Surat Keluar | Petugas dapat mengunggah draf atau salinan dokumen surat keluar ke dalam sistem. |
| **SRS-P06** | Mengelola Legalisir | Petugas dapat mencatat, memvalidasi berkas, dan memproses permohonan legalisir yang diajukan pemohon. |
| **SRS-P07** | Memperbarui Status Legalisir | Petugas dapat mengubah status tahapan legalisir (*Menunggu Verifikasi*, *Sedang Diproses*, *Menunggu Approval Kepsek*, *Selesai/Siap Diambil*, *Ditolak*). |
| **SRS-P08** | Mencari Arsip | Petugas dapat mencari arsip berdasarkan kata kunci perihal, nomor surat, pengirim, penerima, atau kategori. |
| **SRS-P09** | Pencarian dengan KMP | Sistem menerapkan algoritma Knuth-Morris-Pratt (KMP) pada proses pencocokan string kata kunci pencarian arsip. |
| **SRS-P10** | Melihat Detail Arsip | Petugas dapat melihat informasi lengkap mengenai arsip dan riwayat statusnya. |
| **SRS-P11** | Mengunduh Dokumen | Petugas dapat mengunduh berkas fisik digital yang tersimpan pada arsip surat dan legalisir. |

### 4.2. Kebutuhan Fungsional Kepala Sekolah
| Kode | Kebutuhan Fungsional | Deskripsi Rinci dalam Sistem |
|---|---|---|
| **SRS-KS01** | Login | Kepala Sekolah dapat melakukan autentikasi login ke dalam sistem. |
| **SRS-KS02** | Melihat Surat Masuk | Kepala Sekolah dapat memantau data rekapitulasi dan melihat berkas surat masuk yang telah dicatat petugas. |
| **SRS-KS03** | Melihat Surat Keluar | Kepala Sekolah dapat memantau arsip surat keluar dan meninjau draf dokumen surat yang diajukan. |
| **SRS-KS04** | Melihat Data Legalisir | Kepala Sekolah dapat melihat daftar permohonan legalisir serta riwayat status dokumen yang diajukan masyarakat/alumni. |
| **SRS-KS05** | Memberikan Persetujuan Surat | Kepala Sekolah dapat memberikan catatan disposisi/persetujuan (*Approved / Rejected*) pada surat keluar yang membutuhkan verifikasi pimpinan. |
| **SRS-KS06** | Memberikan Persetujuan Legalisir | Kepala Sekolah dapat memberikan persetujuan resmi terhadap berkas legalisir yang membutuhkan tanda tangan/pengesahan pimpinan. |
| **SRS-KS07** | Melihat Status Persetujuan | Kepala Sekolah dapat memantau riwayat seluruh berkas yang telah disetujui atau ditolak. |
| **SRS-KS08** | Mencari Arsip | Kepala Sekolah dapat mencari surat masuk, surat keluar, dan legalisir dengan cepat berbasis kata kunci (didukung algoritma KMP). |
| **SRS-KS09** | Melihat Detail Arsip | Kepala Sekolah dapat melihat lembar detail arsip, metadata, dan riwayat tindak lanjutnya. |
| **SRS-KS10** | Logout | Kepala Sekolah dapat mengakhiri sesi akses sistem dengan aman. |

### 4.3. Kebutuhan Fungsional Pemohon Legalisir (Alumni / Siswa)
| Kode | Kebutuhan Fungsional | Deskripsi Rinci dalam Sistem |
|---|---|---|
| **SRS-L01** | Mengajukan Legalisir | Pemohon dapat membuat pengajuan permohonan legalisir dokumen baru secara mandiri. |
| **SRS-L02** | Mengisi Data Pengajuan | Pemohon mengisikan data diri (nama, NIS/NISN, nomor HP/WhatsApp, tahun lulus), jenis dokumen yang dilegalisir (Ijazah/Transkrip), jumlah lembar, keperluan, serta mengunggah file berkas scan dokumen asli. |
| **SRS-L03** | Melihat Status Pengajuan | Pemohon dapat memantau perkembangan status verifikasi dokumen secara langsung (*tracking code* / dashboard akun pemohon). |
| **SRS-L04** | Melihat Informasi Legalisir | Pemohon dapat membaca informasi syarat, prosedur, jam operasional, dan alur pengambilan fisik dokumen legalisir di SMKN 1 Subang. |
| **SRS-L05** | Logout | Pemohon dapat keluar dari sesi permohonan legalisir. |

---

## 5. Analisis Kebutuhan Non-Fungsional (Non-Functional Requirements)

| Kode | Aspek | Kebutuhan Non-Fungsional | Kriteria Keberhasilan / Implementasi |
|---|---|---|---|
| **NFR-01** | Keamanan | Autentikasi Pengguna | Enkripsi kata sandi menggunakan algoritma *Bcrypt* / Argon2id, pencegahan *session hijacking*, dan perlindungan CSRF token di setiap formulir. |
| **NFR-02** | Keamanan | Hak Akses Pengguna (RBAC) | Penerapan middleware otorisasi ketat di Laravel sehingga rute Petugas, Kepala Sekolah, dan Pemohon terisolasi sesuai hak akses. |
| **NFR-03** | Keamanan | Perlindungan Data Dokumen | Validasi ekstensi file yang diunggah (hanya PDF, JPG, PNG), pembatasan ukuran maksimal (maks 5MB), dan penyimpanan dokumen di direktori terlindung. |
| **NFR-04** | Kemudahan Penggunaan | Antarmuka Sederhana & Bersih | Desain UI modern menggunakan Tailwind CSS dengan layout responsif, warna yang harmonis, dan tipografi yang jelas (Inter/Plus Jakarta Sans). |
| **NFR-05** | Kemudahan Penggunaan | Navigasi Intuitif | Menu navigasi vertikal/horizontal yang jelas, breadcrumbs, tombol aksi yang mencolok, dan pesan notifikasi (*toast/alert*) interaktif. |
| **NFR-06** | Kinerja | Waktu Respons Cepat | Waktu respons muat halaman utama dan manipulasi CRUD di bawah 1,5 detik pada jaringan lokal sekolah. |
| **NFR-07** | Kinerja | Pencarian Arsip KMP Cepat | Algoritma KMP mampu mencocokkan substring kata kunci pada ribuan baris teks arsip secara presisi tanpa lag, dengan indikator waktu komputasi (benchmark millisecond). |
| **NFR-08** | Keandalan | Ketersediaan Data | Data arsip tersimpan dalam database relasional MySQL dengan integritas referensial (foreign keys) dan storage terstruktur. |
| **NFR-09** | Keandalan | Konsistensi Data | Seluruh transaksi perubahan status surat dan legalisir terikat dalam transaksi database (*DB Transaction*) untuk mencegah *partial update*. |
| **NFR-10** | Kompatibilitas | Web Browser Modern | Kompatibel penuh dan tampil optimal pada Google Chrome, Mozilla Firefox, Microsoft Edge, serta browser seluler. |
| **NFR-11** | Pemeliharaan | Struktur Sistem Modular | Mematuhi pola desain MVC (Model-View-Controller) Laravel dengan pemisahan logika pencarian ke dalam Service Layer (`KmpSearchService`). |
| **NFR-12** | Backup | Kemudahan Pencadangan Data | Penyediaan utilitas ekspor data laporan (PDF / Excel) serta kemudahan backup database MySQL melalui dump berkala. |

---

## 6. Analisis Alur Sistem Berjalan (As-Is) vs Sistem Usulan (To-Be)

### 6.1. Alur Sistem Berjalan (As-Is)
1. **Surat Masuk Berjalan:** Surat diterima resepsionis/satpam $\rightarrow$ diserahkan ke TU $\rightarrow$ TU mencatat manual di buku agenda / file Excel $\rightarrow$ surat fisik difotokopi dan dimasukkan ke map $\rightarrow$ saat pimpinan membutuhkan, staf membongkar tumpukan map fisik secara manual.
2. **Surat Keluar Berjalan:** Konsep surat diketik di Word $\rightarrow$ dicetak di kertas $\rightarrow$ dibawa manual ke ruangan Kepala Sekolah $\rightarrow$ jika ada koreksi dicetak ulang $\rightarrow$ ditandatangani manual $\rightarrow$ dicatat nomor surat di buku agenda $\rightarrow$ surat difotokopi untuk arsip fisik.
3. **Legalisir Berjalan:** Alumni datang langsung ke sekolah $\rightarrow$ mengisi buku tamu $\rightarrow$ menyerahkan fotokopi ijazah $\rightarrow$ menunggu pencarian buku induk nilai / arsip kelulusan $\rightarrow$ berkas ditumpuk menunggu tanda tangan Kepala Sekolah $\rightarrow$ alumni harus bolak-balik menanyakan apakah berkas sudah selesai atau belum.

### 6.2. Alur Sistem Usulan (To-Be)
1. **Surat Masuk Digital:** Surat masuk langsung didigitalkan (scan) $\rightarrow$ diinput ke sistem dengan nomor agenda otomatis $\rightarrow$ file tersimpan di storage server $\rightarrow$ Kepala Sekolah menerima notifikasi pada dashboard dan dapat membaca isi surat kapan pun secara online.
2. **Surat Keluar Terotomatisasi:** Draf surat keluar dibuat dan diunggah ke sistem $\rightarrow$ Kepala Sekolah mereview dokumen via web dan memberikan persetujuan $\rightarrow$ nomor surat dikeluarkan secara otomatis $\rightarrow$ surat siap dicetak/didistribusikan $\rightarrow$ otomatis terarsipkan permanen.
3. **Layanan Legalisir Online:** Pemohon mengajukan permohonan legalisir melalui portal web SMKN 1 Subang $\rightarrow$ mengunggah dokumen $\rightarrow$ petugas TU memverifikasi kelengkapan berkas di sistem $\rightarrow$ Kepala Sekolah memberikan persetujuan $\rightarrow$ pemohon mendapat update status real-time melalui tracking code dan hanya datang saat berkas legalisir fisik siap diambil (atau mengunduh versi legalisir digital).
4. **Pencarian Cerdas KMP:** Petugas dan Kepala Sekolah dapat mengetikkan potongan perihal/nomor/nama pengirim pada search bar global $\rightarrow$ Algoritma KMP memproses pencarian teks dengan kompleksitas $O(n + m)$ $\rightarrow$ hasil keluar secara instan dengan penandaan (highlight) kata yang cocok.
