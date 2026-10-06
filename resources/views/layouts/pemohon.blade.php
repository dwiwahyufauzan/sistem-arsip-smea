<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Layanan Legalisir') | Portal Pemohon SMKN 1 Subang</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-smk.png') }}" type="image/png">

    <!-- Fonts & Assets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-heading { font-family: 'Outfit', sans-serif; }
    </style>

    @stack('styles')
</head>
<body class="min-h-full flex flex-col antialiased bg-slate-50 text-slate-800 selection:bg-teal-600 selection:text-white">

    <!-- Global Toast Alert -->
    <x-toast />

    <!-- Global PDF Viewer Modal -->
    <x-pdf-modal />

    <!-- Global Confirmation Action Modal -->
    <x-confirmation-modal />

    <!-- Top Bar Kedinasan Resmi (Identik dengan Landing Page) -->
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

    <!-- Top Navigation Bar Component -->
    <x-navbar-pemohon />

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
        @yield('content')
    </main>

    <!-- Footer Resmi Kedinasan (Identik dengan Landing Page) -->
    <footer class="bg-slate-950 text-slate-400 text-xs py-10 border-t border-slate-800 mt-auto">
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
                        <a href="{{ route('landing') }}" class="hover:text-teal-300 transition-colors">Beranda Publik</a>
                        <a href="{{ route('landing') }}#lacak" class="hover:text-teal-300 transition-colors">Lacak Resi</a>
                        <a href="{{ route('pemohon.dashboard') }}" class="hover:text-teal-300 transition-colors">Dashboard Pemohon</a>
                        <a href="{{ route('landing') }}#alur" class="hover:text-teal-300 transition-colors">Alur Pelayanan</a>
                        <a href="{{ route('landing') }}#faq" class="hover:text-teal-300 transition-colors">Tanya Jawab</a>
                        <a href="{{ route('landing') }}#kontak" class="hover:text-teal-300 transition-colors">Kontak TU</a>
                    </nav>
                    <div class="text-slate-500 text-[11px]">&copy; {{ date('Y') }} SMKN 1 Subang. Dikembangkan berdasarkan Tata Kelola Kearsipan Pendidikan Jawa Barat.</div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script Profile Dropdown -->
    <script>
        function togglePemohonProfileDropdown(e) {
            if (e) e.stopPropagation();
            const menu = document.getElementById('pemohonProfileDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        window.addEventListener('click', function(e) {
            const container = document.getElementById('pemohonProfileDropdownContainer');
            const menu = document.getElementById('pemohonProfileDropdownMenu');
            if (container && menu && !container.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
