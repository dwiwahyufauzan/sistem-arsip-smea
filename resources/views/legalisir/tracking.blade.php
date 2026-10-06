<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pelacakan Status Legalisir Dokumen | SMKN 1 Subang</title>
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

                <nav class="hidden md:flex items-center gap-1 text-xs font-semibold text-slate-600">
                    <a href="{{ route('landing') }}" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Beranda</a>
                    <a href="{{ route('legalisir.create') }}" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Ajukan Legalisir</a>
                    <a href="{{ route('landing') }}#alur" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Alur Pelayanan</a>
                    <a href="{{ route('landing') }}#faq" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors">Tanya Jawab</a>
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('legalisir.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:text-blue-950 hover:bg-slate-100 rounded-xl transition-colors">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Ajukan Baru</span>
                    </a>

                    @auth
                        @if(auth()->user()->role === 'pemohon')
                            <a href="{{ route('pemohon.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white rounded-xl text-xs font-bold shadow-xs transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span>Dashboard Alumni</span>
                            </a>
                        @elseif(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white rounded-xl text-xs font-bold shadow-xs transition-colors">
                                <span>Panel TU</span>
                            </a>
                        @elseif(auth()->user()->role === 'kepala_sekolah')
                            <a href="{{ route('kepsek.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-700 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold shadow-xs transition-colors">
                                <span>Panel Kepsek</span>
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

    <!-- Main Content Area -->
    <main class="flex-1 py-10 px-4 sm:px-6 lg:px-8 bg-slate-50">
        <div class="max-w-4xl mx-auto space-y-8">
            
            <!-- Header & Search Box -->
            <div class="text-center space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-200 text-blue-800 text-xs font-semibold">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span>Live Tracking Layanan Legalisir Dokumen</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-slate-900 tracking-tight">
                    Lacak Status Permohonan Legalisir
                </h1>
                <p class="text-sm text-slate-600 max-w-xl mx-auto">
                    Masukkan <span class="font-semibold text-slate-800">Nomor Resi Pengajuan (LEG-YYYYMM-XXXX)</span> atau <span class="font-semibold text-slate-800">NISN</span> Anda untuk memantau kemajuan berkas secara transparan.
                </p>
            </div>

            <!-- Search Bar Card -->
            <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-200">
                <form id="tracking-page-form" action="{{ route('legalisir.tracking') }}" method="GET" class="flex flex-col sm:flex-row gap-3" onsubmit="if (!this.nomor_pengajuan.value.trim()) { event.preventDefault(); showAlertModal('Nomor Resi / NISN Belum Diisi', 'Silakan ketikkan nomor resi pengajuan legalisir Anda (contoh: LEG-202609-0001) atau 10 digit NISN sebelum melakukan pelacakan status berkas.', 'warning'); this.nomor_pengajuan.focus(); return false; }">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="nomor_pengajuan" 
                            value="{{ old('nomor_pengajuan', $query ?? '') }}" 
                            placeholder="Contoh: LEG-202609-0001 atau NISN 0041234567"
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition-all uppercase tracking-wider font-mono"
                        >
                    </div>
                    <button 
                        type="submit" 
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-700 hover:bg-blue-600 text-white text-sm font-bold rounded-xl shadow-sm transition-colors cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span>Lacak Sekarang</span>
                    </button>
                </form>
            </div>

            @if($searchPerformed)
                @if($pengajuan)
                    <!-- Tracking Result Section -->
                    <div class="space-y-6 animate-in fade-in duration-300">
                        
                        <!-- Resi & Status Overview Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-900 via-slate-900 to-indigo-950 p-6 text-white">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div>
                                        <span class="text-xs uppercase tracking-widest font-semibold text-blue-300">Nomor Resi Resmi</span>
                                        <div class="flex items-center gap-3 mt-1">
                                            <h2 class="text-2xl font-black font-mono tracking-wider text-white">
                                                {{ $pengajuan->nomor_pengajuan }}
                                            </h2>
                                            <button 
                                                onclick="navigator.clipboard.writeText('{{ $pengajuan->nomor_pengajuan }}'); showAlertModal('Resi Berhasil Disalin', 'Nomor resi {{ $pengajuan->nomor_pengajuan }} telah disalin ke clipboard Anda.', 'success');" 
                                                class="p-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-white/80 hover:text-white transition-colors cursor-pointer" 
                                                title="Salin nomor resi"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-xs text-slate-300 mt-1">
                                            Diajukan pada: {{ $pengajuan->created_at->translatedFormat('d F Y, H:i') }} WIB
                                        </p>
                                    </div>
                                    <div class="flex flex-col sm:flex-row items-start md:items-end gap-2">
                                        <x-status-badge :status="$pengajuan->status" type="legalisir" class="text-sm px-3.5 py-1" />
                                    </div>
                                </div>
                            </div>

                            <!-- Applicant & Document Information Grid -->
                            <div class="p-6 border-b border-slate-100 bg-slate-50/50 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                                <div>
                                    <span class="text-slate-500 font-medium block">Nama Pemohon</span>
                                    <span class="font-bold text-slate-900 text-sm mt-0.5 block">{{ $pengajuan->nama_pemohon }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 font-medium block">NISN / Tahun Lulus</span>
                                    <span class="font-bold text-slate-900 text-sm mt-0.5 block font-mono">{{ $pengajuan->nisn }} ({{ $pengajuan->tahun_lulus }})</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 font-medium block">Dokumen & Jumlah</span>
                                    <span class="font-bold text-slate-900 text-sm mt-0.5 block">{{ $pengajuan->jenis_dokumen_label }} ({{ $pengajuan->jumlah_lembar }} Lembar)</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 font-medium block">Estimasi / Siap Ambil</span>
                                    <span class="font-bold text-emerald-700 text-sm mt-0.5 block">
                                        {{ $pengajuan->tanggal_siap_ambil ? $pengajuan->tanggal_siap_ambil->translatedFormat('d F Y') : 'Menunggu Jadwal TU' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Rejection Notice Banner (if rejected) -->
                            @if($pengajuan->status === 'ditolak')
                                <div class="m-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start gap-3">
                                    <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <div>
                                        <h4 class="font-bold text-sm">Permohonan Legalisir Ditolak</h4>
                                        <p class="text-xs mt-1 text-rose-700">
                                            {{ $pengajuan->catatan_petugas ?? $pengajuan->catatan_kepsek ?? 'Berkas tidak sesuai atau data kearsipan kelulusan belum lengkap. Silakan ajukan ulang dengan berkas yang sesuai.' }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Ready For Pickup Banner (if siap_diambil) -->
                            @if($pengajuan->status === 'siap_diambil')
                                <div class="m-6 p-4 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-900 flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div class="space-y-1">
                                        <h4 class="font-bold text-sm text-emerald-900">Dokumen Fisik Legalisir Telah Siap Diambil!</h4>
                                        <p class="text-xs text-emerald-800 leading-relaxed">
                                            Silakan datang ke <strong>Loket Pelayanan Tata Usaha SMKN 1 Subang</strong> pada jam kerja (Senin - Jumat, 08.00 - 15.00 WIB) dengan membawa bukti resi ini dan kartu identitas diri asli.
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Visual Stepper Progress Bar (6 Stages) -->
                            <div class="p-6">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-6">Kemajuan Proses Legalisir</h3>
                                
                                @php
                                    $statusRank = [
                                        'menunggu_verifikasi' => 1,
                                        'diverifikasi' => 2,
                                        'menunggu_approval_kepsek' => 2,
                                        'disetujui_kepsek' => 3,
                                        'sedang_diproses' => 4,
                                        'siap_diambil' => 5,
                                        'selesai' => 6,
                                        'ditolak' => -1,
                                    ];
                                    $currentRank = $statusRank[$pengajuan->status] ?? 1;

                                    $steps = [
                                        1 => ['title' => 'Pengajuan', 'desc' => 'Diterima sistem'],
                                        2 => ['title' => 'Verifikasi TU', 'desc' => 'Cek buku induk'],
                                        3 => ['title' => 'Pengesahan', 'desc' => 'Otorisasi Kepsek'],
                                        4 => ['title' => 'Proses Cetak', 'desc' => 'Stempel basah'],
                                        5 => ['title' => 'Siap Diambil', 'desc' => 'Di loket SMEA'],
                                        6 => ['title' => 'Selesai', 'desc' => 'Telah diserahkan'],
                                    ];
                                @endphp

                                <div class="relative">
                                    <div class="hidden md:block absolute top-5 left-6 right-6 h-1 bg-slate-200 -z-0">
                                        @php
                                            $percent = $currentRank > 0 ? min(100, max(0, ($currentRank - 1) * 20)) : 0;
                                        @endphp
                                        <div class="h-1 bg-blue-600 transition-all duration-500" style="width: {{ $percent }}%;"></div>
                                    </div>

                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 relative z-10">
                                        @foreach($steps as $idx => $step)
                                            @php
                                                $isPast = $currentRank > $idx;
                                                $isCurrent = $currentRank === $idx;
                                                $isUpcoming = $currentRank < $idx;
                                            @endphp
                                            <div class="flex flex-col items-center text-center">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs transition-all shadow-xs
                                                    {{ $isPast ? 'bg-blue-600 text-white' : '' }}
                                                    {{ $isCurrent ? 'bg-blue-700 text-white ring-4 ring-blue-100 ring-offset-2 scale-110' : '' }}
                                                    {{ $isUpcoming ? 'bg-white text-slate-400 border-2 border-slate-300' : '' }}
                                                    {{ $pengajuan->status === 'ditolak' && $idx === 2 ? 'bg-rose-600 text-white ring-4 ring-rose-100' : '' }}
                                                ">
                                                    @if($isPast)
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    @elseif($pengajuan->status === 'ditolak' && $idx === 2)
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    @else
                                                        {{ $idx }}
                                                    @endif
                                                </div>
                                                <h4 class="mt-3 text-xs font-bold {{ $isCurrent ? 'text-blue-900' : ($isPast ? 'text-slate-800' : 'text-slate-400') }}">
                                                    {{ $step['title'] }}
                                                </h4>
                                                <p class="text-[11px] text-slate-500 mt-0.5 leading-tight">
                                                    {{ $step['desc'] }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="p-6 bg-slate-50 border-t border-slate-200 flex flex-wrap items-center justify-between gap-3">
                                <div class="flex flex-wrap gap-2">
                                    <a 
                                        href="{{ route('legalisir.tanda-terima', $pengajuan->nomor_pengajuan) }}" 
                                        target="_blank" 
                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-800 text-xs font-bold rounded-xl shadow-xs transition-colors"
                                    >
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                        </svg>
                                        <span>Cetak Tanda Terima</span>
                                    </a>

                                    <a 
                                        href="{{ $signedDownloadUrl ?? route('legalisir.download', $pengajuan->id) }}" 
                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-800 text-xs font-bold rounded-xl shadow-xs transition-colors"
                                    >
                                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        <span>Unduh Berkas Scan</span>
                                    </a>
                                </div>

                                <a 
                                    href="{{ route('legalisir.create') }}" 
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-700 hover:bg-blue-600 text-white text-xs font-bold rounded-xl shadow-xs transition-colors"
                                >
                                    <span>Ajukan Permohonan Baru &rarr;</span>
                                </a>
                            </div>
                        </div>

                        <!-- Audit Trail / Timeline Riwayat -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                            <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Kronologi Status Berkas</span>
                            </h3>

                            <div class="flow-root">
                                <ul role="list" class="-mb-8">
                                    @forelse($pengajuan->riwayat as $idx => $hist)
                                        <li>
                                            <div class="relative pb-8">
                                                @if(!$loop->last)
                                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center ring-8 ring-white">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <div class="flex items-center gap-2">
                                                                <x-status-badge :status="$hist->status_baru" type="legalisir" />
                                                                <span class="text-xs text-slate-500 font-medium">oleh {{ $hist->user->name ?? 'Sistem' }}</span>
                                                            </div>
                                                            <p class="text-xs text-slate-700 mt-1.5 leading-relaxed bg-slate-50 p-2.5 rounded-lg border border-slate-200/60">
                                                                {{ $hist->catatan }}
                                                            </p>
                                                        </div>
                                                        <div class="text-right text-xs whitespace-nowrap text-slate-400">
                                                            <time datetime="{{ $hist->created_at }}">{{ $hist->created_at->translatedFormat('d M Y, H:i') }} WIB</time>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="text-xs text-slate-500 py-3">Belum ada riwayat aktivitas pada berkas ini.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- No Result State -->
                    <div class="bg-white rounded-2xl p-10 text-center shadow-sm border border-slate-200 animate-in fade-in duration-300">
                        <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Permohonan Tidak Ditemukan</h3>
                        <p class="text-xs text-slate-600 max-w-md mx-auto mt-1">
                            Tidak ada permohonan legalisir dengan nomor resi atau NISN <span class="font-mono font-semibold text-slate-800">"{{ $query }}"</span>. Pastikan nomor yang dimasukkan sudah tepat.
                        </p>
                        <div class="mt-6 flex justify-center gap-3">
                            <a href="{{ route('legalisir.tracking') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors">
                                Coba Lacak Ulang
                            </a>
                            <a href="{{ route('legalisir.create') }}" class="px-4 py-2 bg-blue-700 hover:bg-blue-600 text-white text-xs font-semibold rounded-xl transition-colors">
                                Ajukan Permohonan Baru
                            </a>
                        </div>
                    </div>
                @endif
            @endif

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

</body>
</html>
