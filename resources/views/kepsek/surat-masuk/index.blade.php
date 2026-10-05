@extends('layouts.kepsek')

@section('title', 'Pemantauan Surat Masuk')

@section('content')
<div class="space-y-6">

    <!-- Modern Page Header -->
    <x-page-header 
        title="Pemantauan Surat Masuk" 
        subtitle="Tinjauan surat dinas eksternal yang masuk ke SMKN 1 Subang untuk arahan disposisi tindak lanjut."
        overline="Panel Kebijakan Pimpinan • SRS-KS02"
    >
        <x-slot:actions>
            <span class="px-3.5 py-1.5 bg-emerald-50 text-emerald-800 border border-emerald-200/80 rounded-xl text-xs font-semibold flex items-center gap-2 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                <span>Pimpinan SMKN 1 Subang</span>
            </span>
        </x-slot:actions>
    </x-page-header>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-stat-card 
            label="Total Surat Masuk" 
            :value="number_format($statistik['total'])" 
            description="Seluruh arsip dinas tercatat" 
            color="emerald"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card 
            label="Perlu Disposisi" 
            :value="number_format($statistik['perlu_disposisi'])" 
            description="Menunggu arahan instruksi" 
            color="amber"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card 
            label="Sudah Didisposisi" 
            :value="number_format($statistik['sudah_disposisi'])" 
            description="Instruksi telah diteruskan" 
            color="teal"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-stat-card>
    </div>

    <!-- Filter & Search Bar -->
    <div class="card-modern p-5">
        <form action="{{ route('kepsek.surat-masuk.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-5 relative">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nomor surat, agenda, atau perihal..."
                    class="input-modern w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <div class="md:col-span-4">
                <select name="status" class="input-modern w-full px-3 py-2.5 text-xs sm:text-sm text-slate-700">
                    <option value="">Semua Status Disposisi</option>
                    <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Perlu Disposisi (Diterima)</option>
                    <option value="didisposisikan" {{ request('status') === 'didisposisikan' ? 'selected' : '' }}>Sudah Didisposisikan</option>
                    <option value="diarsipkan" {{ request('status') === 'diarsipkan' ? 'selected' : '' }}>Diarsipkan</option>
                </select>
            </div>

            <div class="md:col-span-3 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 px-4 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-semibold transition-all shadow-xs flex items-center justify-center gap-1.5 active:scale-[0.99]">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Terapkan</span>
                </button>
                @if(request()->hasAny(['search', 'status', 'kategori_id']))
                    <a href="{{ route('kepsek.surat-masuk.index') }}" class="py-2.5 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="card-modern overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-4">Agenda & Status</th>
                        <th class="py-3.5 px-4">Nomor & Pengirim</th>
                        <th class="py-3.5 px-4">Perihal & Klasifikasi</th>
                        <th class="py-3.5 px-4">Dokumen Scan</th>
                        <th class="py-3.5 px-4 text-center">Disposisi</th>
                        <th class="py-3.5 px-4 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($suratMasukList as $sm)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                <span class="font-mono font-bold text-slate-900 bg-slate-100 px-2 py-0.5 rounded border border-slate-200 block w-max">
                                    {{ $sm->nomor_agenda }}
                                </span>
                                <div class="mt-1.5">
                                    <x-status-badge :status="$sm->status" />
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1 block">
                                    {{ $sm->tanggal_terima->isoFormat('D MMM Y') }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 align-top">
                                <div class="font-semibold text-slate-900 leading-snug">{{ $sm->nomor_surat }}</div>
                                <div class="text-slate-600 mt-0.5 text-xs truncate max-w-[200px]">{{ $sm->pengirim }}</div>
                                <span class="text-[10px] text-slate-400 block mt-0.5">Tgl: {{ $sm->tanggal_surat->isoFormat('D MMM Y') }}</span>
                            </td>

                            <td class="py-3.5 px-4 align-top">
                                <p class="font-medium text-slate-900 line-clamp-2 max-w-[280px]" title="{{ $sm->perihal }}">
                                    {{ $sm->perihal }}
                                </p>
                                <span class="mt-1 inline-block px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-700">
                                    {{ $sm->kategori->kode_kategori }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                @if($sm->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($sm->file_path))
                                    <button 
                                        type="button" 
                                        onclick="window.openPdfModal('{{ asset('storage/' . $sm->file_path) }}', 'Surat Masuk: {{ addslashes($sm->nomor_surat) }}')"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-semibold transition-colors"
                                    >
                                        <svg class="w-3.5 h-3.5 text-emerald-800" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                        <span>Lihat Scan</span>
                                    </button>
                                @else
                                    <span class="text-slate-400 italic">Tidak ada</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 align-top text-center whitespace-nowrap">
                                @if($sm->disposisi_count > 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ $sm->disposisi_count }} Arahan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold text-amber-700 bg-amber-50 border border-amber-200">
                                        Perlu Disposisi
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 align-top text-right whitespace-nowrap">
                                <a href="{{ route('kepsek.surat-masuk.show', $sm) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-semibold transition-all shadow-xs active:scale-[0.98]">
                                    <span>Tinjau</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <x-empty-state 
                            colspan="6" 
                            title="Belum Ada Surat Masuk" 
                            description="Belum ada arsip surat masuk yang memerlukan tindak lanjut." 
                        />
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suratMasukList->hasPages())
            <div class="px-5 py-3.5 bg-slate-50/75 border-t border-slate-200">
                {{ $suratMasukList->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
