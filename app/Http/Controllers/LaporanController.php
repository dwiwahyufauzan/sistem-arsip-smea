<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use App\Models\LogAktivitas;
use App\Models\PengajuanLegalisir;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /**
     * Halaman Rekapitulasi Laporan & Agenda Kearsipan untuk Petugas Tata Usaha (SRS-P10, SRS-P11).
     */
    public function indexAdmin(Request $request): View
    {
        $data = $this->buildReportData($request);

        return view('admin.laporan.index', $data);
    }

    /**
     * Lembar Cetak Buku Agenda Resmi Standar Kearsipan SMKN 1 Subang (Admin TU).
     */
    public function cetakAdmin(Request $request): View
    {
        $data = $this->buildReportData($request);

        return view('admin.laporan.cetak', $data);
    }

    /**
     * Halaman Monitoring Rekapitulasi Agenda Eksekutif untuk Kepala Sekolah (SRS-KS09).
     */
    public function indexKepsek(Request $request): View
    {
        $data = $this->buildReportData($request);

        return view('kepsek.laporan.index', $data);
    }

    /**
     * Lembar Cetak Rekapitulasi Eksekutif untuk Kepala Sekolah.
     */
    public function cetakKepsek(Request $request): View
    {
        $data = $this->buildReportData($request);

        return view('admin.laporan.cetak', $data);
    }

    /**
     * Membangun dataset terfilter untuk laporan kearsipan dan agenda dinas.
     *
     * @return array<string, mixed>
     */
    private function buildReportData(Request $request): array
    {
        $jenis = $request->query('jenis', 'surat_masuk');
        $tanggalMulai = $request->query('tanggal_mulai', now()->startOfMonth()->toDateString());
        $tanggalSelesai = $request->query('tanggal_selesai', now()->toDateString());
        $kategoriId = $request->query('kategori_id', '');
        $status = $request->query('status', '');

        $kategoris = KategoriSurat::orderBy('kode_kategori')->get();
        $records = collect();
        $stats = [
            'total_periode' => 0,
            'surat_masuk_count' => SuratMasuk::whereBetween('tanggal_terima', [$tanggalMulai, $tanggalSelesai])->count(),
            'surat_keluar_count' => SuratKeluar::whereBetween('tanggal_surat', [$tanggalMulai, $tanggalSelesai])->count(),
            'legalisir_count' => PengajuanLegalisir::whereBetween('created_at', [$tanggalMulai.' 00:00:00', $tanggalSelesai.' 23:59:59'])->count(),
        ];

        if ($jenis === 'surat_masuk') {
            $query = SuratMasuk::with(['kategori', 'disposisi', 'user'])
                ->whereBetween('tanggal_terima', [$tanggalMulai, $tanggalSelesai])
                ->orderBy('tanggal_terima', 'asc')
                ->orderBy('id', 'asc');

            if ($kategoriId !== '') {
                $query->where('kategori_id', $kategoriId);
            }
            if ($status !== '') {
                $query->where('status', $status);
            }

            $records = $query->get();
            $stats['total_periode'] = $records->count();
        } elseif ($jenis === 'surat_keluar') {
            $query = SuratKeluar::with(['kategori', 'user'])
                ->whereBetween('tanggal_surat', [$tanggalMulai, $tanggalSelesai])
                ->orderBy('tanggal_surat', 'asc')
                ->orderBy('id', 'asc');

            if ($kategoriId !== '') {
                $query->where('kategori_id', $kategoriId);
            }
            if ($status !== '') {
                $query->where('status_persetujuan', $status);
            }

            $records = $query->get();
            $stats['total_periode'] = $records->count();
        } elseif ($jenis === 'legalisir') {
            $query = PengajuanLegalisir::with(['petugas', 'riwayat'])
                ->whereBetween('created_at', [$tanggalMulai.' 00:00:00', $tanggalSelesai.' 23:59:59'])
                ->orderBy('created_at', 'asc');

            if ($status !== '') {
                $query->where('status', $status);
            }

            $records = $query->get();
            $stats['total_periode'] = $records->count();
        }

        return [
            'jenis' => $jenis,
            'tanggalMulai' => $tanggalMulai,
            'tanggalSelesai' => $tanggalSelesai,
            'kategoriId' => $kategoriId,
            'status' => $status,
            'kategoris' => $kategoris,
            'records' => $records,
            'stats' => $stats,
        ];
    }

    /**
     * Halaman Log Aktivitas Kearsipan untuk Petugas Tata Usaha.
     */
    public function logAktivitasAdmin(Request $request): View
    {
        $logs = $this->buildLogQuery($request);

        return view('admin.log-aktivitas.index', compact('logs'));
    }

    /**
     * Halaman Jejak Audit Aktivitas untuk Kepala Sekolah.
     */
    public function logAktivitasKepsek(Request $request): View
    {
        $logs = $this->buildLogQuery($request);

        return view('kepsek.log-aktivitas.index', compact('logs'));
    }

    /**
     * Bangun query log aktivitas dengan filter dan pencarian.
     */
    private function buildLogQuery(Request $request)
    {
        $search = trim((string) $request->input('q', ''));
        $modul = $request->input('modul', 'semua');

        $query = LogAktivitas::with('user')->latest('created_at');

        if ($modul !== 'semua' && $modul !== '') {
            $query->where('modul', $modul);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('aksi', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        return $query->paginate(20)->withQueryString();
    }
}
