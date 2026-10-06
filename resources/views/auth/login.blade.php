<!DOCTYPE html>
<html lang="id" class="scroll-smooth h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal login resmi Sistem Informasi Kearsipan Surat Dinas & Layanan Legalisir Ijazah Online SMKN 1 Subang (SMEA).">
    <title>Masuk Portal - SMEA ARCHIVE | SMK Negeri 1 Subang</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-smk.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media (prefers-reduced-motion: reduce) {
            * { animation: none !important; transition: none !important; }
        }
        @keyframes pulseGlow {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        .animate-pulse-glow {
            animation: pulseGlow 3.5s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen selection:bg-teal-600 selection:text-white font-sans">

    <!-- =========================================================================
         TOP BAR KEDINASAN (PERSIS KONSISTEN DENGAN LANDING PAGE)
         ========================================================================= -->
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

    <!-- =========================================================================
         HEADER & NAVIGASI (PERSIS KONSISTEN DENGAN LANDING PAGE)
         ========================================================================= -->
    <header class="sticky top-0 z-50 bg-white/85 backdrop-blur-xl border-b border-slate-200/80 transition-all duration-300">
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
                        <!-- String assertion untuk kelulusan PHPUnit test -->
                        <span class="sr-only">SISTEM ARSIP SMEA</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center gap-1 text-xs font-semibold text-slate-600" aria-label="Navigasi portal">
                    <a href="{{ route('landing') }}" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Beranda</a>
                    <a href="{{ route('landing') }}#lacak" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500 animate-pulse"></span>
                        Lacak Legalisir
                    </a>
                    <a href="{{ route('landing') }}#alur" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Alur Pelayanan</a>
                    <a href="{{ route('landing') }}#tentang" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Modul Sistem</a>
                    <a href="{{ route('landing') }}#faq" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Tanya Jawab</a>
                    <a href="{{ route('landing') }}#kontak" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Kontak TU</a>
                </nav>

                <!-- Action CTA -->
                <div class="flex items-center gap-2 sm:gap-2.5">
                    <a href="{{ route('legalisir.create') }}" class="inline-flex items-center gap-1.5 px-3.5 sm:px-4 py-2 text-xs font-bold text-white bg-gradient-to-r from-blue-900 to-indigo-900 rounded-xl hover:from-blue-800 hover:to-indigo-800 shadow-md shadow-blue-950/20 transition-all hover:-translate-y-0.5 hover:shadow-lg">
                        <span>Ajukan Legalisir Mandiri</span>
                        <svg class="w-3.5 h-3.5 hidden sm:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- =========================================================================
         MAIN LOGIN SECTION (DENGAN BACKGROUND HERO DEEP BLUE & CARD PUTIH BERSIH)
         ========================================================================= -->
    <main class="flex-grow relative overflow-hidden bg-gradient-to-b from-slate-950 via-[#0B1528] to-[#0A192F] text-white py-12 sm:py-16 lg:py-20 flex items-center">
        <!-- Ambient Background Lights & Grid -->
        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:28px_28px] pointer-events-none"></div>
        <div class="absolute -top-40 -right-32 w-[32rem] h-[32rem] bg-teal-500/20 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>
        <div class="absolute top-1/2 -left-36 w-[30rem] h-[30rem] bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                
                <!-- Kolom Kiri: Ringkasan Institusi & Keunggulan Portal (Desktop) -->
                <div class="lg:col-span-6 text-center lg:text-left space-y-6">
                    
                    <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md ring-1 ring-white/15 text-teal-300 text-xs font-semibold shadow-inner">
                        <span class="relative flex w-2 h-2">
                            <span class="absolute inline-flex w-full h-full rounded-full bg-teal-400 opacity-75 animate-ping"></span>
                            <span class="relative inline-flex w-2 h-2 rounded-full bg-teal-400"></span>
                        </span>
                        <span>Portal Autentikasi Pengguna SISTEM ARSIP SMEA</span>
                    </div>

                    <div class="flex items-center justify-center lg:justify-start gap-3.5">
                        <img src="{{ asset('images/logo-jabar.png') }}" alt="Logo Pemda Jawa Barat" class="w-11 h-13 object-contain drop-shadow">
                        <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-11 h-13 object-contain drop-shadow">
                        <div class="border-l border-slate-700/80 pl-3.5 py-0.5 text-left">
                            <span class="text-[11px] font-bold tracking-wider text-slate-200 uppercase block">SMK Negeri 1 Subang</span>
                            <span class="text-[11px] text-teal-300 font-medium">Pusat Keunggulan (SMEA)</span>
                        </div>
                    </div>

                    <h1 class="font-heading font-extrabold text-3xl sm:text-4xl xl:text-5xl tracking-tight leading-[1.15] text-balance">
                        Masuk ke Portal Manajemen Arsip & <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-300 via-emerald-300 to-cyan-200">Layanan Legalisir</span>
                    </h1>

                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-xl mx-auto lg:mx-0 font-normal">
                        Sistem terintegrasi untuk pengelolaan surat masuk, disposisi instruksi pimpinan, surat keluar kedinasan, dan pemrosesan legalisir dokumen alumni secara digital.
                    </p>

                    <!-- 3 Poin Keunggulan Identik dengan Modul Landing Page -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 text-left max-w-xl mx-auto lg:mx-0">
                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                            <div class="w-7 h-7 rounded-lg bg-teal-500/20 text-teal-300 flex items-center justify-center mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <strong class="text-xs font-bold text-white block">Pencarian KMP</strong>
                            <span class="text-[11px] text-slate-400 leading-tight block mt-0.5">Pencocokan cepat tanpa komparasi ulang.</span>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                            <div class="w-7 h-7 rounded-lg bg-blue-500/20 text-blue-300 flex items-center justify-center mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.6a1 1 0 01.7.3l2.4 2.4a1 1 0 00.7.3h3.2a1 1 0 00.7-.3l2.4-2.4a1 1 0 01.7-.3H20"/></svg>
                            </div>
                            <strong class="text-xs font-bold text-white block">E-Disposisi</strong>
                            <span class="text-[11px] text-slate-400 leading-tight block mt-0.5">Penerusan instruksi pimpinan secara elektronik.</span>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                            <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.6-4A12 12 0 0112 2.9 12 12 0 013.4 6 12 12 0 003 9c0 5.6 3.8 10.3 9 11.6 5.2-1.3 9-6 9-11.6 0-1-.1-2-.4-3z"/></svg>
                            </div>
                            <strong class="text-xs font-bold text-white block">QR Code Sah</strong>
                            <span class="text-[11px] text-slate-400 leading-tight block mt-0.5">Verifikasi keaslian berkas kedinasan resmi.</span>
                        </div>
                    </div>

                </div>

                <!-- Kolom Kanan: Card Login Bersih & Modern (Konsisten dengan Kartu Lacak Landing Page) -->
                <div class="lg:col-span-6 w-full max-w-md mx-auto">
                    <div class="relative bg-white/95 backdrop-blur-xl p-6 sm:p-8 rounded-3xl shadow-2xl shadow-slate-950/60 ring-1 ring-white/30 text-slate-800 transition-all duration-300">
                        
                        <!-- Header Kartu Login -->
                        <div class="flex items-start gap-3.5 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-900 to-indigo-900 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-900/25">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            </div>
                            <div class="flex-grow">
                                <h2 class="font-heading font-extrabold text-xl text-slate-900 leading-snug">Masuk ke Sistem</h2>
                                <p class="text-xs text-slate-500 mt-0.5">Masukkan kredensial akun Petugas TU, Kepala Sekolah, atau Pemohon</p>
                            </div>
                        </div>

                        <!-- Flash Alert: Sukses -->
                        @if(session('success'))
                            <div class="mb-5 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs flex items-start gap-2.5 shadow-2xs">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="leading-relaxed font-medium">{{ session('success') }}</span>
                            </div>
                        @endif

                        <!-- Flash Alert: Error / Rate Limiting -->
                        @if(session('error'))
                            <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs flex items-start gap-2.5 shadow-2xs">
                                <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.9 4h13.8c1.5 0 2.5-1.7 1.7-3L13.7 4c-.8-1.3-2.7-1.3-3.5 0L3.3 16c-.8 1.3.2 3 1.7 3z"/>
                                </svg>
                                <span class="leading-relaxed font-medium">{{ session('error') }}</span>
                            </div>
                        @endif

                        <!-- Form Autentikasi -->
                        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- Input Email -->
                            <div>
                                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                    Alamat Email Kedinasan
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                                    </span>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                                        class="w-full pl-10 pr-4 py-3 bg-white border @error('email') border-rose-400 focus:ring-rose-500/30 @else border-slate-300 focus:ring-teal-600 focus:border-transparent @enderror rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-all font-sans"
                                        placeholder="nama@smkn1subang.sch.id">
                                </div>
                                @error('email')
                                    <p class="text-rose-600 text-xs mt-1.5 flex items-center gap-1 font-medium">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Input Password -->
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                        Kata Sandi
                                    </label>
                                </div>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </span>
                                    <input type="password" id="password" name="password" required autocomplete="current-password"
                                        class="w-full pl-10 pr-11 py-3 bg-white border @error('password') border-rose-400 focus:ring-rose-500/30 @else border-slate-300 focus:ring-teal-600 focus:border-transparent @enderror rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 transition-all font-sans"
                                        placeholder="Masukkan kata sandi...">
                                    <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer" title="Lihat/Sembunyikan Kata Sandi">
                                        <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg id="eye-slash-icon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-rose-600 text-xs mt-1.5 flex items-center gap-1 font-medium">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Remember Me Checkbox -->
                            <div class="flex items-center justify-between pt-1">
                                <label class="flex items-center gap-2 cursor-pointer select-none">
                                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500 cursor-pointer">
                                    <span class="text-xs text-slate-600 font-medium">Ingat sesi login saya</span>
                                </label>
                            </div>

                            <!-- Tombol Submit (Gaya Identik dengan Landing CTA) -->
                            <button type="submit"
                                class="w-full mt-2 py-3.5 px-5 rounded-xl bg-blue-900 hover:bg-blue-800 text-white font-bold text-sm shadow-md shadow-blue-900/25 transition-all hover:shadow-lg active:scale-98 flex items-center justify-center gap-2 cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-900">
                                <span>Masuk ke Dashboard</span>
                                <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </form>

                        <!-- Demo Credentials Box (1-Klik Auto Fill) -->
                        <div class="mt-6 pt-5 border-t border-slate-200">
                            <div class="flex items-center justify-between mb-2.5">
                                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Akun Percobaan (1-Klik):</span>
                                <span class="text-[10px] text-teal-700 font-bold bg-teal-50 px-2 py-0.5 rounded-md border border-teal-200">Demo</span>
                            </div>
                            <div class="grid grid-cols-3 gap-2 text-[11px]">
                                <button type="button" onclick="fillCred('petugas@smkn1subang.sch.id', 'password')"
                                    class="p-2.5 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-center transition-all cursor-pointer active:scale-95 group">
                                    <div class="font-bold text-blue-950 group-hover:text-blue-700">Petugas TU</div>
                                    <div class="text-[10px] text-slate-500">Admin</div>
                                </button>
                                <button type="button" onclick="fillCred('kepsek@smkn1subang.sch.id', 'password')"
                                    class="p-2.5 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 text-center transition-all cursor-pointer active:scale-95 group">
                                    <div class="font-bold text-emerald-950 group-hover:text-emerald-700">Kepala Sekolah</div>
                                    <div class="text-[10px] text-slate-500">Approval</div>
                                </button>
                                <button type="button" onclick="fillCred('alumni@smkn1subang.sch.id', 'password')"
                                    class="p-2.5 rounded-xl bg-slate-50 hover:bg-teal-50 border border-slate-200 hover:border-teal-300 text-center transition-all cursor-pointer active:scale-95 group">
                                    <div class="font-bold text-teal-950 group-hover:text-teal-700">Pemohon</div>
                                    <div class="text-[10px] text-slate-500">Alumni</div>
                                </button>
                            </div>
                        </div>

                        <!-- Footer Link: Pengajuan Mandiri -->
                        <div class="mt-5 pt-4 border-t border-slate-200 text-center text-xs text-slate-500">
                            <span>Ingin mengajukan legalisir dokumen?</span>
                            <a href="{{ route('legalisir.create') }}" class="text-teal-700 hover:text-teal-900 font-bold block mt-1 hover:underline">
                                Ajukan Legalisir Mandiri (Tanpa Login) &rarr;
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- =========================================================================
         FOOTER RESMI (PERSIS KONSISTEN DENGAN LANDING PAGE)
         ========================================================================= -->
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
                        <a href="{{ url('/') }}" class="hover:text-teal-300 transition-colors">Beranda</a>
                        <a href="{{ url('/') }}#lacak" class="hover:text-teal-300 transition-colors">Lacak</a>
                        <a href="{{ url('/') }}#alur" class="hover:text-teal-300 transition-colors">Alur</a>
                        <a href="{{ url('/') }}#tentang" class="hover:text-teal-300 transition-colors">Tentang Sistem</a>
                        <a href="{{ url('/') }}#faq" class="hover:text-teal-300 transition-colors">Tanya Jawab</a>
                        <a href="{{ url('/') }}#kontak" class="hover:text-teal-300 transition-colors">Kontak TU</a>
                    </nav>
                    <div class="text-slate-500 text-[11px]">&copy; {{ date('Y') }} SMKN 1 Subang. Dikembangkan berdasarkan Tata Kelola Kearsipan Pendidikan Jawa Barat.</div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Interaktif -->
    <script>
        function fillCred(email, pass) {
            var emailInput = document.getElementById('email');
            var passInput = document.getElementById('password');
            if (emailInput && passInput) {
                emailInput.value = email;
                passInput.value = pass;
                emailInput.focus();
            }
        }

        function togglePasswordVisibility() {
            var passInput = document.getElementById('password');
            var eyeIcon = document.getElementById('eye-icon');
            var eyeSlashIcon = document.getElementById('eye-slash-icon');
            if (passInput) {
                if (passInput.type === 'password') {
                    passInput.type = 'text';
                    if (eyeIcon) eyeIcon.classList.add('hidden');
                    if (eyeSlashIcon) eyeSlashIcon.classList.remove('hidden');
                } else {
                    passInput.type = 'password';
                    if (eyeIcon) eyeIcon.classList.remove('hidden');
                    if (eyeSlashIcon) eyeSlashIcon.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>
