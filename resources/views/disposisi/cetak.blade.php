<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lembar_Disposisi_{{ str_replace('/', '_', $disposisi->suratMasuk->nomor_agenda) }}</title>
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

    <!-- Top Action Bar (Hanya tampil di layar) -->
    <div class="max-w-4xl mx-auto mb-5 flex items-center justify-between no-print bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <div class="flex items-center gap-3">
            <button 
                type="button" 
                onclick="window.history.back()" 
                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors cursor-pointer flex items-center gap-1.5"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Halaman Sebelumnya</span>
            </button>
            <div class="h-6 w-px bg-slate-200"></div>
            <div>
                <p class="text-xs font-bold text-slate-800">Pratinjau Lembar Disposisi Kedinasan</p>
                <p class="text-[11px] text-slate-500">Standar Naskah Dinas SMKN 1 Subang — Kertas A4 Portrait</p>
            </div>
        </div>

        <button 
            type="button" 
            onclick="window.print()" 
            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-blue-500/20 transition-all flex items-center gap-2 cursor-pointer active:scale-95"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>Cetak Lembar Disposisi (Ctrl+P)</span>
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
                Lembar Disposisi Kepala Sekolah
            </h1>
            <div class="flex items-center justify-center gap-3 text-[10px] font-semibold text-black mt-0.5">
                <span>Indeks: <strong>{{ $disposisi->suratMasuk->kategori->kode_kategori ?? '-' }}</strong></span>
                <span>•</span>
                <span>Klasifikasi: <strong>{{ $disposisi->suratMasuk->kategori->nama_kategori ?? '-' }}</strong></span>
                <span>•</span>
                <span>Status: <strong>Penting</strong></span>
            </div>
        </div>

        <!-- 3. Tabel Data Informasi Surat Masuk -->
        <table class="w-full border-collapse border border-black text-[10.5px] text-black mb-2.5">
            <tbody>
                <tr class="border-b border-black">
                    <td class="w-1/4 py-1 px-2 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Nomor Agenda</td>
                    <td class="w-1/4 py-1 px-2 font-mono font-bold border-r border-black">{{ $disposisi->suratMasuk->nomor_agenda }}</td>
                    <td class="w-1/4 py-1 px-2 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Tanggal Penerimaan</td>
                    <td class="w-1/4 py-1 px-2 font-medium">{{ $disposisi->suratMasuk->tanggal_terima->isoFormat('D MMMM Y') }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="py-1 px-2 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Nomor Surat Asal</td>
                    <td class="py-1 px-2 font-semibold border-r border-black font-mono">{{ $disposisi->suratMasuk->nomor_surat }}</td>
                    <td class="py-1 px-2 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Tanggal Surat Asal</td>
                    <td class="py-1 px-2 font-medium">{{ $disposisi->suratMasuk->tanggal_surat->isoFormat('D MMMM Y') }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="py-1 px-2 font-bold bg-slate-100 print:bg-slate-100 border-r border-black">Asal / Instansi Pengirim</td>
                    <td colspan="3" class="py-1 px-2 font-semibold">{{ $disposisi->suratMasuk->pengirim }}</td>
                </tr>
                <tr>
                    <td class="py-1 px-2 font-bold bg-slate-100 print:bg-slate-100 border-r border-black align-top">Perihal Surat</td>
                    <td colspan="3" class="py-1 px-2 font-medium leading-snug">{{ $disposisi->suratMasuk->perihal }}</td>
                </tr>
            </tbody>
        </table>

        <!-- 4. Lembar Arahan & Pejabat Penerima Disposisi -->
        <table class="w-full border-collapse border border-black text-[10.5px] text-black mb-2.5">
            <thead>
                <tr class="border-b border-black bg-slate-100 print:bg-slate-100 text-center font-bold">
                    <th class="w-1/2 py-1 px-2 border-r border-black uppercase text-[10px] tracking-wider">Diteruskan Kepada Yth:</th>
                    <th class="w-1/2 py-1 px-2 uppercase text-[10px] tracking-wider">Instruksi / Disposisi Pimpinan:</th>
                </tr>
            </thead>
            <tbody>
                <tr class="align-top">
                    <!-- Kolom Diteruskan Kepada -->
                    <td class="p-2 border-r border-black space-y-1">
                        @php
                            $pejabatList = [
                                'Wakil Kepala Sekolah Bidang Kurikulum',
                                'Wakil Kepala Sekolah Bidang Kesiswaan',
                                'Wakil Kepala Sekolah Bidang Hubinmas',
                                'Wakil Kepala Sekolah Bidang Sarana & Prasarana',
                                'Kepala Bagian Tata Usaha (KTU)',
                                'Pembina OSIS & Ekstrakurikuler',
                                'Koordinator Bimbingan Konseling (BK)',
                                'Bendahara Komite / Sekolah',
                                'Staf Pengarsipan Persuratan',
                            ];
                        @endphp

                        @foreach($pejabatList as $pj)
                            @php
                                $isChecked = Str::contains(strtolower($disposisi->tujuan_disposisi), strtolower(explode(' ', $pj)[0])) 
                                    || Str::contains(strtolower($disposisi->tujuan_disposisi), strtolower($pj));
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="w-3.5 h-3.5 border border-black inline-flex items-center justify-center text-[9px] font-bold shrink-0">
                                    {{ $isChecked ? '✓' : '' }}
                                </span>
                                <span class="{{ $isChecked ? 'font-bold underline' : 'font-medium' }} text-[10px]">{{ $pj }}</span>
                            </div>
                        @endforeach

                        <!-- Tujuan Khusus Jika Ditulis Manual -->
                        <div class="pt-1.5 border-t border-dashed border-black mt-1">
                            <span class="text-[9px] font-bold uppercase block text-black">Tujuan Tertulis / Khusus:</span>
                            <p class="font-bold text-[10.5px] mt-0.5 text-black underline leading-tight">{{ $disposisi->tujuan_disposisi }}</p>
                        </div>
                    </td>

                    <!-- Kolom Instruksi & Batas Waktu -->
                    <td class="p-2 flex flex-col justify-between h-full space-y-2">
                        <div>
                            <span class="text-[9px] font-bold uppercase text-black block mb-1">Arahan / Petunjuk Tindak Lanjut:</span>
                            <div class="p-2 bg-slate-50 print:bg-transparent border border-black rounded min-h-[70px] whitespace-pre-line leading-relaxed font-semibold text-black text-[10.5px]">
                                {{ $disposisi->instruksi }}
                            </div>

                            @if($disposisi->catatan)
                                <div class="mt-1 text-[9.5px] p-1.5 bg-slate-50 print:bg-transparent border border-black rounded">
                                    <span class="font-bold">Catatan Khusus:</span>
                                    <span class="italic text-black">{{ $disposisi->catatan }}</span>
                                </div>
                            @endif

                            @if($disposisi->batas_waktu)
                                <div class="mt-1 p-1 bg-amber-50 print:bg-transparent border border-black rounded text-[9.5px] font-bold text-black flex items-center justify-between">
                                    <span>Batas Waktu Penyelesaian:</span>
                                    <span class="font-mono underline">{{ $disposisi->batas_waktu->isoFormat('D MMMM Y') }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="text-[8.5px] text-black italic pt-1 border-t border-dashed border-black mt-1 leading-tight">
                            * Harap segera dipelajari, ditindaklanjuti, dan dilaporkan hasil pelaksanaannya kepada Kepala Sekolah.
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- 5. Tanda Tangan & Lembar Pengesahan -->
        <div class="grid grid-cols-2 gap-6 text-xs text-black pt-1 break-inside-avoid">
            <!-- Tanda Terima Pelaksana -->
            <div class="space-y-1">
                <p class="text-[10px] font-medium text-black">Tanggal Disposisi: {{ $disposisi->created_at->isoFormat('D MMMM Y') }}</p>
                <div class="p-2 border border-black rounded-lg text-[9px] space-y-1 bg-slate-50 print:bg-transparent">
                    <p class="font-bold uppercase tracking-wide">Tanda Terima Pelaksana Disposisi:</p>
                    <p class="text-black">Tanggal Diterima : ...................................................</p>
                    <p class="text-black">Nama Penerima   : ...................................................</p>
                    <p class="text-black">Paraf Pelaksana : ...................................................</p>
                </div>
            </div>

            <!-- Tanda Tangan Kepala Sekolah -->
            <div class="text-center ml-auto w-60">
                <p class="text-[10.5px]">Subang, {{ $disposisi->created_at->isoFormat('D MMMM Y') }}</p>
                <p class="font-bold mt-0.5 text-[10.5px]">Kepala SMK Negeri 1 Subang,</p>

                <!-- Ruang Tanda Tangan & Cap -->
                <div class="h-11 flex items-center justify-center">
                    <span class="text-[9px] text-slate-400 print:text-slate-400 italic">[Tanda Tangan & Cap Dinas]</span>
                </div>

                <p class="font-bold underline text-xs tracking-wide">{{ $disposisi->pemberi->name ?? 'Deden Suryanto, M.Pd.' }}</p>
                <p class="text-[10px] font-mono mt-0.5">NIP. {{ $disposisi->pemberi->nip_nisn ?? '19680512 199303 1 008' }}</p>
            </div>
        </div>

        <!-- Footer Keamanan Dokumen -->
        <div class="mt-2.5 pt-1.5 border-t border-black flex items-center justify-between text-[8.5px] text-black font-mono">
            <span>Sistem Informasi Arsip & Legalisir (SIMA-KMP) SMKN 1 Subang</span>
            <span>ID Disposisi: #DSP-{{ str_pad($disposisi->id, 5, '0', STR_PAD_LEFT) }} • Dicetak: {{ now()->format('d/m/Y H:i') }}</span>
        </div>

    </div>

</body>
</html>

