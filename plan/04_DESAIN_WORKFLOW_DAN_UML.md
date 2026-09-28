# 04. DESAIN WORKFLOW DAN PEMODELAN UML
**Sistem Informasi Pengelolaan Arsip SMKN 1 Subang**  
*Pemodelan Sistem Menggunakan Unified Modeling Language (UML) & Standar RUP*

---

## 1. Use Case Diagram

Diagram Use Case menggambarkan interaksi antara ketiga aktor sistem dengan fungsionalitas utama yang disediakan aplikasi:

```mermaid
flowchart LR
    subgraph Aktor
        Admin((Admin / Petugas TU))
        Kepsek((Kepala Sekolah))
        Pemohon((Pemohon Legalisir))
    end

    subgraph "Sistem Informasi Arsip SMKN 1 Subang"
        UC_Auth[Autentikasi / Login]
        
        %% Modul Surat Masuk
        UC_SM1[Catat Surat Masuk]
        UC_SM2[Unggah Berkas Surat Masuk]
        UC_SM3[Lihat & Unduh Berkas Masuk]
        
        %% Modul Surat Keluar
        UC_SK1[Buat Draf Surat Keluar]
        UC_SK2[Unggah Berkas Surat Keluar]
        UC_SK3[Persetujuan / Approval Surat Keluar]
        
        %% Modul Legalisir
        UC_LEG1[Ajukan Permohonan Legalisir]
        UC_LEG2[Unggah Berkas Ijazah Asli]
        UC_LEG3[Verifikasi Berkas Legalisir]
        UC_LEG4[Persetujuan Pengesahan Legalisir]
        UC_LEG5[Perbarui Status Pengerjaan]
        UC_LEG6[Tracking Status Permohonan]
        
        %% Modul Pencarian
        UC_KMP[Pencarian Arsip Algoritma KMP]
        UC_LAP[Laporan & Rekapitulasi Arsip]
    end

    Admin --> UC_Auth
    Admin --> UC_SM1
    Admin --> UC_SM2
    Admin --> UC_SM3
    Admin --> UC_SK1
    Admin --> UC_SK2
    Admin --> UC_LEG3
    Admin --> UC_LEG5
    Admin --> UC_KMP
    Admin --> UC_LAP

    Kepsek --> UC_Auth
    Kepsek --> UC_SM3
    Kepsek --> UC_SK3
    Kepsek --> UC_LEG4
    Kepsek --> UC_KMP
    Kepsek --> UC_LAP

    Pemohon --> UC_LEG1
    Pemohon --> UC_LEG2
    Pemohon --> UC_LEG6
```

---

## 2. Activity Diagram Alur Utama Sistem

### 2.1. Activity Diagram: Pengelolaan dan Disposisi Surat Masuk
Alur pencatatan surat masuk oleh Petugas hingga dapat ditinjau oleh Kepala Sekolah:

```mermaid
sequenceDiagram
    autonumber
    actor Pengirim as Instansi Luar
    actor Petugas as Admin / Petugas TU
    participant System as Sistem Arsip (Web)
    actor Kepsek as Kepala Sekolah

    Pengirim->>Petugas: Menyerahkan dokumen surat fisik
    Petugas->>Petugas: Memindai (scan) dokumen menjadi PDF/JPG
    Petugas->>System: Akses Form Tambah Surat Masuk
    Petugas->>System: Input metadata (No Surat, Pengirim, Perihal, Tanggal) & Upload File
    System->>System: Validasi file & Simpan ke MySQL + Storage
    System-->>Petugas: Notifikasi: Surat Masuk berhasil diarsipkan
    Kepsek->>System: Akses Dashboard Pimpinan / Surat Masuk
    System-->>Kepsek: Tampilkan daftar surat masuk terbaru
    Kepsek->>System: Buka detail surat & preview PDF dokumen
    opt Memberikan Disposisi
        Kepsek->>System: Isi lembar disposisi & instruksi tindak lanjut
        System-->>Petugas: Disposisi tersimpan dan diteruskan ke staf terkait
    end
```

---

### 2.2. Activity Diagram: Pengajuan dan Persetujuan Surat Keluar
Alur pembuatan konsep surat keluar oleh Petugas hingga disetujui Kepala Sekolah:

```mermaid
sequenceDiagram
    autonumber
    actor Petugas as Admin / Petugas TU
    participant System as Sistem Arsip (Web)
    actor Kepsek as Kepala Sekolah

    Petugas->>System: Input draf Surat Keluar & Upload Berkas
    Petugas->>System: Klik "Ajukan Persetujuan ke Kepala Sekolah"
    System->>System: Ubah status menjadi "menunggu_persetujuan"
    System-->>Kepsek: Notifikasi antrean persetujuan baru di dashboard
    Kepsek->>System: Buka menu Persetujuan Surat Keluar
    Kepsek->>System: Tinjau berkas draf dan rincian perihal
    alt Surat Disetujui
        Kepsek->>System: Klik "Setujui Surat" (Status: "disetujui")
        System->>System: Catat timestamp persetujuan & nama Kepala Sekolah
        System-->>Petugas: Status surat berubah "Disetujui" (Siap diterbitkan & dicetak)
    else Surat Perlu Revisi / Ditolak
        Kepsek->>System: Klik "Tolak / Minta Revisi" & Masukkan Catatan
        System->>System: Ubah status menjadi "ditolak"
        System-->>Petugas: Surat ditolak dengan catatan perbaikan
    end
```

---

### 2.3. Activity Diagram: Alur Layanan Legalisir Online Pemohon
Alur end-to-end layanan legalisir ijazah/transkrip dari pengajuan hingga pengambilan:

```mermaid
stateDiagram-v2
    [*] --> MenungguVerifikasi : Pemohon mengajukan form & upload scan ijazah asli
    MenungguVerifikasi --> Ditolak : Berkas buram / tidak valid (Petugas beri catatan)
    MenungguVerifikasi --> Diverifikasi : Petugas memvalidasi keabsahan data buku induk
    Diverifikasi --> MenungguApprovalKepsek : Petugas meneruskan untuk pengesahan pimpinan
    MenungguApprovalKepsek --> DisetujuiKepsek : Kepala Sekolah memberikan persetujuan
    DisetujuiKepsek --> SedangDiproses : Petugas mencetak stempel & tanda tangan legalisir
    SedangDiproses --> SiapDiambil : Berkas fisik selesai diproses & tanggal ambil ditentukan
    SiapDiambil --> Selesai : Pemohon mengambil dokumen di loket TU SMKN 1 Subang
    Selesai --> [*]
    Ditolak --> [*]
```

---

### 2.4. Activity Diagram: Pencarian Arsip Berbasis Algoritma KMP
Alur pencocokan teks menggunakan algoritma Knuth-Morris-Pratt:

```mermaid
flowchart TD
    A([Pengguna Memasukkan Kata Kunci]) --> B[Kirim Permintaan ke Server]
    B --> C[Ambil Data Koleksi Arsip dari Database]
    C --> D[KmpSearchService: Hitung Tabel LPS Pattern]
    D --> E[Lakukan Iterasi String Matching KMP pada Kolom Target]
    E --> F{Apakah Pattern Cocok?}
    F -- Ya --> G[Simpan Posisi Indeks & Tandai Match]
    F -- Tidak --> H[Geser Pattern Berdasarkan Nilai LPS Tanpa Backtrack]
    G --> I[Gabungkan Seluruh Record yang Cocok]
    H --> J{Masih ada teks yang diperiksa?}
    J -- Ya --> E
    J -- Tidak --> I
    I --> K[Bungkus Hasil Pencarian + Highlighting + Catat Waktu ms]
    K --> L([Tampilkan Hasil ke Antarmuka Pengguna])
```

---

## 3. Perancangan Halaman Antarmuka (UI/UX Blueprint)

1. **Dashboard Utama (Petugas & Kepsek):**
   - KPI Cards: Total Surat Masuk (Bulan ini), Total Surat Keluar, Antrean Persetujuan Kepsek, Permohonan Legalisir Aktif.
   - Quick Search Bar KMP di bagian atas header untuk pencarian instan dari mana saja.
   - Tabel 5 aktivitas dokumen terkini dengan badge status warna Tailwind.
2. **Halaman Data Surat Masuk / Keluar:**
   - Filter berdasarkan rentang tanggal dan klasifikasi kategori.
   - Tombol "Tambah Surat", "Ekspor Excel/PDF", "Cetak Agenda".
   - Fitur Modal Quick View PDF yang menyematkan PDF viewer langsung di browser tanpa harus mengunduh file terlebih dahulu.
3. **Halaman Khusus Approval Kepala Sekolah:**
   - Panel antrean persetujuan dokumen berformat *split view*: sebelah kiri ringkasan data, sebelah kanan preview berkas draf surat/legalisir.
   - Tombol aksi jelas: Hijau (*Setujui*) dan Merah (*Tolak dengan Catatan*).
4. **Portal Pelacakan Legalisir (Public Tracking):**
   - Halaman bersih dan responsif tanpa mewajibkan login rumit bagi alumni.
   - Input nomor resi pengajuan (cth: `LEG-2026-0001`) langsung menampilkan stepper status visual (Proses Verifikasi $\rightarrow$ Persetujuan $\rightarrow$ Siap Diambil).
