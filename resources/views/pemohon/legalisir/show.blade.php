@extends('layouts.pemohon')

@section('title', 'Detail Permohonan - ' . $legalisir->nomor_pengajuan)
@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="bg-white/95 backdrop-blur-xl p-6 rounded-3xl border border-slate-200/90 shadow-xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                    <a href="{{ route('pemohon.legalisir.index') }}" class="hover:text-teal-700 transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        <span>Daftar Permohonan</span>
                    </a>
                    <span>•</span>
                    <span class="text-teal-800 font-mono font-bold">{{ $legalisir->nomor_pengajuan }}</span>
                </div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h2 class="text-xl sm:text-2xl font-extrabold font-heading text-slate-900">
                        {{ $legalisir->jenis_dokumen_label }} ({{ $legalisir->jumlah_lembar }} Lembar)
                    </h2>
                    <x-status-badge :status="$legalisir->status" type="legalisir" class="text-xs px-3 py-1" />
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    Diajukan pada {{ $legalisir->created_at->translatedFormat('l, d F Y, H:i') }} WIB.
                </p>
            </div>

            <div class="flex items-center gap-2.5 flex-wrap">
                <a 
                    href="{{ route('legalisir.tanda-terima', $legalisir->nomor_pengajuan) }}" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-xl shadow-xs transition-colors"
                >
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak Tanda Terima</span>
                </a>

                <a 
                    href="{{ route('legalisir.download', $legalisir->id) }}" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200/80 rounded-xl text-xs font-bold transition-colors"
                >
                    <svg class="w-4 h-4 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Berkas</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Ready for Pickup Banner (If status == siap_diambil) -->
    @if($legalisir->status === 'siap_diambil')
        <div class="p-6 rounded-3xl bg-emerald-50/90 border border-emerald-300 shadow-md flex items-start gap-4 animate-in fade-in duration-300">
            <div class="w-11 h-11 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-emerald-600/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="space-y-1">
                <h3 class="font-heading font-bold text-emerald-950 text-base">Dokumen Fisik Legalisir Telah Siap Diambil!</h3>
                <p class="text-xs text-emerald-800 leading-relaxed">
                    Silakan datang ke Loket Pelayanan Tata Usaha SMKN 1 Subang dengan menunjukkan nomor resi <strong class="font-mono bg-white px-2 py-0.5 rounded border border-emerald-300">{{ $legalisir->nomor_pengajuan }}</strong> dan kartu identitas diri Anda.
                </p>
            </div>
        </div>
    @endif

    <!-- Rejection Notice (If status == ditolak) -->
    @if($legalisir->status === 'ditolak')
        <div class="p-6 rounded-3xl bg-rose-50/90 border border-rose-300 shadow-md flex items-start gap-4 animate-in fade-in duration-300">
            <div class="w-11 h-11 rounded-2xl bg-rose-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-rose-600/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <div class="space-y-1">
                <h3 class="font-heading font-bold text-rose-950 text-base">Permohonan Legalisir Ditolak</h3>
                <p class="text-xs text-rose-800 leading-relaxed">
                    Alasan: {{ $legalisir->catatan_petugas ?? $legalisir->catatan_kepsek ?? 'Dokumen pindaian tidak sesuai dengan arsip buku induk sekolah.' }}
                </p>
            </div>
        </div>
    @endif

    <!-- Stepper Tracker Card -->
    <div class="bg-white/95 backdrop-blur-xl rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-xl">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-6 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-teal-500"></span>
            <span>Tahapan Proses Permohonan Legalisir</span>
        </h3>

        @php
            $statusRank = [
                'menunggu_verifikasi' => 1,
                'diverifikasi' => 2,
                'menunggu_approval_kepsek' => 2,
                'disetujui_kepsek' => 3,
                'sedang_diproses' => 4,
                'siap_diambil' => 5,
                'selesai' => 6,
                'ditolak' => -1,
            ];
            $currentRank = $statusRank[$legalisir->status] ?? 1;

            $steps = [
                1 => ['title' => 'Pengajuan', 'desc' => 'Diterima sistem'],
                2 => ['title' => 'Verifikasi TU', 'desc' => 'Pencocokan arsip'],
                3 => ['title' => 'Pengesahan', 'desc' => 'Kepala Sekolah'],
                4 => ['title' => 'Pencetakan', 'desc' => 'Stempel basah'],
                5 => ['title' => 'Siap Diambil', 'desc' => 'Loket TU SMEA'],
                6 => ['title' => 'Selesai', 'desc' => 'Sudah diserahkan'],
            ];
        @endphp

        <div class="relative">
            <div class="hidden md:block absolute top-5 left-6 right-6 h-1 bg-slate-200 -z-0">
                @php
                    $percent = $currentRank > 0 ? min(100, max(0, ($currentRank - 1) * 20)) : 0;
                @endphp
                <div class="h-1 bg-teal-600 transition-all duration-500" style="width: {{ $percent }}%;"></div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 relative z-10">
                @foreach($steps as $idx => $step)
                    @php
                        $isPast = $currentRank > $idx;
                        $isCurrent = $currentRank === $idx;
                        $isUpcoming = $currentRank < $idx;
                    @endphp
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold text-xs transition-all shadow-xs
                            {{ $isPast ? 'bg-teal-700 text-white' : '' }}
                            {{ $isCurrent ? 'bg-teal-800 text-white ring-4 ring-teal-100 ring-offset-2 scale-110 shadow-md' : '' }}
                            {{ $isUpcoming ? 'bg-white text-slate-400 border-2 border-slate-200' : '' }}
                            {{ $legalisir->status === 'ditolak' && $idx === 2 ? 'bg-rose-600 text-white ring-4 ring-rose-100' : '' }}
                        ">
                            @if($isPast)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @elseif($legalisir->status === 'ditolak' && $idx === 2)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            @else
                                {{ $idx }}
                            @endif
                        </div>
                        <h4 class="mt-3 text-xs font-bold {{ $isCurrent ? 'text-teal-900' : ($isPast ? 'text-slate-800' : 'text-slate-400') }}">
                            {{ $step['title'] }}
                        </h4>
                        <p class="text-[11px] text-slate-500 mt-0.5 leading-tight">
                            {{ $step['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Detail Information & Timeline Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        
        <!-- Left: Application Details -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl border border-slate-200/90 shadow-xl p-6 space-y-4">
            <h3 class="font-heading font-bold text-base text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Rincian Berkas Permohonan</span>
            </h3>

            <div class="space-y-3 text-xs">
                <div class="flex justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Nomor Resi Registrasi:</span>
                    <span class="font-mono font-bold text-teal-900 bg-teal-50 px-2 py-0.5 rounded border border-teal-200">{{ $legalisir->nomor_pengajuan }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Nama Pemohon:</span>
                    <span class="font-bold text-slate-900">{{ $legalisir->nama_pemohon }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">NISN / Tahun Lulus:</span>
                    <span class="font-mono text-slate-900">{{ $legalisir->nisn }} (Lulus {{ $legalisir->tahun_lulus }})</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Jenis Dokumen:</span>
                    <span class="font-bold text-slate-900">{{ $legalisir->jenis_dokumen_label }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Jumlah Lembar:</span>
                    <span class="font-bold text-slate-900">{{ $legalisir->jumlah_lembar }} Lembar</span>
                </div>
                <div class="py-1.5 border-b border-slate-100">
                    <span class="text-slate-500 font-medium block mb-1">Keperluan:</span>
                    <span class="text-slate-800 bg-slate-50 p-2.5 rounded-xl border border-slate-200 block">{{ $legalisir->keperluan }}</span>
                </div>
                @if($legalisir->tanggal_siap_ambil)
                    <div class="flex justify-between py-1.5 border-b border-slate-100 text-emerald-800">
                        <span class="font-medium">Jadwal Kesiapan Pengambilan:</span>
                        <span class="font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">{{ $legalisir->tanggal_siap_ambil->translatedFormat('d F Y') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Activity Timeline -->
        <div class="bg-white/95 backdrop-blur-xl rounded-3xl border border-slate-200/90 shadow-xl p-6 space-y-4">
            <h3 class="font-heading font-bold text-base text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Catatan & Jejak Status Berkas</span>
            </h3>

            <div class="flow-root">
                <ul role="list" class="-mb-8">
                    @forelse($legalisir->riwayat as $idx => $hist)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-teal-100 text-teal-800 flex items-center justify-center ring-8 ring-white">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <x-status-badge :status="$hist->status_baru" type="legalisir" />
                                            </div>
                                            <p class="text-xs text-slate-700 mt-1.5 leading-relaxed bg-slate-50 p-2.5 rounded-xl border border-slate-200/60">
                                                {{ $hist->catatan }}
                                            </p>
                                        </div>
                                        <div class="text-right text-xs whitespace-nowrap text-slate-400">
                                            <time datetime="{{ $hist->created_at }}">{{ $hist->created_at->translatedFormat('d M, H:i') }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-xs text-slate-500 py-3">Belum ada riwayat tercatat.</li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>

</div>
@endsection
