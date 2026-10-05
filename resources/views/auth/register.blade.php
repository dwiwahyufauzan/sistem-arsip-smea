<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun Pemohon - Sistem Arsip SMKN 1 Subang</title>
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
                <a href="{{ route('login') }}" class="text-xs sm:text-sm text-teal-400 hover:text-teal-300 font-medium transition-colors">
                    Sudah Punya Akun? Masuk
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-8 my-4">
        <div class="w-full max-w-md">
            <!-- Card Pemberitahuan Kebijakan Pendaftaran Akun -->
            <div class="bg-slate-800/80 border border-slate-700/80 rounded-2xl p-6 sm:p-8 shadow-2xl shadow-black/40 backdrop-blur-xl text-center">
                <!-- Icon Lembaga / Keamanan -->
                <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-16 h-20 mx-auto mb-4 object-contain drop-shadow-md">

                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs font-semibold mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                    Kebijakan Tata Usaha SMKN 1 Subang
                </div>

                <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">Pendaftaran Akun Terpusat</h2>
                <p class="text-xs sm:text-sm text-slate-300 mt-2 leading-relaxed max-w-sm mx-auto">
                    Sesuai SOP Administrasi SMKN 1 Subang, pembuatan akun sistem bagi <strong>Siswa & Alumni</strong> dilakukan secara terpusat oleh <strong>Admin / Petugas Tata Usaha</strong>.
                </p>

                <!-- Information Box -->
                <div class="mt-6 p-4 rounded-xl bg-slate-900/80 border border-slate-700/60 text-left space-y-2.5">
                    <div class="flex items-start gap-2.5 text-xs text-slate-300">
                        <svg class="w-4 h-4 text-teal-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span><strong>Pengajuan Tanpa Akun:</strong> Anda tetap dapat mengajukan legalisir mandiri secara online tanpa harus memiliki akun.</span>
                    </div>
                    <div class="flex items-start gap-2.5 text-xs text-slate-300">
                        <svg class="w-4 h-4 text-teal-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span><strong>Pelacakan Nomor Resi:</strong> Perkembangan verifikasi dokumen dapat dipantau langsung melalui fitur <em>Live Tracking</em>.</span>
                    </div>
                    <div class="flex items-start gap-2.5 text-xs text-slate-300">
                        <svg class="w-4 h-4 text-teal-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span><strong>Registrasi Akun:</strong> Hubungi ruang Tata Usaha SMKN 1 Subang jika memerlukan akun dashboard pemohon.</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 space-y-3">
                    <a href="{{ route('legalisir.create') }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white font-bold text-xs shadow-lg shadow-teal-500/20 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Ajukan Legalisir Mandiri (Tanpa Akun)</span>
                    </a>

                    <div class="grid grid-cols-2 gap-2.5">
                        <a href="{{ route('legalisir.tracking') }}" class="inline-flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-900/80 border border-slate-700 text-slate-300 hover:text-white text-xs font-semibold transition-all">
                            <svg class="w-3.5 h-3.5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Lacak Berkas</span>
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white text-xs font-semibold transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            <span>Masuk Sistem</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
