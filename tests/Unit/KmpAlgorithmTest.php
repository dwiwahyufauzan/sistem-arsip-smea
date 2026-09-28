<?php

namespace Tests\Unit;

use App\Services\KmpSearchService;
use PHPUnit\Framework\TestCase;

class KmpAlgorithmTest extends TestCase
{
    protected KmpSearchService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new KmpSearchService;
    }

    /**
     * Uji matematis komputasi tabel Longest Proper Prefix which is also Suffix (LPS)
     */
    public function test_compute_lps_array_returns_correct_mathematical_values(): void
    {
        // Kasus 1: Pola standar buku teks ilmu komputer "AABAACAABAA"
        // A -> 0, AA -> 1, AAB -> 0, AABA -> 1, AABAA -> 2, AABAAC -> 0, AABAACA -> 1, AABAACAA -> 2, AABAACAAB -> 3, AABAACAABA -> 4, AABAACAABAA -> 5
        $lps1 = $this->service->computeLpsArray('AABAACAABAA');
        $this->assertSame([0, 1, 0, 1, 2, 0, 1, 2, 3, 4, 5], $lps1);

        // Kasus 2: Kata "SUBANG" tanpa perulangan prefix/suffix
        $lps2 = $this->service->computeLpsArray('SUBANG');
        $this->assertSame([0, 0, 0, 0, 0, 0], $lps2);

        // Kasus 3: Kata dengan perulangan sebagian "ABCDAB"
        $lps3 = $this->service->computeLpsArray('ABCDAB');
        $this->assertSame([0, 0, 0, 0, 1, 2], $lps3);

        // Kasus 4: String kosong
        $lps4 = $this->service->computeLpsArray('');
        $this->assertSame([], $lps4);
    }

    /**
     * Uji pencarian pola tunggal dan multipel kemunculan
     */
    public function test_kmp_search_finds_single_and_multiple_occurrences(): void
    {
        $text = 'SMK Negeri 1 Subang adalah sekolah kejuruan pusat keunggulan di Subang';
        $pattern = 'Subang';

        $matches = $this->service->search($pattern, $text);

        // "Subang" muncul di indeks 13 dan 64
        $this->assertCount(2, $matches);
        $this->assertSame(13, $matches[0]);
        $this->assertSame(64, $matches[1]);
    }

    /**
     * Uji pencarian bersifat case-insensitive secara default
     */
    public function test_kmp_search_is_case_insensitive_by_default(): void
    {
        $text = 'Pelaksanaan Uji Kompetensi Keahlian (UKK) Tahun Ajaran 2026/2027';

        $matchesLower = $this->service->search('ukk', $text);
        $matchesUpper = $this->service->search('UKK', $text);

        $this->assertNotEmpty($matchesLower);
        $this->assertSame($matchesUpper, $matchesLower);
    }

    /**
     * Uji penanganan kondisi batas (pola tidak ditemukan, pola lebih panjang)
     */
    public function test_kmp_returns_empty_when_no_match_or_pattern_longer(): void
    {
        $text = 'Surat Dinas Kurikulum';

        // Tidak ditemukan
        $this->assertSame([], $this->service->search('Keuangan', $text));

        // Pola lebih panjang dari teks
        $this->assertSame([], $this->service->search('Surat Dinas Kurikulum Merdeka Sekolah Kejuruan', $text));

        // Teks kosong
        $this->assertSame([], $this->service->search('Surat', ''));

        // Pola kosong
        $this->assertSame([], $this->service->search('', $text));
    }

    /**
     * Uji validitas perbandingan: KMP dan Brute Force harus menghasilkan indeks kecocokan yang identik
     */
    public function test_brute_force_search_matches_kmp_results(): void
    {
        $text = 'Pemberitahuan verifikasi nomor agenda surat masuk dan surat keluar pada sistem kearsipan smkn 1 subang';
        $pattern = 'surat';

        $kmpMatches = $this->service->search($pattern, $text);
        $bfMatches = $this->service->bruteForceSearch($pattern, $text);

        $this->assertSame($kmpMatches, $bfMatches);
        $this->assertCount(2, $kmpMatches);
    }

    /**
     * Uji modul benchmarking komparasi KMP vs Brute Force untuk data Bab IV Skripsi
     */
    public function test_compare_with_brute_force_benchmark_generates_valid_metrics(): void
    {
        $text = 'SMK Negeri 1 Subang menyelenggarakan uji kompetensi keahlian bersama dinas pendidikan wilayah IV Jawa Barat tahun 2026';
        $pattern = 'kompetensi';

        $benchmark = $this->service->compareWithBruteForce($pattern, $text, 30);

        $this->assertArrayHasKey('kmp', $benchmark);
        $this->assertArrayHasKey('brute_force', $benchmark);
        $this->assertArrayHasKey('speedup_percentage', $benchmark);
        $this->assertArrayHasKey('lps_table', $benchmark);
        $this->assertSame(1, $benchmark['kmp']['matches_count']);
        $this->assertSame(1, $benchmark['brute_force']['matches_count']);
        $this->assertSame('O(n + m)', $benchmark['kmp']['complexity']);
        $this->assertSame('O(n * m)', $benchmark['brute_force']['complexity']);
    }

    /**
     * Uji penyaringan multi-kolom data koleksi arsip
     */
    public function test_filter_collection_multi_fields(): void
    {
        $records = [
            (object) [
                'id' => 1,
                'nomor_surat' => '005/1420/Cadisdik.Wil.IV/2026',
                'perihal' => 'Undangan Rapat Koordinasi UKK',
                'pengirim' => 'Cabang Dinas Pendidikan Wilayah IV',
            ],
            (object) [
                'id' => 2,
                'nomor_surat' => 'B/412/PINDAD/IX/2026',
                'perihal' => 'Konfirmasi Siswa PKL',
                'pengirim' => 'PT. Pindad Persero',
            ],
            (object) [
                'id' => 3,
                'nomor_surat' => '1829/A.A1/PR/2026',
                'perihal' => 'Bantuan Hibah Revitalisasi Lab',
                'pengirim' => 'Kemdikbudristek',
            ],
        ];

        // Cari dengan kata kunci "Pindad"
        $filterResult = $this->service->filterCollection($records, 'Pindad', ['nomor_surat', 'perihal', 'pengirim']);

        $this->assertSame(1, $filterResult['total_found']);
        $this->assertSame('B/412/PINDAD/IX/2026', $filterResult['results'][0]->nomor_surat);
        $this->assertArrayHasKey('pengirim', $filterResult['results'][0]->kmp_match_info);
    }

    /**
     * Uji penandaan warna (highlight) HTML
     */
    public function test_highlight_matches_wraps_term_in_mark_tag(): void
    {
        $text = 'Pengelolaan Kurikulum Operasional Satuan Pendidikan';
        $highlighted = $this->service->highlightMatches($text, 'Kurikulum');

        $this->assertStringContainsString('<mark', $highlighted);
        $this->assertStringContainsString('Kurikulum</mark>', $highlighted);
    }
}
