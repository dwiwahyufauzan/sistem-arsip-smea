@extends('layouts.admin')

@section('title', 'Detail Surat Keluar - ' . $surat_keluar->nomor_surat)

@section('content')
<div class="space-y-6">

    <!-- Top Navigation & Action Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.surat-keluar.index') }}" class="p-2 rounded-xl text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition-colors" title="Kembali ke Daftar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="font-mono font-bold text-xs bg-blue-50 text-blue-900 px-2 py-0.5 rounded border border-blue-200/60">
                        {{ $surat_keluar->nomor_agenda }}
                    </span>
                    <x-status-badge :status="$surat_keluar->status_persetujuan" />
                </div>
                <h1 class="text-base sm:text-lg font-bold text-slate-900 mt-1 leading-tight">
                    {{ $surat_keluar->nomor_surat }}
                </h1>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-2 shrink-0">
            <!-- Ajukan ke Kepala Sekolah jika status draft atau ditolak -->
            @if(in_array($surat_keluar->status_persetujuan, ['draft', 'ditolak']))
                <form action="{{ route('admin.surat-keluar.ajukan', $surat_keluar) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold shadow-xs transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Ajukan Persetujuan Kepsek</span>
                    </button>
                </form>
            @endif

            <!-- Edit -->
            <a href="{{ route('admin.surat-keluar.edit', $surat_keluar) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-amber-50 hover:bg-amber-100 text-amber-800 rounded-xl text-xs font-semibold border border-amber-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Edit</span>
            </a>

            <!-- Unduh File -->
            @if($surat_keluar->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat_keluar->file_path))
                <a href="{{ route('admin.surat-keluar.download', $surat_keluar) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-xl text-xs font-semibold border border-emerald-200 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh</span>
                </a>
            @endif

            <!-- Print / Cetak Lembar Arsip Resmi -->
            <a href="{{ route('admin.surat-keluar.cetak', $surat_keluar) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors cursor-pointer" title="Cetak Lembar Kendali Arsip Surat Keluar">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Lembar Arsip</span>
            </a>

            <!-- Hapus -->
            <button 
                type="button" 
                onclick="openDeleteModal({{ $surat_keluar->id }}, '{{ addslashes($surat_keluar->nomor_surat) }}', '{{ addslashes($surat_keluar->nomor_agenda) }}')" 
                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors"
                title="Hapus Surat Keluar"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Card 1: Informasi Surat Keluar -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Lembar Informasi Surat Keluar</span>
                    </h2>
                    <span class="text-[10px] text-slate-400">SMK Negeri 1 Subang</span>
                </div>

                <div class="p-6 space-y-4">
                    <div class="pb-3 border-b border-slate-100">
                        <span class="text-[11px] text-slate-400 font-medium block">Perihal Surat:</span>
                        <p class="text-base font-bold text-slate-900 mt-0.5 leading-snug">{{ $surat_keluar->perihal }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Nomor Surat Dinas:</span>
                            <span class="font-semibold text-slate-800 mt-0.5 block">{{ $surat_keluar->nomor_surat }}</span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Klasifikasi Dinas:</span>
                            <span class="inline-block mt-0.5 px-2 py-0.5 bg-blue-50 text-blue-700 font-medium rounded border border-blue-200/60">
                                {{ $surat_keluar->kategori->kode_kategori }} - {{ $surat_keluar->kategori->nama_kategori }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Pihak / Instansi Tujuan:</span>
                            <span class="font-semibold text-slate-800 mt-0.5 block">{{ $surat_keluar->tujuan }}</span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Tanggal Surat Diterbitkan:</span>
                            <span class="font-medium text-slate-700 mt-0.5 block">{{ $surat_keluar->tanggal_surat->isoFormat('dddd, D MMMM Y') }}</span>
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

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                        <span>Dibuat oleh: <strong class="text-slate-600">{{ $surat_keluar->user->name ?? 'Petugas TU' }}</strong></span>
                        <span>Waktu Pembuatan: {{ $surat_keluar->created_at->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Status Otorisasi / Persetujuan Kepala Sekolah -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Otorisasi Persetujuan Kepala Sekolah</span>
                    </h2>
                    <x-status-badge :status="$surat_keluar->status_persetujuan" />
                </div>

                <div class="p-6">
                    @if($surat_keluar->status_persetujuan === 'disetujui')
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs space-y-2">
                            <div class="flex items-center gap-2 text-emerald-800 font-bold">
                                <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <span>Surat Keluar Telah Disetujui Pimpinan</span>
                            </div>
                            <p class="text-emerald-900/90">
                                Disetujui oleh: <strong>{{ $surat_keluar->kepsek->name ?? 'Kepala SMKN 1 Subang' }}</strong>
                            </p>
                            @if($surat_keluar->tanggal_disetujui)
                                <p class="text-emerald-700 text-[11px]">
                                    Waktu Persetujuan: {{ $surat_keluar->tanggal_disetujui->isoFormat('dddd, D MMMM Y, HH:mm') }} WIB
                                </p>
                            @endif
                            @if($surat_keluar->catatan_kepsek)
                                <div class="mt-2 pt-2 border-t border-emerald-200/60">
                                    <span class="font-medium text-emerald-800">Catatan Pimpinan:</span>
                                    <p class="text-emerald-900 mt-0.5">{{ $surat_keluar->catatan_kepsek }}</p>
                                </div>
                            @endif
                        </div>
                    @elseif($surat_keluar->status_persetujuan === 'ditolak')
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs space-y-2">
                            <div class="flex items-center gap-2 text-rose-800 font-bold">
                                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span>Ditolak / Memerlukan Revisi oleh Kepala Sekolah</span>
                            </div>
                            <div class="mt-2 pt-2 border-t border-rose-200/60">
                                <span class="font-semibold text-rose-900">Catatan Perbaikan dari Pimpinan:</span>
                                <p class="text-rose-800 mt-1 italic font-medium bg-white p-3 rounded-lg border border-rose-100">
                                    "{{ $surat_keluar->catatan_kepsek ?? 'Silakan lakukan revisi pada draf berkas dokumen surat keluar.' }}"
                                </p>
                            </div>
                            <p class="text-[11px] text-rose-600 pt-1">
                                Klik tombol <strong>Edit</strong> di atas untuk memperbaiki data atau mengunggah berkas revisi baru, kemudian ajukan kembali ke Kepala Sekolah.
                            </p>
                        </div>
                    @elseif($surat_keluar->status_persetujuan === 'menunggu_persetujuan')
                        <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-xs space-y-1.5">
                            <div class="flex items-center gap-2 text-amber-800 font-bold">
                                <svg class="w-5 h-5 text-amber-600 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span>Sedang Menunggu Verifikasi & Persetujuan Kepala Sekolah</span>
                            </div>
                            <p class="text-amber-800">
                                Draf surat keluar telah berada dalam antrean tinjauan pimpinan.
                            </p>
                        </div>
                    @else
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-2">
                            <div class="flex items-center gap-2 text-slate-700 font-bold">
                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                <span>Status Masih Draf Konsep</span>
                            </div>
                            <p class="text-slate-500">
                                Dokumen ini masih berupa draf internal staf Tata Usaha dan belum diajukan ke Kepala Sekolah.
                            </p>
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
                        <div class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-slate-800">Pratinjau Draf Dokumen</h3>
                            <p class="text-[10px] text-slate-400 font-mono">{{ $surat_keluar->file_size_formatted }}</p>
                        </div>
                    </div>

                    @if($surat_keluar->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat_keluar->file_path))
                        <div class="flex items-center gap-1.5">
                            <button 
                                type="button" 
                                onclick="window.openPdfModal('{{ asset('storage/' . $surat_keluar->file_path) }}', 'Surat Keluar: {{ addslashes($surat_keluar->nomor_surat) }}')"
                                class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors"
                                title="Buka Pratinjau Penuh"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            </button>
                            <a 
                                href="{{ asset('storage/' . $surat_keluar->file_path) }}" 
                                target="_blank" 
                                class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors"
                                title="Buka di Tab Baru"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
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
                        <p class="text-xs text-slate-400">Berkas draf dokumen tidak ditemukan pada server.</p>
                    @endif
                </div>

                <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="truncate max-w-[200px] text-slate-600 font-medium" title="{{ $surat_keluar->file_name }}">
                        {{ $surat_keluar->file_name }}
                    </span>
                    @if($surat_keluar->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat_keluar->file_path))
                        <a href="{{ route('admin.surat-keluar.download', $surat_keluar) }}" class="text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center gap-1">
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
