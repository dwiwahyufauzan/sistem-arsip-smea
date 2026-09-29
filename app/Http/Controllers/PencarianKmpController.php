<?php

namespace App\Http\Controllers;

use App\Models\PengajuanLegalisir;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Services\KmpSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PencarianKmpController extends Controller
{
    public function __construct(
        protected KmpSearchService $kmpService
    ) {}

    /**
     * Halaman Pencarian Cerdas Terpadu KMP untuk Petugas Tata Usaha (Admin).
     */
    public function indexAdmin(Request $request): View
    {
        $data = $this->executeUnifiedSearch($request);

        return view('admin.pencarian.index', $data);
    }

    /**
     * Halaman Pencarian Cepat Terpadu KMP untuk Kepala Sekolah (Pimpinan).
     */
    public function indexKepsek(Request $request): View
    {
        $data = $this->executeUnifiedSearch($request);

        return view('kepsek.pencarian.index', $data);
    }

    /**
     * Eksekusi algoritma KMP simultan lintas modul kearsipan SMKN 1 Subang.
     *
     * @return array<string, mixed>
     */
    private function executeUnifiedSearch(Request $request): array
    {
        $query = trim((string) $request->input('q', ''));
        $modul = $request->input('modul', 'semua');
        $runCompare = (bool) $request->boolean('compare', false);

        $resultsSuratMasuk = [];
        $resultsSuratKeluar = [];
        $resultsLegalisir = [];
        $benchmarkData = null;
        $lpsTable = [];
        $totalMatches = 0;
        $totalTimeMs = 0.0;

        if ($query !== '') {
            $startTime = microtime(true);
            $lpsTable = $this->kmpService->computeLpsArray(mb_strtolower($query, 'UTF-8'));

            // 1. Modul Surat Masuk
            if (in_array($modul, ['semua', 'surat_masuk'])) {
                $masukRecords = SuratMasuk::with(['kategori', 'disposisi'])->latest('tanggal_terima')->get();
                $masukFields = ['nomor_surat', 'pengirim', 'perihal', 'ringkasan_isi'];
                $filterMasuk = $this->kmpService->filterCollection($masukRecords, $query, $masukFields);
                $resultsSuratMasuk = $filterMasuk['results'];
                $totalMatches += $filterMasuk['total_found'];
            }

            // 2. Modul Surat Keluar
            if (in_array($modul, ['semua', 'surat_keluar'])) {
                $keluarRecords = SuratKeluar::with(['kategori', 'user'])->latest('tanggal_surat')->get();
                $keluarFields = ['nomor_surat', 'tujuan', 'perihal', 'isi_ringkas'];
                $filterKeluar = $this->kmpService->filterCollection($keluarRecords, $query, $keluarFields);
                $resultsSuratKeluar = $filterKeluar['results'];
                $totalMatches += $filterKeluar['total_found'];
            }

            // 3. Modul Permohonan Legalisir
            if (in_array($modul, ['semua', 'legalisir'])) {
                $legalisirRecords = PengajuanLegalisir::with(['petugas', 'riwayat'])->latest('created_at')->get();
                $legalisirFields = ['nomor_pengajuan', 'nama_pemohon', 'nisn', 'keperluan'];
                $filterLegalisir = $this->kmpService->filterCollection($legalisirRecords, $query, $legalisirFields);
                $resultsLegalisir = $filterLegalisir['results'];
                $totalMatches += $filterLegalisir['total_found'];
            }

            $totalTimeMs = round((microtime(true) - $startTime) * 1000, 3);

            // 4. Pengujian Ilmiah KMP vs Brute Force (Untuk Dokumen Bab IV Skripsi)
            if ($runCompare) {
                $sampleCorpuses = [];
                foreach ($resultsSuratMasuk as $item) {
                    $sampleCorpuses[] = "{$item->nomor_surat} {$item->pengirim} {$item->perihal} {$item->ringkasan_isi}";
                }
                foreach ($resultsSuratKeluar as $item) {
                    $sampleCorpuses[] = "{$item->nomor_surat} {$item->tujuan} {$item->perihal} {$item->isi_ringkas}";
                }
                foreach ($resultsLegalisir as $item) {
                    $sampleCorpuses[] = "{$item->nomor_pengajuan} {$item->nama_pemohon} {$item->nisn} {$item->keperluan}";
                }

                $corpusText = implode(' | ', $sampleCorpuses);
                if (strlen($corpusText) < 100) {
                    $corpusText .= ' SMK Negeri 1 Subang menyelenggarakan sistem tata kelola kearsipan dan layanan legalisir digital menggunakan algoritma Knuth-Morris-Pratt untuk pencarian presisi tinggi.';
                }

                $benchmarkData = $this->kmpService->compareWithBruteForce($query, $corpusText, 50);
            }
        }

        return [
            'query' => $query,
            'modul' => $modul,
            'runCompare' => $runCompare,
            'resultsSuratMasuk' => $resultsSuratMasuk,
            'resultsSuratKeluar' => $resultsSuratKeluar,
            'resultsLegalisir' => $resultsLegalisir,
            'totalMatches' => $totalMatches,
            'totalTimeMs' => $totalTimeMs,
            'lpsTable' => $lpsTable,
            'benchmarkData' => $benchmarkData,
            'kmpService' => $this->kmpService,
        ];
    }

    /**
     * API JSON Live Search untuk prediksi instan pada topbar navbar.
     */
    public function liveSearch(Request $request): JsonResponse
    {
        $query = trim((string) $request->input('q', ''));
        if (strlen($query) < 2) {
            return response()->json(['results' => [], 'total' => 0, 'time_ms' => 0]);
        }

        $startTime = microtime(true);
        $results = [];

        // Cari di Surat Masuk
        $masuk = SuratMasuk::select('id', 'nomor_surat', 'pengirim', 'perihal')->limit(50)->get();
        foreach ($masuk as $item) {
            if ($this->kmpService->contains($query, "{$item->nomor_surat} {$item->pengirim} {$item->perihal}")) {
                $results[] = [
                    'type' => 'surat_masuk',
                    'badge' => 'Surat Masuk',
                    'title' => $item->nomor_surat,
                    'subtitle' => $item->pengirim.' — '.$item->perihal,
                    'url' => route(auth()->user()->role === 'admin' ? 'admin.surat-masuk.show' : 'kepsek.surat-masuk.show', $item->id),
                ];
            }
        }

        // Cari di Surat Keluar
        $keluar = SuratKeluar::select('id', 'nomor_surat', 'tujuan', 'perihal')->limit(50)->get();
        foreach ($keluar as $item) {
            if ($this->kmpService->contains($query, "{$item->nomor_surat} {$item->tujuan} {$item->perihal}")) {
                $results[] = [
                    'type' => 'surat_keluar',
                    'badge' => 'Surat Keluar',
                    'title' => $item->nomor_surat,
                    'subtitle' => $item->tujuan.' — '.$item->perihal,
                    'url' => route(auth()->user()->role === 'admin' ? 'admin.surat-keluar.show' : 'kepsek.surat-keluar.show', $item->id),
                ];
            }
        }

        // Cari di Legalisir
        $legalisir = PengajuanLegalisir::select('id', 'nomor_pengajuan', 'nama_pemohon', 'nisn', 'jenis_dokumen')->limit(50)->get();
        foreach ($legalisir as $item) {
            if ($this->kmpService->contains($query, "{$item->nomor_pengajuan} {$item->nama_pemohon} {$item->nisn}")) {
                $results[] = [
                    'type' => 'legalisir',
                    'badge' => 'Legalisir',
                    'title' => $item->nomor_pengajuan,
                    'subtitle' => $item->nama_pemohon.' (NISN: '.$item->nisn.')',
                    'url' => route(auth()->user()->role === 'admin' ? 'admin.legalisir.show' : 'kepsek.legalisir.show', $item->id),
                ];
            }
        }

        $elapsed = round((microtime(true) - $startTime) * 1000, 2);

        return response()->json([
            'results' => array_slice($results, 0, 8),
            'total' => count($results),
            'time_ms' => $elapsed,
        ]);
    }
}
