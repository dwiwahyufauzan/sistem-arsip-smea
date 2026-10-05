<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lembar_Kendali_Surat_Keluar_{{ str_replace('/', '_', $surat_keluar->nomor_agenda) }}</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-smk.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Times+New+Roman&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @page {
            size: A4 portrait;
            margin: 10mm 15mm;
        }

        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            color: #000000;
            background-color: #f8fafc;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .font-kop {
            font-family: 'Times New Roman', Times, serif;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-sheet {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            .print-border-black {
                border-color: #000000 !important;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-8 antialiased">

    <!-- Top Action Bar (Hanya tampil di layar monitor) -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs">
        <div class="flex items-center gap-3">
            <button 
                type="button" 
                onclick="window.history.back()" 
                class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Detail</span>
            </button>
            <div class="h-6 w-px bg-slate-200"></div>
            <div>
                <p class="text-xs font-bold text-slate-800">Pratinjau Lembar Kendali Surat Keluar</p>
                <p class="text-[11px] text-slate-500 font-mono">{{ $surat_keluar->nomor_agenda }} • {{ $surat_keluar->nomor_surat }}</p>
            </div>
        </div>

        <button 
            type="button" 
            onclick="window.print()" 
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-blue-500/20 transition-all cursor-pointer active:scale-95"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>Cetak Lembar Arsip (Ctrl+P)</span>
        </button>
    </div>

    <!-- Official Printable Sheet (A4 Container) -->
    <div class="print-sheet max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-2xl border border-slate-200 shadow-sm print:shadow-none print:border-none print:p-0">

        <!-- 1. Kop Surat Resmi Dinas Pendidikan Jawa Barat & SMKN 1 Subang -->
        <div class="border-b-[3px] border-black pb-2 mb-4">
            <div class="flex items-center justify-between gap-4">
                <!-- Logo Jawa Barat -->
                <div class="w-20 h-24 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-jabar.png') }}" alt="Logo Provinsi Jawa Barat" class="w-16 h-20 object-contain">
                </div>

                <!-- Teks Kop Surat -->
                <div class="text-center flex-1 font-kop leading-tight">
                    <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-black">PEMERINTAH DAERAH PROVINSI JAWA BARAT</h3>
                    <h2 class="text-sm sm:text-base font-bold uppercase tracking-wider text-black mt-0.5">DINAS PENDIDIKAN</h2>
                    <h3 class="text-xs sm:text-sm font-bold uppercase tracking-wide text-black">CABANG DINAS PENDIDIKAN WILAYAH IV</h3>
                    <h1 class="text-base sm:text-xl font-black uppercase tracking-tight text-black mt-1">SEKOLAH MENENGAH KEJURUAN NEGERI 1 SUBANG</h1>
                    <p class="text-[10px] sm:text-[11px] text-black mt-1 font-sans leading-normal">
                        Jalan Arief Rahman Hakim No. 35, Dangdeur, Kec. Subang, Kabupaten Subang, Jawa Barat 41211<br>
                        Telepon: (0260) 411410 • Faksimile: (0260) 411410 • Laman: smkn1subang.sch.id • Pos-el: smkn1_sbg@yahoo.co.id
                    </p>
                </div>

                <!-- Logo SMKN 1 Subang -->
                <div class="w-20 h-24 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-16 h-20 object-contain">
                </div>
            </div>

            <!-- Double Line Separator Kedinasan -->
            <div class="border-t border-black mt-2 pt-0.5"></div>
        </div>

        <!-- 2. Judul Dokumen & Klasifikasi Arsip -->
        <div class="text-center my-4">
            <h1 class="text-base sm:text-lg font-black uppercase tracking-wider underline text-black">
                LEMBAR KENDALI DAN REGISTRASI SURAT KELUAR
            </h1>
            <div class="flex items-center justify-center gap-4 text-xs font-semibold text-black mt-1">
                <span>Kode Klasifikasi: <strong>{{ $surat_keluar->kategori->kode_kategori ?? '-' }}</strong></span>
                <span>•</span>
                <span>Kategori: <strong>{{ $surat_keluar->kategori->nama_kategori ?? '-' }}</strong></span>
                <span>•</span>
                <span>Status Otorisasi: <strong class="uppercase">{{ str_replace('_', ' ', $surat_keluar->status_persetujuan) }}</strong></span>
            </div>
        </div>

        <!-- 3. Tabel Informasi Lengkap Surat Keluar -->
        <table class="w-full border-collapse border-2 border-black text-xs text-black mb-4">
            <tbody>
                <tr class="border-b border-black">
                    <td class="w-1/4 p-2.5 font-bold bg-slate-100 print:bg-slate-50 border-r border-black">Nomor Agenda</td>
                    <td class="w-1/4 p-2.5 font-mono font-bold border-r border-black text-sm">{{ $surat_keluar->nomor_agenda }}</td>
                    <td class="w-1/4 p-2.5 font-bold bg-slate-100 print:bg-slate-50 border-r border-black">Tanggal Pengeluaran</td>
                    <td class="w-1/4 p-2.5 font-medium">{{ $surat_keluar->tanggal_keluar ? $surat_keluar->tanggal_keluar->isoFormat('D MMMM Y') : '-' }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="p-2.5 font-bold bg-slate-100 print:bg-slate-50 border-r border-black">Nomor Surat Keluar</td>
                    <td class="p-2.5 font-mono font-semibold border-r border-black">{{ $surat_keluar->nomor_surat }}</td>
                    <td class="p-2.5 font-bold bg-slate-100 print:bg-slate-50 border-r border-black">Tanggal Surat Resmi</td>
                    <td class="p-2.5 font-medium">{{ $surat_keluar->tanggal_surat->isoFormat('D MMMM Y') }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="p-2.5 font-bold bg-slate-100 print:bg-slate-50 border-r border-black">Tujuan Surat / Penerima</td>
                    <td colspan="3" class="p-2.5 font-semibold text-sm">{{ $surat_keluar->tujuan }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="p-2.5 font-bold bg-slate-100 print:bg-slate-50 border-r border-black">Dikonsep / Diajukan Oleh</td>
                    <td colspan="3" class="p-2.5 font-medium">
                        {{ $surat_keluar->user->name ?? 'Staf Tata Usaha' }} 
                        @if($surat_keluar->user && $surat_keluar->user->nip_nisn)
                            (NIP: {{ $surat_keluar->user->nip_nisn }})
                        @endif
                    </td>
                </tr>
                <tr class="border-b border-black">
                    <td class="p-2.5 font-bold bg-slate-100 print:bg-slate-50 border-r border-black align-top">Perihal Surat</td>
                    <td colspan="3" class="p-2.5 font-bold leading-relaxed">{{ $surat_keluar->perihal }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="p-2.5 font-bold bg-slate-100 print:bg-slate-50 border-r border-black align-top">Ringkasan Isi Surat</td>
                    <td colspan="3" class="p-2.5 font-normal leading-relaxed text-justify">
                        {{ $surat_keluar->isi_ringkas ?: 'Tidak ada ringkasan isi surat.' }}
                    </td>
                </tr>
                <tr>
                    <td class="p-2.5 font-bold bg-slate-100 print:bg-slate-50 border-r border-black">Berkas Fisik / Lampiran</td>
                    <td colspan="3" class="p-2.5 font-mono text-[11px]">
                        @if($surat_keluar->file_name)
                            {{ $surat_keluar->file_name }} ({{ number_format($surat_keluar->file_size / 1024, 1) }} KB) • Berkas tersimpan dalam Map Ekspedisi Surat Keluar
                        @else
                            Salinan surat resmi tersimpan pada Boks Arsip Surat Keluar Tata Usaha
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- 4. Lembar Status Otorisasi & Pengesahan Kepala Sekolah -->
        <div class="mb-5">
            <h2 class="text-xs font-bold uppercase tracking-wider text-black mb-2 flex items-center gap-1.5">
                <span>Catatan & Otorisasi Persetujuan Pimpinan:</span>
            </h2>

            <table class="w-full border-collapse border-2 border-black text-xs text-black">
                <tbody>
                    <tr class="border-b border-black bg-slate-100 print:bg-slate-50">
                        <td class="w-1/4 p-2.5 font-bold border-r border-black">Status Persetujuan</td>
                        <td class="w-1/4 p-2.5 font-bold uppercase">
                            @if($surat_keluar->status_persetujuan === 'disetujui')
                                <span class="text-black">DISETUJUI RESMI</span>
                            @elseif($surat_keluar->status_persetujuan === 'ditolak')
                                <span class="text-black">DITOLAK / REVISI</span>
                            @else
                                <span class="text-black">MENUNGGU VERIFIKASI KEPSEK</span>
                            @endif
                        </td>
                        <td class="w-1/4 p-2.5 font-bold border-r border-black border-l border-black">Tanggal Otorisasi</td>
                        <td class="w-1/4 p-2.5 font-medium">
                            {{ $surat_keluar->disetujui_pada ? $surat_keluar->disetujui_pada->isoFormat('D MMMM Y') : '-' }}
                        </td>
                    </tr>
                    <tr class="border-b border-black">
                        <td class="p-2.5 font-bold bg-slate-100 print:bg-slate-50 border-r border-black align-top">Catatan Pimpinan</td>
                        <td colspan="3" class="p-2.5 leading-relaxed">
                            @if($surat_keluar->catatan_persetujuan)
                                <p class="italic font-medium">"{{ $surat_keluar->catatan_persetujuan }}"</p>
                            @else
                                <p class="text-slate-500 print:text-black italic">Tidak ada catatan koreksi khusus. Surat disetujui sesuai dengan draf yang diajukan.</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="p-2.5 font-bold bg-slate-100 print:bg-slate-50 border-r border-black">Pejabat Penyetuju</td>
                        <td colspan="3" class="p-2.5 font-semibold">
                            {{ $surat_keluar->kepsek->name ?? 'Deden Suryanto, M.Pd.' }} 
                            (NIP: {{ $surat_keluar->kepsek->nip_nisn ?? '19680512 199303 1 008' }})
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 5. Tanda Tangan & Pengesahan Kedinasan -->
        <div class="grid grid-cols-3 gap-4 text-xs text-black pt-2 break-inside-avoid items-end">
            <!-- Petugas Pembuat Surat TU -->
            <div class="text-center w-full">
                <p>Diajukan dan dikonsep oleh,</p>
                <p class="font-bold mt-0.5">Pengadministrasi Persuratan,</p>

                <div class="h-16 flex items-center justify-center">
                    <span class="text-[10px] text-slate-400 italic">[Paraf Pembuat Surat]</span>
                </div>

                <p class="font-bold underline text-sm tracking-wide">{{ $surat_keluar->user->name ?? 'Staf Tata Usaha' }}</p>
                <p class="text-[11px] font-mono mt-0.5">NIP. {{ $surat_keluar->user->nip_nisn ?? '-' }}</p>
            </div>

            <!-- QR Code Validasi Keabsahan Dokumen -->
            <div class="text-center flex flex-col items-center justify-center p-2 border border-dashed border-slate-300 rounded-xl bg-slate-50/50 print:bg-transparent">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&margin=2&data={{ urlencode(route('verifikasi.surat-keluar', $surat_keluar->id)) }}" alt="QR Code Keabsahan Dokumen" class="w-20 h-20 object-contain shadow-2xs">
                <span class="text-[8px] font-bold uppercase tracking-wider text-slate-700 mt-1">Pindai Verifikasi</span>
                <span class="text-[7px] text-slate-500 font-mono">Keabsahan SIMA-KMP</span>
            </div>

            <!-- Tanda Tangan Kepala Sekolah -->
            <div class="text-center w-full">
                <p>Subang, {{ $surat_keluar->tanggal_keluar ? $surat_keluar->tanggal_keluar->isoFormat('D MMMM Y') : now()->isoFormat('D MMMM Y') }}</p>
                <p class="font-bold mt-0.5">Mengetahui & Menyetujui,<br>Kepala SMK Negeri 1 Subang,</p>

                <div class="h-16 flex items-center justify-center">
                    <span class="text-[10px] text-slate-400 italic">[Tanda Tangan & Cap Dinas]</span>
                </div>

                <p class="font-bold underline text-sm tracking-wide">{{ $surat_keluar->kepsek->name ?? 'Deden Suryanto, M.Pd.' }}</p>
                <p class="text-[11px] font-mono mt-0.5">NIP. {{ $surat_keluar->kepsek->nip_nisn ?? '19680512 199303 1 008' }}</p>
            </div>
        </div>

        <!-- Footer Keamanan Dokumen -->
        <div class="mt-6 pt-3 border-t border-slate-300 print:border-black flex items-center justify-between text-[9px] text-slate-500 print:text-black font-mono">
            <span>Sistem Informasi Manajemen Arsip Kearsipan (SIMA-KMP) SMKN 1 Subang</span>
            <span>ID Arsip: #SK-{{ str_pad($surat_keluar->id, 5, '0', STR_PAD_LEFT) }} • Dicetak: {{ now()->format('d/m/Y H:i:s') }}</span>
        </div>

    </div>

</body>
</html>
