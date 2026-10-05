<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Pengelolaan Arsip SMKN 1 Subang</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-smk.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between selection:bg-teal-500 selection:text-white">
    <!-- Header instansi -->
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-9 h-11 object-contain shrink-0 group-hover:scale-105 transition-transform">
                <div>
                    <h1 class="text-base font-bold text-white tracking-tight">SISTEM ARSIP SMEA</h1>
                    <p class="text-xs text-slate-400">SMK Negeri 1 Subang</p>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="text-xs sm:text-sm text-slate-400 hover:text-white transition-colors">
                    Beranda
                </a>
                <span class="text-slate-700">•</span>
                <a href="{{ route('legalisir.create') }}" class="text-xs sm:text-sm text-teal-400 hover:text-teal-300 font-medium transition-colors">
                    Pengajuan Legalisir Mandiri
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-md">
            <!-- Card Login -->
            <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-6 sm:p-8 shadow-2xl shadow-black/40 backdrop-blur-xl">
                <!-- Icon & Title -->
                <div class="text-center mb-8">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-16 h-20 mx-auto mb-3 object-contain drop-shadow-md">
                    <h2 class="text-2xl font-bold text-white tracking-tight">Masuk ke Sistem</h2>
                    <p class="text-xs text-slate-400 mt-1">Silakan masukkan akun Petugas, Kepala Sekolah, atau Pemohon</p>
                </div>

                <!-- Flash Notifications -->
                @if(session('success'))
                    <div class="mb-5 p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs sm:text-sm flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs sm:text-sm flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full px-4 py-2.5 bg-slate-900/90 border @error('email') border-rose-500 @else border-slate-700 @enderror rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all"
                                placeholder="nama@smkn1subang.sch.id">
                        </div>
                        @error('email')
                            <p class="text-rose-400 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Kata Sandi</label>
                        </div>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-2.5 bg-slate-900/90 border @error('password') border-rose-500 @else border-slate-700 @enderror rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all"
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-rose-400 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-slate-900 border-slate-700 text-teal-600 focus:ring-teal-500 focus:ring-offset-slate-900">
                            <span class="text-xs text-slate-400 select-none">Ingat sesi saya</span>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full mt-2 py-3 px-4 rounded-xl bg-gradient-to-r from-blue-700 via-blue-600 to-teal-600 hover:from-blue-600 hover:to-teal-500 text-white font-semibold text-sm shadow-lg shadow-blue-900/40 hover:shadow-teal-900/40 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                        <span>Masuk ke Dashboard</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>

                <!-- Demo Credentials Box -->
                <div class="mt-6 pt-5 border-t border-slate-700/60">
                    <p class="text-xs font-semibold text-slate-400 mb-2.5 text-center">Akun Percobaan Default:</p>
                    <div class="grid grid-cols-3 gap-2 text-[11px]">
                        <button type="button" onclick="fillCred('petugas@smkn1subang.sch.id', 'password')"
                            class="p-2 rounded-lg bg-slate-900/60 hover:bg-slate-700/50 border border-slate-700 text-center transition-colors">
                            <div class="font-bold text-blue-400">Petugas TU</div>
                            <div class="text-[10px] text-slate-400">Admin</div>
                        </button>
                        <button type="button" onclick="fillCred('kepsek@smkn1subang.sch.id', 'password')"
                            class="p-2 rounded-lg bg-slate-900/60 hover:bg-slate-700/50 border border-slate-700 text-center transition-colors">
                            <div class="font-bold text-amber-400">Kepala Sekolah</div>
                            <div class="text-[10px] text-slate-400">Approval</div>
                        </button>
                        <button type="button" onclick="fillCred('alumni@smkn1subang.sch.id', 'password')"
                            class="p-2 rounded-lg bg-slate-900/60 hover:bg-slate-700/50 border border-slate-700 text-center transition-colors">
                            <div class="font-bold text-teal-400">Pemohon</div>
                            <div class="text-[10px] text-slate-400">Alumni</div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-700/80 text-center text-xs text-slate-400">
                    Akun Siswa & Alumni didaftarkan oleh Admin Tata Usaha. Ingin mengajukan berkas?
                    <a href="{{ route('legalisir.create') }}" class="text-teal-400 hover:underline font-semibold block sm:inline mt-1 sm:mt-0">Ajukan Legalisir Mandiri (Tanpa Akun) &rarr;</a>
                </div>
            </div>

            <!-- Footer copyright -->
            <p class="text-center text-xs text-slate-500 mt-6">
                &copy; {{ date('Y') }} SMKN 1 Subang. Dikembangkan dengan Algoritma KMP & Laravel.
            </p>
        </div>
    </main>

    <script>
        function fillCred(email, pass) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = pass;
        }
    </script>
</body>
</html>
