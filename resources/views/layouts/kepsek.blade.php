<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Pimpinan') | Portal Kepala Sekolah SMKN 1 Subang</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-heading { font-family: 'Outfit', sans-serif; }
    </style>

    @stack('styles')
</head>
<body class="h-full flex flex-col antialiased text-slate-800">

    <!-- Global Toast Alert -->
    <x-toast />

    <!-- Global PDF Viewer Modal -->
    <x-pdf-modal />

    <div class="min-h-full flex">
        <!-- Sidebar Navigation (Desktop) - Executive Green Accent -->
        <aside id="sidebarMenuKepsek" class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 flex flex-col border-r border-slate-800 transition-transform duration-300 -translate-x-full md:translate-x-0">
            <!-- School Brand Header -->
            <div class="h-20 flex items-center px-6 gap-3.5 bg-slate-950/80 border-b border-emerald-950 shrink-0">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-700 via-teal-800 to-blue-900 flex items-center justify-center text-white shadow-md shadow-emerald-950/40">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <div class="overflow-hidden">
                    <div class="flex items-center gap-1.5">
                        <span class="font-heading font-extrabold text-white text-base tracking-tight truncate">EKSEKUTIF</span>
                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">KEPSEK</span>
                    </div>
                    <p class="text-xs text-slate-400 truncate">SMK Negeri 1 Subang</p>
                </div>
            </div>

            <!-- Navigation Links Scrollable -->
            <nav class="flex-grow px-4 py-5 space-y-6 overflow-y-auto text-xs font-medium">
                <!-- Group 1: Pengawasan Eksekutif -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Panel Pimpinan</span>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('kepsek.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('kepsek.dashboard') ? 'bg-emerald-700 text-white font-semibold shadow-sm' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard Pimpinan</span>
                        </a>

                        <a href="{{ url('/kepala-sekolah/pencarian-kmp') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('kepala-sekolah/pencarian-kmp*') ? 'bg-emerald-700 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Pencarian Cepat KMP</span>
                        </a>
                    </div>
                </div>

                <!-- Group 2: Persetujuan & Disposisi -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Persetujuan & Kebijakan</span>
                    <div class="mt-2 space-y-1">
                        <!-- Surat Keluar Approval -->
                        <a href="{{ url('/kepala-sekolah/surat-keluar') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors {{ request()->is('kepala-sekolah/surat-keluar*') ? 'bg-emerald-700 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <div class="flex items-center gap-3 truncate">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span class="truncate">Persetujuan Surat Keluar</span>
                            </div>
                            @php
                                $pendingSkCount = \App\Models\SuratKeluar::where('status_persetujuan', 'menunggu_persetujuan')->count();
                            @endphp
                            @if($pendingSkCount > 0)
                                <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-slate-950 animate-pulse shrink-0">
                                    {{ $pendingSkCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Pemantauan Surat Masuk -->
                        <a href="{{ url('/kepala-sekolah/surat-masuk') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('kepala-sekolah/surat-masuk*') ? 'bg-emerald-700 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            <span>Pemantauan Surat Masuk</span>
                        </a>

                        <!-- Disposisi Surat Masuk -->
                        <a href="{{ url('/kepala-sekolah/disposisi') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('kepala-sekolah/disposisi*') ? 'bg-emerald-700 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <span>Disposisi Surat Masuk</span>
                        </a>

                        <!-- Pengesahan Legalisir -->
                        <a href="{{ url('/kepala-sekolah/legalisir') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors {{ request()->is('kepala-sekolah/legalisir*') ? 'bg-emerald-700 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <div class="flex items-center gap-3 truncate">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span class="truncate">Pengesahan Legalisir</span>
                            </div>
                            @php
                                $pendingLegalisirCount = \App\Models\PengajuanLegalisir::where('status', 'diverifikasi')->count();
                            @endphp
                            @if($pendingLegalisirCount > 0)
                                <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-slate-950 animate-pulse shrink-0">
                                    {{ $pendingLegalisirCount }}
                                </span>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Group 3: Rekapitulasi & Log Audit -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Laporan & Audit</span>
                    <div class="mt-2 space-y-1">
                        <a href="{{ url('/kepala-sekolah/laporan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('kepala-sekolah/laporan*') ? 'bg-emerald-700 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Rekapitulasi Agenda Arsip</span>
                        </a>

                        <a href="{{ url('/kepala-sekolah/log-aktivitas') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('kepala-sekolah/log-aktivitas*') ? 'bg-emerald-700 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Jejak Audit Aktivitas</span>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Bottom User Profile Card -->
            <div class="p-4 bg-slate-950/90 border-t border-slate-800 shrink-0">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 truncate">
                        <div class="w-8 h-8 rounded-lg bg-emerald-900 text-emerald-300 font-bold flex items-center justify-center shrink-0 border border-emerald-700/50">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </div>
                        <div class="truncate text-xs">
                            <p class="font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-slate-400 text-[10px] truncate">Kepala SMKN 1 Subang</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                        @csrf
                        <button 
                            type="submit" 
                            title="Keluar dari Akun"
                            class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition-colors"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex-grow flex flex-col md:pl-64 min-w-0">
            <!-- Top Navigation Bar -->
            <header class="h-20 bg-white border-b border-slate-200/80 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-xs">
                <!-- Left: Mobile Burger & Quick Search -->
                <div class="flex items-center gap-3 sm:gap-4 flex-grow max-w-xl">
                    <button 
                        type="button" 
                        onclick="document.getElementById('sidebarMenuKepsek').classList.toggle('-translate-x-full')"
                        class="md:hidden p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <!-- Search Input Bar -->
                    <form action="{{ url('/kepala-sekolah/pencarian-kmp') }}" method="GET" class="relative w-full">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input 
                                type="text" 
                                name="q" 
                                placeholder="Cari arsip & pengesahan pimpinan (KMP Search)..." 
                                class="w-full pl-9 pr-14 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all placeholder:text-slate-400"
                            >
                            <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                <kbd class="px-1.5 py-0.5 text-[10px] font-mono text-slate-400 bg-slate-200 rounded">KMP</kbd>
                            </span>
                        </div>
                    </form>
                </div>

                <!-- Right Action Menus -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('landing') }}" target="_blank" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-colors" title="Buka Portal Beranda Publik">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>

                    <!-- Profile Pill -->
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 pl-3 border-l border-slate-200 hover:opacity-80 transition-opacity" title="Pengaturan Profil & Password">
                        <div class="w-9 h-9 rounded-xl bg-emerald-800 text-white font-bold flex items-center justify-center text-xs shadow-xs">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="hidden sm:block text-left text-xs">
                            <p class="font-semibold text-slate-900 leading-tight">{{ auth()->user()->name }}</p>
                            <span class="text-[10px] font-medium text-emerald-800 bg-emerald-50 px-1.5 py-0.5 rounded">Kepala Sekolah</span>
                        </div>
                    </a>
                </div>
            </header>

            <!-- Page Title Bar -->
            <div class="bg-white border-b border-slate-200/60 py-5 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900 tracking-tight">
                            @yield('page_title', 'Portal Eksekutif Kepala Sekolah')
                        </h1>
                        <p class="text-xs text-slate-500 mt-0.5">
                            @yield('page_subtitle', 'Pengesahan Surat Keluar, Disposisi Surat Masuk & Pengesahan Legalisir')
                        </p>
                    </div>
                    <div class="flex items-center gap-2.5 shrink-0">
                        @yield('page_actions')
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <main class="flex-grow p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-200 text-slate-500 text-xs py-4 px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2">
                <span>&copy; {{ date('Y') }} SMKN 1 Subang — SMEA. Portal Pimpinan & Pengesahan Dokumen Resmi.</span>
                <span class="text-slate-400">Verifikasi Integritas & Otoritas Kepala Sekolah</span>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
