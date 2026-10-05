@extends('layouts.admin')

@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="space-y-6">

    <!-- Modern Page Header -->
    <x-page-header 
        title="Log Aktivitas Sistem Kearsipan" 
        subtitle="Catatan kronologis seluruh interaksi pengguna, modifikasi arsip surat, disposisi, dan pelayanan legalisir online."
        overline="Keamanan & Transparansi Tata Kelola • Jejak Audit"
    >
        <x-slot:actions>
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-blue-50 text-blue-700 text-xs font-semibold rounded-xl border border-blue-200 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                <span>Audit Trail Aktif</span>
            </span>
        </x-slot:actions>
    </x-page-header>

    <!-- Filter & Search Toolbar -->
    <div class="card-modern p-5">
        <form action="{{ route('admin.log-aktivitas.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-3 text-xs">
            
            <!-- Search Keyword -->
            <div class="sm:col-span-2">
                <label class="block text-slate-500 font-semibold mb-1">Cari Aktivitas / Deskripsi / IP / Petugas:</label>
                <div class="relative">
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}" 
                        placeholder="Contoh: Mengunggah, Disetujui, 127.0.0.1, nama petugas..."
                        class="input-modern w-full pl-9 pr-4 py-2 text-xs"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- Modul Selector -->
            <div>
                <label class="block text-slate-500 font-semibold mb-1">Modul Sistem:</label>
                <select 
                    name="modul" 
                    class="input-modern w-full px-3 py-2 text-xs"
                >
                    <option value="semua" {{ request('modul', 'semua') === 'semua' ? 'selected' : '' }}>-- Semua Modul --</option>
                    <option value="SURAT_MASUK" {{ request('modul') === 'SURAT_MASUK' ? 'selected' : '' }}>Surat Masuk</option>
                    <option value="SURAT_KELUAR" {{ request('modul') === 'SURAT_KELUAR' ? 'selected' : '' }}>Surat Keluar</option>
                    <option value="DISPOSISI" {{ request('modul') === 'DISPOSISI' ? 'selected' : '' }}>Disposisi</option>
                    <option value="LEGALISIR" {{ request('modul') === 'LEGALISIR' ? 'selected' : '' }}>Legalisir Online</option>
                    <option value="AUTH" {{ request('modul') === 'AUTH' ? 'selected' : '' }}>Otentikasi / Akun</option>
                    <option value="KATEGORI_SURAT" {{ request('modul') === 'KATEGORI_SURAT' ? 'selected' : '' }}>Klasifikasi Surat</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-end gap-2">
                <button 
                    type="submit" 
                    class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-semibold transition-all shadow-xs active:scale-[0.98] cursor-pointer flex items-center justify-center gap-1.5"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Filter</span>
                </button>
                <a 
                    href="{{ route('admin.log-aktivitas.index') }}" 
                    class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors font-semibold"
                    title="Reset Filter"
                >
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Logs Table -->
    <div class="card-modern overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider text-[11px] border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 w-14 text-center">No.</th>
                        <th class="px-4 py-3 w-40">Waktu & Tanggal</th>
                        <th class="px-4 py-3 w-48">Pengguna / Peran</th>
                        <th class="px-4 py-3 w-32">Modul</th>
                        <th class="px-4 py-3 w-36">Aksi</th>
                        <th class="px-4 py-3">Deskripsi Aktivitas</th>
                        <th class="px-4 py-3 w-32">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($logs as $index => $log)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-4 py-3 text-center text-slate-400">
                                {{ $logs->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="font-semibold text-slate-800">{{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : '-' }}</div>
                                <div class="text-[10px] text-slate-400">{{ $log->created_at ? $log->created_at->diffForHumans() : '' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                @if($log->user)
                                    <div class="font-semibold text-slate-900">{{ $log->user->name }}</div>
                                    <div class="text-[10px] text-slate-500 capitalize">{{ str_replace('_', ' ', $log->user->role) }}</div>
                                @else
                                    <span class="text-slate-400 italic">Sistem / Tamu</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $modulColor = match(strtoupper($log->modul)) {
                                        'SURAT_MASUK' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'SURAT_KELUAR' => 'bg-teal-100 text-teal-800 border-teal-200',
                                        'DISPOSISI' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                        'LEGALISIR' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        'AUTH' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        default => 'bg-slate-100 text-slate-800 border-slate-200'
                                    };
                                @endphp
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border {{ $modulColor }}">
                                    {{ $log->modul }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-semibold text-slate-800">{{ $log->aksi }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $log->deskripsi }}
                            </td>
                            <td class="px-4 py-3 font-mono text-[11px] text-slate-500 whitespace-nowrap">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <x-empty-state 
                            colspan="7" 
                            title="Belum ada catatan aktivitas yang sesuai filter" 
                            description="Coba gunakan kata kunci pencarian atau modul yang berbeda." 
                        />
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
