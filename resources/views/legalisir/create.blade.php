<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Formulir Permohonan Legalisir Online | SMKN 1 Subang</title>
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
</head>
<body class="min-h-full flex flex-col text-slate-800 antialiased selection:bg-teal-600 selection:text-white bg-slate-50">

    <x-toast />
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

    <!-- Header & Navigasi (Identik dengan Landing Page) -->
    <header class="sticky top-0 z-40 bg-white/85 backdrop-blur-xl border-b border-slate-200/80 transition-all duration-300 shadow-xs">
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
                    </div>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-1 text-xs font-semibold text-slate-600" aria-label="Navigasi formulir">
                    <a href="{{ route('landing') }}" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Beranda</a>
                    <a href="{{ route('legalisir.tracking') }}" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Lacak Resi</a>
                    <a href="{{ route('landing') }}#alur" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Alur Pelayanan</a>
                    <a href="{{ route('landing') }}#faq" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Tanya Jawab</a>
                </nav>

                <!-- Action Button -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('legalisir.tracking') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:text-blue-950 hover:bg-slate-100 rounded-xl transition-colors">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Cek Status</span>
                    </a>

                    @auth
                        @if(auth()->user()->role === 'pemohon')
                            <a href="{{ route('pemohon.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-xl text-xs font-bold shadow-xs transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span>Dashboard Saya</span>
                            </a>
                        @else
                            <a href="{{ url('/admin/dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white rounded-xl text-xs font-bold shadow-xs transition-colors">
                                <span>Panel Petugas</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-950 hover:bg-blue-900 text-white rounded-xl text-xs font-bold shadow-xs transition-colors">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            <span>Masuk Akun</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Deep Navy Hero Canvas (Identik dengan Landing Page) -->
    <div class="relative bg-gradient-to-b from-slate-950 via-[#0B1528] to-[#0A192F] text-white pt-10 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <!-- Radial Dot Background & Ambient Glow -->
        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:18px_18px] pointer-events-none"></div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-4xl mx-auto text-center relative z-10 space-y-3.5">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full text-xs font-bold bg-teal-500/20 text-teal-300 ring-1 ring-teal-400/40">
                <svg class="w-3.5 h-3.5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Pelayanan Mandiri Cepat & Transparan</span>
            </span>

            <h1 class="font-heading font-extrabold text-2xl sm:text-4xl tracking-tight text-white">
                Permohonan Legalisir Dokumen Online
            </h1>

            <p class="text-xs sm:text-sm text-slate-300 max-w-2xl mx-auto leading-relaxed">
                Pengajuan legalisir Ijazah, Transkrip Nilai, Rapor, dan Sertifikat UKK resmi SMKN 1 Subang (SMEA) tanpa antre panjang di sekolah.
            </p>
        </div>
    </div>

    <!-- Main Content Form Card -->
    <main class="flex-grow max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 -mt-10 relative z-20 mb-16">
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl border border-slate-200/90 shadow-2xl overflow-hidden">

            <!-- Card Header -->
            <div class="px-6 sm:px-8 py-5 bg-gradient-to-r from-slate-50 to-slate-100/70 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-teal-100 text-teal-800 flex items-center justify-center font-bold text-sm shrink-0 ring-1 ring-teal-300">
                        <svg class="w-5 h-5 text-teal-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-heading font-bold text-base text-slate-900">Formulir Data Permohonan Legalisir</h2>
                        <p class="text-xs text-slate-500">Lengkapi identitas diri dan unggah berkas pindaian dokumen asli</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-800 border border-blue-200/80">
                    Langkah 1 dari 1
                </span>
            </div>

            <!-- Form -->
            <form action="{{ route('legalisir.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
                @csrf

                <!-- Section 1: Identitas Pemohon -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-100">
                        <div class="w-7 h-7 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center font-bold text-xs ring-1 ring-blue-200">1</div>
                        <h3 class="font-heading font-bold text-sm uppercase tracking-wider text-slate-800">Identitas Pemohon / Alumni</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4.5">
                        <!-- Nama Pemohon -->
                        <div class="space-y-1.5 sm:col-span-2">
                            <label for="nama_pemohon" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Nama Lengkap Pemohon (Sesuai Ijazah) <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="nama_pemohon" 
                                id="nama_pemohon" 
                                value="{{ old('nama_pemohon', $user->name ?? '') }}"
                                required 
                                placeholder="Contoh: Ridwan Kurniawan"
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            >
                            @error('nama_pemohon')
                                <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- NISN -->
                        <div class="space-y-1.5">
                            <label for="nisn" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Nomor Induk Siswa Nasional (NISN) <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="nisn" 
                                id="nisn" 
                                value="{{ old('nisn', $user->nip_nisn ?? '') }}"
                                required 
                                placeholder="Contoh: 0012345678"
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all font-mono"
                            >
                            @error('nisn')
                                <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tahun Lulus -->
                        <div class="space-y-1.5">
                            <label for="tahun_lulus" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Tahun Kelulusan <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="tahun_lulus" 
                                id="tahun_lulus" 
                                value="{{ old('tahun_lulus', '2024') }}"
                                required 
                                placeholder="Contoh: 2024"
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all font-mono"
                            >
                            @error('tahun_lulus')
                                <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nomor WhatsApp -->
                        <div class="space-y-1.5">
                            <label for="nomor_whatsapp" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="nomor_whatsapp" 
                                id="nomor_whatsapp" 
                                value="{{ old('nomor_whatsapp', $user->phone_number ?? '') }}"
                                required 
                                placeholder="Contoh: 081234567890"
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all font-mono"
                            >
                            <p class="text-[10px] text-slate-400">Digunakan untuk informasi kesiapan pengambilan dokumen fisik.</p>
                            @error('nomor_whatsapp')
                                <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-1.5">
                            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Alamat Email Aktif <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email', $user->email ?? '') }}"
                                required 
                                placeholder="Contoh: alumni@gmail.com"
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            >
                            @error('email')
                                <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Detail Legalisir Dokumen -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-100">
                        <div class="w-7 h-7 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center font-bold text-xs ring-1 ring-teal-200">2</div>
                        <h3 class="font-heading font-bold text-sm uppercase tracking-wider text-slate-800">Dokumen & Keperluan Pengajuan</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4.5">
                        <!-- Jenis Dokumen -->
                        <div class="space-y-1.5">
                            <label for="jenis_dokumen" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Jenis Dokumen yang Dilegalisir <span class="text-rose-500">*</span>
                            </label>
                            <select 
                                name="jenis_dokumen" 
                                id="jenis_dokumen" 
                                required 
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all font-semibold"
                            >
                                <option value="ijazah" {{ old('jenis_dokumen') === 'ijazah' ? 'selected' : '' }}>Ijazah Asli / Salinan Resmi</option>
                                <option value="transkrip_nilai" {{ old('jenis_dokumen') === 'transkrip_nilai' ? 'selected' : '' }}>Transkrip Nilai / SKHUN</option>
                                <option value="rapor" {{ old('jenis_dokumen') === 'rapor' ? 'selected' : '' }}>Buku Rapor Lengkap</option>
                                <option value="sertifikat_keahlian" {{ old('jenis_dokumen') === 'sertifikat_keahlian' ? 'selected' : '' }}>Sertifikat Uji Kompetensi Keahlian (UKK)</option>
                            </select>
                            @error('jenis_dokumen')
                                <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jumlah Lembar -->
                        <div class="space-y-1.5">
                            <label for="jumlah_lembar" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Jumlah Lembar Pengesahan (1 - 10 Lembar) <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="jumlah_lembar" 
                                id="jumlah_lembar" 
                                min="1" 
                                max="10" 
                                value="{{ old('jumlah_lembar', 3) }}"
                                required 
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all font-semibold"
                            >
                            @error('jumlah_lembar')
                                <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keperluan -->
                        <div class="space-y-1.5 sm:col-span-2">
                            <label for="keperluan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Keperluan Legalisir <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="keperluan" 
                                id="keperluan" 
                                value="{{ old('keperluan') }}"
                                required 
                                placeholder="Contoh: Pendaftaran Seleksi CASN / BUMN / Melamar Pekerjaan / Melanjutkan Pendidikan S1"
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                            >
                            @error('keperluan')
                                <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Unggah Berkas Scan Asli -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5 pb-2.5 border-b border-slate-100">
                        <div class="w-7 h-7 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs ring-1 ring-emerald-200">3</div>
                        <h3 class="font-heading font-bold text-sm uppercase tracking-wider text-slate-800">Unggah Berkas Pindaian (Scan) Dokumen Asli</h3>
                    </div>

                    <div class="space-y-2">
                        <div 
                            id="dropzone"
                            class="border-2 border-dashed border-slate-300 hover:border-teal-500 rounded-2xl p-6 sm:p-8 text-center bg-slate-50/50 hover:bg-teal-50/20 transition-all cursor-pointer relative group"
                            onclick="document.getElementById('berkas').click()"
                        >
                            <input 
                                type="file" 
                                name="berkas" 
                                id="berkas" 
                                accept=".pdf,.jpg,.jpeg,.png"
                                required 
                                class="hidden"
                                onchange="handleFileSelected(this)"
                            >

                            <div class="space-y-2.5" id="dropzoneContent">
                                <div class="w-12 h-12 rounded-2xl bg-teal-50 group-hover:bg-teal-100 text-teal-700 flex items-center justify-center mx-auto transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                </div>
                                <div class="text-xs text-slate-600">
                                    <span class="font-bold text-teal-800 hover:underline">Pilih berkas dokumen</span> atau tarik dan lepas ke kotak ini
                                </div>
                                <p class="text-[11px] text-slate-400">
                                    Format didukung: <strong>PDF, JPG, PNG</strong> (Ukuran berkas maksimal <strong>5 MB</strong>)
                                </p>
                            </div>

                            <div id="fileInfo" class="hidden text-left bg-white p-4 rounded-xl border border-slate-200 mt-2 shadow-xs">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3 truncate">
                                        <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                        </div>
                                        <div class="truncate">
                                            <p id="fileName" class="text-xs font-bold text-slate-800 truncate"></p>
                                            <p id="fileSize" class="text-[10px] text-slate-400 font-mono"></p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">Berkas Terpilih</span>
                                </div>
                            </div>
                        </div>
                        @error('berkas')
                            <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Terms & Notice -->
                <div class="p-4.5 rounded-2xl bg-amber-50/80 border border-amber-200/90 text-xs text-amber-950 space-y-1.5">
                    <p class="font-bold flex items-center gap-2 text-amber-900">
                        <svg class="w-4 h-4 text-amber-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Ketentuan Layanan Legalisir SMKN 1 Subang:</span>
                    </p>
                    <ul class="list-disc list-inside space-y-1 text-amber-800 text-[11px] pl-1">
                        <li>Pastikan pindaian dokumen asli tidak buram, teks terbaca jelas, dan nomor seri ijazah terlihat utuh.</li>
                        <li>Petugas TU akan memeriksa kesesuaian dokumen dengan Buku Induk Kearsipan Sekolah.</li>
                        <li>Setelah permohonan disetujui, Anda dapat memantau status secara langsung melalui kode resi pelacakan.</li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('landing') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Batalkan & Kembali ke Beranda</span>
                    </a>

                    <button 
                        type="submit" 
                        class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-blue-950 to-indigo-900 hover:from-blue-900 hover:to-indigo-800 text-white font-heading font-extrabold text-xs sm:text-sm rounded-xl shadow-lg shadow-blue-950/20 transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-98"
                    >
                        <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <span>Kirim Permohonan Legalisir Sekarang</span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer Resmi (Identik dengan Landing Page) -->
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
                        <a href="{{ route('landing') }}" class="hover:text-teal-300 transition-colors">Beranda</a>
                        <a href="{{ route('legalisir.tracking') }}" class="hover:text-teal-300 transition-colors">Lacak</a>
                        <a href="{{ route('landing') }}#alur" class="hover:text-teal-300 transition-colors">Alur</a>
                        <a href="{{ route('landing') }}#tentang" class="hover:text-teal-300 transition-colors">Tentang Sistem</a>
                        <a href="{{ route('landing') }}#faq" class="hover:text-teal-300 transition-colors">Tanya Jawab</a>
                        <a href="{{ route('landing') }}#kontak" class="hover:text-teal-300 transition-colors">Kontak TU</a>
                    </nav>
                    <div class="text-slate-500 text-[11px]">&copy; {{ date('Y') }} SMKN 1 Subang. Dikembangkan berdasarkan Tata Kelola Kearsipan Pendidikan Jawa Barat.</div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function handleFileSelected(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.size > 5242880) {
                    showAlertModal('Ukuran Berkas Melebihi Batas', 'Ukuran berkas melebihi batas maksimal 5 MB. Harap kompres berkas Anda terlebih dahulu.', 'warning');
                    input.value = '';
                    return;
                }
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('fileSize').textContent = (file.size / 1024).toFixed(2) + ' KB';
                document.getElementById('fileInfo').classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
