<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lembar Disposisi - {{ $disposisi->suratMasuk->nomor_agenda }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Times+New+Roman&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            body {
                background: white !important;
                color: black !important;
                font-size: 12pt;
            }
            .no-print {
                display: none !important;
            }
            .print-border {
                border-color: #000 !important;
            }
            .page-break {
                page-break-after: always;
            }
        }
        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
        }
        .kop-instansi {
            font-family: 'Times New Roman', serif;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased p-4 sm:p-8">

    <!-- Top Action Bar (Screen Only) -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-3">
            <button 
                type="button" 
                onclick="window.history.back()" 
                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors cursor-pointer"
            >
                &larr; Kembali
            </button>
            <span class="text-xs text-slate-500 font-medium">Format Cetak Lembar Disposisi Standar Kedinasan</span>
        </div>
        <button 
            type="button" 
            onclick="window.print()" 
            class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-700/20 transition-all flex items-center gap-2 cursor-pointer"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>Cetak Dokumen Sekarang</span>
        </button>
    </div>

    <!-- Official Printable Sheet (A4 Container) -->
    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-2xl sm:border sm:border-slate-200 shadow-sm print:shadow-none print:border-none print:p-0">

        <!-- 1. Kop Surat Resmi Instansi SMKN 1 Subang -->
        <div class="kop-instansi text-center border-b-[3px] border-black pb-3 relative">
            <div class="leading-tight">
                <h3 class="text-sm font-bold tracking-wider uppercase text-black">Pemerintah Daerah Provinsi Jawa Barat</h3>
                <h3 class="text-sm font-bold tracking-wider uppercase text-black">Dinas Pendidikan</h3>
                <h3 class="text-base font-bold tracking-wider uppercase text-black">Cabang Dinas Pendidikan Wilayah IV</h3>
                <h2 class="text-xl sm:text-2xl font-extrabold uppercase text-black mt-0.5 tracking-tight">SMK Negeri 1 Subang</h2>
                <p class="text-xs text-black mt-1 font-normal">
                    Jalan Arief Rahman Hakim No. 35, Dangdeur, Kec. Subang, Kabupaten Subang, Jawa Barat 41211<br>
                    Telepon: (0260) 411410 | Faksimile: (0260) 411410 | Laman: smkn1subang.sch.id
                </p>
            </div>
            <!-- Double Line Separator -->
            <div class="border-t border-black mt-1.5 pt-0.5"></div>
        </div>

        <!-- 2. Judul Lembar -->
        <div class="text-center my-5">
            <h1 class="text-base sm:text-lg font-extrabold uppercase tracking-wider underline text-black">
                Lembar Disposisi Kepala Sekolah
            </h1>
            <p class="text-xs text-black mt-0.5 font-medium">
                Indeks / Kode Klasifikasi: {{ $disposisi->suratMasuk->kategori->kode_kategori }} - {{ $disposisi->suratMasuk->kategori->nama_kategori }}
            </p>
        </div>

        <!-- 3. Tabel Data Surat Masuk -->
        <table class="w-full border-collapse border border-black text-xs text-black mb-4">
            <tbody>
                <tr class="border-b border-black">
                    <td class="w-1/4 p-2 font-bold bg-slate-50 print:bg-transparent border-r border-black">Nomor Agenda</td>
                    <td class="w-1/4 p-2 font-mono font-bold border-r border-black">{{ $disposisi->suratMasuk->nomor_agenda }}</td>
                    <td class="w-1/4 p-2 font-bold bg-slate-50 print:bg-transparent border-r border-black">Tanggal Terima</td>
                    <td class="w-1/4 p-2">{{ $disposisi->suratMasuk->tanggal_terima->isoFormat('D MMMM Y') }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="p-2 font-bold bg-slate-50 print:bg-transparent border-r border-black">Nomor Surat</td>
                    <td class="p-2 font-semibold border-r border-black">{{ $disposisi->suratMasuk->nomor_surat }}</td>
                    <td class="p-2 font-bold bg-slate-50 print:bg-transparent border-r border-black">Tanggal Surat</td>
                    <td class="p-2">{{ $disposisi->suratMasuk->tanggal_surat->isoFormat('D MMMM Y') }}</td>
                </tr>
                <tr class="border-b border-black">
                    <td class="p-2 font-bold bg-slate-50 print:bg-transparent border-r border-black">Asal / Pengirim</td>
                    <td colspan="3" class="p-2 font-medium">{{ $disposisi->suratMasuk->pengirim }}</td>
                </tr>
                <tr>
                    <td class="p-2 font-bold bg-slate-50 print:bg-transparent border-r border-black align-top">Perihal Surat</td>
                    <td colspan="3" class="p-2 font-medium leading-relaxed">{{ $disposisi->suratMasuk->perihal }}</td>
                </tr>
            </tbody>
        </table>

        <!-- 4. Lembar Arahan & Pejabat Tujuan -->
        <table class="w-full border-collapse border border-black text-xs text-black mb-6">
            <thead>
                <tr class="border-b border-black bg-slate-100 print:bg-transparent text-center font-bold">
                    <th class="w-1/2 p-2 border-r border-black uppercase text-[11px]">Diteruskan Kepada Yth:</th>
                    <th class="w-1/2 p-2 uppercase text-[11px]">Instruksi / Disposisi Kepala Sekolah:</th>
                </tr>
            </thead>
            <tbody>
                <tr class="align-top">
                    <!-- Kolom Diteruskan Kepada -->
                    <td class="p-3 border-r border-black space-y-1.5">
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
                                <span class="w-4 h-4 border border-black inline-flex items-center justify-center text-[11px] font-bold">
                                    {{ $isChecked ? '✓' : '' }}
                                </span>
                                <span class="{{ $isChecked ? 'font-bold' : '' }}">{{ $pj }}</span>
                            </div>
                        @endforeach

                        <!-- Jika tujuan custom di luar list standar -->
                        <div class="pt-2 border-t border-dashed border-slate-300 print:border-black mt-2">
                            <span class="text-[10px] font-bold uppercase block text-slate-500 print:text-black">Tujuan Khusus Tertulis:</span>
                            <p class="font-bold underline text-xs mt-0.5">{{ $disposisi->tujuan_disposisi }}</p>
                        </div>
                    </td>

                    <!-- Kolom Isi Disposisi -->
                    <td class="p-3 space-y-3 flex flex-col justify-between h-full min-h-[220px]">
                        <div>
                            <span class="text-[10px] font-bold uppercase text-slate-500 print:text-black block mb-1">Arahan / Petunjuk:</span>
                            <div class="p-2.5 bg-slate-50 print:bg-transparent border border-slate-200 print:border-black rounded-lg min-h-[100px] whitespace-pre-line leading-relaxed font-medium">
                                {{ $disposisi->instruksi }}
                            </div>

                            @if($disposisi->catatan)
                                <div class="mt-2 text-[11px]">
                                    <span class="font-bold">Catatan:</span>
                                    <span class="italic">{{ $disposisi->catatan }}</span>
                                </div>
                            @endif

                            @if($disposisi->batas_waktu)
                                <div class="mt-3 p-1.5 bg-amber-50 print:bg-transparent border border-amber-300 print:border-black rounded text-[11px] font-bold">
                                    Batas Waktu Selesai: {{ $disposisi->batas_waktu->isoFormat('D MMMM Y') }}
                                </div>
                            @endif
                        </div>

                        <div class="text-[11px] text-slate-400 print:text-black mt-4 italic">
                            * Mohon untuk segera ditindaklanjuti dan dilaporkan perkembangannya.
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- 5. Tanda Tangan & Pengesahan Pimpinan -->
        <div class="grid grid-cols-2 gap-8 text-xs text-black pt-4">
            <div>
                <p class="text-[11px] text-slate-500 print:text-black">Tanggal Diterbitkan: {{ $disposisi->created_at->isoFormat('D MMMM Y') }}</p>
                <div class="mt-2 p-2 border border-dashed border-slate-300 print:border-black rounded text-[10px] space-y-1">
                    <p class="font-bold uppercase">Catatan Penerima Disposisi:</p>
                    <p class="text-slate-400 print:text-slate-700 italic">Tanggal terima: ...........................................</p>
                    <p class="text-slate-400 print:text-slate-700 italic">Paraf / Tanda Tangan: .................................</p>
                </div>
            </div>

            <div class="text-center ml-auto w-64">
                <p>Subang, {{ $disposisi->created_at->isoFormat('D MMMM Y') }}</p>
                <p class="font-bold mt-0.5">Kepala SMK Negeri 1 Subang,</p>

                <!-- Signature Space -->
                <div class="h-20 flex items-center justify-center">
                    <span class="text-[10px] text-slate-300 print:text-slate-400 italic">[Tanda Tangan & Cap Dinas]</span>
                </div>

                <p class="font-bold underline text-sm">{{ $disposisi->pemberi->name ?? 'Deden Suryanto, M.Pd.' }}</p>
                <p class="text-[11px]">NIP. {{ $disposisi->pemberi->nip_nisn ?? '19680512 199303 1 008' }}</p>
            </div>
        </div>

    </div>

</body>
</html>
