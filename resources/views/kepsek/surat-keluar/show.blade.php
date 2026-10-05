@extends('layouts.kepsek')

@section('title', 'Tinjauan Draf Surat Keluar - ' . $surat_keluar->nomor_surat)

@section('content')
<div class="space-y-6">

    <!-- Top Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-3">
            <a href="{{ route('kepsek.surat-keluar.index') }}" class="p-2 rounded-xl text-slate-500 hover:text-emerald-800 hover:bg-slate-100 transition-colors" title="Kembali">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="font-mono font-bold text-xs bg-slate-100 text-slate-800 px-2 py-0.5 rounded border border-slate-200">
                        {{ $surat_keluar->nomor_agenda }}
                    </span>
                    <x-status-badge :status="$surat_keluar->status_persetujuan" />
                </div>
                <h1 class="text-base sm:text-lg font-bold text-slate-900 mt-1 leading-tight">
                    {{ $surat_keluar->nomor_surat }}
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            @if($surat_keluar->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat_keluar->file_path))
                <a href="{{ route('kepsek.surat-keluar.download', $surat_keluar) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-xl text-xs font-semibold border border-emerald-200 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Dokumen</span>
                </a>
            @endif

            <a href="{{ route('kepsek.surat-keluar.cetak', $surat_keluar) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors cursor-pointer" title="Cetak Lembar Kendali Arsip Surat Keluar">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Lembar Arsip</span>
            </a>
        </div>
    </div>

    <!-- Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Detail Lembar Informasi -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Lembar Informasi Draf Surat Keluar</h2>
                    <span class="text-[10px] text-slate-400">SMKN 1 Subang</span>
                </div>

                <div class="p-6 space-y-4">
                    <div class="pb-3 border-b border-slate-100">
                        <span class="text-[11px] text-slate-400 font-medium block">Perihal Surat:</span>
                        <p class="text-base font-bold text-slate-900 mt-0.5 leading-snug">{{ $surat_keluar->perihal }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Tujuan Surat:</span>
                            <span class="font-semibold text-slate-800 mt-0.5 block">{{ $surat_keluar->tujuan }}</span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Klasifikasi Dinas:</span>
                            <span class="inline-block mt-0.5 px-2 py-0.5 bg-emerald-50 text-emerald-800 font-medium rounded border border-emerald-200">
                                {{ $surat_keluar->kategori->kode_kategori }} - {{ $surat_keluar->kategori->nama_kategori }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Tanggal Terbit:</span>
                            <span class="font-medium text-slate-700 mt-0.5 block">{{ $surat_keluar->tanggal_surat->isoFormat('dddd, D MMMM Y') }}</span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Draf Diajukan Oleh:</span>
                            <span class="font-semibold text-slate-800 mt-0.5 block">{{ $surat_keluar->user->name ?? 'Petugas TU' }}</span>
                        </div>
                    </div>

                    @if($surat_keluar->isi_ringkas)
                        <div class="pt-3 border-t border-slate-100">
                            <span class="text-[11px] text-slate-400 font-medium block">Isi Ringkas / Keterangan:</span>
                            <div class="mt-1 p-3.5 bg-slate-50 rounded-xl text-slate-700 text-xs leading-relaxed border border-slate-100">
                                {{ $surat_keluar->isi_ringkas }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Status Persetujuan & Catatan Pimpinan -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Status Otorisasi Pimpinan</h2>
                    <x-status-badge :status="$surat_keluar->status_persetujuan" />
                </div>

                <div class="p-6">
                    @if($surat_keluar->status_persetujuan === 'disetujui')
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs space-y-2">
                            <p class="font-bold text-emerald-800">Surat keluar ini telah Anda setujui untuk diterbitkan secara resmi.</p>
                            @if($surat_keluar->tanggal_disetujui)
                                <p class="text-emerald-700 text-[11px]">Waktu Persetujuan: {{ $surat_keluar->tanggal_disetujui->isoFormat('dddd, D MMMM Y, HH:mm') }} WIB</p>
                            @endif
                            @if($surat_keluar->catatan_kepsek)
                                <p class="text-emerald-900 mt-2 font-medium">Catatan: "{{ $surat_keluar->catatan_kepsek }}"</p>
                            @endif
                        </div>
                    @elseif($surat_keluar->status_persetujuan === 'ditolak')
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs space-y-2">
                            <p class="font-bold text-rose-800">Draf surat keluar ditolak / diminta untuk direvisi.</p>
                            <div class="bg-white p-3 rounded-lg border border-rose-100 text-rose-900 font-medium">
                                Catatan Perbaikan: "{{ $surat_keluar->catatan_kepsek }}"
                            </div>
                        </div>
                    @elseif($surat_keluar->status_persetujuan === 'menunggu_persetujuan')
                        <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-xs space-y-3">
                            <div>
                                <p class="font-bold text-amber-900">Surat keluar ini sedang menunggu keputusan persetujuan dari Anda.</p>
                                <p class="text-amber-800 mt-0.5">
                                    Silakan teliti draf dokumen surat dan berikan otorisasi persetujuan atau catatan perbaikan.
                                </p>
                            </div>
                            <div>
                                <a 
                                    href="{{ route('kepsek.persetujuan.show', $surat_keluar) }}" 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl font-bold text-xs shadow-xs transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Buka Lembar Otorisasi & Keputusan</span>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            <p class="text-slate-600">Dokumen masih berupa draf kerja internal staf TU dan belum diajukan secara resmi.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Column: Document Viewer (5 Cols) -->
        <div class="lg:col-span-5 space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-5 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                        </div>
                        <h3 class="text-xs font-bold text-slate-800">Pratinjau Draf Surat</h3>
                    </div>

                    @if($surat_keluar->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat_keluar->file_path))
                        <button 
                            type="button" 
                            onclick="window.openPdfModal('{{ asset('storage/' . $surat_keluar->file_path) }}', 'Surat Keluar: {{ addslashes($surat_keluar->nomor_surat) }}')"
                            class="p-1.5 text-slate-500 hover:text-emerald-800 hover:bg-slate-100 rounded-lg transition-colors"
                            title="Layar Penuh"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                        </button>
                    @endif
                </div>

                <div class="bg-slate-900 h-[520px] flex items-center justify-center overflow-hidden">
                    @if($surat_keluar->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat_keluar->file_path))
                        <iframe 
                            src="{{ asset('storage/' . $surat_keluar->file_path) }}#toolbar=0" 
                            class="w-full h-full border-0" 
                            title="Pratinjau Dokumen"
                        ></iframe>
                    @else
                        <p class="text-xs text-slate-400">Berkas fisik tidak ditemukan pada server.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
