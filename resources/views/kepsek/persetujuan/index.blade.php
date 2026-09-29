@extends('layouts.kepsek')

@section('title', 'Persetujuan Surat Keluar')
@section('page_title', 'Persetujuan Surat Keluar')
@section('page_subtitle', 'Tinjauan & Otorisasi Resmi Draf Surat Keluar Dinas SMKN 1 Subang')

@section('content')
<div class="space-y-6">

    <!-- 1. Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Menunggu Persetujuan -->
        <a href="{{ route('kepsek.persetujuan.index', ['status' => 'menunggu_persetujuan']) }}" class="block p-5 bg-white rounded-2xl border transition-all hover:shadow-md {{ $status === 'menunggu_persetujuan' ? 'border-amber-400 ring-2 ring-amber-400/20' : 'border-slate-200/80' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Otorisasi</p>
                    <p class="text-2xl font-extrabold text-amber-600 mt-1 font-heading">{{ $stats['menunggu'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center {{ $stats['menunggu'] > 0 ? 'animate-pulse' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Perlu peninjauan & persetujuan Anda</p>
        </a>

        <!-- Disetujui -->
        <a href="{{ route('kepsek.persetujuan.index', ['status' => 'disetujui']) }}" class="block p-5 bg-white rounded-2xl border transition-all hover:shadow-md {{ $status === 'disetujui' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-slate-200/80' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Telah Disetujui</p>
                    <p class="text-2xl font-extrabold text-emerald-600 mt-1 font-heading">{{ $stats['disetujui'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Surat resmi siap diterbitkan</p>
        </a>

        <!-- Ditolak / Revisi -->
        <a href="{{ route('kepsek.persetujuan.index', ['status' => 'ditolak']) }}" class="block p-5 bg-white rounded-2xl border transition-all hover:shadow-md {{ $status === 'ditolak' ? 'border-rose-400 ring-2 ring-rose-400/20' : 'border-slate-200/80' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Perlu Revisi</p>
                    <p class="text-2xl font-extrabold text-rose-600 mt-1 font-heading">{{ $stats['ditolak'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Ditolak disertai catatan perbaikan</p>
        </a>

        <!-- Total Seluruh Draf -->
        <a href="{{ route('kepsek.persetujuan.index', ['status' => 'semua']) }}" class="block p-5 bg-white rounded-2xl border transition-all hover:shadow-md {{ $status === 'semua' ? 'border-blue-500 ring-2 ring-blue-500/20' : 'border-slate-200/80' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Surat Keluar</p>
                    <p class="text-2xl font-extrabold text-slate-900 mt-1 font-heading">{{ $stats['total'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Rekapitulasi seluruh pengajuan</p>
        </a>
    </div>

    <!-- 2. Filter Tabs & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Status Filter Badges -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 text-xs">
            <a href="{{ route('kepsek.persetujuan.index', ['status' => 'menunggu_persetujuan', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ $status === 'menunggu_persetujuan' ? 'bg-amber-500 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Menunggu ({{ $stats['menunggu'] }})
            </a>
            <a href="{{ route('kepsek.persetujuan.index', ['status' => 'disetujui', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ $status === 'disetujui' ? 'bg-emerald-700 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Disetujui ({{ $stats['disetujui'] }})
            </a>
            <a href="{{ route('kepsek.persetujuan.index', ['status' => 'ditolak', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ $status === 'ditolak' ? 'bg-rose-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Ditolak ({{ $stats['ditolak'] }})
            </a>
            <a href="{{ route('kepsek.persetujuan.index', ['status' => 'semua', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ $status === 'semua' ? 'bg-slate-800 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua Status
            </a>
        </div>

        <!-- Keyword Search Filter -->
        <form action="{{ route('kepsek.persetujuan.index') }}" method="GET" class="flex items-center gap-2 max-w-md w-full">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $search }}" 
                    placeholder="Cari nomor agenda, perihal, atau tujuan..."
                    class="w-full pl-9 pr-8 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all"
                >
                @if($search)
                    <a href="{{ route('kepsek.persetujuan.index', ['status' => $status]) }}" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
            </div>
            <button type="submit" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold shrink-0 transition-colors">
                Cari
            </button>
        </form>
    </div>

    <!-- 3. Letters Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-semibold uppercase text-[11px] tracking-wider">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Agenda & Klasifikasi</th>
                        <th class="py-3.5 px-4">Nomor & Tanggal Surat</th>
                        <th class="py-3.5 px-4">Tujuan Surat</th>
                        <th class="py-3.5 px-4">Perihal</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Dokumen</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($suratKeluars as $index => $sk)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 text-center font-medium text-slate-400">
                                {{ $suratKeluars->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-mono font-bold text-slate-900 block text-xs">{{ $sk->nomor_agenda }}</span>
                                <span class="text-[11px] text-slate-400 mt-0.5 inline-block">{{ $sk->kategori->kode_kategori }} - {{ $sk->kategori->nama_kategori }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-semibold text-slate-800 block">{{ $sk->nomor_surat }}</span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">{{ $sk->tanggal_surat->isoFormat('D MMMM Y') }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-900">
                                {{ $sk->tujuan }}
                            </td>
                            <td class="py-3.5 px-4">
                                <p class="font-medium text-slate-800 line-clamp-1" title="{{ $sk->perihal }}">{{ $sk->perihal }}</p>
                                @if($sk->isi_ringkas)
                                    <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">{{ $sk->isi_ringkas }}</p>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <x-status-badge :status="$sk->status_persetujuan" />
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($sk->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($sk->file_path))
                                    <button 
                                        type="button" 
                                        onclick="window.openPdfModal('{{ asset('storage/' . $sk->file_path) }}', 'Draf: {{ addslashes($sk->nomor_surat) }}')"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-semibold transition-colors"
                                        title="Pratinjau Draf Fisik"
                                    >
                                        <svg class="w-3.5 h-3.5 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                        <span>PDF</span>
                                    </button>
                                @else
                                    <span class="text-slate-400 text-[11px] italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <a 
                                    href="{{ route('kepsek.persetujuan.show', $sk) }}" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 {{ $sk->status_persetujuan === 'menunggu_persetujuan' ? 'bg-emerald-700 hover:bg-emerald-800 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold' }} rounded-xl text-xs transition-colors"
                                    title="Tinjau dan Berikan Keputusan"
                                >
                                    <span>Tinjau</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-600">Tidak Ada Pengajuan Surat Keluar</p>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                    @if($search)
                                        Tidak ditemukan surat keluar yang cocok dengan pencarian kata kunci "{{ $search }}".
                                    @else
                                        Saat ini tidak ada draf surat keluar pada kriteria status yang dipilih.
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suratKeluars->hasPages())
            <div class="p-4 bg-slate-50/75 border-t border-slate-200">
                {{ $suratKeluars->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
