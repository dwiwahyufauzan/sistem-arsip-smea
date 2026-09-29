<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\PengajuanLegalisir;
use App\Models\RiwayatLegalisir;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegalisirAdminController extends Controller
{
    /**
     * Tampilkan antrean permohonan legalisir untuk Petugas TU.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'semua');
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
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%");
            });
        }

        $legalisirList = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => PengajuanLegalisir::count(),
            'menunggu_verifikasi' => PengajuanLegalisir::where('status', 'menunggu_verifikasi')->count(),
            'menunggu_approval_kepsek' => PengajuanLegalisir::where('status', 'menunggu_approval_kepsek')->count(),
            'sedang_diproses' => PengajuanLegalisir::whereIn('status', ['diverifikasi', 'disetujui_kepsek', 'sedang_diproses'])->count(),
            'siap_diambil' => PengajuanLegalisir::where('status', 'siap_diambil')->count(),
            'selesai' => PengajuanLegalisir::where('status', 'selesai')->count(),
            'ditolak' => PengajuanLegalisir::where('status', 'ditolak')->count(),
        ];

        return view('admin.legalisir.index', compact('legalisirList', 'stats', 'status', 'search'));
    }

    /**
     * Lembar verifikasi berkas dan rincian permohonan legalisir.
     */
    public function show(PengajuanLegalisir $legalisir): View
    {
        $legalisir->load(['petugas', 'riwayat.user', 'user']);

        return view('admin.legalisir.show', compact('legalisir'));
    }

    /**
     * Verifikasi kesesuaian berkas terhadap buku induk kearsipan sekolah.
     */
    public function verifikasi(Request $request, PengajuanLegalisir $legalisir): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:diverifikasi,menunggu_approval_kepsek'],
            'catatan_petugas' => ['nullable', 'string', 'max:500'],
        ]);

        $statusSebelumnya = $legalisir->status;
        $statusBaru = $validated['status'];
        $catatan = $validated['catatan_petugas'] ?? ($statusBaru === 'menunggu_approval_kepsek'
            ? 'Berkas telah diverifikasi sesuai Buku Induk dan diajukan ke Kepala Sekolah untuk pengesahan.'
            : 'Berkas telah diverifikasi dan dinyatakan sesuai dengan data arsip kelulusan SMKN 1 Subang.');

        $legalisir->update([
            'status' => $statusBaru,
            'catatan_petugas' => $catatan,
            'petugas_id' => auth()->id(),
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
            'VERIFIKASI_LEGALISIR',
            'LEGALISIR',
            "Petugas TU memverifikasi permohonan legalisir [{$legalisir->nomor_pengajuan}] pemohon {$legalisir->nama_pemohon} (Status: {$statusBaru}).",
            auth()->id()
        );

        return back()->with('success', "Permohonan [{$legalisir->nomor_pengajuan}] berhasil diverifikasi.");
    }

    /**
     * Tandai dokumen sedang dalam proses cetak & pembubuhan stempel legalisir.
     */
    public function prosesCetak(Request $request, PengajuanLegalisir $legalisir): RedirectResponse
    {
        $statusSebelumnya = $legalisir->status;
        $statusBaru = 'sedang_diproses';
        $catatan = 'Dokumen salinan fisik sedang dicetak dan dalam proses pembubuhan stempel legalisir resmi.';

        $legalisir->update([
            'status' => $statusBaru,
            'petugas_id' => auth()->id(),
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
            'PROSES_CETAK_LEGALISIR',
            'LEGALISIR',
            "Permohonan [{$legalisir->nomor_pengajuan}] sedang diproses cetak & stempel basah.",
            auth()->id()
        );

        return back()->with('success', "Permohonan [{$legalisir->nomor_pengajuan}] ditandai sedang diproses.");
    }

    /**
     * Tandai dokumen fisik legalisir telah siap diambil di loket TU SMKN 1 Subang.
     */
    public function siapDiambil(Request $request, PengajuanLegalisir $legalisir): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_siap_ambil' => ['required', 'date'],
            'catatan_petugas' => ['nullable', 'string', 'max:500'],
        ], [
            'tanggal_siap_ambil.required' => 'Tentukan tanggal kesiapan pengambilan fisik dokumen.',
        ]);

        $statusSebelumnya = $legalisir->status;
        $statusBaru = 'siap_diambil';
        $catatan = $validated['catatan_petugas'] ?? 'Dokumen fisik legalisir telah siap diambil di loket Tata Usaha SMKN 1 Subang. Harap membawa identitas asli (KTP/SIM) dan bukti tanda terima resi.';

        $legalisir->update([
            'status' => $statusBaru,
            'tanggal_siap_ambil' => $validated['tanggal_siap_ambil'],
            'catatan_petugas' => $catatan,
            'petugas_id' => auth()->id(),
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
            'LEGALISIR_SIAP_DIAMBIL',
            'LEGALISIR',
            "Dokumen legalisir [{$legalisir->nomor_pengajuan}] siap diambil mulai tanggal {$validated['tanggal_siap_ambil']}.",
            auth()->id()
        );

        return back()->with('success', "Dokumen legalisir [{$legalisir->nomor_pengajuan}] berhasil ditandai SIAP DIAMBIL.");
    }

    /**
     * Tandai dokumen fisik telah diserahkan dan diambil oleh pemohon di sekolah.
     */
    public function selesai(Request $request, PengajuanLegalisir $legalisir): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_pengambilan' => ['nullable', 'date'],
        ]);

        $statusSebelumnya = $legalisir->status;
        $statusBaru = 'selesai';
        $catatan = 'Dokumen fisik legalisir telah diambil langsung oleh pemohon di loket SMKN 1 Subang. Layanan selesai.';

        $legalisir->update([
            'status' => $statusBaru,
            'tanggal_pengambilan' => $validated['tanggal_pengambilan'] ?? now()->toDateString(),
            'petugas_id' => auth()->id(),
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
            'LEGALISIR_SELESAI',
            'LEGALISIR',
            "Permohonan legalisir [{$legalisir->nomor_pengajuan}] pemohon {$legalisir->nama_pemohon} telah selesai diserahkan.",
            auth()->id()
        );

        return back()->with('success', "Permohonan legalisir [{$legalisir->nomor_pengajuan}] ditandai SELESAI.");
    }

    /**
     * Tolak permohonan legalisir disertai catatan perbaikan / alasan penolakan.
     */
    public function tolak(Request $request, PengajuanLegalisir $legalisir): RedirectResponse
    {
        $validated = $request->validate([
            'catatan_petugas' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'catatan_petugas.required' => 'Catatan alasan penolakan wajib diisi agar pemohon mengetahuinya.',
            'catatan_petugas.min' => 'Catatan penolakan minimal 5 karakter.',
        ]);

        $statusSebelumnya = $legalisir->status;
        $statusBaru = 'ditolak';

        $legalisir->update([
            'status' => $statusBaru,
            'catatan_petugas' => $validated['catatan_petugas'],
            'petugas_id' => auth()->id(),
        ]);

        RiwayatLegalisir::create([
            'pengajuan_legalisir_id' => $legalisir->id,
            'status_sebelumnya' => $statusSebelumnya,
            'status_baru' => $statusBaru,
            'diubah_oleh' => auth()->id(),
            'catatan' => 'Permohonan ditolak oleh Petugas TU: '.$validated['catatan_petugas'],
            'created_at' => now(),
        ]);

        LogAktivitas::catat(
            'TOLAK_LEGALISIR',
            'LEGALISIR',
            "Permohonan legalisir [{$legalisir->nomor_pengajuan}] ditolak oleh Petugas TU: {$validated['catatan_petugas']}",
            auth()->id()
        );

        return back()->with('warning', "Permohonan legalisir [{$legalisir->nomor_pengajuan}] ditolak dengan catatan terlampir.");
    }
}
