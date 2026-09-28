# Tahap 03: Instalasi & Konfigurasi Frontend Tech Stack (Tailwind CSS & Vite)
**Status:** 🟢 Selesai  
**Tanggal Penyelesaian:** 28 September 2026

---

## 🎯 1. Deskripsi Tahapan
Menyiapkan arsitektur frontend menggunakan **Tailwind CSS** dan build tool **Vite**, mengonfigurasi palet warna resmi instansi SMKN 1 Subang (Navy Blue `#1E3A8A` dan Modern Teal `#0D9488`), serta memvalidasi pipeline kompilasi asset CSS dan JavaScript.

---

## 📋 2. Target & Indikator Keberhasilan (Deliverables)
- [x] Dependensi npm terpasang lengkap (`tailwindcss`, `@tailwindcss/vite`, `vite`, `laravel-vite-plugin`).
- [x] Konfigurasi `vite.config.js` dan `resources/css/app.css` terhubung optimal dengan template Blade.
- [x] Palet warna instansi (Primary Navy Blue & Accent Teal) terkonfigurasi pada `@theme`.
- [x] Perintah `npm run build` berhasil mengeksekusi kompilasi asset tanpa error (`✓ built in 728ms`).

---

## 💻 3. Langkah Teknis & Perintah Eksekusi
1. Instalasi dependensi npm:
   ```bash
   npm install
   ```
2. Konfigurasi `resources/css/app.css`:
   - `@import 'tailwindcss';`
   - Penambahan direktif `@source` untuk path template Blade.
   - Penambahan variabel theme token `--color-primary-*` dan `--color-accent-*`.
3. Kompilasi asset produksi:
   ```bash
   npm run build
   ```

---

## 🧪 4. Hasil Pengujian & Bukti Eksekusi
- **Status Build:** Sukses (`vite build` selesai dalam 728ms).
- **Hasil Manifest:**
  - `public/build/assets/app-*.css` (37.88 kB)
  - `public/build/assets/app-*.js`
  - Font web Instrument Sans ter-bundle otomatis di `public/build/assets/`.

---

## 📝 5. Riwayat Komit Git
- **Commit Message:** `feat(tahap-03): konfigurasi frontend tailwind css dan vite dengan tema warna resmi smkn 1 subang selesai`
- **Branch:** `main`
