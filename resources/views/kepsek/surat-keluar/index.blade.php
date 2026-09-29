@extends('layouts.kepsek')

@section('title', 'Persetujuan Surat Keluar')

@section('content')
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-800 uppercase tracking-wider mb-1">
                <span>Panel Kebijakan Pimpinan</span>
                <span>•</span>
                <span>SRS-KS03</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Persetujuan & Tinjauan Surat Keluar</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Tinjauan draf surat dinas yang diajukan staf Tata Usaha sebelum diterbitkan dan dikirimkan ke pihak eksternal.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <span class="px-3 py-1.5 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl text-xs font-semibold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-700 animate-pulse"></span>
                <span>Wewenang Otorisasi Pimpinan</span>
            </span>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Total Surat Keluar</p>
                <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mt-0.5">{{ number_format($statistik['total']) }}</h3>
            </div>
        </div>

        <!-- Card 2: Menunggu Persetujuan -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Menunggu Persetujuan</p>
                <h3 class="text-xl sm:text-2xl font-bold text-amber-600 mt-0.5">{{ number_format($statistik['menunggu']) }}</h3>
            </div>
        </div>

        <!-- Card 3: Disetujui -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Telah Disetujui</p>
                <h3 class="text-xl sm:text-2xl font-bold text-emerald-800 mt-0.5">{{ number_format($statistik['disetujui']) }}</h3>
            </div>
        </div>

        <!-- Card 4: Ditolak / Revisi -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Memerlukan Revisi</p>
                <h3 class="text-xl sm:text-2xl font-bold text-rose-600 mt-0.5">{{ number_format($statistik['ditolak']) }}</h3>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('kepsek.surat-keluar.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-5 relative">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nomor surat, tujuan, atau perihal..."
                    class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <div class="md:col-span-4">
                <select name="status_persetujuan" class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-emerald-600 text-slate-700">
                    <option value="">Semua Status Persetujuan</option>
                    <option value="menunggu_persetujuan" {{ request('status_persetujuan') === 'menunggu_persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="disetujui" {{ request('status_persetujuan') === 'disetujui' ? 'selected' : '' }}>Telah Disetujui</option>
                    <option value="ditolak" {{ request('status_persetujuan') === 'ditolak' ? 'selected' : '' }}>Ditolak / Perlu Revisi</option>
                    <option value="draft" {{ request('status_persetujuan') === 'draft' ? 'selected' : '' }}>Draf Konsep TU</option>
                </select>
            </div>

            <div class="md:col-span-3 flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 px-4 bg-emerald-800 hover:bg-emerald-900 text-white rounded-xl text-xs font-semibold transition-colors flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Filter</span>
                </button>
                @if(request()->hasAny(['search', 'status_persetujuan', 'kategori_id']))
                    <a href="{{ route('kepsek.surat-keluar.index') }}" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors">
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
                        <th class="py-3.5 px-4">Agenda & Tanggal</th>
                        <th class="py-3.5 px-4">Nomor & Tujuan Surat</th>
                        <th class="py-3.5 px-4">Perihal & Klasifikasi</th>
                        <th class="py-3.5 px-4">Status Persetujuan</th>
                        <th class="py-3.5 px-4">Draf Berkas</th>
                        <th class="py-3.5 px-4 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($suratKeluarList as $sk)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                <span class="font-mono font-bold text-slate-900 bg-slate-100 px-2 py-0.5 rounded border border-slate-200 block w-max">
                                    {{ $sk->nomor_agenda }}
                                </span>
                                <span class="text-[10px] text-slate-400 mt-1 block">
                                    {{ $sk->tanggal_surat->isoFormat('D MMM Y') }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 align-top">
                                <div class="font-semibold text-slate-900 leading-snug">{{ $sk->nomor_surat }}</div>
                                <div class="text-slate-600 mt-0.5 text-xs truncate max-w-[200px]">{{ $sk->tujuan }}</div>
                            </td>

                            <td class="py-3.5 px-4 align-top">
                                <p class="font-medium text-slate-900 line-clamp-2 max-w-[260px]" title="{{ $sk->perihal }}">
                                    {{ $sk->perihal }}
                                </p>
                                <span class="mt-1 inline-block px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-700">
                                    {{ $sk->kategori->kode_kategori }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                <x-status-badge :status="$sk->status_persetujuan" />
                            </td>

                            <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                @if($sk->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($sk->file_path))
                                    <button 
                                        type="button" 
                                        onclick="window.openPdfModal('{{ asset('storage/' . $sk->file_path) }}', 'Surat Keluar: {{ addslashes($sk->nomor_surat) }}')"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-semibold transition-colors"
                                    >
                                        <svg class="w-3.5 h-3.5 text-emerald-800" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                        <span>Pratinjau</span>
                                    </button>
                                @else
                                    <span class="text-slate-400 italic">Tidak ada</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 align-top text-right whitespace-nowrap">
                                <a href="{{ route('kepsek.surat-keluar.show', $sk) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-800 hover:bg-emerald-900 text-white rounded-xl text-xs font-semibold transition-colors shadow-xs">
                                    <span>Tinjau</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500 text-xs">
                                Belum ada berkas surat keluar dalam antrean pimpinan.
                            </td>
                        </tr>
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
@endsection
