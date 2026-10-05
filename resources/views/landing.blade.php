<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Arsip & Layanan Legalisir Dokumen | SMKN 1 Subang</title>

    <link rel="shortcut icon" href="{{ asset('images/logo-smk.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen selection:bg-teal-600 selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-teal-500/20 text-teal-300 border border-teal-500/30">
                    RESMI
                </span>
                <span>Pemerintah Daerah Provinsi Jawa Barat — Dinas Pendidikan Cabang Wilayah IV</span>
            </div>
            <div class="flex items-center gap-4 text-slate-400">
                <span>🕒 Pelayanan TU: Senin - Jumat (07.30 - 15.30 WIB)</span>
                <span class="hidden md:inline">|</span>
                <span class="hidden md:inline">📞 (0260) 411410</span>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo & School Identity -->
                <a href="{{ route('landing') }}" class="flex items-center gap-3.5 group">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-11 h-13 object-contain shrink-0 group-hover:scale-105 transition-transform duration-200">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-heading font-extrabold text-xl text-blue-950 tracking-tight">SMEA ARCHIVE</span>
                            <span class="px-1.5 py-0.5 text-[10px] font-bold uppercase rounded bg-blue-100 text-blue-800">PK</span>
                        </div>
                        <p class="text-xs font-medium text-slate-500">SMK Negeri 1 Subang</p>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                    <a href="#beranda" class="hover:text-blue-900 transition-colors">Beranda</a>
                    <a href="#lacak" class="hover:text-blue-900 transition-colors flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                        Lacak Legalisir
                    </a>
                    <a href="#alur" class="hover:text-blue-900 transition-colors">Alur Pelayanan</a>
                    <a href="#tentang" class="hover:text-blue-900 transition-colors">Tentang Sistem</a>
                    <a href="#kontak" class="hover:text-blue-900 transition-colors">Kontak TU</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-900 rounded-lg hover:bg-blue-800 shadow-sm transition-all">
                                <span>Dashboard Admin TU</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @elseif(Auth::user()->isKepalaSekolah())
                            <a href="{{ route('kepsek.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-emerald-800 rounded-lg hover:bg-emerald-700 shadow-sm transition-all">
                                <span>Portal Kepala Sekolah</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @else
                            <a href="{{ route('pemohon.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-teal-700 rounded-lg hover:bg-teal-600 shadow-sm transition-all">
                                <span>Dashboard Pemohon</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-slate-700 hover:text-blue-950 transition-colors">
                            Masuk Portal
                        </a>
                        <a href="{{ route('legalisir.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-900 rounded-lg hover:bg-blue-800 shadow-sm shadow-blue-900/10 transition-all hover:shadow-md">
                            <span>Ajukan Legalisir</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
        <!-- Hero Section -->
        <section id="beranda" class="relative overflow-hidden bg-gradient-to-b from-blue-950 via-blue-900 to-slate-900 text-white pt-16 pb-24 lg:pt-20 lg:pb-32">
            <!-- Decorative background accents -->
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:24px_24px]"></div>
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-teal-300 text-xs font-semibold mb-6">
                        <span class="w-2 h-2 rounded-full bg-teal-400 animate-ping"></span>
                        Portal Kearsipan & Legalisir Digital SMEA
                    </div>
                    <h1 class="font-heading font-extrabold text-3xl sm:text-5xl lg:text-6xl tracking-tight leading-tight sm:leading-tight mb-6">
                        Tata Kelola Arsip Modern & Layanan Legalisir Online
                    </h1>
                    <p class="text-base sm:text-lg text-slate-300 mb-8 leading-relaxed">
                        Sistem manajemen arsip persuratan dan verifikasi legalisir dokumen resmi SMKN 1 Subang berbasis web dengan pencarian presisi menggunakan Algoritma Knuth-Morris-Pratt (KMP).
                    </p>

                    <!-- CTA Actions -->
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <a href="#lacak" class="inline-flex items-center gap-2 px-6 py-3.5 text-sm font-bold text-slate-900 bg-teal-400 hover:bg-teal-300 rounded-xl shadow-lg shadow-teal-500/20 transition-all hover:scale-102">
                            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span>Lacak Permohonan Legalisir</span>
                        </a>
                        <a href="{{ route('legalisir.create') }}" class="inline-flex items-center gap-2 px-6 py-3.5 text-sm font-semibold text-white bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl backdrop-blur-md transition-all">
                            <span>Ajukan Legalisir Mandiri</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Fast Tracking Card in Hero -->
                <div id="lacak" class="mt-14 max-w-2xl mx-auto">
                    <div class="bg-white/95 backdrop-blur-md p-6 sm:p-8 rounded-2xl shadow-2xl border border-white/20 text-slate-800">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-teal-100 text-teal-800 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="font-heading font-bold text-lg text-slate-900">Lacak Status Permohonan Legalisir</h2>
                                <p class="text-xs text-slate-500">Masukkan Nomor Resi Registrasi (cth: <span class="font-mono font-medium text-teal-700">LEG-202609-0001</span>) atau NISN Anda</p>
                            </div>
                        </div>

                        <form action="{{ route('landing') }}#lacak" method="GET" class="flex flex-col sm:flex-row gap-3">
                            <div class="relative flex-grow">
                                <input
                                    type="text"
                                    name="nomor_pengajuan"
                                    value="{{ $query ?? '' }}"
                                    placeholder="Nomor Resi (LEG-...) atau 10 digit NISN..."
                                    required
                                    class="w-full px-4 py-3 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-transparent uppercase placeholder:normal-case font-mono"
                                >
                            </div>
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-bold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-md transition-all shrink-0 cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span>Cek Status</span>
                            </button>
                        </form>

                        <!-- Tracking Result Section -->
                        @if($searchPerformed)
                            <div class="mt-6 pt-6 border-t border-slate-200">
                                @if($pengajuan)
                                    <!-- Result Found -->
                                    <div class="bg-blue-50/70 border border-blue-200/80 rounded-xl p-5 mb-6">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-blue-200/60">
                                            <div>
                                                <span class="text-xs font-semibold text-blue-800 uppercase tracking-wider">Nomor Pengajuan Resi</span>
                                                <h3 class="font-mono text-lg font-extrabold text-blue-950">{{ $pengajuan->nomor_pengajuan }}</h3>
                                            </div>
                                            <div>
                                                @php
                                                    $statusClasses = match($pengajuan->status) {
                                                        'menunggu_verifikasi' => 'bg-amber-100 text-amber-800 border-amber-300',
                                                        'diverifikasi' => 'bg-sky-100 text-sky-800 border-sky-300',
                                                        'menunggu_approval_kepsek' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                                        'disetujui_kepsek' => 'bg-blue-100 text-blue-800 border-blue-300',
                                                        'sedang_diproses' => 'bg-purple-100 text-purple-800 border-purple-300',
                                                        'siap_diambil' => 'bg-emerald-100 text-emerald-800 border-emerald-300 animate-pulse',
                                                        'selesai' => 'bg-slate-100 text-slate-800 border-slate-300',
                                                        'ditolak' => 'bg-rose-100 text-rose-800 border-rose-300',
                                                        default => 'bg-slate-100 text-slate-800 border-slate-300',
                                                    };
                                                @endphp
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $statusClasses }}">
                                                    {{ $pengajuan->status_label }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-700 mt-3">
                                            <div>
                                                <span class="text-slate-500">Nama Pemohon:</span>
                                                <p class="font-semibold text-slate-900">{{ $pengajuan->nama_pemohon }}</p>
                                            </div>
                                            <div>
                                                <span class="text-slate-500">NISN / Tahun Lulus:</span>
                                                <p class="font-semibold text-slate-900">{{ $pengajuan->nisn }} (Lulus {{ $pengajuan->tahun_lulus }})</p>
                                            </div>
                                            <div>
                                                <span class="text-slate-500">Jenis Dokumen:</span>
                                                <p class="font-semibold text-slate-900">{{ $pengajuan->jenis_dokumen_label }} ({{ $pengajuan->jumlah_lembar }} Lembar)</p>
                                            </div>
                                            <div>
                                                <span class="text-slate-500">Tanggal Pengajuan:</span>
                                                <p class="font-semibold text-slate-900">{{ $pengajuan->created_at->format('d M Y, H:i') }} WIB</p>
                                            </div>
                                        </div>

                                        @if($pengajuan->catatan_petugas)
                                            <div class="mt-3 p-3 bg-white rounded-lg border border-blue-200 text-xs">
                                                <span class="font-semibold text-blue-900">Catatan Petugas TU:</span>
                                                <p class="text-slate-700 mt-0.5">{{ $pengajuan->catatan_petugas }}</p>
                                            </div>
                                        @endif

                                        @if($pengajuan->status === 'siap_diambil')
                                            <div class="mt-3 p-3 bg-emerald-50 rounded-lg border border-emerald-300 text-xs text-emerald-900 flex items-start gap-2">
                                                <svg class="w-4 h-4 text-emerald-600 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                <div>
                                                    <strong class="font-semibold">Dokumen Sudah Siap Diambil!</strong>
                                                    <p class="mt-0.5">Silakan datang ke Ruang Tata Usaha SMKN 1 Subang membawa berkas asli/salinan pada jam kerja dengan menunjukkan nomor resi ini.</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Tracking Stepper Timeline -->
                                    <div class="mt-4">
                                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Histori Pelacakan Berkas</h4>
                                        <div class="relative pl-6 space-y-4 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                                            @forelse($pengajuan->riwayat as $history)
                                                <div class="relative">
                                                    <span class="absolute -left-6 top-1.5 w-4 h-4 rounded-full bg-teal-500 ring-4 ring-white border-2 border-teal-600"></span>
                                                    <div class="text-xs">
                                                        <div class="flex items-center gap-2">
                                                            <strong class="font-semibold text-slate-900 uppercase">{{ str_replace('_', ' ', $history->status_baru) }}</strong>
                                                            <span class="text-slate-400">•</span>
                                                            <span class="text-slate-500">{{ $history->created_at->format('d M Y, H:i') }} WIB</span>
                                                        </div>
                                                        <p class="text-slate-600 mt-0.5">{{ $history->catatan ?? 'Perubahan status tercatat oleh sistem.' }}</p>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="relative">
                                                    <span class="absolute -left-6 top-1.5 w-4 h-4 rounded-full bg-blue-500 ring-4 ring-white"></span>
                                                    <div class="text-xs">
                                                        <strong class="font-semibold text-slate-900">Permohonan Terdaftar</strong>
                                                        <p class="text-slate-500 mt-0.5">Berkas masuk antrean verifikasi staf Tata Usaha SMKN 1 Subang.</p>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                @else
                                    <!-- Result Not Found -->
                                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs">
                                        <div class="flex items-start gap-2.5">
                                            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            <div>
                                                <h4 class="font-bold">Data Permohonan Tidak Ditemukan</h4>
                                                <p class="mt-1">Nomor resi atau NISN <span class="font-mono font-bold">"{{ $query }}"</span> tidak terdaftar dalam sistem. Pastikan format nomor pengajuan sesuai (contoh: <span class="font-mono">LEG-202609-0001</span>) atau hubungi petugas Tata Usaha.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Live Statistics Counter -->
        <section class="bg-white border-y border-slate-200 py-10 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div class="p-4">
                        <div class="font-heading text-3xl sm:text-4xl font-extrabold text-blue-950">{{ $stats['total_surat_masuk'] }}</div>
                        <div class="text-xs sm:text-sm font-medium text-slate-500 mt-1">Surat Masuk Terarsip</div>
                    </div>
                    <div class="p-4">
                        <div class="font-heading text-3xl sm:text-4xl font-extrabold text-blue-950">{{ $stats['total_surat_keluar'] }}</div>
                        <div class="text-xs sm:text-sm font-medium text-slate-500 mt-1">Surat Keluar Resmi</div>
                    </div>
                    <div class="p-4">
                        <div class="font-heading text-3xl sm:text-4xl font-extrabold text-teal-600">{{ $stats['total_kategori'] }}</div>
                        <div class="text-xs sm:text-sm font-medium text-slate-500 mt-1">Klasifikasi Kategori Dinas</div>
                    </div>
                    <div class="p-4">
                        <div class="font-heading text-3xl sm:text-4xl font-extrabold text-teal-600">{{ $stats['total_legalisir'] }}</div>
                        <div class="text-xs sm:text-sm font-medium text-slate-500 mt-1">Pengajuan Legalisir Online</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3 Core Pillars Section -->
        <section id="tentang" class="py-16 sm:py-24 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <span class="text-xs font-bold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-200">
                        Modul Utama Sistem
                    </span>
                    <h2 class="font-heading font-extrabold text-2xl sm:text-4xl text-slate-900 mt-3 tracking-tight">
                        Integrasi Manajemen Kearsipan Sekolah
                    </h2>
                    <p class="text-sm text-slate-600 mt-3">
                        Dirancang khusus untuk mendukung operasional administrasi Tata Usaha SMKN 1 Subang secara efektif, terukur, dan transparan.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Card 1: Surat Masuk & Disposisi -->
                    <div class="bg-white rounded-2xl p-7 shadow-xs border border-slate-200 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"/>
                            </svg>
                        </div>
                        <h3 class="font-heading font-bold text-lg text-slate-900 mb-2">Surat Masuk & Disposisi Digital</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pencatatan nomor agenda surat masuk dari instansi mitra/dinas, digitalisasi berkas PDF, serta alur disposisi instruksi Kepala Sekolah langsung ke Wakil Kepala Sekolah.
                        </p>
                    </div>

                    <!-- Card 2: Surat Keluar & Persetujuan -->
                    <div class="bg-white rounded-2xl p-7 shadow-xs border border-slate-200 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </div>
                        <h3 class="font-heading font-bold text-lg text-slate-900 mb-2">Surat Keluar & Approval Kepsek</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Registrasi draf surat keluar, verifikasi kelengkapan oleh staf Tata Usaha, dan persetujuan (approval) digital Kepala Sekolah sebelum surat resmi diterbitkan.
                        </p>
                    </div>

                    <!-- Card 3: Layanan Legalisir Online -->
                    <div class="bg-white rounded-2xl p-7 shadow-xs border border-slate-200 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-800 flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="font-heading font-bold text-lg text-slate-900 mb-2">Layanan Legalisir Ijazah Online</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Kemudahan bagi alumni dan siswa SMKN 1 Subang mengajukan legalisir ijazah dan transkrip nilai tanpa harus antre lama, dilengkapi pelacakan status berkas transparan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Alur Pelayanan Legalisir Section -->
        <section id="alur" class="py-16 sm:py-20 bg-white border-t border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-14">
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-900 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">
                        Prosedur Mudah
                    </span>
                    <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900 mt-3 tracking-tight">
                        Alur 4 Langkah Permohonan Legalisir
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center relative">
                        <div class="w-10 h-10 rounded-full bg-blue-900 text-white font-extrabold flex items-center justify-center mx-auto mb-4 text-sm">
                            1
                        </div>
                        <h4 class="font-heading font-bold text-base text-slate-900 mb-1">Daftar Akun & Unggah Berkas</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Buat akun menggunakan NISN dan unggah pindaian (scan) ijazah/transkrip asli berformat PDF.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center relative">
                        <div class="w-10 h-10 rounded-full bg-blue-900 text-white font-extrabold flex items-center justify-center mx-auto mb-4 text-sm">
                            2
                        </div>
                        <h4 class="font-heading font-bold text-base text-slate-900 mb-1">Verifikasi Staf Tata Usaha</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Petugas mencocokkan berkas dengan buku induk kelulusan SMKN 1 Subang.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center relative">
                        <div class="w-10 h-10 rounded-full bg-blue-900 text-white font-extrabold flex items-center justify-center mx-auto mb-4 text-sm">
                            3
                        </div>
                        <h4 class="font-heading font-bold text-base text-slate-900 mb-1">Persetujuan Kepala Sekolah</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Pimpinan memberikan pengesahan legalitas dokumen secara digital dalam sistem.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center relative">
                        <div class="w-10 h-10 rounded-full bg-teal-600 text-white font-extrabold flex items-center justify-center mx-auto mb-4 text-sm">
                            4
                        </div>
                        <h4 class="font-heading font-bold text-base text-slate-900 mb-1">Pengambilan Berkas Selesai</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">Alumni menerima notifikasi dan mengambil salinan berstempel basah di ruang Tata Usaha.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Information & Contact Section -->
        <section id="kontak" class="py-16 bg-slate-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-500/20 text-teal-300 text-xs font-semibold mb-4 border border-teal-500/30">
                            Lokasi & Jam Kerja
                        </div>
                        <h3 class="font-heading font-extrabold text-2xl sm:text-3xl text-white mb-4">
                            Layanan Tata Usaha SMKN 1 Subang
                        </h3>
                        <p class="text-slate-300 text-sm leading-relaxed mb-6">
                            Gedung Utama Administrasi SMKN 1 Subang melayani kebutuhan kearsipan surat-menyurat dinas dan legalisir dokumen alumni setiap hari kerja.
                        </p>
                        <div class="space-y-3 text-xs text-slate-300">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-teal-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Jl. Arief Rahman Hakim No. 35, Cigadung, Kec. Subang, Kabupaten Subang, Jawa Barat 41213</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>Telepon: (0260) 411410</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-teal-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>Email: smkn1subang@yahoo.co.id / info@smkn1subang.sch.id</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800/80 p-8 rounded-2xl border border-slate-700/80">
                        <h4 class="font-heading font-bold text-lg text-white mb-4">Akses Cepat Pengguna</h4>
                        <div class="space-y-3">
                            <a href="{{ route('login') }}" class="flex items-center justify-between p-4 rounded-xl bg-slate-900/60 hover:bg-slate-900 border border-slate-700 hover:border-teal-500/50 transition-all text-sm group">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-blue-900/50 text-blue-400 flex items-center justify-center font-bold text-xs">TU</div>
                                    <div>
                                        <div class="font-semibold text-white group-hover:text-teal-300 transition-colors">Portal Staf Tata Usaha</div>
                                        <div class="text-xs text-slate-400">Pengelolaan surat & verifikasi berkas</div>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-slate-500 group-hover:text-teal-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>

                            <a href="{{ route('login') }}" class="flex items-center justify-between p-4 rounded-xl bg-slate-900/60 hover:bg-slate-900 border border-slate-700 hover:border-emerald-500/50 transition-all text-sm group">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-emerald-900/50 text-emerald-400 flex items-center justify-center font-bold text-xs">KS</div>
                                    <div>
                                        <div class="font-semibold text-white group-hover:text-emerald-300 transition-colors">Portal Kepala Sekolah</div>
                                        <div class="text-xs text-slate-400">Disposisi surat & persetujuan legalisir</div>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-slate-500 group-hover:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>

                            <a href="{{ route('legalisir.create') }}" class="flex items-center justify-between p-4 rounded-xl bg-slate-900/60 hover:bg-slate-900 border border-slate-700 hover:border-purple-500/50 transition-all text-sm group">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-purple-900/50 text-purple-400 flex items-center justify-center font-bold text-xs">AL</div>
                                    <div>
                                        <div class="font-semibold text-white group-hover:text-purple-300 transition-colors">Pengajuan Legalisir Mandiri Online</div>
                                        <div class="text-xs text-slate-400">Layanan pengajuan dokumen langsung tanpa perlu login</div>
                                    </div>
                                </div>
                                <svg class="w-4 h-4 text-slate-500 group-hover:text-purple-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 text-xs py-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-8 h-10 object-contain shrink-0 opacity-85">
                <div>
                    <p class="text-slate-300 font-semibold">SMK Negeri 1 Subang — SMEA</p>
                    <p class="text-slate-500 mt-0.5">Sistem Informasi Pengelolaan Arsip & Layanan Legalisir Dokumen Digital</p>
                </div>
            </div>
            <div class="text-slate-500">
                &copy; {{ date('Y') }} SMKN 1 Subang. Dikembangkan berdasarkan Proposal Penelitian Skripsi.
            </div>
        </div>
    </footer>

</body>
</html>
