<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lembar_Kendali_Surat_Masuk_{{ str_replace('/', '_', $surat_masuk->nomor_agenda) }}</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-smk.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Times+New+Roman&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @page {
            size: A4 portrait;
            margin: 8mm 12mm;
        }

        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            color: #000000;
            background-color: #f8fafc;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .font-kop {
            font-family: 'Times New Roman', Times, serif;
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
            .no-print {
                display: none !important;
            }
            .print-sheet {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            table {
                border-collapse: collapse !important;
            }
            .break-inside-avoid {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-6 antialiased">

    <!-- Top Action Bar (Hanya tampil di layar monitor) -->
    <div class="max-w-4xl mx-auto mb-5 flex items-center justify-between no-print bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <div class="flex items-center gap-3">
            <button 
                type="button" 
                onclick="window.history.back()" 
                class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Halaman Sebelumnya</span>
            </button>
            <div class="h-6 w-px bg-slate-200"></div>
            <div>
                <p class="text-xs font-bold text-slate-800">Pratinjau Lembar Kendali Surat Masuk</p>
                <p class="text-[11px] text-slate-500 font-mono">{{ $surat_masuk->nomor_agenda }} • {{ $surat_masuk->nomor_surat }}</p>
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
    <div class="print-sheet max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm print:shadow-none print:border-none print:p-0">

        <!-- 1. Kop Surat Resmi Dinas Pendidikan Jawa Barat & SMKN 1 Subang -->
        <div class="border-b-2 border-black pb-1.5 mb-2.5">
            <div class="flex items-center justify-between gap-3">
                <!-- Logo Jawa Barat -->
                <div class="w-14 h-18 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-jabar.png') }}" alt="Logo Provinsi Jawa Barat" class="w-13 h-17 object-contain">
                </div>

                <!-- Teks Kop Surat -->
                <div class="text-center flex-1 font-kop leading-tight">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-black">PEMERINTAH DAERAH PROVINSI JAWA BARAT</h3>
                    <h2 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-black mt-0.5">DINAS PENDIDIKAN</h2>
                    <h3 class="text-xs font-bold uppercase tracking-wide text-black">CABANG DINAS PENDIDIKAN WILAYAH IV</h3>
                    <h1 class="text-sm sm:text-base font-black uppercase tracking-tight text-black mt-0.5">SEKOLAH MENENGAH KEJURUAN NEGERI 1 SUBANG</h1>
                    <p class="text-[9px] text-black mt-0.5 font-sans leading-tight">
                        Jalan Arief Rahman Hakim No. 35, Dangdeur, Kec. Subang, Kabupaten Subang, Jawa Barat 41211<br>
                        Telepon: (0260) 411410 • Faksimile: (0260) 411410 • Laman: smkn1subang.sch.id • Pos-el: smkn1_sbg@yahoo.co.id
                    </p>
                </div>

                <!-- Logo SMKN 1 Subang -->
                <div class="w-14 h-18 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-13 h-17 object-contain">
                </div>
            </div>

            <!-- Double Line Separator Kedinasan -->
            <div class="border-t border-black mt-1.5 pt-0.5"></div>
        </div>

        <!-- 2. Judul Dokumen & Klasifikasi Arsip -->
        <div class="text-center my-2">
            <h1 class="text-sm sm:text-base font-black uppercase tracking-wider underline text-black">
                LEMBAR KENDALI DAN REGISTRASI SURAT MASUK
            </h1>
            <div class="flex items-center justify-center gap-3 text-[10px] font-semibold text-black mt-0.5">
                <span>Kode Klasifikasi: <strong>{{ $surat_masuk->kategori->kode_kategori ?? '-' }}</strong></span>
                <span>•</span>
                <span>Kategori: <strong>{{ $surat_masuk->kategori->nama_kategori ?? '-' }}</strong></span>
                <span>•</span>
                <span>Status: <strong>{{ ucfirst($surat_masuk->status) }}</strong></span>
            </div>
        </div>

        <!-- 3. Tabel Informasi Lengkap Surat Masuk -->
        <table class="w-full border-collapse border border-black text-[10.5px] text-black mb-2.5">
            <tbody>
                <tr class="border-b border-black">
                    <td class="w-1/4 py-1 px-2.5 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Nomor Agenda</td>
                    <td class="w-1/4 py-1 px-2.5 font-mono font-bold border-r border-black text-xs">{{ $surat_masuk->nomor_agenda }}</td>
                    <td class="w-1/4 py-1 px-2.5 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Tanggal Penerimaan</td>
                    <td class="w-1/4 py-1 px-2.5 font-medium">{{ $surat_masuk->tanggal_terima->isoFormat('D MMMM Y') }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="py-1 px-2.5 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Nomor Surat Masuk</td>
                    <td class="py-1 px-2.5 font-mono font-semibold border-r border-black">{{ $surat_masuk->nomor_surat }}</td>
                    <td class="py-1 px-2.5 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Tanggal Surat Asal</td>
                    <td class="py-1 px-2.5 font-medium">{{ $surat_masuk->tanggal_surat->isoFormat('D MMMM Y') }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="py-1 px-2.5 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Instansi / Pengirim</td>
                    <td colspan="3" class="py-1 px-2.5 font-semibold">{{ $surat_masuk->pengirim }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="py-1 px-2.5 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Ditujukan Kepada</td>
                    <td colspan="3" class="py-1 px-2.5 font-medium">{{ $surat_masuk->penerima ?: 'Kepala SMK Negeri 1 Subang' }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="py-1 px-2.5 font-bold bg-slate-100 print:bg-slate-100 border-r border-black align-top">Perihal Surat</td>
                    <td colspan="3" class="py-1 px-2.5 font-bold leading-snug">{{ $surat_masuk->perihal }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="py-1 px-2.5 font-bold bg-slate-100 print:bg-slate-100 border-r border-black align-top">Ringkasan Isi Surat</td>
                    <td colspan="3" class="py-1 px-2.5 font-normal leading-snug text-justify">
                        {{ $surat_masuk->isi_ringkas ?: 'Tidak ada ringkasan isi surat.' }}
                    </td>
                </tr>
                <tr>
                    <td class="py-1 px-2.5 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Berkas Fisik / Scan</td>
                    <td colspan="3" class="py-1 px-2.5 font-mono text-[10px]">
                        @if($surat_masuk->file_name)
                            {{ $surat_masuk->file_name }} ({{ number_format($surat_masuk->file_size / 1024, 1) }} KB) • Tersimpan di Ruang Arsip TU SMKN 1 Subang
                        @else
                            Lampiran dokumen fisik tersimpan dalam Boks Arsip Surat Masuk
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- 4. Lembar Rekap Disposisi / Instruksi Tindak Lanjut -->
        <div class="mb-2.5">
            <h2 class="text-[11px] font-bold uppercase tracking-wider text-black mb-1 flex items-center gap-1.5">
                <span>Instruksi Disposisi Kepala Sekolah:</span>
            </h2>

            @if($surat_masuk->disposisi && $surat_masuk->disposisi->count() > 0)
                <div class="space-y-1.5">
                    @foreach($surat_masuk->disposisi as $disp)
                        <table class="w-full border-collapse border border-black text-[10.5px] text-black mb-1">
                            <tbody>
                                <tr class="border-b border-black bg-slate-100 print:bg-slate-100">
                                    <td class="w-1/4 py-1 px-2 font-bold border-r border-black">Diteruskan Kepada</td>
                                    <td class="w-3/4 py-1 px-2 font-bold">{{ $disp->tujuan_disposisi }}</td>
                                </tr>
                                <tr class="border-b border-black">
                                    <td class="py-1 px-2 font-bold bg-slate-100 print:bg-slate-100 border-r border-black align-top">Instruksi Arahan</td>
                                    <td class="py-1 px-2 font-semibold leading-snug whitespace-pre-line">{{ $disp->instruksi }}</td>
                                </tr>
                                @if($disp->catatan)
                                    <tr class="border-b border-black">
                                        <td class="py-1 px-2 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Catatan Tambahan</td>
                                        <td class="py-1 px-2 italic">{{ $disp->catatan }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="py-1 px-2 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Batas Waktu / Status</td>
                                    <td class="py-1 px-2 flex items-center justify-between">
                                        <span>Batas Waktu: <strong>{{ $disp->batas_waktu ? $disp->batas_waktu->isoFormat('D MMMM Y') : 'Segera' }}</strong></span>
                                        <span>Status: <strong class="uppercase underline">{{ $disp->status }}</strong></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                </div>
            @else
                <!-- Format Kotak Disposisi Manual Bila Belum Ada di Sistem -->
                <table class="w-full border-collapse border border-black text-[10px] text-black">
                    <tbody>
                        <tr class="border-b border-black bg-slate-100 print:bg-slate-100 font-bold">
                            <td class="w-1/2 py-1 px-2 border-r border-black text-center">DITERUSKAN KEPADA YTH:</td>
                            <td class="w-1/2 py-1 px-2 text-center">PETUNJUK / DISPOSISI KEPALA SEKOLAH:</td>
                        </tr>
                        <tr class="align-top">
                            <td class="p-2 border-r border-black space-y-0.5 text-[9.5px]">
                                <div class="flex items-center gap-1.5"><span class="w-3 h-3 border border-black inline-block"></span> Wakasek Bidang Kurikulum</div>
                                <div class="flex items-center gap-1.5"><span class="w-3 h-3 border border-black inline-block"></span> Wakasek Bidang Kesiswaan</div>
                                <div class="flex items-center gap-1.5"><span class="w-3 h-3 border border-black inline-block"></span> Wakasek Bidang Hubinmas / BKK</div>
                                <div class="flex items-center gap-1.5"><span class="w-3 h-3 border border-black inline-block"></span> Wakasek Bidang Sarana & Prasarana</div>
                                <div class="flex items-center gap-1.5"><span class="w-3 h-3 border border-black inline-block"></span> Kepala Bagian Tata Usaha (KTU)</div>
                                <div class="flex items-center gap-1.5"><span class="w-3 h-3 border border-black inline-block"></span> Bendahara Sekolah / Komite</div>
                                <div class="flex items-center gap-1.5"><span class="w-3 h-3 border border-black inline-block"></span> Petugas Pengarsipan Persuratan</div>
                            </td>
                            <td class="p-2 flex flex-col justify-between min-h-[75px] text-[9.5px]">
                                <p class="text-slate-500 italic print:text-black leading-tight">
                                    [ ] Tanggapi & Tindak Lanjuti Segera<br>
                                    [ ] Hadiri / Koordinasikan<br>
                                    [ ] Siapkan Bahan & Laporan<br>
                                    [ ] Arsipkan / Ketahui Bersama<br>
                                    Catatan: ............................................................................................
                                </p>
                                <div class="pt-2 flex justify-between items-end text-[9px] text-black">
                                    <span>Batas Waktu: ....................</span>
                                    <span>Paraf KS: ..........</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>

        <!-- 5. Tanda Tangan & Pengesahan Kedinasan -->
        <div class="grid grid-cols-2 gap-6 text-xs text-black pt-1 break-inside-avoid">
            <!-- Petugas Pengadministrasi Arsip TU -->
            <div class="text-center w-60 mr-auto">
                <p class="text-[10px]">Dicatat dan diverifikasi,</p>
                <p class="font-bold mt-0.5 text-[10.5px]">Pengelola Arsip Tata Usaha,</p>

                <div class="h-11 flex items-center justify-center">
                    <span class="text-[9px] text-slate-400 print:text-slate-400 italic">[Paraf Petugas TU]</span>
                </div>

                <p class="font-bold underline text-xs tracking-wide">{{ $surat_masuk->user->name ?? 'Staf Tata Usaha' }}</p>
                <p class="text-[10px] font-mono mt-0.5">NIP. {{ $surat_masuk->user->nip_nisn ?? '-' }}</p>
            </div>

            <!-- Tanda Tangan Kepala Sekolah -->
            <div class="text-center ml-auto w-60">
                <p class="text-[10px]">Subang, {{ now()->isoFormat('D MMMM Y') }}</p>
                <p class="font-bold mt-0.5 text-[10.5px]">Kepala SMK Negeri 1 Subang,</p>

                <div class="h-11 flex items-center justify-center">
                    <span class="text-[9px] text-slate-400 print:text-slate-400 italic">[Tanda Tangan & Cap Dinas]</span>
                </div>

                <p class="font-bold underline text-xs tracking-wide">Deden Suryanto, M.Pd.</p>
                <p class="text-[10px] font-mono mt-0.5">NIP. 19680512 199303 1 008</p>
            </div>
        </div>

        <!-- Footer Keamanan Dokumen -->
        <div class="mt-2.5 pt-1.5 border-t border-black flex items-center justify-between text-[8.5px] text-black font-mono">
            <span>Sistem Informasi Manajemen Arsip Kearsipan (SIMA-KMP) SMKN 1 Subang</span>
            <span>ID Arsip: #SM-{{ str_pad($surat_masuk->id, 5, '0', STR_PAD_LEFT) }} • Dicetak: {{ now()->format('d/m/Y H:i:s') }}</span>
        </div>

    </div>

</body>
</html>

