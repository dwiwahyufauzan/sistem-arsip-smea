<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Tata Usaha') | Sistem Arsip SMKN 1 Subang</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-smk.png') }}" type="image/png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS / Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-heading { font-family: 'Outfit', sans-serif; }
        @media print {
            body { background: #ffffff !important; color: #000000 !important; }
            header, aside, .no-print, nav, #pdfViewerModal { display: none !important; }
            main { padding: 0 !important; margin: 0 !important; max-width: 100% !important; }
        }
    </style>

    @stack('styles')
</head>
<body class="h-full flex flex-col antialiased text-slate-800 bg-slate-100">

    <!-- Global Toast Alert -->
    <x-toast />

    <!-- Global PDF Viewer Modal -->
    <x-pdf-modal />

    <!-- Global Confirmation Action Modal -->
    <x-confirmation-modal />

    <!-- Top Navigation Bar Component (Full Width di Paling Atas) -->
    <x-navbar-admin />

    <!-- Body Layout Container (Di Bawah Full Navbar: pt-20) -->
    <div class="min-h-full flex-grow flex pt-20">
        <!-- Sidebar Navigation (Desktop & Mobile Drawer) -->
        <aside id="sidebarMenu" class="fixed top-20 bottom-0 left-0 z-30 w-64 bg-slate-900 text-slate-300 flex flex-col border-r border-slate-800 transition-transform duration-300 -translate-x-full md:translate-x-0">
            <!-- Sidebar Panel Title / Header -->
            <div class="px-5 py-3.5 bg-slate-950/40 border-b border-slate-800/60 flex items-center justify-between shrink-0">
                <span class="text-[11px] font-bold tracking-wider uppercase text-slate-400">Navigasi Tata Usaha</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Aktif
                </span>
            </div>

            <!-- Navigation Links Scrollable -->
            <nav class="flex-grow px-3 py-4 space-y-5 overflow-y-auto text-xs font-medium scrollbar-thin scrollbar-thumb-slate-700">
                <!-- Group 1: Utama -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Menu Utama</span>
                    <div class="mt-1.5 space-y-1">
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
                    <div class="mt-1.5 space-y-1">
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
                    <div class="mt-1.5 space-y-1">
                        <a href="{{ url('/admin/legalisir') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/legalisir*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Verifikasi Permohonan</span>
                        </a>
                    </div>
                </div>

                <!-- Group 4: Master Data & Audit Trail -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Master & Laporan Agenda</span>
                    <div class="mt-1.5 space-y-1">
                        <a href="{{ url('/admin/laporan') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/laporan*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Rekapitulasi Laporan & Agenda</span>
                        </a>

                        <a href="{{ url('/admin/kategori') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/kategori*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            <span>Kategori Klasifikasi</span>
                        </a>

                        <a href="{{ url('/admin/pengguna') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/pengguna*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span>Kelola User & Role</span>
                        </a>

                        <a href="{{ url('/admin/log-aktivitas') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('admin/log-aktivitas*') ? 'bg-blue-600 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Log Aktivitas Sistem</span>
                        </a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Mobile Backdrop Overlay -->
        <div id="sidebarBackdrop" onclick="toggleAdminSidebar()" class="fixed inset-0 top-20 bg-slate-950/60 z-20 backdrop-blur-xs hidden md:hidden"></div>

        <!-- Main Content Wrapper (Content + Footer) -->
        <div class="flex-grow flex flex-col md:pl-64 min-w-0">
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

    <!-- Script Drawer & Profile Dropdown -->
    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('sidebarMenu');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full');
            }
            if (backdrop) {
                backdrop.classList.toggle('hidden');
            }
        }

        function toggleAdminProfileDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('adminProfileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        window.addEventListener('click', function(e) {
            const container = document.getElementById('adminProfileDropdownContainer');
            const menu = document.getElementById('adminProfileDropdownMenu');
            if (container && menu && !container.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
