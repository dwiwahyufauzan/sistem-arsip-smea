<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use App\Models\LogAktivitas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriSuratController extends Controller
{
    /**
     * Menampilkan daftar kategori klasifikasi surat dinas SMKN 1 Subang
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('q', ''));

        $query = KategoriSurat::withCount(['suratMasuk', 'suratKeluar'])
            ->orderBy('kode_kategori', 'asc');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('kode_kategori', 'like', "%{$search}%")
                    ->orWhere('nama_kategori', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $kategoriList = $query->paginate(10)->withQueryString();

        return view('admin.kategori.index', compact('kategoriList', 'search'));
    }

    /**
     * Menyimpan kategori klasifikasi baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_kategori' => ['required', 'string', 'max:50', 'unique:kategori_surat,kode_kategori'],
            'nama_kategori' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ], [
            'kode_kategori.required' => 'Kode kategori wajib diisi.',
            'kode_kategori.unique' => 'Kode kategori klasifikasi ini sudah digunakan.',
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
        ]);

        $kategori = KategoriSurat::create($validated);

        LogAktivitas::catat(
            'TAMBAH_KATEGORI',
            'KATEGORI',
            "Menambahkan kategori klasifikasi arsip baru: {$kategori->kode_kategori} ({$kategori->nama_kategori})"
        );

        return redirect()->route('admin.kategori.index')
            ->with('success', "Kategori klasifikasi {$kategori->kode_kategori} berhasil ditambahkan ke sistem.");
    }

    /**
     * Memperbarui kategori klasifikasi surat
     */
    public function update(Request $request, KategoriSurat $kategori): RedirectResponse
    {
        $validated = $request->validate([
            'kode_kategori' => ['required', 'string', 'max:50', 'unique:kategori_surat,kode_kategori,'.$kategori->id],
            'nama_kategori' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:500'],
        ], [
            'kode_kategori.required' => 'Kode kategori wajib diisi.',
            'kode_kategori.unique' => 'Kode kategori klasifikasi ini sudah digunakan.',
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
        ]);

        $kategori->update($validated);

        LogAktivitas::catat(
            'UBAH_KATEGORI',
            'KATEGORI',
            "Memperbarui data kategori arsip: {$kategori->kode_kategori}"
        );

        return redirect()->route('admin.kategori.index')
            ->with('success', "Kategori klasifikasi {$kategori->kode_kategori} berhasil diperbarui.");
    }

    /**
     * Menghapus kategori klasifikasi surat (dengan proteksi integritas relasi)
     */
    public function destroy(KategoriSurat $kategori): RedirectResponse
    {
        $smCount = $kategori->suratMasuk()->count();
        $skCount = $kategori->suratKeluar()->count();

        if ($smCount > 0 || $skCount > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', "Kategori {$kategori->kode_kategori} tidak dapat dihapus karena masih digunakan oleh {$smCount} arsip surat masuk dan {$skCount} surat keluar.");
        }

        $kode = $kategori->kode_kategori;
        $kategori->delete();

        LogAktivitas::catat(
            'HAPUS_KATEGORI',
            'KATEGORI',
            "Menghapus kategori arsip: {$kode}"
        );

        return redirect()->route('admin.kategori.index')
            ->with('success', "Kategori klasifikasi {$kode} berhasil dihapus dari sistem.");
    }
}
