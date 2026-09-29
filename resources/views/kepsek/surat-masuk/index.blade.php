@extends('layouts.kepsek')

@section('title', 'Pemantauan Surat Masuk')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-800 uppercase tracking-wider mb-1">
                <span>Panel Kebijakan Pimpinan</span>
                <span>•</span>
                <span>SRS-KS02</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Pemantauan Surat Masuk</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Tinjauan surat dinas eksternal yang masuk ke SMKN 1 Subang untuk arahan disposisi tindak lanjut.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <span class="px-3 py-1.5 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl text-xs font-semibold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-700 animate-pulse"></span>
                <span>Pimpinan SMKN 1 Subang</span>
            </span>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Card 1 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Total Surat Masuk</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-0.5">{{ number_format($statistik['total']) }}</h3>
                <span class="text-[10px] text-slate-400">Seluruh arsip dinas</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Perlu Disposisi</p>
                <h3 class="text-2xl font-bold text-amber-600 mt-0.5">{{ number_format($statistik['perlu_disposisi']) }}</h3>
                <span class="text-[10px] text-amber-700/80">Menunggu arahan instruksi</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Sudah Didisposisi</p>
                <h3 class="text-2xl font-bold text-emerald-800 mt-0.5">{{ number_format($statistik['sudah_disposisi']) }}</h3>
                <span class="text-[10px] text-emerald-800/80">Instruksi telah diteruskan</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('kepsek.surat-masuk.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-5 relative">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nomor surat, agenda, atau perihal..."
                    class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <div class="md:col-span-3">
                <select name="status" class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 text-slate-700">
                    <option value="">Semua Status Disposisi</option>
                    <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Perlu Disposisi (Diterima)</option>
                    <option value="didisposisikan" {{ request('status') === 'didisposisikan' ? 'selected' : '' }}>Sudah Didisposisikan</option>
                    <option value="diarsipkan" {{ request('status') === 'diarsipkan' ? 'selected' : '' }}>Diarsipkan</option>
                </select>
            </div>

            <div class="md:col-span-4 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 px-4 bg-emerald-800 hover:bg-emerald-900 text-white rounded-xl text-xs font-semibold transition-colors flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Terapkan Filter</span>
                </button>
                @if(request()->hasAny(['search', 'status', 'kategori_id']))
                    <a href="{{ route('kepsek.surat-masuk.index') }}" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
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
                                <a href="{{ route('kepsek.surat-masuk.show', $sm) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-800 hover:bg-emerald-900 text-white rounded-xl text-xs font-semibold transition-colors shadow-xs">
                                    <span>Tinjau</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500 text-xs">
                                Belum ada arsip surat masuk yang memerlukan tindak lanjut.
                            </td>
                        </tr>
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
