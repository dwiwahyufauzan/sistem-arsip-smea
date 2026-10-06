<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use App\Models\LogAktivitas;
use App\Models\SuratMasuk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SuratMasukController extends Controller
{
    /**
     * Tampilkan daftar arsip Surat Masuk untuk Petugas TU / Admin
     */
    public function index(Request $request): View
    {
        $query = SuratMasuk::with(['kategori', 'user'])->withCount('disposisi');

        // Filter Pencarian Teks
        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_agenda', 'like', "%{$keyword}%")
                    ->orWhere('nomor_surat', 'like', "%{$keyword}%")
                    ->orWhere('pengirim', 'like', "%{$keyword}%")
                    ->orWhere('perihal', 'like', "%{$keyword}%")
                    ->orWhere('isi_ringkas', 'like', "%{$keyword}%");
            });
        }

        // Filter Kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Rentang Tanggal Terima
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_terima', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_terima', '<=', $request->tanggal_selesai);
        }

        $suratMasukList = $query->orderBy('tanggal_terima', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Statistik ringkas untuk kartu indikator
        $statistik = [
            'total' => SuratMasuk::count(),
            'diterima' => SuratMasuk::where('status', 'diterima')->count(),
            'didisposisikan' => SuratMasuk::where('status', 'didisposisikan')->count(),
            'diarsipkan' => SuratMasuk::where('status', 'diarsipkan')->count(),
        ];

        $kategoriList = KategoriSurat::orderBy('nama_kategori')->get();

        return view('admin.surat-masuk.index', compact('suratMasukList', 'statistik', 'kategoriList'));
    }

    /**
     * Tampilkan formulir pencatatan Surat Masuk baru
     */
    public function create(): View
    {
        $kategoriList = KategoriSurat::orderBy('kode_kategori')->get();
        $nomorAgendaOtomatis = $this->generateNomorAgenda();

        return view('admin.surat-masuk.create', compact('kategoriList', 'nomorAgendaOtomatis'));
    }

    /**
     * Simpan data surat masuk baru beserta unggahan berkas fisik scan
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_agenda' => ['required', 'string', 'max:50', 'unique:surat_masuk,nomor_agenda'],
            'nomor_surat' => ['required', 'string', 'max:100'],
            'tanggal_surat' => ['required', 'date'],
            'tanggal_terima' => ['required', 'date'],
            'pengirim' => ['required', 'string', 'max:255'],
            'penerima' => ['nullable', 'string', 'max:255'],
            'perihal' => ['required', 'string', 'max:255'],
            'isi_ringkas' => ['nullable', 'string', 'max:1000'],
            'kategori_id' => ['required', 'exists:kategori_surat,id'],
            'berkas' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // Maks 5MB sesuai SRS-P02
        ], [
            'nomor_agenda.required' => 'Nomor agenda wajib diisi.',
            'nomor_agenda.unique' => 'Nomor agenda ini sudah terdaftar sebelumnya.',
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi.',
            'tanggal_terima.required' => 'Tanggal terima surat wajib diisi.',
            'pengirim.required' => 'Instansi/nama pengirim surat wajib diisi.',
            'perihal.required' => 'Perihal surat wajib diisi.',
            'kategori_id.required' => 'Kategori klasifikasi surat wajib dipilih.',
            'kategori_id.exists' => 'Kategori surat tidak valid.',
            'berkas.required' => 'Berkas scan surat wajib diunggah.',
            'berkas.mimes' => 'Berkas harus berupa dokumen PDF atau gambar (JPG/PNG).',
            'berkas.max' => 'Ukuran berkas tidak boleh melebihi 5 MB.',
        ]);

        $file = $request->file('berkas');
        $fileName = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $filePath = $file->storeAs('dokumen-surat-masuk', $fileName, 'public');

        $suratMasuk = SuratMasuk::create([
            'nomor_agenda' => $validated['nomor_agenda'],
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'tanggal_terima' => $validated['tanggal_terima'],
            'pengirim' => $validated['pengirim'],
            'penerima' => ! empty($validated['penerima']) ? $validated['penerima'] : 'Kepala SMKN 1 Subang',
            'perihal' => $validated['perihal'],
            'isi_ringkas' => $validated['isi_ringkas'] ?? null,
            'kategori_id' => $validated['kategori_id'],
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'status' => 'diterima',
            'user_id' => auth()->id(),
        ]);

        LogAktivitas::catat(
            'TAMBAH_SURAT_MASUK',
            'SURAT_MASUK',
            "Mencatat Surat Masuk baru No: {$suratMasuk->nomor_surat} (Agenda: {$suratMasuk->nomor_agenda}) dari {$suratMasuk->pengirim}"
        );

        return redirect()->route('admin.surat-masuk.show', $suratMasuk)
            ->with('success', 'Surat Masuk baru berhasil dicatat dan diarsipkan ke dalam sistem.');
    }

    /**
     * Tampilkan detail surat masuk, pratinjau dokumen, dan lembar disposisi
     */
    public function show(SuratMasuk $surat_masuk): View
    {
        $surat_masuk->load(['kategori', 'user', 'disposisi.pemberi']);

        return view('admin.surat-masuk.show', compact('surat_masuk'));
    }

    /**
     * Cetak lembar kendali arsip surat masuk standar kedinasan
     */
    public function cetak(SuratMasuk $surat_masuk): View
    {
        $surat_masuk->load(['kategori', 'user', 'disposisi.pemberi']);

        return view('admin.surat-masuk.cetak', compact('surat_masuk'));
    }

    /**
     * Tampilkan form edit metadata surat masuk
     */
    public function edit(SuratMasuk $surat_masuk): View
    {
        $kategoriList = KategoriSurat::orderBy('kode_kategori')->get();

        return view('admin.surat-masuk.edit', compact('surat_masuk', 'kategoriList'));
    }

    /**
     * Perbarui metadata surat masuk dan opsi penggantian berkas lampiran
     */
    public function update(Request $request, SuratMasuk $surat_masuk): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_agenda' => ['required', 'string', 'max:50', 'unique:surat_masuk,nomor_agenda,'.$surat_masuk->id],
            'nomor_surat' => ['required', 'string', 'max:100'],
            'tanggal_surat' => ['required', 'date'],
            'tanggal_terima' => ['required', 'date'],
            'pengirim' => ['required', 'string', 'max:255'],
            'penerima' => ['nullable', 'string', 'max:255'],
            'perihal' => ['required', 'string', 'max:255'],
            'isi_ringkas' => ['nullable', 'string', 'max:1000'],
            'kategori_id' => ['required', 'exists:kategori_surat,id'],
            'status' => ['required', 'in:diterima,didisposisikan,diarsipkan'],
            'berkas' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ], [
            'nomor_agenda.required' => 'Nomor agenda wajib diisi.',
            'nomor_agenda.unique' => 'Nomor agenda ini sudah terdaftar pada surat lain.',
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'berkas.mimes' => 'Berkas pengganti harus berupa dokumen PDF atau gambar (JPG/PNG).',
            'berkas.max' => 'Ukuran berkas pengganti tidak boleh melebihi 5 MB.',
        ]);

        $updateData = [
            'nomor_agenda' => $validated['nomor_agenda'],
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'tanggal_terima' => $validated['tanggal_terima'],
            'pengirim' => $validated['pengirim'],
            'penerima' => ! empty($validated['penerima']) ? $validated['penerima'] : 'Kepala SMKN 1 Subang',
            'perihal' => $validated['perihal'],
            'isi_ringkas' => $validated['isi_ringkas'] ?? null,
            'kategori_id' => $validated['kategori_id'],
            'status' => $validated['status'],
        ];

        // Jika ada unggahan berkas baru, hapus berkas fisik lama dan simpan yang baru
        if ($request->hasFile('berkas')) {
            if ($surat_masuk->file_path && Storage::disk('public')->exists($surat_masuk->file_path)) {
                Storage::disk('public')->delete($surat_masuk->file_path);
            }

            $newFile = $request->file('berkas');
            $fileName = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $newFile->getClientOriginalName());
            $filePath = $newFile->storeAs('dokumen-surat-masuk', $fileName, 'public');

            $updateData['file_path'] = $filePath;
            $updateData['file_name'] = $newFile->getClientOriginalName();
            $updateData['file_size'] = $newFile->getSize();
        }

        $surat_masuk->update($updateData);

        LogAktivitas::catat(
            'UPDATE_SURAT_MASUK',
            'SURAT_MASUK',
            "Memperbarui data Surat Masuk No: {$surat_masuk->nomor_surat} (Agenda: {$surat_masuk->nomor_agenda})"
        );

        return redirect()->route('admin.surat-masuk.show', $surat_masuk)
            ->with('success', 'Data Surat Masuk berhasil diperbarui.');
    }

    /**
     * Hapus arsip surat masuk dan berkas scan fisik dari storage
     */
    public function destroy(SuratMasuk $surat_masuk): RedirectResponse
    {
        $nomorSurat = $surat_masuk->nomor_surat;
        $nomorAgenda = $surat_masuk->nomor_agenda;

        // Karena menggunakan SoftDeletes, record dipindahkan ke arsip inaktif dan file fisik dipertahankan
        $surat_masuk->delete();

        LogAktivitas::catat(
            'HAPUS_SURAT_MASUK',
            'SURAT_MASUK',
            "Memindahkan ke arsip inaktif (Soft Delete) Surat Masuk No: {$nomorSurat} (Agenda: {$nomorAgenda})"
        );

        return redirect()->route('admin.surat-masuk.index')
            ->with('success', "Surat Masuk No: {$nomorSurat} berhasil dipindahkan ke arsip inaktif.");
    }

    /**
     * Unduh berkas fisik surat masuk
     */
    public function download(SuratMasuk $surat_masuk): StreamedResponse|RedirectResponse
    {
        if (! $surat_masuk->file_path || ! Storage::disk('public')->exists($surat_masuk->file_path)) {
            return back()->with('error', 'Berkas fisik dokumen tidak ditemukan pada penyimpanan server.');
        }

        return Storage::disk('public')->download($surat_masuk->file_path, $surat_masuk->file_name);
    }

    /**
     * Pemantauan Surat Masuk untuk Kepala Sekolah (SRS-KS02)
     */
    public function indexKepsek(Request $request): View
    {
        $query = SuratMasuk::with(['kategori', 'user'])->withCount('disposisi');

        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_agenda', 'like', "%{$keyword}%")
                    ->orWhere('nomor_surat', 'like', "%{$keyword}%")
                    ->orWhere('pengirim', 'like', "%{$keyword}%")
                    ->orWhere('perihal', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $suratMasukList = $query->orderBy('tanggal_terima', 'desc')->paginate(10)->withQueryString();

        $statistik = [
            'total' => SuratMasuk::count(),
            'perlu_disposisi' => SuratMasuk::where('status', 'diterima')->count(),
            'sudah_disposisi' => SuratMasuk::where('status', 'didisposisikan')->count(),
        ];

        $kategoriList = KategoriSurat::orderBy('nama_kategori')->get();

        return view('kepsek.surat-masuk.index', compact('suratMasukList', 'statistik', 'kategoriList'));
    }

    /**
     * Tinjauan Surat Masuk untuk Kepala Sekolah (SRS-KS02)
     */
    public function showKepsek(SuratMasuk $surat_masuk): View
    {
        $surat_masuk->load(['kategori', 'user', 'disposisi.pemberi']);

        return view('kepsek.surat-masuk.show', compact('surat_masuk'));
    }

    /**
     * Generator otomatis Nomor Agenda dengan format SM/YYYY/XXX
     */
    private function generateNomorAgenda(): string
    {
        $tahun = date('Y');
        $prefix = "SM/{$tahun}/";

        $lastSurat = SuratMasuk::withTrashed()
            ->where('nomor_agenda', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastSurat) {
            $parts = explode('/', $lastSurat->nomor_agenda);
            $lastNumber = isset($parts[2]) ? (int) $parts[2] : 0;
            $nextNumber = str_pad((string) ($lastNumber + 1), 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        return "{$prefix}{$nextNumber}";
    }
}
