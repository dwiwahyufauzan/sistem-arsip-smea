<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Keabsahan Legalisir - {{ $pengajuan->nomor_pengajuan }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased py-8 px-4 sm:px-6 lg:px-8 font-sans">

    <div class="max-w-2xl mx-auto">
        <!-- Brand Header Resmi SMKN 1 Subang -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden">
            <!-- Kop Instansi Kedinasan -->
            <div class="bg-slate-900 text-white p-6 sm:p-8 text-center relative overflow-hidden">
                <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-teal-600/20 rounded-full blur-2xl pointer-events-none"></div>
                <div class="flex items-center justify-center gap-3 sm:gap-4 mb-3">
                    <img src="{{ asset('images/logo-pemda-jabar.png') }}" alt="Logo Pemda Jabar" class="w-12 h-14 object-contain drop-shadow-sm">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-12 h-14 object-contain drop-shadow-sm">
                </div>
                <p class="text-[11px] font-bold tracking-widest text-slate-300 uppercase">Pemerintah Daerah Provinsi Jawa Barat</p>
                <p class="text-xs font-semibold text-slate-300">Dinas Pendidikan • Cabang Dinas Pendidikan Wilayah IV</p>
                <h1 class="text-base sm:text-lg font-extrabold uppercase tracking-tight text-white mt-1">SMK NEGERI 1 SUBANG</h1>
                <p class="text-[11px] text-slate-400 mt-1 font-mono">Layanan Legalisir Ijazah & Dokumen Akademik Online (SMEA)</p>
            </div>

            <!-- Status Banner Keabsahan -->
            <div class="p-6 sm:p-8">
                @if($isSah)
                    <div class="bg-teal-50 border-2 border-teal-500/80 rounded-2xl p-5 mb-6 text-center shadow-xs">
                        <div class="w-14 h-14 rounded-full bg-teal-600 text-white flex items-center justify-center mx-auto mb-3 shadow-md">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="inline-block px-3 py-1 bg-teal-600 text-white text-xs font-black uppercase tracking-wider rounded-full mb-1">
                            Bukti Sah & Terdaftar
                        </span>
                        <h2 class="text-lg sm:text-xl font-black text-teal-950 mt-1">LEGALISIR RESMI SMKN 1 SUBANG</h2>
                        <p class="text-xs text-teal-800 mt-1 max-w-md mx-auto leading-relaxed">
                            Pengajuan berkas legalisir ini sah dan telah melalui verifikasi berkas oleh Subbag Tata Usaha SMKN 1 Subang.
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
                            Status: {{ strtoupper(str_replace('_', ' ', $pengajuan->status)) }}
                        </span>
                        <h2 class="text-lg font-black text-amber-950 mt-1">STATUS SEDANG DIPROSES</h2>
                        <p class="text-xs text-amber-800 mt-1 max-w-md mx-auto">
                            Pengajuan ini belum selesai atau sedang menunggu tindak lanjut dari staf verifikator.
                        </p>
                    </div>
                @endif

                <!-- Rincian Identitas Permohonan -->
                <div class="space-y-4 text-xs">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 pb-2 border-b border-slate-200">
                        Rincian Berkas Legalisir
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                            <span class="text-[10px] font-semibold uppercase text-slate-400 block">Nomor Registrasi Pengajuan</span>
                            <span class="font-mono font-bold text-slate-900 text-sm mt-0.5 block">{{ $pengajuan->nomor_pengajuan }}</span>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                            <span class="text-[10px] font-semibold uppercase text-slate-400 block">Status Terkini</span>
                            <span class="font-bold text-teal-800 uppercase mt-0.5 block">{{ str_replace('_', ' ', $pengajuan->status) }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                            <span class="text-[10px] font-semibold uppercase text-slate-400 block">Nama Pemohon (Alumni/Siswa)</span>
                            <p class="font-bold text-slate-900 text-sm mt-0.5">{{ $pengajuan->nama_pemohon }}</p>
                        </div>
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                            <span class="text-[10px] font-semibold uppercase text-slate-400 block">Nomor Induk Siswa Nasional (NISN)</span>
                            <p class="font-mono font-bold text-slate-900 text-sm mt-0.5">{{ $pengajuan->nisn }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                            <span class="text-[10px] font-semibold uppercase text-slate-400 block">Jenis Dokumen</span>
                            <span class="font-semibold text-slate-900 mt-0.5 block capitalize">{{ str_replace('_', ' ', $pengajuan->jenis_dokumen) }}</span>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                            <span class="text-[10px] font-semibold uppercase text-slate-400 block">Tahun Kelulusan</span>
                            <span class="font-semibold text-slate-900 mt-0.5 block">{{ $pengajuan->tahun_lulus }}</span>
                        </div>
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                            <span class="text-[10px] font-semibold uppercase text-slate-400 block">Jumlah Lembar</span>
                            <span class="font-semibold text-slate-900 mt-0.5 block">{{ $pengajuan->jumlah_lembar }} Lembar</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
                        <span class="text-[10px] font-semibold uppercase text-slate-400 block">Keperluan Legalisir</span>
                        <p class="text-slate-700 mt-0.5">{{ $pengajuan->keperluan }}</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-gradient-to-br from-slate-50 to-teal-50/40 border border-teal-200/80">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-teal-800 text-white flex items-center justify-center shrink-0 shadow-xs font-bold text-xs">
                                TU
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-teal-800 block">Petugas Verifikasi Subbag Tata Usaha</span>
                                <p class="text-sm font-bold text-slate-900 mt-0.5">{{ $pengajuan->petugas->name ?? 'Staf Tata Usaha SMKN 1 Subang' }}</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">Tanggal Registrasi: {{ $pengajuan->created_at->isoFormat('D MMMM Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-between text-[11px] text-slate-500 font-mono">
                        <span>Waktu Verifikasi Sistem:</span>
                        <span class="font-semibold text-slate-700">{{ now()->isoFormat('D MMMM Y, HH:mm:ss') }} WIB</span>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('landing') }}" class="flex-1 py-3 px-4 rounded-xl text-center text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                        Kembali ke Portal Beranda
                    </a>
                    <a href="{{ route('legalisir.tracking') }}?nomor={{ $pengajuan->nomor_pengajuan }}" class="flex-1 py-3 px-4 rounded-xl text-center text-xs font-bold bg-teal-800 hover:bg-teal-700 text-white shadow-xs transition-colors">
                        Lacak Status & Tracking Berkas
                    </a>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            &copy; {{ date('Y') }} SMK Negeri 1 Subang • Sistem Verifikasi Dokumen Kearsipan Kedinasan
        </p>
    </div>

</body>
</html>
