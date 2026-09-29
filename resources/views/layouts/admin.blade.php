<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Tata Usaha') | Sistem Arsip SMKN 1 Subang</title>

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
        <!-- Sidebar Navigation (Desktop) -->
        <aside id="sidebarMenu" class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-slate-300 flex flex-col border-r border-slate-800 transition-transform duration-300 -translate-x-full md:translate-x-0">
            <!-- School Brand Header -->
            <div class="h-20 flex items-center px-6 gap-3.5 bg-slate-950/60 border-b border-slate-800/80 shrink-0">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-700 via-blue-800 to-teal-500 flex items-center justify-center text-white shadow-md shadow-blue-900/40">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <div class="overflow-hidden">
                    <div class="flex items-center gap-1.5">
                        <span class="font-heading font-extrabold text-white text-base tracking-tight truncate">SMEA ARSIP</span>
                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">TU</span>
                    </div>
                    <p class="text-xs text-slate-400 truncate">SMK Negeri 1 Subang</p>
                </div>
            </div>

            <!-- Navigation Links Scrollable -->
            <nav class="flex-grow px-4 py-5 space-y-6 overflow-y-auto text-xs font-medium">
                <!-- Group 1: Utama -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Menu Utama</span>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard Petugas</span>
                        </a>

                        <a href="{{ url('/admin/pencarian-kmp') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/pencarian-kmp*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Pencarian Cerdas KMP</span>
                            <span class="ml-auto text-[9px] font-bold uppercase px-1.5 py-0.5 rounded bg-teal-500/20 text-teal-300 border border-teal-500/30">Fast</span>
                        </a>
                    </div>
                </div>

                <!-- Group 2: Modul Arsip Persuratan -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Pengelolaan Arsip</span>
                    <div class="mt-2 space-y-1">
                        <a href="{{ url('/admin/surat-masuk') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/surat-masuk*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            <span>Surat Masuk</span>
                        </a>

                        <a href="{{ url('/admin/surat-keluar') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/surat-keluar*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            <span>Surat Keluar</span>
                        </a>

                        <a href="{{ url('/admin/disposisi') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/disposisi*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span>Disposisi Pimpinan</span>
                        </a>
                    </div>
                </div>

                <!-- Group 3: Layanan Publik Legalisir -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Layanan Legalisir</span>
                    <div class="mt-2 space-y-1">
                        <a href="{{ url('/admin/legalisir') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/legalisir*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Verifikasi Permohonan</span>
                        </a>
                    </div>
                </div>

                <!-- Group 4: Master Data & Audit Trail -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Master & Audit Trail</span>
                    <div class="mt-2 space-y-1">
                        <a href="{{ url('/admin/kategori') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/kategori*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            <span>Kategori Klasifikasi</span>
                        </a>

                        <a href="{{ url('/admin/pengguna') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/pengguna*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span>Manajemen Pengguna</span>
                        </a>

                        <a href="{{ url('/admin/log-aktivitas') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/log-aktivitas*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Log Aktivitas Sistem</span>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Bottom User Profile Card -->
            <div class="p-4 bg-slate-950/80 border-t border-slate-800 shrink-0">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 truncate">
                        <div class="w-8 h-8 rounded-lg bg-blue-900 text-blue-300 font-bold flex items-center justify-center shrink-0 border border-blue-700/50">
                            {{ substr(auth()->user()->name, 0, 2) }}
                        </div>
                        <div class="truncate text-xs">
                            <p class="font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-slate-400 text-[10px] truncate">{{ auth()->user()->email }}</p>
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
                <!-- Left: Burger Toggle & Quick Search -->
                <div class="flex items-center gap-3 sm:gap-4 flex-grow max-w-xl">
                    <button 
                        type="button" 
                        onclick="document.getElementById('sidebarMenu').classList.toggle('-translate-x-full')"
                        class="md:hidden p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <!-- Instant KMP Search Input Bar -->
                    <form action="{{ url('/admin/pencarian-kmp') }}" method="GET" class="relative w-full">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </span>
                            <input 
                                type="text" 
                                name="q" 
                                placeholder="Cari arsip cepat (KMP Search: nomor surat, perihal, pengirim)..." 
                                class="w-full pl-9 pr-14 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all placeholder:text-slate-400"
                            >
                            <span class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                <kbd class="px-1.5 py-0.5 text-[10px] font-mono text-slate-400 bg-slate-200 rounded">KMP</kbd>
                            </span>
                        </div>
                    </form>
                </div>

                <!-- Right Action Menus -->
                <div class="flex items-center gap-3">
                    <div class="hidden lg:flex items-center gap-2 text-xs font-medium text-slate-500 border border-slate-200 px-3 py-1.5 rounded-xl bg-slate-50">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>TA 2026/2027</span>
                    </div>

                    <a href="{{ route('landing') }}" target="_blank" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-colors" title="Buka Portal Beranda Publik">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>

                    <!-- Profile Pill -->
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 pl-3 border-l border-slate-200 hover:opacity-80 transition-opacity" title="Pengaturan Profil & Password">
                        <div class="w-9 h-9 rounded-xl bg-blue-900 text-white font-bold flex items-center justify-center text-xs shadow-xs">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="hidden sm:block text-left text-xs">
                            <p class="font-semibold text-slate-900 leading-tight">{{ auth()->user()->name }}</p>
                            <span class="text-[10px] font-medium text-blue-700 bg-blue-50 px-1.5 py-0.5 rounded">Petugas TU</span>
                        </div>
                    </a>
                </div>
            </header>

            <!-- Page Title Bar -->
            <div class="bg-white border-b border-slate-200/60 py-5 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900 tracking-tight">
                            @yield('page_title', 'Dashboard Petugas TU')
                        </h1>
                        <p class="text-xs text-slate-500 mt-0.5">
                            @yield('page_subtitle', 'Sistem Informasi Manajemen Kearsipan SMKN 1 Subang')
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
                <span>&copy; {{ date('Y') }} SMKN 1 Subang — SMEA. Tata Kelola Arsip & Layanan Legalisir Digital.</span>
                <span class="text-slate-400">Pencarian Arsip Terindeks Knuth-Morris-Pratt (KMP)</span>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
