@extends('layouts.kepsek')

@section('title', 'Pencarian Cepat KMP')
@section('page_title', 'Pencarian Cepat Terpadu KMP')
@section('page_subtitle', 'Penelusuran instan seluruh arsip kearsipan dan legalisir pimpinan berbasis Algoritma Knuth-Morris-Pratt (SRS-KS08 / NFR-07)')

@section('content')
<div class="space-y-6">

    <!-- Header & Hero Search Bar (Emerald Theme) -->
    <div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-teal-950 rounded-3xl p-6 sm:p-8 text-white shadow-lg border border-slate-800">
        <div class="max-w-3xl space-y-4">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Pencarian Cepat Pimpinan — Algoritma KMP</span>
            </div>
            
            <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-white tracking-tight">
                Penelusuran Presisi Seluruh Dokumen Sekolah
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                Pencarian instan arsip Surat Masuk, Surat Keluar, dan Permohonan Legalisir Alumni SMKN 1 Subang dengan komputasi linear $O(n+m)$.
            </p>

            <!-- Search Form -->
            <form action="{{ route('kepsek.pencarian-kmp') }}" method="GET" class="pt-2">
                <input type="hidden" name="modul" value="{{ $modul }}">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $query }}" 
                            placeholder="Cari nomor surat, instansi pengirim, perihal, atau nama siswa..." 
                            required
                            class="w-full pl-11 pr-24 py-3.5 bg-white/10 hover:bg-white/15 focus:bg-white border border-white/20 focus:border-emerald-500 rounded-2xl text-sm font-medium text-white focus:text-slate-900 placeholder-slate-400 focus:placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-emerald-500/30 transition-all shadow-inner"
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center gap-1.5 pointer-events-none">
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-600/60 text-white">KMP Search</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button 
                            type="submit" 
                            class="px-6 py-3.5 bg-emerald-600 hover:bg-emerald-500 active:scale-[0.98] text-white text-xs sm:text-sm font-bold rounded-2xl shadow-md shadow-emerald-600/30 transition-all cursor-pointer flex items-center justify-center gap-2 shrink-0"
                        >
                            <span>Cari Dokumen</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>

                        @if($query !== '')
                            <a 
                                href="{{ route('kepsek.pencarian-kmp') }}" 
                                class="p-3.5 bg-white/10 hover:bg-white/20 text-white rounded-2xl transition-colors"
                                title="Reset Pencarian"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Suggestions & Compare Toggle -->
                <div class="mt-4 flex flex-wrap items-center justify-between gap-3 text-xs">
                    <div class="flex flex-wrap items-center gap-1.5 text-slate-300">
                        <span class="text-slate-400">Kata kunci saran:</span>
                        @foreach(['Dinas Pendidikan', 'UKK', 'Kurikulum', 'Undangan', 'Ijazah'] as $chip)
                            <a 
                                href="{{ route('kepsek.pencarian-kmp', ['q' => $chip, 'modul' => $modul]) }}" 
                                class="px-2.5 py-1 rounded-lg bg-white/10 hover:bg-white/20 text-emerald-200 transition-colors"
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
                                class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-white/20 bg-white/10"
                            >
                            <span class="font-medium text-[11px]">Uji Komparasi KMP vs Brute Force (Skripsi)</span>
                        </label>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($query !== '')

        <!-- Metrics & LPS Details Bar -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs space-y-4">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-sm shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-slate-900 text-sm">Hasil Pencarian Algoritma KMP</h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-100 text-emerald-800">
                                Waktu Eksekusi: {{ $totalTimeMs }} ms
                            </span>
                        </div>
                        <p class="text-xs text-slate-500">
                            Ditemukan <span class="font-bold text-slate-900">{{ $totalMatches }}</span> arsip yang memuat pola kata kunci <span class="font-bold text-emerald-700">"{{ $query }}"</span>.
                        </p>
                    </div>
                </div>

                <!-- LPS Table Preview -->
                @if(!empty($lpsTable))
                    <details class="group text-xs">
                        <summary class="font-semibold text-emerald-700 hover:text-emerald-900 cursor-pointer flex items-center gap-1.5 p-2 rounded-xl hover:bg-emerald-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span>Tabel Pergeseran LPS</span>
                            <span class="transition-transform group-open:rotate-180">&darr;</span>
                        </summary>
                        <div class="mt-2 p-3 bg-slate-50 border border-slate-200 rounded-xl overflow-x-auto">
                            <table class="text-[11px] font-mono border-collapse">
                                <thead>
                                    <tr class="text-slate-400">
                                        <th class="p-1 border border-slate-200 text-left">Indeks</th>
                                        @foreach(mb_str_split($query) as $idx => $char)
                                            <th class="p-1 border border-slate-200 text-center w-7">{{ $idx }}</th>
                                        @endforeach
                                    </tr>
                                    <tr class="text-slate-800">
                                        <th class="p-1 border border-slate-200 text-left">P[i]</th>
                                        @foreach(mb_str_split($query) as $char)
                                            <th class="p-1 border border-slate-200 text-center font-bold bg-emerald-50 text-emerald-900">{{ $char }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="text-slate-900 font-bold">
                                        <td class="p-1 border border-slate-200">LPS[i]</td>
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

            <!-- Scientific Benchmark Card -->
            @if($benchmarkData)
                <div class="p-4 rounded-xl bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-amber-900">
                            Pengujian Benchmark KMP vs Brute Force (Data Analisis Skripsi)
                        </h4>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-200 text-amber-900">
                            {{ $benchmarkData['iterations'] }} Iterasi
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                        <div class="p-3 bg-white rounded-lg border border-amber-200">
                            <span class="text-slate-500 block text-[11px] font-medium">Algoritma KMP</span>
                            <p class="text-lg font-extrabold text-emerald-800 mt-0.5">{{ $benchmarkData['kmp']['avg_time_ms'] }} ms</p>
                            <span class="text-[10px] text-slate-400 font-mono">O(n + m)</span>
                        </div>
                        <div class="p-3 bg-white rounded-lg border border-amber-200">
                            <span class="text-slate-500 block text-[11px] font-medium">Algoritma Brute Force</span>
                            <p class="text-lg font-extrabold text-slate-700 mt-0.5">{{ $benchmarkData['brute_force']['avg_time_ms'] }} ms</p>
                            <span class="text-[10px] text-slate-400 font-mono">O(n × m)</span>
                        </div>
                        <div class="p-3 bg-white rounded-lg border border-amber-200 flex flex-col justify-center">
                            <span class="text-slate-500 block text-[11px] font-medium">Peningkatan Efisiensi:</span>
                            <p class="text-lg font-extrabold text-emerald-700 mt-0.5">
                                {{ $benchmarkData['speedup_percentage'] >= 0 ? '+' : '' }}{{ $benchmarkData['speedup_percentage'] }}%
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filter Tabs -->
            <div class="flex items-center gap-1 border-t border-slate-100 pt-3 overflow-x-auto text-xs font-semibold">
                <a 
                    href="{{ route('kepsek.pencarian-kmp', ['q' => $query, 'modul' => 'semua', 'compare' => $runCompare ? 1 : 0]) }}" 
                    class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $modul === 'semua' ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Semua Arsip ({{ $totalMatches }})
                </a>
                <a 
                    href="{{ route('kepsek.pencarian-kmp', ['q' => $query, 'modul' => 'surat_masuk', 'compare' => $runCompare ? 1 : 0]) }}" 
                    class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $modul === 'surat_masuk' ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Surat Masuk ({{ count($resultsSuratMasuk) }})
                </a>
                <a 
                    href="{{ route('kepsek.pencarian-kmp', ['q' => $query, 'modul' => 'surat_keluar', 'compare' => $runCompare ? 1 : 0]) }}" 
                    class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $modul === 'surat_keluar' ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Surat Keluar ({{ count($resultsSuratKeluar) }})
                </a>
                <a 
                    href="{{ route('kepsek.pencarian-kmp', ['q' => $query, 'modul' => 'legalisir', 'compare' => $runCompare ? 1 : 0]) }}" 
                    class="px-3.5 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $modul === 'legalisir' ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Legalisir Dokumen ({{ count($resultsLegalisir) }})
                </a>
            </div>
        </div>

        <!-- Search Results List -->
        <div class="space-y-4">

            <!-- Surat Masuk -->
            @if(in_array($modul, ['semua', 'surat_masuk']) && count($resultsSuratMasuk) > 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="p-4 bg-sky-50/50 border-b border-slate-200/80 flex items-center justify-between">
                        <span class="font-bold text-xs uppercase tracking-wider text-slate-800">
                            Arsip Surat Masuk ({{ count($resultsSuratMasuk) }})
                        </span>
                        <span class="text-xs text-slate-500">Pencocokan KMP</span>
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
                                    </div>
                                    <div class="text-slate-600">
                                        <span class="text-slate-400">Pengirim:</span>
                                        <span class="font-bold text-slate-800">{!! $kmpService->highlightMatches($item->pengirim, $query) !!}</span>
                                    </div>
                                    <p class="text-slate-800 font-semibold leading-relaxed">
                                        Perihal: {!! $kmpService->highlightMatches($item->perihal, $query) !!}
                                    </p>
                                </div>
                                <div class="shrink-0">
                                    <a 
                                        href="{{ route('kepsek.surat-masuk.show', $item->id) }}" 
                                        class="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold rounded-xl text-xs flex items-center gap-1"
                                    >
                                        <span>Tinjau Surat</span> &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Surat Keluar -->
            @if(in_array($modul, ['semua', 'surat_keluar']) && count($resultsSuratKeluar) > 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="p-4 bg-teal-50/50 border-b border-slate-200/80 flex items-center justify-between">
                        <span class="font-bold text-xs uppercase tracking-wider text-slate-800">
                            Arsip Surat Keluar ({{ count($resultsSuratKeluar) }})
                        </span>
                        <span class="text-xs text-slate-500">Pencocokan KMP</span>
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
                                    </div>
                                    <div class="text-slate-600">
                                        <span class="text-slate-400">Tujuan:</span>
                                        <span class="font-bold text-slate-800">{!! $kmpService->highlightMatches($item->tujuan, $query) !!}</span>
                                    </div>
                                    <p class="text-slate-800 font-semibold leading-relaxed">
                                        Perihal: {!! $kmpService->highlightMatches($item->perihal, $query) !!}
                                    </p>
                                </div>
                                <div class="shrink-0">
                                    <a 
                                        href="{{ route('kepsek.surat-keluar.show', $item->id) }}" 
                                        class="px-3 py-1.5 bg-teal-50 hover:bg-teal-100 text-teal-800 font-semibold rounded-xl text-xs flex items-center gap-1"
                                    >
                                        <span>Tinjau Surat</span> &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Legalisir -->
            @if(in_array($modul, ['semua', 'legalisir']) && count($resultsLegalisir) > 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                    <div class="p-4 bg-purple-50/50 border-b border-slate-200/80 flex items-center justify-between">
                        <span class="font-bold text-xs uppercase tracking-wider text-slate-800">
                            Permohonan Legalisir Dokumen ({{ count($resultsLegalisir) }})
                        </span>
                        <span class="text-xs text-slate-500">Pencocokan KMP</span>
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
                                    </div>
                                    <div class="text-slate-600">
                                        <span class="text-slate-400">Pemohon:</span>
                                        <span class="font-bold text-slate-800">{!! $kmpService->highlightMatches($item->nama_pemohon, $query) !!}</span>
                                        <span class="text-slate-400 mx-1">•</span>
                                        <span class="font-mono text-slate-600">NISN: {!! $kmpService->highlightMatches($item->nisn, $query) !!}</span>
                                    </div>
                                    <p class="text-slate-800 font-semibold leading-relaxed">
                                        Keperluan: {!! $kmpService->highlightMatches($item->keperluan, $query) !!}
                                    </p>
                                </div>
                                <div class="shrink-0">
                                    <a 
                                        href="{{ route('kepsek.legalisir.show', $item->id) }}" 
                                        class="px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-800 font-semibold rounded-xl text-xs flex items-center gap-1"
                                    >
                                        <span>Tinjau Legalisir</span> &rarr;
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
                    <h3 class="font-bold text-base text-slate-800">Tidak Ada Dokumen yang Cocok</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                        Pola pencarian <span class="font-bold text-slate-800">"{{ $query }}"</span> tidak ditemukan dalam basis data arsip.
                    </p>
                </div>
            @endif

        </div>

    @else
        <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center text-xs text-slate-500 space-y-2">
            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <h3 class="font-bold text-sm text-slate-800">Pencarian Cepat Kearsipan Pimpinan</h3>
            <p class="max-w-md mx-auto leading-relaxed">
                Ketikkan kata kunci pada kotak pencarian di atas untuk menelusuri nomor surat, instansi dinas pengirim, perihal agenda, atau data pemohon alumni secara akurat.
            </p>
        </div>
    @endif

</div>
@endsection
