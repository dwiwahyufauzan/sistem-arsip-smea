<?php

namespace App\Services;

class KmpSearchService
{
    /**
     * Menghitung Longest Proper Prefix which is also Suffix (LPS) Array
     *
     * Tabel LPS berfungsi sebagai tabel lompatan (shift table) pada algoritma KMP,
     * yang menentukan ke indeks mana pola harus digeser saat terjadi mismatch
     * tanpa memundurkan penunjuk indeks teks utama (tanpa backtracking).
     *
     * @param  string  $pattern  Pola kata kunci pencarian
     * @return array<int> Tabel nilai LPS
     */
    public function computeLpsArray(string $pattern): array
    {
        $m = strlen($pattern);
        if ($m === 0) {
            return [];
        }

        $lps = array_fill(0, $m, 0);
        $len = 0; // Panjang prefix terpanjang yang cocok sebelumnya
        $i = 1;

        while ($i < $m) {
            if ($pattern[$i] === $pattern[$len]) {
                $len++;
                $lps[$i] = $len;
                $i++;
            } else {
                if ($len !== 0) {
                    // Coba prefix yang lebih pendek berdasarkan tabel LPS sebelumnya
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
     * Melakukan pencocokan string teks menggunakan Algoritma Knuth-Morris-Pratt (KMP)
     * Kompleksitas Waktu: O(n + m) linear
     *
     * @param  string  $pattern  Kata kunci pencarian (Pola)
     * @param  string  $text  Teks sumber (Nomor Surat, Perihal, Ringkasan, dll.)
     * @param  bool  $caseSensitive  Apakah sensitif huruf besar/kecil (default: false)
     * @return array<int> Daftar indeks awal kemunculan pola pada teks (0-indexed)
     */
    public function search(string $pattern, string $text, bool $caseSensitive = false): array
    {
        $matches = [];
        $patternTrim = trim($pattern);

        if ($patternTrim === '' || $text === '') {
            return $matches;
        }

        $p = $caseSensitive ? $patternTrim : mb_strtolower($patternTrim, 'UTF-8');
        $t = $caseSensitive ? $text : mb_strtolower($text, 'UTF-8');

        $m = strlen($p);
        $n = strlen($t);

        if ($m > $n) {
            return $matches;
        }

        $lps = $this->computeLpsArray($p);

        $i = 0; // Indeks penunjuk teks utama
        $j = 0; // Indeks penunjuk pola (pattern)

        while ($i < $n) {
            if ($p[$j] === $t[$i]) {
                $i++;
                $j++;
            }

            if ($j === $m) {
                // Pola ditemukan penuh pada indeks ($i - $j)
                $matches[] = $i - $j;
                $j = $lps[$j - 1]; // Geser pola sesuai tabel LPS
            } elseif ($i < $n && $p[$j] !== $t[$i]) {
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
     * Memeriksa apakah suatu teks mengandung pola tertentu menggunakan KMP
     */
    public function contains(string $pattern, string $text, bool $caseSensitive = false): bool
    {
        $matches = $this->search($pattern, $text, $caseSensitive);

        return ! empty($matches);
    }

    /**
     * Mengembalikan indeks pertama kemunculan pola atau null jika tidak ada
     */
    public function searchFirst(string $pattern, string $text, bool $caseSensitive = false): ?int
    {
        $matches = $this->search($pattern, $text, $caseSensitive);

        return ! empty($matches) ? $matches[0] : null;
    }

    /**
     * Algoritma Pencarian Naïve / Brute Force O(n x m)
     * Dibuat sebagai modul komparasi tolok ukur (benchmark) untuk Bab IV Skripsi
     *
     * @return array<int>
     */
    public function bruteForceSearch(string $pattern, string $text, bool $caseSensitive = false): array
    {
        $matches = [];
        $patternTrim = trim($pattern);

        if ($patternTrim === '' || $text === '') {
            return $matches;
        }

        $p = $caseSensitive ? $patternTrim : mb_strtolower($patternTrim, 'UTF-8');
        $t = $caseSensitive ? $text : mb_strtolower($text, 'UTF-8');

        $m = strlen($p);
        $n = strlen($t);

        if ($m > $n) {
            return $matches;
        }

        for ($i = 0; $i <= $n - $m; $i++) {
            $j = 0;
            while ($j < $m && $t[$i + $j] === $p[$j]) {
                $j++;
            }

            if ($j === $m) {
                $matches[] = $i;
            }
        }

        return $matches;
    }

    /**
     * Komparasi ilmiah performa komputasi KMP vs Brute Force
     * Menghasilkan data kuantitatif waktu eksekusi (milidetik) dan persentase efisiensi
     *
     * @param  int  $iterations  Jumlah iterasi untuk stabilitas pengukuran (default: 50)
     * @return array<string, mixed>
     */
    public function compareWithBruteForce(string $pattern, string $text, int $iterations = 50): array
    {
        $iterations = max(1, $iterations);

        // 1. Eksekusi Pengujian KMP
        $startKmp = microtime(true);
        $kmpMatches = [];
        for ($k = 0; $k < $iterations; $k++) {
            $kmpMatches = $this->search($pattern, $text);
        }
        $totalTimeKmp = (microtime(true) - $startKmp) * 1000;
        $avgTimeKmp = $totalTimeKmp / $iterations;

        // 2. Eksekusi Pengujian Brute Force
        $startBf = microtime(true);
        $bfMatches = [];
        for ($k = 0; $k < $iterations; $k++) {
            $bfMatches = $this->bruteForceSearch($pattern, $text);
        }
        $totalTimeBf = (microtime(true) - $startBf) * 1000;
        $avgTimeBf = $totalTimeBf / $iterations;

        // 3. Hitung Persentase Peningkatan Efisiensi
        $speedupPercentage = $avgTimeBf > 0
            ? round((($avgTimeBf - $avgTimeKmp) / $avgTimeBf) * 100, 2)
            : 0;

        return [
            'pattern' => $pattern,
            'pattern_length' => strlen(trim($pattern)),
            'text_length' => strlen($text),
            'iterations' => $iterations,
            'lps_table' => $this->computeLpsArray(mb_strtolower(trim($pattern), 'UTF-8')),
            'kmp' => [
                'total_time_ms' => round($totalTimeKmp, 4),
                'avg_time_ms' => round($avgTimeKmp, 6),
                'matches_count' => count($kmpMatches),
                'matches_indices' => $kmpMatches,
                'complexity' => 'O(n + m)',
            ],
            'brute_force' => [
                'total_time_ms' => round($totalTimeBf, 4),
                'avg_time_ms' => round($avgTimeBf, 6),
                'matches_count' => count($bfMatches),
                'matches_indices' => $bfMatches,
                'complexity' => 'O(n * m)',
            ],
            'speedup_percentage' => $speedupPercentage,
            'is_kmp_faster' => $avgTimeKmp <= $avgTimeBf,
        ];
    }

    /**
     * Memfilter koleksi record (Eloquent atau Array) menggunakan algoritma KMP pada multi-kolom
     *
     * @param  array<string>  $searchableFields
     * @return array<string, mixed>
     */
    public function filterCollection(iterable $records, string $keyword, array $searchableFields): array
    {
        $startTime = microtime(true);
        $filtered = [];
        $trimmedKeyword = trim($keyword);

        if ($trimmedKeyword === '') {
            return [
                'results' => is_array($records) ? $records : iterator_to_array($records),
                'total_found' => is_countable($records) ? count($records) : 0,
                'execution_time_ms' => 0.0,
                'keyword' => '',
            ];
        }

        foreach ($records as $item) {
            $isMatched = false;
            $matchedFields = [];

            foreach ($searchableFields as $field) {
                $fieldValue = is_object($item) ? ($item->{$field} ?? '') : ($item[$field] ?? '');
                $textValue = (string) $fieldValue;

                $occurrences = $this->search($trimmedKeyword, $textValue);
                if (! empty($occurrences)) {
                    $isMatched = true;
                    $matchedFields[$field] = [
                        'occurrences_count' => count($occurrences),
                        'positions' => $occurrences,
                        'highlighted' => $this->highlightMatches($textValue, $trimmedKeyword),
                    ];
                }
            }

            if ($isMatched) {
                if (is_object($item)) {
                    $item->kmp_match_info = $matchedFields;
                }
                $filtered[] = $item;
            }
        }

        $executionTimeMs = round((microtime(true) - $startTime) * 1000, 3);

        return [
            'results' => $filtered,
            'total_found' => count($filtered),
            'execution_time_ms' => $executionTimeMs,
            'keyword' => $trimmedKeyword,
        ];
    }

    /**
     * Memberikan penandaan warna (highlight) HTML pada teks yang cocok
     */
    public function highlightMatches(string $text, string $keyword, string $class = 'bg-amber-200 text-amber-950 font-bold px-1 rounded shadow-xs'): string
    {
        $trimmed = trim($keyword);
        if ($trimmed === '') {
            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        }

        $escaped = preg_quote($trimmed, '/');
        $safeText = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        return (string) preg_replace(
            "/($escaped)/i",
            '<mark class="'.htmlspecialchars($class, ENT_QUOTES, 'UTF-8').'">$1</mark>',
            $safeText
        );
    }
}
