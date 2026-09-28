@extends('layouts.admin')

@section('title', 'Dashboard Petugas TU')

@section('page_title', 'Dashboard Administrasi & Kearsipan')
@section('page_subtitle', 'Pusat kendali pengelolaan arsip persuratan dan verifikasi legalisir SMKN 1 Subang')

@section('page_actions')
    <a href="{{ url('/admin/surat-masuk/create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-xs transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Catat Surat Masuk</span>
    </a>
    <a href="{{ url('/admin/surat-keluar/create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl shadow-xs transition-colors">
        <svg class="w-4 h-4 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
        <span>Draf Surat Keluar</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <!-- KPI Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Card 1: Surat Masuk -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Surat Masuk</span>
                <div class="font-heading text-2xl font-extrabold text-blue-950 mt-1">
                    {{ \App\Models\SuratMasuk::count() }}
                </div>
                <div class="text-[11px] text-slate-500 mt-0.5">
                    <span class="font-semibold text-blue-700">{{ \App\Models\SuratMasuk::where('status', 'didisposisikan')->count() }}</span> berkas didisposisikan
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-800 flex items-center justify-center shrink-0 border border-blue-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </div>
        </div>

        <!-- Card 2: Surat Keluar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Surat Keluar</span>
                <div class="font-heading text-2xl font-extrabold text-blue-950 mt-1">
                    {{ \App\Models\SuratKeluar::count() }}
                </div>
                <div class="text-[11px] text-slate-500 mt-0.5">
                    <span class="font-semibold text-emerald-700">{{ \App\Models\SuratKeluar::where('status_persetujuan', 'disetujui')->count() }}</span> disetujui Kepala Sekolah
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-800 flex items-center justify-center shrink-0 border border-teal-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </div>
        </div>

        <!-- Card 3: Permohonan Legalisir -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Legalisir Aktif</span>
                <div class="font-heading text-2xl font-extrabold text-blue-950 mt-1">
                    {{ \App\Models\PengajuanLegalisir::whereNotIn('status', ['selesai', 'ditolak'])->count() }}
                </div>
                <div class="text-[11px] text-slate-500 mt-0.5">
                    <span class="font-semibold text-amber-700">{{ \App\Models\PengajuanLegalisir::where('status', 'menunggu_verifikasi')->count() }}</span> butuh verifikasi TU
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-800 flex items-center justify-center shrink-0 border border-purple-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <!-- Card 4: Kategori Dinas -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori Dinas</span>
                <div class="font-heading text-2xl font-extrabold text-blue-950 mt-1">
                    {{ \App\Models\KategoriSurat::count() }}
                </div>
                <div class="text-[11px] text-slate-500 mt-0.5">
                    Klasifikasi standar kearsipan
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center shrink-0 border border-slate-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
        </div>
    </div>

    <!-- 2 Column Section: Surat Masuk Terkini & Legalisir Terkini -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Left Table: 5 Surat Masuk Terkini -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="font-heading font-bold text-sm text-slate-900">Surat Masuk Terkini</h3>
                    <p class="text-xs text-slate-500">Daftar agenda registrasi surat masuk terbaru</p>
                </div>
                <a href="{{ url('/admin/surat-masuk') }}" class="text-xs font-semibold text-blue-900 hover:text-blue-700">Lihat Semua &rarr;</a>
            </div>

            <div class="divide-y divide-slate-100 flex-grow">
                @php
                    $latestSm = \App\Models\SuratMasuk::with('kategori')->latest('tanggal_terima')->take(4)->get();
                @endphp

                @forelse($latestSm as $sm)
                    <div class="p-4 hover:bg-slate-50 transition-colors flex items-start justify-between gap-3 text-xs">
                        <div class="space-y-1 overflow-hidden">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-slate-900">{{ $sm->nomor_agenda }}</span>
                                <x-status-badge :status="$sm->status" type="surat_masuk" />
                            </div>
                            <h4 class="font-semibold text-slate-800 truncate" title="{{ $sm->perihal }}">{{ $sm->perihal }}</h4>
                            <p class="text-slate-500 truncate">Pengirim: {{ $sm->pengirim }}</p>
                            <span class="inline-block text-[10px] text-slate-400 font-mono">Diterima: {{ $sm->tanggal_terima->format('d M Y') }}</span>
                        </div>

                        @if($sm->file_path)
                            <button 
                                type="button" 
                                onclick="window.openPdfModal('{{ asset('storage/' . $sm->file_path) }}', '{{ addslashes($sm->perihal) }}')"
                                class="p-2 rounded-lg bg-slate-100 hover:bg-blue-100 hover:text-blue-900 text-slate-600 transition-colors shrink-0"
                                title="Pratinjau PDF"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        @endif
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">Belum ada arsip surat masuk yang tercatat.</div>
                @endforelse
            </div>
        </div>

        <!-- Right Table: 5 Pengajuan Legalisir Terkini -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="font-heading font-bold text-sm text-slate-900">Permohonan Legalisir Terkini</h3>
                    <p class="text-xs text-slate-500">Antrean permohonan legalisir alumni & siswa</p>
                </div>
                <a href="{{ url('/admin/legalisir') }}" class="text-xs font-semibold text-blue-900 hover:text-blue-700">Lihat Semua &rarr;</a>
            </div>

            <div class="divide-y divide-slate-100 flex-grow">
                @php
                    $latestLeg = \App\Models\PengajuanLegalisir::latest()->take(4)->get();
                @endphp

                @forelse($latestLeg as $leg)
                    <div class="p-4 hover:bg-slate-50 transition-colors flex items-start justify-between gap-3 text-xs">
                        <div class="space-y-1 overflow-hidden">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-teal-800">{{ $leg->nomor_pengajuan }}</span>
                                <x-status-badge :status="$leg->status" type="legalisir" />
                            </div>
                            <h4 class="font-semibold text-slate-800">{{ $leg->nama_pemohon }} (NISN: {{ $leg->nisn }})</h4>
                            <p class="text-slate-500">{{ $leg->jenis_dokumen_label }} &bull; {{ $leg->jumlah_lembar }} lembar</p>
                            <span class="inline-block text-[10px] text-slate-400">Diajukan: {{ $leg->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>

                        @if($leg->file_dokumen_path)
                            <button 
                                type="button" 
                                onclick="window.openPdfModal('{{ asset('storage/' . $leg->file_dokumen_path) }}', 'Berkas Legalisir: {{ addslashes($leg->nama_pemohon) }}')"
                                class="p-2 rounded-lg bg-slate-100 hover:bg-teal-100 hover:text-teal-900 text-slate-600 transition-colors shrink-0"
                                title="Pratinjau Berkas Pemohon"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        @endif
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">Belum ada pengajuan legalisir masuk.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- System Diagnostics Card -->
    <div class="bg-gradient-to-r from-blue-950 via-slate-900 to-blue-900 text-white rounded-2xl p-5 shadow-xs border border-blue-900/50 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-300 flex items-center justify-center shrink-0 border border-teal-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div class="text-xs">
                <h4 class="font-bold text-white text-sm">Status Kesiapan Sistem Kearsipan</h4>
                <p class="text-slate-300 mt-0.5">Database MySQL Aktif &bull; Algoritma KMP Engine Terhubung &bull; Zona Waktu: Asia/Jakarta (WIB)</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-1.5 animate-pulse"></span>
                Operasional Normal
            </span>
        </div>
    </div>

</div>
@endsection
