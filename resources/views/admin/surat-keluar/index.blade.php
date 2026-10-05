@extends('layouts.admin')

@section('title', 'Arsip Surat Keluar')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <x-page-header 
        badge="Modul Kearsipan • SRS-P04 / SRS-P05"
        title="Pengelolaan Arsip Surat Keluar"
        description="Pembuatan draf surat dinas resmi, pengunggahan berkas, dan pengajuan persetujuan ke Kepala Sekolah."
    >
        <x-slot:actions>
            <a href="{{ route('admin.surat-keluar.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-sm shadow-blue-500/20 active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Buat Surat Keluar</span>
            </a>
        </x-slot:actions>
    </x-page-header>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <x-stat-card label="Total Surat" :value="number_format($statistik['total'])" color="blue">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card label="Draf Konsep" :value="number_format($statistik['draft'])" color="slate">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card label="Menunggu Kepsek" :value="number_format($statistik['menunggu'])" color="amber">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card label="Disetujui" :value="number_format($statistik['disetujui'])" color="emerald">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card label="Perlu Revisi" :value="number_format($statistik['ditolak'])" color="rose">
            <x-slot:icon>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-stat-card>
    </div>

    <!-- Filter & Pencarian Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.surat-keluar.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                <div class="md:col-span-4 relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nomor surat, agenda, tujuan, atau perihal..."
                        class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <div class="md:col-span-3">
                    <select name="status_persetujuan" class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 text-slate-700">
                        <option value="">Semua Status Persetujuan</option>
                        <option value="draft" {{ request('status_persetujuan') === 'draft' ? 'selected' : '' }}>Draf Konsep</option>
                        <option value="menunggu_persetujuan" {{ request('status_persetujuan') === 'menunggu_persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan Kepsek</option>
                        <option value="disetujui" {{ request('status_persetujuan') === 'disetujui' ? 'selected' : '' }}>Disetujui Kepsek</option>
                        <option value="ditolak" {{ request('status_persetujuan') === 'ditolak' ? 'selected' : '' }}>Ditolak / Perlu Revisi</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <select name="kategori_id" class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 text-slate-700">
                        <option value="">Semua Kategori Klasifikasi</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->kode_kategori }} - {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 flex items-center gap-2">
                    <button type="submit" class="flex-1 py-2 px-4 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold transition-colors flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        <span>Filter</span>
                    </button>
                    @if(request()->hasAny(['search', 'status_persetujuan', 'kategori_id', 'tanggal_mulai', 'tanggal_selesai']))
                        <a href="{{ route('admin.surat-keluar.index') }}" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-slate-100 text-xs text-slate-500">
                <span class="font-medium">Rentang Tanggal Surat:</span>
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="px-2.5 py-1 text-xs rounded-lg border border-slate-200 focus:outline-none focus:border-blue-500">
                <span>s/d</span>
                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="px-2.5 py-1 text-xs rounded-lg border border-slate-200 focus:outline-none focus:border-blue-500">
            </div>
        </form>
    </div>

    <!-- Tabel Data Surat Keluar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-4">Agenda & Tanggal</th>
                        <th class="py-3.5 px-4">Nomor & Tujuan Surat</th>
                        <th class="py-3.5 px-4">Perihal & Klasifikasi</th>
                        <th class="py-3.5 px-4">Status Persetujuan</th>
                        <th class="py-3.5 px-4">Berkas Dokumen</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($suratKeluarList as $sk)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <!-- Kolom 1 -->
                            <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                <span class="font-mono font-bold text-blue-900 bg-blue-50 px-2 py-0.5 rounded border border-blue-200/60 block w-max">
                                    {{ $sk->nomor_agenda }}
                                </span>
                                <span class="text-[10px] text-slate-400 mt-1 block">
                                    Tgl: {{ $sk->tanggal_surat->isoFormat('D MMM Y') }}
                                </span>
                            </td>

                            <!-- Kolom 2 -->
                            <td class="py-3.5 px-4 align-top">
                                <div class="font-semibold text-slate-900 leading-snug">
                                    {{ $sk->nomor_surat }}
                                </div>
                                <div class="text-slate-600 mt-0.5 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <span class="truncate max-w-[200px]" title="{{ $sk->tujuan }}">{{ $sk->tujuan }}</span>
                                </div>
                            </td>

                            <!-- Kolom 3 -->
                            <td class="py-3.5 px-4 align-top">
                                <p class="font-medium text-slate-900 line-clamp-2 max-w-[260px]" title="{{ $sk->perihal }}">
                                    {{ $sk->perihal }}
                                </p>
                                <span class="mt-1 inline-block px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-700">
                                    {{ $sk->kategori->kode_kategori }}
                                </span>
                            </td>

                            <!-- Kolom 4 -->
                            <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                <x-status-badge :status="$sk->status_persetujuan" />
                                @if($sk->catatan_kepsek)
                                    <p class="text-[10px] text-rose-600 italic mt-1 line-clamp-1 max-w-[180px]" title="{{ $sk->catatan_kepsek }}">
                                        Catatan: {{ $sk->catatan_kepsek }}
                                    </p>
                                @endif
                            </td>

                            <!-- Kolom 5 -->
                            <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                @if($sk->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($sk->file_path))
                                    <div class="flex items-center gap-1.5">
                                        <button 
                                            type="button" 
                                            onclick="window.openPdfModal('{{ asset('storage/' . $sk->file_path) }}', 'Surat Keluar: {{ addslashes($sk->nomor_surat) }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/60 rounded-lg text-xs font-semibold transition-colors"
                                        >
                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                            <span>Pratinjau</span>
                                        </button>
                                        <span class="text-[10px] text-slate-400 font-mono">{{ $sk->file_size_formatted }}</span>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">Tidak ada</span>
                                @endif
                            </td>

                            <!-- Kolom 6: Aksi -->
                            <td class="py-3.5 px-4 align-top text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1">
                                    <!-- Ajukan ke Kepsek (jika status draft atau ditolak) -->
                                    @if(in_array($sk->status_persetujuan, ['draft', 'ditolak']))
                                        <form action="{{ route('admin.surat-keluar.ajukan', $sk) }}" method="POST" class="inline">
                                            @csrf
                                            <button 
                                                type="submit" 
                                                class="px-2 py-1 bg-amber-50 hover:bg-amber-100 text-amber-800 rounded-lg text-[11px] font-semibold border border-amber-200 transition-colors inline-flex items-center gap-1"
                                                title="Ajukan ke Kepala Sekolah"
                                            >
                                                <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                                <span>Ajukan</span>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Detail -->
                                    <a href="{{ route('admin.surat-keluar.show', $sk) }}" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.surat-keluar.edit', $sk) }}" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit Metadata / Berkas">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Unduh -->
                                    @if($sk->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($sk->file_path))
                                        <a href="{{ route('admin.surat-keluar.download', $sk) }}" class="p-1.5 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Unduh Berkas">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        </a>
                                    @endif

                                    <!-- Hapus -->
                                    <button 
                                        type="button" 
                                        onclick="openDeleteModal({{ $sk->id }}, '{{ addslashes($sk->nomor_surat) }}', '{{ addslashes($sk->nomor_agenda) }}')" 
                                        class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                        title="Hapus Surat Keluar"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-empty-state 
                            colspan="6"
                            title="Tidak Ada Arsip Surat Keluar"
                            description="Belum ada berkas surat keluar yang tercatat ke dalam sistem."
                            actionText="Buat Draf Surat Baru"
                            :actionUrl="route('admin.surat-keluar.create')"
                        />
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suratKeluarList->hasPages())
            <div class="px-5 py-3.5 bg-slate-50/75 border-t border-slate-200">
                {{ $suratKeluarList->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden transition-opacity duration-200" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity" onclick="closeDeleteModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all duration-200 text-slate-800 animate-in fade-in zoom-in-95">
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="p-6 pb-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 border bg-rose-50 text-rose-600 border-rose-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </div>
                        <div class="flex-grow pt-0.5">
                            <h3 class="font-heading font-bold text-base text-slate-900 leading-snug">Konfirmasi Hapus Surat Keluar</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Pastikan data surat keluar sebelum memproses tindakan ini.</p>
                        </div>
                        <button type="button" onclick="closeDeleteModal()" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer shrink-0" title="Tutup (Esc)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <div class="px-6 pb-5 space-y-3 text-xs">
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 space-y-1">
                        <p class="text-slate-500 text-[11px]">Nomor Surat:</p>
                        <p id="deleteNomorSurat" class="font-bold text-slate-900 font-mono text-xs"></p>
                        <p class="text-slate-500 text-[11px] pt-1">Nomor Agenda: <span id="deleteNomorAgenda" class="font-mono text-blue-900 font-bold"></span></p>
                    </div>

                    <div class="p-3 rounded-xl border text-[11px] leading-relaxed font-medium bg-rose-50/80 text-rose-700 border-rose-100">
                        Data arsip akan dipindahkan ke arsip inaktif (Soft Delete). Dokumen pindaian fisik tetap aman di server.
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors cursor-pointer shadow-2xs">
                        Batal
                    </button>
                    <button type="submit" class="px-4.5 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-xs transition-colors cursor-pointer flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Ya, Hapus Arsip</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(id, nomorSurat, nomorAgenda) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const nomorSuratEl = document.getElementById('deleteNomorSurat');
        const nomorAgendaEl = document.getElementById('deleteNomorAgenda');

        form.action = `/admin/surat-keluar/${id}`;
        nomorSuratEl.textContent = nomorSurat;
        nomorAgendaEl.textContent = nomorAgenda;

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endsection
