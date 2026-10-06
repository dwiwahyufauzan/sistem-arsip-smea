<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Keabsahan Dokumen - {{ $suratKeluar->nomor_surat }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @page {
            size: A4 portrait;
            margin: 10mm 15mm;
        }

        @media print {
            html, body {
                background: #ffffff !important;
                background-color: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
                font-size: 10pt !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print,
            .btn-action-container {
                display: none !important;
            }
            .print-card {
                box-shadow: none !important;
                border: 1.5px solid #000000 !important;
                border-radius: 12px !important;
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
            }
            .print-card-header {
                background-color: #0f172a !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased py-8 px-4 sm:px-6 lg:px-8 font-sans">

    <div class="max-w-2xl mx-auto">
        <!-- Brand Header Resmi SMKN 1 Subang -->
        <div class="print-card bg-white rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden">
            <!-- Kop Instansi Kedinasan -->
            <div class="print-card-header bg-slate-900 text-white p-6 sm:p-8 text-center relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-blue-600/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="flex items-center justify-center gap-3 sm:gap-4 mb-3">
                    <img src="{{ asset('images/logo-jabar.png') }}" alt="Logo Pemda Jawa Barat" class="w-12 h-14 object-contain drop-shadow-sm">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-12 h-14 object-contain drop-shadow-sm">
                </div>
                <p class="text-[11px] font-bold tracking-widest text-slate-300 uppercase">Pemerintah Daerah Provinsi Jawa Barat</p>
                <p class="text-xs font-semibold text-slate-300">Dinas Pendidikan • Cabang Dinas Pendidikan Wilayah IV</p>
                <h1 class="text-base sm:text-lg font-extrabold uppercase tracking-tight text-white mt-1">SMK NEGERI 1 SUBANG</h1>
                <p class="text-[11px] text-slate-400 mt-1 font-mono">Sistem Informasi Manajemen Arsip Kearsipan (SIMA-KMP)</p>
            </div>

            <!-- Status Banner Keabsahan -->
            <div class="p-6 sm:p-8">
                @if($isSah)
                    <div class="bg-emerald-50 border-2 border-emerald-500/80 rounded-2xl p-5 mb-6 text-center shadow-xs">
                        <div class="w-14 h-14 rounded-full bg-emerald-600 text-white flex items-center justify-center mx-auto mb-3 shadow-md">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="inline-block px-3 py-1 bg-emerald-600 text-white text-xs font-black uppercase tracking-wider rounded-full mb-1">
                            Dokumen Resmi & Sah
                        </span>
                        <h2 class="text-lg sm:text-xl font-black text-emerald-950 mt-1">TERVERIFIKASI DI SISTEM ARSIP</h2>
                        <p class="text-xs text-emerald-800 mt-1 max-w-md mx-auto leading-relaxed">
                            Surat ini sah terdaftar secara resmi pada buku agenda keluar SMKN 1 Subang dan telah melalui proses otorisasi pimpinan.
                        </p>
                    </div>
                @else
                    <div class="bg-amber-50 border-2 border-amber-500/80 rounded-2xl p-5 mb-6 text-center shadow-xs">
                        <div class="w-14 h-14 rounded-full bg-amber-500 text-white flex items-center justify-center mx-auto mb-3 shadow-md">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <span class="inline-block px-3 py-1 bg-amber-600 text-white text-xs font-black uppercase tracking-wider rounded-full mb-1">
                            Status: {{ strtoupper(str_replace('_', ' ', $suratKeluar->status_persetujuan)) }}
                        </span>
                        <h2 class="text-lg font-black text-amber-950 mt-1">BELUM TEROTORISASI PENUH</h2>
                        <p class="text-xs text-amber-800 mt-1 max-w-md mx-auto">
                            Dokumen ini tercatat dalam sistem namun belum memiliki pengesahan akhir dari Kepala Sekolah.
                        </p>
                    </div>
                @endif

                <!-- Rincian Identitas Dokumen -->
                <div class="space-y-4 text-xs">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 pb-2 border-b border-slate-200">
                        Rincian Autentikasi Dokumen
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                            <span class="text-[10px] font-semibold uppercase text-slate-400 block">Nomor Surat Resmi</span>
                            <span class="font-mono font-bold text-slate-900 text-sm mt-0.5 block break-all">{{ $suratKeluar->nomor_surat }}</span>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                            <span class="text-[10px] font-semibold uppercase text-slate-400 block">Nomor Agenda Sistem</span>
                            <span class="font-mono font-bold text-slate-900 text-sm mt-0.5 block">{{ $suratKeluar->nomor_agenda }}</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                        <span class="text-[10px] font-semibold uppercase text-slate-400 block">Perihal Dokumen</span>
                        <p class="font-bold text-slate-900 text-sm mt-0.5">{{ $suratKeluar->perihal }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                            <span class="text-[10px] font-semibold uppercase text-slate-400 block">Tujuan / Penerima</span>
                            <span class="font-semibold text-slate-900 mt-0.5 block">{{ $suratKeluar->tujuan }}</span>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                            <span class="text-[10px] font-semibold uppercase text-slate-400 block">Tanggal Surat</span>
                            <span class="font-medium text-slate-900 mt-0.5 block">{{ $suratKeluar->tanggal_surat->isoFormat('D MMMM Y') }}</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-gradient-to-br from-slate-50 to-blue-50/40 border border-blue-200/80">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-900 text-white flex items-center justify-center shrink-0 shadow-xs font-bold text-xs">
                                TTE
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-blue-800 block">Otorisasi & Pengesahan Pimpinan</span>
                                <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $suratKeluar->kepsek->name ?? 'Deden Suryanto, M.Pd.' }}</p>
                                <p class="text-xs text-slate-600 font-mono mt-0.5">NIP: {{ $suratKeluar->kepsek->nip_nisn ?? '19680512 199303 1 008' }}</p>
                                <p class="text-[11px] text-slate-500 mt-1">Jabatan: Kepala SMKN 1 Subang</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-between text-[11px] text-slate-500 font-mono">
                        <span>Waktu Pengecekan Sistem:</span>
                        <span class="font-semibold text-slate-700">{{ now()->isoFormat('D MMMM Y, HH:mm:ss') }} WIB</span>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-8 flex flex-col sm:flex-row gap-3 btn-action-container no-print">
                    <button type="button" onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ route('landing') }}'" class="flex-1 py-3 px-4 rounded-xl text-center text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors cursor-pointer">
                        Kembali ke Halaman Sebelumnya
                    </button>
                    <button onclick="window.print()" class="py-3 px-6 rounded-xl text-center text-xs font-bold bg-blue-900 hover:bg-blue-800 text-white shadow-xs transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak Bukti Verifikasi</span>
                    </button>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            &copy; {{ date('Y') }} SMK Negeri 1 Subang • Sistem Verifikasi Dokumen Kearsipan Kedinasan
        </p>
    </div>

</body>
</html>
