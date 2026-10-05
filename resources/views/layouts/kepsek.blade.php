<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Pimpinan') | Portal Kepala Sekolah SMKN 1 Subang</title>
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
    <x-navbar-kepsek />

    <!-- Body Layout Container (Di Bawah Full Navbar: pt-20) -->
    <div class="min-h-full flex-grow flex pt-20">
        <!-- Sidebar Navigation (Desktop & Mobile Drawer) - Executive Green Accent -->
        <aside id="sidebarMenuKepsek" class="fixed top-20 bottom-0 left-0 z-30 w-64 bg-slate-900 text-slate-300 flex flex-col border-r border-slate-800 transition-transform duration-300 -translate-x-full md:translate-x-0">
            <!-- Sidebar Panel Title / Header -->
            <div class="px-5 py-3.5 bg-slate-950/40 border-b border-emerald-950/60 flex items-center justify-between shrink-0">
                <span class="text-[11px] font-bold tracking-wider uppercase text-emerald-400">Panel Eksekutif Pimpinan</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold bg-emerald-500/10 text-emerald-300 border border-emerald-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Kepsek
                </span>
            </div>

            <!-- Navigation Links Scrollable -->
            <nav class="flex-grow px-3 py-4 space-y-5 overflow-y-auto text-xs font-medium scrollbar-thin scrollbar-thumb-slate-700">
                <!-- Group 1: Pengawasan Eksekutif -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Panel Pimpinan</span>
                    <div class="mt-1.5 space-y-1">
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
                    <div class="mt-1.5 space-y-1">
                        <!-- Surat Keluar Approval -->
                        <a href="{{ route('kepsek.persetujuan.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors {{ request()->is('kepala-sekolah/persetujuan*') || request()->is('kepala-sekolah/surat-keluar*') ? 'bg-emerald-700 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
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
                        <a href="{{ route('kepsek.surat-masuk.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ request()->is('kepala-sekolah/surat-masuk*') ? 'bg-emerald-700 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            <span>Pemantauan Surat Masuk</span>
                        </a>

                        <!-- Disposisi Surat Masuk -->
                        <a href="{{ route('kepsek.disposisi.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors {{ request()->is('kepala-sekolah/disposisi*') ? 'bg-emerald-700 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <div class="flex items-center gap-3 truncate">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span class="truncate">Disposisi Surat Masuk</span>
                            </div>
                            @php
                                $totalSmUnread = \App\Models\SuratMasuk::whereDoesntHave('disposisi')->count();
                            @endphp
                            @if($totalSmUnread > 0)
                                <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-500 text-white shrink-0">
                                    {{ $totalSmUnread }}
                                </span>
                            @endif
                        </a>

                        <!-- Pengesahan Legalisir -->
                        <a href="{{ route('kepsek.legalisir.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-colors {{ request()->is('kepala-sekolah/legalisir*') ? 'bg-emerald-700 text-white font-semibold' : 'hover:bg-slate-800/80 hover:text-white text-slate-400' }}">
                            <div class="flex items-center gap-3 truncate">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="truncate">Pengesahan Legalisir</span>
                            </div>
                            @php
                                $pendingLegalisir = \App\Models\PengajuanLegalisir::where('status', 'diajukan')->count();
                            @endphp
                            @if($pendingLegalisir > 0)
                                <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-500 text-white shrink-0">
                                    {{ $pendingLegalisir }}
                                </span>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Group 3: Rekapitulasi & Log Audit -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500">Laporan & Audit</span>
                    <div class="mt-1.5 space-y-1">
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
        </aside>

        <!-- Mobile Backdrop Overlay -->
        <div id="sidebarBackdropKepsek" onclick="toggleKepsekSidebar()" class="fixed inset-0 top-20 bg-slate-950/60 z-20 backdrop-blur-xs hidden md:hidden"></div>

        <!-- Main Content Wrapper (Content + Footer) -->
        <div class="flex-grow flex flex-col md:pl-64 min-w-0">
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

    <!-- Script Drawer & Profile Dropdown -->
    <script>
        function toggleKepsekSidebar() {
            const sidebar = document.getElementById('sidebarMenuKepsek');
            const backdrop = document.getElementById('sidebarBackdropKepsek');
            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full');
            }
            if (backdrop) {
                backdrop.classList.toggle('hidden');
            }
        }

        function toggleKepsekProfileDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('kepsekProfileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        window.addEventListener('click', function(e) {
            const container = document.getElementById('kepsekProfileDropdownContainer');
            const menu = document.getElementById('kepsekProfileDropdownMenu');
            if (container && menu && !container.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
