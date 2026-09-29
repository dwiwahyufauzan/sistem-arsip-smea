@extends('layouts.admin')

@section('title', 'Pencarian Cerdas Terpadu KMP')

@section('content')
<div class="space-y-6">

    <!-- Header & Hero Search Bar -->
    <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white shadow-lg border border-slate-800">
        <div class="max-w-3xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span>Mesin Pencari Presisi Knuth-Morris-Pratt (KMP)</span>
            </div>
            
            <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-white tracking-tight">
                Pencarian Cerdas Terpadu Seluruh Arsip SMEA
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Pencarian simultan teks secara linear tanpa <span class="italic">backtracking</span> pada berkas Surat Masuk, Surat Keluar, dan Permohonan Legalisir dengan penandaan warna (*highlighting*).
            </p>

            <!-- Search Form -->
            <form action="{{ route('admin.pencarian-kmp') }}" method="GET" class="pt-2">
                <input type="hidden" name="modul" value="{{ $modul }}">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $query }}" 
                            placeholder="Ketik nomor surat, perihal, pengirim, instansi, atau nama pemohon..." 
                            required
                            class="w-full pl-11 pr-24 py-3.5 bg-white/10 hover:bg-white/15 focus:bg-white border border-white/20 focus:border-blue-500 rounded-2xl text-sm font-medium text-white focus:text-slate-900 placeholder-slate-400 focus:placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition-all shadow-inner"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center gap-1.5 pointer-events-none">
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-blue-600/60 text-white">KMP O(n+m)</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button 
                            type="submit" 
                            class="px-6 py-3.5 bg-blue-600 hover:bg-blue-500 active:scale-[0.98] text-white text-xs sm:text-sm font-bold rounded-2xl shadow-md shadow-blue-600/30 transition-all cursor-pointer flex items-center justify-center gap-2 shrink-0"
                        >
                            <span>Cari Presisi</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>

                        @if($query !== '')
                            <a 
                                href="{{ route('admin.pencarian-kmp') }}" 
                                class="p-3.5 bg-white/10 hover:bg-white/20 text-white rounded-2xl transition-colors"
                                title="Reset Pencarian"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Suggestion Chips & Benchmark Toggle -->
                <div class="mt-4 flex flex-wrap items-center justify-between gap-3 text-xs">
                    <div class="flex flex-wrap items-center gap-1.5 text-slate-300">
                        <span class="text-slate-400">Kata kunci saran:</span>
                        @foreach(['Dinas Pendidikan', 'UKK', 'Kurikulum', 'Undangan', 'Ijazah', 'PKL'] as $chip)
                            <a 
                                href="{{ route('admin.pencarian-kmp', ['q' => $chip, 'modul' => $modul]) }}" 
                                class="px-2.5 py-1 rounded-lg bg-white/10 hover:bg-white/20 text-blue-200 transition-colors"
                            >
                                {{ $chip }}
                            </a>
                        @endforeach
                    </div>

                    @if($query !== '')
                        <label class="inline-flex items-center gap-2 cursor-pointer text-slate-300 hover:text-white">
                            <input 
                                type="checkbox" 
                                name="compare" 
                                value="1" 
                                {{ $runCompare ? 'checked' : '' }} 
                                onchange="this.form.submit()" 
                                class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500 border-white/20 bg-white/10"
                            >
                            <span class="font-medium text-[11px]">Uji Komparasi KMP vs Brute Force (Skripsi)</span>
                        </label>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($query !== '')
        
        <!-- Algorithmic Insights & Metrics Bar -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs space-y-4">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-sm shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-slate-900 text-sm">Metrik Pencarian Algoritma KMP</h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-100 text-emerald-800">
                                Waktu: {{ $totalTimeMs }} ms
                            </span>
                        </div>
                        <p class="text-xs text-slate-500">
                            Ditemukan <span class="font-bold text-slate-900">{{ $totalMatches }}</span> arsip yang memuat pola kata kunci <span class="font-bold text-blue-700">"{{ $query }}"</span>.
                        </p>
                    </div>
                </div>

                <!-- LPS Table Visualization Accordion -->
                @if(!empty($lpsTable))
                    <details class="group text-xs">
                        <summary class="font-semibold text-blue-600 hover:text-blue-800 cursor-pointer flex items-center gap-1.5 p-2 rounded-xl hover:bg-blue-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span>Lihat Tabel Pergeseran LPS (Longest Proper Prefix-Suffix)</span>
                            <span class="transition-transform group-open:rotate-180">&darr;</span>
                        </summary>
                        <div class="mt-2 p-3 bg-slate-50 border border-slate-200 rounded-xl overflow-x-auto">
                            <p class="text-[10px] text-slate-500 mb-2 font-medium">Tabel lompatan pergeseran indeks pola saat terjadi ketidakcocokan karakter:</p>
                            <table class="text-[11px] font-mono border-collapse">
                                <thead>
                                    <tr class="text-slate-400">
                                        <th class="p-1 border border-slate-200 text-left">Indeks (i)</th>
                                        @foreach(mb_str_split($query) as $idx => $char)
                                            <th class="p-1 border border-slate-200 text-center w-7">{{ $idx }}</th>
                                        @endforeach
                                    </tr>
                                    <tr class="text-slate-800">
                                        <th class="p-1 border border-slate-200 text-left">Karakter P[i]</th>
                                        @foreach(mb_str_split($query) as $char)
                                            <th class="p-1 border border-slate-200 text-center font-bold bg-blue-50 text-blue-900">{{ $char }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-slate-900 font-bold">
                                        <td class="p-1 border border-slate-200">Nilai LPS[i]</td>
                                        @foreach($lpsTable as $val)
                                            <td class="p-1 border border-slate-200 text-center bg-white text-emerald-700">{{ $val }}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </details>
                @endif
            </div>

            <!-- Scientific Benchmark Comparison Card (Bab IV Skripsi) -->
            @if($benchmarkData)
                <div class="p-4 rounded-xl bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-amber-900">
                                Hasil Pengujian Benchmark Komparasi Kuantitatif (Bab IV Skripsi)
                            </h4>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-200 text-amber-900">
                            {{ $benchmarkData['iterations'] }} Iterasi Pengujian
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                        <div class="p-3 bg-white rounded-lg border border-amber-200">
                            <span class="text-slate-500 block text-[11px] font-medium">Algoritma KMP (Usulan)</span>
                            <p class="text-lg font-extrabold text-blue-900 mt-0.5">{{ $benchmarkData['kmp']['avg_time_ms'] }} ms</p>
                            <span class="text-[10px] text-slate-400 font-mono">Kompleksitas: O(n + m)</span>
                        </div>
                        <div class="p-3 bg-white rounded-lg border border-amber-200">
                            <span class="text-slate-500 block text-[11px] font-medium">Algoritma Naïve / Brute Force</span>
                            <p class="text-lg font-extrabold text-slate-700 mt-0.5">{{ $benchmarkData['brute_force']['avg_time_ms'] }} ms</p>
                            <span class="text-[10px] text-slate-400 font-mono">Kompleksitas: O(n × m)</span>
                        </div>
                        <div class="p-3 bg-white rounded-lg border border-amber-200 flex flex-col justify-center">
                            <span class="text-slate-500 block text-[11px] font-medium">Efisiensi Kecepatan:</span>
                            <p class="text-lg font-extrabold text-emerald-700 mt-0.5">
                                {{ $benchmarkData['speedup_percentage'] >= 0 ? '+' : '' }}{{ $benchmarkData['speedup_percentage'] }}%
                            </p>
                            <span class="text-[10px] text-emerald-800 font-semibold">KMP lebih cepat & stabil</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filter Tabs by Module -->
            <div class="flex items-center gap-1 border-t border-slate-100 pt-3 overflow-x-auto text-xs font-semibold">
                <a 
                    href="{{ route('admin.pencarian-kmp', ['q' => $query, 'modul' => 'semua', 'compare' => $runCompare ? 1 : 0]) }}" 
                    class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $modul === 'semua' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Semua Arsip ({{ $totalMatches }})
                </a>
                <a 
                    href="{{ route('admin.pencarian-kmp', ['q' => $query, 'modul' => 'surat_masuk', 'compare' => $runCompare ? 1 : 0]) }}" 
                    class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $modul === 'surat_masuk' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Surat Masuk ({{ count($resultsSuratMasuk) }})
                </a>
                <a 
                    href="{{ route('admin.pencarian-kmp', ['q' => $query, 'modul' => 'surat_keluar', 'compare' => $runCompare ? 1 : 0]) }}" 
                    class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $modul === 'surat_keluar' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Surat Keluar ({{ count($resultsSuratKeluar) }})
                </a>
                <a 
                    href="{{ route('admin.pencarian-kmp', ['q' => $query, 'modul' => 'legalisir', 'compare' => $runCompare ? 1 : 0]) }}" 
                    class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $modul === 'legalisir' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Legalisir Online ({{ count($resultsLegalisir) }})
                </a>
            </div>
        </div>

        <!-- Search Results List -->
        <div class="space-y-4">

            <!-- Section 1: Surat Masuk Matches -->
            @if(in_array($modul, ['semua', 'surat_masuk']) && count($resultsSuratMasuk) > 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="p-4 bg-sky-50/50 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-sky-600"></span>
                            <h3 class="font-bold text-xs uppercase tracking-wider text-slate-800">
                                Arsip Surat Masuk ({{ count($resultsSuratMasuk) }})
                            </h3>
                        </div>
                        <span class="text-xs text-slate-500">Pencarian pada: No. Surat, Pengirim, Perihal, Ringkasan</span>
                    </div>

                    <div class="divide-y divide-slate-100 text-xs">
                        @foreach($resultsSuratMasuk as $item)
                            <div class="p-5 hover:bg-slate-50/80 transition-colors flex flex-col md:flex-row md:items-start justify-between gap-4">
                                <div class="space-y-1.5 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-mono font-bold text-blue-900 text-sm">
                                            {!! $kmpService->highlightMatches($item->nomor_surat, $query) !!}
                                        </span>
                                        <x-status-badge :status="$item->status" type="surat_masuk" />
                                        @if($item->kategori)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700">
                                                {{ $item->kategori->nama_kategori }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="text-slate-600">
                                        <span class="font-medium text-slate-400">Pengirim:</span>
                                        <span class="font-bold text-slate-800">{!! $kmpService->highlightMatches($item->pengirim, $query) !!}</span>
                                        <span class="text-slate-400 mx-1">•</span>
                                        <span class="font-medium text-slate-400">Diterima:</span>
                                        <span class="text-slate-700">{{ $item->tanggal_terima ? $item->tanggal_terima->translatedFormat('d M Y') : '-' }}</span>
                                    </div>

                                    <p class="text-slate-800 font-semibold leading-relaxed">
                                        Perihal: {!! $kmpService->highlightMatches($item->perihal, $query) !!}
                                    </p>

                                    @if($item->ringkasan_isi)
                                        <p class="text-[11px] text-slate-500 bg-slate-50 p-2.5 rounded-xl border border-slate-200/60 leading-relaxed">
                                            {!! $kmpService->highlightMatches($item->ringkasan_isi, $query) !!}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2 shrink-0 pt-2 md:pt-0">
                                    <a 
                                        href="{{ route('admin.surat-masuk.show', $item->id) }}" 
                                        class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold rounded-xl transition-colors text-xs flex items-center gap-1"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>Lihat Detail</span>
                                    </a>
                                    @if($item->file_path)
                                        <a 
                                            href="{{ route('admin.surat-masuk.download', $item->id) }}" 
                                            class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors"
                                            title="Unduh Berkas Scan"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Section 2: Surat Keluar Matches -->
            @if(in_array($modul, ['semua', 'surat_keluar']) && count($resultsSuratKeluar) > 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="p-4 bg-teal-50/50 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-teal-600"></span>
                            <h3 class="font-bold text-xs uppercase tracking-wider text-slate-800">
                                Arsip Surat Keluar ({{ count($resultsSuratKeluar) }})
                            </h3>
                        </div>
                        <span class="text-xs text-slate-500">Pencarian pada: No. Surat, Tujuan, Perihal, Ringkasan</span>
                    </div>

                    <div class="divide-y divide-slate-100 text-xs">
                        @foreach($resultsSuratKeluar as $item)
                            <div class="p-5 hover:bg-slate-50/80 transition-colors flex flex-col md:flex-row md:items-start justify-between gap-4">
                                <div class="space-y-1.5 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-mono font-bold text-teal-900 text-sm">
                                            {!! $kmpService->highlightMatches($item->nomor_surat, $query) !!}
                                        </span>
                                        <x-status-badge :status="$item->status_persetujuan" type="surat_keluar" />
                                        @if($item->kategori)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700">
                                                {{ $item->kategori->nama_kategori }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="text-slate-600">
                                        <span class="font-medium text-slate-400">Tujuan:</span>
                                        <span class="font-bold text-slate-800">{!! $kmpService->highlightMatches($item->tujuan, $query) !!}</span>
                                        <span class="text-slate-400 mx-1">•</span>
                                        <span class="font-medium text-slate-400">Tanggal:</span>
                                        <span class="text-slate-700">{{ $item->tanggal_surat ? $item->tanggal_surat->translatedFormat('d M Y') : '-' }}</span>
                                    </div>

                                    <p class="text-slate-800 font-semibold leading-relaxed">
                                        Perihal: {!! $kmpService->highlightMatches($item->perihal, $query) !!}
                                    </p>

                                    @if($item->isi_ringkas)
                                        <p class="text-[11px] text-slate-500 bg-slate-50 p-2.5 rounded-xl border border-slate-200/60 leading-relaxed">
                                            {!! $kmpService->highlightMatches($item->isi_ringkas, $query) !!}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2 shrink-0 pt-2 md:pt-0">
                                    <a 
                                        href="{{ route('admin.surat-keluar.show', $item->id) }}" 
                                        class="px-3 py-1.5 bg-teal-50 hover:bg-teal-100 text-teal-800 font-semibold rounded-xl transition-colors text-xs flex items-center gap-1"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>Lihat Detail</span>
                                    </a>
                                    @if($item->file_path)
                                        <a 
                                            href="{{ route('admin.surat-keluar.download', $item->id) }}" 
                                            class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors"
                                            title="Unduh Berkas Draf"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Section 3: Permohonan Legalisir Matches -->
            @if(in_array($modul, ['semua', 'legalisir']) && count($resultsLegalisir) > 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="p-4 bg-purple-50/50 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-600"></span>
                            <h3 class="font-bold text-xs uppercase tracking-wider text-slate-800">
                                Permohonan Legalisir Online ({{ count($resultsLegalisir) }})
                            </h3>
                        </div>
                        <span class="text-xs text-slate-500">Pencarian pada: No. Resi, Nama Pemohon, NISN, Keperluan</span>
                    </div>

                    <div class="divide-y divide-slate-100 text-xs">
                        @foreach($resultsLegalisir as $item)
                            <div class="p-5 hover:bg-slate-50/80 transition-colors flex flex-col md:flex-row md:items-start justify-between gap-4">
                                <div class="space-y-1.5 flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-mono font-bold text-purple-900 text-sm">
                                            {!! $kmpService->highlightMatches($item->nomor_pengajuan, $query) !!}
                                        </span>
                                        <x-status-badge :status="$item->status" type="legalisir" />
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-purple-100 text-purple-800">
                                            {{ $item->jenis_dokumen_label }} ({{ $item->jumlah_lembar }} Lembar)
                                        </span>
                                    </div>

                                    <div class="text-slate-600">
                                        <span class="font-medium text-slate-400">Pemohon:</span>
                                        <span class="font-bold text-slate-800">{!! $kmpService->highlightMatches($item->nama_pemohon, $query) !!}</span>
                                        <span class="text-slate-400 mx-1">•</span>
                                        <span class="font-medium text-slate-400">NISN:</span>
                                        <span class="font-mono text-slate-700">{!! $kmpService->highlightMatches($item->nisn, $query) !!} (Lulus {{ $item->tahun_lulus }})</span>
                                    </div>

                                    <p class="text-slate-800 font-semibold leading-relaxed">
                                        Keperluan: {!! $kmpService->highlightMatches($item->keperluan, $query) !!}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2 shrink-0 pt-2 md:pt-0">
                                    <a 
                                        href="{{ route('admin.legalisir.show', $item->id) }}" 
                                        class="px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-800 font-semibold rounded-xl transition-colors text-xs flex items-center gap-1"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>Lembar Verifikasi</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Zero Results State -->
            @if($totalMatches === 0)
                <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 shadow-xs">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-base text-slate-800">Tidak Ditemukan Arsip yang Cocok</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                        Pola pencarian <span class="font-bold text-slate-800">"{{ $query }}"</span> tidak ditemukan pada modul arsip yang dipilih. Coba gunakan kata kunci yang lebih umum.
                    </p>
                </div>
            @endif

        </div>

    @else
        <!-- Initial Blank State with Features Guide -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="font-bold text-sm text-slate-900">Tanpa Backtracking</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Algoritma KMP memanfaatkan tabel fungsi kegagalan (LPS) untuk melompati karakter yang sudah terverifikasi tanpa memundurkan penunjuk teks utama.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="font-bold text-sm text-slate-900">Simultan Lintas Modul</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Menelusuri seluruh arsip Surat Masuk, Surat Keluar, dan Permohonan Legalisir secara bersamaan dalam satu klik pencarian presisi tinggi.
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-2">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="font-bold text-sm text-slate-900">Validasi Metrik Skripsi</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Menampilkan tabel pergeseran LPS dan komparasi kuantitatif terhadap metode Naïve Brute Force untuk kebutuhan Bab IV analisis pengujian.
                </p>
            </div>
        </div>
    @endif

</div>
@endsection
