@extends('layouts.kepsek')

@section('title', 'Detail Lembar Disposisi - ' . $disposisi->suratMasuk->nomor_agenda)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Action Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-3">
            <a href="{{ route('kepsek.disposisi.index') }}" class="p-2 rounded-xl text-slate-500 hover:text-emerald-800 hover:bg-slate-100 transition-colors" title="Kembali">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="font-mono font-bold text-xs bg-slate-100 text-slate-800 px-2 py-0.5 rounded border border-slate-200">
                        Disposisi #{{ $disposisi->id }}
                    </span>
                    @if($disposisi->status === 'selesai')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            Selesai Dilaksanakan
                        </span>
                    @elseif($disposisi->status === 'ditindaklanjuti')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
                            Sedang Diproses
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                            Menunggu Tindak Lanjut
                        </span>
                    @endif
                </div>
                <h1 class="text-base sm:text-lg font-bold text-slate-900 mt-1 leading-tight">
                    Disposisi: {{ $disposisi->tujuan_disposisi }}
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <!-- Cetak Lembar Resmi -->
            <a 
                href="{{ route('kepsek.disposisi.cetak', $disposisi) }}" 
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-xs transition-colors"
                title="Cetak Lembar Disposisi Standar Instansi"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Lembar Disposisi</span>
            </a>

            <!-- Ubah -->
            <a 
                href="{{ route('kepsek.disposisi.edit', $disposisi) }}" 
                class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Ubah</span>
            </a>
        </div>
    </div>

    <!-- Grid Detail Disposisi & Surat Terkait -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column: Lembar Disposisi & Status Updater (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Detail Lembar Arahan -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Arahan & Instruksi Resmi Pimpinan</h2>
                    <span class="text-[10px] text-slate-400">Diberikan oleh: {{ $disposisi->pemberi->name ?? 'Kepala Sekolah' }}</span>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <span class="text-[11px] text-slate-400 font-medium block">Diteruskan Kepada (Tujuan Disposisi):</span>
                        <div class="mt-1 inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-900 font-bold text-sm border border-emerald-200">
                            <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>{{ $disposisi->tujuan_disposisi }}</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-1.5">
                        <span class="text-[11px] text-slate-500 font-bold uppercase tracking-wider block">Isi Instruksi / Disposisi:</span>
                        <p class="text-xs text-slate-900 leading-relaxed font-medium whitespace-pre-line">{{ $disposisi->instruksi }}</p>
                    </div>

                    @if($disposisi->catatan)
                        <div class="p-4 rounded-xl bg-amber-50/50 border border-amber-100 space-y-1">
                            <span class="text-[11px] text-amber-700 font-bold uppercase tracking-wider block">Catatan Khusus:</span>
                            <p class="text-xs text-amber-950 italic">{{ $disposisi->catatan }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-3 border-t border-slate-100 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Batas Waktu Tindak Lanjut:</span>
                            @if($disposisi->batas_waktu)
                                <span class="font-bold text-slate-800 mt-0.5 block">{{ $disposisi->batas_waktu->isoFormat('dddd, D MMMM Y') }}</span>
                                @php
                                    $diff = now()->startOfDay()->diffInDays($disposisi->batas_waktu, false);
                                @endphp
                                @if($diff < 0 && $disposisi->status !== 'selesai')
                                    <span class="text-[10px] text-rose-600 font-bold mt-0.5 block">Telah melewati tenggat waktu</span>
                                @elseif($diff >= 0 && $disposisi->status !== 'selesai')
                                    <span class="text-[10px] text-amber-600 font-semibold mt-0.5 block">{{ $diff }} hari tersisa</span>
                                @endif
                            @else
                                <span class="text-slate-500 mt-0.5 block italic">Tidak ditentukan</span>
                            @endif
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Waktu Disposisi Diterbitkan:</span>
                            <span class="font-medium text-slate-700 mt-0.5 block">{{ $disposisi->created_at->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pembaruan Status Tindak Lanjut Cepat -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Pembaruan Perkembangan Tindak Lanjut</h2>
                    <span class="text-[10px] text-slate-400">Monitoring Eksekusi</span>
                </div>

                <div class="p-6">
                    <form action="{{ route('kepsek.disposisi.status', $disposisi) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-3">
                        @csrf
                        @method('PATCH')
                        <div class="w-full sm:w-2/3">
                            <label for="status" class="block text-[11px] font-semibold text-slate-500 mb-1">Ubah Status Tindak Lanjut:</label>
                            <select 
                                name="status" 
                                id="status" 
                                class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all font-semibold"
                            >
                                <option value="menunggu" {{ $disposisi->status === 'menunggu' ? 'selected' : '' }}>Menunggu Tindak Lanjut</option>
                                <option value="ditindaklanjuti" {{ $disposisi->status === 'ditindaklanjuti' ? 'selected' : '' }}>Sedang Ditindaklanjuti / Dalam Proses</option>
                                <option value="selesai" {{ $disposisi->status === 'selesai' ? 'selected' : '' }}>Selesai Dilaksanakan Sepenuhnya</option>
                            </select>
                        </div>
                        <div class="w-full sm:w-1/3 sm:self-end">
                            <button 
                                type="submit" 
                                class="w-full py-2 px-4 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs rounded-xl shadow-xs transition-colors cursor-pointer"
                            >
                                Simpan Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Right Column: Informasi Surat Masuk Terkait (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">

            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Surat Masuk Terkait</h2>
                    <a href="{{ route('kepsek.surat-masuk.show', $disposisi->suratMasuk) }}" class="text-xs text-emerald-800 hover:underline font-semibold inline-flex items-center gap-1">
                        <span>Buka Lembar Surat</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>

                <div class="p-6 space-y-3.5 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[11px]">Nomor Agenda & Surat:</span>
                        <p class="font-mono font-bold text-slate-900 mt-0.5">{{ $disposisi->suratMasuk->nomor_agenda }}</p>
                        <p class="font-semibold text-slate-800">{{ $disposisi->suratMasuk->nomor_surat }}</p>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Asal / Pengirim:</span>
                        <p class="font-medium text-slate-800 mt-0.5">{{ $disposisi->suratMasuk->pengirim }}</p>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Perihal Surat:</span>
                        <p class="font-medium text-slate-900 mt-0.5">{{ $disposisi->suratMasuk->perihal }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Tanggal Surat:</span>
                            <span class="font-medium text-slate-700 mt-0.5 block">{{ $disposisi->suratMasuk->tanggal_surat->isoFormat('D MMM Y') }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Tanggal Diterima TU:</span>
                            <span class="font-medium text-slate-700 mt-0.5 block">{{ $disposisi->suratMasuk->tanggal_terima->isoFormat('D MMM Y') }}</span>
                        </div>
                    </div>

                    @if($disposisi->suratMasuk->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($disposisi->suratMasuk->file_path))
                        <div class="pt-3 border-t border-slate-100">
                            <button 
                                type="button" 
                                onclick="window.openPdfModal('{{ asset('storage/' . $disposisi->suratMasuk->file_path) }}', 'Surat Masuk: {{ addslashes($disposisi->suratMasuk->nomor_surat) }}')"
                                class="w-full py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold flex items-center justify-center gap-2 transition-colors cursor-pointer"
                            >
                                <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                <span>Pratinjau Pindaian Berkas Surat Masuk</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
