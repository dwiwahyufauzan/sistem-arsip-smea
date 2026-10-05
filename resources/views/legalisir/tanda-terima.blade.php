<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda_Terima_Legalisir_{{ str_replace('/', '_', $pengajuan->nomor_pengajuan) }}</title>
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
                width: 100% !important;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-8 antialiased">

    <!-- Action Bar (Hanya Tampil di Layar) -->
    <div class="no-print max-w-3xl mx-auto mb-6 flex items-center justify-between bg-white p-4 rounded-2xl shadow-xs border border-slate-200/90">
        <div class="flex items-center gap-3">
            <a href="{{ route('legalisir.tracking', ['nomor_pengajuan' => $pengajuan->nomor_pengajuan]) }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Pelacakan Berkas</span>
            </a>
            <div class="h-6 w-px bg-slate-200"></div>
            <div>
                <p class="text-xs font-bold text-slate-800">Bukti Tanda Terima Legalisir</p>
                <p class="text-[11px] text-slate-500 font-mono">{{ $pengajuan->nomor_pengajuan }}</p>
            </div>
        </div>

        <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-blue-500/20 transition-all cursor-pointer active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            <span>Cetak Tanda Terima (Ctrl+P)</span>
        </button>
    </div>

    <!-- Official Printable Sheet (A4 Container) -->
    <div class="print-sheet max-w-3xl mx-auto bg-white p-8 sm:p-10 rounded-2xl shadow-sm border border-slate-200 print:shadow-none print:border-none print:p-0">
        
        <!-- Official Kop Surat Dinas Pendidikan Jawa Barat & SMKN 1 Subang -->
        <div class="border-b-[3px] border-black pb-2 mb-4">
            <div class="flex items-center justify-between gap-4">
                <div class="w-16 h-20 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-jabar.png') }}" alt="Logo Provinsi Jawa Barat" class="w-14 h-18 object-contain">
                </div>
                <div class="text-center flex-1 font-kop leading-tight">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-black">PEMERINTAH DAERAH PROVINSI JAWA BARAT</h3>
                    <h2 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-black mt-0.5">DINAS PENDIDIKAN</h2>
                    <h3 class="text-xs font-bold uppercase tracking-wide text-black">CABANG DINAS PENDIDIKAN WILAYAH IV</h3>
                    <h1 class="text-sm sm:text-lg font-black uppercase tracking-tight text-black mt-0.5">SEKOLAH MENENGAH KEJURUAN NEGERI 1 SUBANG</h1>
                    <p class="text-[9px] sm:text-[10px] text-black mt-1 font-sans leading-normal">
                        Jalan Arief Rahman Hakim No. 35, Dangdeur, Subang, Jawa Barat 41211<br>
                        Telepon: (0260) 411410 • Laman: smkn1subang.sch.id • Pos-el: smkn1_sbg@yahoo.co.id
                    </p>
                </div>
                <div class="w-16 h-20 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-14 h-18 object-contain">
                </div>
            </div>
            <!-- Garis Pemisah Ganda -->
            <div class="border-t border-black mt-2 pt-0.5"></div>
        </div>

        <!-- Judul Bukti Tanda Terima & Nomor Resi -->
        <div class="flex items-center justify-between border-b-2 border-black pb-3 mb-4">
            <div>
                <h1 class="text-sm sm:text-base font-black uppercase tracking-wide text-black">
                    BUKTI TANDA TERIMA PENDAFTARAN LEGALISIR
                </h1>
                <p class="text-[11px] text-black mt-0.5 font-medium">Layanan Tata Usaha Mandiri Alumni & Siswa SMKN 1 Subang</p>
            </div>
            <!-- Badge Resi Resmi & QR Code -->
            <div class="border-2 border-black rounded-xl p-2 text-center bg-slate-50 print:bg-slate-50 flex items-center gap-3">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&margin=1&data={{ urlencode(route('verifikasi.legalisir', $pengajuan->nomor_pengajuan)) }}" alt="QR Code Resi Legalisir" class="w-14 h-14 object-contain shrink-0">
                <div class="text-left">
                    <span class="text-[8px] font-black tracking-wider uppercase block text-black">NO. REGISTRASI RESMI</span>
                    <span class="text-xs font-black font-mono text-black">{{ $pengajuan->nomor_pengajuan }}</span>
                    <span class="text-[8px] text-slate-600 block mt-0.5">Pindai QR untuk verifikasi bukti</span>
                </div>
            </div>
        </div>

        <!-- Tabel Rincian Data Pemohon & Permohonan -->
        <div class="space-y-4 text-xs text-black">
            <table class="w-full border-collapse border border-black">
                <tbody class="divide-y divide-black">
                    <tr>
                        <td class="w-1/3 py-2 px-3 font-bold bg-slate-50 print:bg-slate-50 border-r border-black">Waktu Pendaftaran</td>
                        <td class="w-2/3 py-2 px-3 font-semibold">{{ $pengajuan->created_at->translatedFormat('l, d F Y - H:i') }} WIB</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3 font-bold bg-slate-50 print:bg-slate-50 border-r border-black">Nama Lengkap Pemohon</td>
                        <td class="py-2 px-3 font-bold uppercase">{{ $pengajuan->nama_pemohon }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3 font-bold bg-slate-50 print:bg-slate-50 border-r border-black">NISN / Tahun Kelulusan</td>
                        <td class="py-2 px-3 font-mono font-medium">{{ $pengajuan->nisn }} (Lulusan Tahun {{ $pengajuan->tahun_lulus }})</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3 font-bold bg-slate-50 print:bg-slate-50 border-r border-black">Nomor Kontak WhatsApp</td>
                        <td class="py-2 px-3 font-mono font-medium">{{ $pengajuan->nomor_whatsapp }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3 font-bold bg-slate-50 print:bg-slate-50 border-r border-black">Alamat Email Terdaftar</td>
                        <td class="py-2 px-3 font-mono">{{ $pengajuan->email }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3 font-bold bg-slate-50 print:bg-slate-50 border-r border-black">Jenis Dokumen Legalisir</td>
                        <td class="py-2 px-3 font-bold text-black uppercase">{{ $pengajuan->jenis_dokumen_label }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3 font-bold bg-slate-50 print:bg-slate-50 border-r border-black">Jumlah Lembar Legalisir</td>
                        <td class="py-2 px-3 font-bold">{{ $pengajuan->jumlah_lembar }} Lembar</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3 font-bold bg-slate-50 print:bg-slate-50 border-r border-black">Keperluan Pengajuan</td>
                        <td class="py-2 px-3">{{ $pengajuan->keperluan }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 px-3 font-bold bg-slate-50 print:bg-slate-50 border-r border-black">Status Terkini Berkas</td>
                        <td class="py-2 px-3 font-bold uppercase">{{ $pengajuan->status_label }}</td>
                    </tr>
                    @if($pengajuan->tanggal_siap_ambil)
                    <tr class="bg-amber-50/50 print:bg-slate-100">
                        <td class="py-2 px-3 font-bold border-r border-black">Jadwal Pengambilan</td>
                        <td class="py-2 px-3 font-bold underline font-mono">{{ $pengajuan->tanggal_siap_ambil->translatedFormat('l, d F Y') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Ketentuan Kedinasan Pengambilan Berkas -->
            <div class="border border-black p-3.5 rounded-lg text-[10px] leading-relaxed bg-slate-50 print:bg-transparent space-y-1">
                <p class="font-bold uppercase tracking-wider text-black">Ketentuan Pengambilan Dokumen Fisik di Tata Usaha:</p>
                <ol class="list-decimal list-inside space-y-0.5 pl-1 text-black font-medium">
                    <li>Pemohon wajib membawa lembar bukti tanda terima ini (cetak fisik atau digital pada gawai) ke Loket Pelayanan Tata Usaha SMKN 1 Subang.</li>
                    <li>Wajib menunjukkan kartu identitas asli pemohon (KTP / SIM / Kartu Pelajar) yang sah dan masih berlaku.</li>
                    <li>Membawa dokumen asli (Ijazah / Transkrip / Rapor) untuk dicocokkan keabsahannya oleh petugas verifikator.</li>
                    <li>Waktu pelayanan loket Tata Usaha: <strong>Senin s.d. Jumat pukul 08.00 - 15.00 WIB</strong> (Istirahat 12.00 - 13.00 WIB).</li>
                    <li>Seluruh layanan administrasi dan legalisir dokumen resmi di SMKN 1 Subang <strong>TIDAK DIPUNGUT BIAYA (GRATIS)</strong>.</li>
                </ol>
            </div>

            <!-- Kolom Tanda Tangan Dua Pihak -->
            <div class="pt-4 grid grid-cols-2 gap-8 text-center text-xs break-inside-avoid">
                <div>
                    <p class="font-medium text-slate-700 print:text-black">Pemohon / Pengaju Legalisir,</p>
                    <div class="h-16 flex items-center justify-center">
                        <span class="text-[9px] text-slate-300 print:text-slate-400 italic">[Tanda Tangan Pemohon]</span>
                    </div>
                    <p class="font-bold text-black uppercase underline">{{ $pengajuan->nama_pemohon }}</p>
                    <p class="text-[10px] text-black font-mono">NISN: {{ $pengajuan->nisn }}</p>
                </div>
                <div>
                    <p class="font-medium text-slate-700 print:text-black">Subang, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="font-medium text-slate-700 print:text-black">Petugas Loket Tata Usaha,</p>
                    <div class="h-16 flex items-center justify-center">
                        <span class="text-[9px] text-slate-300 print:text-slate-400 italic">[Tanda Tangan & Cap Loket]</span>
                    </div>
                    <p class="font-bold text-black uppercase underline">
                        {{ $pengajuan->petugas->name ?? 'Petugas Tata Usaha' }}
                    </p>
                    <p class="text-[10px] text-black font-mono">
                        {{ $pengajuan->petugas?->nip_nisn ? 'NIP. ' . $pengajuan->petugas->nip_nisn : 'Staf Kearsipan SMEA' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Keamanan Dokumen -->
        <div class="mt-6 pt-3 border-t border-black flex items-center justify-between text-[9px] text-black font-mono">
            <span>Sistem Informasi Tata Kelola Arsip & Legalisir (SIMA-KMP) SMKN 1 Subang</span>
            <span>Dicetak secara digital: {{ now()->format('d/m/Y H:i:s') }}</span>
        </div>
    </div>

</body>
</html>
