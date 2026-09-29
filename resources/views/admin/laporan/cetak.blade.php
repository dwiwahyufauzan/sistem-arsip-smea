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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Tinos:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: #0f172a;
            background-color: #f8fafc;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .font-kop {
            font-family: 'Tinos', serif;
        }

        @page {
            size: landscape;
            margin: 10mm 12mm;
        }

        @media print {
            body {
                background-color: #ffffff !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-shadow-none {
                box-shadow: none !important;
                border: none !important;
            }
            .page-break {
                page-break-after: always;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            thead {
                display: table-header-group;
            }
            tfoot {
                display: table-footer-group;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-8">

    <!-- Action Toolbar (No Print) -->
    <div class="no-print max-w-7xl mx-auto mb-6 bg-white p-4 rounded-2xl shadow-sm border border-slate-200 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <button onclick="window.history.back()" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali</span>
            </button>
            <div class="h-6 w-px bg-slate-200"></div>
            <div>
                <h2 class="text-sm font-bold text-slate-800">Pratinjau Lembar Cetak Dinas</h2>
                <p class="text-[11px] text-slate-500">Format resmi buku agenda kearsipan Provinsi Jawa Barat</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-blue-500/20 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Lembar Dokumen (Ctrl + P)</span>
            </button>
        </div>
    </div>

    <!-- Official Paper Container -->
    <div class="max-w-7xl mx-auto bg-white p-6 sm:p-10 rounded-2xl shadow-sm border border-slate-200 print-shadow-none">

        <!-- Kop Surat Dinas Pendidikan Jawa Barat & SMKN 1 Subang -->
        <div class="border-b-[3px] border-double border-slate-900 pb-3 mb-6">
            <div class="flex items-center justify-between gap-4">
                <div class="w-20 h-20 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-jabar.png') }}" onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/a/a2/Coat_of_arms_of_West_Java.svg'" alt="Logo Jawa Barat" class="h-20 w-auto object-contain">
                </div>
                <div class="text-center flex-1 font-kop leading-tight">
                    <h3 class="text-sm sm:text-base font-bold uppercase tracking-wider text-slate-900">PEMERINTAH DAERAH PROVINSI JAWA BARAT</h3>
                    <h2 class="text-base sm:text-lg font-bold uppercase tracking-wide text-slate-900">DINAS PENDIDIKAN</h2>
                    <h3 class="text-sm font-semibold uppercase text-slate-800">CABANG DINAS PENDIDIKAN WILAYAH IV</h3>
                    <h1 class="text-lg sm:text-xl font-black uppercase tracking-wider text-slate-950 mt-0.5">SEKOLAH MENENGAH KEJURUAN NEGERI 1 SUBANG</h1>
                    <p class="text-[10px] sm:text-xs text-slate-600 mt-1 font-sans">
                        Jl. Arif Rahman Hakim No. 35, Cigadung, Kec. Subang, Kabupaten Subang, Jawa Barat 41211<br>
                        Telepon: (0260) 411410 • Pos-el: smkn1_sbg@yahoo.co.id • Laman: smkn1subang.sch.id
                    </p>
                </div>
                <div class="w-20 h-20 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-smk.png') }}" onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Logo_SMK_Bisa.png/600px-Logo_SMK_Bisa.png'" alt="Logo Sekolah" class="h-16 w-auto object-contain">
                </div>
            </div>
        </div>

        <!-- Document Title & Period Metadata -->
        <div class="text-center my-6">
            <h2 class="text-base sm:text-lg font-extrabold uppercase tracking-wide text-slate-950 underline underline-offset-4 decoration-2">
                @if($jenis === 'surat_masuk')
                    BUKU AGENDA SURAT MASUK
                @elseif($jenis === 'surat_keluar')
                    BUKU AGENDA SURAT KELUAR
                @else
                    REKAPITULASI PELAYANAN LEGALISIR DOKUMEN ALUMNI
                @endif
            </h2>
            <div class="text-xs text-slate-700 mt-2 flex items-center justify-center gap-3">
                <span><strong>Periode:</strong> {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }} s.d. {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d F Y') }}</span>
                <span>•</span>
                <span><strong>Total Data:</strong> {{ number_format($records->count()) }} Dokumen</span>
                @if($kategoriId)
                    @php $katSelected = $kategoris->firstWhere('id', $kategoriId); @endphp
                    <span>•</span>
                    <span><strong>Klasifikasi:</strong> {{ $katSelected ? $katSelected->kode_kategori . ' (' . $katSelected->nama_kategori . ')' : '-' }}</span>
                @endif
            </div>
        </div>

        <!-- Tabular Agenda Data -->
        <div class="overflow-x-auto my-6">
            <table class="w-full border-collapse border border-slate-900 text-xs">
                <thead>
                    @if($jenis === 'surat_masuk')
                        <tr class="bg-slate-100 text-slate-950 text-center font-bold">
                            <th class="border border-slate-900 px-2 py-2 w-10">No.</th>
                            <th class="border border-slate-900 px-2 py-2 w-24">No. Agenda</th>
                            <th class="border border-slate-900 px-2 py-2 w-24">Tgl Terima</th>
                            <th class="border border-slate-900 px-3 py-2 w-44">Nomor & Tanggal Surat</th>
                            <th class="border border-slate-900 px-3 py-2 w-48">Pengirim (Instansi)</th>
                            <th class="border border-slate-900 px-3 py-2">Perihal & Ringkasan</th>
                            <th class="border border-slate-900 px-2 py-2 w-28">Klasifikasi</th>
                            <th class="border border-slate-900 px-2 py-2 w-24">Status</th>
                        </tr>
                    @elseif($jenis === 'surat_keluar')
                        <tr class="bg-slate-100 text-slate-950 text-center font-bold">
                            <th class="border border-slate-900 px-2 py-2 w-10">No.</th>
                            <th class="border border-slate-900 px-2 py-2 w-24">No. Agenda</th>
                            <th class="border border-slate-900 px-3 py-2 w-48">Nomor & Tanggal Surat</th>
                            <th class="border border-slate-900 px-3 py-2 w-48">Tujuan / Penerima</th>
                            <th class="border border-slate-900 px-3 py-2">Perihal & Isi Ringkas</th>
                            <th class="border border-slate-900 px-2 py-2 w-28">Klasifikasi</th>
                            <th class="border border-slate-900 px-2 py-2 w-28">Persetujuan</th>
                        </tr>
                    @else
                        <tr class="bg-slate-100 text-slate-950 text-center font-bold">
                            <th class="border border-slate-900 px-2 py-2 w-10">No.</th>
                            <th class="border border-slate-900 px-2 py-2 w-32">No. Pengajuan</th>
                            <th class="border border-slate-900 px-2 py-2 w-24">Tgl Pengajuan</th>
                            <th class="border border-slate-900 px-3 py-2 w-44">Nama Pemohon</th>
                            <th class="border border-slate-900 px-2 py-2 w-28">NISN / Thn Lulus</th>
                            <th class="border border-slate-900 px-2 py-2 w-28">Jenis Dokumen</th>
                            <th class="border border-slate-900 px-2 py-2 w-16">Jumlah</th>
                            <th class="border border-slate-900 px-3 py-2">Keperluan Permohonan</th>
                            <th class="border border-slate-900 px-2 py-2 w-24">Status</th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @forelse($records as $index => $item)
                        @if($jenis === 'surat_masuk')
                            <tr class="align-top hover:bg-slate-50">
                                <td class="border border-slate-900 px-2 py-1.5 text-center">{{ $index + 1 }}</td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center font-mono font-semibold">{{ $item->nomor_agenda }}</td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d/m/Y') }}</td>
                                <td class="border border-slate-900 px-3 py-1.5">
                                    <div class="font-semibold">{{ $item->nomor_surat }}</div>
                                    <div class="text-[10px] text-slate-600">Tgl: {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d/m/Y') }}</div>
                                </td>
                                <td class="border border-slate-900 px-3 py-1.5 font-medium">{{ $item->pengirim }}</td>
                                <td class="border border-slate-900 px-3 py-1.5">
                                    <div class="font-semibold">{{ $item->perihal }}</div>
                                    @if($item->ringkasan_isi)
                                        <div class="text-[10px] text-slate-600 line-clamp-2 mt-0.5">{{ $item->ringkasan_isi }}</div>
                                    @endif
                                </td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center">
                                    <span class="font-mono font-semibold">{{ $item->kategori->kode_kategori ?? '-' }}</span>
                                    <div class="text-[9px] text-slate-500 leading-tight">{{ $item->kategori->nama_kategori ?? '' }}</div>
                                </td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center">
                                    @if($item->disposisi && $item->disposisi->isNotEmpty())
                                        <span class="font-semibold text-emerald-800">Didisposisi</span>
                                    @else
                                        <span class="text-slate-600 capitalize">{{ str_replace('_', ' ', $item->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @elseif($jenis === 'surat_keluar')
                            <tr class="align-top hover:bg-slate-50">
                                <td class="border border-slate-900 px-2 py-1.5 text-center">{{ $index + 1 }}</td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center font-mono font-semibold">{{ $item->nomor_agenda }}</td>
                                <td class="border border-slate-900 px-3 py-1.5">
                                    <div class="font-semibold">{{ $item->nomor_surat }}</div>
                                    <div class="text-[10px] text-slate-600">Tgl: {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d/m/Y') }}</div>
                                </td>
                                <td class="border border-slate-900 px-3 py-1.5 font-medium">{{ $item->tujuan }}</td>
                                <td class="border border-slate-900 px-3 py-1.5">
                                    <div class="font-semibold">{{ $item->perihal }}</div>
                                    @if($item->isi_ringkas)
                                        <div class="text-[10px] text-slate-600 line-clamp-2 mt-0.5">{{ $item->isi_ringkas }}</div>
                                    @endif
                                </td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center">
                                    <span class="font-mono font-semibold">{{ $item->kategori->kode_kategori ?? '-' }}</span>
                                    <div class="text-[9px] text-slate-500 leading-tight">{{ $item->kategori->nama_kategori ?? '' }}</div>
                                </td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center font-medium capitalize">
                                    {{ str_replace('_', ' ', $item->status_persetujuan) }}
                                </td>
                            </tr>
                        @else
                            <tr class="align-top hover:bg-slate-50">
                                <td class="border border-slate-900 px-2 py-1.5 text-center">{{ $index + 1 }}</td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center font-mono font-semibold">{{ $item->nomor_pengajuan }}</td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center whitespace-nowrap">{{ $item->created_at->format('d/m/Y') }}</td>
                                <td class="border border-slate-900 px-3 py-1.5 font-semibold">{{ $item->nama_pemohon }}</td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center">
                                    <div class="font-mono">{{ $item->nisn }}</div>
                                    <div class="text-[10px] text-slate-600">Lulus {{ $item->tahun_lulus }}</div>
                                </td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center font-medium uppercase">{{ $item->jenis_dokumen }}</td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center font-semibold">{{ $item->jumlah_lembar }} Lembar</td>
                                <td class="border border-slate-900 px-3 py-1.5 text-slate-700">{{ $item->keperluan }}</td>
                                <td class="border border-slate-900 px-2 py-1.5 text-center capitalize font-medium">
                                    {{ str_replace('_', ' ', $item->status) }}
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="{{ $jenis === 'legalisir' ? 9 : 8 }}" class="border border-slate-900 px-4 py-8 text-center text-slate-500 italic">
                                Belum ada arsip atau catatan dinas yang terdaftar pada rentang periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Official Endorsement & Signature Blocks -->
        <div class="mt-10 pt-4 break-inside-avoid">
            <div class="flex justify-between items-start text-xs text-slate-900 px-8">
                
                <!-- Left Signature: Kepala Bagian Tata Usaha -->
                <div class="text-center w-64">
                    <p class="text-slate-600 mb-1">Mengetahui / Memeriksa,</p>
                    <p class="font-bold uppercase tracking-wider text-slate-950">Kepala Tata Usaha SMKN 1 Subang</p>
                    <div class="h-20 sm:h-24"></div>
                    <p class="font-bold underline underline-offset-2 uppercase text-slate-950">H. Tatang Supriatna, S.Sos.</p>
                    <p class="text-slate-600 text-[11px] mt-0.5">NIP. 19720815 199802 1 002</p>
                </div>

                <!-- Right Signature: Kepala Sekolah -->
                <div class="text-center w-64">
                    <p class="text-slate-600 mb-1">Subang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p class="font-bold uppercase tracking-wider text-slate-950">Kepala SMK Negeri 1 Subang</p>
                    <div class="h-20 sm:h-24"></div>
                    <p class="font-bold underline underline-offset-2 uppercase text-slate-950">Deden Suryanto, M.Pd.</p>
                    <p class="text-slate-600 text-[11px] mt-0.5">NIP. 19680512 199303 1 008</p>
                </div>
            </div>

            <!-- Footer Stamp & Archival Security Verification -->
            <div class="mt-8 pt-4 border-t border-slate-200 text-center text-[10px] text-slate-400 font-mono">
                Dokumen Buku Agenda Resmi ini dicetak secara digital melalui Sistem Informasi Manajemen Arsip Berbasis KMP (SIMA-KMP) SMKN 1 Subang • {{ now()->format('d/m/Y H:i:s') }}
            </div>
        </div>

    </div>

</body>
</html>
