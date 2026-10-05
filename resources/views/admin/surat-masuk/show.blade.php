@extends('layouts.admin')

@section('title', 'Detail Surat Masuk - ' . $surat_masuk->nomor_surat)

@section('content')
<div class="space-y-6">

    <!-- Top Navigation & Action Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.surat-masuk.index') }}" class="p-2 rounded-xl text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition-colors" title="Kembali ke Daftar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="font-mono font-bold text-xs bg-blue-50 text-blue-900 px-2 py-0.5 rounded border border-blue-200/60">
                        {{ $surat_masuk->nomor_agenda }}
                    </span>
                    <x-status-badge :status="$surat_masuk->status" />
                </div>
                <h1 class="text-base sm:text-lg font-bold text-slate-900 mt-1 leading-tight">
                    {{ $surat_masuk->nomor_surat }}
                </h1>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-2 shrink-0">
            <!-- Edit -->
            <a href="{{ route('admin.surat-masuk.edit', $surat_masuk) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-amber-50 hover:bg-amber-100 text-amber-800 rounded-xl text-xs font-semibold border border-amber-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit Data</span>
            </a>

            <!-- Unduh File -->
            @if($surat_masuk->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat_masuk->file_path))
                <a href="{{ route('admin.surat-masuk.download', $surat_masuk) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-xl text-xs font-semibold border border-emerald-200 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Dokumen</span>
                </a>
            @endif

            <!-- Print / Cetak Lembar Arsip Resmi -->
            <a href="{{ route('admin.surat-masuk.cetak', $surat_masuk) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors cursor-pointer" title="Cetak Lembar Kendali Arsip Surat Masuk">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Lembar Arsip</span>
            </a>

            <!-- Hapus -->
            <button 
                type="button" 
                onclick="openDeleteModal({{ $surat_masuk->id }}, '{{ addslashes($surat_masuk->nomor_surat) }}', '{{ addslashes($surat_masuk->nomor_agenda) }}')" 
                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors"
                title="Hapus Surat Masuk"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column: Lembar Rincian Surat & Disposisi (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Card 1: Identitas Arsip Surat -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Lembar Informasi Surat Masuk</span>
                    </h2>
                    <span class="text-[10px] text-slate-400">SMK Negeri 1 Subang</span>
                </div>

                <div class="p-6 space-y-4">
                    <!-- Perihal -->
                    <div class="pb-3 border-b border-slate-100">
                        <span class="text-[11px] text-slate-400 font-medium block">Perihal Surat:</span>
                        <p class="text-base font-bold text-slate-900 mt-0.5 leading-snug">{{ $surat_masuk->perihal }}</p>
                    </div>

                    <!-- Metadata Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Nomor Surat Dinas:</span>
                            <span class="font-semibold text-slate-800 mt-0.5 block">{{ $surat_masuk->nomor_surat }}</span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Kategori Klasifikasi:</span>
                            <span class="inline-block mt-0.5 px-2 py-0.5 bg-blue-50 text-blue-700 font-medium rounded border border-blue-200/60">
                                {{ $surat_masuk->kategori->kode_kategori }} - {{ $surat_masuk->kategori->nama_kategori }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Pengirim (Instansi / Lembaga):</span>
                            <span class="font-semibold text-slate-800 mt-0.5 block">{{ $surat_masuk->pengirim }}</span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Tujuan / Penerima di Sekolah:</span>
                            <span class="font-semibold text-slate-800 mt-0.5 block">{{ $surat_masuk->penerima }}</span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Tanggal Surat Tertulis:</span>
                            <span class="font-medium text-slate-700 mt-0.5 block">{{ $surat_masuk->tanggal_surat->isoFormat('dddd, D MMMM Y') }}</span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Tanggal Diterima Staf TU:</span>
                            <span class="font-medium text-slate-700 mt-0.5 block">{{ $surat_masuk->tanggal_terima->isoFormat('dddd, D MMMM Y') }}</span>
                        </div>
                    </div>

                    <!-- Isi Ringkas -->
                    @if($surat_masuk->isi_ringkas)
                        <div class="pt-3 border-t border-slate-100">
                            <span class="text-[11px] text-slate-400 font-medium block">Isi Ringkas / Keterangan:</span>
                            <div class="mt-1 p-3.5 bg-slate-50 rounded-xl text-slate-700 text-xs leading-relaxed border border-slate-100">
                                {{ $surat_masuk->isi_ringkas }}
                            </div>
                        </div>
                    @endif

                    <!-- Audit Penginput -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                        <span>Dicatat oleh: <strong class="text-slate-600">{{ $surat_masuk->user->name ?? 'Petugas TU' }}</strong></span>
                        <span>Waktu Registrasi: {{ $surat_masuk->created_at->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Lembar Disposisi Kepala Sekolah -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span>Lembar Disposisi Pimpinan</span>
                    </h2>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $surat_masuk->disposisi->count() > 0 ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500' }}">
                        {{ $surat_masuk->disposisi->count() }} Disposisi
                    </span>
                </div>

                <div class="p-6">
                    @forelse($surat_masuk->disposisi as $disp)
                        <div class="p-4 rounded-xl bg-teal-50/40 border border-teal-100 space-y-3 mb-3 last:mb-0">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-teal-600 text-white flex items-center justify-center font-bold text-[10px]">
                                        {{ $loop->iteration }}
                                    </span>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">Tujuan: {{ $disp->tujuan_disposisi }}</p>
                                        <span class="text-[10px] text-slate-500">Diberikan oleh: {{ $disp->pemberi->name ?? 'Kepala Sekolah' }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full {{ $disp->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : ($disp->status === 'ditindaklanjuti' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800') }}">
                                        {{ ucfirst($disp->status) }}
                                    </span>
                                    <a 
                                        href="{{ route('admin.disposisi.cetak', $disp) }}" 
                                        target="_blank" 
                                        class="p-1 text-slate-400 hover:text-slate-700 transition-colors" 
                                        title="Cetak Lembar Disposisi Resmi"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    </a>
                                </div>
                            </div>

                            <div class="text-xs space-y-1.5 pt-1">
                                <div>
                                    <span class="text-[11px] text-slate-400 font-medium">Instruksi:</span>
                                    <p class="font-medium text-slate-800">{{ $disp->instruksi }}</p>
                                </div>
                                @if($disp->catatan)
                                    <div>
                                        <span class="text-[11px] text-slate-400 font-medium">Catatan Khusus:</span>
                                        <p class="text-slate-600">{{ $disp->catatan }}</p>
                                    </div>
                                @endif
                                @if($disp->batas_waktu)
                                    <div class="text-[11px] text-rose-600 font-medium flex items-center gap-1 pt-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Batas Waktu: {{ \Carbon\Carbon::parse($disp->batas_waktu)->isoFormat('D MMMM Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-xs font-semibold text-slate-700">Belum Ada Disposisi Pimpinan</p>
                            <p class="text-[11px] text-slate-400 max-w-sm mx-auto mt-0.5">
                                Surat masuk ini masih berstatus <span class="font-semibold text-amber-600">Diterima</span> dan menunggu arahan instruksi tindak lanjut dari Kepala Sekolah.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right Column: Interactive Document Viewer (5 Cols) -->
        <div class="lg:col-span-5 space-y-4">

            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-5 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-slate-800">Pratinjau Dokumen Fisik</h3>
                            <p class="text-[10px] text-slate-400 font-mono">{{ $surat_masuk->file_size_formatted }}</p>
                        </div>
                    </div>

                    @if($surat_masuk->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat_masuk->file_path))
                        <div class="flex items-center gap-1.5">
                            <button 
                                type="button" 
                                onclick="window.openPdfModal('{{ asset('storage/' . $surat_masuk->file_path) }}', 'Surat Masuk: {{ addslashes($surat_masuk->nomor_surat) }}')"
                                class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors"
                                title="Buka Pratinjau Penuh"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            </button>
                            <a 
                                href="{{ asset('storage/' . $surat_masuk->file_path) }}" 
                                target="_blank" 
                                class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors"
                                title="Buka di Tab Baru"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Document Viewer Frame -->
                <div class="bg-slate-900 h-[520px] flex items-center justify-center overflow-hidden relative">
                    @if($surat_masuk->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat_masuk->file_path))
                        @php
                            $ext = strtolower(pathinfo($surat_masuk->file_path, PATHINFO_EXTENSION));
                        @endphp

                        @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset('storage/' . $surat_masuk->file_path) }}" alt="{{ $surat_masuk->file_name }}" class="max-h-full max-w-full object-contain p-2">
                        @else
                            <iframe 
                                src="{{ asset('storage/' . $surat_masuk->file_path) }}#toolbar=0" 
                                class="w-full h-full border-0" 
                                title="Pratinjau Dokumen"
                            ></iframe>
                        @endif
                    @else
                        <div class="text-center p-6 text-slate-400 space-y-2">
                            <svg class="w-10 h-10 mx-auto text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="text-xs">Berkas dokumen belum tersedia atau telah dipindahkan.</p>
                        </div>
                    @endif
                </div>

                <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="truncate max-w-[200px] text-slate-600 font-medium" title="{{ $surat_masuk->file_name }}">
                        {{ $surat_masuk->file_name }}
                    </span>
                    @if($surat_masuk->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat_masuk->file_path))
                        <a href="{{ route('admin.surat-masuk.download', $surat_masuk) }}" class="text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>Unduh Asli</span>
                        </a>
                    @endif
                </div>
            </div>

        </div>

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
                            <h3 class="font-heading font-bold text-base text-slate-900 leading-snug">Konfirmasi Hapus Surat Masuk</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Pastikan keabsahan arsip sebelum menghapus data ini.</p>
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

        form.action = `/admin/surat-masuk/${id}`;
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
