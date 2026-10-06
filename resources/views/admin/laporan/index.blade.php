@extends('layouts.admin')

@section('title', 'Rekapitulasi Laporan & Buku Agenda')

@section('content')
<div class="space-y-6">

    <!-- Modern Page Header -->
    <x-page-header 
        title="Rekapitulasi Laporan & Buku Agenda" 
        subtitle="Penyusunan buku agenda resmi Surat Masuk, Surat Keluar, dan Rekapitulasi Pelayanan Legalisir berbasis rentang tanggal."
        overline="Standar Kearsipan Dinas • SRS-P10 / SRS-P11"
    >
        <x-slot:actions>
            <a 
                href="{{ route('admin.laporan.cetak', request()->all()) }}" 
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-sm shadow-blue-500/20 cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Buku Agenda Resmi</span>
            </a>
        </x-slot:actions>
    </x-page-header>

    <!-- Quick Stats Cards for Period -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-stat-card 
            label="Surat Masuk (Periode Ini)" 
            :value="number_format($stats['surat_masuk_count'])" 
            description="Arsip surat diterima" 
            color="blue"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card 
            label="Surat Keluar (Periode Ini)" 
            :value="number_format($stats['surat_keluar_count'])" 
            description="Arsip surat diterbitkan" 
            color="teal"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card 
            label="Permohonan Legalisir" 
            :value="number_format($stats['legalisir_count'])" 
            description="Pelayanan alumni daring" 
            color="purple"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </x-slot:icon>
        </x-stat-card>
    </div>

    <!-- Filter Configuration Card -->
    <div class="card-modern p-5 space-y-4">
        
        <!-- Module Selector Tabs -->
        <div class="flex items-center gap-2 border-b border-slate-100 pb-4 overflow-x-auto text-xs font-semibold">
            <a 
                href="{{ route('admin.laporan.index', array_merge(request()->query(), ['jenis' => 'surat_masuk'])) }}" 
                class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $jenis === 'surat_masuk' ? 'bg-blue-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100' }}"
            >
                Buku Agenda Surat Masuk
            </a>
            <a 
                href="{{ route('admin.laporan.index', array_merge(request()->query(), ['jenis' => 'surat_keluar'])) }}" 
                class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $jenis === 'surat_keluar' ? 'bg-teal-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100' }}"
            >
                Buku Agenda Surat Keluar
            </a>
            <a 
                href="{{ route('admin.laporan.index', array_merge(request()->query(), ['jenis' => 'legalisir'])) }}" 
                class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $jenis === 'legalisir' ? 'bg-purple-600 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100' }}"
            >
                Rekapitulasi Layanan Legalisir
            </a>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 text-xs">
            <input type="hidden" name="jenis" value="{{ $jenis }}">

            <div>
                <label class="block text-slate-500 font-semibold mb-1">Tanggal Mulai:</label>
                <input 
                    type="date" 
                    name="tanggal_mulai" 
                    value="{{ $tanggalMulai }}" 
                    class="input-modern w-full p-2 text-slate-800"
                >
            </div>

            <div>
                <label class="block text-slate-500 font-semibold mb-1">Tanggal Selesai:</label>
                <input 
                    type="date" 
                    name="tanggal_selesai" 
                    value="{{ $tanggalSelesai }}" 
                    class="input-modern w-full p-2 text-slate-800"
                >
            </div>

            @if(in_array($jenis, ['surat_masuk', 'surat_keluar']))
                <div>
                    <label class="block text-slate-500 font-semibold mb-1">Kategori Klasifikasi:</label>
                    <select name="kategori_id" class="input-modern w-full p-2 text-slate-800">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ $kategoriId == $kat->id ? 'selected' : '' }}>
                                {{ $kat->kode_kategori }} - {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div>
                <label class="block text-slate-500 font-semibold mb-1">Status Dokumen:</label>
                <select name="status" class="input-modern w-full p-2 text-slate-800">
                    <option value="">Semua Status</option>
                    @if($jenis === 'surat_masuk')
                        <option value="diterima" {{ $status === 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="didisposisikan" {{ $status === 'didisposisikan' ? 'selected' : '' }}>Didisposisikan</option>
                        <option value="diarsipkan" {{ $status === 'diarsipkan' ? 'selected' : '' }}>Diarsipkan</option>
                    @elseif($jenis === 'surat_keluar')
                        <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draf Konsep</option>
                        <option value="menunggu_persetujuan" {{ $status === 'menunggu_persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                        <option value="disetujui" {{ $status === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ $status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    @elseif($jenis === 'legalisir')
                        <option value="menunggu_verifikasi" {{ $status === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="menunggu_approval_kepsek" {{ $status === 'menunggu_approval_kepsek' ? 'selected' : '' }}>Menunggu Kepsek</option>
                        <option value="sedang_diproses" {{ $status === 'sedang_diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="siap_diambil" {{ $status === 'siap_diambil' ? 'selected' : '' }}>Siap Diambil</option>
                        <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    @endif
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button 
                    type="submit" 
                    class="w-full py-2 bg-slate-800 hover:bg-slate-900 text-white font-semibold rounded-xl transition-all shadow-xs active:scale-[0.98] cursor-pointer"
                >
                    Terapkan Filter
                </button>
                <a 
                    href="{{ route('admin.laporan.index', ['jenis' => $jenis]) }}" 
                    class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors"
                    title="Reset Filter"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Data Preview Table -->
    <div class="card-modern overflow-hidden">
        <div class="p-4 bg-slate-50/80 border-b border-slate-200 flex items-center justify-between">
            <h3 class="font-bold text-xs uppercase tracking-wider text-slate-800">
                Pratinjau Data: {{ $jenis === 'surat_masuk' ? 'Agenda Surat Masuk' : ($jenis === 'surat_keluar' ? 'Agenda Surat Keluar' : 'Rekapitulasi Legalisir') }}
                <span class="text-blue-700">({{ $records->count() }} Data)</span>
            </h3>
            <span class="text-xs text-slate-500 font-medium">
                Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d M Y') }} s.d. {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d M Y') }}
            </span>
        </div>

        <div class="overflow-x-auto">
            @if($jenis === 'surat_masuk')
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-3 text-center w-10">No</th>
                            <th class="py-3 px-3">No. Agenda</th>
                            <th class="py-3 px-3">Tgl. Diterima</th>
                            <th class="py-3 px-3">Pengirim</th>
                            <th class="py-3 px-3">Nomor & Tanggal Surat</th>
                            <th class="py-3 px-4">Perihal</th>
                            <th class="py-3 px-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($records as $idx => $item)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3 px-3 text-center font-semibold text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3 px-3 font-mono font-bold text-blue-900">{{ $item->nomor_agenda }}</td>
                                <td class="py-3 px-3 text-slate-600">{{ $item->tanggal_terima ? $item->tanggal_terima->translatedFormat('d/m/Y') : '-' }}</td>
                                <td class="py-3 px-3 font-semibold text-slate-800">{{ $item->pengirim }}</td>
                                <td class="py-3 px-3">
                                    <span class="font-mono text-slate-800 block">{{ $item->nomor_surat }}</span>
                                    <span class="text-[11px] text-slate-400 block">{{ $item->tanggal_surat ? $item->tanggal_surat->translatedFormat('d/m/Y') : '-' }}</span>
                                </td>
                                <td class="py-3 px-4 font-medium text-slate-700 max-w-xs truncate" title="{{ $item->perihal }}">{{ $item->perihal }}</td>
                                <td class="py-3 px-3"><x-status-badge :status="$item->status" type="surat_masuk" /></td>
                            </tr>
                        @empty
                            <x-empty-state colspan="7" title="Tidak ada data surat masuk" description="Tidak ada data surat masuk pada rentang tanggal ini." />
                        @endforelse
                    </tbody>
                </table>
            @elseif($jenis === 'surat_keluar')
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-3 text-center w-10">No</th>
                            <th class="py-3 px-3">No. Agenda</th>
                            <th class="py-3 px-3">Tgl. Surat</th>
                            <th class="py-3 px-3">Tujuan Surat</th>
                            <th class="py-3 px-3">Nomor Surat</th>
                            <th class="py-3 px-4">Perihal</th>
                            <th class="py-3 px-3">Status Persetujuan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($records as $idx => $item)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3 px-3 text-center font-semibold text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3 px-3 font-mono font-bold text-teal-900">{{ $item->nomor_agenda }}</td>
                                <td class="py-3 px-3 text-slate-600">{{ $item->tanggal_surat ? $item->tanggal_surat->translatedFormat('d/m/Y') : '-' }}</td>
                                <td class="py-3 px-3 font-semibold text-slate-800">{{ $item->tujuan }}</td>
                                <td class="py-3 px-3 font-mono text-slate-800">{{ $item->nomor_surat }}</td>
                                <td class="py-3 px-4 font-medium text-slate-700 max-w-xs truncate" title="{{ $item->perihal }}">{{ $item->perihal }}</td>
                                <td class="py-3 px-3"><x-status-badge :status="$item->status_persetujuan" type="surat_keluar" /></td>
                            </tr>
                        @empty
                            <x-empty-state colspan="7" title="Tidak ada data surat keluar" description="Tidak ada data surat keluar pada rentang tanggal ini." />
                        @endforelse
                    </tbody>
                </table>
            @else
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-3 text-center w-10">No</th>
                            <th class="py-3 px-3">No. Resi</th>
                            <th class="py-3 px-3">Tgl. Daftar</th>
                            <th class="py-3 px-3">Nama Pemohon & NISN</th>
                            <th class="py-3 px-3">Dokumen & Lembar</th>
                            <th class="py-3 px-4">Keperluan</th>
                            <th class="py-3 px-3">Status Pelayanan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($records as $idx => $item)
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3 px-3 text-center font-semibold text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-3 px-3 font-mono font-bold text-purple-900">{{ $item->nomor_pengajuan }}</td>
                                <td class="py-3 px-3 text-slate-600">{{ $item->created_at->translatedFormat('d/m/Y') }}</td>
                                <td class="py-3 px-3">
                                    <span class="font-bold text-slate-900 block">{{ $item->nama_pemohon }}</span>
                                    <span class="text-[11px] font-mono text-slate-500">NISN: {{ $item->nisn }} ({{ $item->tahun_lulus }})</span>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="font-semibold text-slate-800 block">{{ $item->jenis_dokumen_label }}</span>
                                    <span class="text-[11px] text-slate-500">{{ $item->jumlah_lembar }} Lembar</span>
                                </td>
                                <td class="py-3 px-4 font-medium text-slate-700 max-w-xs truncate" title="{{ $item->keperluan }}">{{ $item->keperluan }}</td>
                                <td class="py-3 px-3"><x-status-badge :status="$item->status" type="legalisir" /></td>
                            </tr>
                        @empty
                            <x-empty-state colspan="7" title="Tidak ada data legalisir" description="Tidak ada data legalisir pada rentang tanggal ini." />
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>
@endsection
