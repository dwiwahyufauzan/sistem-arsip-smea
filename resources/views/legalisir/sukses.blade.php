<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Permohonan Terkirim - {{ $pengajuan->nomor_pengajuan }} | SMKN 1 Subang</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-smk.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 text-slate-800 antialiased bg-slate-100/70">

    <div class="max-w-xl w-full bg-white rounded-3xl border border-slate-200/80 shadow-xl overflow-hidden p-6 sm:p-10 text-center space-y-6 animate-in fade-in zoom-in-95 duration-200">

        <!-- Logo SMKN 1 Subang -->
        <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-14 h-16 mx-auto object-contain drop-shadow-xs">

        <!-- Success Animated Icon -->
        <div class="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-600 border border-emerald-200/60 flex items-center justify-center mx-auto shadow-md shadow-emerald-500/10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>

        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                Permohonan Berhasil Terkirim
            </span>
            <h1 class="font-heading font-extrabold text-xl sm:text-2xl text-slate-900 mt-2">
                Terima Kasih, {{ $pengajuan->nama_pemohon }}!
            </h1>
            <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">
                Pengajuan legalisir dokumen Anda telah diterima oleh sistem kearsipan SMKN 1 Subang dan sedang dalam antrean verifikasi petugas Tata Usaha.
            </p>
        </div>

        <!-- Nomor Resi Card (Prominent) -->
        <div class="p-5 rounded-2xl bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 text-white shadow-lg space-y-2">
            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Kode Resi Pelacakan Anda</span>
            <div class="flex items-center justify-center gap-3">
                <span id="resiCode" class="font-mono font-black text-xl sm:text-2xl tracking-wider text-teal-300">
                    {{ $pengajuan->nomor_pengajuan }}
                </span>
                <button 
                    type="button" 
                    onclick="copyResi()" 
                    class="p-2 rounded-xl bg-white/10 hover:bg-white/20 text-white transition-colors cursor-pointer"
                    title="Salin Kode Resi"
                >
                    <svg id="copyIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span id="copiedToast" class="hidden text-[10px] font-bold text-emerald-300">Tersalin!</span>
                </button>
            </div>
            <p class="text-[11px] text-slate-300">
                Simpan nomor resi ini untuk melacak status dokumen Anda secara berkala.
            </p>
        </div>

        <!-- Ringkasan Data -->
        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/80 text-left text-xs space-y-2">
            <div class="flex justify-between py-1 border-b border-slate-200/60">
                <span class="text-slate-400">Jenis Dokumen:</span>
                <span class="font-bold text-slate-800">{{ $pengajuan->jenis_dokumen_label }}</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-200/60">
                <span class="text-slate-400">Jumlah Lembar:</span>
                <span class="font-semibold text-slate-800">{{ $pengajuan->jumlah_lembar }} Lembar</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-200/60">
                <span class="text-slate-400">NISN / Tahun Lulus:</span>
                <span class="font-mono text-slate-800">{{ $pengajuan->nisn }} (Lulus {{ $pengajuan->tahun_lulus }})</span>
            </div>
            <div class="flex justify-between py-1">
                <span class="text-slate-400">Status Saat Ini:</span>
                <x-status-badge :status="$pengajuan->status" />
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-2.5 pt-2">
            <a 
                href="{{ route('legalisir.tracking', ['nomor_pengajuan' => $pengajuan->nomor_pengajuan]) }}" 
                class="w-full py-3 px-4 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs shadow-md shadow-blue-700/20 transition-all flex items-center justify-center gap-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Lacak Status Permohonan (Live Tracking)</span>
            </a>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                <a 
                    href="{{ route('legalisir.tanda-terima', $pengajuan->nomor_pengajuan) }}" 
                    target="_blank"
                    class="py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition-colors flex items-center justify-center gap-1.5"
                >
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak Tanda Terima</span>
                </a>

                <a 
                    href="{{ route('landing') }}" 
                    class="py-2.5 px-4 rounded-xl bg-white hover:bg-slate-50 text-slate-600 font-semibold text-xs border border-slate-200 transition-colors flex items-center justify-center"
                >
                    Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>

    <script>
        function copyResi() {
            const resi = document.getElementById('resiCode').textContent.trim();
            navigator.clipboard.writeText(resi).then(() => {
                document.getElementById('copyIcon').classList.add('hidden');
                document.getElementById('copiedToast').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('copyIcon').classList.remove('hidden');
                    document.getElementById('copiedToast').classList.add('hidden');
                }, 2000);
            });
        }
    </script>
</body>
</html>
