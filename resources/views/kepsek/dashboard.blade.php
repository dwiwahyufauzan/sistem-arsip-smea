@extends('layouts.kepsek')

@section('title', 'Dashboard Pimpinan')

@section('content')
<div class="space-y-6">

    <!-- Modern Page Header -->
    <x-page-header 
        title="Panel Eksekutif Kepala Sekolah" 
        description="Pengawasan tata kelola kearsipan dinas, disposisi pimpinan, dan otoritas pengesahan dokumen"
        badge="Pusat Kendali Pimpinan"
        theme="emerald"
    >
        <x-slot:actions>
            <a href="{{ url('/kepala-sekolah/surat-keluar') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-semibold text-white bg-emerald-700 hover:bg-emerald-800 rounded-xl shadow-sm shadow-emerald-700/20 active:scale-[0.98] transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Antrean Persetujuan</span>
            </a>
            <a href="{{ url('/kepala-sekolah/pencarian-kmp') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl shadow-xs active:scale-[0.98] transition-all cursor-pointer">
                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Pencarian Arsip</span>
            </a>
        </x-slot:actions>
    </x-page-header>

    @php
        $pendingSk = \App\Models\SuratKeluar::where('status_persetujuan', 'menunggu_persetujuan')->get();
        $pendingLeg = \App\Models\PengajuanLegalisir::where('status', 'diverifikasi')->get();
        $suratMasukCount = \App\Models\SuratMasuk::count();
        $suratKeluarCount = \App\Models\SuratKeluar::count();
    @endphp

    <!-- Executive Action Alert if Any Pending Items -->
    @if($pendingSk->count() > 0 || $pendingLeg->count() > 0)
        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-950 flex items-start gap-3 shadow-xs">
            <div class="w-9 h-9 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center shrink-0 font-extrabold text-sm shadow-xs">
                !
            </div>
            <div class="text-xs">
                <h3 class="font-bold text-sm text-amber-900">Perhatian: Memerlukan Tindakan Pimpinan</h3>
                <p class="mt-0.5 text-amber-800">
                    Terdapat <span class="font-bold underline">{{ $pendingSk->count() }} draf surat keluar</span> dan <span class="font-bold underline">{{ $pendingLeg->count() }} berkas legalisir</span> yang menunggu persetujuan dan pengesahan Anda hari ini.
                </p>
            </div>
        </div>
    @endif

    <!-- Executive Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Metric 1: Pending Surat Keluar -->
        <x-stat-card 
            label="Antrean Surat Keluar"
            :value="number_format($pendingSk->count())"
            sub="Menunggu persetujuan kepsek"
            :color="$pendingSk->count() > 0 ? 'amber' : 'slate'"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <!-- Metric 2: Pending Legalisir -->
        <x-stat-card 
            label="Antrean Legalisir"
            :value="number_format($pendingLeg->count())"
            sub="Berkas siap disahkan"
            :color="$pendingLeg->count() > 0 ? 'purple' : 'slate'"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <!-- Metric 3: Total Surat Masuk -->
        <x-stat-card 
            label="Surat Masuk"
            :value="number_format($suratMasukCount)"
            sub="Total arsip diterima dinas"
            color="blue"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <!-- Metric 4: Total Surat Keluar Resmi -->
        <x-stat-card 
            label="Surat Keluar"
            :value="number_format($suratKeluarCount)"
            sub="Diterbitkan resmi ke publik"
            color="emerald"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </x-slot:icon>
        </x-stat-card>
    </div>

    <!-- Antrean Persetujuan Split-View List -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Left: Draf Surat Keluar Menunggu Approval -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="font-bold text-sm text-slate-900">Draf Surat Keluar Menunggu Approval</h3>
                    <p class="text-xs text-slate-500">Periksa isi draf sebelum surat resmi disahkan</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                    {{ $pendingSk->count() }} Berkas
                </span>
            </div>

            <div class="divide-y divide-slate-100 flex-grow">
                @forelse($pendingSk as $sk)
                    <div class="p-4 hover:bg-slate-50/80 transition-colors flex items-start justify-between gap-3 text-xs">
                        <div class="space-y-1 overflow-hidden">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-slate-900">{{ $sk->nomor_agenda }}</span>
                                <x-status-badge :status="$sk->status_persetujuan" type="surat_keluar" />
                            </div>
                            <h4 class="font-semibold text-slate-800 truncate" title="{{ $sk->perihal }}">{{ $sk->perihal }}</h4>
                            <p class="text-slate-500 truncate">Tujuan: {{ $sk->tujuan }}</p>
                            <span class="text-[10px] text-slate-400 font-mono">Tanggal: {{ \Carbon\Carbon::parse($sk->tanggal_surat)->format('d M Y') }}</span>
                        </div>

                        <div class="flex items-center gap-1.5 shrink-0">
                            @if($sk->file_path)
                                <button 
                                    type="button" 
                                    onclick="window.openPdfModal('{{ asset('storage/' . $sk->file_path) }}', 'Draf: {{ addslashes($sk->perihal) }}')"
                                    class="p-2 rounded-xl bg-slate-50 hover:bg-emerald-50 text-slate-500 hover:text-emerald-700 border border-slate-200 transition-colors cursor-pointer"
                                    title="Pratinjau Draf PDF"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            @endif
                            <a 
                                href="{{ url('/kepala-sekolah/surat-keluar/' . $sk->id) }}" 
                                class="px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-semibold border border-emerald-200 transition-colors"
                            >
                                Tinjau
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-xs text-slate-400">
                        <svg class="w-8 h-8 mx-auto text-emerald-500 mb-2 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Tidak ada antrean draf surat keluar. Semua telah disetujui.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Pengesahan Legalisir Menunggu -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="font-bold text-sm text-slate-900">Pengesahan Legalisir Ijazah</h3>
                    <p class="text-xs text-slate-500">Berkas alumni yang telah lolos verifikasi berkas oleh TU</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-purple-50 text-purple-800 border border-purple-200">
                    {{ $pendingLeg->count() }} Permohonan
                </span>
            </div>

            <div class="divide-y divide-slate-100 flex-grow">
                @forelse($pendingLeg as $leg)
                    <div class="p-4 hover:bg-slate-50/80 transition-colors flex items-start justify-between gap-3 text-xs">
                        <div class="space-y-1 overflow-hidden">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-purple-700">{{ $leg->nomor_pengajuan }}</span>
                                <x-status-badge :status="$leg->status" type="legalisir" />
                            </div>
                            <h4 class="font-semibold text-slate-800">{{ $leg->nama_pemohon }} <span class="font-mono text-slate-400">(Lulus {{ $leg->tahun_lulus }})</span></h4>
                            <p class="text-slate-500">{{ strtoupper($leg->jenis_dokumen) }} ({{ $leg->jumlah_lembar }} Lembar) &bull; Keperluan: {{ $leg->keperluan }}</p>
                            <span class="text-[10px] text-slate-400">Verifikator: Petugas Tata Usaha</span>
                        </div>

                        <div class="flex items-center gap-1.5 shrink-0">
                            @if($leg->file_dokumen_path)
                                <button 
                                    type="button" 
                                    onclick="window.openPdfModal('{{ asset('storage/' . $leg->file_dokumen_path) }}', 'Berkas: {{ addslashes($leg->nama_pemohon) }}')"
                                    class="p-2 rounded-xl bg-slate-50 hover:bg-purple-50 text-slate-500 hover:text-purple-700 border border-slate-200 transition-colors cursor-pointer"
                                    title="Pratinjau Berkas Ijazah"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            @endif
                            <a 
                                href="{{ url('/kepala-sekolah/legalisir/' . $leg->id) }}" 
                                class="px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-semibold border border-emerald-200 transition-colors"
                            >
                                Sahkan
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-xs text-slate-400">
                        <svg class="w-8 h-8 mx-auto text-purple-500 mb-2 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Tidak ada antrean pengesahan legalisir saat ini.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
