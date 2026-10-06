<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\SuratKeluar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PersetujuanController extends Controller
{
    /**
     * Tampilkan daftar pengajuan surat keluar untuk ditinjau Kepala Sekolah.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'menunggu_persetujuan');
        $search = trim((string) $request->query('q', ''));

        $query = SuratKeluar::with(['kategori', 'user', 'kepsek'])
            ->latest('tanggal_surat');

        if ($status !== 'semua') {
            $query->where('status_persetujuan', $status);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_agenda', 'like', "%{$search}%")
                    ->orWhere('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%")
                    ->orWhere('tujuan', 'like', "%{$search}%");
            });
        }

        $suratKeluars = $query->paginate(10)->withQueryString();

        // Hitung statistik ringkasan antrean
        $stats = [
            'total' => SuratKeluar::count(),
            'menunggu' => SuratKeluar::where('status_persetujuan', 'menunggu_persetujuan')->count(),
            'disetujui' => SuratKeluar::where('status_persetujuan', 'disetujui')->count(),
            'ditolak' => SuratKeluar::where('status_persetujuan', 'ditolak')->count(),
        ];

        return view('kepsek.persetujuan.index', compact('suratKeluars', 'stats', 'status', 'search'));
    }

    /**
     * Tampilkan lembar peninjauan dokumen draf surat keluar untuk disetujui/ditolak.
     */
    public function show(SuratKeluar $suratKeluar): View
    {
        $suratKeluar->load(['kategori', 'user', 'kepsek']);

        return view('kepsek.persetujuan.show', compact('suratKeluar'));
    }

    /**
     * Setujui draf surat keluar oleh Kepala Sekolah.
     */
    public function approve(Request $request, SuratKeluar $suratKeluar): RedirectResponse
    {
        if ($suratKeluar->status_persetujuan !== 'menunggu_persetujuan') {
            return redirect()
                ->route('kepsek.persetujuan.show', $suratKeluar)
                ->with('error', 'Hanya surat keluar dengan status "Menunggu Persetujuan" yang dapat disetujui.');
        }

        $catatan = trim((string) $request->input('catatan_kepsek', ''));
        if ($catatan === '') {
            $catatan = 'Disetujui untuk diterbitkan secara resmi.';
        }

        $suratKeluar->update([
            'status_persetujuan' => 'disetujui',
            'catatan_kepsek' => $catatan,
            'disetujui_oleh' => auth()->id(),
            'tanggal_disetujui' => now(),
        ]);

        LogAktivitas::catat(
            'SETUJUI_SURAT_KELUAR',
            'SURAT_KELUAR',
            "Kepala Sekolah menyetujui surat keluar nomor agenda {$suratKeluar->nomor_agenda} (Nomor: {$suratKeluar->nomor_surat}).",
            auth()->id()
        );

        return redirect()
            ->route('kepsek.persetujuan.show', $suratKeluar)
            ->with('success', "Surat keluar [{$suratKeluar->nomor_surat}] berhasil disetujui dan siap didistribusikan.");
    }

    /**
     * Tolak / minta revisi draf surat keluar oleh Kepala Sekolah.
     */
    public function reject(Request $request, SuratKeluar $suratKeluar): RedirectResponse
    {
        if ($suratKeluar->status_persetujuan !== 'menunggu_persetujuan') {
            return redirect()
                ->route('kepsek.persetujuan.show', $suratKeluar)
                ->with('error', 'Hanya surat keluar dengan status "Menunggu Persetujuan" yang dapat ditolak/direvisi.');
        }

        $validated = $request->validate([
            'catatan_kepsek' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'catatan_kepsek.required' => 'Catatan revisi/alasan penolakan wajib diisi agar staf TU dapat memperbaikinya.',
            'catatan_kepsek.min' => 'Catatan penolakan minimal 5 karakter.',
            'catatan_kepsek.max' => 'Catatan penolakan maksimal 1000 karakter.',
        ]);

        $suratKeluar->update([
            'status_persetujuan' => 'ditolak',
            'catatan_kepsek' => $validated['catatan_kepsek'],
            'disetujui_oleh' => auth()->id(),
            'tanggal_disetujui' => now(),
        ]);

        LogAktivitas::catat(
            'TOLAK_SURAT_KELUAR',
            'SURAT_KELUAR',
            "Kepala Sekolah menolak draf surat keluar {$suratKeluar->nomor_agenda} dengan catatan: {$validated['catatan_kepsek']}",
            auth()->id()
        );

        return redirect()
            ->route('kepsek.persetujuan.show', $suratKeluar)
            ->with('warning', "Surat keluar [{$suratKeluar->nomor_surat}] ditandai Ditolak / Perlu Revisi dengan catatan terlampir.");
    }
}
