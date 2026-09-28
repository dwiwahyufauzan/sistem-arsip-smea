<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun Pemohon - Sistem Arsip SMKN 1 Subang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-900 text-slate-100 flex flex-col justify-between selection:bg-teal-500 selection:text-white">
    <!-- Header instansi -->
    <header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-700 to-teal-500 flex items-center justify-center font-bold text-white shadow-lg shadow-blue-500/20 group-hover:scale-105 transition-transform">
                    SA
                </div>
                <div>
                    <h1 class="text-base font-bold text-white tracking-tight">SISTEM ARSIP SMEA</h1>
                    <p class="text-xs text-slate-400">SMK Negeri 1 Subang</p>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-xs sm:text-sm text-teal-400 hover:text-teal-300 font-medium transition-colors">
                    Sudah Punya Akun? Masuk
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-8 my-4">
        <div class="w-full max-w-md">
            <!-- Card Register -->
            <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-6 sm:p-8 shadow-2xl shadow-black/40 backdrop-blur-xl">
                <div class="text-center mb-6">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-teal-500/10 border border-teal-500/30 flex items-center justify-center text-teal-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Daftar Akun Pemohon</h2>
                    <p class="text-xs text-slate-400 mt-1">Daftar akun untuk mengajukan legalisir dan memantau status dokumen</p>
                </div>

                <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-2 bg-slate-900/90 border @error('name') border-rose-500 @else border-slate-700 @enderror rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all"
                            placeholder="Sesuai nama di Ijazah">
                        @error('name')
                            <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="nisn" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1">NISN</label>
                            <input type="text" id="nisn" name="nisn" value="{{ old('nisn') }}" required
                                class="w-full px-4 py-2 bg-slate-900/90 border @error('nisn') border-rose-500 @else border-slate-700 @enderror rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all"
                                placeholder="10 digit NISN">
                            @error('nisn')
                                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone_number" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1">No. WhatsApp</label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                                class="w-full px-4 py-2 bg-slate-900/90 border @error('phone_number') border-rose-500 @else border-slate-700 @enderror rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all"
                                placeholder="08xxxxxxxxxx">
                            @error('phone_number')
                                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1">Alamat Email Aktif</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2 bg-slate-900/90 border @error('email') border-rose-500 @else border-slate-700 @enderror rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all"
                            placeholder="nama@email.com">
                        @error('email')
                            <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1">Kata Sandi</label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-2 bg-slate-900/90 border @error('password') border-rose-500 @else border-slate-700 @enderror rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all"
                                placeholder="Min. 6 karakter">
                            @error('password')
                                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1">Konfirmasi</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="w-full px-4 py-2 bg-slate-900/90 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all"
                                placeholder="Ulangi sandi">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-3 py-3 px-4 rounded-xl bg-gradient-to-r from-teal-600 to-blue-600 hover:from-teal-500 hover:to-blue-500 text-white font-semibold text-sm shadow-lg shadow-teal-900/30 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2">
                        <span>Daftarkan Akun Pemohon</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>

                <p class="text-center text-xs text-slate-400 mt-5">
                    Sudah memiliki akun terdaftar? 
                    <a href="{{ route('login') }}" class="text-teal-400 hover:underline font-medium">Masuk di sini</a>
                </p>
            </div>
        </div>
    </main>
</body>
</html>
