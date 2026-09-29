@extends('layouts.admin')

@section('title', 'Verifikasi & Pengelolaan Legalisir')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">
                <span>Layanan Publik Alumni</span>
                <span>•</span>
                <span>SRS-P06 / SRS-P07</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Verifikasi & Pengelolaan Legalisir Online</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Verifikasi keabsahan dokumen terhadap buku induk kelulusan, ajukan pengesahan Kepala Sekolah, dan pantau pengambilan fisik di SMKN 1 Subang.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('legalisir.create') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-sm shadow-blue-500/20 active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Input Permohonan Manual</span>
            </a>
            <a href="{{ route('legalisir.tracking') }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs sm:text-sm font-semibold transition-colors">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Live Tracker</span>
            </a>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-3">
        <!-- Card 1: Total -->
        <a href="{{ route('admin.legalisir.index', ['status' => 'semua']) }}" class="bg-white p-4 rounded-2xl border {{ $status === 'semua' ? 'border-blue-500 ring-2 ring-blue-500/20' : 'border-slate-200/80' }} shadow-xs hover:border-blue-400 transition-all">
            <p class="text-[11px] text-slate-500 font-medium">Total Permohonan</p>
            <h3 class="text-xl font-bold text-slate-900 mt-1">{{ number_format($stats['total']) }}</h3>
            <span class="text-[10px] text-slate-400">Seluruh berkas</span>
        </a>

        <!-- Card 2: Menunggu Verifikasi -->
        <a href="{{ route('admin.legalisir.index', ['status' => 'menunggu_verifikasi']) }}" class="bg-white p-4 rounded-2xl border {{ $status === 'menunggu_verifikasi' ? 'border-amber-500 ring-2 ring-amber-500/20' : 'border-slate-200/80' }} shadow-xs hover:border-amber-400 transition-all">
            <div class="flex items-center justify-between">
                <p class="text-[11px] text-amber-700 font-semibold">Perlu Verifikasi</p>
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
            </div>
            <h3 class="text-xl font-bold text-amber-600 mt-1">{{ number_format($stats['menunggu_verifikasi']) }}</h3>
            <span class="text-[10px] text-amber-700/80">Antrean staf TU</span>
        </a>

        <!-- Card 3: Menunggu Kepsek -->
        <a href="{{ route('admin.legalisir.index', ['status' => 'menunggu_approval_kepsek']) }}" class="bg-white p-4 rounded-2xl border {{ $status === 'menunggu_approval_kepsek' ? 'border-indigo-500 ring-2 ring-indigo-500/20' : 'border-slate-200/80' }} shadow-xs hover:border-indigo-400 transition-all">
            <p class="text-[11px] text-indigo-700 font-semibold">Menunggu Kepsek</p>
            <h3 class="text-xl font-bold text-indigo-600 mt-1">{{ number_format($stats['menunggu_approval_kepsek']) }}</h3>
            <span class="text-[10px] text-indigo-700/80">Otorisasi pimpinan</span>
        </a>

        <!-- Card 4: Sedang Diproses -->
        <a href="{{ route('admin.legalisir.index', ['status' => 'sedang_diproses']) }}" class="bg-white p-4 rounded-2xl border {{ $status === 'sedang_diproses' ? 'border-purple-500 ring-2 ring-purple-500/20' : 'border-slate-200/80' }} shadow-xs hover:border-purple-400 transition-all">
            <p class="text-[11px] text-purple-700 font-semibold">Proses Cetak</p>
            <h3 class="text-xl font-bold text-purple-600 mt-1">{{ number_format($stats['sedang_diproses']) }}</h3>
            <span class="text-[10px] text-purple-700/80">Stempel & tanda tangan</span>
        </a>

        <!-- Card 5: Siap Diambil -->
        <a href="{{ route('admin.legalisir.index', ['status' => 'siap_diambil']) }}" class="bg-white p-4 rounded-2xl border {{ $status === 'siap_diambil' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-slate-200/80' }} shadow-xs hover:border-emerald-400 transition-all">
            <p class="text-[11px] text-emerald-700 font-semibold">Siap Diambil</p>
            <h3 class="text-xl font-bold text-emerald-600 mt-1">{{ number_format($stats['siap_diambil']) }}</h3>
            <span class="text-[10px] text-emerald-700/80">Di loket TU</span>
        </a>

        <!-- Card 6: Selesai -->
        <a href="{{ route('admin.legalisir.index', ['status' => 'selesai']) }}" class="bg-white p-4 rounded-2xl border {{ $status === 'selesai' ? 'border-teal-500 ring-2 ring-teal-500/20' : 'border-slate-200/80' }} shadow-xs hover:border-teal-400 transition-all">
            <p class="text-[11px] text-teal-700 font-semibold">Selesai</p>
            <h3 class="text-xl font-bold text-teal-600 mt-1">{{ number_format($stats['selesai']) }}</h3>
            <span class="text-[10px] text-teal-700/80">Telah diserahkan</span>
        </a>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <!-- Tabs Filter Status -->
            <div class="flex items-center gap-1 overflow-x-auto pb-1 max-w-full text-xs font-semibold">
                <a href="{{ route('admin.legalisir.index', ['status' => 'semua', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $status === 'semua' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    Semua ({{ $stats['total'] }})
                </a>
                <a href="{{ route('admin.legalisir.index', ['status' => 'menunggu_verifikasi', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $status === 'menunggu_verifikasi' ? 'bg-amber-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    Menunggu Verifikasi ({{ $stats['menunggu_verifikasi'] }})
                </a>
                <a href="{{ route('admin.legalisir.index', ['status' => 'menunggu_approval_kepsek', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $status === 'menunggu_approval_kepsek' ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    Menunggu Kepsek ({{ $stats['menunggu_approval_kepsek'] }})
                </a>
                <a href="{{ route('admin.legalisir.index', ['status' => 'sedang_diproses', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $status === 'sedang_diproses' ? 'bg-purple-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    Diproses Cetak
                </a>
                <a href="{{ route('admin.legalisir.index', ['status' => 'siap_diambil', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $status === 'siap_diambil' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    Siap Diambil ({{ $stats['siap_diambil'] }})
                </a>
                <a href="{{ route('admin.legalisir.index', ['status' => 'selesai', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $status === 'selesai' ? 'bg-teal-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    Selesai ({{ $stats['selesai'] }})
                </a>
                <a href="{{ route('admin.legalisir.index', ['status' => 'ditolak', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $status === 'ditolak' ? 'bg-rose-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                    Ditolak ({{ $stats['ditolak'] }})
                </a>
            </div>

            <!-- Form Pencarian Cepat -->
            <form action="{{ route('admin.legalisir.index') }}" method="GET" class="flex items-center gap-2">
                <input type="hidden" name="status" value="{{ $status }}">
                <div class="relative">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ $search }}" 
                        placeholder="Cari resi, nama, NISN..."
                        class="w-56 sm:w-64 pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-300 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition-colors cursor-pointer">
                    Cari
                </button>
                @if($search !== '')
                    <a href="{{ route('admin.legalisir.index', ['status' => $status]) }}" class="p-1.5 text-slate-500 hover:text-slate-800 rounded-lg hover:bg-slate-100" title="Reset Pencarian">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
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
                        <th class="py-3.5 px-4">Pemohon & NISN</th>
                        <th class="py-3.5 px-4">Dokumen & Lembar</th>
                        <th class="py-3.5 px-4">Status Layanan</th>
                        <th class="py-3.5 px-4">Kesiapan Ambil</th>
                        <th class="py-3.5 px-4 text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($legalisirList as $item)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3.5 px-4 align-top">
                                <span class="font-mono font-bold text-blue-900 block text-xs">{{ $item->nomor_pengajuan }}</span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</span>
                            </td>
                            <td class="py-3.5 px-4 align-top">
                                <span class="font-bold text-slate-900 block text-xs">{{ $item->nama_pemohon }}</span>
                                <span class="text-[11px] text-slate-500 font-mono block mt-0.5">NISN: {{ $item->nisn }} (Lulus {{ $item->tahun_lulus }})</span>
                                <span class="text-[10px] text-slate-400 block">{{ $item->nomor_whatsapp }}</span>
                            </td>
                            <td class="py-3.5 px-4 align-top">
                                <span class="font-semibold text-slate-800 block text-xs">{{ $item->jenis_dokumen_label }}</span>
                                <span class="text-[11px] text-slate-500 block mt-0.5">{{ $item->jumlah_lembar }} Lembar Salinan</span>
                                <span class="text-[10px] text-slate-400 block truncate max-w-xs" title="{{ $item->keperluan }}">Keperluan: {{ $item->keperluan }}</span>
                            </td>
                            <td class="py-3.5 px-4 align-top">
                                <x-status-badge :status="$item->status" type="legalisir" />
                                @if($item->catatan_petugas && $item->status === 'ditolak')
                                    <p class="text-[10px] text-rose-600 mt-1 max-w-xs truncate" title="{{ $item->catatan_petugas }}">
                                        Alasan: {{ $item->catatan_petugas }}
                                    </p>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 align-top">
                                @if($item->tanggal_siap_ambil)
                                    <span class="inline-flex items-center gap-1 font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $item->tanggal_siap_ambil->translatedFormat('d M Y') }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Belum dijadwalkan</span>
                                @endif
                                
                                @if($item->tanggal_pengambilan)
                                    <span class="text-[10px] text-teal-700 block mt-1">Diambil: {{ $item->tanggal_pengambilan->translatedFormat('d M Y') }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 align-top text-center">
                                <div class="inline-flex items-center gap-1">
                                    <a 
                                        href="{{ route('admin.legalisir.show', $item->id) }}" 
                                        class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg font-semibold transition-colors flex items-center gap-1 text-[11px]"
                                        title="Periksa Berkas & Tindak Lanjut"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>Verifikasi</span>
                                    </a>
                                    <a 
                                        href="{{ route('legalisir.tanda-terima', $item->nomor_pengajuan) }}" 
                                        target="_blank" 
                                        class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors"
                                        title="Cetak Resi Tanda Terima"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <p class="font-semibold text-slate-700">Tidak ada permohonan legalisir</p>
                                <p class="text-xs text-slate-400 mt-0.5">Tidak ditemukan permohonan yang sesuai dengan filter atau kata kunci pencarian.</p>
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
