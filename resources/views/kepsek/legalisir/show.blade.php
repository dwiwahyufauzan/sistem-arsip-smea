@extends('layouts.kepsek')

@section('title', 'Tinjauan Pengesahan Legalisir - ' . $legalisir->nomor_pengajuan)
@section('page_title', 'Tinjauan Pengesahan Legalisir')
@section('page_subtitle', 'Lembar Otorisasi & Validasi Dokumen Kelulusan Resmi SMKN 1 Subang')

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                    <a href="{{ route('kepsek.legalisir.index') }}" class="hover:text-emerald-700 transition-colors">&larr; Kembali ke Daftar Pengesahan</a>
                    <span>•</span>
                    <span class="text-emerald-700 font-mono">{{ $legalisir->nomor_pengajuan }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                        {{ $legalisir->nama_pemohon }} — {{ $legalisir->jenis_dokumen_label }}
                    </h1>
                    <x-status-badge :status="$legalisir->status" type="legalisir" class="text-xs px-3 py-1" />
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    Diajukan oleh alumni pada <span class="font-semibold text-slate-700">{{ $legalisir->created_at->translatedFormat('l, d F Y, H:i') }} WIB</span>.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a 
                    href="{{ route('legalisir.download', $legalisir->id) }}" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors"
                >
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Berkas Scan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- Left Column: Details & Document Preview (2 cols) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Card 1: Data Pemohon & Verifikasi Tata Usaha -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>Identitas Pemohon & Verifikasi Arsip Sekolah</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 font-medium block">Nama Lengkap Pemohon</span>
                        <span class="text-sm font-bold text-slate-900 block mt-0.5">{{ $legalisir->nama_pemohon }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">NISN / Tahun Kelulusan</span>
                        <span class="text-sm font-bold text-slate-900 block mt-0.5 font-mono">{{ $legalisir->nisn }} (Lulus: {{ $legalisir->tahun_lulus }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Dokumen yang Dilegalisir</span>
                        <span class="text-slate-800 font-bold block mt-0.5">{{ $legalisir->jenis_dokumen_label }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Jumlah Permohonan Salinan</span>
                        <span class="text-slate-800 font-bold block mt-0.5">{{ $legalisir->jumlah_lembar }} Lembar Fisik</span>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="text-slate-400 font-medium block">Keperluan Permohonan</span>
                        <p class="text-slate-800 font-medium mt-0.5 bg-slate-50 p-3 rounded-xl border border-slate-200">
                            {{ $legalisir->keperluan }}
                        </p>
                    </div>
                </div>

                <!-- Verification by TU Notice Box -->
                <div class="p-4 rounded-xl bg-blue-50/70 border border-blue-200 text-xs space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-blue-900">Catatan Verifikasi Staf Tata Usaha:</span>
                        <span class="text-[11px] text-blue-700 font-medium">{{ $legalisir->petugas->name ?? 'Petugas Tata Usaha' }}</span>
                    </div>
                    <p class="text-blue-800 leading-relaxed italic">
                        "{{ $legalisir->catatan_petugas ?? 'Dokumen pindaian telah diverifikasi dan dinyatakan sesuai dengan data kearsipan kelulusan SMKN 1 Subang.' }}"
                    </p>
                </div>
            </div>

            <!-- Card 2: Pratinjau Dokumen -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>Pratinjau Pindaian Berkas Dokumen</span>
                    </h2>
                    <a href="{{ asset('storage/' . $legalisir->file_dokumen_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline font-semibold flex items-center gap-1">
                        Buka Resolusi Penuh &rarr;
                    </a>
                </div>

                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                    @php
                        $ext = strtolower(pathinfo($legalisir->file_dokumen_path ?? '', PATHINFO_EXTENSION));
                        $url = asset('storage/' . $legalisir->file_dokumen_path);
                    @endphp

                    @if($ext === 'pdf')
                        <div class="aspect-[4/3] w-full rounded-lg overflow-hidden border border-slate-300 bg-white shadow-inner">
                            <iframe src="{{ $url }}#toolbar=0" class="w-full h-full" title="PDF Preview"></iframe>
                        </div>
                    @elseif(in_array($ext, ['jpg', 'jpeg', 'png']))
                        <div class="max-h-[500px] overflow-auto rounded-lg border border-slate-300 bg-white p-2 flex items-center justify-center">
                            <img src="{{ $url }}" alt="Scan Dokumen" class="max-w-full h-auto object-contain rounded">
                        </div>
                    @else
                        <div class="p-6 text-center text-xs text-slate-500">
                            <p>Pratinjau berkas tidak tersedia langsung.</p>
                            <a href="{{ route('legalisir.download', $legalisir->id) }}" class="mt-2 inline-flex items-center gap-1 text-emerald-600 font-semibold hover:underline">
                                Unduh berkas &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card 3: Kronologi Riwayat Status -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Kronologi Audit Trail</span>
                </h2>

                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @forelse($legalisir->riwayat as $idx => $hist)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center ring-8 ring-white">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <x-status-badge :status="$hist->status_baru" type="legalisir" />
                                                    <span class="text-xs text-slate-500 font-medium">oleh {{ $hist->user->name ?? 'Sistem' }}</span>
                                                </div>
                                                <p class="text-xs text-slate-700 mt-1 leading-relaxed bg-slate-50 p-2.5 rounded-lg border border-slate-200/60">
                                                    {{ $hist->catatan }}
                                                </p>
                                            </div>
                                            <div class="text-right text-xs whitespace-nowrap text-slate-400">
                                                <time datetime="{{ $hist->created_at }}">{{ $hist->created_at->translatedFormat('d M Y, H:i') }} WIB</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-xs text-slate-500 py-2">Belum ada kronologi riwayat.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>

        <!-- Right Column: Approval Panel (1 col) -->
        <div class="space-y-6">

            <!-- Panel Keputusan Kepala Sekolah -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">
                    Otorisasi Kepala Sekolah
                </h3>

                @if($legalisir->status === 'menunggu_approval_kepsek')
                    <div class="border border-emerald-300 bg-emerald-50/50 rounded-xl p-4 space-y-3">
                        <div class="flex items-center gap-2 text-emerald-900 font-bold text-xs">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 animate-ping"></span>
                            <span>Menunggu Pengesahan Anda</span>
                        </div>
                        <p class="text-[11px] text-emerald-800 leading-relaxed">
                            Setelah disetujui, staf Tata Usaha akan mencetak salinan fisik dokumen dan membubuhkan stempel legalisir basah SMKN 1 Subang.
                        </p>

                        <!-- Form Persetujuan -->
                        <form action="{{ route('kepsek.legalisir.approve', $legalisir->id) }}" method="POST" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-700 mb-1">Catatan Persetujuan (Opsional):</label>
                                <textarea name="catatan_kepsek" rows="2" placeholder="Disetujui untuk pengesahan tanda tangan dan cap stempel resmi..." class="w-full text-xs bg-white border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-emerald-600"></textarea>
                            </div>

                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengesahan legalisir dokumen ini?')" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors cursor-pointer flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>Setujui & Sahkan Legalisir</span>
                            </button>
                        </form>
                    </div>

                    <!-- Form Penolakan -->
                    <div class="pt-2 border-t border-slate-200">
                        <details class="group text-xs">
                            <summary class="font-semibold text-rose-600 hover:text-rose-700 cursor-pointer flex items-center justify-between p-2 rounded-lg hover:bg-rose-50 transition-colors">
                                <span>Tolak Pengesahan Legalisir</span>
                                <span class="transition-transform group-open:rotate-180">&darr;</span>
                            </summary>
                            <form action="{{ route('kepsek.legalisir.reject', $legalisir->id) }}" method="POST" class="mt-3 p-3 bg-rose-50 border border-rose-200 rounded-xl space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-[11px] font-semibold text-rose-900 mb-1">Catatan Alasan Penolakan: <span class="text-rose-600">*</span></label>
                                    <textarea name="catatan_kepsek" rows="3" required placeholder="Jelaskan alasan penolakan pengesahan..." class="w-full text-xs bg-white border border-rose-300 rounded-lg p-2 text-rose-950 focus:ring-2 focus:ring-rose-500"></textarea>
                                </div>

                                <button type="submit" onclick="return confirm('Tolak permohonan legalisir ini?')" class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl transition-colors cursor-pointer">
                                    Konfirmasi Penolakan Pengesahan
                                </button>
                            </form>
                        </details>
                    </div>
                @else
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500 font-medium">Status Saat Ini:</span>
                            <x-status-badge :status="$legalisir->status" type="legalisir" />
                        </div>
                        @if($legalisir->catatan_kepsek)
                            <div class="pt-2 border-t border-slate-200">
                                <span class="text-slate-500 font-medium block">Catatan Pengesahan Kepsek:</span>
                                <p class="text-slate-800 font-semibold mt-0.5 italic">
                                    "{{ $legalisir->catatan_kepsek }}"
                                </p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Panel Tata Kelola Sekolah -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 text-xs text-slate-600 space-y-2">
                <h4 class="font-bold text-slate-800 uppercase tracking-wider text-[11px]">Standar Layanan Kearsipan</h4>
                <p class="leading-relaxed">
                    Setiap pengesahan legalisir didokumentasikan dalam log aktivitas kearsipan resmi SMKN 1 Subang untuk menjaga akuntabilitas dokumen negara.
                </p>
            </div>

        </div>

    </div>

</div>
@endsection
