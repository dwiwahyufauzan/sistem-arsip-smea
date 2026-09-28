# Tahap 10: Pembangunan Core Engine Algoritma Knuth-Morris-Pratt (KMP)
**Status:** 🟢 Selesai  
**Tanggal Penyelesaian:** 28 September 2026

---

## 🎯 1. Deskripsi Tahapan
Membangun *core engine* pencocokan string (*string matching*) Algoritma Knuth-Morris-Pratt (KMP) sebagai materi inti penelitian skripsi kearsipan SMKN 1 Subang. Engine ini diisolasi dalam Service Layer (`app/Services/KmpSearchService.php`) dengan fungsi komputasi tabel *Longest Proper Prefix which is also Suffix* (LPS), pencarian substring berkecepatan linear $\mathcal{O}(n + m)$, penyaringan koleksi multi-kolom arsip, penanda teks (*highlighting*), serta modul tolok ukur komparasi ilmiah (*benchmarking*) terhadap Algoritma *Brute Force* $\mathcal{O}(n \times m)$ untuk kebutuhan Bab IV Skripsi.

---

## 📋 2. Target & Indikator Keberhasilan (Deliverables)
- [x] **Service Class `app/Services/KmpSearchService.php`:**
  - `computeLpsArray(string $pattern): array`: Perhitungan matematis tabel prefix/suffix $\pi$ tanpa *backtracking*.
  - `search(string $pattern, string $text, bool $caseSensitive = false): array`: Algoritma pencarian substring KMP mengembalikan seluruh indeks kecocokan.
  - `contains(string $pattern, string $text): bool` & `searchFirst(...)`: Helper pengecekan eksistensi string.
  - `bruteForceSearch(string $pattern, string $text): array`: Algoritma pembanding Naïve/Brute Force.
  - `compareWithBruteForce(string $pattern, string $text, int $iterations): array`: Perhitungan waktu eksekusi (milidetik), jumlah kecocokan, dan persentase efisiensi (*speedup percentage*).
  - `filterCollection(iterable $records, string $keyword, array $searchableFields): array`: Penyaringan multi-kolom data arsip (nomor surat, perihal, pengirim, isi ringkas) dengan metadata kecocokan.
  - `highlightMatches(string $text, string $keyword): string`: Penandaan HTML `<mark>` pada kata kunci hasil pencarian.
- [x] **Unit Test Suite `tests/Unit/KmpAlgorithmTest.php`:**
  - 8 metode pengujian komputasi matematis LPS, akurasi indeks pencocokan, case-insensitivity, kondisi batas, kesesuaian hasil KMP vs Brute Force, benchmark, dan filter koleksi.
- [x] **Seluruh Test Lulus 100% (26 tests, 86 assertions).**
- [x] **Pembersihan dan Standarisasi Kode menggunakan Laravel Pint.**

---

## 💻 3. Langkah Teknis & Perintah Eksekusi
1. Pembuatan berkas Service:
   - `app/Services/KmpSearchService.php`
2. Pembuatan berkas Unit Test:
   - `tests/Unit/KmpAlgorithmTest.php`
3. Eksekusi pengujian otomatis:
   ```bash
   php artisan test --filter=KmpAlgorithmTest
   ```
4. Format standarisasi kode:
   ```bash
   vendor/bin/pint --format agent
   ```

---

## 🧪 4. Hasil Pengujian & Bukti Eksekusi

```text
 PASS  Tests\Unit\KmpAlgorithmTest
✓ compute lps array returns correct mathematical values ....................... 0.01s
✓ kmp search finds single and multiple occurrences ............................ 0.01s
✓ kmp search is case insensitive by default ................................... 0.01s
✓ kmp returns empty when no match or pattern longer ........................... 0.01s
✓ brute force search matches kmp results ...................................... 0.01s
✓ compare with brute force benchmark generates valid metrics .................. 0.01s
✓ filter collection multi fields .............................................. 0.01s
✓ highlight matches wraps term in mark tag .................................... 0.01s

Total Uji Keseluruhan Proyek:
Tests:    26 passed (86 assertions)
Duration: 0.86s
```

---

## 📝 5. Riwayat Komit Git
- **Commit Message:** `feat(tahap-10): pembangunan core engine algoritma knuth-morris-pratt kmp tabel lps dan benchmark komparasi brute force`
- **Branch:** `main`
