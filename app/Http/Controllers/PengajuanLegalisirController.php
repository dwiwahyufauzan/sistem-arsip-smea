<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\PengajuanLegalisir;
use App\Models\RiwayatLegalisir;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PengajuanLegalisirController extends Controller
{
    /**
     * Tampilkan formulir permohonan legalisir dokumen baru (Publik / Pemohon).
     */
    public function create(): View
    {
        $user = auth()->user();

        return view('legalisir.create', compact('user'));
    }

    /**
     * Simpan permohonan legalisir baru dan hasilkan nomor resi pelacakan.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_pemohon' => ['required', 'string', 'max:150'],
            'nisn' => ['required', 'string', 'max:30'],
            'tahun_lulus' => ['required', 'string', 'max:10'],
            'nomor_whatsapp' => ['required', 'string', 'max:25'],
            'email' => ['required', 'email', 'max:191'],
            'jenis_dokumen' => ['required', 'in:ijazah,transkrip_nilai,rapor,sertifikat_keahlian'],
            'jumlah_lembar' => ['required', 'integer', 'min:1', 'max:10'],
            'keperluan' => ['required', 'string', 'max:255'],
            'berkas' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // Max 5MB
        ], [
            'nama_pemohon.required' => 'Nama lengkap pemohon wajib diisi.',
            'nisn.required' => 'Nomor Induk Siswa Nasional (NISN) wajib diisi.',
            'tahun_lulus.required' => 'Tahun kelulusan wajib diisi.',
            'nomor_whatsapp.required' => 'Nomor WhatsApp aktif wajib diisi untuk notifikasi.',
            'email.required' => 'Alamat email aktif wajib diisi.',
            'jenis_dokumen.required' => 'Pilih jenis dokumen yang hendak dilegalisir.',
            'jumlah_lembar.required' => 'Jumlah lembar legalisir wajib ditentukan (1 - 10 lembar).',
            'keperluan.required' => 'Keperluan permohonan legalisir wajib diisi.',
            'berkas.required' => 'Berkas pindaian (scan) dokumen asli wajib diunggah.',
            'berkas.mimes' => 'Format berkas dokumen harus berupa PDF, JPG, atau PNG.',
            'berkas.max' => 'Ukuran berkas dokumen maksimal 5 MB.',
        ]);

        // Generator otomatis Nomor Resi Legalisir: LEG-YYYYMM-XXXX
        $yearMonth = date('Ym');
        $prefix = "LEG-{$yearMonth}-";

        $lastRecord = PengajuanLegalisir::where('nomor_pengajuan', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastRecord && preg_match('/-(\d+)$/', $lastRecord->nomor_pengajuan, $matches)) {
            $nextNumber = (int) $matches[1] + 1;
        }

        $nomorPengajuan = $prefix.str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);

        // Upload berkas fisik dokumen asli ke storage
        $file = $request->file('berkas');
        $extension = $file->getClientOriginalExtension();
        $safeFileName = 'legalisir_'.str_replace('-', '_', $nomorPengajuan).'_'.time().'.'.$extension;
        $filePath = $file->storeAs('dokumen-legalisir', $safeFileName, 'public');

        // Simpan ke basis data
        $userId = auth()->id();
        $pengajuan = PengajuanLegalisir::create([
            'nomor_pengajuan' => $nomorPengajuan,
            'user_id' => $userId,
            'nama_pemohon' => $validated['nama_pemohon'],
            'nisn' => $validated['nisn'],
            'tahun_lulus' => $validated['tahun_lulus'],
            'nomor_whatsapp' => $validated['nomor_whatsapp'],
            'email' => $validated['email'],
            'jenis_dokumen' => $validated['jenis_dokumen'],
            'jumlah_lembar' => $validated['jumlah_lembar'],
            'keperluan' => $validated['keperluan'],
            'file_dokumen_path' => $filePath,
            'status' => 'menunggu_verifikasi',
        ]);

        // Simpan jejak awal ke riwayat_legalisir
        $defaultAdminId = $userId ?? User::where('role', 'admin')->value('id') ?? 1;
        RiwayatLegalisir::create([
            'pengajuan_legalisir_id' => $pengajuan->id,
            'status_sebelumnya' => null,
            'status_baru' => 'menunggu_verifikasi',
            'diubah_oleh' => $defaultAdminId,
            'catatan' => 'Permohonan legalisir berhasil diajukan secara online.',
            'created_at' => now(),
        ]);

        if ($userId) {
            LogAktivitas::catat(
                'PENGAJUAN_LEGALISIR',
                'LEGALISIR',
                "Pemohon {$validated['nama_pemohon']} mengajukan permohonan legalisir dokumen {$pengajuan->jenis_dokumen_label} (Resi: {$nomorPengajuan}).",
                $userId
            );
        }

        return redirect()
            ->route('legalisir.sukses', $pengajuan->nomor_pengajuan)
            ->with('success', "Permohonan legalisir berhasil dikirim! Nomor resi pelacakan Anda: {$nomorPengajuan}");
    }

    /**
     * Halaman sukses penerbitan resi dan bukti permohonan legalisir.
     */
    public function sukses(string $nomor_pengajuan): View
    {
        $pengajuan = PengajuanLegalisir::with(['riwayat.user'])
            ->where('nomor_pengajuan', $nomor_pengajuan)
            ->firstOrFail();

        return view('legalisir.sukses', compact('pengajuan'));
    }

    /**
     * Halaman pelacakan status legalisir mandiri (Live Tracking Stepper).
     */
    public function tracking(Request $request): View
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

        return view('legalisir.tracking', compact('pengajuan', 'query', 'searchPerformed'));
    }

    /**
     * Cetak Tanda Terima / Bukti Registrasi Permohonan Legalisir.
     */
    public function cetakTandaTerima(string $nomor_pengajuan): View
    {
        $pengajuan = PengajuanLegalisir::with(['riwayat.user'])
            ->where('nomor_pengajuan', $nomor_pengajuan)
            ->firstOrFail();

        return view('legalisir.tanda-terima', compact('pengajuan'));
    }

    /**
     * Unduh berkas pindaian dokumen asli pemohon secara aman.
     */
    public function downloadDokumen(PengajuanLegalisir $legalisir): BinaryFileResponse|RedirectResponse
    {
        if (! $legalisir->file_dokumen_path || ! Storage::disk('public')->exists($legalisir->file_dokumen_path)) {
            return back()->with('error', 'Berkas dokumen fisik tidak ditemukan pada server penyimpanan.');
        }

        $fullPath = Storage::disk('public')->path($legalisir->file_dokumen_path);
        $downloadName = 'Berkas_Legalisir_'.$legalisir->nomor_pengajuan.'.'.pathinfo($legalisir->file_dokumen_path, PATHINFO_EXTENSION);

        return response()->download($fullPath, $downloadName);
    }

    /**
     * Dashboard / Daftar Permohonan Saya untuk akun Pemohon.
     */
    public function indexPemohon(Request $request): View
    {
        $user = auth()->user();

        $query = PengajuanLegalisir::with('riwayat')
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhere('email', $user->email);
                if ($user->nip_nisn) {
                    $q->orWhere('nisn', $user->nip_nisn);
                }
            })
            ->latest('created_at');

        $pengajuans = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => (clone $query)->count(),
            'menunggu' => (clone $query)->whereIn('status', ['menunggu_verifikasi', 'diverifikasi', 'menunggu_approval_kepsek'])->count(),
            'proses' => (clone $query)->whereIn('status', ['disetujui_kepsek', 'sedang_diproses'])->count(),
            'siap_ambil' => (clone $query)->where('status', 'siap_diambil')->count(),
            'selesai' => (clone $query)->where('status', 'selesai')->count(),
        ];

        return view('pemohon.legalisir.index', compact('pengajuans', 'stats'));
    }

    /**
     * Detail permohonan legalisir untuk akun Pemohon.
     */
    public function showPemohon(PengajuanLegalisir $legalisir): View
    {
        $legalisir->load(['riwayat.user', 'petugas']);

        return view('pemohon.legalisir.show', compact('legalisir'));
    }
}
