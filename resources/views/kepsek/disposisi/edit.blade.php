@extends('layouts.kepsek')

@section('title', 'Ubah Lembar Disposisi - #' . $disposisi->id)
@section('page_title', 'Ubah Lembar Disposisi')
@section('page_subtitle', 'Pembaruan Instruksi & Pejabat Tujuan Disposisi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a 
            href="{{ route('kepsek.disposisi.show', $disposisi) }}" 
            class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-emerald-800 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Detail Disposisi</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Ubah Data Lembar Disposisi ID #{{ $disposisi->id }}</h2>
            <span class="font-mono text-xs font-semibold text-slate-500">{{ $disposisi->suratMasuk->nomor_agenda }}</span>
        </div>

        <form action="{{ route('kepsek.disposisi.update', $disposisi) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Info Surat Masuk Terkait -->
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-1 text-xs text-slate-700">
                <p><span class="text-slate-400">Nomor Surat Masuk:</span> <strong>{{ $disposisi->suratMasuk->nomor_surat }}</strong></p>
                <p><span class="text-slate-400">Pengirim:</span> {{ $disposisi->suratMasuk->pengirim }}</p>
                <p><span class="text-slate-400">Perihal:</span> {{ $disposisi->suratMasuk->perihal }}</p>
            </div>

            <!-- Tujuan Disposisi -->
            <div class="space-y-1.5">
                <label for="tujuan_disposisi" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                    Diteruskan Kepada (Tujuan Disposisi) <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="tujuan_disposisi" 
                    id="tujuan_disposisi" 
                    value="{{ old('tujuan_disposisi', $disposisi->tujuan_disposisi) }}" 
                    required 
                    class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all font-medium"
                >
                @error('tujuan_disposisi')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Instruksi -->
            <div class="space-y-1.5">
                <label for="instruksi" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                    Instruksi / Arahan Disposisi <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    name="instruksi" 
                    id="instruksi" 
                    rows="4" 
                    required 
                    class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all"
                >{{ old('instruksi', $disposisi->instruksi) }}</textarea>
                @error('instruksi')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Batas Waktu & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="batas_waktu" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                        Batas Waktu Tindak Lanjut
                    </label>
                    <input 
                        type="date" 
                        name="batas_waktu" 
                        id="batas_waktu" 
                        value="{{ old('batas_waktu', $disposisi->batas_waktu ? $disposisi->batas_waktu->format('Y-m-d') : '') }}" 
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all"
                    >
                    @error('batas_waktu')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="status" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                        Status Tindak Lanjut <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="status" 
                        id="status" 
                        required 
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all font-semibold"
                    >
                        <option value="menunggu" {{ old('status', $disposisi->status) === 'menunggu' ? 'selected' : '' }}>Menunggu Tindak Lanjut</option>
                        <option value="ditindaklanjuti" {{ old('status', $disposisi->status) === 'ditindaklanjuti' ? 'selected' : '' }}>Sedang Ditindaklanjuti</option>
                        <option value="selesai" {{ old('status', $disposisi->status) === 'selesai' ? 'selected' : '' }}>Selesai Dilaksanakan</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Catatan Khusus -->
            <div class="space-y-1.5">
                <label for="catatan" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                    Catatan Tambahan
                </label>
                <textarea 
                    name="catatan" 
                    id="catatan" 
                    rows="2" 
                    class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all"
                >{{ old('catatan', $disposisi->catatan) }}</textarea>
                @error('catatan')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a 
                    href="{{ route('kepsek.disposisi.show', $disposisi) }}" 
                    class="px-5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition-colors"
                >
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow-xs transition-colors cursor-pointer"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
