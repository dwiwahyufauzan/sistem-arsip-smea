@extends('layouts.kepsek')

@section('title', 'Rekapitulasi Agenda Eksekutif')

@section('content')
<div class="space-y-6">

    <!-- Header & Quick Print Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-600 uppercase tracking-wider mb-1">
                <span>Pusat Kendali Eksekutif</span>
                <span>•</span>
                <span>SRS-KS09</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Rekapitulasi Agenda & Laporan Kearsipan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Pemantauan data buku agenda dinas, rekapitulasi surat masuk/keluar, dan pelayanan alumni untuk kebutuhan supervisi berkala pimpinan.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a 
                href="{{ route('kepsek.laporan.cetak', request()->all()) }}" 
                target="_blank" 
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 active:scale-[0.98] text-white rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-sm shadow-emerald-700/20 cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Lembar Rekapitulasi</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards for Period -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">Surat Masuk Periode Ini</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-0.5">{{ number_format($stats['surat_masuk_count']) }}</h3>
                <span class="text-[10px] text-emerald-600 font-medium">Arsip surat diterima</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">Surat Keluar Diterbitkan</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-0.5">{{ number_format($stats['surat_keluar_count']) }}</h3>
                <span class="text-[10px] text-emerald-600 font-medium">Arsip dinas keluar</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs text-slate-500 font-medium">Layanan Legalisir</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-0.5">{{ number_format($stats['legalisir_count']) }}</h3>
                <span class="text-[10px] text-purple-600 font-medium">Pelayanan alumni</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
    </div>

    <!-- Filter Configuration Card -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        
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
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-hidden transition-all text-xs"
                >
            </div>

            <div>
                <label class="block text-slate-500 font-semibold mb-1">Tanggal Selesai:</label>
                <input 
                    type="date" 
                    name="tanggal_selesai" 
                    value="{{ $tanggalSelesai }}" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-hidden transition-all text-xs"
                >
            </div>

            @if($jenis !== 'legalisir')
                <div>
                    <label class="block text-slate-500 font-semibold mb-1">Klasifikasi Surat:</label>
                    <select 
                        name="kategori_id" 
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-hidden transition-all text-xs"
                    >
                        <option value="">-- Semua Klasifikasi --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ (string)$kategoriId === (string)$kat->id ? 'selected' : '' }}>
                                {{ $kat->kode_kategori }} - {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div>
                <label class="block text-slate-500 font-semibold mb-1">Status:</label>
                <select 
                    name="status" 
                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:outline-hidden transition-all text-xs"
                >
                    <option value="">-- Semua Status --</option>
                    @if($jenis === 'surat_masuk')
                        <option value="diterima" {{ $status === 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="didisposisikan" {{ $status === 'didisposisikan' ? 'selected' : '' }}>Didisposisikan</option>
                        <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    @elseif($jenis === 'surat_keluar')
                        <option value="draf" {{ $status === 'draf' ? 'selected' : '' }}>Draf</option>
                        <option value="menunggu_persetujuan" {{ $status === 'menunggu_persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                        <option value="disetujui" {{ $status === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ $status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="terkirim" {{ $status === 'terkirim' ? 'selected' : '' }}>Terkirim</option>
                    @else
                        <option value="diajukan" {{ $status === 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                        <option value="diverifikasi" {{ $status === 'diverifikasi' ? 'selected' : '' }}>Diverifikasi TU</option>
                        <option value="disahkan" {{ $status === 'disahkan' ? 'selected' : '' }}>Disahkan Kepsek</option>
                        <option value="siap_diambil" {{ $status === 'siap_diambil' ? 'selected' : '' }}>Siap Diambil</option>
                        <option value="selesai" {{ $status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ $status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    @endif
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button 
                    type="submit" 
                    class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-semibold transition-all shadow-xs cursor-pointer flex items-center justify-center gap-1.5"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Terapkan Filter</span>
                </button>
                <a 
                    href="{{ route('kepsek.laporan.index', ['jenis' => $jenis]) }}" 
                    class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-all cursor-pointer font-semibold"
                    title="Reset Filter"
                >
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table Preview Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
            <div>
                <h2 class="text-sm font-bold text-slate-900">
                    Pratinjau Data Agenda ({{ number_format($records->count()) }} Dokumen Terpilih)
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">
                    Periode {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d M Y') }} s.d. {{ \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d M Y') }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a 
                    href="{{ route('kepsek.laporan.cetak', request()->all()) }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-lg border border-emerald-200 transition-colors"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak PDF / Print</span>
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100/75 text-slate-700 font-semibold uppercase tracking-wider text-[11px] border-b border-slate-200">
                    @if($jenis === 'surat_masuk')
                        <tr>
                            <th class="px-4 py-3 w-12 text-center">No.</th>
                            <th class="px-4 py-3 w-28">No. Agenda</th>
                            <th class="px-4 py-3 w-28">Tgl Terima</th>
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
                <tbody class="divide-y divide-slate-100">
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
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : ($item->status === 'didisposisikan' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-800') }}">
                                        {{ $item->status }}
                                    </span>
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
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status_persetujuan === 'disetujui' ? 'bg-emerald-100 text-emerald-800' : ($item->status_persetujuan === 'menunggu_persetujuan' ? 'bg-amber-100 text-amber-800' : ($item->status_persetujuan === 'ditolak' ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-800')) }}">
                                        {{ str_replace('_', ' ', $item->status_persetujuan) }}
                                    </span>
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
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ in_array($item->status, ['disahkan', 'selesai']) ? 'bg-emerald-100 text-emerald-800' : ($item->status === 'diverifikasi' ? 'bg-amber-100 text-amber-800' : ($item->status === 'ditolak' ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-800')) }}">
                                        {{ str_replace('_', ' ', $item->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="{{ $jenis === 'legalisir' ? 7 : 8 }}" class="px-6 py-12 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-sm font-semibold text-slate-700">Tidak ada data arsip pada periode yang dipilih</p>
                                <p class="text-xs text-slate-400 mt-1">Silakan sesuaikan filter tanggal mulai atau tanggal selesai di atas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
