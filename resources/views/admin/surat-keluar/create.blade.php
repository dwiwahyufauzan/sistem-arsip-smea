@extends('layouts.admin')

@section('title', 'Buat Surat Keluar Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.surat-keluar.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Daftar Surat Keluar</span>
        </a>

        <span class="text-xs text-slate-400 font-mono">Format Agenda: SK/YYYY/XXX</span>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-5 bg-slate-50/75 border-b border-slate-200/80">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-slate-900">Registrasi Surat Keluar Baru</h1>
                    <p class="text-xs text-slate-500">Mencatat draf surat dinas eksternal dan mengunggah berkas rancangan dokumen.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.surat-keluar.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
            @csrf

            <!-- Bagian 1: Nomor Agenda & Klasifikasi -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-blue-900 border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>1. Informasi Registrasi & Klasifikasi Surat Keluar</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Nomor Agenda -->
                    <div>
                        <label for="nomor_agenda" class="block text-xs font-semibold text-slate-700 mb-1">
                            Nomor Agenda Surat <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="nomor_agenda" 
                                name="nomor_agenda" 
                                value="{{ old('nomor_agenda', $nomorAgendaOtomatis) }}" 
                                required
                                class="w-full px-3.5 py-2 text-xs sm:text-sm font-mono font-bold rounded-xl border {{ $errors->has('nomor_agenda') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            >
                            <span class="absolute right-3 top-2.5 text-[10px] bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded font-medium border border-blue-200/60">
                                Otomatis
                            </span>
                        </div>
                        @error('nomor_agenda')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori Klasifikasi -->
                    <div>
                        <label for="kategori_id" class="block text-xs font-semibold text-slate-700 mb-1">
                            Kategori Klasifikasi Dinas <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            id="kategori_id" 
                            name="kategori_id" 
                            required 
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border {{ $errors->has('kategori_id') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-slate-800"
                        >
                            <option value="">-- Pilih Kode Klasifikasi --</option>
                            @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->kode_kategori }} - {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Awal -->
                    <div>
                        <label for="status_persetujuan" class="block text-xs font-semibold text-slate-700 mb-1">
                            Status Awal Dokumen <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            id="status_persetujuan" 
                            name="status_persetujuan" 
                            required 
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 text-slate-800"
                        >
                            <option value="draft" {{ old('status_persetujuan') === 'draft' ? 'selected' : '' }}>Simpan sebagai Draf Konsep</option>
                            <option value="menunggu_persetujuan" {{ old('status_persetujuan') === 'menunggu_persetujuan' ? 'selected' : '' }}>Langsung Ajukan ke Kepala Sekolah</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Detail Surat Keluar -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-blue-900 border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>2. Detail Isi & Tujuan Surat Keluar</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nomor Surat -->
                    <div>
                        <label for="nomor_surat" class="block text-xs font-semibold text-slate-700 mb-1">
                            Nomor Surat Keluar Resmi <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nomor_surat" 
                            name="nomor_surat" 
                            value="{{ old('nomor_surat') }}" 
                            required
                            placeholder="Contoh: 421.5/095-SMKN1/IX/2026"
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border {{ $errors->has('nomor_surat') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        >
                        @error('nomor_surat')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Surat -->
                    <div>
                        <label for="tanggal_surat" class="block text-xs font-semibold text-slate-700 mb-1">
                            Tanggal Surat Diterbitkan <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            id="tanggal_surat" 
                            name="tanggal_surat" 
                            value="{{ old('tanggal_surat', date('Y-m-d')) }}" 
                            required
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border {{ $errors->has('tanggal_surat') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} focus:outline-none focus:border-blue-500"
                        >
                    </div>

                    <!-- Tujuan Surat -->
                    <div class="md:col-span-2">
                        <label for="tujuan" class="block text-xs font-semibold text-slate-700 mb-1">
                            Pihak / Instansi Tujuan Surat <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="tujuan" 
                            name="tujuan" 
                            value="{{ old('tujuan') }}" 
                            required
                            placeholder="Contoh: Kepala Dinas Pendidikan Provinsi Jawa Barat, Orang Tua/Wali Siswa Kelas XII, PT. Pindad (Persero)"
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border {{ $errors->has('tujuan') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        >
                        @error('tujuan')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Perihal -->
                    <div class="md:col-span-2">
                        <label for="perihal" class="block text-xs font-semibold text-slate-700 mb-1">
                            Perihal Surat <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="perihal" 
                            name="perihal" 
                            value="{{ old('perihal') }}" 
                            required
                            placeholder="Contoh: Permohonan Pengesahan Kurikulum Merdeka atau Pemberitahuan Sosialisasi BKK"
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border {{ $errors->has('perihal') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        >
                        @error('perihal')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Isi Ringkas -->
                    <div class="md:col-span-2">
                        <label for="isi_ringkas" class="block text-xs font-semibold text-slate-700 mb-1">
                            Ringkasan Isi / Catatan Pengantar Surat
                        </label>
                        <textarea 
                            id="isi_ringkas" 
                            name="isi_ringkas" 
                            rows="3"
                            placeholder="Intisari surat keluar atau poin penting yang disampaikan kepada penerima..."
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500"
                        >{{ old('isi_ringkas') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Unggah Berkas Draf Dokumen -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-blue-900 border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>3. Berkas Draf Dokumen Surat Keluar (Maks 5 MB)</span>
                </h3>

                <div class="border-2 border-dashed {{ $errors->has('berkas') ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200 bg-slate-50/50' }} hover:border-blue-400 transition-colors rounded-2xl p-6 text-center relative">
                    <input 
                        type="file" 
                        id="berkas" 
                        name="berkas" 
                        accept=".pdf,.jpg,.jpeg,.png"
                        required
                        onchange="handleFileSelect(this)"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    >
                    <div id="dropzoneDefault" class="space-y-2">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mx-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        </div>
                        <div class="text-xs text-slate-600">
                            <span class="font-semibold text-blue-600 hover:underline">Pilih berkas</span> atau seret dokumen draf ke sini
                        </div>
                        <p class="text-[11px] text-slate-400">
                            Mendukung berkas format: <strong>PDF, JPG, JPEG, PNG</strong> (Maksimal 5.0 MB)
                        </p>
                    </div>

                    <div id="dropzoneSelected" class="hidden space-y-2">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                        <p id="selectedFileName" class="text-xs font-bold text-slate-800 font-mono"></p>
                        <p id="selectedFileSize" class="text-[11px] text-slate-500"></p>
                        <span class="text-[10px] text-blue-600 font-medium inline-block hover:underline">Klik untuk mengganti</span>
                    </div>
                </div>

                @error('berkas')
                    <p class="text-[11px] text-rose-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.surat-keluar.index') }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs sm:text-sm font-semibold transition-all shadow-sm shadow-blue-500/20 active:scale-[0.98] flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Surat Keluar</span>
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    function handleFileSelect(input) {
        const defaultBox = document.getElementById('dropzoneDefault');
        const selectedBox = document.getElementById('dropzoneSelected');
        const fileNameEl = document.getElementById('selectedFileName');
        const fileSizeEl = document.getElementById('selectedFileSize');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const sizeInMb = (file.size / (1024 * 1024)).toFixed(2);

            if (file.size > 5 * 1024 * 1024) {
                alert('Peringatan: Ukuran berkas (' + sizeInMb + ' MB) melebihi batas maksimal 5 MB.');
                input.value = '';
                defaultBox.classList.remove('hidden');
                selectedBox.classList.add('hidden');
                return;
            }

            fileNameEl.textContent = file.name;
            fileSizeEl.textContent = 'Ukuran: ' + sizeInMb + ' MB (' + (file.size / 1024).toFixed(1) + ' KB)';
            defaultBox.classList.add('hidden');
            selectedBox.classList.remove('hidden');
        }
    }
</script>
@endsection
