@extends('layouts.pemohon')

@section('title', 'Dashboard Pemohon')

@section('content')
<div class="space-y-8">

    <!-- Official Hero Canvas Alumni (Konsisten dengan Landing Page) -->
    <div class="relative bg-gradient-to-br from-slate-950 via-[#0B1528] to-[#0A192F] text-white rounded-3xl p-6 sm:p-8 overflow-hidden shadow-xl border border-slate-800">
        <!-- Radial Dot Background & Ambient Glow -->
        <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
        <div class="absolute -top-16 -right-16 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -left-16 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2.5 max-w-2xl">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-teal-500/20 text-teal-300 ring-1 ring-teal-400/40">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-ping"></span>
                        Portal Alumni • Layanan Mandiri
                    </span>
                    @if(auth()->user()->nip_nisn)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-mono text-slate-300 bg-white/10 border border-white/15">
                            NISN: {{ auth()->user()->nip_nisn }}
                        </span>
                    @endif
                </div>

                <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-white tracking-tight">
                    Portal Layanan Legalisir Alumni
                </h1>

                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Selamat datang, <strong class="text-white">{{ auth()->user()->name }}</strong>. Ajukan permohonan legalisir ijazah atau transkrip nilai resmi SMKN 1 Subang dan pantau perkembangan status verifikasi secara langsung tanpa harus antre di sekolah.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row md:flex-col lg:flex-row items-stretch sm:items-center gap-3 shrink-0">
                <a 
                    href="{{ url('/pemohon/legalisir/create') }}" 
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-teal-500 hover:bg-teal-400 text-slate-950 font-heading font-extrabold text-xs sm:text-sm shadow-lg shadow-teal-500/20 transition-all cursor-pointer active:scale-98"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span>Ajukan Legalisir Baru</span>
                </a>

                <a 
                    href="{{ route('landing') }}#lacak" 
                    target="_blank"
                    class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-white/10 hover:bg-white/15 text-white font-bold text-xs border border-white/20 transition-all"
                >
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Lacak Publik</span>
                </a>
            </div>
        </div>
    </div>

    @php
        $myPengajuan = auth()->user()->pengajuanLegalisir()->with('riwayat')->latest()->get();
        $inProgressCount = $myPengajuan->whereNotIn('status', ['selesai', 'ditolak'])->count();
        $readyToPickup = $myPengajuan->where('status', 'siap_diambil');
    @endphp

    <!-- Ready for Pickup Alert -->
    @if($readyToPickup->count() > 0)
        <div class="p-5 sm:p-6 rounded-3xl bg-emerald-50/90 border border-emerald-300 text-emerald-950 flex items-start gap-4 shadow-sm animate-in fade-in duration-300">
            <div class="w-11 h-11 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-emerald-600/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="text-xs space-y-1">
                <h3 class="font-heading font-bold text-sm sm:text-base text-emerald-900">Dokumen Anda Sudah Siap Diambil di Sekolah!</h3>
                <p class="text-emerald-800 leading-relaxed">
                    Terdapat <span class="font-bold underline">{{ $readyToPickup->count() }} pengajuan</span> yang telah selesai diverifikasi dan distempel basah. Silakan datang ke Ruang Tata Usaha SMKN 1 Subang pada jam operasional (Senin - Jumat 07.30 - 15.30 WIB) dengan menunjukkan nomor pengajuan Anda.
                </p>
            </div>
        </div>
    @endif

    <!-- Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
        <x-stat-card 
            label="Total Pengajuan Saya"
            :value="number_format($myPengajuan->count())"
            sub="Seluruh permohonan tercatat"
            color="teal"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card 
            label="Sedang Diproses"
            :value="number_format($inProgressCount)"
            sub="Tahap verifikasi & stempel"
            color="blue"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card 
            label="Siap Diambil"
            :value="number_format($readyToPickup->count())"
            sub="Di Ruang Tata Usaha"
            color="emerald"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </x-slot:icon>
        </x-stat-card>
    </div>

    <!-- Submissions Table Card -->
    <div class="bg-white/95 backdrop-blur-xl rounded-3xl border border-slate-200/90 shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-gradient-to-r from-slate-50 to-slate-100/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center font-bold text-xs ring-1 ring-teal-200">
                    <svg class="w-5 h-5 text-teal-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <div>
                    <h3 class="font-heading font-bold text-base text-slate-900">Daftar Pengajuan Legalisir Anda</h3>
                    <p class="text-xs text-slate-500">Pantau perkembangan status pengesahan berkas Anda secara berkala</p>
                </div>
            </div>
            <a href="{{ url('/pemohon/legalisir/create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-teal-800 bg-teal-50 hover:bg-teal-100 border border-teal-200 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                <span>Permohonan Baru</span>
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($myPengajuan as $pengajuan)
                <div class="p-5 sm:p-6 hover:bg-slate-50/80 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-4 text-xs">
                    <div class="space-y-2 flex-grow">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <span class="font-mono font-bold text-sm text-slate-900 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200">{{ $pengajuan->nomor_pengajuan }}</span>
                            <x-status-badge :status="$pengajuan->status" type="legalisir" />
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm">{{ strtoupper($pengajuan->jenis_dokumen) }} ({{ $pengajuan->jumlah_lembar }} Lembar)</h4>
                        <p class="text-slate-600">Keperluan: {{ $pengajuan->keperluan }}</p>
                        <div class="flex items-center gap-3 text-[11px] text-slate-400 flex-wrap">
                            <span>Diajukan: {{ $pengajuan->created_at->format('d M Y, H:i') }} WIB</span>
                            @if($pengajuan->tanggal_siap_ambil)
                                <span>&bull;</span>
                                <span class="font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">Estimasi Siap: {{ \Carbon\Carbon::parse($pengajuan->tanggal_siap_ambil)->format('d M Y') }}</span>
                            @endif
                        </div>
                        @if($pengajuan->catatan_petugas)
                            <div class="mt-2 p-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-xs">
                                <span class="font-semibold text-slate-900">Catatan Petugas TU:</span> {{ $pengajuan->catatan_petugas }}
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 shrink-0 flex-wrap">
                        @if($pengajuan->file_dokumen_path)
                            <button 
                                type="button" 
                                onclick="window.openPdfModal('{{ asset('storage/' . $pengajuan->file_dokumen_path) }}', 'Berkas: {{ addslashes($pengajuan->nama_pemohon) }}')"
                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-50 hover:bg-teal-50 text-slate-700 hover:text-teal-800 border border-slate-200 font-semibold transition-colors cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>Pratinjau Berkas</span>
                            </button>
                        @endif

                        <a 
                            href="{{ route('landing') }}?nomor_pengajuan={{ $pengajuan->nomor_pengajuan }}#lacak" 
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-900 border border-blue-200 font-semibold transition-colors"
                        >
                            <span>Lacak Publik</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <x-empty-state 
                    title="Belum Ada Pengajuan"
                    description="Anda belum pernah mengajukan legalisir dokumen. Klik tombol di bawah untuk memulai."
                    actionText="Ajukan Legalisir Sekarang"
                    :actionUrl="url('/pemohon/legalisir/create')"
                />
            @endforelse
        </div>
    </div>

</div>
@endsection
