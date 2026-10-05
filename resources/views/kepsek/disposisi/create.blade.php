@extends('layouts.kepsek')

@section('title', 'Buat Lembar Disposisi Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Back Button Bar -->
    <div class="flex items-center justify-between">
        <a 
            href="{{ route('kepsek.disposisi.index') }}" 
            class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-emerald-800 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Daftar Disposisi</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-4 bg-slate-50/75 border-b border-slate-200/80 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-800">Formulir Penerbitan Lembar Disposisi Pimpinan</h2>
                    <p class="text-[11px] text-slate-400">SMK Negeri 1 Subang — Format Resmi Kedinasan</p>
                </div>
            </div>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                Otoritas Kepala Sekolah
            </span>
        </div>

        <form action="{{ route('kepsek.disposisi.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- 1. Pemilihan Surat Masuk -->
            <div class="space-y-2">
                <label for="surat_masuk_id" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                    Surat Masuk yang Didisposisikan <span class="text-rose-500">*</span>
                </label>

                @if($selectedSuratMasuk)
                    <!-- Kartu Ringkasan Surat Masuk yang Terpilih -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-xs bg-white text-slate-800 px-2.5 py-1 rounded-lg border border-slate-200 shadow-2xs">
                                    {{ $selectedSuratMasuk->nomor_agenda }}
                                </span>
                                <span class="font-bold text-slate-900 text-xs">{{ $selectedSuratMasuk->nomor_surat }}</span>
                            </div>
                            <span class="text-[11px] text-slate-500 font-medium">
                                Tanggal Terima: {{ $selectedSuratMasuk->tanggal_terima->isoFormat('D MMMM Y') }}
                            </span>
                        </div>
                        <div class="text-xs text-slate-600">
                            <p><span class="text-slate-400">Pengirim:</span> <strong>{{ $selectedSuratMasuk->pengirim }}</strong></p>
                            <p class="mt-0.5"><span class="text-slate-400">Perihal:</span> {{ $selectedSuratMasuk->perihal }}</p>
                        </div>
                        <input type="hidden" name="surat_masuk_id" value="{{ $selectedSuratMasuk->id }}">
                    </div>
                @else
                    <!-- Dropdown Pemilihan Surat Masuk -->
                    <select 
                        name="surat_masuk_id" 
                        id="surat_masuk_id" 
                        required 
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all"
                    >
                        <option value="">-- Pilih Surat Masuk --</option>
                        @foreach($suratMasukList as $sm)
                            <option value="{{ $sm->id }}" {{ old('surat_masuk_id') == $sm->id ? 'selected' : '' }}>
                                [{{ $sm->nomor_agenda }}] {{ $sm->nomor_surat }} — {{ Str::limit($sm->perihal, 50) }} (Dari: {{ $sm->pengirim }})
                            </option>
                        @endforeach
                    </select>
                @endif
                @error('surat_masuk_id')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Tujuan Disposisi (Pejabat / Unit Kerja) -->
            <div class="space-y-2">
                <label for="tujuan_disposisi" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                    Diteruskan Kepada (Tujuan Disposisi) <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="tujuan_disposisi" 
                    id="tujuan_disposisi" 
                    value="{{ old('tujuan_disposisi') }}"
                    required 
                    placeholder="Contoh: Wakil Kepala Sekolah Bidang Kurikulum"
                    class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all font-medium"
                >
                @error('tujuan_disposisi')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror

                <!-- Quick Selection Chips Pejabat Sekolah -->
                <div>
                    <span class="text-[10px] font-semibold text-slate-400 block mb-1.5 uppercase tracking-wider">Pilih Cepat Pejabat / Unit Kerja:</span>
                    <div class="flex flex-wrap gap-1.5">
                        @php
                            $pejabats = [
                                'Waka Bidang Kurikulum',
                                'Waka Bidang Kesiswaan',
                                'Waka Bidang Hubinmas',
                                'Waka Bidang Sarpras',
                                'Kepala Tata Usaha (KTU)',
                                'Pembina OSIS & Ekskul',
                                'Koordinator BK',
                                'Bendahara Sekolah',
                                'Staf Pengarsipan Persuratan',
                            ];
                        @endphp
                        @foreach($pejabats as $pj)
                            <button 
                                type="button" 
                                onclick="setTujuanDisposisi('{{ $pj }}')"
                                class="px-2.5 py-1 text-[11px] font-medium bg-slate-100 hover:bg-emerald-50 hover:text-emerald-800 text-slate-700 rounded-lg border border-slate-200/80 transition-colors cursor-pointer"
                            >
                                + {{ $pj }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- 3. Instruksi / Arahan Pimpinan -->
            <div class="space-y-2">
                <label for="instruksi" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                    Instruksi / Disposisi Pimpinan <span class="text-rose-500">*</span>
                </label>
                <textarea 
                    name="instruksi" 
                    id="instruksi" 
                    rows="3" 
                    required 
                    placeholder="Tuliskan arahan/instruksi tindak lanjut surat secara jelas..."
                    class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all"
                >{{ old('instruksi') }}</textarea>
                @error('instruksi')
                    <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                @enderror

                <!-- Quick Instruction Chips -->
                <div>
                    <span class="text-[10px] font-semibold text-slate-400 block mb-1.5 uppercase tracking-wider">Pilihan Cepat Instruksi Standar:</span>
                    <div class="flex flex-wrap gap-1.5">
                        @php
                            $instruksis = [
                                'Tindak lanjuti segera dan laporkan hasilnya',
                                'Pelajari substansi surat dan koordinasikan dengan bagian terkait',
                                'Siapkan bahan rapat / koordinasi internal',
                                'Siapkan konsep tanggapan / surat balasan resmi',
                                'Hadiri atau wakilkan kegiatan sesuai jadwal terlampir',
                                'Simpan, catat, dan arsipkan dengan baik',
                            ];
                        @endphp
                        @foreach($instruksis as $ins)
                            <button 
                                type="button" 
                                onclick="setInstruksi('{{ $ins }}')"
                                class="px-2.5 py-1 text-[11px] font-medium bg-slate-100 hover:bg-emerald-50 hover:text-emerald-800 text-slate-700 rounded-lg border border-slate-200/80 transition-colors cursor-pointer"
                            >
                                {{ $ins }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- 4. Batas Waktu & Catatan Tambahan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="batas_waktu" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                        Batas Waktu Tindak Lanjut (Deadline)
                    </label>
                    <input 
                        type="date" 
                        name="batas_waktu" 
                        id="batas_waktu" 
                        value="{{ old('batas_waktu') }}"
                        class="w-full px-3.5 py-2.5 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all"
                    >
                    <p class="text-[10px] text-slate-400">Kosongkan jika tidak ada tenggat waktu khusus.</p>
                    @error('batas_waktu')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="catatan" class="block text-xs font-bold text-slate-800 uppercase tracking-wider">
                        Catatan Khusus Pimpinan (Opsional)
                    </label>
                    <textarea 
                        name="catatan" 
                        id="catatan" 
                        rows="2" 
                        placeholder="Catatan tambahan bila diperlukan..."
                        class="w-full px-3.5 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:border-transparent transition-all"
                    >{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a 
                    href="{{ route('kepsek.disposisi.index') }}" 
                    class="px-5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition-colors"
                >
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-700/20 transition-all flex items-center gap-2 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Terbitkan Lembar Disposisi</span>
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    function setTujuanDisposisi(val) {
        const input = document.getElementById('tujuan_disposisi');
        input.value = val;
        input.focus();
    }

    function setInstruksi(val) {
        const textarea = document.getElementById('instruksi');
        textarea.value = val;
        textarea.focus();
    }
</script>
@endpush
@endsection
