<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Layanan Legalisir') | Portal Pemohon SMKN 1 Subang</title>
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
    </style>

    @stack('styles')
</head>
<body class="h-full flex flex-col antialiased text-slate-800">

    <!-- Global Toast Alert -->
    <x-toast />

    <!-- Global PDF Viewer Modal -->
    <x-pdf-modal />

    <!-- Global Confirmation Action Modal -->
    <x-confirmation-modal />

    <!-- Top Navigation Bar Component -->
    <x-navbar-pemohon />

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 text-slate-500 text-xs py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div>
                <span class="font-semibold text-slate-700">Layanan Legalisir Online SMKN 1 Subang (SMEA)</span>
                <p class="text-[11px] text-slate-400 mt-0.5">Gedung Tata Usaha — Jl. Arief Rahman Hakim No. 35 Subang. Telp: (0260) 411410</p>
            </div>
            <div class="text-[11px] text-slate-400">
                Jam Layanan Pengambilan Berkas: Senin - Jumat (07.30 - 15.30 WIB)
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
