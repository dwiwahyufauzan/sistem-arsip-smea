<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\PengajuanLegalisir;
use App\Models\RiwayatLegalisir;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegalisirKepsekController extends Controller
{
    /**
     * Tampilkan daftar monitoring permohonan legalisir untuk Kepala Sekolah.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'menunggu_approval_kepsek');
        $search = trim((string) $request->query('q', ''));

        $query = PengajuanLegalisir::with(['petugas', 'riwayat'])
            ->latest('created_at');

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pengajuan', 'like', "%{$search}%")
                    ->orWhere('nama_pemohon', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%");
            });
        }

        $legalisirList = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => PengajuanLegalisir::count(),
            'menunggu' => PengajuanLegalisir::where('status', 'menunggu_approval_kepsek')->count(),
            'disetujui' => PengajuanLegalisir::where('status', 'disetujui_kepsek')->count(),
            'selesai' => PengajuanLegalisir::where('status', 'selesai')->count(),
        ];

        return view('kepsek.legalisir.index', compact('legalisirList', 'stats', 'status', 'search'));
    }

    /**
     * Lembar peninjauan dokumen legalisir untuk pengesahan Kepala Sekolah.
     */
    public function show(PengajuanLegalisir $legalisir): View
    {
        $legalisir->load(['petugas', 'riwayat.user']);

        return view('kepsek.legalisir.show', compact('legalisir'));
    }

    /**
     * Setujui otorisasi pengesahan legalisir oleh Kepala Sekolah.
     */
    public function approve(Request $request, PengajuanLegalisir $legalisir): RedirectResponse
    {
        $catatan = trim((string) $request->input('catatan_kepsek', ''));
        if ($catatan === '') {
            $catatan = 'Disetujui untuk pengesahan tanda tangan dan cap stempel resmi SMKN 1 Subang.';
        }

        $statusSebelumnya = $legalisir->status;
        $statusBaru = 'disetujui_kepsek';

        $legalisir->update([
            'status' => $statusBaru,
            'catatan_kepsek' => $catatan,
        ]);

        RiwayatLegalisir::create([
            'pengajuan_legalisir_id' => $legalisir->id,
            'status_sebelumnya' => $statusSebelumnya,
            'status_baru' => $statusBaru,
            'diubah_oleh' => auth()->id(),
            'catatan' => $catatan,
            'created_at' => now(),
        ]);

        LogAktivitas::catat(
            'SETUJUI_LEGALISIR',
            'LEGALISIR',
            "Kepala Sekolah menyetujui pengesahan legalisir [{$legalisir->nomor_pengajuan}] pemohon {$legalisir->nama_pemohon}.",
            auth()->id()
        );

        return back()->with('success', "Permohonan legalisir [{$legalisir->nomor_pengajuan}] berhasil disetujui Kepala Sekolah.");
    }

    /**
     * Tolak pengesahan legalisir oleh Kepala Sekolah.
     */
    public function reject(Request $request, PengajuanLegalisir $legalisir): RedirectResponse
    {
        $validated = $request->validate([
            'catatan_kepsek' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'catatan_kepsek.required' => 'Catatan alasan penolakan wajib diisi.',
            'catatan_kepsek.min' => 'Catatan penolakan minimal 5 karakter.',
        ]);

        $statusSebelumnya = $legalisir->status;
        $statusBaru = 'ditolak';

        $legalisir->update([
            'status' => $statusBaru,
            'catatan_kepsek' => $validated['catatan_kepsek'],
        ]);

        RiwayatLegalisir::create([
            'pengajuan_legalisir_id' => $legalisir->id,
            'status_sebelumnya' => $statusSebelumnya,
            'status_baru' => $statusBaru,
            'diubah_oleh' => auth()->id(),
            'catatan' => 'Ditolak Kepala Sekolah: '.$validated['catatan_kepsek'],
            'created_at' => now(),
        ]);

        LogAktivitas::catat(
            'TOLAK_LEGALISIR_KEPSEK',
            'LEGALISIR',
            "Kepala Sekolah menolak pengesahan legalisir [{$legalisir->nomor_pengajuan}]: {$validated['catatan_kepsek']}",
            auth()->id()
        );

        return back()->with('warning', "Permohonan legalisir [{$legalisir->nomor_pengajuan}] ditolak.");
    }
}
