@extends('layouts.admin')

@section('title', 'Edit Surat Keluar - ' . $surat_keluar->nomor_surat)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Top Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.surat-keluar.show', $surat_keluar) }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Detail Surat</span>
        </a>

        <span class="text-xs text-slate-400 font-mono">ID Arsip: #{{ $surat_keluar->id }}</span>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="px-6 py-5 bg-slate-50/75 border-b border-slate-200/80">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-slate-900">Perbarui Surat Keluar</h1>
                    <p class="text-xs text-slate-500">Edit data registrasi, perbarui berkas dokumen draf, atau sesuaikan status persetujuan.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.surat-keluar.update', $surat_keluar) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Bagian 1: Nomor Agenda, Kategori, & Status -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-blue-900 border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>1. Informasi Registrasi & Status Persetujuan</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Nomor Agenda -->
                    <div>
                        <label for="nomor_agenda" class="block text-xs font-semibold text-slate-700 mb-1">
                            Nomor Agenda Surat <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nomor_agenda" 
                            name="nomor_agenda" 
                            value="{{ old('nomor_agenda', $surat_keluar->nomor_agenda) }}" 
                            required
                            class="w-full px-3.5 py-2 text-xs sm:text-sm font-mono font-bold rounded-xl border {{ $errors->has('nomor_agenda') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} focus:outline-none focus:border-blue-500"
                        >
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
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border {{ $errors->has('kategori_id') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} focus:outline-none focus:border-blue-500 text-slate-800"
                        >
                            @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $surat_keluar->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->kode_kategori }} - {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Persetujuan -->
                    <div>
                        <label for="status_persetujuan" class="block text-xs font-semibold text-slate-700 mb-1">
                            Status Persetujuan <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            id="status_persetujuan" 
                            name="status_persetujuan" 
                            required 
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border {{ $errors->has('status_persetujuan') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} focus:outline-none focus:border-blue-500 text-slate-800"
                        >
                            <option value="draft" {{ old('status_persetujuan', $surat_keluar->status_persetujuan) === 'draft' ? 'selected' : '' }}>Draf Konsep</option>
                            <option value="menunggu_persetujuan" {{ old('status_persetujuan', $surat_keluar->status_persetujuan) === 'menunggu_persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan Kepsek</option>
                            <option value="disetujui" {{ old('status_persetujuan', $surat_keluar->status_persetujuan) === 'disetujui' ? 'selected' : '' }}>Disetujui Kepsek</option>
                            <option value="ditolak" {{ old('status_persetujuan', $surat_keluar->status_persetujuan) === 'ditolak' ? 'selected' : '' }}>Ditolak / Perlu Revisi</option>
                        </select>
                        @error('status_persetujuan')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
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
                    <div>
                        <label for="nomor_surat" class="block text-xs font-semibold text-slate-700 mb-1">
                            Nomor Surat Keluar Resmi <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="nomor_surat" 
                            name="nomor_surat" 
                            value="{{ old('nomor_surat', $surat_keluar->nomor_surat) }}" 
                            required
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border {{ $errors->has('nomor_surat') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} focus:outline-none focus:border-blue-500"
                        >
                        @error('nomor_surat')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_surat" class="block text-xs font-semibold text-slate-700 mb-1">
                            Tanggal Surat Diterbitkan <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            id="tanggal_surat" 
                            name="tanggal_surat" 
                            value="{{ old('tanggal_surat', $surat_keluar->tanggal_surat->format('Y-m-d')) }}" 
                            required
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label for="tujuan" class="block text-xs font-semibold text-slate-700 mb-1">
                            Pihak / Instansi Tujuan Surat <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="tujuan" 
                            name="tujuan" 
                            value="{{ old('tujuan', $surat_keluar->tujuan) }}" 
                            required
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border {{ $errors->has('tujuan') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} focus:outline-none focus:border-blue-500"
                        >
                        @error('tujuan')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="perihal" class="block text-xs font-semibold text-slate-700 mb-1">
                            Perihal Surat <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="perihal" 
                            name="perihal" 
                            value="{{ old('perihal', $surat_keluar->perihal) }}" 
                            required
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border {{ $errors->has('perihal') ? 'border-rose-400 bg-rose-50/30' : 'border-slate-200' }} focus:outline-none focus:border-blue-500"
                        >
                        @error('perihal')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="isi_ringkas" class="block text-xs font-semibold text-slate-700 mb-1">
                            Ringkasan Isi / Catatan Pengantar Surat
                        </label>
                        <textarea 
                            id="isi_ringkas" 
                            name="isi_ringkas" 
                            rows="3"
                            class="w-full px-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500"
                        >{{ old('isi_ringkas', $surat_keluar->isi_ringkas) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Berkas Dokumen & Penggantian -->
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-blue-900 border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    <span>3. Berkas Dokumen Surat Keluar</span>
                </h3>

                <!-- Info Berkas Aktif -->
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/80 mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">{{ $surat_keluar->file_name }}</p>
                            <p class="text-[11px] text-slate-500 font-mono">Ukuran: {{ $surat_keluar->file_size_formatted }}</p>
                        </div>
                    </div>

                    @if($surat_keluar->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($surat_keluar->file_path))
                        <div class="flex items-center gap-2">
                            <button 
                                type="button" 
                                onclick="window.openPdfModal('{{ asset('storage/' . $surat_keluar->file_path) }}', 'Surat Keluar: {{ addslashes($surat_keluar->nomor_surat) }}')"
                                class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-lg text-xs font-semibold transition-colors"
                            >
                                Pratinjau Dokumen
                            </button>
                            <a 
                                href="{{ route('admin.surat-keluar.download', $surat_keluar) }}" 
                                class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-semibold transition-colors"
                            >
                                Unduh
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Dropzone Penggantian Berkas -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        Unggah Berkas Pengganti <span class="text-slate-400 font-normal">(Opsional - biarkan kosong jika berkas draf tidak direvisi)</span>
                    </label>

                    <div class="border-2 border-dashed {{ $errors->has('berkas') ? 'border-rose-400 bg-rose-50/20' : 'border-slate-200 bg-slate-50/50' }} hover:border-blue-400 transition-colors rounded-2xl p-5 text-center relative">
                        <input 
                            type="file" 
                            id="berkas" 
                            name="berkas" 
                            accept=".pdf,.jpg,.jpeg,.png"
                            onchange="handleFileSelect(this)"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        >
                        <div id="dropzoneDefault" class="space-y-1">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mx-auto">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <div class="text-xs text-slate-600">
                                <span class="font-semibold text-blue-600 hover:underline">Pilih berkas baru</span> untuk mengganti draf dokumen
                            </div>
                            <p class="text-[10px] text-slate-400">PDF, JPG, JPEG, PNG (Maks 5 MB)</p>
                        </div>

                        <div id="dropzoneSelected" class="hidden space-y-1">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </div>
                            <p id="selectedFileName" class="text-xs font-bold text-slate-800 font-mono"></p>
                            <p id="selectedFileSize" class="text-[10px] text-slate-500"></p>
                        </div>
                    </div>

                    @error('berkas')
                        <p class="text-[11px] text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.surat-keluar.show', $surat_keluar) }}" class="px-5 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-xl text-xs sm:text-sm transition-all shadow-sm active:scale-[0.98] flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan Perubahan</span>
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
                showAlertModal('Peringatan Ukuran Berkas', 'Ukuran berkas (' + sizeInMb + ' MB) melebihi batas maksimal 5 MB. Harap pilih berkas pindaian yang lebih kecil atau kompres berkas.', 'warning');
                input.value = '';
                defaultBox.classList.remove('hidden');
                selectedBox.classList.add('hidden');
                return;
            }

            fileNameEl.textContent = file.name;
            fileSizeEl.textContent = 'Berkas baru dipilih: ' + sizeInMb + ' MB';
            defaultBox.classList.add('hidden');
            selectedBox.classList.remove('hidden');
        }
    }
</script>
@endsection
