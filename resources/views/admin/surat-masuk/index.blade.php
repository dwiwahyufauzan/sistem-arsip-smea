@extends('layouts.admin')

@section('title', 'Arsip Surat Masuk')

@section('content')
<div class="space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">
                <span>Modul Kearsipan</span>
                <span>•</span>
                <span>SRS-P02 / SRS-P03</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Pengelolaan Arsip Surat Masuk</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Pencatatan registrasi surat dinas eksternal, unggah berkas scan fisik, dan penelusuran status disposisi.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.surat-masuk.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-sm shadow-blue-500/20 active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Catat Surat Masuk</span>
            </a>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Total Surat Masuk</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-0.5">{{ number_format($statistik['total']) }}</h3>
                <span class="text-[10px] text-slate-400">Seluruh arsip terdaftar</span>
            </div>
        </div>

        <!-- Card 2: Diterima / Menunggu Disposisi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Menunggu Disposisi</p>
                <h3 class="text-2xl font-bold text-amber-600 mt-0.5">{{ number_format($statistik['diterima']) }}</h3>
                <span class="text-[10px] text-amber-700/80">Perlu tindak lanjut pimpinan</span>
            </div>
        </div>

        <!-- Card 3: Sudah Didisposisikan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Didisposisikan</p>
                <h3 class="text-2xl font-bold text-teal-600 mt-0.5">{{ number_format($statistik['didisposisikan']) }}</h3>
                <span class="text-[10px] text-teal-700/80">Instruksi telah diterbitkan</span>
            </div>
        </div>

        <!-- Card 4: Diarsipkan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Selesai / Diarsipkan</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-0.5">{{ number_format($statistik['diarsipkan']) }}</h3>
                <span class="text-[10px] text-emerald-700/80">Arsip inaktif tersimpan</span>
            </div>
        </div>
    </div>

    <!-- Filter & Pencarian Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <form action="{{ route('admin.surat-masuk.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                <!-- Search Input -->
                <div class="md:col-span-4 relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nomor surat, agenda, pengirim, atau perihal..."
                        class="w-full pl-10 pr-4 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>

                <!-- Kategori Filter -->
                <div class="md:col-span-3">
                    <select name="kategori_id" class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-700">
                        <option value="">Semua Kategori Klasifikasi</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->kode_kategori }} - {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="md:col-span-2">
                    <select name="status" class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-700">
                        <option value="">Semua Status</option>
                        <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="didisposisikan" {{ request('status') === 'didisposisikan' ? 'selected' : '' }}>Didisposisikan</option>
                        <option value="diarsipkan" {{ request('status') === 'diarsipkan' ? 'selected' : '' }}>Diarsipkan</option>
                    </select>
                </div>

                <!-- Action Filter Buttons -->
                <div class="md:col-span-3 flex items-center gap-2">
                    <button type="submit" class="flex-1 py-2 px-4 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold transition-colors flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        <span>Filter</span>
                    </button>
                    @if(request()->hasAny(['search', 'kategori_id', 'status', 'tanggal_mulai', 'tanggal_selesai']))
                        <a href="{{ route('admin.surat-masuk.index') }}" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors" title="Reset Filter">
                            Reset
                        </a>
                    @endif
                </div>
            </div>

            <!-- Optional Date Range Collapse -->
            <div class="flex items-center gap-3 pt-2 border-t border-slate-100 text-xs text-slate-500">
                <span class="font-medium">Rentang Tanggal Terima:</span>
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="px-2.5 py-1 text-xs rounded-lg border border-slate-200 focus:outline-none focus:border-blue-500">
                <span>s/d</span>
                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="px-2.5 py-1 text-xs rounded-lg border border-slate-200 focus:outline-none focus:border-blue-500">
            </div>
        </form>
    </div>

    <!-- Tabel Data Surat Masuk -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <th class="py-3.5 px-4">Agenda & Status</th>
                        <th class="py-3.5 px-4">Nomor & Pengirim</th>
                        <th class="py-3.5 px-4">Perihal & Klasifikasi</th>
                        <th class="py-3.5 px-4">Berkas Scan</th>
                        <th class="py-3.5 px-4 text-center">Disposisi</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($suratMasukList as $sm)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <!-- Kolom 1: Agenda & Status -->
                            <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                <span class="font-mono font-bold text-blue-900 bg-blue-50 px-2 py-0.5 rounded border border-blue-200/60 block w-max">
                                    {{ $sm->nomor_agenda }}
                                </span>
                                <div class="mt-1.5 flex items-center gap-1.5">
                                    <x-status-badge :status="$sm->status" />
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1 block">
                                    Diterima: {{ $sm->tanggal_terima->isoFormat('D MMM Y') }}
                                </span>
                            </td>

                            <!-- Kolom 2: Nomor & Pengirim -->
                            <td class="py-3.5 px-4 align-top">
                                <div class="font-semibold text-slate-900 leading-snug">
                                    {{ $sm->nomor_surat }}
                                </div>
                                <div class="text-slate-600 mt-0.5 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    <span class="truncate max-w-[200px]" title="{{ $sm->pengirim }}">{{ $sm->pengirim }}</span>
                                </div>
                                <span class="text-[10px] text-slate-400 block mt-0.5">
                                    Tgl Surat: {{ $sm->tanggal_surat->isoFormat('D MMM Y') }}
                                </span>
                            </td>

                            <!-- Kolom 3: Perihal & Klasifikasi -->
                            <td class="py-3.5 px-4 align-top">
                                <p class="font-medium text-slate-900 line-clamp-2 max-w-[280px]" title="{{ $sm->perihal }}">
                                    {{ $sm->perihal }}
                                </p>
                                <div class="mt-1 flex items-center gap-1.5">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-700 border border-slate-200/80">
                                        {{ $sm->kategori->kode_kategori }} - {{ $sm->kategori->nama_kategori }}
                                    </span>
                                </div>
                            </td>

                            <!-- Kolom 4: Berkas Scan -->
                            <td class="py-3.5 px-4 align-top whitespace-nowrap">
                                @if($sm->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($sm->file_path))
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            onclick="window.openPdfModal('{{ asset('storage/' . $sm->file_path) }}', 'Surat Masuk: {{ addslashes($sm->nomor_surat) }}')"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200/60 rounded-lg text-xs font-semibold transition-colors"
                                            title="Klik untuk Pratinjau Cepat"
                                        >
                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                            <span>Pratinjau</span>
                                        </button>
                                        <span class="text-[10px] text-slate-400 font-mono">{{ $sm->file_size_formatted }}</span>
                                    </div>
                                @else
                                    <span class="text-[11px] text-slate-400 italic">Tidak ada berkas</span>
                                @endif
                            </td>

                            <!-- Kolom 5: Disposisi Counter -->
                            <td class="py-3.5 px-4 align-top text-center whitespace-nowrap">
                                @if($sm->disposisi_count > 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ $sm->disposisi_count }} Lembar
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-normal text-slate-400 bg-slate-50 border border-slate-200/60">
                                        Belum Ada
                                    </span>
                                @endif
                            </td>

                            <!-- Kolom 6: Aksi -->
                            <td class="py-3.5 px-4 align-top text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1">
                                    <!-- Detail -->
                                    <a href="{{ route('admin.surat-masuk.show', $sm) }}" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Lembar Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('admin.surat-masuk.edit', $sm) }}" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit Metadata / Ganti Berkas">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Unduh Berkas -->
                                    @if($sm->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($sm->file_path))
                                        <a href="{{ route('admin.surat-masuk.download', $sm) }}" class="p-1.5 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Unduh Berkas Scan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        </a>
                                    @endif

                                    <!-- Hapus -->
                                    <button 
                                        type="button" 
                                        onclick="openDeleteModal({{ $sm->id }}, '{{ addslashes($sm->nomor_surat) }}', '{{ addslashes($sm->nomor_agenda) }}')" 
                                        class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                        title="Hapus Surat Masuk"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    </div>
                                    <h3 class="font-semibold text-slate-800 text-sm">Tidak Ada Arsip Surat Masuk</h3>
                                    <p class="text-xs text-slate-500">
                                        @if(request()->hasAny(['search', 'kategori_id', 'status', 'tanggal_mulai', 'tanggal_selesai']))
                                            Tidak ditemukan arsip surat masuk yang cocok dengan kriteria filter saat ini.
                                        @else
                                            Belum ada berkas surat masuk yang dicatat ke dalam sistem kearsipan.
                                        @endif
                                    </p>
                                    <div class="pt-2">
                                        <a href="{{ route('admin.surat-masuk.create') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            <span>Mulai Catat Surat Baru</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suratMasukList->hasPages())
            <div class="px-5 py-3.5 bg-slate-50/75 border-t border-slate-200">
                {{ $suratMasukList->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeDeleteModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-base font-bold text-slate-900">Konfirmasi Hapus Surat Masuk</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">
                Apakah Anda yakin ingin menghapus arsip surat <strong id="deleteNomorSurat" class="text-slate-800"></strong> (Agenda: <span id="deleteNomorAgenda" class="font-mono text-blue-900 font-bold"></span>)?
            </p>
            <p class="text-[11px] text-rose-600 bg-rose-50 p-2.5 rounded-xl border border-rose-100 mt-3 font-medium">
                Peringatan: Berkas scan fisik di penyimpanan server dan riwayat disposisi terkait juga akan dihapus permanen.
            </p>

            <form id="deleteForm" method="POST" action="" class="mt-6 flex items-center justify-end gap-2.5">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-xl transition-colors shadow-xs">
                    Ya, Hapus Permanen
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(id, nomorSurat, nomorAgenda) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const nomorSuratEl = document.getElementById('deleteNomorSurat');
        const nomorAgendaEl = document.getElementById('deleteNomorAgenda');

        form.action = `/admin/surat-masuk/${id}`;
        nomorSuratEl.textContent = nomorSurat;
        nomorAgendaEl.textContent = nomorAgenda;

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endsection
