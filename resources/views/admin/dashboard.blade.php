@extends('layouts.admin')

@section('title', 'Dashboard Petugas TU')

@section('content')
<div class="space-y-6">

    <!-- Modern Page Header -->
    <x-page-header 
        title="Dashboard Administrasi & Kearsipan" 
        description="Pusat kendali pengelolaan arsip persuratan dan verifikasi legalisir SMKN 1 Subang"
        badge="Sistem Informasi Kearsipan"
        theme="blue"
    >
        <x-slot:actions>
            <a href="{{ url('/admin/surat-masuk/create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm shadow-blue-500/20 active:scale-[0.98] transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Catat Surat Masuk</span>
            </a>
            <a href="{{ url('/admin/surat-keluar/create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl shadow-xs active:scale-[0.98] transition-all cursor-pointer">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                <span>Draf Surat Keluar</span>
            </a>
        </x-slot:actions>
    </x-page-header>

    <!-- KPI Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Card 1: Surat Masuk -->
        <x-stat-card 
            label="Surat Masuk"
            :value="number_format(\App\Models\SuratMasuk::count())"
            :sub="\App\Models\SuratMasuk::where('status', 'didisposisikan')->count() . ' berkas didisposisikan'"
            color="blue"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <!-- Card 2: Surat Keluar -->
        <x-stat-card 
            label="Surat Keluar"
            :value="number_format(\App\Models\SuratKeluar::count())"
            :sub="\App\Models\SuratKeluar::where('status_persetujuan', 'disetujui')->count() . ' disetujui Kepala Sekolah'"
            color="teal"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <!-- Card 3: Permohonan Legalisir -->
        <x-stat-card 
            label="Legalisir Aktif"
            :value="number_format(\App\Models\PengajuanLegalisir::whereNotIn('status', ['selesai', 'ditolak'])->count())"
            :sub="\App\Models\PengajuanLegalisir::where('status', 'menunggu_verifikasi')->count() . ' butuh verifikasi TU'"
            color="purple"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <!-- Card 4: Kategori Dinas -->
        <x-stat-card 
            label="Kategori Dinas"
            :value="number_format(\App\Models\KategoriSurat::count())"
            sub="Klasifikasi standar kearsipan"
            color="sky"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </x-slot:icon>
        </x-stat-card>
    </div>

    <!-- 2 Column Section: Surat Masuk Terkini & Legalisir Terkini -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Left Table: 4 Surat Masuk Terkini -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="font-bold text-sm text-slate-900">Surat Masuk Terkini</h3>
                    <p class="text-xs text-slate-500">Daftar agenda registrasi surat masuk terbaru</p>
                </div>
                <a href="{{ url('/admin/surat-masuk') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">Lihat Semua &rarr;</a>
            </div>

            <div class="divide-y divide-slate-100 flex-grow">
                @php
                    $latestSm = \App\Models\SuratMasuk::with('kategori')->latest('tanggal_terima')->take(4)->get();
                @endphp

                @forelse($latestSm as $sm)
                    <div class="p-4 hover:bg-slate-50/80 transition-colors flex items-start justify-between gap-3 text-xs">
                        <div class="space-y-1 overflow-hidden">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-slate-900">{{ $sm->nomor_agenda }}</span>
                                <x-status-badge :status="$sm->status" type="surat_masuk" />
                            </div>
                            <h4 class="font-semibold text-slate-800 truncate" title="{{ $sm->perihal }}">{{ $sm->perihal }}</h4>
                            <p class="text-slate-500 truncate">Pengirim: {{ $sm->pengirim }}</p>
                            <span class="inline-block text-[10px] text-slate-400 font-mono">Diterima: {{ \Carbon\Carbon::parse($sm->tanggal_terima)->format('d M Y') }}</span>
                        </div>

                        @if($sm->file_path)
                            <button 
                                type="button" 
                                onclick="window.openPdfModal('{{ asset('storage/' . $sm->file_path) }}', '{{ addslashes($sm->perihal) }}')"
                                class="p-2 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-500 hover:text-blue-600 border border-slate-200 transition-colors shrink-0 cursor-pointer"
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

        <!-- Right Table: 4 Pengajuan Legalisir Terkini -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="font-bold text-sm text-slate-900">Permohonan Legalisir Terkini</h3>
                    <p class="text-xs text-slate-500">Berkas permohonan alumni yang perlu verifikasi</p>
                </div>
                <a href="{{ url('/admin/legalisir') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">Lihat Semua &rarr;</a>
            </div>

            <div class="divide-y divide-slate-100 flex-grow">
                @php
                    $latestLegalisir = \App\Models\PengajuanLegalisir::latest()->take(4)->get();
                @endphp

                @forelse($latestLegalisir as $lgl)
                    <div class="p-4 hover:bg-slate-50/80 transition-colors flex items-start justify-between gap-3 text-xs">
                        <div class="space-y-1 overflow-hidden">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-blue-600">{{ $lgl->nomor_pengajuan }}</span>
                                <x-status-badge :status="$lgl->status" type="legalisir" />
                            </div>
                            <h4 class="font-semibold text-slate-800 truncate">{{ $lgl->nama_pemohon }} <span class="font-normal text-slate-400 font-mono">({{ $lgl->nisn }})</span></h4>
                            <p class="text-slate-500 truncate">Lulus {{ $lgl->tahun_lulus }} • {{ strtoupper($lgl->jenis_dokumen) }} ({{ $lgl->jumlah_lembar }} Lembar)</p>
                            <span class="inline-block text-[10px] text-slate-400 font-mono">Diajukan: {{ $lgl->created_at->format('d M Y H:i') }}</span>
                        </div>

                        <a 
                            href="{{ url('/admin/legalisir/' . $lgl->id) }}" 
                            class="px-2.5 py-1.5 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-600 hover:text-blue-600 font-semibold border border-slate-200 transition-colors shrink-0 text-center"
                        >
                            Detail
                        </a>
                    </div>
                @empty
                    <div class="p-6 text-center text-xs text-slate-400">Belum ada berkas permohonan legalisir.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Shortcuts Toolbar -->
    <div class="bg-gradient-to-r from-blue-900 to-indigo-950 p-6 rounded-2xl text-white shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="space-y-1 text-center md:text-left">
            <h3 class="font-bold text-base">Pencarian Cerdas Terpadu KMP</h3>
            <p class="text-xs text-blue-200 max-w-xl">
                Temukan arsip surat masuk, draf surat keluar, dan dokumen legalisir alumni secara instan dengan algoritma Knuth-Morris-Pratt tanpa proses penelusuran ulang berulang (tanpa *backtracking*).
            </p>
        </div>
        <a 
            href="{{ url('/admin/pencarian-kmp') }}" 
            class="px-5 py-2.5 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs rounded-xl shadow-sm transition-all hover:scale-105 active:scale-[0.98] shrink-0"
        >
            Buka Mesin KMP &rarr;
        </a>
    </div>

</div>
@endsection
