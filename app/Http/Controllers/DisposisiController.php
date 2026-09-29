<?php

namespace App\Http\Controllers;

use App\Models\DisposisiSuratMasuk;
use App\Models\LogAktivitas;
use App\Models\SuratMasuk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DisposisiController extends Controller
{
    /**
     * Tampilkan daftar disposisi surat masuk untuk Kepala Sekolah.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'semua');
        $search = trim((string) $request->query('q', ''));

        $query = DisposisiSuratMasuk::with(['suratMasuk.kategori', 'pemberi'])
            ->latest('created_at');

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('tujuan_disposisi', 'like', "%{$search}%")
                    ->orWhere('instruksi', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%")
                    ->orWhereHas('suratMasuk', function ($sm) use ($search) {
                        $sm->where('nomor_agenda', 'like', "%{$search}%")
                            ->orWhere('nomor_surat', 'like', "%{$search}%")
                            ->orWhere('perihal', 'like', "%{$search}%")
                            ->orWhere('pengirim', 'like', "%{$search}%");
                    });
            });
        }

        $disposisiList = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => DisposisiSuratMasuk::count(),
            'menunggu' => DisposisiSuratMasuk::where('status', 'menunggu')->count(),
            'ditindaklanjuti' => DisposisiSuratMasuk::where('status', 'ditindaklanjuti')->count(),
            'selesai' => DisposisiSuratMasuk::where('status', 'selesai')->count(),
        ];

        return view('kepsek.disposisi.index', compact('disposisiList', 'stats', 'status', 'search'));
    }

    /**
     * Tampilkan daftar disposisi untuk Admin / Petugas TU.
     */
    public function indexAdmin(Request $request): View
    {
        $status = $request->query('status', 'semua');
        $search = trim((string) $request->query('q', ''));

        $query = DisposisiSuratMasuk::with(['suratMasuk.kategori', 'pemberi'])
            ->latest('created_at');

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('tujuan_disposisi', 'like', "%{$search}%")
                    ->orWhere('instruksi', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%")
                    ->orWhereHas('suratMasuk', function ($sm) use ($search) {
                        $sm->where('nomor_agenda', 'like', "%{$search}%")
                            ->orWhere('nomor_surat', 'like', "%{$search}%")
                            ->orWhere('perihal', 'like', "%{$search}%")
                            ->orWhere('pengirim', 'like', "%{$search}%");
                    });
            });
        }

        $disposisiList = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => DisposisiSuratMasuk::count(),
            'menunggu' => DisposisiSuratMasuk::where('status', 'menunggu')->count(),
            'ditindaklanjuti' => DisposisiSuratMasuk::where('status', 'ditindaklanjuti')->count(),
            'selesai' => DisposisiSuratMasuk::where('status', 'selesai')->count(),
        ];

        return view('admin.disposisi.index', compact('disposisiList', 'stats', 'status', 'search'));
    }

    /**
     * Formulir pembuatan lembar disposisi baru oleh Kepala Sekolah.
     */
    public function create(Request $request): View
    {
        $selectedSuratMasukId = $request->query('surat_masuk_id');
        $selectedSuratMasuk = null;

        if ($selectedSuratMasukId) {
            $selectedSuratMasuk = SuratMasuk::with('kategori')->find($selectedSuratMasukId);
        }

        // Ambil daftar surat masuk terbaru yang masih aktif
        $suratMasukList = SuratMasuk::with('kategori')
            ->latest('tanggal_terima')
            ->take(50)
            ->get();

        return view('kepsek.disposisi.create', compact('suratMasukList', 'selectedSuratMasuk'));
    }

    /**
     * Simpan lembar disposisi baru ke basis data.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'surat_masuk_id' => ['required', 'exists:surat_masuk,id'],
            'tujuan_disposisi' => ['required', 'string', 'max:150'],
            'instruksi' => ['required', 'string', 'max:1000'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'batas_waktu' => ['nullable', 'date'],
        ], [
            'surat_masuk_id.required' => 'Pilih surat masuk yang hendak didisposisikan.',
            'surat_masuk_id.exists' => 'Surat masuk yang dipilih tidak ditemukan.',
            'tujuan_disposisi.required' => 'Tujuan disposisi / pejabat penerima wajib diisi.',
            'tujuan_disposisi.max' => 'Tujuan disposisi maksimal 150 karakter.',
            'instruksi.required' => 'Instruksi / arahan disposisi pimpinan wajib diisi.',
            'instruksi.max' => 'Instruksi disposisi maksimal 1000 karakter.',
            'batas_waktu.date' => 'Format batas waktu tindak lanjut tidak valid.',
        ]);

        $disposisi = DisposisiSuratMasuk::create([
            'surat_masuk_id' => $validated['surat_masuk_id'],
            'diberikan_oleh' => auth()->id(),
            'tujuan_disposisi' => $validated['tujuan_disposisi'],
            'instruksi' => $validated['instruksi'],
            'catatan' => $validated['catatan'] ?? null,
            'batas_waktu' => $validated['batas_waktu'] ?? null,
            'status' => 'menunggu',
        ]);

        // Perbarui status surat masuk menjadi 'didisposisikan'
        $suratMasuk = SuratMasuk::findOrFail($validated['surat_masuk_id']);
        $suratMasuk->update(['status' => 'didisposisikan']);

        LogAktivitas::catat(
            'BUAT_DISPOSISI',
            'DISPOSISI',
            "Kepala Sekolah memberikan lembar disposisi pada surat masuk {$suratMasuk->nomor_agenda} kepada {$validated['tujuan_disposisi']}.",
            auth()->id()
        );

        return redirect()
            ->route('kepsek.disposisi.show', $disposisi)
            ->with('success', "Lembar disposisi untuk surat [{$suratMasuk->nomor_surat}] berhasil diterbitkan.");
    }

    /**
     * Tampilkan detail lembar disposisi untuk Kepala Sekolah.
     */
    public function show(DisposisiSuratMasuk $disposisi): View
    {
        $disposisi->load(['suratMasuk.kategori', 'pemberi']);

        return view('kepsek.disposisi.show', compact('disposisi'));
    }

    /**
     * Tampilkan detail lembar disposisi untuk Admin / Petugas TU.
     */
    public function showAdmin(DisposisiSuratMasuk $disposisi): View
    {
        $disposisi->load(['suratMasuk.kategori', 'pemberi']);

        return view('admin.disposisi.show', compact('disposisi'));
    }

    /**
     * Formulir ubah lembar disposisi.
     */
    public function edit(DisposisiSuratMasuk $disposisi): View
    {
        $disposisi->load(['suratMasuk.kategori']);

        return view('kepsek.disposisi.edit', compact('disposisi'));
    }

    /**
     * Perbarui data lembar disposisi.
     */
    public function update(Request $request, DisposisiSuratMasuk $disposisi): RedirectResponse
    {
        $validated = $request->validate([
            'tujuan_disposisi' => ['required', 'string', 'max:150'],
            'instruksi' => ['required', 'string', 'max:1000'],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'batas_waktu' => ['nullable', 'date'],
            'status' => ['required', 'in:menunggu,ditindaklanjuti,selesai'],
        ], [
            'tujuan_disposisi.required' => 'Tujuan disposisi wajib diisi.',
            'instruksi.required' => 'Instruksi disposisi wajib diisi.',
            'status.in' => 'Status disposisi tidak valid.',
        ]);

        $disposisi->update($validated);

        LogAktivitas::catat(
            'UBAH_DISPOSISI',
            'DISPOSISI',
            "Kepala Sekolah memperbarui lembar disposisi ID #{$disposisi->id} (Surat: {$disposisi->suratMasuk->nomor_agenda}).",
            auth()->id()
        );

        return redirect()
            ->route('kepsek.disposisi.show', $disposisi)
            ->with('success', 'Data lembar disposisi berhasil diperbarui.');
    }

    /**
     * Hapus lembar disposisi.
     */
    public function destroy(DisposisiSuratMasuk $disposisi): RedirectResponse
    {
        $suratMasuk = $disposisi->suratMasuk;
        $nomorAgenda = $suratMasuk->nomor_agenda;

        $disposisi->delete();

        // Jika surat masuk tidak lagi memiliki lembar disposisi, kembalikan statusnya ke 'diterima'
        if ($suratMasuk->disposisi()->count() === 0) {
            $suratMasuk->update(['status' => 'diterima']);
        }

        LogAktivitas::catat(
            'HAPUS_DISPOSISI',
            'DISPOSISI',
            "Lembar disposisi untuk surat {$nomorAgenda} dihapus oleh Kepala Sekolah.",
            auth()->id()
        );

        return redirect()
            ->route('kepsek.disposisi.index')
            ->with('success', 'Lembar disposisi berhasil dihapus.');
    }

    /**
     * Perbarui status tindak lanjut disposisi (bisa dilakukan Admin atau Kepsek).
     */
    public function updateStatus(Request $request, DisposisiSuratMasuk $disposisi): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:menunggu,ditindaklanjuti,selesai'],
        ]);

        $disposisi->update([
            'status' => $validated['status'],
        ]);

        $statusLabel = match ($validated['status']) {
            'menunggu' => 'Menunggu Tindak Lanjut',
            'ditindaklanjuti' => 'Sedang Ditindaklanjuti',
            'selesai' => 'Selesai Dilaksanakan',
            default => $validated['status']
        };

        LogAktivitas::catat(
            'UPDATE_STATUS_DISPOSISI',
            'DISPOSISI',
            "Status disposisi ID #{$disposisi->id} diubah menjadi '{$statusLabel}' oleh ".auth()->user()->name.'.',
            auth()->id()
        );

        return back()->with('success', "Status disposisi berhasil diubah menjadi: {$statusLabel}.");
    }

    /**
     * Tampilan cetak lembar disposisi resmi instansi SMKN 1 Subang (SRS-KS06).
     */
    public function cetak(DisposisiSuratMasuk $disposisi): View
    {
        $disposisi->load(['suratMasuk.kategori', 'pemberi']);

        return view('disposisi.cetak', compact('disposisi'));
    }
}
