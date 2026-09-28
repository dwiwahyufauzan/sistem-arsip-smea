# 03. IMPLEMENTASI ALGORITMA KNUTH-MORRIS-PRATT (KMP)
**Sistem Informasi Pengelolaan Arsip SMKN 1 Subang**  
*Materi Inti Penelitian Skripsi: Pencocokan String pada Pencarian Data Arsip*

---

## 1. Landasan Teori Algoritma Knuth-Morris-Pratt (KMP)

Algoritma Knuth-Morris-Pratt (ditemukan oleh Donald Knuth, James H. Morris, dan Vaughan Pratt pada tahun 1977) merupakan salah satu algoritma pencocokan string (*string matching*) yang sangat efisien. 

### 1.1. Perbandingan Brute Force vs KMP
- **Brute Force (Naïve String Matching):**
  - Mencocokkan karakter satu per satu dari kiri ke kanan.
  - Jika terjadi ketidakcocokan (*mismatch*), pergeseran jendela (*pattern shift*) hanya maju 1 karakter ke kanan, dan perbandingan diulang kembali dari awal pola.
  - Kompleksitas waktu terburuk: $\mathcal{O}(m \times n)$, di mana $n$ adalah panjang teks dan $m$ adalah panjang pola (*pattern*).
- **Knuth-Morris-Pratt (KMP):**
  - Mengeliminasi langkah mundur (*backtracking*) pada indeks teks utama ketika terjadi ketidakcocokan.
  - Memanfaatkan informasi yang sudah dicocokkan sebelumnya melalui **Tabel Prefix** atau **LPS (Longest Proper Prefix which is also Suffix)**.
  - Ketika terjadi *mismatch* di karakter ke-$j$, algoritma langsung menggeser pola ke indeks `LPS[j - 1]` tanpa memeriksa ulang karakter teks yang sudah cocok.
  - Kompleksitas waktu total: $\mathcal{O}(n + m)$ (Linear Time Complexity).

---

## 2. Cara Kerja Pembentukan Tabel LPS (Longest Proper Prefix which is also Suffix)

Tabel LPS (sering disimbolkan $\pi$) berukuran sama dengan panjang pola ($m$). Setiap elemen `LPS[i]` menyimpan panjang prefix terpanjang dari substring `pattern[0...i]` yang juga merupakan suffix dari substring tersebut (dengan ketentuan prefix tidak boleh sama dengan seluruh substring).

### Contoh Simulasi Pembentukan Tabel LPS:
Misalkan kata kunci pencarian arsip: **`SUBANG`**
- Substring `"S"` $\rightarrow$ Prefix: `""`, Suffix: `""` $\rightarrow$ LPS = `0`
- Substring `"SU"` $\rightarrow$ LPS = `0`
- Substring `"SUB"` $\rightarrow$ LPS = `0`
- Substring `"SUBA"` $\rightarrow$ LPS = `0`
- Substring `"SUBAN"` $\rightarrow$ LPS = `0`
- Substring `"SUBANG"` $\rightarrow$ LPS = `0`

Misalkan kata kunci pengujian berpola simetris: **`ARSIP-AR`**
- `i = 0`: `"A"` $\rightarrow$ LPS[0] = `0`
- `i = 1`: `"AR"` $\rightarrow$ LPS[1] = `0`
- `i = 2`: `"ARS"` $\rightarrow$ LPS[2] = `0`
- `i = 3`: `"ARSI"` $\rightarrow$ LPS[3] = `0`
- `i = 4`: `"ARSIP"` $\rightarrow$ LPS[4] = `0`
- `i = 5`: `"ARSIP-"` $\rightarrow$ LPS[5] = `0`
- `i = 6`: `"ARSIP-A"` $\rightarrow$ cocok dengan prefix `"A"` $\rightarrow$ LPS[6] = `1`
- `i = 7`: `"ARSIP-AR"` $\rightarrow$ cocok dengan prefix `"AR"` $\rightarrow$ LPS[7] = `2`

---

## 3. Desain Arsitektur Service KMP di Laravel (`KmpSearchService.php`)

Sesuai standar clean architecture, algoritma KMP diisolasi ke dalam Service Layer di direktori `app/Services/KmpSearchService.php`:

```php
<?php

namespace App\Services;

class KmpSearchService
{
    /**
     * Menghitung Longest Proper Prefix which is also Suffix (LPS) Array
     *
     * @param string $pattern
     * @return array<int>
     */
    public function computeLpsArray(string $pattern): array
    {
        $m = strlen($pattern);
        $lps = array_fill(0, $m, 0);
        $len = 0; // panjang prefix cocok sebelumnya
        $i = 1;

        while ($i < $m) {
            if ($pattern[$i] === $pattern[$len]) {
                $len++;
                $lps[$i] = $len;
                $i++;
            } else {
                if ($len !== 0) {
                    $len = $lps[$len - 1];
                } else {
                    $lps[$i] = 0;
                    $i++;
                }
            }
        }

        return $lps;
    }

    /**
     * Melakukan pencarian substring dalam teks menggunakan Algoritma KMP
     * (Case-Insensitive untuk kemudahan pencarian dokumen arsip)
     *
     * @param string $pattern Pola kata kunci pencarian
     * @param string $text Teks sumber arsip (perihal / no surat / isi)
     * @return array<int> Indeks posisi kemunculan pattern
     */
    public function search(string $pattern, string $text): array
    {
        $matches = [];
        $patternLower = strtolower(trim($pattern));
        $textLower = strtolower($text);

        $m = strlen($patternLower);
        $n = strlen($textLower);

        if ($m === 0 || $n === 0 || $m > $n) {
            return $matches;
        }

        $lps = $this->computeLpsArray($patternLower);

        $i = 0; // indeks untuk teks
        $j = 0; // indeks untuk pola

        while ($i < $n) {
            if ($patternLower[$j] === $textLower[$i]) {
                $i++;
                $j++;
            }

            if ($j === $m) {
                // Pola ditemukan pada indeks ($i - $j)
                $matches[] = $i - $j;
                $j = $lps[$j - 1];
            } elseif ($i < $n && $patternLower[$j] !== $textLower[$i]) {
                if ($j !== 0) {
                    $j = $lps[$j - 1];
                } else {
                    $i++;
                }
            }
        }

        return $matches;
    }

    /**
     * Memfilter koleksi arsip berdasarkan pencocokan pola KMP pada beberapa field
     *
     * @param \Illuminate\Support\Collection $records
     * @param string $keyword
     * @param array $searchableFields
     * @return array
     */
    public function filterRecords($records, string $keyword, array $searchableFields): array
    {
        $startTime = microtime(true);
        $filtered = [];

        foreach ($records as $item) {
            $isMatched = false;
            $matchedFields = [];

            foreach ($searchableFields as $field) {
                $textValue = (string) ($item->{$field} ?? '');
                $occurrences = $this->search($keyword, $textValue);

                if (!empty($occurrences)) {
                    $isMatched = true;
                    $matchedFields[$field] = $occurrences;
                }
            }

            if ($isMatched) {
                $item->kmp_matched_fields = $matchedFields;
                $filtered[] = $item;
            }
        }

        $executionTimeMs = round((microtime(true) - $startTime) * 1000, 3);

        return [
            'results' => $filtered,
            'total_found' => count($filtered),
            'execution_time_ms' => $executionTimeMs,
            'pattern' => $keyword,
        ];
    }

    /**
     * Memberikan penandaan warna (highlight) HTML pada teks yang cocok
     */
    public function highlightMatches(string $text, string $keyword): string
    {
        if (empty(trim($keyword))) {
            return htmlspecialchars($text);
        }

        $pattern = '/' . preg_quote($keyword, '/') . '/i';
        return preg_replace($pattern, '<mark class="bg-amber-200 text-amber-900 font-semibold px-1 rounded">$0</mark>', htmlspecialchars($text));
    }
}
```

---

## 4. Modul Benchmarking KMP vs Brute Force (Untuk Keperluan Bab IV Skripsi)

Proposal skripsi menekankan bahwa algoritma KMP diuji efektivitas dan kecepatannya. Oleh karena itu, sistem akan dilengkapi dengan helper perbandingan kinerja (*benchmark*):

```php
/**
 * Komparasi Waktu Eksekusi KMP vs Brute Force
 */
public function compareWithBruteForce(string $keyword, string $text): array
{
    // 1. Eksekusi KMP
    $startKmp = microtime(true);
    $kmpMatches = $this->search($keyword, $text);
    $timeKmp = (microtime(true) - $startKmp) * 1000;

    // 2. Eksekusi Brute Force
    $startBf = microtime(true);
    $bfMatches = $this->bruteForceSearch($keyword, $text);
    $timeBf = (microtime(true) - $startBf) * 1000;

    return [
        'kmp' => [
            'time_ms' => round($timeKmp, 4),
            'matches_count' => count($kmpMatches),
        ],
        'brute_force' => [
            'time_ms' => round($timeBf, 4),
            'matches_count' => count($bfMatches),
        ],
        'speedup_percentage' => $timeBf > 0 ? round((($timeBf - $timeKmp) / $timeBf) * 100, 2) : 0,
    ];
}
```

Modul perbandingan ini dapat ditampilkan di halaman laporan/pengujian sistem pada dashboard Admin, sehingga mempermudah Ridwan Kurniawan dalam menyusun data tabel perbandingan Bab IV skripsi secara ilmiah dan akurat.
