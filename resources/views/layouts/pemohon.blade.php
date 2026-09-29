<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Layanan Legalisir') | Portal Pemohon SMKN 1 Subang</title>

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

    <!-- Top Navigation Bar for Pemohon / Alumni -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo & School Identity -->
                <a href="{{ route('pemohon.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-700 via-teal-800 to-blue-900 flex items-center justify-center text-white shadow-md shadow-teal-900/20 group-hover:scale-105 transition-transform duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-heading font-extrabold text-lg text-slate-900 tracking-tight">LEGALISIR SMEA</span>
                            <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-teal-100 text-teal-800">ALUMNI</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium">SMK Negeri 1 Subang</p>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center gap-6 text-xs font-semibold text-slate-600">
                    <a href="{{ route('pemohon.dashboard') }}" class="hover:text-teal-700 transition-colors {{ request()->routeIs('pemohon.dashboard') ? 'text-teal-700 font-bold' : '' }}">
                        Beranda Pemohon
                    </a>
                    <a href="{{ url('/pemohon/legalisir/create') }}" class="hover:text-teal-700 transition-colors {{ request()->is('pemohon/legalisir/create*') ? 'text-teal-700 font-bold' : '' }}">
                        Ajukan Legalisir Baru
                    </a>
                    <a href="{{ url('/pemohon/legalisir') }}" class="hover:text-teal-700 transition-colors {{ request()->is('pemohon/legalisir') ? 'text-teal-700 font-bold' : '' }}">
                        Riwayat & Tracking Berkas
                    </a>
                    <a href="{{ route('landing') }}#alur" target="_blank" class="hover:text-teal-700 transition-colors">
                        Panduan Berkas
                    </a>
                </nav>

                <!-- Profile & Logout Action -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('profile.edit') }}" class="hidden sm:block text-right text-xs hover:opacity-80 transition-opacity" title="Pengaturan Profil & Password">
                        <p class="font-semibold text-slate-900 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-teal-700 font-mono">NISN: {{ auth()->user()->nip_nisn ?? 'Alumni' }}</p>
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button 
                            type="submit" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-lg transition-colors cursor-pointer"
                            title="Keluar dari Akun"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Title Header -->
    <div class="bg-white border-b border-slate-200 py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900 tracking-tight">
                    @yield('page_title', 'Dashboard Layanan Legalisir')
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    @yield('page_subtitle', 'Portal mandiri pengajuan legalisir ijazah dan transkrip nilai SMKN 1 Subang')
                </p>
            </div>
            <div class="flex items-center gap-2.5 shrink-0">
                @yield('page_actions')
            </div>
        </div>
    </div>

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

    @stack('scripts')
</body>
</html>
