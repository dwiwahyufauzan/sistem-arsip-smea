<?php

namespace App\Http\Controllers;

use App\Models\PengajuanLegalisir;
use App\Models\SuratKeluar;
use Illuminate\View\View;

class VerifikasiDokumenController extends Controller
{
    /**
     * Halaman publik untuk memverifikasi keabsahan Surat Keluar resmi via QR Code
     */
    public function verifikasiSuratKeluar(string $identifier): View
    {
        // Cari berdasarkan ID atau nomor surat / agenda
        $suratKeluar = SuratKeluar::withTrashed()
            ->with(['kategori', 'user', 'kepsek'])
            ->where('id', $identifier)
            ->orWhere('nomor_surat', $identifier)
            ->orWhere('nomor_agenda', $identifier)
            ->firstOrFail();

        $isSah = $suratKeluar->status_persetujuan === 'disetujui' && is_null($suratKeluar->deleted_at);

        return view('verifikasi.surat-keluar', compact('suratKeluar', 'isSah'));
    }

    /**
     * Halaman publik untuk memverifikasi keabsahan pengajuan & tanda terima legalisir via QR Code
     */
    public function verifikasiLegalisir(string $nomorPengajuan): View
    {
        $pengajuan = PengajuanLegalisir::withTrashed()
            ->with(['user', 'petugas'])
            ->where('nomor_pengajuan', $nomorPengajuan)
            ->firstOrFail();

        $isSah = in_array($pengajuan->status, ['diverifikasi', 'disetujui_kepsek', 'sedang_diproses', 'siap_diambil', 'selesai'])
            && is_null($pengajuan->deleted_at);

        return view('verifikasi.legalisir', compact('pengajuan', 'isSah'));
    }
}
