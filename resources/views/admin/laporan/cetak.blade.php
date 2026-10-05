<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if($jenis === 'surat_masuk')
            Buku_Agenda_Surat_Masuk_{{ $tanggalMulai }}_sd_{{ $tanggalSelesai }}
        @elseif($jenis === 'surat_keluar')
            Buku_Agenda_Surat_Keluar_{{ $tanggalMulai }}_sd_{{ $tanggalSelesai }}
        @else
            Rekapitulasi_Pelayanan_Legalisir_{{ $tanggalMulai }}_sd_{{ $tanggalSelesai }}
        @endif
    </title>

    <link rel="shortcut icon" href="{{ asset('images/logo-smk.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Times+New+Roman&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @page {
            size: A4 landscape;
            margin: 10mm 12mm;
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
                width: 100% !important;
            }
            thead {
                display: table-header-group;
            }
            tr {
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-8 antialiased">

    <!-- Action Toolbar (Hanya tampil di layar) -->
    <div class="no-print max-w-7xl mx-auto mb-6 bg-white p-4 rounded-2xl shadow-xs border border-slate-200/90 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <button onclick="window.history.back()" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali</span>
            </button>
            <div class="h-6 w-px bg-slate-200"></div>
            <div>
                <h2 class="text-xs font-bold text-slate-800">Pratinjau Cetak Buku Agenda Kedinasan</h2>
                <p class="text-[11px] text-slate-500">Format Resmi Provinsi Jawa Barat — Kertas A4 Landscape</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-blue-500/20 transition-all cursor-pointer active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Lembar Dokumen (Ctrl + P)</span>
            </button>
        </div>
    </div>

    <!-- Official Printable Paper Container -->
    <div class="print-sheet max-w-7xl mx-auto bg-white p-6 sm:p-10 rounded-2xl shadow-sm border border-slate-200 print:shadow-none print:border-none print:p-0">

        <!-- Kop Surat Dinas Pendidikan Jawa Barat & SMKN 1 Subang -->
        <div class="border-b-[3px] border-black pb-2 mb-4">
            <div class="flex items-center justify-between gap-4">
                <div class="w-20 h-24 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-jabar.png') }}" alt="Logo Jawa Barat" class="w-16 h-20 object-contain">
                </div>
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
                <div class="w-20 h-24 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-16 h-20 object-contain">
                </div>
            </div>
            <!-- Garis Ganda Pemisah Kop -->
            <div class="border-t border-black mt-2 pt-0.5"></div>
        </div>

        <!-- Judul Laporan & Informasi Periode -->
        <div class="text-center my-4">
            <h2 class="text-base sm:text-lg font-black uppercase tracking-wider text-black underline underline-offset-4 decoration-2">
                @if($jenis === 'surat_masuk')
                    BUKU AGENDA SURAT MASUK
                @elseif($jenis === 'surat_keluar')
                    BUKU AGENDA SURAT KELUAR
                @else
                    REKAPITULASI PELAYANAN LEGALISIR DOKUMEN ALUMNI
                @endif
            </h2>
            <div class="text-xs text-black mt-1.5 flex items-center justify-center gap-3 font-semibold">
                <span>Periode: <strong>{{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }} s.d. {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d F Y') }}</strong></span>
                <span>•</span>
                <span>Total: <strong>{{ number_format($records->count()) }} Dokumen Terdata</strong></span>
                @if($kategoriId)
                    @php $katSelected = $kategoris->firstWhere('id', $kategoriId); @endphp
                    <span>•</span>
                    <span>Klasifikasi: <strong>{{ $katSelected ? $katSelected->kode_kategori . ' (' . $katSelected->nama_kategori . ')' : '-' }}</strong></span>
                @endif
            </div>
        </div>

        <!-- Tabel Agenda Dokumen Resmi -->
        <div class="my-4 overflow-x-auto">
            <table class="w-full border-collapse border-2 border-black text-xs text-black">
                <thead>
                    @if($jenis === 'surat_masuk')
                        <tr class="bg-slate-100 print:bg-slate-100 text-black text-center font-bold border-b-2 border-black">
                            <th class="border border-black px-2 py-2 w-10">No.</th>
                            <th class="border border-black px-2 py-2 w-24">No. Agenda</th>
                            <th class="border border-black px-2 py-2 w-24">Tgl Terima</th>
                            <th class="border border-black px-3 py-2 w-44">Nomor & Tgl Surat</th>
                            <th class="border border-black px-3 py-2 w-48">Pengirim (Instansi)</th>
                            <th class="border border-black px-3 py-2">Perihal Surat</th>
                            <th class="border border-black px-2 py-2 w-28">Klasifikasi</th>
                            <th class="border border-black px-2 py-2 w-24">Status</th>
                        </tr>
                    @elseif($jenis === 'surat_keluar')
                        <tr class="bg-slate-100 print:bg-slate-100 text-black text-center font-bold border-b-2 border-black">
                            <th class="border border-black px-2 py-2 w-10">No.</th>
                            <th class="border border-black px-2 py-2 w-24">No. Agenda</th>
                            <th class="border border-black px-3 py-2 w-48">Nomor & Tgl Surat</th>
                            <th class="border border-black px-3 py-2 w-48">Tujuan / Penerima</th>
                            <th class="border border-black px-3 py-2">Perihal Surat</th>
                            <th class="border border-black px-2 py-2 w-28">Klasifikasi</th>
                            <th class="border border-black px-2 py-2 w-28">Persetujuan</th>
                        </tr>
                    @else
                        <tr class="bg-slate-100 print:bg-slate-100 text-black text-center font-bold border-b-2 border-black">
                            <th class="border border-black px-2 py-2 w-10">No.</th>
                            <th class="border border-black px-2 py-2 w-32">No. Pengajuan</th>
                            <th class="border border-black px-2 py-2 w-24">Tgl Pengajuan</th>
                            <th class="border border-black px-3 py-2 w-44">Nama Pemohon</th>
                            <th class="border border-black px-2 py-2 w-28">NISN / Thn Lulus</th>
                            <th class="border border-black px-2 py-2 w-28">Jenis Dokumen</th>
                            <th class="border border-black px-2 py-2 w-16">Jumlah</th>
                            <th class="border border-black px-3 py-2">Keperluan</th>
                            <th class="border border-black px-2 py-2 w-24">Status</th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @forelse($records as $index => $item)
                        @if($jenis === 'surat_masuk')
                            <tr class="align-top hover:bg-slate-50 border-b border-black">
                                <td class="border border-black px-2 py-2 text-center font-medium">{{ $index + 1 }}</td>
                                <td class="border border-black px-2 py-2 text-center font-mono font-bold">{{ $item->nomor_agenda }}</td>
                                <td class="border border-black px-2 py-2 text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d/m/Y') }}</td>
                                <td class="border border-black px-3 py-2">
                                    <div class="font-bold font-mono">{{ $item->nomor_surat }}</div>
                                    <div class="text-[10px] text-slate-600 print:text-black mt-0.5">Tgl: {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d/m/Y') }}</div>
                                </td>
                                <td class="border border-black px-3 py-2 font-semibold">{{ $item->pengirim }}</td>
                                <td class="border border-black px-3 py-2">
                                    <div class="font-bold">{{ $item->perihal }}</div>
                                    @if($item->ringkasan_isi)
                                        <div class="text-[10px] text-slate-600 print:text-black mt-0.5 leading-relaxed">{{ $item->ringkasan_isi }}</div>
                                    @endif
                                </td>
                                <td class="border border-black px-2 py-2 text-center">
                                    <span class="font-mono font-bold">{{ $item->kategori->kode_kategori ?? '-' }}</span>
                                    <div class="text-[9px] text-slate-600 print:text-black leading-tight">{{ $item->kategori->nama_kategori ?? '' }}</div>
                                </td>
                                <td class="border border-black px-2 py-2 text-center">
                                    @if($item->disposisi && $item->disposisi->isNotEmpty())
                                        <span class="font-bold">Didisposisikan</span>
                                    @else
                                        <span class="capitalize">{{ str_replace('_', ' ', $item->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @elseif($jenis === 'surat_keluar')
                            <tr class="align-top hover:bg-slate-50 border-b border-black">
                                <td class="border border-black px-2 py-2 text-center font-medium">{{ $index + 1 }}</td>
                                <td class="border border-black px-2 py-2 text-center font-mono font-bold">{{ $item->nomor_agenda }}</td>
                                <td class="border border-black px-3 py-2">
                                    <div class="font-bold font-mono">{{ $item->nomor_surat }}</div>
                                    <div class="text-[10px] text-slate-600 print:text-black mt-0.5">Tgl: {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d/m/Y') }}</div>
                                </td>
                                <td class="border border-black px-3 py-2 font-semibold">{{ $item->tujuan }}</td>
                                <td class="border border-black px-3 py-2">
                                    <div class="font-bold">{{ $item->perihal }}</div>
                                    @if($item->isi_ringkas)
                                        <div class="text-[10px] text-slate-600 print:text-black mt-0.5 leading-relaxed">{{ $item->isi_ringkas }}</div>
                                    @endif
                                </td>
                                <td class="border border-black px-2 py-2 text-center">
                                    <span class="font-mono font-bold">{{ $item->kategori->kode_kategori ?? '-' }}</span>
                                    <div class="text-[9px] text-slate-600 print:text-black leading-tight">{{ $item->kategori->nama_kategori ?? '' }}</div>
                                </td>
                                <td class="border border-black px-2 py-2 text-center font-semibold capitalize">
                                    {{ str_replace('_', ' ', $item->status_persetujuan) }}
                                </td>
                            </tr>
                        @else
                            <tr class="align-top hover:bg-slate-50 border-b border-black">
                                <td class="border border-black px-2 py-2 text-center font-medium">{{ $index + 1 }}</td>
                                <td class="border border-black px-2 py-2 text-center font-mono font-bold">{{ $item->nomor_pengajuan }}</td>
                                <td class="border border-black px-2 py-2 text-center whitespace-nowrap">{{ $item->created_at->format('d/m/Y') }}</td>
                                <td class="border border-black px-3 py-2 font-bold uppercase">{{ $item->nama_pemohon }}</td>
                                <td class="border border-black px-2 py-2 text-center">
                                    <div class="font-mono font-semibold">{{ $item->nisn }}</div>
                                    <div class="text-[10px] text-slate-600 print:text-black">Lulus {{ $item->tahun_lulus }}</div>
                                </td>
                                <td class="border border-black px-2 py-2 text-center font-semibold uppercase">{{ $item->jenis_dokumen }}</td>
                                <td class="border border-black px-2 py-2 text-center font-bold">{{ $item->jumlah_lembar }} Lembar</td>
                                <td class="border border-black px-3 py-2">{{ $item->keperluan }}</td>
                                <td class="border border-black px-2 py-2 text-center capitalize font-bold">
                                    {{ str_replace('_', ' ', $item->status) }}
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="{{ $jenis === 'legalisir' ? 9 : 8 }}" class="border border-black px-4 py-8 text-center text-slate-500 print:text-black italic">
                                Tidak ada catatan arsip atau transaksi dokumen yang terdaftar pada rentang periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Kolom Pengesahan Dua Pihak (KTU & Kepala Sekolah) -->
        <div class="mt-8 pt-4 break-inside-avoid">
            <div class="flex justify-between items-start text-xs text-black px-12">
                <!-- Sisi Kiri: KTU -->
                <div class="text-center w-64">
                    <p class="text-slate-600 print:text-black mb-1">Memeriksa / Mengetahui,</p>
                    <p class="font-bold uppercase tracking-wider text-black">Kepala Bagian Tata Usaha,</p>
                    <div class="h-20 sm:h-24 flex items-center justify-center">
                        <span class="text-[10px] text-slate-300 print:text-slate-400 italic">[Tanda Tangan & Cap]</span>
                    </div>
                    <p class="font-bold underline text-black uppercase tracking-wide">H. Tatang Supriatna, S.Sos.</p>
                    <p class="text-[11px] font-mono mt-0.5">NIP. 19720815 199802 1 002</p>
                </div>

                <!-- Sisi Kanan: Kepala Sekolah -->
                <div class="text-center w-64">
                    <p class="text-slate-600 print:text-black mb-1">Subang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p class="font-bold uppercase tracking-wider text-black">Kepala SMK Negeri 1 Subang,</p>
                    <div class="h-20 sm:h-24 flex items-center justify-center">
                        <span class="text-[10px] text-slate-300 print:text-slate-400 italic">[Tanda Tangan & Cap Dinas]</span>
                    </div>
                    <p class="font-bold underline text-black uppercase tracking-wide">Deden Suryanto, M.Pd.</p>
                    <p class="text-[11px] font-mono mt-0.5">NIP. 19680512 199303 1 008</p>
                </div>
            </div>

            <!-- Footer Keamanan Cetak Digital -->
            <div class="mt-6 pt-3 border-t border-slate-300 print:border-black text-center text-[9px] text-slate-500 print:text-black font-mono">
                Buku Agenda Kearsipan Resmi ini dicetak secara digital via Sistem Informasi Manajemen Arsip Berbasis KMP (SIMA-KMP) SMKN 1 Subang • {{ now()->format('d/m/Y H:i:s') }}
            </div>
        </div>

    </div>

</body>
</html>
