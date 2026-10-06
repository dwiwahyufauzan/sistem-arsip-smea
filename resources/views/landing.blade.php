<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portal arsip surat dinas dan layanan legalisir ijazah online resmi SMKN 1 Subang (SMEA). Ajukan, pantau status real-time, dan ambil berkas tanpa antre.">
    <meta name="author" content="SMK Negeri 1 Subang">
    <title>Sistem Informasi Arsip & Layanan Legalisir Dokumen | SMKN 1 Subang</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-smk.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto !important; }
            * { animation: none !important; transition: none !important; }
        }
        section[id] { scroll-margin-top: 5.5rem; }
        details > summary { list-style: none; }
        details > summary::-webkit-details-marker { display: none; }
        details[open] .faq-icon { transform: rotate(180deg); }

        @keyframes shakeInput {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
        .input-shake {
            animation: shakeInput 0.45s ease-in-out;
        }

        @keyframes pulseGlow {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 0.9; transform: scale(1.05); }
        }
        .animate-pulse-glow {
            animation: pulseGlow 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen selection:bg-teal-600 selection:text-white font-sans">

@php
    $steps = ['menunggu_verifikasi', 'diverifikasi', 'menunggu_approval_kepsek', 'disetujui_kepsek', 'sedang_diproses', 'siap_diambil', 'selesai'];
    $stepIndex = isset($pengajuan) && $pengajuan ? array_search($pengajuan->status, $steps) : false;
    $progress = $stepIndex === false ? 0 : round((($stepIndex + 1) / count($steps)) * 100);

    // Timeline human steps definition for visual stepper
    $flowStages = [
        ['key' => 'menunggu_verifikasi', 'label' => 'Diajukan', 'desc' => 'Berkas Masuk'],
        ['key' => 'diverifikasi', 'label' => 'Verifikasi TU', 'desc' => 'Pemeriksaan Buku Induk'],
        ['key' => 'disetujui_kepsek', 'label' => 'Persetujuan Kepsek', 'desc' => 'Tanda Tangan Elektronik'],
        ['key' => 'sedang_diproses', 'label' => 'Diproses Staf', 'desc' => 'Pencetakan & Cap'],
        ['key' => 'siap_diambil', 'label' => 'Siap Diambil', 'desc' => 'Loket TU SMKN 1'],
        ['key' => 'selesai', 'label' => 'Selesai', 'desc' => 'Dokumen Diterima'],
    ];

    $stageIndexMap = [
        'menunggu_verifikasi' => 0,
        'diverifikasi' => 1,
        'menunggu_approval_kepsek' => 1,
        'disetujui_kepsek' => 2,
        'sedang_diproses' => 3,
        'siap_diambil' => 4,
        'selesai' => 5,
        'ditolak' => -1,
    ];

    $currentStageActive = isset($pengajuan) && $pengajuan ? ($stageIndexMap[$pengajuan->status] ?? 0) : 0;
@endphp

    <a href="#konten" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[100] focus:px-4 focus:py-2 focus:bg-white focus:text-blue-950 focus:rounded-lg focus:shadow-xl focus:ring-2 focus:ring-teal-500">Lewati ke konten utama</a>

    <!-- Top Bar Kedinasan -->
    <div class="bg-slate-950 text-slate-300 text-xs border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-2.5 text-center sm:text-left flex-wrap justify-center">
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-teal-500/20 text-teal-300 ring-1 ring-teal-400/40">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-ping"></span>
                    Portal Kedinasan Resmi
                </span>
                <span class="text-slate-400 text-[11px] sm:text-xs">Pemerintah Provinsi Jawa Barat · Dinas Pendidikan Cabang Wilayah IV</span>
            </div>
            <div class="hidden md:flex items-center gap-6 text-slate-400 text-xs">
                <span class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-teal-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg>
                    Senin–Jumat, 07.30–15.30 WIB
                </span>
                <a href="tel:+62260411410" class="flex items-center gap-1.5 hover:text-teal-300 transition-colors">
                    <svg class="w-3.5 h-3.5 text-teal-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.3a1 1 0 01.9.7l1.5 4.5a1 1 0 01-.5 1.2l-2.3 1.1a11 11 0 005.5 5.5l1.1-2.3a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.7.9V19a2 2 0 01-2 2h-1C9.7 21 3 14.3 3 6V5z"/></svg>
                    (0260) 411410
                </a>
            </div>
        </div>
    </div>

    <!-- Header & Navigasi -->
    <header id="header" class="sticky top-0 z-50 bg-white/85 backdrop-blur-xl border-b border-slate-200/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Brand / Logo -->
                <a href="{{ route('landing') }}" class="flex items-center gap-3.5 group focus-visible:outline-2 focus-visible:outline-teal-600 rounded-xl" aria-label="Beranda SMEA ARCHIVE SMKN 1 Subang">
                    <div class="relative">
                        <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-9 h-11 sm:w-11 sm:h-13 object-contain shrink-0 group-hover:scale-105 transition-transform duration-300 filter drop-shadow-sm">
                    </div>
                    <div class="leading-tight">
                        <div class="flex items-center gap-2">
                            <span class="font-heading font-extrabold text-lg sm:text-xl text-blue-950 tracking-tight">SMEA ARCHIVE</span>
                            <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-md bg-blue-100 text-blue-900 border border-blue-200">PK</span>
                        </div>
                        <p class="text-[11px] sm:text-xs font-semibold text-slate-600">SMK Negeri 1 Subang</p>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden lg:flex items-center gap-0.5 text-xs font-semibold text-slate-600" aria-label="Navigasi utama">
                    <a href="#beranda" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Beranda</a>
                    <a href="#lacak" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500 animate-pulse"></span>
                        Lacak Legalisir
                    </a>
                    <a href="#alur" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Alur Pelayanan</a>
                    <a href="#tentang" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Modul Sistem</a>
                    <a href="#faq" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Tanya Jawab</a>
                    <a href="#kontak" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Kontak TU</a>
                </nav>

                <!-- Action CTA -->
                <div class="flex items-center gap-2 sm:gap-2.5">
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold text-white bg-blue-900 rounded-xl hover:bg-blue-800 shadow-md shadow-blue-900/20 transition-all hover:-translate-y-0.5">
                                <span class="hidden sm:inline">Dashboard Admin TU</span>
                                <span class="sm:hidden">Dashboard</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @elseif(Auth::user()->isKepalaSekolah())
                            <a href="{{ route('kepsek.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold text-white bg-emerald-800 rounded-xl hover:bg-emerald-700 shadow-md shadow-emerald-800/20 transition-all hover:-translate-y-0.5">
                                <span class="hidden sm:inline">Portal Kepala Sekolah</span>
                                <span class="sm:hidden">Portal</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @else
                            <a href="{{ route('pemohon.dashboard') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-bold text-white bg-teal-700 rounded-xl hover:bg-teal-600 shadow-md shadow-teal-700/20 transition-all hover:-translate-y-0.5">
                                <span class="hidden sm:inline">Dashboard Pemohon</span>
                                <span class="sm:hidden">Dashboard</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex px-3 py-1.5 text-xs font-bold text-slate-700 hover:text-blue-950 transition-colors">
                            Masuk Portal
                        </a>
                        <a href="{{ route('legalisir.create') }}" class="inline-flex items-center gap-1.5 px-3.5 sm:px-4 py-2 text-xs font-bold text-white bg-gradient-to-r from-blue-900 to-indigo-900 rounded-xl hover:from-blue-800 hover:to-indigo-800 shadow-md shadow-blue-950/20 transition-all hover:-translate-y-0.5 hover:shadow-lg">
                            <span>Ajukan Legalisir</span>
                            <svg class="w-3.5 h-3.5 hidden sm:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button id="menu-btn" type="button" class="lg:hidden inline-flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-100 transition-colors" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="mobile-menu">
                        <svg id="icon-open" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                        <svg id="icon-close" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white/95 backdrop-blur-lg">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 grid gap-1 text-xs font-semibold text-slate-600" aria-label="Navigasi seluler">
                <a href="#beranda" class="px-3 py-2 rounded-lg hover:bg-slate-100">Beranda</a>
                <a href="#lacak" class="px-3 py-2 rounded-lg hover:bg-teal-50 text-teal-800 flex items-center justify-between">
                    <span>Lacak Legalisir</span>
                    <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                </a>
                <a href="#alur" class="px-3 py-2 rounded-lg hover:bg-slate-100">Alur Pelayanan</a>
                <a href="#tentang" class="px-3 py-2 rounded-lg hover:bg-slate-100">Modul Sistem</a>
                <a href="#faq" class="px-3 py-2 rounded-lg hover:bg-slate-100">Tanya Jawab</a>
                <a href="#kontak" class="px-3 py-2 rounded-lg hover:bg-slate-100">Kontak TU</a>
                @guest
                    <div class="pt-2 mt-1.5 border-t border-slate-100 grid grid-cols-2 gap-2">
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg border border-slate-200 text-center font-bold text-slate-800 hover:bg-slate-50 text-xs">Masuk</a>
                        <a href="{{ route('legalisir.create') }}" class="px-3 py-2 rounded-lg bg-blue-900 text-white text-center font-bold hover:bg-blue-800 text-xs">Ajukan Online</a>
                    </div>
                @endguest
            </nav>
        </div>
    </header>

    <main id="konten" class="flex-grow">

        <!-- =========================================================================
             HERO SECTION & LIVE TRACKING
             ========================================================================= -->
        <section id="beranda" class="relative overflow-hidden bg-gradient-to-b from-slate-950 via-[#0B1528] to-[#0A192F] text-white">
            <!-- Decorative Background Grid & Glows -->
            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:28px_28px]"></div>
            <div class="absolute -top-40 -right-32 w-[32rem] h-[32rem] bg-teal-500/20 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>
            <div class="absolute top-1/2 -left-36 w-[30rem] h-[30rem] bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 right-1/4 w-[24rem] h-[24rem] bg-indigo-500/15 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-24 sm:pt-16 lg:pt-20 lg:pb-32">
                <div class="grid lg:grid-cols-12 gap-10 lg:gap-12 items-start">

                    <!-- Kolom Teks Hero (Kiri) -->
                    <div class="lg:col-span-6 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md ring-1 ring-white/15 text-teal-300 text-xs font-semibold mb-6 shadow-inner">
                            <span class="relative flex w-2 h-2">
                                <span class="absolute inline-flex w-full h-full rounded-full bg-teal-400 opacity-75 animate-ping"></span>
                                <span class="relative inline-flex w-2 h-2 rounded-full bg-teal-400"></span>
                            </span>
                            <span>Portal Kearsipan & Legalisir Digital SMEA</span>
                        </div>

                        <h1 class="font-heading font-extrabold text-3xl sm:text-5xl xl:text-6xl tracking-tight leading-[1.12] mb-6 text-balance">
                            Legalisir ijazah dari rumah, <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-300 via-emerald-300 to-cyan-200">tanpa antre</span> di sekolah
                        </h1>

                        <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-xl mx-auto lg:mx-0 mb-8 font-normal">
                            Ajukan legalisir mandiri secara online, pantau status verifikasi secara real-time, dan ambil berkas saat sudah berstempel basah. Didukung pengelolaan arsip surat dinas SMKN 1 Subang berkecepatan tinggi dengan algoritma Knuth-Morris-Pratt (KMP).
                        </p>

                        <!-- CTA Hero Buttons -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center lg:justify-start gap-3.5 mb-10">
                            <a href="{{ route('legalisir.create') }}" class="group inline-flex items-center justify-center gap-2.5 px-6 py-3.5 text-sm font-bold text-slate-950 bg-gradient-to-r from-teal-400 to-emerald-400 hover:from-teal-300 hover:to-emerald-300 rounded-xl shadow-lg shadow-teal-500/25 transition-all duration-200 hover:-translate-y-0.5">
                                <svg class="w-5 h-5 text-slate-950 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                <span>Ajukan legalisir sekarang</span>
                            </a>
                            <a href="#alur" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-semibold text-white bg-white/10 hover:bg-white/20 ring-1 ring-white/20 rounded-xl backdrop-blur-md transition-all duration-200">
                                <span>Lihat alur pelayanan</span>
                                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </a>
                        </div>

                        <!-- Feature Badges -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 max-w-xl mx-auto lg:mx-0 text-left pt-2 border-t border-slate-800/80">
                            <div class="flex items-center gap-2.5 text-xs text-slate-300">
                                <div class="w-7 h-7 rounded-lg bg-teal-500/15 text-teal-400 flex items-center justify-center shrink-0 ring-1 ring-teal-500/30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <span class="font-medium">Pengajuan tanpa perlu login</span>
                            </div>
                            <div class="flex items-center gap-2.5 text-xs text-slate-300">
                                <div class="w-7 h-7 rounded-lg bg-teal-500/15 text-teal-400 flex items-center justify-center shrink-0 ring-1 ring-teal-500/30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <span class="font-medium">Status terpantau real-time</span>
                            </div>
                            <div class="flex items-center gap-2.5 text-xs text-slate-300">
                                <div class="w-7 h-7 rounded-lg bg-teal-500/15 text-teal-400 flex items-center justify-center shrink-0 ring-1 ring-teal-500/30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.6-4A12 12 0 0112 2.9 12 12 0 013.4 6 12 12 0 003 9c0 5.6 3.8 10.3 9 11.6 5.2-1.3 9-6 9-11.6 0-1-.1-2-.4-3z"/></svg>
                                </div>
                                <span class="font-medium">QR verifikasi keaslian dinas</span>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Widget Lacak Status (Kanan) -->
                    <div id="lacak" class="lg:col-span-6 w-full max-w-xl mx-auto lg:max-w-none">
                        <div class="relative bg-white/95 backdrop-blur-xl p-5 sm:p-7 rounded-3xl shadow-2xl shadow-slate-950/50 ring-1 ring-white/30 text-slate-800 transition-all duration-300">
                            
                            <!-- Header Form Lacak -->
                            <div class="flex items-start gap-3.5 mb-5">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-teal-500/25">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.6a1 1 0 01.7.3l5.4 5.4a1 1 0 01.3.7V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex items-center justify-between">
                                        <h2 class="font-heading font-extrabold text-xl text-slate-900 leading-snug">Lacak status permohonan</h2>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-100 text-teal-800">
                                            Live Tracker
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">
                                        Masukkan nomor resi (contoh <button type="button" onclick="fillExampleResi('LEG-202609-0001')" class="font-mono font-semibold text-teal-700 hover:text-teal-900 underline decoration-teal-400 decoration-dotted cursor-pointer">LEG-202609-0001</button>) atau 10 digit NISN Anda.
                                    </p>
                                </div>
                            </div>

                            <!-- Form Input Lacak -->
                            <form id="tracking-form" action="{{ route('landing') }}#lacak" method="GET" class="flex flex-col sm:flex-row gap-2.5">
                                <label for="nomor_pengajuan" class="sr-only">Nomor resi atau NISN</label>
                                <div class="relative flex-grow">
                                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    <input id="nomor_pengajuan" type="text" name="nomor_pengajuan" value="{{ $query ?? '' }}" placeholder="Ketik nomor resi atau NISN..." autocomplete="off"
                                        class="w-full pl-10 pr-9 py-3 text-sm rounded-xl border border-slate-300 bg-white text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent uppercase placeholder:normal-case font-mono transition-all">
                                    @if(!empty($query))
                                        <button type="button" onclick="clearTrackingInput()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-0.5 rounded-md" title="Hapus ketikan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    @endif
                                </div>
                                <button type="submit" id="btn-submit-track" class="inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-bold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-md shadow-blue-900/20 transition-all shrink-0 cursor-pointer hover:shadow-lg focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-900 active:scale-98">
                                    <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35"/></svg>
                                    <span>Cek status</span>
                                </button>
                            </form>

                            <!-- =============================================================
                                 HASIL PELACAKAN DITEMUKAN / TIDAK DITEMUKAN
                                 ============================================================= -->
                            @if($searchPerformed)
                                <div class="mt-6 pt-6 border-t border-slate-200/90 transition-all">
                                    @if($pengajuan)
                                        @php
                                            $statusConfig = match($pengajuan->status) {
                                                'menunggu_verifikasi' => [
                                                    'badge' => 'bg-amber-100 text-amber-900 border-amber-300',
                                                    'dot' => 'bg-amber-500',
                                                    'hero_bg' => 'from-amber-500/10 via-amber-50/50 to-white',
                                                    'desc' => 'Menunggu staf Tata Usaha memvalidasi berkas dengan buku induk.',
                                                ],
                                                'diverifikasi' => [
                                                    'badge' => 'bg-sky-100 text-sky-900 border-sky-300',
                                                    'dot' => 'bg-sky-500',
                                                    'hero_bg' => 'from-sky-500/10 via-sky-50/50 to-white',
                                                    'desc' => 'Berkas valid dan siap diteruskan untuk persetujuan pimpinan.',
                                                ],
                                                'menunggu_approval_kepsek' => [
                                                    'badge' => 'bg-indigo-100 text-indigo-900 border-indigo-300',
                                                    'dot' => 'bg-indigo-500',
                                                    'hero_bg' => 'from-indigo-500/10 via-indigo-50/50 to-white',
                                                    'desc' => 'Menunggu verifikasi dan tanda tangan Kepala Sekolah.',
                                                ],
                                                'disetujui_kepsek' => [
                                                    'badge' => 'bg-blue-100 text-blue-900 border-blue-300',
                                                    'dot' => 'bg-blue-600',
                                                    'hero_bg' => 'from-blue-500/10 via-blue-50/50 to-white',
                                                    'desc' => 'Telah disetujui Kepala Sekolah untuk dicetak dan distempel.',
                                                ],
                                                'sedang_diproses' => [
                                                    'badge' => 'bg-purple-100 text-purple-900 border-purple-300',
                                                    'dot' => 'bg-purple-600',
                                                    'hero_bg' => 'from-purple-500/10 via-purple-50/50 to-white',
                                                    'desc' => 'Staf Tata Usaha sedang mencetak dan membubuhkan stempel basah.',
                                                ],
                                                'siap_diambil' => [
                                                    'badge' => 'bg-emerald-100 text-emerald-900 border-emerald-300 ring-2 ring-emerald-500/30 animate-pulse',
                                                    'dot' => 'bg-emerald-600',
                                                    'hero_bg' => 'from-emerald-500/15 via-emerald-50/60 to-white',
                                                    'desc' => 'Dokumen sudah berstempel lengkap dan siap diambil di loket TU.',
                                                ],
                                                'selesai' => [
                                                    'badge' => 'bg-slate-100 text-slate-900 border-slate-300',
                                                    'dot' => 'bg-slate-600',
                                                    'hero_bg' => 'from-slate-500/10 via-slate-50/50 to-white',
                                                    'desc' => 'Proses legalisir telah selesai dan dokumen telah diserahkan.',
                                                ],
                                                'ditolak' => [
                                                    'badge' => 'bg-rose-100 text-rose-900 border-rose-300',
                                                    'dot' => 'bg-rose-600',
                                                    'hero_bg' => 'from-rose-500/15 via-rose-50/50 to-white',
                                                    'desc' => 'Permohonan ditolak oleh petugas. Periksa catatan alasan penolakan.',
                                                ],
                                                default => [
                                                    'badge' => 'bg-slate-100 text-slate-800 border-slate-300',
                                                    'dot' => 'bg-slate-500',
                                                    'hero_bg' => 'from-slate-100 to-white',
                                                    'desc' => 'Status berkas sedang diperbarui.',
                                                ],
                                            };
                                        @endphp

                                        <!-- KARTU HASIL PELACAKAN MODERN -->
                                        <div class="rounded-2xl border border-slate-200/90 bg-gradient-to-b {{ $statusConfig['hero_bg'] }} p-4 sm:p-5 shadow-sm space-y-4">
                                            
                                            <!-- Top Status & Monospace Resi -->
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3.5 border-b border-slate-200/80">
                                                <div class="min-w-0">
                                                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-0.5">Nomor Tanda Terima Resi</span>
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <h3 id="display-resi" class="font-mono text-base sm:text-xl font-extrabold text-blue-950 tracking-tight select-all">{{ $pengajuan->nomor_pengajuan }}</h3>
                                                        <button type="button" onclick="copyResiCode('{{ $pengajuan->nomor_pengajuan }}')" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-lg bg-white border border-slate-200 hover:border-teal-500 text-slate-700 hover:text-teal-700 shadow-xs transition-all active:scale-95" title="Salin nomor resi ke papan klip">
                                                            <svg id="copy-icon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                            <span id="copy-text">Salin</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="shrink-0">
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold border {{ $statusConfig['badge'] }} shadow-xs">
                                                        <span class="w-2 h-2 rounded-full {{ $statusConfig['dot'] }}"></span>
                                                        {{ $pengajuan->status_label }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Visual Stepper Tracker -->
                                            @if($pengajuan->status !== 'ditolak')
                                                <div class="pt-1">
                                                    <div class="flex items-center justify-between text-xs mb-2">
                                                        <span class="font-bold text-slate-700">Tahapan Proses Dokumen</span>
                                                        <span class="font-extrabold font-mono text-blue-900 bg-blue-100/80 px-2 py-0.5 rounded-md">{{ $progress }}% Selesai</span>
                                                    </div>
                                                    
                                                    <!-- Progress Bar Garis -->
                                                    <div class="h-2 w-full rounded-full bg-slate-200/90 overflow-hidden mb-3">
                                                        <div class="h-full rounded-full bg-gradient-to-r from-blue-700 via-teal-600 to-emerald-500 transition-all duration-500" style="width: {{ $progress }}%"></div>
                                                    </div>

                                                    <!-- 6 Micro Stepper Nodes -->
                                                    <div class="grid grid-cols-6 gap-1 text-center">
                                                        @foreach($flowStages as $idx => $stage)
                                                            @php
                                                                $isDone = $idx < $currentStageActive;
                                                                $isCurrent = $idx === $currentStageActive;
                                                            @endphp
                                                            <div class="flex flex-col items-center">
                                                                <div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold mb-1 transition-all {{ $isDone ? 'bg-teal-600 text-white' : ($isCurrent ? 'bg-blue-900 text-white ring-4 ring-blue-200 ring-offset-1 animate-pulse' : 'bg-slate-200 text-slate-500') }}">
                                                                    @if($isDone)
                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                                    @else
                                                                        {{ $idx + 1 }}
                                                                    @endif
                                                                </div>
                                                                <span class="text-[9px] sm:text-[10px] font-semibold leading-tight {{ $isCurrent ? 'text-blue-950 font-bold' : ($isDone ? 'text-slate-700' : 'text-slate-400') }} hidden sm:block">
                                                                    {{ $stage['label'] }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Data Spesifikasi Pemohon & Berkas (Bento Grid) -->
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs pt-1">
                                                <div class="p-3 rounded-xl bg-white/80 border border-slate-200/70 shadow-2xs">
                                                    <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider block">Nama Pemohon</span>
                                                    <div class="font-bold text-slate-900 text-sm mt-0.5">{{ $pengajuan->nama_pemohon }}</div>
                                                    <span class="text-[11px] text-teal-700 font-medium">Alumni Terdaftar</span>
                                                </div>
                                                <div class="p-3 rounded-xl bg-white/80 border border-slate-200/70 shadow-2xs">
                                                    <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider block">NISN / Tahun Kelulusan</span>
                                                    <div class="font-bold font-mono text-slate-900 text-sm mt-0.5">{{ $pengajuan->nisn }}</div>
                                                    <span class="text-[11px] text-slate-600 font-medium">Lulusan Tahun {{ $pengajuan->tahun_lulus }}</span>
                                                </div>
                                                <div class="p-3 rounded-xl bg-white/80 border border-slate-200/70 shadow-2xs">
                                                    <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider block">Jenis Dokumen</span>
                                                    <div class="font-bold text-slate-900 mt-0.5">{{ $pengajuan->jenis_dokumen_label }}</div>
                                                    <span class="text-[11px] text-blue-800 font-semibold">{{ $pengajuan->jumlah_lembar }} Lembar Berkas</span>
                                                </div>
                                                <div class="p-3 rounded-xl bg-white/80 border border-slate-200/70 shadow-2xs">
                                                    <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider block">Waktu Pengajuan</span>
                                                    <div class="font-bold text-slate-900 mt-0.5">{{ $pengajuan->created_at->format('d M Y') }}</div>
                                                    <span class="text-[11px] text-slate-500 font-mono">{{ $pengajuan->created_at->format('H:i') }} WIB</span>
                                                </div>
                                            </div>

                                            <!-- Keperluan Dokumen -->
                                            @if($pengajuan->keperluan)
                                                <div class="p-3 rounded-xl bg-white/80 border border-slate-200/70 text-xs">
                                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Keperluan Dokumen</span>
                                                    <p class="text-slate-700 mt-0.5 leading-relaxed">{{ $pengajuan->keperluan }}</p>
                                                </div>
                                            @endif

                                            <!-- Alert Box Jika Siap Diambil -->
                                            @if($pengajuan->status === 'siap_diambil')
                                                <div class="p-4 rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 border-2 border-emerald-400 text-xs text-emerald-950 shadow-sm animate-pulse-glow">
                                                    <div class="flex items-start gap-3">
                                                        <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                        </div>
                                                        <div class="flex-grow">
                                                            <strong class="font-extrabold text-sm text-emerald-950 block">Dokumen sudah siap diambil di Loket TU!</strong>
                                                            <p class="mt-1 text-emerald-900 leading-relaxed">
                                                                Silakan datang ke <strong>Ruang Tata Usaha SMKN 1 Subang (Gedung Administrasi)</strong> pada hari kerja (Senin–Jumat, 07.30–15.30 WIB).
                                                            </p>
                                                            <div class="mt-2.5 flex items-center gap-2 flex-wrap text-[11px] font-semibold text-emerald-800 bg-white/80 px-2.5 py-1.5 rounded-lg border border-emerald-200">
                                                                <span>Syarat pengambilan:</span>
                                                                <span class="px-1.5 py-0.5 bg-emerald-100 rounded">Tunjukkan Resi {{ $pengajuan->nomor_pengajuan }}</span>
                                                                <span class="px-1.5 py-0.5 bg-emerald-100 rounded">Bawa Dokumen Asli / Tanda Pengenal</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Catatan Petugas TU jika ada -->
                                            @if($pengajuan->catatan_petugas)
                                                <div class="p-3 bg-white rounded-xl border border-blue-200/90 text-xs shadow-2xs">
                                                    <div class="flex items-center gap-1.5 text-blue-900 font-bold mb-1">
                                                        <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                        <span>Catatan Petugas Tata Usaha</span>
                                                    </div>
                                                    <p class="text-slate-700 leading-relaxed">{{ $pengajuan->catatan_petugas }}</p>
                                                </div>
                                            @endif

                                            <!-- Catatan Kepala Sekolah jika ada -->
                                            @if($pengajuan->catatan_kepsek)
                                                <div class="p-3 bg-emerald-50/70 rounded-xl border border-emerald-200 text-xs shadow-2xs">
                                                    <div class="flex items-center gap-1.5 text-emerald-950 font-bold mb-1">
                                                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.6-4A12 12 0 0112 2.9 12 12 0 013.4 6 12 12 0 003 9c0 5.6 3.8 10.3 9 11.6 5.2-1.3 9-6 9-11.6 0-1-.1-2-.4-3z"/></svg>
                                                        <span>Catatan Pengesahan Kepala Sekolah</span>
                                                    </div>
                                                    <p class="text-emerald-900 leading-relaxed">{{ $pengajuan->catatan_kepsek }}</p>
                                                </div>
                                            @endif

                                            <!-- Quick Action Links -->
                                            <div class="pt-2 flex flex-wrap items-center gap-2">
                                                <a href="{{ route('legalisir.tanda-terima', $pengajuan->nomor_pengajuan) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-white bg-blue-900 hover:bg-blue-800 shadow-sm transition-all">
                                                    <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                                    <span>Cetak Bukti Resi</span>
                                                </a>
                                                <a href="{{ route('verifikasi.legalisir', $pengajuan->nomor_pengajuan) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-all">
                                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                                    <span>Cek QR Publik</span>
                                                </a>
                                                <a href="https://wa.me/6285712345678?text=Halo%20Staf%20Tata%20Usaha%20SMKN%201%20Subang,%20saya%20ingin%20menanyakan%20status%20legalisir%20nomor%20resi%20{{ $pengajuan->nomor_pengajuan }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-emerald-800 bg-emerald-100/80 hover:bg-emerald-200/80 transition-all">
                                                    <svg class="w-4 h-4 text-emerald-700" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2z"/></svg>
                                                    <span>Tanya Loket TU</span>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- RIWAYAT PELACAKAN BERKAS (TIMELINE) -->
                                        <div class="mt-5">
                                            <div class="flex items-center justify-between mb-3">
                                                <h4 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                                                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg>
                                                    Riwayat pelacakan berkas
                                                </h4>
                                                <span class="text-[11px] font-semibold text-slate-500">{{ $pengajuan->riwayat->count() }} Aktivitas</span>
                                            </div>

                                            <div class="relative pl-6 space-y-3.5 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                                                @forelse($pengajuan->riwayat as $history)
                                                    <div class="relative group">
                                                        <span class="absolute -left-6 top-1 w-4 h-4 rounded-full bg-teal-500 ring-4 ring-white border-2 border-teal-600 group-hover:scale-125 transition-transform"></span>
                                                        <div class="p-2.5 rounded-xl bg-slate-50 hover:bg-slate-100/80 border border-slate-200/80 text-xs transition-colors">
                                                            <div class="flex flex-wrap items-center justify-between gap-1">
                                                                <strong class="font-bold text-slate-900 capitalize">{{ str_replace('_', ' ', $history->status_baru) }}</strong>
                                                                <span class="text-[11px] font-mono text-slate-500">{{ $history->created_at->format('d M Y, H:i') }} WIB</span>
                                                            </div>
                                                            <p class="text-slate-600 mt-1 leading-relaxed">{{ $history->catatan ?? 'Perubahan status tercatat oleh sistem administrasi kearsipan.' }}</p>
                                                            @if($history->user)
                                                                <span class="inline-block mt-1 text-[10px] text-slate-400">Oleh: {{ $history->user->name }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="relative">
                                                        <span class="absolute -left-6 top-1 w-4 h-4 rounded-full bg-blue-600 ring-4 ring-white"></span>
                                                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                                            <strong class="font-bold text-slate-900">Permohonan terdaftar di sistem</strong>
                                                            <p class="text-slate-500 mt-0.5">Berkas masuk ke antrean verifikasi staf Tata Usaha SMKN 1 Subang.</p>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>

                                    @else
                                        <!-- KARTU DATA TIDAK DITEMUKAN -->
                                        <div class="p-5 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 text-amber-950 text-xs shadow-xs" role="alert">
                                            <div class="flex items-start gap-3.5">
                                                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-sm shadow-amber-500/30">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.9 4h13.8c1.5 0 2.5-1.7 1.7-3L13.7 4c-.8-1.3-2.7-1.3-3.5 0L3.3 16c-.8 1.3.2 3 1.7 3z"/></svg>
                                                </div>
                                                <div class="flex-grow">
                                                    <h4 class="font-extrabold text-sm text-amber-950">Data permohonan tidak ditemukan</h4>
                                                    <p class="mt-1.5 text-amber-900 leading-relaxed">
                                                        Nomor resi atau NISN <span class="font-mono font-bold bg-amber-100/90 px-1.5 py-0.5 rounded text-amber-950">"{{ $query }}"</span> belum terdaftar di basis data sistem kearsipan kami.
                                                    </p>
                                                    <div class="mt-3 p-3 rounded-xl bg-white/80 border border-amber-200/80 text-[11px] space-y-1 text-slate-700">
                                                        <div class="font-bold text-slate-900 mb-1">Tips pencarian:</div>
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                            Pastikan format nomor resi diawali dengan <strong class="font-mono">LEG-YYYYMM-XXXX</strong> (contoh: <strong class="font-mono">LEG-202609-0001</strong>).
                                                        </div>
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                            Atau gunakan 10 digit Nomor Induk Siswa Nasional (NISN) Anda.
                                                        </div>
                                                        <div class="flex items-center gap-1.5">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                            Belum pernah mengajukan? Anda dapat mengajukan secara langsung tanpa antre.
                                                        </div>
                                                    </div>
                                                    <div class="mt-3.5 flex items-center gap-2 flex-wrap">
                                                        <a href="{{ route('legalisir.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-800 text-white font-bold text-xs hover:bg-amber-900 transition-colors">
                                                            <span>Ajukan legalisir baru</span>
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                                        </a>
                                                        <button type="button" onclick="fillExampleResi('LEG-202609-0001')" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white border border-amber-300 text-amber-900 font-semibold text-xs hover:bg-amber-50 transition-colors">
                                                            <span>Coba sampel resi</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- =========================================================================
             SECTION STATISTIK & METRIK SISTEM
             ========================================================================= -->
        <section class="relative -mt-12 z-20" aria-label="Statistik sistem kearsipan">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 lg:grid-cols-4 bg-white/95 backdrop-blur-md rounded-3xl shadow-xl shadow-slate-900/10 border border-slate-200/90 divide-slate-200 divide-y lg:divide-y-0 lg:divide-x [&>div:nth-child(odd)]:border-r [&>div:nth-child(odd)]:border-slate-200 lg:[&>div:nth-child(odd)]:border-r-0 overflow-hidden">
                    
                    <div class="p-5 sm:p-7 text-center group hover:bg-slate-50/80 transition-colors">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.6a1 1 0 01.7.3l2.4 2.4a1 1 0 00.7.3h3.2a1 1 0 00.7-.3l2.4-2.4a1 1 0 01.7-.3H20"/></svg>
                        </div>
                        <div class="font-heading text-3xl sm:text-4xl font-extrabold text-blue-950 tabular-nums">{{ $stats['total_surat_masuk'] }}</div>
                        <div class="text-xs sm:text-sm font-semibold text-slate-600 mt-1">Surat masuk terarsip</div>
                    </div>

                    <div class="p-5 sm:p-7 text-center group hover:bg-slate-50/80 transition-colors">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-indigo-100 text-indigo-900 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </div>
                        <div class="font-heading text-3xl sm:text-4xl font-extrabold text-blue-950 tabular-nums">{{ $stats['total_surat_keluar'] }}</div>
                        <div class="text-xs sm:text-sm font-semibold text-slate-600 mt-1">Surat keluar resmi</div>
                    </div>

                    <div class="p-5 sm:p-7 text-center group hover:bg-slate-50/80 transition-colors">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-teal-100 text-teal-900 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        </div>
                        <div class="font-heading text-3xl sm:text-4xl font-extrabold text-teal-700 tabular-nums">{{ $stats['total_kategori'] }}</div>
                        <div class="text-xs sm:text-sm font-semibold text-slate-600 mt-1">Klasifikasi kategori dinas</div>
                    </div>

                    <div class="p-5 sm:p-7 text-center group hover:bg-slate-50/80 transition-colors">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-emerald-100 text-emerald-900 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="font-heading text-3xl sm:text-4xl font-extrabold text-emerald-700 tabular-nums">{{ $stats['total_legalisir'] }}</div>
                        <div class="text-xs sm:text-sm font-semibold text-slate-600 mt-1">Pengajuan legalisir online</div>
                    </div>

                </div>
            </div>
        </section>

        <!-- =========================================================================
             SECTION BENTO GRID MODUL SISTEM
             ========================================================================= -->
        <section id="tentang" class="py-20 sm:py-28 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="max-w-3xl mb-14 sm:mb-16 text-center sm:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-900 text-xs font-bold mb-3">
                        Ekosistem Arsip Modern
                    </div>
                    <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 tracking-tight text-balance">
                        Satu sistem terpadu untuk seluruh urusan Tata Usaha SMEA
                    </h2>
                    <p class="text-slate-600 mt-3.5 leading-relaxed text-base">
                        Surat masuk, disposisi instruksi pimpinan, surat keluar kedinasan, dan layanan legalisir ijazah alumni dikelola dalam alur yang transparan, aman, dan berstandar kearsipan nasional.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-6 gap-6">
                    
                    <!-- Bento Card 1 (Feature Utama - Large) -->
                    <article class="md:col-span-6 lg:col-span-4 relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-950 via-slate-900 to-blue-900 text-white p-7 sm:p-10 shadow-xl group">
                        <div class="absolute -right-16 -bottom-16 w-72 h-72 rounded-full bg-teal-400/20 blur-3xl pointer-events-none group-hover:scale-125 transition-transform duration-700"></div>
                        <div class="relative grid sm:grid-cols-5 gap-6 items-center">
                            <div class="sm:col-span-3">
                                <div class="w-13 h-13 rounded-2xl bg-white/10 ring-1 ring-white/20 text-teal-300 flex items-center justify-center mb-6 shadow-inner">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.6-4A12 12 0 0112 2.9 12 12 0 013.4 6 12 12 0 003 9c0 5.6 3.8 10.3 9 11.6 5.2-1.3 9-6 9-11.6 0-1-.1-2-.4-3z"/></svg>
                                </div>
                                <span class="text-xs font-bold text-teal-300 uppercase tracking-wider block mb-1">Layanan Unggulan Alumni</span>
                                <h3 class="font-heading font-extrabold text-2xl sm:text-3xl mb-3">Legalisir ijazah online mandiri</h3>
                                <p class="text-sm text-slate-300 leading-relaxed mb-6 font-normal">
                                    Alumni dapat mengajukan permohonan legalisir ijazah dan transkrip nilai secara online dari mana saja, memantau riwayat verifikasi step-by-step, dan hanya datang ke sekolah saat dokumen siap diambil.
                                </p>
                                <a href="{{ route('legalisir.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-teal-400 text-slate-950 text-sm font-bold hover:bg-teal-300 transition-all shadow-md shadow-teal-500/20 hover:-translate-y-0.5">
                                    <span>Ajukan Sekarang</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                            <!-- Mockup Ilustrasi Dokumen -->
                            <div class="sm:col-span-2 hidden sm:flex justify-center" aria-hidden="true">
                                <div class="relative w-44 h-56 rounded-2xl bg-white shadow-2xl rotate-3 p-5 border border-slate-100 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center gap-2 mb-3">
                                            <div class="w-6 h-6 rounded-full bg-blue-900/10 flex items-center justify-center text-[10px] font-bold text-blue-950">SMK</div>
                                            <div class="h-2 w-16 rounded bg-slate-300"></div>
                                        </div>
                                        <div class="h-2 w-full rounded bg-slate-200 mb-2"></div>
                                        <div class="h-2 w-5/6 rounded bg-slate-200 mb-2"></div>
                                        <div class="h-2 w-4/6 rounded bg-slate-200 mb-2"></div>
                                        <div class="h-2 w-3/4 rounded bg-slate-100"></div>
                                    </div>
                                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                        <div class="h-4 w-12 rounded bg-slate-200"></div>
                                        <div class="w-8 h-8 rounded-full border-2 border-teal-500 bg-teal-50 text-teal-600 flex items-center justify-center font-bold text-xs shadow-sm">
                                            ✓
                                        </div>
                                    </div>
                                    <!-- Badge Cap Stempel -->
                                    <div class="absolute -bottom-4 -right-4 w-16 h-16 rounded-full border-2 border-dashed border-teal-500 bg-teal-500/95 text-white flex flex-col items-center justify-center -rotate-12 shadow-lg">
                                        <span class="text-[8px] font-black tracking-tighter uppercase">LEGALISIR</span>
                                        <span class="text-[9px] font-bold">SAH</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- Bento Card 2 (Pencarian KMP) -->
                    <article class="md:col-span-3 lg:col-span-2 rounded-3xl bg-white border border-slate-200/90 p-7 sm:p-8 hover:shadow-xl hover:border-teal-300 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-800 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-teal-700 uppercase tracking-wider block mb-1">Algoritma Cerdas</span>
                            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-2.5">Pencarian arsip cepat KMP</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                Pencarian surat dengan algoritma Knuth-Morris-Pratt (KMP) mencocokkan pola teks tanpa komparasi ulang, memberikan hasil instan meski ribuan arsip bertambah.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs font-mono text-slate-500">
                            <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                            Kompleksitas O(n + m) Efisien
                        </div>
                    </article>

                    <!-- Bento Card 3 (Surat Masuk & Disposisi) -->
                    <article class="md:col-span-3 lg:col-span-3 rounded-3xl bg-white border border-slate-200/90 p-7 sm:p-8 hover:shadow-xl hover:border-blue-300 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-900 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.6a1 1 0 01.7.3l2.4 2.4a1 1 0 00.7.3h3.2a1 1 0 00.7-.3l2.4-2.4a1 1 0 01.7-.3H20"/></svg>
                            </div>
                            <span class="text-xs font-bold text-blue-800 uppercase tracking-wider block mb-1">Kearsipan Masuk</span>
                            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-2.5">Surat masuk & disposisi digital</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                Pencatatan nomor agenda kedinasan, penyimpanan pindaian berkas PDF resmi, serta penerusan instruksi Kepala Sekolah langsung ke Wakil Kepala Sekolah tanpa kertas disposisi fisik.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs font-semibold text-blue-900">
                            <span>Pelacakan instruksi pimpinan realtime</span>
                        </div>
                    </article>

                    <!-- Bento Card 4 (Surat Keluar & Approval Kepsek) -->
                    <article class="md:col-span-6 lg:col-span-3 rounded-3xl bg-white border border-slate-200/90 p-7 sm:p-8 hover:shadow-xl hover:border-indigo-300 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-900 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </div>
                            <span class="text-xs font-bold text-indigo-800 uppercase tracking-wider block mb-1">Surat Keluar</span>
                            <h3 class="font-heading font-extrabold text-xl text-slate-900 mb-2.5">Persetujuan surat keluar Kepsek</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                Draf surat keluar disusun oleh staf Tata Usaha, diverifikasi bertingkat, lalu disetujui Kepala Sekolah secara elektronik sebelum nomor surat resmi diterbitkan.
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-2 text-xs font-semibold text-indigo-900">
                            <span>Sistem penomoran otomatis & anti-duplikasi</span>
                        </div>
                    </article>

                </div>
            </div>
        </section>

        <!-- =========================================================================
             SECTION ALUR PELAYANAN (INTERAKTIF & MODERN)
             ========================================================================= -->
        <section id="alur" class="py-20 sm:py-28 bg-white border-y border-slate-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="max-w-3xl mx-auto text-center mb-14 sm:mb-20">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-100 text-teal-900 text-xs font-bold mb-3">
                        Transparan & Cepat
                    </span>
                    <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 tracking-tight text-balance">
                        Empat langkah sampai legalisir di tangan
                    </h2>
                    <p class="text-slate-600 mt-3 text-base">
                        Anda hanya perlu datang ke sekolah satu kali, yaitu saat berkas berstempel basah sudah dinyatakan siap diambil.
                    </p>
                </div>

                <!-- 4 Step Process Cards -->
                <div class="relative grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="hidden lg:block absolute top-12 left-[12.5%] right-[12.5%] h-1 bg-gradient-to-r from-blue-900 via-teal-600 to-emerald-500 rounded-full" aria-hidden="true"></div>
                    
                    @php
                        $alurLangkah = [
                            [
                                'num' => 1,
                                'judul' => 'Isi Formulir & Unggah Scan',
                                'isi' => 'Ketikkan NISN, pilih jenis dokumen (ijazah/transkrip), dan unggah hasil pindaian berkas asli dalam format PDF.',
                                'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.6a1 1 0 01.7.3l5.4 5.4a1 1 0 01.3.7V19a2 2 0 01-2 2z',
                            ],
                            [
                                'num' => 2,
                                'judul' => 'Verifikasi Buku Induk TU',
                                'isi' => 'Petugas Tata Usaha mencocokkan keabsahan data kelulusan pemohon dengan buku induk SMKN 1 Subang.',
                                'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
                            ],
                            [
                                'num' => 3,
                                'judul' => 'Persetujuan Kepala Sekolah',
                                'isi' => 'Kepala Sekolah memeriksa draf pengesahan dan memberikan persetujuan digital di sistem kearsipan.',
                                'icon' => 'M9 12l2 2 4-4m5.6-4A12 12 0 0112 2.9 12 12 0 013.4 6 12 12 0 003 9c0 5.6 3.8 10.3 9 11.6 5.2-1.3 9-6 9-11.6 0-1-.1-2-.4-3z',
                            ],
                            [
                                'num' => 4,
                                'judul' => 'Ambil Berkas di Sekolah',
                                'isi' => 'Setelah status siap diambil, datang ke loket TU dan tunjukkan nomor resi untuk mengambil berkas berstempel basah.',
                                'icon' => 'M5 13l4 4L19 7',
                            ],
                        ];
                    @endphp

                    @foreach($alurLangkah as $item)
                        <div class="relative p-6 sm:p-7 rounded-3xl bg-slate-50 border border-slate-200/90 text-center hover:bg-white hover:shadow-xl hover:border-teal-300 transition-all duration-300 flex flex-col items-center">
                            <div class="relative z-10 w-16 h-16 rounded-2xl {{ $item['num'] === 4 ? 'bg-gradient-to-br from-teal-500 to-emerald-600' : 'bg-blue-900' }} text-white font-heading font-extrabold text-xl flex items-center justify-center mb-5 ring-8 ring-white shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                                <span class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-slate-900 text-white text-xs font-black flex items-center justify-center ring-2 ring-white">
                                    {{ $item['num'] }}
                                </span>
                            </div>
                            <h3 class="font-heading font-bold text-base sm:text-lg text-slate-900 mb-2 leading-snug">{{ $item['judul'] }}</h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">{{ $item['isi'] }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Info Box Pendukung Persiapan -->
                <div class="mt-14 grid lg:grid-cols-5 gap-6 items-stretch">
                    <div class="lg:col-span-3 rounded-3xl bg-slate-50 border border-slate-200/90 p-6 sm:p-8">
                        <div class="flex items-center gap-2.5 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-800 flex items-center justify-center font-bold text-sm">
                                📋
                            </div>
                            <h3 class="font-heading font-extrabold text-lg text-slate-900">Dokumen yang perlu disiapkan</h3>
                        </div>
                        <ul class="grid sm:grid-cols-2 gap-3 text-sm text-slate-700">
                            @foreach([
                                'NISN dan tahun kelulusan aktif',
                                'File pindaian (scan) ijazah asli format PDF (maks. 2MB)',
                                'Jumlah lembar legalisir yang diajukan',
                                'Nomor WhatsApp & email aktif untuk konfirmasi',
                            ] as $syarat)
                                <li class="flex items-start gap-2.5">
                                    <svg class="w-5 h-5 text-teal-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span class="font-medium">{{ $syarat }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="lg:col-span-2 rounded-3xl bg-gradient-to-br from-teal-50 to-emerald-50 border border-teal-200 p-6 sm:p-8 flex flex-col justify-between gap-5 shadow-xs">
                        <div>
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-teal-800 uppercase tracking-wider mb-1">Cek Mandiri</span>
                            <h3 class="font-heading font-extrabold text-xl text-teal-950 mb-1.5">Sudah punya nomor resi?</h3>
                            <p class="text-sm text-teal-900/80 leading-relaxed">
                                Pantau posisi berkas Anda secara instan tanpa perlu masuk ke akun.
                            </p>
                        </div>
                        <a href="#lacak" class="inline-flex w-fit items-center gap-2 px-5 py-3 text-sm font-bold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-md transition-all hover:-translate-y-0.5">
                            <span>Lacak sekarang</span>
                            <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- =========================================================================
             SECTION FAQ (TANYA JAWAB INTERAKTIF)
             ========================================================================= -->
        <section id="faq" class="py-20 sm:py-28 bg-slate-50">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center mb-12 sm:mb-16">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-900 text-xs font-bold mb-3">
                        Informasi Bantuan
                    </span>
                    <h2 class="font-heading font-extrabold text-3xl sm:text-4xl text-slate-900 tracking-tight">
                        Pertanyaan yang sering diajukan
                    </h2>
                    <p class="text-slate-600 mt-2.5 text-sm sm:text-base">
                        Jawaban seputar prosedur pengajuan, durasi, pengambilan, serta status verifikasi.
                    </p>
                </div>

                <div class="space-y-3.5">
                    @foreach([
                        [
                            'tanya' => 'Berapa lama proses legalisir sampai selesai?',
                            'jawab' => 'Waktu pemrosesan rata-rata memakan waktu 1–2 hari kerja, tergantung antrean buku induk dan jadwal Kepala Sekolah. Anda dapat memantau status secara langsung melalui nomor resi tanda terima.',
                        ],
                        [
                            'tanya' => 'Apakah harus membuat akun login untuk mengajukan legalisir?',
                            'jawab' => 'Tidak wajib. Alumni dan siswa dapat mengajukan legalisir secara mandiri tanpa login melalui formulir publik. Akun pemohon hanya dibutuhkan jika Anda ingin menyimpan arsip riwayat seluruh permohonan dalam dashboard pribadi.',
                        ],
                        [
                            'tanya' => 'Apa saja yang harus dibawa saat mengambil dokumen di sekolah?',
                            'jawab' => 'Cukup tunjukkan nomor resi (misal LEG-202609-0001) kepada petugas loket Tata Usaha SMKN 1 Subang, serta membawa dokumen asli atau kartu tanda pengenal untuk pencocokan fisik sebelum penyerahan.',
                        ],
                        [
                            'tanya' => 'Bagaimana jika permohonan legalisir saya ditolak?',
                            'jawab' => 'Jika status ditolak, sistem akan menampilkan catatan resmi dari petugas TU (misal: scan berkas buram atau NISN tidak cocok). Anda dapat membaca catatan tersebut dan mengajukan kembali dengan berkas yang sudah diperbaiki.',
                        ],
                        [
                            'tanya' => 'Bagaimana cara memeriksa keaslian tanda terima legalisir?',
                            'jawab' => 'Setiap lembar tanda terima dilengkapi kode akses QR verifikasi. Siapa pun dapat memindai QR code tersebut untuk memverifikasi keaslian pengajuan di portal resmi SMKN 1 Subang.',
                        ],
                    ] as $item)
                        <details class="group rounded-2xl bg-white border border-slate-200/90 shadow-2xs open:shadow-md open:border-teal-300 transition-all duration-200">
                            <summary class="flex items-center justify-between gap-4 cursor-pointer p-5 font-bold text-slate-900 text-sm sm:text-base focus-visible:outline-2 focus-visible:outline-teal-600 rounded-2xl select-none">
                                <span>{{ $item['tanya'] }}</span>
                                <div class="faq-icon w-8 h-8 rounded-full bg-slate-100 group-open:bg-teal-100 text-slate-600 group-open:text-teal-700 flex items-center justify-center shrink-0 transition-all duration-200">
                                    <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </summary>
                            <div class="px-5 pb-5 -mt-1 text-sm text-slate-600 leading-relaxed border-t border-slate-100/80 pt-3">
                                {{ $item['jawab'] }}
                            </div>
                        </details>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- =========================================================================
             SECTION KONTAK & AKSES PORTAL KEDINASAN
             ========================================================================= -->
        <section id="kontak" class="py-20 sm:py-24 bg-slate-950 text-white relative overflow-hidden">
            <div class="absolute -top-32 -left-32 w-80 h-80 rounded-full bg-blue-600/10 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-32 -right-32 w-80 h-80 rounded-full bg-teal-500/10 blur-3xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-10 lg:gap-14 items-center">
                    
                    <!-- Informasi Gedung & Kontak TU -->
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-500/15 text-teal-300 text-xs font-bold mb-4 ring-1 ring-teal-400/30">
                            Loket Pelayanan Terpadu
                        </div>
                        <h3 class="font-heading font-extrabold text-3xl sm:text-4xl text-white mb-4 text-balance">
                            Layanan Tata Usaha SMKN 1 Subang
                        </h3>
                        <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-8 max-w-lg">
                            Gedung Administrasi Utama melayani pengelolaan arsip surat dinas kedinasan, disposisi, dan legalisir dokumen alumni setiap hari kerja.
                        </p>
                        
                        <ul class="space-y-4 text-sm text-slate-300">
                            <li class="flex items-start gap-3.5">
                                <span class="w-10 h-10 rounded-xl bg-teal-500/15 text-teal-400 flex items-center justify-center shrink-0 ring-1 ring-teal-500/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.7 16.7L13.4 20.9a2 2 0 01-2.8 0l-4.2-4.2a8 8 0 1111.3 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </span>
                                <div class="pt-1">
                                    <strong class="text-white block">Alamat Kampus:</strong>
                                    <span>Jl. Arief Rahman Hakim No. 35, Cigadung, Kec. Subang, Kabupaten Subang, Jawa Barat 41213</span>
                                </div>
                            </li>
                            <li class="flex items-center gap-3.5">
                                <span class="w-10 h-10 rounded-xl bg-teal-500/15 text-teal-400 flex items-center justify-center shrink-0 ring-1 ring-teal-500/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.3a1 1 0 01.9.7l1.5 4.5a1 1 0 01-.5 1.2l-2.3 1.1a11 11 0 005.5 5.5l1.1-2.3a1 1 0 011.2-.5l4.5 1.5a1 1 0 01.7.9V19a2 2 0 01-2 2h-1C9.7 21 3 14.3 3 6V5z"/></svg>
                                </span>
                                <div>
                                    <strong class="text-white block">Telepon Kantor:</strong>
                                    <a href="tel:+62260411410" class="hover:text-teal-300 transition-colors font-mono">(0260) 411410</a>
                                </div>
                            </li>
                            <li class="flex items-start gap-3.5">
                                <span class="w-10 h-10 rounded-xl bg-teal-500/15 text-teal-400 flex items-center justify-center shrink-0 ring-1 ring-teal-500/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.9 5.3a2 2 0 002.2 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <div class="pt-1">
                                    <strong class="text-white block">Email Resmi:</strong>
                                    <span class="break-all font-mono text-xs">smkn1subang@yahoo.co.id · info@smkn1subang.sch.id</span>
                                </div>
                            </li>
                            <li class="flex items-center gap-3.5">
                                <span class="w-10 h-10 rounded-xl bg-teal-500/15 text-teal-400 flex items-center justify-center shrink-0 ring-1 ring-teal-500/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg>
                                </span>
                                <div>
                                    <strong class="text-white block">Jam Operasional Pelayanan:</strong>
                                    <span>Senin–Jumat, 07.30–15.30 WIB (Hari Libur Tutup)</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Akses Cepat Masuk Portal -->
                    <div class="bg-slate-900/90 p-6 sm:p-8 rounded-3xl border border-slate-800 shadow-2xl backdrop-blur-sm">
                        <div class="flex items-center justify-between mb-5">
                            <h4 class="font-heading font-extrabold text-lg text-white">Akses portal pengguna</h4>
                            <span class="text-xs text-slate-400 font-mono">Role Access</span>
                        </div>
                        
                        <div class="space-y-3">
                            <!-- Portal Admin TU -->
                            <a href="{{ route('login') }}" class="flex items-center justify-between gap-3 p-4 rounded-2xl bg-slate-950/70 hover:bg-slate-950 border border-slate-800 hover:border-teal-500/60 transition-all text-sm group">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div class="w-11 h-11 rounded-xl bg-blue-900/80 text-blue-300 flex items-center justify-center font-extrabold text-xs shrink-0 ring-1 ring-blue-700/50">TU</div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-white group-hover:text-teal-300 transition-colors">Portal Staf Tata Usaha</div>
                                        <div class="text-xs text-slate-400 truncate">Kelola arsip surat, agenda & verifikasi berkas</div>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-slate-500 group-hover:text-teal-400 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>

                            <!-- Portal Kepala Sekolah -->
                            <a href="{{ route('login') }}" class="flex items-center justify-between gap-3 p-4 rounded-2xl bg-slate-950/70 hover:bg-slate-950 border border-slate-800 hover:border-emerald-500/60 transition-all text-sm group">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div class="w-11 h-11 rounded-xl bg-emerald-950 text-emerald-300 flex items-center justify-center font-extrabold text-xs shrink-0 ring-1 ring-emerald-700/50">KS</div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-white group-hover:text-emerald-300 transition-colors">Portal Kepala Sekolah</div>
                                        <div class="text-xs text-slate-400 truncate">Disposisi surat masuk & persetujuan legalisir</div>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-slate-500 group-hover:text-emerald-400 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>

                            <!-- Pengajuan Alumni Mandiri -->
                            <a href="{{ route('legalisir.create') }}" class="flex items-center justify-between gap-3 p-4 rounded-2xl bg-slate-950/70 hover:bg-slate-950 border border-slate-800 hover:border-purple-500/60 transition-all text-sm group">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div class="w-11 h-11 rounded-xl bg-purple-950 text-purple-300 flex items-center justify-center font-extrabold text-xs shrink-0 ring-1 ring-purple-700/50">AL</div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-white group-hover:text-purple-300 transition-colors">Formulir Legalisir Mandiri</div>
                                        <div class="text-xs text-slate-400 truncate">Ajukan dokumen ijazah online tanpa antre</div>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-slate-500 group-hover:text-purple-400 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <!-- Footer Resmi -->
    <footer class="bg-slate-950 text-slate-400 text-xs py-10 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
                <div class="flex items-center gap-3.5">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-9 h-11 object-contain shrink-0 opacity-90">
                    <div>
                        <p class="text-slate-200 font-bold text-sm">SMK Negeri 1 Subang — SMEA ARCHIVE</p>
                        <p class="text-slate-500 mt-0.5">Sistem Informasi Pengelolaan Arsip Kedinasan & Layanan Legalisir Dokumen Digital</p>
                    </div>
                </div>
                
                <div class="flex flex-col items-center md:items-end gap-2">
                    <nav class="flex flex-wrap justify-center gap-x-6 gap-y-1 text-slate-400 font-semibold" aria-label="Tautan navigasi footer">
                        <a href="#beranda" class="hover:text-teal-300 transition-colors">Beranda</a>
                        <a href="#lacak" class="hover:text-teal-300 transition-colors">Lacak</a>
                        <a href="#alur" class="hover:text-teal-300 transition-colors">Alur</a>
                        <a href="#tentang" class="hover:text-teal-300 transition-colors">Tentang Sistem</a>
                        <a href="#faq" class="hover:text-teal-300 transition-colors">Tanya Jawab</a>
                        <a href="#kontak" class="hover:text-teal-300 transition-colors">Kontak TU</a>
                    </nav>
                    <div class="text-slate-500 text-[11px]">&copy; {{ date('Y') }} SMKN 1 Subang. Dikembangkan berdasarkan Tata Kelola Kearsipan Pendidikan Jawa Barat.</div>
                </div>
            </div>
        </div>
    </footer>

    <!-- =========================================================================
         MODAL POP-UP CUSTOM: VALIDASI RESI BELUM DIISI (MODERN & INTERAKTIF)
         ========================================================================= -->
    <div id="empty-resi-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300" role="dialog" aria-modal="true" aria-labelledby="empty-modal-title">
        <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200/90 p-6 sm:p-7 transform scale-95 transition-all duration-300 text-center">
            
            <!-- Tombol Tutup X -->
            <button type="button" onclick="closeEmptyModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100 transition-colors" aria-label="Tutup pop-up">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <!-- Icon Warning Beranimasi -->
            <div class="w-16 h-16 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mx-auto mb-4 ring-8 ring-amber-50">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.9 4h13.8c1.5 0 2.5-1.7 1.7-3L13.7 4c-.8-1.3-2.7-1.3-3.5 0L3.3 16c-.8 1.3.2 3 1.7 3z"/></svg>
            </div>

            <!-- Teks Judul & Penjelasan -->
            <h3 id="empty-modal-title" class="font-heading font-extrabold text-xl text-slate-900 mb-2">
                Nomor Resi / NISN Belum Diisi
            </h3>
            <p class="text-sm text-slate-600 leading-relaxed mb-6">
                Silakan ketikkan <strong>nomor resi pengajuan legalisir</strong> Anda (contoh: <span class="font-mono font-bold text-teal-700">LEG-202609-0001</span>) atau <strong>10 digit NISN</strong> sebelum melakukan pelacakan status berkas.
            </p>

            <!-- Card Bantuan / Contoh Cepat -->
            <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/80 text-xs text-left mb-6">
                <span class="font-bold text-slate-700 block mb-1">Butuh contoh untuk mencoba fitur?</span>
                <p class="text-slate-500 mb-2.5">Klik tombol di bawah ini untuk memasukkan nomor resi contoh yang terdaftar di sistem.</p>
                <button type="button" onclick="fillExampleAndClose('LEG-202609-0001')" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-teal-100/80 text-teal-900 font-bold hover:bg-teal-200 transition-colors">
                    <span class="font-mono">LEG-202609-0001</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>

            <!-- Tombol Aksi Utama -->
            <div class="flex items-center justify-center gap-3">
                <button type="button" onclick="closeEmptyModal()" class="w-full py-3 px-5 text-sm font-bold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-md transition-all hover:shadow-lg active:scale-98">
                    Mengerti & Masukkan Resi
                </button>
            </div>

        </div>
    </div>

    <!-- Toast Notifikasi (Copy Clipboard & Alert) -->
    <div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 flex items-center gap-2.5 px-4 py-2.5 rounded-2xl bg-slate-900/95 text-white text-xs font-semibold shadow-2xl backdrop-blur-md opacity-0 pointer-events-none translate-y-3 transition-all duration-300 border border-slate-700" role="status">
        <svg id="toast-icon" class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        <span id="toast-msg">Nomor resi berhasil disalin!</span>
    </div>

    <!-- Tombol Back to Top -->
    <button id="to-top" type="button" aria-label="Kembali ke atas" class="fixed bottom-5 right-5 z-40 w-11 h-11 rounded-2xl bg-blue-900 text-white shadow-xl shadow-blue-950/30 hover:bg-blue-800 transition-all opacity-0 pointer-events-none translate-y-2 flex items-center justify-center hover:scale-105 active:scale-95">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
    </button>

    <!-- JavaScript Interaktif -->
    <script>
        (function () {
            // 1. Mobile Menu Drawer Toggle
            var menuBtn = document.getElementById('menu-btn');
            var mobileMenu = document.getElementById('mobile-menu');
            var iconOpen = document.getElementById('icon-open');
            var iconClose = document.getElementById('icon-close');

            function toggleMenu(open) {
                mobileMenu.classList.toggle('hidden', !open);
                iconOpen.classList.toggle('hidden', open);
                iconClose.classList.toggle('hidden', !open);
                menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
            }

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function () {
                    toggleMenu(mobileMenu.classList.contains('hidden'));
                });
                mobileMenu.querySelectorAll('a').forEach(function (link) {
                    link.addEventListener('click', function () { toggleMenu(false); });
                });
            }

            // 2. Scroll to Top & Header Shadow
            var toTop = document.getElementById('to-top');
            var header = document.getElementById('header');

            window.addEventListener('scroll', function () {
                var isScrolled = window.scrollY > 400;
                if (toTop) {
                    toTop.classList.toggle('opacity-0', !isScrolled);
                    toTop.classList.toggle('pointer-events-none', !isScrolled);
                    toTop.classList.toggle('translate-y-2', !isScrolled);
                }
                if (header) {
                    header.classList.toggle('shadow-md', window.scrollY > 15);
                }
            }, { passive: true });

            if (toTop) {
                toTop.addEventListener('click', function () {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // 3. Tracking Form Validation & Empty Resi Modal
            var trackingForm = document.getElementById('tracking-form');
            var resiInput = document.getElementById('nomor_pengajuan');
            var emptyModal = document.getElementById('empty-resi-modal');

            if (trackingForm && resiInput) {
                trackingForm.addEventListener('submit', function (e) {
                    var val = resiInput.value.trim();
                    if (!val) {
                        e.preventDefault();
                        showEmptyModal();
                    }
                });
            }

            // Modal Controls
            window.showEmptyModal = function () {
                if (!emptyModal) return;
                emptyModal.classList.remove('opacity-0', 'pointer-events-none');
                var card = emptyModal.querySelector('div');
                if (card) {
                    card.classList.remove('scale-95');
                    card.classList.add('scale-100');
                }
            };

            window.closeEmptyModal = function () {
                if (!emptyModal) return;
                emptyModal.classList.add('opacity-0', 'pointer-events-none');
                var card = emptyModal.querySelector('div');
                if (card) {
                    card.classList.remove('scale-100');
                    card.classList.add('scale-95');
                }
                // Focus & Shake Input Field
                if (resiInput) {
                    resiInput.focus();
                    resiInput.classList.add('input-shake', 'ring-2', 'ring-teal-500');
                    setTimeout(function () {
                        resiInput.classList.remove('input-shake');
                    }, 500);
                    setTimeout(function () {
                        resiInput.classList.remove('ring-2', 'ring-teal-500');
                    }, 1800);
                }
            };

            // Close on Backdrop Click & ESC Key
            if (emptyModal) {
                emptyModal.addEventListener('click', function (e) {
                    if (e.target === emptyModal) {
                        closeEmptyModal();
                    }
                });
            }
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && emptyModal && !emptyModal.classList.contains('pointer-events-none')) {
                    closeEmptyModal();
                }
            });

            // 4. Helper Fill Functions
            window.fillExampleResi = function (code) {
                if (resiInput) {
                    resiInput.value = code;
                    resiInput.focus();
                }
            };

            window.fillExampleAndClose = function (code) {
                if (resiInput) {
                    resiInput.value = code;
                }
                if (emptyModal) {
                    emptyModal.classList.add('opacity-0', 'pointer-events-none');
                }
                if (trackingForm) {
                    trackingForm.submit();
                }
            };

            window.clearTrackingInput = function () {
                if (resiInput) {
                    resiInput.value = '';
                    resiInput.focus();
                }
                // Jika ingin mereset halaman tanpa query, pindah ke route landing
                window.location.href = "{{ route('landing') }}#lacak";
            };

            // 5. Salin Resi (Copy to Clipboard)
            window.copyResiCode = function (text) {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(function () {
                        triggerToast('Nomor resi ' + text + ' berhasil disalin!');
                        updateCopyBtnVisual();
                    }).catch(function () {
                        fallbackCopyText(text);
                    });
                } else {
                    fallbackCopyText(text);
                }
            };

            function fallbackCopyText(text) {
                var temp = document.createElement('textarea');
                temp.value = text;
                document.body.appendChild(temp);
                temp.select();
                try {
                    document.execCommand('copy');
                    triggerToast('Nomor resi ' + text + ' berhasil disalin!');
                    updateCopyBtnVisual();
                } catch (err) {
                    triggerToast('Gagal menyalin resi.');
                }
                document.body.removeChild(temp);
            }

            function updateCopyBtnVisual() {
                var copyText = document.getElementById('copy-text');
                var copyIcon = document.getElementById('copy-icon');
                if (copyText) copyText.textContent = 'Tersalin!';
                setTimeout(function () {
                    if (copyText) copyText.textContent = 'Salin';
                }, 2000);
            }

            // 6. Toast Notification
            var toastTimer;
            window.triggerToast = function (msg) {
                var toast = document.getElementById('toast');
                var toastMsg = document.getElementById('toast-msg');
                if (!toast || !toastMsg) return;
                
                toastMsg.textContent = msg;
                toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-3');
                
                clearTimeout(toastTimer);
                toastTimer = setTimeout(function () {
                    toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-3');
                }, 2600);
            };
        })();
    </script>
</body>
</html>