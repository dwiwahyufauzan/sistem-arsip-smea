@extends('layouts.kepsek')

@section('title', 'Rekapitulasi Agenda Eksekutif')

@section('content')
<div class="space-y-6">

    <!-- Modern Page Header -->
    <x-page-header 
        title="Rekapitulasi Agenda & Laporan Kearsipan" 
        subtitle="Pemantauan data buku agenda dinas, rekapitulasi surat masuk/keluar, dan pelayanan alumni untuk kebutuhan supervisi berkala pimpinan."
        overline="Pusat Kendali Eksekutif • SRS-KS09"
    >
        <x-slot:actions>
            <a 
                href="{{ route('kepsek.laporan.cetak', request()->all()) }}" 
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 active:scale-[0.98] text-white rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-sm shadow-emerald-700/20 cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Lembar Rekapitulasi</span>
            </a>
        </x-slot:actions>
    </x-page-header>

    <!-- Quick Stats Cards for Period -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-stat-card 
            label="Surat Masuk Periode Ini" 
            :value="number_format($stats['surat_masuk_count'])" 
            description="Arsip surat diterima" 
            color="emerald"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card 
            label="Surat Keluar Diterbitkan" 
            :value="number_format($stats['surat_keluar_count'])" 
            description="Arsip dinas keluar" 
            color="blue"
        >
            <x-slot:icon>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </x-slot:icon>
        </x-stat-card>

        <x-stat-card 
            label="Layanan Legalisir" 
            :value="number_format($stats['legalisir_count'])" 
            description="Pelayanan alumni" 
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
                href="{{ route('kepsek.laporan.index', array_merge(request()->query(), ['jenis' => 'surat_masuk'])) }}" 
                class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $jenis === 'surat_masuk' ? 'bg-emerald-700 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100' }}"
            >
                Buku Agenda Surat Masuk
            </a>
            <a 
                href="{{ route('kepsek.laporan.index', array_merge(request()->query(), ['jenis' => 'surat_keluar'])) }}" 
                class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $jenis === 'surat_keluar' ? 'bg-emerald-700 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100' }}"
            >
                Buku Agenda Surat Keluar
            </a>
            <a 
                href="{{ route('kepsek.laporan.index', array_merge(request()->query(), ['jenis' => 'legalisir'])) }}" 
                class="px-4 py-2 rounded-xl transition-all whitespace-nowrap {{ $jenis === 'legalisir' ? 'bg-emerald-700 text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100' }}"
            >
                Rekapitulasi Layanan Legalisir
            </a>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('kepsek.laporan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 text-xs">
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
                    href="{{ route('kepsek.laporan.index', ['jenis' => $jenis]) }}" 
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
                Pratinjau Data Eksekutif: {{ $jenis === 'surat_masuk' ? 'Agenda Surat Masuk' : ($jenis === 'surat_keluar' ? 'Agenda Surat Keluar' : 'Rekapitulasi Legalisir') }}
                <span class="text-emerald-700">({{ $records->count() }} Data)</span>
            </h3>
            <span class="text-xs text-slate-500 font-medium">
                Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d M Y') }} s.d. {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d M Y') }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200">
                    @if($jenis === 'surat_masuk')
                        <tr>
                            <th class="px-4 py-3 w-12 text-center">No.</th>
                            <th class="px-4 py-3 w-28">No. Agenda</th>
                            <th class="px-4 py-3 w-28">Tgl Diterima</th>
                            <th class="px-4 py-3 w-52">Nomor & Tanggal Surat</th>
                            <th class="px-4 py-3 w-48">Pengirim</th>
                            <th class="px-4 py-3">Perihal & Disposisi</th>
                            <th class="px-4 py-3 w-28 text-center">Klasifikasi</th>
                            <th class="px-4 py-3 w-28 text-center">Status</th>
                        </tr>
                    @elseif($jenis === 'surat_keluar')
                        <tr>
                            <th class="px-4 py-3 w-12 text-center">No.</th>
                            <th class="px-4 py-3 w-28">No. Agenda</th>
                            <th class="px-4 py-3 w-52">Nomor & Tanggal Surat</th>
                            <th class="px-4 py-3 w-48">Tujuan</th>
                            <th class="px-4 py-3">Perihal & Isi Ringkas</th>
                            <th class="px-4 py-3 w-28 text-center">Klasifikasi</th>
                            <th class="px-4 py-3 w-32 text-center">Status</th>
                        </tr>
                    @else
                        <tr>
                            <th class="px-4 py-3 w-12 text-center">No.</th>
                            <th class="px-4 py-3 w-32">No. Pengajuan</th>
                            <th class="px-4 py-3 w-28">Tgl Pengajuan</th>
                            <th class="px-4 py-3 w-48">Nama Pemohon & NISN</th>
                            <th class="px-4 py-3 w-32">Dokumen & Lembar</th>
                            <th class="px-4 py-3">Keperluan</th>
                            <th class="px-4 py-3 w-28 text-center">Status</th>
                        </tr>
                    @endif
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($records as $index => $item)
                        @if($jenis === 'surat_masuk')
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-4 py-3 text-center text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-mono font-bold text-slate-800">{{ $item->nomor_agenda }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-slate-600">{{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-900">{{ $item->nomor_surat }}</div>
                                    <div class="text-[10px] text-slate-400">Tgl: {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $item->pengirim }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-900">{{ $item->perihal }}</div>
                                    @if($item->disposisi && $item->disposisi->isNotEmpty())
                                        <div class="text-[10px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md inline-block mt-1 font-medium border border-emerald-200">
                                            Instruksi: {{ Str::limit($item->disposisi->first()->instruksi, 40) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="font-mono text-xs font-semibold px-2 py-0.5 bg-slate-100 rounded text-slate-700">{{ $item->kategori->kode_kategori ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <x-status-badge :status="$item->status" type="surat_masuk" />
                                </td>
                            </tr>
                        @elseif($jenis === 'surat_keluar')
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-4 py-3 text-center text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-mono font-bold text-slate-800">{{ $item->nomor_agenda }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-900">{{ $item->nomor_surat }}</div>
                                    <div class="text-[10px] text-slate-400">Tgl: {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $item->tujuan }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-900">{{ $item->perihal }}</div>
                                    @if($item->isi_ringkas)
                                        <div class="text-[10px] text-slate-500 line-clamp-1 mt-0.5">{{ $item->isi_ringkas }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="font-mono text-xs font-semibold px-2 py-0.5 bg-slate-100 rounded text-slate-700">{{ $item->kategori->kode_kategori ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <x-status-badge :status="$item->status_persetujuan" type="surat_keluar" />
                                </td>
                            </tr>
                        @else
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-4 py-3 text-center text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 font-mono font-bold text-slate-800">{{ $item->nomor_pengajuan }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-slate-600">{{ $item->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-semibold text-slate-900">{{ $item->nama_pemohon }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">NISN: {{ $item->nisn }} (Lulus {{ $item->tahun_lulus }})</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-medium uppercase">{{ $item->jenis_dokumen }}</span>
                                    <div class="text-[10px] text-slate-500 font-bold">{{ $item->jumlah_lembar }} Lembar</div>
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ $item->keperluan }}</td>
                                <td class="px-4 py-3 text-center">
                                    <x-status-badge :status="$item->status" type="legalisir" />
                                </td>
                            </tr>
                        @endif
                    @empty
                        <x-empty-state 
                            :colspan="$jenis === 'legalisir' ? 7 : 8" 
                            title="Tidak ada data arsip pada periode yang dipilih" 
                            description="Silakan sesuaikan filter tanggal mulai atau tanggal selesai di atas." 
                        />
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
