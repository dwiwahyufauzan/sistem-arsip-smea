<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Formulir Permohonan Legalisir Online | SMKN 1 Subang</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-heading { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="min-h-full flex flex-col text-slate-800 antialiased selection:bg-blue-600 selection:text-white">

    <x-toast />

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 shadow-2xs">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-blue-900 via-blue-800 to-teal-700 flex items-center justify-center text-white shadow-md shadow-blue-900/20 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <span class="font-heading font-extrabold text-base sm:text-lg text-slate-900 block leading-tight">SMKN 1 SUBANG</span>
                    <span class="text-xs text-blue-700 font-semibold tracking-wide">Layanan Legalisir Dokumen Online</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('legalisir.tracking') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-blue-700 hover:bg-slate-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Lacak Resi</span>
                </a>

                @auth
                    <a href="{{ route('pemohon.dashboard') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-semibold transition-colors">
                        Dashboard Saya
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-xl text-xs font-bold shadow-xs transition-colors">
                        Masuk Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Title -->
    <div class="bg-gradient-to-b from-blue-900 via-blue-950 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
        <div class="max-w-4xl mx-auto text-center relative z-10 space-y-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-teal-500/20 text-teal-300 border border-teal-500/30">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Pelayanan Cepat & Transparan</span>
            </span>
            <h1 class="font-heading font-extrabold text-2xl sm:text-4xl tracking-tight text-white">
                Permohonan Legalisir Dokumen Online
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 max-w-2xl mx-auto leading-relaxed">
                Pengajuan legalisir Ijazah, Transkrip Nilai, Rapor, dan Sertifikat UKK resmi SMKN 1 Subang (SMEA) tanpa antre panjang di sekolah.
            </p>
        </div>
    </div>

    <!-- Main Content Form -->
    <main class="flex-grow max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 -mt-6 relative z-20 mb-16">
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl overflow-hidden">

            <!-- Card Header -->
            <div class="px-6 sm:px-8 py-5 bg-slate-50 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h2 class="font-heading font-bold text-base text-slate-900">Formulir Data Permohonan</h2>
                    <p class="text-xs text-slate-500">Lengkapi identitas diri dan unggah berkas pindaian dokumen asli</p>
                </div>
                <span class="text-xs font-medium text-slate-400">Tahap 1 dari 1</span>
            </div>

            <!-- Form -->
            <form action="{{ route('legalisir.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
                @csrf

                <!-- Section 1: Identitas Pemohon -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs">1</div>
                        <h3 class="font-bold text-xs uppercase tracking-wider text-slate-800">Identitas Pemohon / Alumni</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all"
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
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all font-mono"
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
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all font-mono"
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
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all font-mono"
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
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all"
                            >
                            @error('email')
                                <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Detail Legalisir Dokumen -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-xs">2</div>
                        <h3 class="font-bold text-xs uppercase tracking-wider text-slate-800">Dokumen & Keperluan Pengajuan</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Jenis Dokumen -->
                        <div class="space-y-1.5">
                            <label for="jenis_dokumen" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                Jenis Dokumen yang Dilegalisir <span class="text-rose-500">*</span>
                            </label>
                            <select 
                                name="jenis_dokumen" 
                                id="jenis_dokumen" 
                                required 
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all font-semibold"
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
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all font-semibold"
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
                                class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all"
                            >
                            @error('keperluan')
                                <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Unggah Berkas Scan Asli -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs">3</div>
                        <h3 class="font-bold text-xs uppercase tracking-wider text-slate-800">Unggah Berkas Pindaian (Scan) Dokumen Asli</h3>
                    </div>

                    <div class="space-y-2">
                        <div 
                            id="dropzone"
                            class="border-2 border-dashed border-slate-300 hover:border-blue-500 rounded-2xl p-6 sm:p-8 text-center bg-slate-50/50 hover:bg-blue-50/30 transition-all cursor-pointer relative"
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

                            <div class="space-y-2" id="dropzoneContent">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                </div>
                                <div class="text-xs text-slate-600">
                                    <span class="font-bold text-blue-700 hover:underline">Pilih berkas dokumen</span> atau tarik dan lepas ke kotak ini
                                </div>
                                <p class="text-[11px] text-slate-400">
                                    Format didukung: <strong>PDF, JPG, PNG</strong> (Ukuran berkas maksimal <strong>5 MB</strong>)
                                </p>
                            </div>

                            <div id="fileInfo" class="hidden text-left bg-white p-4 rounded-xl border border-slate-200 mt-2">
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
                                    <span class="text-xs text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded">Berkas Terpilih</span>
                                </div>
                            </div>
                        </div>
                        @error('berkas')
                            <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Terms & Notice -->
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200/80 text-xs text-amber-900 space-y-1">
                    <p class="font-bold flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Ketentuan Layanan Legalisir SMKN 1 Subang:</span>
                    </p>
                    <ul class="list-disc list-inside space-y-0.5 text-amber-800 text-[11px] pl-1">
                        <li>Pastikan pindaian dokumen asli tidak buram, teks terbaca jelas, dan nomor seri ijazah terlihat utuh.</li>
                        <li>Petugas TU akan memeriksa kesesuaian dokumen dengan Buku Induk Kearsipan Sekolah.</li>
                        <li>Setelah permohonan disetujui, Anda dapat memantau status secara langsung melalui kode resi pelacakan.</li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('landing') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition-colors">
                        &larr; Batalkan & Kembali ke Beranda
                    </a>

                    <button 
                        type="submit" 
                        class="w-full sm:w-auto px-8 py-3.5 bg-blue-700 hover:bg-blue-800 text-white font-heading font-extrabold text-xs sm:text-sm rounded-xl shadow-lg shadow-blue-700/20 transition-all flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <span>Kirim Permohonan Legalisir Sekarang</span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 text-slate-500 text-xs py-6 mt-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} SMKN 1 Subang — SMEA. Sistem Informasi Pengarsipan & Layanan Dokumen Resmi.</p>
        </div>
    </footer>

    <script>
        function handleFileSelected(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                if (file.size > 5242880) {
                    alert('Ukuran berkas melebihi 5 MB. Harap kompres berkas Anda terlebih dahulu.');
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
