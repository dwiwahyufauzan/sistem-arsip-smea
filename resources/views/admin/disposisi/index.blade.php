@extends('layouts.admin')

@section('title', 'Disposisi Pimpinan')
@section('page_title', 'Disposisi Pimpinan')
@section('page_subtitle', 'Monitoring Instruksi & Tindak Lanjut Surat Masuk dari Kepala Sekolah')

@section('content')
<div class="space-y-6">

    <!-- 1. Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Menunggu -->
        <a href="{{ route('admin.disposisi.index', ['status' => 'menunggu']) }}" class="block p-5 bg-white rounded-2xl border transition-all hover:shadow-md {{ $status === 'menunggu' ? 'border-amber-400 ring-2 ring-amber-400/20' : 'border-slate-200/80' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu Diproses</p>
                    <p class="text-2xl font-extrabold text-amber-600 mt-1 font-heading">{{ $stats['menunggu'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Instruksi belum dijalankan unit kerja</p>
        </a>

        <!-- Sedang Diproses -->
        <a href="{{ route('admin.disposisi.index', ['status' => 'ditindaklanjuti']) }}" class="block p-5 bg-white rounded-2xl border transition-all hover:shadow-md {{ $status === 'ditindaklanjuti' ? 'border-blue-500 ring-2 ring-blue-500/20' : 'border-slate-200/80' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sedang Ditindaklanjuti</p>
                    <p class="text-2xl font-extrabold text-blue-600 mt-1 font-heading">{{ $stats['ditindaklanjuti'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Dalam proses penanganan unit kerja</p>
        </a>

        <!-- Selesai -->
        <a href="{{ route('admin.disposisi.index', ['status' => 'selesai']) }}" class="block p-5 bg-white rounded-2xl border transition-all hover:shadow-md {{ $status === 'selesai' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-slate-200/80' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Telah Selesai</p>
                    <p class="text-2xl font-extrabold text-emerald-600 mt-1 font-heading">{{ $stats['selesai'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Instruksi selesai dilaksanakan</p>
        </a>

        <!-- Total -->
        <a href="{{ route('admin.disposisi.index', ['status' => 'semua']) }}" class="block p-5 bg-white rounded-2xl border transition-all hover:shadow-md {{ $status === 'semua' ? 'border-slate-800 ring-2 ring-slate-800/20' : 'border-slate-200/80' }}">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Disposisi</p>
                    <p class="text-2xl font-extrabold text-slate-900 mt-1 font-heading">{{ $stats['total'] }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <p class="text-[11px] text-slate-400 mt-3 font-medium">Seluruh arahan pimpinan</p>
        </a>
    </div>

    <!-- 2. Controls & Search -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Status Filter Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 text-xs">
            <a href="{{ route('admin.disposisi.index', ['status' => 'semua', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ $status === 'semua' ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua Disposisi ({{ $stats['total'] }})
            </a>
            <a href="{{ route('admin.disposisi.index', ['status' => 'menunggu', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ $status === 'menunggu' ? 'bg-amber-500 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Menunggu ({{ $stats['menunggu'] }})
            </a>
            <a href="{{ route('admin.disposisi.index', ['status' => 'ditindaklanjuti', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ $status === 'ditindaklanjuti' ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Sedang Diproses ({{ $stats['ditindaklanjuti'] }})
            </a>
            <a href="{{ route('admin.disposisi.index', ['status' => 'selesai', 'q' => $search]) }}" class="px-3.5 py-2 rounded-xl font-semibold transition-all whitespace-nowrap {{ $status === 'selesai' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Selesai ({{ $stats['selesai'] }})
            </a>
        </div>

        <!-- Keyword Search -->
        <form action="{{ route('admin.disposisi.index') }}" method="GET" class="flex items-center gap-2 max-w-md w-full">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $search }}" 
                    placeholder="Cari arahan, tujuan unit kerja, nomor surat..."
                    class="w-full pl-9 pr-8 py-2 text-xs rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all"
                >
                @if($search)
                    <a href="{{ route('admin.disposisi.index', ['status' => $status]) }}" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </a>
                @endif
            </div>
            <button type="submit" class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-semibold shrink-0 transition-colors">
                Cari
            </button>
        </form>
    </div>

    <!-- 3. Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-semibold uppercase text-[11px] tracking-wider">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Surat Masuk</th>
                        <th class="py-3.5 px-4">Diteruskan Kepada</th>
                        <th class="py-3.5 px-4">Instruksi Pimpinan</th>
                        <th class="py-3.5 px-4">Batas Waktu</th>
                        <th class="py-3.5 px-4 text-center">Status & Update</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
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
                                <span class="font-semibold text-slate-700 block truncate max-w-xs">{{ $disp->suratMasuk->nomor_surat }}</span>
                                <span class="text-[11px] text-slate-400 block truncate max-w-xs mt-0.5">{{ $disp->suratMasuk->pengirim }}</span>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">
                                <span class="inline-block px-2 py-0.5 rounded-md bg-slate-100 text-slate-800 border border-slate-200 text-[11px]">
                                    {{ $disp->tujuan_disposisi }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <p class="font-medium text-slate-800 line-clamp-2 max-w-xs">{{ $disp->instruksi }}</p>
                                @if($disp->catatan)
                                    <p class="text-[11px] text-slate-400 italic line-clamp-1 mt-0.5">Catatan: {{ $disp->catatan }}</p>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($disp->batas_waktu)
                                    <span class="font-medium text-slate-700 block">{{ $disp->batas_waktu->isoFormat('D MMMM Y') }}</span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.disposisi.status', $disp) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select 
                                        name="status" 
                                        onchange="this.form.submit()" 
                                        class="text-[11px] font-bold py-1 px-2.5 rounded-lg border cursor-pointer {{ $disp->status === 'selesai' ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : ($disp->status === 'ditindaklanjuti' ? 'bg-blue-50 text-blue-800 border-blue-300' : 'bg-amber-50 text-amber-800 border-amber-300') }}"
                                    >
                                        <option value="menunggu" {{ $disp->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="ditindaklanjuti" {{ $disp->status === 'ditindaklanjuti' ? 'selected' : '' }}>Diproses</option>
                                        <option value="selesai" {{ $disp->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- Cetak Lembar Disposisi -->
                                    <a 
                                        href="{{ route('admin.disposisi.cetak', $disp) }}" 
                                        target="_blank"
                                        class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors"
                                        title="Cetak Lembar Disposisi Resmi"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    </a>

                                    <!-- Buka Detail Surat Masuk -->
                                    <a 
                                        href="{{ route('admin.surat-masuk.show', $disp->suratMasuk) }}" 
                                        class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition-colors"
                                        title="Buka Arsip Surat Masuk"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-600">Belum Ada Disposisi Masuk</p>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                                    Arahan disposisi dari Kepala Sekolah akan muncul di halaman ini untuk dipantau dan ditindaklanjuti.
                                </p>
                            </td>
                        </tr>
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
@endsection
