@extends('layouts.pemohon')

@section('title', 'Dashboard Pemohon')

@section('content')
<div class="space-y-6">

    <!-- Modern Page Header -->
    <x-page-header 
        title="Portal Layanan Legalisir Alumni" 
        description="Ajukan permohonan legalisir ijazah atau transkrip nilai dan pantau status verifikasi secara langsung."
        badge="Portal Alumni • Layanan Mandiri"
        theme="teal"
    >
        <x-slot:actions>
            <a href="{{ url('/pemohon/legalisir/create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-bold text-white bg-teal-700 hover:bg-teal-800 rounded-xl shadow-xs transition-all active:scale-[0.98] cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Ajukan Legalisir Baru</span>
            </a>
        </x-slot:actions>
    </x-page-header>

    @php
        $myPengajuan = auth()->user()->pengajuanLegalisir()->with('riwayat')->latest()->get();
        $inProgressCount = $myPengajuan->whereNotIn('status', ['selesai', 'ditolak'])->count();
        $readyToPickup = $myPengajuan->where('status', 'siap_diambil');
    @endphp

    <!-- Ready for Pickup Alert -->
    @if($readyToPickup->count() > 0)
        <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-950 flex items-start gap-3.5 shadow-xs">
            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div class="text-xs">
                <h3 class="font-bold text-sm text-emerald-900">Dokumen Anda Sudah Siap Diambil di Sekolah!</h3>
                <p class="mt-0.5 text-emerald-800 leading-relaxed">
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
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div>
                <h3 class="font-bold text-base text-slate-900">Daftar Pengajuan Legalisir Anda</h3>
                <p class="text-xs text-slate-500">Pantau perkembangan status pengesahan berkas Anda secara berkala</p>
            </div>
            <a href="{{ url('/pemohon/legalisir/create') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700 transition-colors">+ Permohonan Baru</a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($myPengajuan as $pengajuan)
                <div class="p-5 hover:bg-slate-50/80 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-4 text-xs">
                    <div class="space-y-1.5 flex-grow">
                        <div class="flex items-center gap-2">
                            <span class="font-mono font-bold text-sm text-slate-900">{{ $pengajuan->nomor_pengajuan }}</span>
                            <x-status-badge :status="$pengajuan->status" type="legalisir" />
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm">{{ strtoupper($pengajuan->jenis_dokumen) }} ({{ $pengajuan->jumlah_lembar }} Lembar)</h4>
                        <p class="text-slate-600">Keperluan: {{ $pengajuan->keperluan }}</p>
                        <div class="flex items-center gap-3 text-[11px] text-slate-400">
                            <span>Diajukan: {{ $pengajuan->created_at->format('d M Y, H:i') }} WIB</span>
                            @if($pengajuan->tanggal_siap_ambil)
                                <span>&bull;</span>
                                <span class="font-semibold text-emerald-700">Estimasi Siap: {{ \Carbon\Carbon::parse($pengajuan->tanggal_siap_ambil)->format('d M Y') }}</span>
                            @endif
                        </div>
                        @if($pengajuan->catatan_petugas)
                            <div class="mt-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-xs">
                                <span class="font-semibold text-slate-900">Catatan Petugas TU:</span> {{ $pengajuan->catatan_petugas }}
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        @if($pengajuan->file_dokumen_path)
                            <button 
                                type="button" 
                                onclick="window.openPdfModal('{{ asset('storage/' . $pengajuan->file_dokumen_path) }}', 'Berkas: {{ addslashes($pengajuan->nama_pemohon) }}')"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-teal-50 text-slate-700 hover:text-teal-700 border border-slate-200 font-semibold transition-colors cursor-pointer"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>Pratinjau Berkas</span>
                            </button>
                        @endif

                        <a 
                            href="{{ route('landing') }}?nomor_pengajuan={{ $pengajuan->nomor_pengajuan }}#lacak" 
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 font-semibold transition-colors"
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
