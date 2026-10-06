@extends('layouts.pemohon')

@section('title', 'Permohonan Legalisir Saya')

@section('content')
<div class="space-y-6">

    <!-- Modern Page Header -->
    <x-page-header 
        title="Riwayat & Pelacakan Permohonan Legalisir" 
        subtitle="Pantau perkembangan verifikasi berkas alumni secara transparan dan unduh bukti tanda terima."
        overline="Portal Alumni • Layanan Mandiri"
        theme="teal"
    >
        <x-slot:actions>
            <a href="{{ route('legalisir.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-bold text-white bg-teal-700 hover:bg-teal-800 rounded-xl shadow-xs transition-all active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Ajukan Legalisir Baru</span>
            </a>
        </x-slot:actions>
    </x-page-header>

    <!-- Stat Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white/95 backdrop-blur-xl rounded-2xl border border-slate-200/90 shadow-xs p-4.5 hover:shadow-md transition-shadow">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Pengajuan</span>
            <div class="text-2xl font-extrabold font-heading text-slate-900 mt-1">{{ $stats['total'] }}</div>
            <span class="text-[11px] text-slate-400">Seluruh riwayat berkas</span>
        </div>

        <div class="bg-white/95 backdrop-blur-xl rounded-2xl border border-amber-200/90 shadow-xs p-4.5 bg-amber-50/20 hover:shadow-md transition-shadow">
            <span class="text-xs font-semibold text-amber-700 uppercase tracking-wider block">Menunggu Verifikasi</span>
            <div class="text-2xl font-extrabold font-heading text-amber-600 mt-1">{{ $stats['menunggu'] }}</div>
            <span class="text-[11px] text-amber-700/80">Antrean staf Tata Usaha</span>
        </div>

        <div class="bg-white/95 backdrop-blur-xl rounded-2xl border border-purple-200/90 shadow-xs p-4.5 bg-purple-50/20 hover:shadow-md transition-shadow">
            <span class="text-xs font-semibold text-purple-700 uppercase tracking-wider block">Diproses & Cap</span>
            <div class="text-2xl font-extrabold font-heading text-purple-600 mt-1">{{ $stats['proses'] }}</div>
            <span class="text-[11px] text-purple-700/80">Pencetakan & stempel</span>
        </div>

        <div class="bg-white/95 backdrop-blur-xl rounded-2xl border border-emerald-300 shadow-xs p-4.5 bg-emerald-50/40 hover:shadow-md transition-shadow">
            <span class="text-xs font-semibold text-emerald-800 uppercase tracking-wider block">Siap Diambil</span>
            <div class="text-2xl font-extrabold font-heading text-emerald-700 mt-1">{{ $stats['siap_ambil'] }}</div>
            <span class="text-[11px] text-emerald-800 font-semibold">Tersedia di Loket TU</span>
        </div>
    </div>

    <!-- Table of Applications -->
    <div class="bg-white/95 backdrop-blur-xl rounded-3xl border border-slate-200/90 shadow-xl overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-slate-50 to-slate-100/60">
            <div>
                <h3 class="font-heading font-bold text-base text-slate-900">Daftar Permohonan Legalisir Anda</h3>
                <p class="text-xs text-slate-500">Kelola dan pantau seluruh status permohonan legalisir resmi Anda</p>
            </div>
            <span class="text-xs font-bold text-slate-600 bg-white px-3 py-1 rounded-full border border-slate-200">{{ $pengajuans->total() }} data ditemukan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-5">No. Resi & Tanggal</th>
                        <th class="py-3.5 px-5">Dokumen yang Dilegalisir</th>
                        <th class="py-3.5 px-5">Jumlah Lembar</th>
                        <th class="py-3.5 px-5">Status Pengajuan</th>
                        <th class="py-3.5 px-5">Kesiapan Ambil</th>
                        <th class="py-3.5 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($pengajuans as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-5">
                                <span class="font-mono font-bold text-teal-800 block text-xs">{{ $item->nomor_pengajuan }}</span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</span>
                            </td>
                            <td class="py-4 px-5">
                                <span class="font-bold text-slate-900 block">{{ $item->jenis_dokumen_label }}</span>
                                <span class="text-[11px] text-slate-500 block truncate max-w-xs">{{ $item->keperluan }}</span>
                            </td>
                            <td class="py-4 px-5 font-semibold text-slate-700">
                                {{ $item->jumlah_lembar }} Lembar
                            </td>
                            <td class="py-4 px-5">
                                <x-status-badge :status="$item->status" type="legalisir" />
                                @if($item->status === 'ditolak')
                                    <p class="text-[10px] text-rose-600 mt-1 max-w-xs truncate" title="{{ $item->catatan_petugas ?? $item->catatan_kepsek }}">
                                        Catatan: {{ $item->catatan_petugas ?? $item->catatan_kepsek ?? 'Berkas ditolak' }}
                                    </p>
                                @endif
                            </td>
                            <td class="py-4 px-5">
                                @if($item->tanggal_siap_ambil)
                                    <span class="inline-flex items-center gap-1 font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-lg border border-emerald-200">
                                        {{ $item->tanggal_siap_ambil->translatedFormat('d M Y') }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Dalam proses verifikasi</span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <a 
                                        href="{{ route('pemohon.legalisir.show', $item->id) }}" 
                                        class="px-3.5 py-1.5 bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200/70 rounded-xl font-bold text-xs transition-colors"
                                    >
                                        Lacak Status
                                    </a>
                                    <a 
                                        href="{{ route('legalisir.tanda-terima', $item->nomor_pengajuan) }}" 
                                        class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors"
                                        title="Cetak Tanda Terima"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-empty-state 
                            colspan="6" 
                            title="Belum ada pengajuan legalisir" 
                            description="Anda belum mengajukan legalisir dokumen ke SMKN 1 Subang." 
                            :action-url="route('legalisir.create')"
                            action-text="+ Ajukan Legalisir Baru"
                        />
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengajuans->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $pengajuans->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
