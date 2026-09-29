@extends('layouts.pemohon')

@section('title', 'Permohonan Legalisir Saya')
@section('page_title', 'Riwayat & Pelacakan Permohonan Legalisir')
@section('page_subtitle', 'Pantau perkembangan verifikasi berkas alumni secara transparan dan unduh bukti tanda terima')

@section('page_actions')
    <a href="{{ route('legalisir.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-teal-700 hover:bg-teal-600 rounded-xl shadow-xs transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Ajukan Legalisir Baru</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Stat Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Pengajuan</span>
            <div class="text-2xl font-bold font-heading text-slate-900 mt-1">{{ $stats['total'] }}</div>
            <span class="text-[11px] text-slate-400">Seluruh riwayat</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-xs font-semibold text-amber-600 uppercase tracking-wider block">Menunggu Verifikasi</span>
            <div class="text-2xl font-bold font-heading text-amber-600 mt-1">{{ $stats['menunggu'] }}</div>
            <span class="text-[11px] text-amber-700/80">Antrean staf TU</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-xs font-semibold text-purple-600 uppercase tracking-wider block">Diproses & Cap</span>
            <div class="text-2xl font-bold font-heading text-purple-600 mt-1">{{ $stats['proses'] }}</div>
            <span class="text-[11px] text-purple-700/80">Pencetakan & stempel</span>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-emerald-300 bg-emerald-50/50 shadow-xs">
            <span class="text-xs font-semibold text-emerald-800 uppercase tracking-wider block">Siap Diambil</span>
            <div class="text-2xl font-bold font-heading text-emerald-700 mt-1">{{ $stats['siap_ambil'] }}</div>
            <span class="text-[11px] text-emerald-800 font-semibold">Tersedia di TU</span>
        </div>
    </div>

    <!-- Table of Applications -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-heading font-bold text-sm text-slate-900">Daftar Permohonan Legalisir Anda</h3>
            <span class="text-xs text-slate-500">{{ $pengajuans->total() }} data ditemukan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">No. Resi & Tanggal</th>
                        <th class="py-3 px-4">Dokumen yang Dilegalisir</th>
                        <th class="py-3 px-4">Jumlah Lembar</th>
                        <th class="py-3 px-4">Status Pengajuan</th>
                        <th class="py-3 px-4">Kesiapan Ambil</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengajuans as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <span class="font-mono font-bold text-teal-800 block text-xs">{{ $item->nomor_pengajuan }}</span>
                                <span class="text-[11px] text-slate-400 block mt-0.5">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900 block">{{ $item->jenis_dokumen_label }}</span>
                                <span class="text-[11px] text-slate-500 block truncate max-w-xs">{{ $item->keperluan }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-700">
                                {{ $item->jumlah_lembar }} Lembar
                            </td>
                            <td class="py-3.5 px-4">
                                <x-status-badge :status="$item->status" type="legalisir" />
                                @if($item->status === 'ditolak')
                                    <p class="text-[10px] text-rose-600 mt-1 max-w-xs truncate" title="{{ $item->catatan_petugas ?? $item->catatan_kepsek }}">
                                        Catatan: {{ $item->catatan_petugas ?? $item->catatan_kepsek ?? 'Berkas ditolak' }}
                                    </p>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($item->tanggal_siap_ambil)
                                    <span class="inline-flex items-center gap-1 font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-200">
                                        {{ $item->tanggal_siap_ambil->translatedFormat('d M Y') }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">Dalam proses verifikasi</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-1">
                                    <a 
                                        href="{{ route('pemohon.legalisir.show', $item->id) }}" 
                                        class="px-3 py-1.5 bg-teal-50 hover:bg-teal-100 text-teal-800 rounded-xl font-bold text-xs transition-colors"
                                    >
                                        Lacak Status
                                    </a>
                                    <a 
                                        href="{{ route('legalisir.tanda-terima', $item->nomor_pengajuan) }}" 
                                        target="_blank" 
                                        class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors"
                                        title="Cetak Tanda Terima"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <p class="font-bold text-slate-700">Belum ada pengajuan legalisir</p>
                                <p class="text-xs text-slate-400 mt-0.5">Anda belum mengajukan legalisir dokumen ke SMKN 1 Subang.</p>
                                <a href="{{ route('legalisir.create') }}" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 bg-teal-700 text-white font-bold rounded-xl text-xs hover:bg-teal-600 transition-colors">
                                    + Ajukan Legalisir Baru
                                </a>
                            </td>
                        </tr>
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
