<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Permohonan Terkirim - {{ $pengajuan->nomor_pengajuan }} | SMKN 1 Subang</title>
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

    <!-- Header & Navigasi -->
    <header class="bg-white/85 backdrop-blur-xl border-b border-slate-200/80 sticky top-0 z-40 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <a href="{{ route('landing') }}" class="flex items-center gap-3.5 group">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-9 h-11 sm:w-11 sm:h-13 object-contain shrink-0 group-hover:scale-105 transition-transform duration-300 filter drop-shadow-sm">
                    <div class="leading-tight">
                        <div class="flex items-center gap-2">
                            <span class="font-heading font-extrabold text-lg sm:text-xl text-blue-950 tracking-tight">SMEA ARCHIVE</span>
                            <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-md bg-blue-100 text-blue-900 border border-blue-200">PK</span>
                        </div>
                        <p class="text-[11px] sm:text-xs font-semibold text-slate-600">SMK Negeri 1 Subang</p>
                    </div>
                </a>

                <div class="flex items-center gap-3">
                    <a href="{{ route('landing') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors">
                        Beranda Publik
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl w-full bg-white/95 backdrop-blur-xl rounded-3xl border border-slate-200/90 shadow-2xl overflow-hidden p-6 sm:p-10 text-center space-y-6">

            <!-- School Logo -->
            <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-14 h-16 mx-auto object-contain drop-shadow-xs">

            <!-- Success Animated Icon -->
            <div class="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-600 border border-emerald-200/60 flex items-center justify-center mx-auto shadow-md shadow-emerald-500/10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>

            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                    Permohonan Berhasil Terkirim
                </span>
                <h1 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900 mt-2">
                    Terima Kasih, {{ $pengajuan->nama_pemohon }}!
                </h1>
                <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                    Pengajuan legalisir dokumen Anda telah diterima oleh sistem kearsipan SMKN 1 Subang dan sedang dalam antrean verifikasi petugas Tata Usaha.
                </p>
            </div>

            <!-- Nomor Resi Card (Prominent Navy Glow) -->
            <div class="p-5 rounded-2xl bg-gradient-to-br from-slate-950 via-[#0B1528] to-[#0A192F] text-white shadow-xl space-y-2 border border-slate-800">
                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Kode Resi Pelacakan Anda</span>
                <div class="flex items-center justify-center gap-3">
                    <span id="resiCode" class="font-mono font-black text-xl sm:text-2xl tracking-wider text-teal-300">
                        {{ $pengajuan->nomor_pengajuan }}
                    </span>
                    <button 
                        type="button" 
                        onclick="copyResi()" 
                        class="p-2 rounded-xl bg-white/10 hover:bg-white/20 text-white transition-colors cursor-pointer"
                        title="Salin Kode Resi"
                    >
                        <svg id="copyIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span id="copiedToast" class="hidden text-[10px] font-bold text-emerald-300">Tersalin!</span>
                    </button>
                </div>
                <p class="text-[11px] text-slate-300">
                    Simpan nomor resi ini untuk melacak status dokumen Anda secara berkala.
                </p>
            </div>

            <!-- Ringkasan Data -->
            <div class="bg-slate-50/90 rounded-2xl p-4.5 border border-slate-200/80 text-left text-xs space-y-2">
                <div class="flex justify-between py-1 border-b border-slate-200/60">
                    <span class="text-slate-500">Jenis Dokumen:</span>
                    <span class="font-bold text-slate-800">{{ $pengajuan->jenis_dokumen_label }}</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-200/60">
                    <span class="text-slate-500">Jumlah Lembar:</span>
                    <span class="font-semibold text-slate-800">{{ $pengajuan->jumlah_lembar }} Lembar</span>
                </div>
                <div class="flex justify-between py-1 border-b border-slate-200/60">
                    <span class="text-slate-500">NISN / Tahun Lulus:</span>
                    <span class="font-mono text-slate-800">{{ $pengajuan->nisn }} (Lulus {{ $pengajuan->tahun_lulus }})</span>
                </div>
                <div class="flex justify-between py-1">
                    <span class="text-slate-500">Status Saat Ini:</span>
                    <x-status-badge :status="$pengajuan->status" />
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2.5 pt-2">
                <a 
                    href="{{ route('legalisir.tracking', ['nomor_pengajuan' => $pengajuan->nomor_pengajuan]) }}" 
                    class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-blue-950 to-indigo-900 hover:from-blue-900 hover:to-indigo-800 text-white font-bold text-xs shadow-lg shadow-blue-950/20 transition-all flex items-center justify-center gap-2 cursor-pointer"
                >
                    <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Lacak Status Permohonan (Live Tracking)</span>
                </a>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                    <a 
                        href="{{ route('legalisir.tanda-terima', $pengajuan->nomor_pengajuan) }}" 
                        target="_blank" 
                        class="py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors flex items-center justify-center gap-1.5"
                    >
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak Tanda Terima</span>
                    </a>

                    <a 
                        href="{{ route('landing') }}" 
                        class="py-2.5 px-4 rounded-xl bg-white hover:bg-slate-50 text-slate-600 font-semibold text-xs border border-slate-200 transition-colors flex items-center justify-center"
                    >
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

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
                        <a href="{{ route('landing') }}#faq" class="hover:text-teal-300 transition-colors">Tanya Jawab</a>
                        <a href="{{ route('landing') }}#kontak" class="hover:text-teal-300 transition-colors">Kontak TU</a>
                    </nav>
                    <div class="text-slate-500 text-[11px]">&copy; {{ date('Y') }} SMKN 1 Subang. Dikembangkan berdasarkan Tata Kelola Kearsipan Pendidikan Jawa Barat.</div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function copyResi() {
            const resi = document.getElementById('resiCode').textContent.trim();
            navigator.clipboard.writeText(resi).then(() => {
                document.getElementById('copyIcon').classList.add('hidden');
                document.getElementById('copiedToast').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('copyIcon').classList.remove('hidden');
                    document.getElementById('copiedToast').classList.add('hidden');
                }, 2000);
            });
        }
    </script>
</body>
</html>
