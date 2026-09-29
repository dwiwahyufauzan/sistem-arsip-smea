@extends('layouts.admin')

@section('title', 'Kategori Surat')

@section('page_title', 'Master Klasifikasi Kategori Surat')
@section('page_subtitle', 'Pengelolaan kode klasifikasi standar kearsipan dinas SMKN 1 Subang')

@section('page_actions')
    <button 
        type="button" 
        onclick="openCreateKategoriModal()"
        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-xs transition-colors cursor-pointer"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Tambah Kategori</span>
    </button>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Search & Filter Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3">
        <form action="{{ route('admin.kategori.index') }}" method="GET" class="relative w-full sm:w-80">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input 
                type="text" 
                name="q" 
                value="{{ $search }}" 
                placeholder="Cari kode atau nama kategori..." 
                class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all"
            >
        </form>

        <div class="text-xs text-slate-500 font-medium">
            Total Klasifikasi Terdaftar: <span class="font-bold text-slate-900">{{ $kategoriList->total() }}</span>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-4">No</th>
                        <th class="py-3.5 px-4">Kode Klasifikasi</th>
                        <th class="py-3.5 px-4">Nama Klasifikasi Kategori</th>
                        <th class="py-3.5 px-4">Deskripsi / Cakupan</th>
                        <th class="py-3.5 px-4 text-center">Arsip Terkait</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($kategoriList as $index => $kat)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 font-mono text-slate-400">
                                {{ $kategoriList->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-blue-900 text-sm">
                                {{ $kat->kode_kategori }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-900">
                                {{ $kat->nama_kategori }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 max-w-xs truncate" title="{{ $kat->deskripsi }}">
                                {{ $kat->deskripsi ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-800 border border-blue-200" title="Jumlah Surat Masuk">
                                        {{ $kat->surat_masuk_count }} Masuk
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-50 text-teal-800 border border-teal-200" title="Jumlah Surat Keluar">
                                        {{ $kat->surat_keluar_count }} Keluar
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-1.5 whitespace-nowrap">
                                <button 
                                    type="button" 
                                    onclick="openEditKategoriModal({{ json_encode($kat) }})"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-slate-700 bg-slate-100 hover:bg-blue-100 hover:text-blue-900 font-semibold transition-colors cursor-pointer"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>Ubah</span>
                                </button>

                                <form action="{{ route('admin.kategori.destroy', $kat) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $kat->kode_kategori }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-rose-700 bg-rose-50 hover:bg-rose-100 font-semibold transition-colors cursor-pointer"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                Tidak ada data klasifikasi kategori surat yang cocok dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kategoriList->hasPages())
            <div class="px-5 py-4 border-t border-slate-200 bg-slate-50/50">
                {{ $kategoriList->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Tambah Kategori -->
<div id="createKategoriModal" class="fixed inset-0 z-50 hidden transition-opacity">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs" onclick="closeCreateKategoriModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 relative text-slate-800">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h3 class="font-heading font-bold text-base text-slate-900">Tambah Kategori Klasifikasi Baru</h3>
                <button type="button" onclick="closeCreateKategoriModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('admin.kategori.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Kategori Klasifikasi <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        name="kode_kategori" 
                        required 
                        placeholder="Contoh: 421.5/KUR" 
                        class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600 font-mono"
                    >
                    <p class="text-[10px] text-slate-400 mt-1">Gunakan format standar kearsipan dinas pendidikan.</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        name="nama_kategori" 
                        required 
                        placeholder="Contoh: Kurikulum & Pembelajaran" 
                        class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Cakupan</label>
                    <textarea 
                        name="deskripsi" 
                        rows="3" 
                        placeholder="Keterangan jenis surat yang masuk dalam klasifikasi ini..." 
                        class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    ></textarea>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeCreateKategoriModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-xs transition-colors">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah Kategori -->
<div id="editKategoriModal" class="fixed inset-0 z-50 hidden transition-opacity">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs" onclick="closeEditKategoriModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 relative text-slate-800">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h3 class="font-heading font-bold text-base text-slate-900">Ubah Kategori Klasifikasi</h3>
                <button type="button" onclick="closeEditKategoriModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="editKategoriForm" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Kategori Klasifikasi <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        id="editKodeKategori"
                        name="kode_kategori" 
                        required 
                        class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600 font-mono"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        id="editNamaKategori"
                        name="nama_kategori" 
                        required 
                        class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Cakupan</label>
                    <textarea 
                        id="editDeskripsi"
                        name="deskripsi" 
                        rows="3" 
                        class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600"
                    ></textarea>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeEditKategoriModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-xs transition-colors">
                        Perbarui Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateKategoriModal() {
        document.getElementById('createKategoriModal').classList.remove('hidden');
    }
    function closeCreateKategoriModal() {
        document.getElementById('createKategoriModal').classList.add('hidden');
    }

    function openEditKategoriModal(kategori) {
        const modal = document.getElementById('editKategoriModal');
        const form = document.getElementById('editKategoriForm');
        form.action = `/admin/kategori/${kategori.id}`;

        document.getElementById('editKodeKategori').value = kategori.kode_kategori;
        document.getElementById('editNamaKategori').value = kategori.nama_kategori;
        document.getElementById('editDeskripsi').value = kategori.deskripsi || '';

        modal.classList.remove('hidden');
    }
    function closeEditKategoriModal() {
        document.getElementById('editKategoriModal').classList.add('hidden');
    }
</script>
@endsection
