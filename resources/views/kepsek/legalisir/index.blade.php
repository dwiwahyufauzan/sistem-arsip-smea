@extends('layouts.kepsek')

@section('title', 'Pengesahan Legalisir Dokumen')
@section('page_title', 'Pengesahan Legalisir Dokumen')
@section('page_subtitle', 'Tinjauan & Otorisasi Pengesahan Dokumen Kelulusan Alumni SMKN 1 Subang (SRS-KS04 / SRS-KS06)')

@section('content')
<div class="space-y-6">

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Menunggu Otorisasi Kepsek -->
        <a href="{{ route('kepsek.legalisir.index', ['status' => 'menunggu_approval_kepsek']) }}" class="block p-5 bg-white rounded-2xl border transition-all hover:shadow-md {{ $status === 'menunggu_approval_kepsek' ? 'border-amber-400 ring-2 ring-amber-400/20' : 'border-slate-200/80' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Pengesahan</p>
                    <p class="text-2xl font-extrabold text-amber-600 mt-1 font-heading">{{ $stats['menunggu'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center {{ $stats['menunggu'] > 0 ? 'animate-pulse' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Telah diverifikasi Staf Tata Usaha</p>
        </a>

        <!-- Disetujui Kepsek -->
        <a href="{{ route('kepsek.legalisir.index', ['status' => 'disetujui_kepsek']) }}" class="block p-5 bg-white rounded-2xl border transition-all hover:shadow-md {{ $status === 'disetujui_kepsek' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-slate-200/80' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Telah Disahkan</p>
                    <p class="text-2xl font-extrabold text-emerald-600 mt-1 font-heading">{{ $stats['disetujui'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Dalam proses cetak & cap basah</p>
        </a>

        <!-- Selesai Diserahkan -->
        <a href="{{ route('kepsek.legalisir.index', ['status' => 'selesai']) }}" class="block p-5 bg-white rounded-2xl border transition-all hover:shadow-md {{ $status === 'selesai' ? 'border-teal-500 ring-2 ring-teal-500/20' : 'border-slate-200/80' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Selesai Diambil</p>
                    <p class="text-2xl font-extrabold text-teal-600 mt-1 font-heading">{{ $stats['selesai'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Telah diserahkan ke alumni</p>
        </a>

        <!-- Total Seluruh Permohonan -->
        <a href="{{ route('kepsek.legalisir.index', ['status' => 'semua']) }}" class="block p-5 bg-white rounded-2xl border transition-all hover:shadow-md {{ $status === 'semua' ? 'border-blue-500 ring-2 ring-blue-500/20' : 'border-slate-200/80' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Permohonan</p>
                    <p class="text-2xl font-extrabold text-slate-900 mt-1 font-heading">{{ $stats['total'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Seluruh arsip legalisir sistem</p>
        </a>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <!-- Tabs Filter Status -->
            <div class="flex items-center gap-1 overflow-x-auto pb-1 text-xs font-semibold">
                <a href="{{ route('kepsek.legalisir.index', ['status' => 'menunggu_approval_kepsek', 'q' => $search]) }}" class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $status === 'menunggu_approval_kepsek' ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    Menunggu Otorisasi ({{ $stats['menunggu'] }})
                </a>
                <a href="{{ route('kepsek.legalisir.index', ['status' => 'disetujui_kepsek', 'q' => $search]) }}" class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $status === 'disetujui_kepsek' ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    Disahkan ({{ $stats['disetujui'] }})
                </a>
                <a href="{{ route('kepsek.legalisir.index', ['status' => 'selesai', 'q' => $search]) }}" class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $status === 'selesai' ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    Selesai ({{ $stats['selesai'] }})
                </a>
                <a href="{{ route('kepsek.legalisir.index', ['status' => 'semua', 'q' => $search]) }}" class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $status === 'semua' ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    Semua Berkas ({{ $stats['total'] }})
                </a>
            </div>

            <!-- Form Pencarian Cepat -->
            <form action="{{ route('kepsek.legalisir.index') }}" method="GET" class="flex items-center gap-2">
                <input type="hidden" name="status" value="{{ $status }}">
                <div class="relative">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ $search }}" 
                        placeholder="Cari resi, nama, NISN..."
                        class="w-56 sm:w-64 pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition-colors cursor-pointer">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">No. Resi & Tanggal</th>
                        <th class="py-3.5 px-4">Nama Pemohon & NISN</th>
                        <th class="py-3.5 px-4">Dokumen yang Dilegalisir</th>
                        <th class="py-3.5 px-4">Verifikasi Tata Usaha</th>
                        <th class="py-3.5 px-4">Status Pengesahan</th>
                        <th class="py-3.5 px-4 text-center">Aksi Pimpinan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($legalisirList as $item)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4 align-top">
                                <span class="font-mono font-bold text-slate-900 block text-xs">{{ $item->nomor_pengajuan }}</span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</span>
                            </td>
                            <td class="py-3.5 px-4 align-top">
                                <span class="font-bold text-slate-900 block text-xs">{{ $item->nama_pemohon }}</span>
                                <span class="text-[11px] text-slate-500 font-mono block mt-0.5">NISN: {{ $item->nisn }} (Lulus: {{ $item->tahun_lulus }})</span>
                            </td>
                            <td class="py-3.5 px-4 align-top">
                                <span class="font-semibold text-slate-800 block text-xs">{{ $item->jenis_dokumen_label }}</span>
                                <span class="text-[11px] text-slate-500 block mt-0.5">{{ $item->jumlah_lembar }} Lembar Salinan</span>
                                <span class="text-[10px] text-slate-400 block truncate max-w-xs">{{ $item->keperluan }}</span>
                            </td>
                            <td class="py-3.5 px-4 align-top">
                                <div class="space-y-1">
                                    <span class="text-[11px] font-semibold text-slate-700 block">
                                        Petugas: {{ $item->petugas->name ?? 'Staf Tata Usaha' }}
                                    </span>
                                    <p class="text-[10px] text-slate-500 bg-slate-50 p-2 rounded border border-slate-200/60 max-w-xs line-clamp-2">
                                        {{ $item->catatan_petugas ?? 'Telah diverifikasi sesuai Buku Induk kelulusan.' }}
                                    </p>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 align-top">
                                <x-status-badge :status="$item->status" type="legalisir" />
                                @if($item->catatan_kepsek)
                                    <p class="text-[10px] text-slate-500 mt-1 max-w-xs truncate" title="{{ $item->catatan_kepsek }}">
                                        Catatan: {{ $item->catatan_kepsek }}
                                    </p>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 align-top text-center">
                                <a 
                                    href="{{ route('kepsek.legalisir.show', $item->id) }}" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 {{ $item->status === 'menunggu_approval_kepsek' ? 'bg-emerald-600 hover:bg-emerald-700 text-white font-bold' : 'bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold' }} rounded-xl text-xs transition-colors shadow-xs"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    <span>{{ $item->status === 'menunggu_approval_kepsek' ? 'Tinjau & Otorisasi' : 'Detail Tinjauan' }}</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <p class="font-semibold text-slate-700">Tidak ada permohonan legalisir pada antrean ini</p>
                                <p class="text-xs text-slate-400 mt-0.5">Semua berkas yang memerlukan peninjauan pimpinan telah selesai ditindaklanjuti.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($legalisirList->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $legalisirList->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
