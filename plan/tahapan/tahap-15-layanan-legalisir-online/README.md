# Tahap 15: Implementasi Modul Layanan Legalisir Online (SRS-L01..05, SRS-P06..07, SRS-KS04..06)
**Status:** 🟢 Selesai

---

## 🎯 1. Deskripsi Tahapan
Tahap 15 merealisasikan seluruh alur layanan permohonan legalisir dokumen resmi (Ijazah, Transkrip Nilai, Rapor, Sertifikat Keahlian) secara daring bagi alumni/pemohon, verifikasi kesesuaian berkas terhadap buku induk kearsipan oleh petugas Tata Usaha, otorisasi pengesahan oleh Kepala Sekolah, pencetakan & pembubuhan stempel legalisir basah, hingga penyerahan fisik di loket SMKN 1 Subang sebagaimana diamanatkan dalam proposal skripsi.

---

## 📋 2. Target & Indikator Keberhasilan (Deliverables)
- [x] Formulir online pengajuan legalisir (`/legalisir/buat`) dengan validasi ukuran berkas maksimal 5 MB (PDF/JPG/PNG).
- [x] Generator otomatis nomor resi pelacakan dengan pola unik `LEG-YYYYMM-XXXX` (contoh: `LEG-202609-0001`).
- [x] Halaman sukses penerbitan resi (`/legalisir/sukses/{nomor_pengajuan}`) dengan fitur salin resi dan tombol unduh/cetak.
- [x] Halaman pelacakan langsung (*Live Tracking Stepper*) 6 tahapan (`/legalisir/tracking`) berbasis nomor resi maupun NISN.
- [x] Lembar bukti tanda terima pendaftaran resmi siap cetak (`/legalisir/tanda-terima/{nomor_pengajuan}`) ber-kop surat resmi SMKN 1 Subang.
- [x] Antrean pengelolaan legalisir petugas Tata Usaha (`/admin/legalisir`) dilengkapi 6 kartu metrik dan filter status.
- [x] Lembar verifikasi petugas TU (`/admin/legalisir/{id}`) untuk pencocokan buku induk, draf verifikasi, ajukan ke Kepsek, proses cetak stempel, kesiapan ambil di loket, dan penolakan berkas dengan catatan.
- [x] Panel otorisasi dan monitoring Kepala Sekolah (`/kepala-sekolah/legalisir`) untuk peninjauan berkas pindaian, persetujuan pengesahan (*approve*), dan penolakan (*reject*).
- [x] Portal alumni mandiri (`/pemohon/permohonan-saya` dan `/pemohon/dashboard`) untuk melacak seluruh permohonan yang pernah diajukan.
- [x] Jejak audit otomatis pada tabel `riwayat_legalisir` dan `log_aktivitas`.
- [x] Seluruh rangkaian pengujian fitur (`LegalisirTest`) lulus 100% (15 skenario, 76 asersi) dan pengujian menyeluruh sistem (102 tes, 432 asersi).

---

## 💻 3. Arsitektur Komponen & Alur Data

### 3.1. Siklus Hidup Status Permohonan Legalisir
```
[Pemohon Daring]
       │ Unggah Berkas & Resi Diterbitkan
       ▼
1. menunggu_verifikasi
       │
       ▼
2. diverifikasi / menunggu_approval_kepsek ─── (Tolak TU) ───► ditolak
       │
       ▼
3. disetujui_kepsek ────────────────────────── (Tolak Kepsek) ─► ditolak
       │
       ▼
4. sedang_diproses (Cetak & Cap Stempel Basah TU)
       │
       ▼
5. siap_diambil (Jadwal Pengambilan di Loket SMEA)
       │
       ▼
6. selesai (Penyerahan Fisik Berkas ke Alumni)
```

### 3.2. Berkas & Pengendali yang Dibuat
1. **Controller**:
   - `app/Http/Controllers/PengajuanLegalisirController.php`: Formulir publik, unggah berkas, generator resi, tracking live stepper, cetak tanda terima, dan portal pemohon.
   - `app/Http/Controllers/LegalisirAdminController.php`: Verifikasi buku induk TU, penandaan cetak, penetapan tanggal siap ambil, penyerahan selesai, dan penolakan berkas.
   - `app/Http/Controllers/LegalisirKepsekController.php`: Antrean otorisasi pengesahan dan penolakan pimpinan.
2. **Views**:
   - `resources/views/legalisir/create.blade.php`: Formulir pengajuan legalisir publik interaktif.
   - `resources/views/legalisir/sukses.blade.php`: Halaman konfirmasi resi pendaftaran.
   - `resources/views/legalisir/tracking.blade.php`: Live tracker pelacakan mandiri.
   - `resources/views/legalisir/tanda-terima.blade.php`: Bukti tanda terima resmi SMKN 1 Subang format cetak.
   - `resources/views/admin/legalisir/index.blade.php`: Daftar antrean verifikasi petugas TU.
   - `resources/views/admin/legalisir/show.blade.php`: Lembar kerja verifikasi berkas dan aksi transisi status TU.
   - `resources/views/kepsek/legalisir/index.blade.php`: Antrean monitoring & pengesahan Kepsek.
   - `resources/views/kepsek/legalisir/show.blade.php`: Lembar otorisasi dan tinjauan pimpinan.
   - `resources/views/pemohon/legalisir/index.blade.php`: Riwayat permohonan akun alumni.
   - `resources/views/pemohon/legalisir/show.blade.php`: Detail pelacakan pada portal pemohon.

---

## 🧪 4. Hasil Pengujian & Bukti Eksekusi

### 4.1. Hasil Pengujian Unit & Fitur Legalisir
```bash
php artisan test --filter=LegalisirTest --compact
```
**Output:**
```json
{"tool":"phpunit","result":"passed","tests":15,"passed":15,"assertions":76,"duration_ms":2800}
```

### 4.2. Hasil Pengujian Seluruh Fitur Proyek
```bash
php artisan test --compact
```
**Output:**
```json
{"tool":"phpunit","result":"passed","tests":102,"passed":102,"assertions":432,"duration_ms":10098}
```

### 4.3. Kompilasi Aset Frontend (Vite)
```bash
npm run build
```
Status: Berhasil dikompilasi dalam 2.25s tanpa kesalahan.

---

## 📝 5. Riwayat Komit Git
- **Status Komit:** Siap Dikomit
- **Pesan Komit:** `feat(tahap-15): implementasi modul layanan legalisir online verifikasi tu dan otorisasi kepsek`
