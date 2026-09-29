@extends('layouts.admin')

@section('title', 'Detail Disposisi - #' . $disposisi->id)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Action Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.disposisi.index') }}" class="p-2 rounded-xl text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition-colors" title="Kembali">
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
                    Tujuan: {{ $disposisi->tujuan_disposisi }}
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a 
                href="{{ route('admin.disposisi.cetak', $disposisi) }}" 
                target="_blank"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold shadow-xs transition-colors"
                title="Cetak Lembar Disposisi"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Cetak Lembar Disposisi</span>
            </a>
        </div>
    </div>

    <!-- Grid Detail Disposisi & Surat Terkait -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Left Column: Lembar Disposisi & Status Updater (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">

            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Arahan Resmi Pimpinan Sekolah</h2>
                    <span class="text-[10px] text-slate-400">Pemberi: {{ $disposisi->pemberi->name ?? 'Kepala Sekolah' }}</span>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <span class="text-[11px] text-slate-400 font-medium block">Diteruskan Kepada (Unit Kerja):</span>
                        <div class="mt-1 inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-blue-50 text-blue-900 font-bold text-sm border border-blue-200">
                            <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
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
                            <span class="text-slate-400 block text-[11px]">Batas Waktu:</span>
                            @if($disposisi->batas_waktu)
                                <span class="font-bold text-slate-800 mt-0.5 block">{{ $disposisi->batas_waktu->isoFormat('dddd, D MMMM Y') }}</span>
                            @else
                                <span class="text-slate-500 mt-0.5 block italic">-</span>
                            @endif
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[11px]">Waktu Disposisi Diterbitkan:</span>
                            <span class="font-medium text-slate-700 mt-0.5 block">{{ $disposisi->created_at->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Status Disposisi oleh TU -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Pembaruan Perkembangan Tindak Lanjut</h2>
                    <span class="text-[10px] text-slate-400">Petugas TU</span>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.disposisi.status', $disposisi) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-3">
                        @csrf
                        @method('PATCH')
                        <div class="w-full sm:w-2/3">
                            <label for="status" class="block text-[11px] font-semibold text-slate-500 mb-1">Ubah Status Tindak Lanjut:</label>
                            <select 
                                name="status" 
                                id="status" 
                                class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all font-semibold"
                            >
                                <option value="menunggu" {{ $disposisi->status === 'menunggu' ? 'selected' : '' }}>Menunggu Tindak Lanjut</option>
                                <option value="ditindaklanjuti" {{ $disposisi->status === 'ditindaklanjuti' ? 'selected' : '' }}>Sedang Ditindaklanjuti / Dalam Proses</option>
                                <option value="selesai" {{ $disposisi->status === 'selesai' ? 'selected' : '' }}>Selesai Dilaksanakan Sepenuhnya</option>
                            </select>
                        </div>
                        <div class="w-full sm:w-1/3 sm:self-end">
                            <button 
                                type="submit" 
                                class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-xs transition-colors cursor-pointer"
                            >
                                Simpan Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Right Column: Informasi Surat Masuk (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Surat Masuk Terkait</h2>
                    <a href="{{ route('admin.surat-masuk.show', $disposisi->suratMasuk) }}" class="text-xs text-blue-600 hover:underline font-semibold inline-flex items-center gap-1">
                        <span>Lihat Detail</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>

                <div class="p-6 space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block text-[11px]">Nomor Agenda:</span>
                        <span class="font-mono font-bold text-slate-900">{{ $disposisi->suratMasuk->nomor_agenda }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Nomor Surat:</span>
                        <span class="font-semibold text-slate-800">{{ $disposisi->suratMasuk->nomor_surat }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Pengirim:</span>
                        <span class="font-medium text-slate-800">{{ $disposisi->suratMasuk->pengirim }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block text-[11px]">Perihal:</span>
                        <span class="font-medium text-slate-900 leading-snug block">{{ $disposisi->suratMasuk->perihal }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
