@extends('layouts.kepsek')

@section('title', 'Tinjauan & Otorisasi Surat Keluar - ' . $suratKeluar->nomor_surat)

@section('content')
<div class="space-y-6">

    <!-- Top Navigation Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-3">
            <a href="{{ route('kepsek.persetujuan.index') }}" class="p-2 rounded-xl text-slate-500 hover:text-emerald-800 hover:bg-slate-100 transition-colors" title="Kembali ke Antrean">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="font-mono font-bold text-xs bg-slate-100 text-slate-800 px-2 py-0.5 rounded border border-slate-200">
                        {{ $suratKeluar->nomor_agenda }}
                    </span>
                    <x-status-badge :status="$suratKeluar->status_persetujuan" />
                </div>
                <h1 class="text-base sm:text-lg font-bold text-slate-900 mt-1 leading-tight">
                    {{ $suratKeluar->nomor_surat }}
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            @if($suratKeluar->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($suratKeluar->file_path))
                <a href="{{ route('kepsek.surat-keluar.download', $suratKeluar) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-xl text-xs font-semibold border border-emerald-200 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Dokumen</span>
                </a>
            @endif

            <a href="{{ route('kepsek.surat-keluar.cetak', $suratKeluar) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors cursor-pointer" title="Cetak Lembar Kendali Arsip Surat Keluar">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Lembar</span>
            </a>
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column: Letter Metadata & Executive Approval Actions (7 Cols) -->
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
                        <p class="text-base font-bold text-slate-900 mt-0.5 leading-snug">{{ $suratKeluar->perihal }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Tujuan / Penerima Surat:</span>
                            <span class="font-semibold text-slate-800 mt-0.5 block">{{ $suratKeluar->tujuan }}</span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Klasifikasi Dinas:</span>
                            <span class="inline-block mt-0.5 px-2 py-0.5 bg-emerald-50 text-emerald-800 font-medium rounded border border-emerald-200">
                                {{ $suratKeluar->kategori->kode_kategori }} - {{ $suratKeluar->kategori->nama_kategori }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Tanggal Terbit Dokumen:</span>
                            <span class="font-medium text-slate-700 mt-0.5 block">{{ $suratKeluar->tanggal_surat->isoFormat('dddd, D MMMM Y') }}</span>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Draf Diajukan Oleh:</span>
                            <span class="font-semibold text-slate-800 mt-0.5 block">{{ $suratKeluar->user->name ?? 'Staf Tata Usaha' }}</span>
                        </div>
                    </div>

                    @if($suratKeluar->isi_ringkas)
                        <div class="pt-3 border-t border-slate-100">
                            <span class="text-[11px] text-slate-400 font-medium block">Keterangan / Isi Ringkas Surat:</span>
                            <div class="mt-1 p-3.5 bg-slate-50 rounded-xl text-slate-700 text-xs leading-relaxed border border-slate-100">
                                {{ $suratKeluar->isi_ringkas }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Panel Keputusan Otorisasi Kepala Sekolah -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-lg bg-emerald-700 text-white flex items-center justify-center text-xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Otorisasi & Kebijakan Pimpinan</h2>
                    </div>
                    <x-status-badge :status="$suratKeluar->status_persetujuan" />
                </div>

                <div class="p-6">
                    @if($suratKeluar->status_persetujuan === 'menunggu_persetujuan')
                        <div class="space-y-4">
                            <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-xs">
                                <p class="font-bold text-amber-900">Perhatian:</p>
                                <p class="text-amber-800 mt-0.5">
                                    Draf surat keluar ini telah diajukan oleh staf Tata Usaha dan membutuhkan persetujuan resmi Kepala Sekolah sebelum dapat dicetak dan didistribusikan.
                                </p>
                            </div>

                            <div class="flex flex-col sm:flex-row items-center gap-3 pt-2">
                                <!-- Tombol Setujui (Trigger Modal) -->
                                <button 
                                    type="button" 
                                    onclick="document.getElementById('modalApprove').classList.remove('hidden')"
                                    class="w-full sm:w-1/2 flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-md shadow-emerald-700/20 transition-all cursor-pointer"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Setujui Surat Keluar</span>
                                </button>

                                <!-- Tombol Tolak / Minta Revisi (Trigger Modal) -->
                                <button 
                                    type="button" 
                                    onclick="document.getElementById('modalReject').classList.remove('hidden')"
                                    class="w-full sm:w-1/2 flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-white hover:bg-rose-50 text-rose-700 font-bold text-xs border border-rose-300 transition-all cursor-pointer"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    <span>Tolak / Minta Revisi</span>
                                </button>
                            </div>
                        </div>

                    @elseif($suratKeluar->status_persetujuan === 'disetujui')
                        <div class="space-y-4">
                            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs space-y-2">
                                <div class="flex items-center gap-2 text-emerald-800 font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Surat Keluar Telah Resmi Disetujui</span>
                                </div>
                                <p class="text-emerald-700">
                                    Disetujui oleh: <strong class="text-emerald-900">{{ $suratKeluar->kepsek->name ?? 'Kepala Sekolah' }}</strong>
                                    pada {{ $suratKeluar->tanggal_disetujui ? $suratKeluar->tanggal_disetujui->isoFormat('dddd, D MMMM Y, HH:mm') . ' WIB' : '-' }}
                                </p>
                                @if($suratKeluar->catatan_kepsek)
                                    <div class="mt-2 p-3 bg-white/80 rounded-lg border border-emerald-100 text-emerald-950 font-medium">
                                        Catatan Pimpinan: "{{ $suratKeluar->catatan_kepsek }}"
                                    </div>
                                @endif
                            </div>

                            <!-- Opsi Minta Koreksi / Revisi Ulang jika ada hal baru -->
                            <div class="pt-2 text-right">
                                <button 
                                    type="button" 
                                    onclick="document.getElementById('modalReject').classList.remove('hidden')"
                                    class="text-xs text-rose-600 hover:text-rose-800 font-medium hover:underline inline-flex items-center gap-1"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>Revisi / Batalkan Persetujuan</span>
                                </button>
                            </div>
                        </div>

                    @elseif($suratKeluar->status_persetujuan === 'ditolak')
                        <div class="space-y-4">
                            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs space-y-2">
                                <div class="flex items-center gap-2 text-rose-800 font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                    <span>Draf Surat Ditolak / Memerlukan Revisi Staf TU</span>
                                </div>
                                <div class="bg-white p-3.5 rounded-lg border border-rose-100 text-rose-950 font-medium text-xs">
                                    <span class="text-rose-500 font-semibold block text-[11px]">Poin Catatan Perbaikan dari Pimpinan:</span>
                                    "{{ $suratKeluar->catatan_kepsek }}"
                                </div>
                            </div>

                            <!-- Opsi Setujui Ulang jika staf sudah klarifikasi -->
                            <div class="pt-2 text-right">
                                <button 
                                    type="button" 
                                    onclick="document.getElementById('modalApprove').classList.remove('hidden')"
                                    class="text-xs text-emerald-700 hover:text-emerald-900 font-semibold hover:underline inline-flex items-center gap-1"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Setujui Draf Sekarang</span>
                                </button>
                            </div>
                        </div>

                    @else
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-600">
                            Surat keluar ini masih berupa draft lokal staf TU dan belum diajukan secara resmi.
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Column: Document Viewer (5 Cols) -->
        <div class="lg:col-span-5 space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden sticky top-24">
                <div class="px-5 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-slate-800">Pratinjau Draf Dokumen</h3>
                            <p class="text-[10px] text-slate-400 font-mono">{{ $suratKeluar->file_size_formatted }}</p>
                        </div>
                    </div>

                    @if($suratKeluar->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($suratKeluar->file_path))
                        <button 
                            type="button" 
                            onclick="window.openPdfModal('{{ asset('storage/' . $suratKeluar->file_path) }}', 'Surat Keluar: {{ addslashes($suratKeluar->nomor_surat) }}')"
                            class="p-1.5 text-slate-500 hover:text-emerald-800 hover:bg-slate-100 rounded-lg transition-colors"
                            title="Layar Penuh"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                        </button>
                    @endif
                </div>

                <div class="bg-slate-900 h-[540px] flex items-center justify-center overflow-hidden">
                    @if($suratKeluar->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($suratKeluar->file_path))
                        @php
                            $ext = strtolower(pathinfo($suratKeluar->file_path, PATHINFO_EXTENSION));
                        @endphp

                        @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset('storage/' . $suratKeluar->file_path) }}" alt="{{ $suratKeluar->file_name }}" class="max-h-full max-w-full object-contain p-2">
                        @else
                            <iframe 
                                src="{{ asset('storage/' . $suratKeluar->file_path) }}#toolbar=0" 
                                class="w-full h-full border-0" 
                                title="Pratinjau Draf Surat"
                            ></iframe>
                        @endif
                    @else
                        <div class="text-center p-6 text-slate-400">
                            <p class="text-xs font-semibold">Berkas Draf Tidak Ditemukan</p>
                            <p class="text-[10px] mt-1 text-slate-500">File fisik surat belum diunggah atau tidak tersimpan di storage.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Modal 1: Konfirmasi Setujui Surat Keluar -->
<div id="modalApprove" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs transition-opacity duration-200 hidden" role="dialog" aria-modal="true">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all duration-200 text-slate-800 animate-in fade-in zoom-in-95">
        <form action="{{ route('kepsek.persetujuan.approve', $suratKeluar) }}" method="POST">
            @csrf
            <div class="p-6 pb-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 border bg-emerald-50 text-emerald-600 border-emerald-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="flex-grow pt-0.5">
                        <h3 class="font-heading font-bold text-base text-slate-900 leading-snug">Konfirmasi Persetujuan Surat</h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Otorisasi resmi draf surat keluar dinas SMKN 1 Subang.</p>
                    </div>
                    <button type="button" onclick="closeApproveModal()" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer shrink-0" title="Tutup (Esc)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <div class="px-6 pb-5 space-y-3.5 text-xs">
                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 space-y-1.5">
                    <p><span class="text-slate-400">Nomor Surat:</span> <strong class="text-slate-900 font-mono">{{ $suratKeluar->nomor_surat }}</strong></p>
                    <p><span class="text-slate-400">Tujuan:</span> <span class="text-slate-800 font-medium">{{ $suratKeluar->tujuan }}</span></p>
                    <p><span class="text-slate-400">Perihal:</span> <span class="text-slate-800 font-medium">{{ $suratKeluar->perihal }}</span></p>
                </div>

                <div>
                    <label for="catatan_approve" class="block text-xs font-semibold text-slate-700 mb-1">
                        Catatan Persetujuan Pimpinan (Opsional):
                    </label>
                    <textarea 
                        name="catatan_kepsek" 
                        id="catatan_approve" 
                        rows="2" 
                        placeholder="Disetujui untuk diterbitkan secara resmi..."
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all"
                    ></textarea>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button 
                    type="button" 
                    onclick="closeApproveModal()"
                    class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors cursor-pointer shadow-2xs"
                >
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="px-4.5 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition-colors cursor-pointer flex items-center gap-1.5"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Ya, Setujui Sekarang</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Formulir Penolakan / Permintaan Revisi -->
<div id="modalReject" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs transition-opacity duration-200 hidden" role="dialog" aria-modal="true">
    <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all duration-200 text-slate-800 animate-in fade-in zoom-in-95">
        <form action="{{ route('kepsek.persetujuan.reject', $suratKeluar) }}" method="POST">
            @csrf
            <div class="p-6 pb-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 border bg-rose-50 text-rose-600 border-rose-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="flex-grow pt-0.5">
                        <h3 class="font-heading font-bold text-base text-slate-900 leading-snug">Tolak / Minta Revisi Draf</h3>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Berikan catatan koreksi perbaikan kepada staf Tata Usaha.</p>
                    </div>
                    <button type="button" onclick="closeRejectModal()" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer shrink-0" title="Tutup (Esc)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <div class="px-6 pb-5 space-y-3.5 text-xs">
                <div class="p-3 rounded-xl border text-[11px] leading-relaxed font-medium bg-rose-50/80 text-rose-700 border-rose-100">
                    Status surat akan berubah menjadi <strong class="text-rose-800">Ditolak / Revisi</strong> dan staf TU dapat mengunggah berkas yang telah diperbaiki.
                </div>

                <div>
                    <label for="catatan_reject" class="block text-xs font-semibold text-slate-700 mb-1">
                        Poin Koreksi / Alasan Penolakan <span class="text-rose-500">*</span>
                    </label>
                    <textarea 
                        name="catatan_kepsek" 
                        id="catatan_reject" 
                        rows="3" 
                        required 
                        minlength="5"
                        placeholder="Contoh: Perbaiki format penulisan nomor lampiran, sesuaikan tujuan surat ke Kepala Dinas Pendidikan..."
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all"
                    ></textarea>
                    <p class="text-[10px] text-slate-400 mt-1">Wajib diisi minimal 5 karakter agar staf TU memahami hal yang perlu diperbaiki.</p>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end gap-2.5">
                <button 
                    type="button" 
                    onclick="closeRejectModal()"
                    class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors cursor-pointer shadow-2xs"
                >
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="px-4.5 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-xs transition-colors cursor-pointer flex items-center gap-1.5"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Kirim Catatan Revisi</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openApproveModal() {
        document.getElementById('modalApprove').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    function closeApproveModal() {
        document.getElementById('modalApprove').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    function openRejectModal() {
        document.getElementById('modalReject').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    function closeRejectModal() {
        document.getElementById('modalReject').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeApproveModal();
            closeRejectModal();
        }
    });
</script>
@endsection
