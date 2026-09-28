<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use App\Models\PengajuanLegalisir;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Menampilkan Beranda Publik SMKN 1 Subang & Fitur Lacak Resi Legalisir
     */
    public function index(Request $request): View
    {
        $query = trim((string) $request->input('nomor_pengajuan', ''));
        $pengajuan = null;
        $searchPerformed = false;

        if ($query !== '') {
            $searchPerformed = true;
            $pengajuan = PengajuanLegalisir::with(['riwayat.user', 'petugas'])
                ->where('nomor_pengajuan', $query)
                ->orWhere('nisn', $query)
                ->first();
        }

        $stats = [
            'total_surat_masuk' => SuratMasuk::count(),
            'total_surat_keluar' => SuratKeluar::count(),
            'total_kategori' => KategoriSurat::count(),
            'total_legalisir' => PengajuanLegalisir::count(),
            'total_legalisir_selesai' => PengajuanLegalisir::whereIn('status', ['siap_diambil', 'selesai'])->count(),
        ];

        return view('landing', compact('stats', 'pengajuan', 'query', 'searchPerformed'));
    }
}
