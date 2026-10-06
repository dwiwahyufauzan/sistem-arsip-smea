@extends('layouts.admin')

@section('title', 'Verifikasi Legalisir - ' . $legalisir->nomor_pengajuan)

@section('content')
<div class="space-y-6">

    <!-- Header & Breadcrumb -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-1">
                    <a href="{{ route('admin.legalisir.index') }}" class="hover:text-blue-600 transition-colors">&larr; Kembali ke Daftar Legalisir</a>
                    <span>•</span>
                    <span class="text-blue-600 font-mono">{{ $legalisir->nomor_pengajuan }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                        Lembar Verifikasi Berkas Legalisir
                    </h1>
                    <x-status-badge :status="$legalisir->status" type="legalisir" class="text-xs px-3 py-1" />
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    Diajukan secara daring pada <span class="font-semibold text-slate-700">{{ $legalisir->created_at->translatedFormat('l, d F Y, H:i') }} WIB</span>.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <a 
                    href="{{ route('legalisir.tanda-terima', $legalisir->nomor_pengajuan) }}" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition-colors"
                >
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak Tanda Terima</span>
                </a>

                <a 
                    href="{{ route('legalisir.download', $legalisir->id) }}" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-xl text-xs font-semibold transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Berkas Scan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Layout Grid: 2 Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- Left Column: Details & Document Preview (2 cols) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Card 1: Data Identitas Pemohon -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Data Pemohon & Pencocokan Buku Induk</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 font-medium block">Nama Lengkap Pemohon</span>
                        <span class="text-sm font-bold text-slate-900 block mt-0.5">{{ $legalisir->nama_pemohon }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">NISN / Tahun Kelulusan</span>
                        <span class="text-sm font-bold text-slate-900 block mt-0.5 font-mono">{{ $legalisir->nisn }} (Lulus: {{ $legalisir->tahun_lulus }})</span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Nomor WhatsApp / HP</span>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="font-mono text-slate-800 font-semibold">{{ $legalisir->nomor_whatsapp }}</span>
                            @php
                                $notifService = app(\App\Services\NotificationService::class);
                                $waUrl = $notifService->generateWhatsAppUrl($legalisir->nomor_whatsapp, $notifService->getLegalisirNotificationMessage($legalisir));
                            @endphp
                            <a 
                                href="{{ $waUrl }}" 
                                target="_blank"
                                class="inline-flex items-center gap-1.5 text-[11px] text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-300 px-2 py-0.5 rounded-lg font-bold transition-all shadow-2xs"
                                title="Kirim notifikasi otomatis via WhatsApp"
                            >
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                <span>Kirim WA &rarr;</span>
                            </a>
                        </div>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium block">Alamat Email</span>
                        <span class="text-slate-800 font-medium block mt-0.5">{{ $legalisir->email }}</span>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="text-slate-400 font-medium block">Keperluan Legalisir</span>
                        <p class="text-slate-800 font-medium mt-0.5 bg-slate-50 p-3 rounded-xl border border-slate-200">
                            {{ $legalisir->keperluan }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Dokumen yang Dimohonkan & Preview Berkas -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Dokumen Salinan Asli: {{ $legalisir->jenis_dokumen_label }}</span>
                    </h2>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200">
                        {{ $legalisir->jumlah_lembar }} Lembar Salinan
                    </span>
                </div>

                <!-- Preview File Container -->
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                    @php
                        $extension = strtolower(pathinfo($legalisir->file_dokumen_path ?? '', PATHINFO_EXTENSION));
                        $fileUrl = asset('storage/' . $legalisir->file_dokumen_path);
                    @endphp

                    @if($extension === 'pdf')
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-xs text-slate-600">
                                <span>Tampilan Pindaian Dokumen (PDF)</span>
                                <a href="{{ $fileUrl }}" target="_blank" class="text-blue-600 hover:underline font-semibold flex items-center gap-1">
                                    Buka di Tab Baru
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>
                            <div class="aspect-[4/3] w-full rounded-lg overflow-hidden border border-slate-300 bg-white shadow-inner">
                                <iframe src="{{ $fileUrl }}#toolbar=0" class="w-full h-full" title="Pratinjau Berkas PDF"></iframe>
                            </div>
                        </div>
                    @elseif(in_array($extension, ['jpg', 'jpeg', 'png']))
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-xs text-slate-600">
                                <span>Tampilan Pindaian Dokumen (Gambar)</span>
                                <a href="{{ $fileUrl }}" target="_blank" class="text-blue-600 hover:underline font-semibold">Lihat Resolusi Penuh</a>
                            </div>
                            <div class="max-h-[500px] overflow-auto rounded-lg border border-slate-300 bg-white p-2 flex items-center justify-center">
                                <img src="{{ $fileUrl }}" alt="Scan Dokumen" class="max-w-full h-auto object-contain rounded">
                            </div>
                        </div>
                    @else
                        <div class="p-6 text-center text-xs text-slate-500">
                            <p>Format berkas tidak mendukung pratinjau langsung.</p>
                            <a href="{{ route('legalisir.download', $legalisir->id) }}" class="mt-2 inline-flex items-center gap-1 text-blue-600 font-semibold hover:underline">
                                Unduh berkas fisik &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card 3: Jejak Riwayat & Audit Trail -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Kronologi & Jejak Audit Riwayat Legalisir</span>
                </h2>

                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @forelse($legalisir->riwayat as $idx => $hist)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center ring-8 ring-white">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <x-status-badge :status="$hist->status_baru" type="legalisir" />
                                                    <span class="text-xs text-slate-500 font-medium">oleh {{ $hist->user->name ?? 'Sistem' }}</span>
                                                </div>
                                                <p class="text-xs text-slate-700 mt-1 leading-relaxed bg-slate-50 p-2.5 rounded-lg border border-slate-200/60">
                                                    {{ $hist->catatan }}
                                                </p>
                                            </div>
                                            <div class="text-right text-xs whitespace-nowrap text-slate-400">
                                                <time datetime="{{ $hist->created_at }}">{{ $hist->created_at->translatedFormat('d M Y, H:i') }} WIB</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-xs text-slate-500 py-2">Belum ada riwayat tercatat.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>

        <!-- Right Column: Verification & Action Panel (1 col) -->
        <div class="space-y-6">

            <!-- Panel 1: Tindakan Petugas Tata Usaha -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6 space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">
                    Tindakan Verifikasi & Layanan
                </h3>

                <!-- Status Summary Box -->
                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs space-y-1.5">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Status Berkas:</span>
                        <x-status-badge :status="$legalisir->status" type="legalisir" />
                    </div>
                    @if($legalisir->tanggal_siap_ambil)
                        <div class="flex justify-between items-center pt-1 border-t border-slate-200">
                            <span class="text-slate-500 font-medium">Siap Diambil:</span>
                            <span class="font-bold text-emerald-700">{{ $legalisir->tanggal_siap_ambil->translatedFormat('d F Y') }}</span>
                        </div>
                    @endif
                </div>

                <!-- Action 1: Tahap Verifikasi Dokumen TU (If status == 'menunggu_verifikasi') -->
                @if($legalisir->status === 'menunggu_verifikasi')
                    <div class="border border-blue-200 bg-blue-50/50 rounded-xl p-4 space-y-3">
                        <h4 class="text-xs font-bold text-blue-900 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Langkah 1: Verifikasi Berkas Fisik</span>
                        </h4>
                        <p class="text-[11px] text-blue-800 leading-relaxed">
                            Pastikan data pemohon cocok dengan <strong>Buku Induk Kearsipan Kelulusan SMKN 1 Subang</strong> sebelum melanjutkan.
                        </p>

                        <form action="{{ route('admin.legalisir.verifikasi', $legalisir->id) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-700 mb-1">Pilihan Verifikasi:</label>
                                <select name="status" class="w-full text-xs bg-white border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600">
                                    <option value="menunggu_approval_kepsek" selected>Kirim ke Kepala Sekolah untuk Pengesahan</option>
                                    <option value="diverifikasi">Verifikasi Valid (Simpan Draf Verifikasi)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-700 mb-1">Catatan Hasil Verifikasi (Opsional):</label>
                                <textarea name="catatan_petugas" rows="2" placeholder="Contoh: Berkas sesuai dengan Buku Induk Angkatan 2022..." class="w-full text-xs bg-white border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-600"></textarea>
                            </div>

                            <button type="submit" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors cursor-pointer">
                                Konfirmasi Hasil Verifikasi &rarr;
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Action 2: Mulai Proses Cetak & Stempel (If status == 'disetujui_kepsek' or 'diverifikasi') -->
                @if(in_array($legalisir->status, ['disetujui_kepsek', 'diverifikasi']))
                    <div class="border border-purple-200 bg-purple-50/50 rounded-xl p-4 space-y-3">
                        <h4 class="text-xs font-bold text-purple-900 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            <span>Langkah 2: Cetak & Pembubuhan Stempel</span>
                        </h4>
                        <p class="text-[11px] text-purple-800 leading-relaxed">
                            Pengesahan pimpinan telah selesai. Cetak <strong>{{ $legalisir->jumlah_lembar }} lembar</strong> salinan fisik dokumen dan bubuhkan stempel legalisir basah.
                        </p>

                        <form action="{{ route('admin.legalisir.proses-cetak', $legalisir->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors cursor-pointer">
                                Tandai Sedang Dicetak & Distempel
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Action 3: Tetapkan Tanggal Siap Diambil (If status == 'sedang_diproses') -->
                @if($legalisir->status === 'sedang_diproses')
                    <div class="border border-emerald-200 bg-emerald-50/50 rounded-xl p-4 space-y-3">
                        <h4 class="text-xs font-bold text-emerald-900 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Langkah 3: Siap Diambil di Loket</span>
                        </h4>
                        <p class="text-[11px] text-emerald-800 leading-relaxed">
                            Dokumen fisik telah selesai dicap dan siap diserahkan kepada pemohon di loket TU SMKN 1 Subang.
                        </p>

                        <form action="{{ route('admin.legalisir.siap-diambil', $legalisir->id) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-700 mb-1">Tanggal Kesiapan Pengambilan: <span class="text-rose-500">*</span></label>
                                <input type="date" name="tanggal_siap_ambil" value="{{ date('Y-m-d') }}" required class="w-full text-xs bg-white border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-emerald-600">
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-700 mb-1">Instruksi Pengambilan Tambahan:</label>
                                <textarea name="catatan_petugas" rows="2" class="w-full text-xs bg-white border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-emerald-600" placeholder="Bawa kartu tanda pengenal dan nomor resi pendaftaran..."></textarea>
                            </div>

                            <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors cursor-pointer">
                                Terbitkan Status: SIAP DIAMBIL &rarr;
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Action 4: Penyerahan Selesai (If status == 'siap_diambil') -->
                @if($legalisir->status === 'siap_diambil')
                    <div class="border border-teal-200 bg-teal-50/50 rounded-xl p-4 space-y-3">
                        <h4 class="text-xs font-bold text-teal-900 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Langkah 4: Konfirmasi Penyerahan Fisik</span>
                        </h4>
                        <p class="text-[11px] text-teal-800 leading-relaxed">
                            Klik tombol di bawah ketika pemohon telah datang mengambil dokumen fisik di loket TU dan menandatangani tanda terima.
                        </p>

                        <form id="selesaiLegalisirForm" action="{{ route('admin.legalisir.selesai', $legalisir->id) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-700 mb-1">Tanggal Pengambilan Fisik:</label>
                                <input type="date" name="tanggal_pengambilan" value="{{ date('Y-m-d') }}" class="w-full text-xs bg-white border border-slate-300 rounded-lg p-2 focus:ring-2 focus:ring-teal-600">
                            </div>

                            <button 
                                type="button" 
                                onclick="confirmAction({
                                    title: 'Konfirmasi Penyerahan Fisik',
                                    subtitle: 'Penyelesaian layanan legalisir kearsipan',
                                    message: 'Apakah Anda yakin ingin menyelesaikan permohonan legalisir ini? Pastikan pemohon telah menerima berkas fisik dan menandatangani bukti pengambilan.',
                                    targetName: '{{ $legalisir->nama_pemohon }}',
                                    targetBadge: 'Resi: {{ $legalisir->nomor_pengajuan }}',
                                    type: 'success',
                                    confirmText: 'Ya, Selesaikan Layanan',
                                    onConfirm: () => document.getElementById('selesaiLegalisirForm').submit()
                                })" 
                                class="w-full py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors cursor-pointer"
                            >
                                Selesaikan Layanan Legalisir &check;
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Action 5: Penolakan Permohonan (Available unless already selesai or ditolak) -->
                @if(!in_array($legalisir->status, ['selesai', 'ditolak']))
                    <div class="pt-2 border-t border-slate-200">
                        <details class="group text-xs">
                            <summary class="font-semibold text-rose-600 hover:text-rose-700 cursor-pointer flex items-center justify-between p-2 rounded-lg hover:bg-rose-50 transition-colors">
                                <span>Tolak Permohonan Legalisir</span>
                                <span class="transition-transform group-open:rotate-180">&darr;</span>
                            </summary>
                            <form id="tolakLegalisirAdminForm" action="{{ route('admin.legalisir.tolak', $legalisir->id) }}" method="POST" class="mt-3 p-3 bg-rose-50 border border-rose-200 rounded-xl space-y-3">
                                @csrf
                                @method('PATCH')

                                <div>
                                    <label class="block text-[11px] font-semibold text-rose-900 mb-1">Alasan Penolakan Berkas: <span class="text-rose-600">*</span></label>
                                    <textarea id="catatanTolakAdmin" name="catatan_petugas" rows="3" required placeholder="Jelaskan alasan penolakan, misal: scan dokumen buram, tidak terdaftar pada buku induk..." class="w-full text-xs bg-white border border-rose-300 rounded-lg p-2 text-rose-950 focus:ring-2 focus:ring-rose-500"></textarea>
                                </div>

                                <button 
                                    type="button" 
                                    onclick="
                                        const note = document.getElementById('catatanTolakAdmin').value.trim();
                                        if (!note) {
                                            document.getElementById('catatanTolakAdmin').focus();
                                            return;
                                        }
                                        confirmAction({
                                            title: 'Konfirmasi Penolakan Berkas',
                                            subtitle: 'Penolakan permohonan verifikasi legalisir',
                                            message: 'Apakah Anda yakin ingin menolak permohonan legalisir ini?',
                                            targetName: '{{ $legalisir->nama_pemohon }}',
                                            targetBadge: 'Resi: {{ $legalisir->nomor_pengajuan }}',
                                            warning: 'Status permohonan akan diubah menjadi Ditolak dan catatan penolakan akan dicatat pada riwayat audit.',
                                            type: 'danger',
                                            confirmText: 'Ya, Tolak Permohonan',
                                            onConfirm: () => document.getElementById('tolakLegalisirAdminForm').submit()
                                        });
                                    " 
                                    class="w-full py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl transition-colors cursor-pointer"
                                >
                                    Konfirmasi Penolakan Berkas
                                </button>
                            </form>
                        </details>
                    </div>
                @endif

            </div>

            <!-- Panel 2: Info Petugas Bertanggung Jawab -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5 space-y-3 text-xs">
                <h4 class="font-bold text-slate-800 uppercase tracking-wider text-[11px]">Petugas Kearsipan Bertugas</h4>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">
                        {{ strtoupper(substr($legalisir->petugas->name ?? auth()->user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-900">{{ $legalisir->petugas->name ?? auth()->user()->name }}</p>
                        <p class="text-[11px] text-slate-500 font-mono">{{ $legalisir->petugas->nip_nisn ?? 'Staf Tata Usaha SMKN 1 Subang' }}</p>
                    </div>
                </div>
            </div>

            <!-- Panel 3: Layanan Notifikasi WhatsApp Pemohon -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl border border-emerald-200/90 shadow-2xs p-5 space-y-3 text-xs">
                <div class="flex items-center gap-2 text-emerald-950 font-bold text-xs">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    <span>Notifikasi WhatsApp Otomatis</span>
                </div>
                <p class="text-[11px] text-emerald-800 leading-relaxed">
                    Kirim template pesan resmi pembaruan status terkini ke nomor kontak <strong>{{ $legalisir->nama_pemohon }}</strong>.
                </p>
                <a 
                    href="{{ $waUrl }}" 
                    target="_blank"
                    class="w-full py-2.5 px-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors flex items-center justify-center gap-2 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    <span>Kirim Pesan WhatsApp Pemohon</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
