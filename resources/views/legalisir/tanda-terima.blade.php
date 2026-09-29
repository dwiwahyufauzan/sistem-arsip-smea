<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima Permohonan Legalisir - {{ $pengajuan->nomor_pengajuan }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #fff !important;
                padding: 0 !important;
            }
            .print-container {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased p-4 sm:p-8">

    <!-- Action Bar (Hidden on Print) -->
    <div class="no-print max-w-3xl mx-auto mb-6 flex items-center justify-between bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
        <div class="flex items-center gap-2">
            <a href="{{ route('legalisir.tracking', ['nomor_pengajuan' => $pengajuan->nomor_pengajuan]) }}" class="px-3.5 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                &larr; Kembali ke Pelacakan
            </a>
            <span class="text-xs text-slate-400">|</span>
            <span class="text-xs text-slate-600 font-mono font-semibold">{{ $pengajuan->nomor_pengajuan }}</span>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2 bg-blue-700 hover:bg-blue-600 text-white text-xs font-bold rounded-xl shadow-sm transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak Tanda Terima</span>
            </button>
        </div>
    </div>

    <!-- Official Printable Sheet -->
    <div class="print-container max-w-3xl mx-auto bg-white p-8 sm:p-10 rounded-2xl shadow-md border border-slate-300">
        
        <!-- Official Kop Surat SMKN 1 Subang -->
        <div class="border-b-4 border-double border-slate-900 pb-4 mb-6">
            <div class="flex items-center justify-between gap-4">
                <div class="w-20 h-20 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-16 h-16 object-contain" onerror="this.onerror=null; this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'%231e3a8a\'><path d=\'M12 2L1 7l11 5 9-4.09V17h2V7L12 2z\'/></svg>'">
                </div>
                <div class="text-center flex-1">
                    <h3 class="text-xs uppercase font-semibold tracking-wider text-slate-700">PEMERINTAH DAERAH PROVINSI JAWA BARAT</h3>
                    <h4 class="text-xs uppercase font-semibold tracking-wider text-slate-700">DINAS PENDIDIKAN</h4>
                    <h2 class="text-sm font-extrabold uppercase tracking-wide text-slate-800">CABANG DINAS PENDIDIKAN WILAYAH IV</h2>
                    <h1 class="text-lg font-black uppercase text-slate-950 tracking-tight">SMK NEGERI 1 SUBANG</h1>
                    <p class="text-[10px] text-slate-600 leading-tight mt-0.5">
                        Jl. Arif Rahman Hakim No. 35, Cigadung, Kec. Subang, Kab. Subang, Jawa Barat 41211<br>
                        Pos-el: smkn1subang@yahoo.co.id | Laman: www.smkn1subang.sch.id
                    </p>
                </div>
                <div class="w-20 h-20 shrink-0 flex flex-col items-center justify-center p-1 bg-slate-50 border border-slate-300 rounded-lg text-center">
                    <span class="text-[8px] font-bold text-slate-500 uppercase">RESI RESMI</span>
                    <span class="text-[9px] font-black font-mono text-blue-900 mt-1 leading-tight break-all">{{ $pengajuan->nomor_pengajuan }}</span>
                </div>
            </div>
        </div>

        <!-- Title of Document -->
        <div class="text-center mb-6">
            <h2 class="text-base font-extrabold uppercase tracking-wider text-slate-900 underline decoration-slate-900 underline-offset-4">
                BUKTI TANDA TERIMA PENDAFTARAN LEGALISIR
            </h2>
            <p class="text-xs text-slate-500 mt-1">
                Nomor Registrasi: <span class="font-mono font-bold text-slate-800">{{ $pengajuan->nomor_pengajuan }}</span>
            </p>
        </div>

        <!-- Registration & Applicant Details -->
        <div class="space-y-4 text-xs">
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                <table class="w-full">
                    <tbody class="divide-y divide-slate-200/60">
                        <tr>
                            <td class="py-2 text-slate-500 font-semibold w-1/3">Tanggal Pendaftaran</td>
                            <td class="py-2 text-slate-900 font-medium w-2/3">: {{ $pengajuan->created_at->translatedFormat('d F Y, H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-slate-500 font-semibold">Nama Lengkap Pemohon</td>
                            <td class="py-2 text-slate-900 font-bold uppercase">: {{ $pengajuan->nama_pemohon }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-slate-500 font-semibold">NISN / Tahun Kelulusan</td>
                            <td class="py-2 text-slate-900 font-medium font-mono">: {{ $pengajuan->nisn }} / Lulus Tahun {{ $pengajuan->tahun_lulus }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-slate-500 font-semibold">Nomor WhatsApp / HP</td>
                            <td class="py-2 text-slate-900 font-medium font-mono">: {{ $pengajuan->nomor_whatsapp }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-slate-500 font-semibold">Alamat Email</td>
                            <td class="py-2 text-slate-900 font-medium">: {{ $pengajuan->email }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-slate-500 font-semibold">Dokumen yang Dilegalisir</td>
                            <td class="py-2 text-slate-900 font-bold">: {{ $pengajuan->jenis_dokumen_label }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-slate-500 font-semibold">Jumlah Lembar Legalisir</td>
                            <td class="py-2 text-slate-900 font-medium">: {{ $pengajuan->jumlah_lembar }} Lembar</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-slate-500 font-semibold">Keperluan Permohonan</td>
                            <td class="py-2 text-slate-900 font-medium">: {{ $pengajuan->keperluan }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-slate-500 font-semibold">Status Terkini Berkas</td>
                            <td class="py-2 font-bold text-blue-900">: {{ $pengajuan->status_label }}</td>
                        </tr>
                        @if($pengajuan->tanggal_siap_ambil)
                        <tr>
                            <td class="py-2 text-slate-500 font-semibold">Tanggal Siap Diambil</td>
                            <td class="py-2 font-bold text-emerald-800">: {{ $pengajuan->tanggal_siap_ambil->translatedFormat('d F Y') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Notes & Terms -->
            <div class="border border-slate-300 rounded-xl p-4 bg-slate-50/70 text-[11px] space-y-1.5 text-slate-700">
                <p class="font-bold text-slate-900 uppercase tracking-wide">Ketentuan Pengambilan Dokumen Fisik:</p>
                <ol class="list-decimal list-inside space-y-1 pl-1">
                    <li>Pemohon wajib membawa lembar bukti tanda terima ini (cetak fisik atau unduhan digital pada gawai) ke loket Pelayanan Tata Usaha SMKN 1 Subang.</li>
                    <li>Membawa kartu identitas resmi pemohon (KTP / SIM / Paspor) asli yang masih berlaku.</li>
                    <li>Membawa dokumen asli untuk diverifikasi petugas loket apabila ada keraguan keabsahan berkas.</li>
                    <li>Pengambilan dilayani pada hari kerja: <strong>Senin s.d. Jumat, pukul 08.00 - 15.00 WIB</strong> (Istirahat 12.00 - 13.00 WIB).</li>
                    <li>Layanan legalisir dokumen resmi di SMK Negeri 1 Subang tidak dipungut biaya retribusi (<strong>GRATIS</strong>).</li>
                </ol>
            </div>

            <!-- Signatures Section -->
            <div class="pt-6 grid grid-cols-2 gap-8 text-center text-xs">
                <div>
                    <p class="text-slate-500">Pemohon / Pengaju Legalisir,</p>
                    <div class="h-16"></div>
                    <p class="font-bold text-slate-900 uppercase underline">{{ $pengajuan->nama_pemohon }}</p>
                    <p class="text-[10px] text-slate-500 font-mono">NISN. {{ $pengajuan->nisn }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Subang, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="text-slate-500">Petugas Loket Tata Usaha SMKN 1 Subang,</p>
                    <div class="h-16"></div>
                    <p class="font-bold text-slate-900 uppercase underline">
                        {{ $pengajuan->petugas->name ?? 'Petugas Tata Usaha' }}
                    </p>
                    <p class="text-[10px] text-slate-500 font-mono">
                        {{ $pengajuan->petugas?->nip_nisn ? 'NIP. ' . $pengajuan->petugas->nip_nisn : 'Staf Kearsipan SMEA' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-slate-200 flex items-center justify-between text-[10px] text-slate-400">
            <span>Sistem Informasi Tata Kelola Arsip & Layanan Legalisir SMKN 1 Subang (SMEA)</span>
            <span class="font-mono">Dicetak otomatis: {{ now()->format('d/m/Y H:i:s') }}</span>
        </div>
    </div>

</body>
</html>
