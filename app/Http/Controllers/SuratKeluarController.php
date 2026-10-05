<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use App\Models\LogAktivitas;
use App\Models\SuratKeluar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SuratKeluarController extends Controller
{
    /**
     * Tampilkan daftar arsip Surat Keluar untuk Petugas TU / Admin
     */
    public function index(Request $request): View
    {
        $query = SuratKeluar::with(['kategori', 'user', 'kepsek']);

        // Filter Pencarian Teks
        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_agenda', 'like', "%{$keyword}%")
                    ->orWhere('nomor_surat', 'like', "%{$keyword}%")
                    ->orWhere('tujuan', 'like', "%{$keyword}%")
                    ->orWhere('perihal', 'like', "%{$keyword}%")
                    ->orWhere('isi_ringkas', 'like', "%{$keyword}%");
            });
        }

        // Filter Kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter Status Persetujuan
        if ($request->filled('status_persetujuan')) {
            $query->where('status_persetujuan', $request->status_persetujuan);
        }

        // Filter Rentang Tanggal Surat
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_surat', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal_surat', '<=', $request->tanggal_selesai);
        }

        $suratKeluarList = $query->orderBy('tanggal_surat', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Statistik ringkas status persetujuan
        $statistik = [
            'total' => SuratKeluar::count(),
            'draft' => SuratKeluar::where('status_persetujuan', 'draft')->count(),
            'menunggu' => SuratKeluar::where('status_persetujuan', 'menunggu_persetujuan')->count(),
            'disetujui' => SuratKeluar::where('status_persetujuan', 'disetujui')->count(),
            'ditolak' => SuratKeluar::where('status_persetujuan', 'ditolak')->count(),
        ];

        $kategoriList = KategoriSurat::orderBy('nama_kategori')->get();

        return view('admin.surat-keluar.index', compact('suratKeluarList', 'statistik', 'kategoriList'));
    }

    /**
     * Tampilkan formulir pembuatan konsep/draf Surat Keluar baru
     */
    public function create(): View
    {
        $kategoriList = KategoriSurat::orderBy('kode_kategori')->get();
        $nomorAgendaOtomatis = $this->generateNomorAgenda();

        return view('admin.surat-keluar.create', compact('kategoriList', 'nomorAgendaOtomatis'));
    }

    /**
     * Simpan data surat keluar baru beserta unggahan berkas draf
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_agenda' => ['required', 'string', 'max:50', 'unique:surat_keluar,nomor_agenda'],
            'nomor_surat' => ['required', 'string', 'max:100'],
            'tanggal_surat' => ['required', 'date'],
            'tujuan' => ['required', 'string', 'max:255'],
            'perihal' => ['required', 'string', 'max:255'],
            'isi_ringkas' => ['nullable', 'string', 'max:1000'],
            'kategori_id' => ['required', 'exists:kategori_surat,id'],
            'status_persetujuan' => ['required', 'in:draft,menunggu_persetujuan'],
            'berkas' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // Maks 5MB sesuai NFR-02
        ], [
            'nomor_agenda.required' => 'Nomor agenda wajib diisi.',
            'nomor_agenda.unique' => 'Nomor agenda ini sudah terdaftar sebelumnya.',
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'tanggal_surat.required' => 'Tanggal surat wajib diisi.',
            'tujuan.required' => 'Pihak/instansi tujuan surat wajib diisi.',
            'perihal.required' => 'Perihal surat wajib diisi.',
            'kategori_id.required' => 'Kategori klasifikasi dinas wajib dipilih.',
            'status_persetujuan.required' => 'Status awal surat wajib ditentukan.',
            'berkas.required' => 'Berkas draf/dokumen surat wajib diunggah.',
            'berkas.mimes' => 'Berkas harus berupa dokumen PDF atau gambar (JPG/PNG).',
            'berkas.max' => 'Ukuran berkas tidak boleh melebihi 5 MB.',
        ]);

        $file = $request->file('berkas');
        $fileName = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
        $filePath = $file->storeAs('dokumen-surat-keluar', $fileName, 'public');

        $suratKeluar = SuratKeluar::create([
            'nomor_agenda' => $validated['nomor_agenda'],
            'nomor_surat' => $validated['nomor_surat'],
            'tanggal_surat' => $validated['tanggal_surat'],
            'tujuan' => $validated['tujuan'],
            'perihal' => $validated['perihal'],
            'isi_ringkas' => $validated['isi_ringkas'] ?? null,
            'kategori_id' => $validated['kategori_id'],
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'status_persetujuan' => $validated['status_persetujuan'],
            'user_id' => auth()->id(),
        ]);

        $statusKet = $suratKeluar->status_persetujuan === 'menunggu_persetujuan'
            ? 'dan diajukan ke Kepala Sekolah'
            : 'sebagai Draf Konsep';

        LogAktivitas::catat(
            'TAMBAH_SURAT_KELUAR',
            'SURAT_KELUAR',
            "Membuat Surat Keluar No: {$suratKeluar->nomor_surat} (Agenda: {$suratKeluar->nomor_agenda}) {$statusKet}"
        );

        return redirect()->route('admin.surat-keluar.show', $suratKeluar)
            ->with('success', "Surat Keluar No: {$suratKeluar->nomor_surat} berhasil disimpan {$statusKet}.");
    }

    /**
     * Tampilkan lembar rincian surat keluar dan pratinjau dokumen
     */
    public function show(SuratKeluar $surat_keluar): View
    {
        $surat_keluar->load(['kategori', 'user', 'kepsek']);

        return view('admin.surat-keluar.show', compact('surat_keluar'));
    }

    /**
     * Cetak lembar kendali arsip surat keluar standar kedinasan
     */
    public function cetak(SuratKeluar $surat_keluar): View
    {
        $surat_keluar->load(['kategori', 'user', 'kepsek']);

        return view('admin.surat-keluar.cetak', compact('surat_keluar'));
    }

    /**
     * Tampilkan formulir edit metadata surat keluar
     */
    public function edit(SuratKeluar $surat_keluar): View
    {
        $kategoriList = KategoriSurat::orderBy('kode_kategori')->get();

        return view('admin.surat-keluar.edit', compact('surat_keluar', 'kategoriList'));
    }

    /**
     * Perbarui data surat keluar dan opsi penggantian berkas dokumen
     */
    public function update(Request $request, SuratKeluar $surat_keluar): RedirectResponse
    {
        $validated = $request->validate([
            'nomor_agenda' => ['required', 'string', 'max:50', 'unique:surat_keluar,nomor_agenda,'.$surat_keluar->id],
            'nomor_surat' => ['required', 'string', 'max:100'],
            'tanggal_surat' => ['required', 'date'],
            'tujuan' => ['required', 'string', 'max:255'],
            'perihal' => ['required', 'string', 'max:255'],
            'isi_ringkas' => ['nullable', 'string', 'max:1000'],
            'kategori_id' => ['required', 'exists:kategori_surat,id'],
            'status_persetujuan' => ['required', 'in:draft,menunggu_persetujuan,disetujui,ditolak'],
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
            'tujuan' => $validated['tujuan'],
            'perihal' => $validated['perihal'],
            'isi_ringkas' => $validated['isi_ringkas'] ?? null,
            'kategori_id' => $validated['kategori_id'],
            'status_persetujuan' => $validated['status_persetujuan'],
        ];

        // Jika mengunggah berkas pengganti
        if ($request->hasFile('berkas')) {
            if ($surat_keluar->file_path && Storage::disk('public')->exists($surat_keluar->file_path)) {
                Storage::disk('public')->delete($surat_keluar->file_path);
            }

            $newFile = $request->file('berkas');
            $fileName = time().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '_', $newFile->getClientOriginalName());
            $filePath = $newFile->storeAs('dokumen-surat-keluar', $fileName, 'public');

            $updateData['file_path'] = $filePath;
            $updateData['file_name'] = $newFile->getClientOriginalName();
            $updateData['file_size'] = $newFile->getSize();
        }

        $surat_keluar->update($updateData);

        LogAktivitas::catat(
            'UPDATE_SURAT_KELUAR',
            'SURAT_KELUAR',
            "Memperbarui data Surat Keluar No: {$surat_keluar->nomor_surat} (Agenda: {$surat_keluar->nomor_agenda})"
        );

        return redirect()->route('admin.surat-keluar.show', $surat_keluar)
            ->with('success', 'Data Surat Keluar berhasil diperbarui.');
    }

    /**
     * Hapus arsip surat keluar dan berkas fisiknya dari storage
     */
    public function destroy(SuratKeluar $surat_keluar): RedirectResponse
    {
        $nomorSurat = $surat_keluar->nomor_surat;
        $nomorAgenda = $surat_keluar->nomor_agenda;

        // Karena menggunakan SoftDeletes, record dipindahkan ke arsip inaktif dan file fisik dipertahankan
        $surat_keluar->delete();

        LogAktivitas::catat(
            'HAPUS_SURAT_KELUAR',
            'SURAT_KELUAR',
            "Memindahkan ke arsip inaktif (Soft Delete) Surat Keluar No: {$nomorSurat} (Agenda: {$nomorAgenda})"
        );

        return redirect()->route('admin.surat-keluar.index')
            ->with('success', "Surat Keluar No: {$nomorSurat} berhasil dipindahkan ke arsip inaktif.");
    }

    /**
     * Ajukan surat keluar ke Kepala Sekolah untuk verifikasi & persetujuan
     */
    public function ajukanPersetujuan(SuratKeluar $surat_keluar): RedirectResponse
    {
        $surat_keluar->update([
            'status_persetujuan' => 'menunggu_persetujuan',
        ]);

        LogAktivitas::catat(
            'AJUKAN_SURAT_KELUAR',
            'SURAT_KELUAR',
            "Mengajukan persetujuan Surat Keluar No: {$surat_keluar->nomor_surat} ke Kepala Sekolah"
        );

        return redirect()->route('admin.surat-keluar.show', $surat_keluar)
            ->with('success', "Surat Keluar No: {$surat_keluar->nomor_surat} telah berhasil diajukan ke antrean persetujuan Kepala Sekolah.");
    }

    /**
     * Unduh berkas fisik dokumen surat keluar
     */
    public function download(SuratKeluar $surat_keluar): StreamedResponse|RedirectResponse
    {
        if (! $surat_keluar->file_path || ! Storage::disk('public')->exists($surat_keluar->file_path)) {
            return back()->with('error', 'Berkas fisik dokumen surat keluar tidak ditemukan pada server.');
        }

        return Storage::disk('public')->download($surat_keluar->file_path, $surat_keluar->file_name);
    }

    /**
     * Pemantauan & Antrean Persetujuan Surat Keluar untuk Kepala Sekolah (SRS-KS03)
     */
    public function indexKepsek(Request $request): View
    {
        $query = SuratKeluar::with(['kategori', 'user', 'kepsek']);

        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_agenda', 'like', "%{$keyword}%")
                    ->orWhere('nomor_surat', 'like', "%{$keyword}%")
                    ->orWhere('tujuan', 'like', "%{$keyword}%")
                    ->orWhere('perihal', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status_persetujuan')) {
            $query->where('status_persetujuan', $request->status_persetujuan);
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $suratKeluarList = $query->orderBy('tanggal_surat', 'desc')->paginate(10)->withQueryString();

        $statistik = [
            'total' => SuratKeluar::count(),
            'menunggu' => SuratKeluar::where('status_persetujuan', 'menunggu_persetujuan')->count(),
            'disetujui' => SuratKeluar::where('status_persetujuan', 'disetujui')->count(),
            'ditolak' => SuratKeluar::where('status_persetujuan', 'ditolak')->count(),
        ];

        $kategoriList = KategoriSurat::orderBy('nama_kategori')->get();

        return view('kepsek.surat-keluar.index', compact('suratKeluarList', 'statistik', 'kategoriList'));
    }

    /**
     * Tinjauan draf Surat Keluar untuk Kepala Sekolah (SRS-KS03)
     */
    public function showKepsek(SuratKeluar $surat_keluar): View
    {
        $surat_keluar->load(['kategori', 'user', 'kepsek']);

        return view('kepsek.surat-keluar.show', compact('surat_keluar'));
    }

    /**
     * Generator otomatis Nomor Agenda Surat Keluar: SK/YYYY/XXX
     */
    private function generateNomorAgenda(): string
    {
        $tahun = date('Y');
        $prefix = "SK/{$tahun}/";

        $lastSurat = SuratKeluar::where('nomor_agenda', 'like', "{$prefix}%")
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
