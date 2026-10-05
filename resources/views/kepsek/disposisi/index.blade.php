@extends('layouts.kepsek')

@section('title', 'Disposisi Surat Masuk')

@section('content')
<div class="space-y-6">

    <!-- Modern Page Header -->
    <x-page-header 
        title="Disposisi Surat Masuk" 
        subtitle="Pemberian Arahan & Instruksi Tindak Lanjut Surat Masuk ke Unit Kerja"
        overline="Panel Kebijakan Pimpinan • SRS-KS06"
    >
        <x-slot:actions>
            <a 
                href="{{ route('kepsek.disposisi.create') }}" 
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow-md shadow-emerald-700/20 transition-all active:scale-[0.98]"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Buat Disposisi Baru</span>
            </a>
        </x-slot:actions>
    </x-page-header>

    <!-- 1. Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Menunggu -->
        <a href="{{ route('kepsek.disposisi.index', ['status' => 'menunggu']) }}" class="card-modern p-5 transition-all hover:shadow-md {{ $status === 'menunggu' ? 'border-amber-400 ring-2 ring-amber-400/20' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Tindak Lanjut</p>
                    <p class="text-2xl font-extrabold text-amber-600 mt-1 font-heading">{{ $stats['menunggu'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Instruksi belum diproses oleh unit kerja</p>
        </a>

        <!-- Ditindaklanjuti -->
        <a href="{{ route('kepsek.disposisi.index', ['status' => 'ditindaklanjuti']) }}" class="card-modern p-5 transition-all hover:shadow-md {{ $status === 'ditindaklanjuti' ? 'border-blue-400 ring-2 ring-blue-400/20' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sedang Diproses</p>
                    <p class="text-2xl font-extrabold text-blue-600 mt-1 font-heading">{{ $stats['ditindaklanjuti'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Staf/Waka sedang menindaklanjuti arahan</p>
        </a>

        <!-- Selesai -->
        <a href="{{ route('kepsek.disposisi.index', ['status' => 'selesai']) }}" class="card-modern p-5 transition-all hover:shadow-md {{ $status === 'selesai' ? 'border-emerald-400 ring-2 ring-emerald-400/20' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Selesai Dilaksanakan</p>
                    <p class="text-2xl font-extrabold text-emerald-600 mt-1 font-heading">{{ $stats['selesai'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Instruksi tuntas dijalankan</p>
        </a>

        <!-- Total Disposisi -->
        <a href="{{ route('kepsek.disposisi.index', ['status' => 'semua']) }}" class="card-modern p-5 transition-all hover:shadow-md {{ $status === 'semua' ? 'border-emerald-700 ring-2 ring-emerald-700/20' : '' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Lembar Disposisi</p>
                    <p class="text-2xl font-extrabold text-slate-900 mt-1 font-heading">{{ $stats['total'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Rekapitulasi seluruh arahan surat</p>
        </a>
    </div>

    <!-- 2. Filter & Search Controls -->
    <div class="card-modern p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Status Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 text-xs">
            <a href="{{ route('kepsek.disposisi.index', ['status' => 'semua', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ $status === 'semua' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua ({{ $stats['total'] }})
            </a>
            <a href="{{ route('kepsek.disposisi.index', ['status' => 'menunggu', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ $status === 'menunggu' ? 'bg-amber-500 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Menunggu ({{ $stats['menunggu'] }})
            </a>
            <a href="{{ route('kepsek.disposisi.index', ['status' => 'ditindaklanjuti', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ $status === 'ditindaklanjuti' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Sedang Diproses ({{ $stats['ditindaklanjuti'] }})
            </a>
            <a href="{{ route('kepsek.disposisi.index', ['status' => 'selesai', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ $status === 'selesai' ? 'bg-emerald-700 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Selesai ({{ $stats['selesai'] }})
            </a>
        </div>

        <!-- Keyword Search -->
        <form action="{{ route('kepsek.disposisi.index') }}" method="GET" class="flex items-center gap-2 max-w-md w-full">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $search }}" 
                    placeholder="Cari instruksi, pejabat tujuan, nomor surat..."
                    class="input-modern w-full pl-9 pr-8 py-2 text-xs"
                >
                @if($search)
                    <a href="{{ route('kepsek.disposisi.index', ['status' => $status]) }}" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
            </div>
            <button type="submit" class="px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-semibold shrink-0 transition-all shadow-xs active:scale-[0.98]">
                Cari
            </button>
        </form>
    </div>

    <!-- 3. Disposisi Table -->
    <div class="card-modern overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-bold uppercase text-[11px] tracking-wider">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Surat Masuk Terkait</th>
                        <th class="py-3.5 px-4">Diteruskan Kepada</th>
                        <th class="py-3.5 px-4">Instruksi Pimpinan</th>
                        <th class="py-3.5 px-4">Batas Waktu</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($disposisiList as $index => $disp)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 text-center font-medium text-slate-400">
                                {{ $disposisiList->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-mono font-bold text-slate-900 block">{{ $disp->suratMasuk->nomor_agenda }}</span>
                                <span class="font-semibold text-slate-700 block truncate max-w-xs" title="{{ $disp->suratMasuk->nomor_surat }}">{{ $disp->suratMasuk->nomor_surat }}</span>
                                <span class="text-[11px] text-slate-400 block truncate max-w-xs mt-0.5">Dari: {{ $disp->suratMasuk->pengirim }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 font-semibold border border-emerald-200 text-[11px]">
                                    <svg class="w-3 h-3 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>{{ $disp->tujuan_disposisi }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <p class="font-medium text-slate-800 line-clamp-2 max-w-xs" title="{{ $disp->instruksi }}">{{ $disp->instruksi }}</p>
                                @if($disp->catatan)
                                    <p class="text-[11px] text-slate-400 italic line-clamp-1 mt-0.5">Catatan: {{ $disp->catatan }}</p>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($disp->batas_waktu)
                                    <span class="font-medium text-slate-700 block">{{ $disp->batas_waktu->isoFormat('D MMMM Y') }}</span>
                                    @php
                                        $diffDays = now()->startOfDay()->diffInDays($disp->batas_waktu, false);
                                    @endphp
                                    @if($diffDays < 0 && $disp->status !== 'selesai')
                                        <span class="text-[10px] font-bold text-rose-600 block">Lewat batas waktu</span>
                                    @elseif($diffDays >= 0 && $diffDays <= 2 && $disp->status !== 'selesai')
                                        <span class="text-[10px] font-bold text-amber-600 block">{{ $diffDays }} hari lagi</span>
                                    @endif
                                @else
                                    <span class="text-slate-400 italic text-[11px]">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($disp->status === 'selesai')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Selesai
                                    </span>
                                @elseif($disp->status === 'ditindaklanjuti')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                        Diproses
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Detail -->
                                    <a 
                                        href="{{ route('kepsek.disposisi.show', $disp) }}" 
                                        class="p-1.5 text-slate-500 hover:text-emerald-700 hover:bg-slate-100 rounded-lg transition-colors"
                                        title="Lihat Detail Lembar Disposisi"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <!-- Cetak Lembar Resmi -->
                                    <a 
                                        href="{{ route('kepsek.disposisi.cetak', $disp) }}" 
                                        target="_blank" 
                                        class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors"
                                        title="Cetak Lembar Disposisi Standar Sekolah"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    </a>

                                    <!-- Edit -->
                                    <a 
                                        href="{{ route('kepsek.disposisi.edit', $disp) }}" 
                                        class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-slate-100 rounded-lg transition-colors"
                                        title="Ubah Arahan Disposisi"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Hapus -->
                                    <button 
                                        type="button" 
                                        onclick="confirmDelete('{{ route('kepsek.disposisi.destroy', $disp) }}', 'Disposisi untuk surat {{ addslashes($disp->suratMasuk->nomor_agenda) }}')"
                                        class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition-colors cursor-pointer"
                                        title="Hapus Lembar Disposisi"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-empty-state 
                            colspan="7" 
                            title="Belum Ada Lembar Disposisi" 
                            description="Klik tombol '+ Buat Disposisi Baru' untuk memberikan arahan tindak lanjut pada surat masuk." 
                        />
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($disposisiList->hasPages())
            <div class="p-4 bg-slate-50/75 border-t border-slate-200">
                {{ $disposisiList->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden transition-opacity duration-200" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity" onclick="closeDeleteModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all duration-200 text-slate-800 animate-in fade-in zoom-in-95">
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="p-6 pb-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 border bg-rose-50 text-rose-600 border-rose-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </div>
                        <div class="flex-grow pt-0.5">
                            <h3 class="font-heading font-bold text-base text-slate-900 leading-snug">Konfirmasi Hapus Disposisi</h3>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">Tindakan ini akan membatalkan instruksi tindak lanjut pimpinan.</p>
                        </div>
                        <button type="button" onclick="closeDeleteModal()" class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer shrink-0" title="Tutup (Esc)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <div class="px-6 pb-5 space-y-3 text-xs">
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 space-y-1">
                        <p class="text-slate-500 text-[11px]">Sasaran Disposisi:</p>
                        <p id="deleteTargetName" class="font-bold text-slate-900"></p>
                    </div>

                    <div class="p-3 rounded-xl border text-[11px] leading-relaxed font-medium bg-amber-50/80 text-amber-800 border-amber-200">
                        Catatan: Surat masuk terkait akan dikembalikan ke status 'Diterima' jika tidak memiliki lembar disposisi aktif lainnya.
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors cursor-pointer shadow-2xs">
                        Batal
                    </button>
                    <button type="submit" class="px-4.5 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-xs transition-colors cursor-pointer flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Ya, Hapus Disposisi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(actionUrl, name) {
        document.getElementById('deleteForm').action = actionUrl;
        document.getElementById('deleteTargetName').textContent = name;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endpush
@endsection
