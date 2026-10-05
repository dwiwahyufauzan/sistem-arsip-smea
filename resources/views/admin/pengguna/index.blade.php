@extends('layouts.admin')

@section('title', 'Kelola User & Role')

@section('content')
<div class="space-y-6">

    <!-- Modern Page Header -->
    <x-page-header 
        title="Kelola User & Role Sistem" 
        subtitle="Manajemen akun dan hak akses Petugas Tata Usaha, Kepala Sekolah, Siswa Aktif, dan Alumni SMKN 1 Subang."
        overline="Master Data • Tata Kelola Akun & Hak Akses"
    >
        <x-slot:actions>
            <button 
                type="button" 
                onclick="openCreateUserModal()"
                class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs transition-all active:scale-[0.98] cursor-pointer"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span>Tambah Pengguna</span>
            </button>
        </x-slot:actions>
    </x-page-header>

    <!-- Metric / Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Pengguna -->
        <a href="{{ route('admin.pengguna.index') }}" class="card-modern p-4 hover:border-blue-300 transition-all group {{ $selectedRole === '' ? 'ring-2 ring-blue-500/20 bg-blue-50/20' : '' }}">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-slate-500">Total Pengguna</p>
                <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </span>
            </div>
            <p class="mt-2 text-2xl font-bold font-heading text-slate-900">{{ number_format($roleCounts['total']) }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Semua akun terdaftar di sistem</p>
        </a>

        <!-- Card 2: Petugas & Pimpinan -->
        <a href="{{ route('admin.pengguna.index', ['role' => 'admin']) }}" class="card-modern p-4 hover:border-blue-300 transition-all group {{ $selectedRole === 'admin' || $selectedRole === 'kepala_sekolah' ? 'ring-2 ring-blue-500/20 bg-blue-50/20' : '' }}">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-slate-500">Petugas TU & Kepsek</p>
                <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </span>
            </div>
            <p class="mt-2 text-2xl font-bold font-heading text-slate-900">{{ number_format($roleCounts['admin'] + $roleCounts['kepala_sekolah']) }}</p>
            <p class="mt-1 text-[11px] text-slate-500">TU: <span class="font-bold text-slate-700">{{ $roleCounts['admin'] }}</span> • Kepsek: <span class="font-bold text-slate-700">{{ $roleCounts['kepala_sekolah'] }}</span></p>
        </a>

        <!-- Card 3: Siswa Aktif -->
        <a href="{{ route('admin.pengguna.index', ['role' => 'siswa_aktif']) }}" class="card-modern p-4 hover:border-sky-300 transition-all group {{ $selectedRole === 'siswa_aktif' ? 'ring-2 ring-sky-500/20 bg-sky-50/20' : '' }}">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-slate-500">Siswa Aktif</p>
                <span class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </span>
            </div>
            <p class="mt-2 text-2xl font-bold font-heading text-sky-700">{{ number_format($roleCounts['siswa_aktif']) }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Siswa aktif SMKN 1 Subang</p>
        </a>

        <!-- Card 4: Alumni -->
        <a href="{{ route('admin.pengguna.index', ['role' => 'alumni']) }}" class="card-modern p-4 hover:border-purple-300 transition-all group {{ $selectedRole === 'alumni' ? 'ring-2 ring-purple-500/20 bg-purple-50/20' : '' }}">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-slate-500">Alumni</p>
                <span class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </span>
            </div>
            <p class="mt-2 text-2xl font-bold font-heading text-purple-700">{{ number_format($roleCounts['alumni']) }}</p>
            <p class="mt-1 text-[11px] text-slate-500">Lulusan SMKN 1 Subang</p>
        </a>
    </div>

    <!-- Filter Pills Tabs & Search Card -->
    <div class="card-modern p-4 flex flex-col lg:flex-row items-center justify-between gap-4">
        <!-- Navigation Filter Pills -->
        <div class="flex items-center gap-1.5 overflow-x-auto w-full lg:w-auto text-xs font-semibold scrollbar-none pb-1 lg:pb-0">
            <a href="{{ route('admin.pengguna.index', ['q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $selectedRole === '' ? 'bg-blue-600 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Semua ({{ $roleCounts['total'] }})
            </a>
            <a href="{{ route('admin.pengguna.index', ['role' => 'siswa_aktif', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $selectedRole === 'siswa_aktif' ? 'bg-sky-600 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-sky-50 hover:text-sky-700' }}">
                🎓 Siswa Aktif ({{ $roleCounts['siswa_aktif'] }})
            </a>
            <a href="{{ route('admin.pengguna.index', ['role' => 'alumni', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $selectedRole === 'alumni' ? 'bg-purple-600 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-purple-50 hover:text-purple-700' }}">
                🏛️ Alumni ({{ $roleCounts['alumni'] }})
            </a>
            <a href="{{ route('admin.pengguna.index', ['role' => 'admin', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $selectedRole === 'admin' ? 'bg-blue-600 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Petugas TU ({{ $roleCounts['admin'] }})
            </a>
            <a href="{{ route('admin.pengguna.index', ['role' => 'kepala_sekolah', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $selectedRole === 'kepala_sekolah' ? 'bg-blue-600 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Kepala Sekolah ({{ $roleCounts['kepala_sekolah'] }})
            </a>
            <a href="{{ route('admin.pengguna.index', ['role' => 'pemohon', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl whitespace-nowrap transition-colors {{ $selectedRole === 'pemohon' ? 'bg-blue-600 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100' }}">
                Semua Pemohon ({{ $roleCounts['pemohon'] }})
            </a>
        </div>

        <!-- Search Input -->
        <form action="{{ route('admin.pengguna.index') }}" method="GET" class="relative w-full lg:w-72">
            @if($selectedRole)
                <input type="hidden" name="role" value="{{ $selectedRole }}">
            @endif
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </span>
            <input 
                type="text" 
                name="q" 
                value="{{ $search }}" 
                placeholder="Cari nama, email, NIP, NISN..." 
                class="input-modern w-full pl-9 pr-3 py-2 text-xs"
            >
        </form>
    </div>

    <!-- Table Card -->
    <div class="card-modern overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-bold text-[11px]">
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4">Peran & Kategori</th>
                        <th class="py-3.5 px-4">NIP / NISN</th>
                        <th class="py-3.5 px-4">Nomor WhatsApp</th>
                        <th class="py-3.5 px-4">Terdaftar Pada</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    @php
                                        $avatarColor = match(true) {
                                            $u->isAdmin() => 'bg-blue-100 text-blue-700 border-blue-200',
                                            $u->isKepalaSekolah() => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                            $u->isSiswaAktif() => 'bg-sky-100 text-sky-700 border-sky-200',
                                            default => 'bg-purple-100 text-purple-700 border-purple-200',
                                        };
                                    @endphp
                                    <div class="w-8 h-8 rounded-full font-bold flex items-center justify-center shrink-0 border {{ $avatarColor }}">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $u->name }}</p>
                                        <p class="text-slate-400 font-mono text-[11px]">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($u->isAdmin())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold border bg-blue-50 text-blue-800 border-blue-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        Petugas TU
                                    </span>
                                @elseif($u->isKepalaSekolah())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold border bg-emerald-50 text-emerald-800 border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Kepala Sekolah
                                    </span>
                                @elseif($u->isSiswaAktif())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold border bg-sky-50 text-sky-800 border-sky-200">
                                        <svg class="w-3 h-3 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        Siswa Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold border bg-purple-50 text-purple-800 border-purple-200">
                                        <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        Alumni
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-mono">
                                {{ $u->nip_nisn ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4">
                                {{ $u->phone_number ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-500">
                                {{ $u->created_at->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-1.5 whitespace-nowrap">
                                <!-- Tombol Detail Modal -->
                                <button 
                                    type="button" 
                                    onclick='openDetailUserModal(@json($u))'
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-slate-700 bg-slate-100 hover:bg-slate-200 font-semibold transition-colors cursor-pointer"
                                    title="Lihat Detail Profil"
                                >
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>Detail</span>
                                </button>

                                <!-- Tombol Ubah Modal -->
                                <button 
                                    type="button" 
                                    onclick='openEditUserModal(@json($u))'
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 font-semibold transition-colors cursor-pointer"
                                    title="Ubah Data Pengguna"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>Ubah</span>
                                </button>

                                @if($u->id !== auth()->id())
                                    <button 
                                        type="button" 
                                        onclick="confirmAction({
                                            title: 'Konfirmasi Hapus Pengguna',
                                            subtitle: 'Tindakan penghapusan akun sistem kearsipan',
                                            message: 'Apakah Anda yakin ingin menghapus akun pengguna ini?',
                                            targetName: '{{ $u->name }} ({{ $u->email }})',
                                            targetBadge: '{{ strtoupper($u->role) }}',
                                            warning: 'Pengguna yang telah dihapus tidak akan dapat masuk kembali ke dalam sistem kearsipan SMKN 1 Subang.',
                                            type: 'danger',
                                            confirmText: 'Ya, Hapus Pengguna',
                                            actionUrl: '{{ route('admin.pengguna.destroy', $u) }}',
                                            method: 'DELETE'
                                        })"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-rose-700 bg-rose-50 hover:bg-rose-100 font-semibold transition-colors cursor-pointer"
                                        title="Hapus Akun Pengguna"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <x-empty-state 
                            colspan="6" 
                            title="Tidak ada akun pengguna" 
                            description="Tidak ada data akun pengguna yang sesuai dengan filter atau kata kunci pencarian Anda." 
                        />
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-5 py-4 border-t border-slate-200 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Tambah Pengguna -->
<div id="createUserModal" class="fixed inset-0 z-50 hidden transition-opacity duration-200" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity" onclick="closeCreateUserModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all duration-200 text-slate-800 max-h-[92vh] flex flex-col animate-in fade-in zoom-in-95">
            <!-- Header -->
            <div class="px-6 py-4.5 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-900 border border-blue-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-bold text-base text-slate-900">Tambah Akun Pengguna Baru</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Daftarkan akun staf TU, pimpinan sekolah, siswa aktif, atau alumni.</p>
                    </div>
                </div>
                <button type="button" onclick="closeCreateUserModal()" class="w-8 h-8 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 transition-colors flex items-center justify-center cursor-pointer" title="Tutup (Esc)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('admin.pengguna.store') }}" method="POST" class="flex flex-col overflow-hidden">
                @csrf
                <div class="p-6 space-y-4 overflow-y-auto max-h-[calc(92vh-130px)]">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Contoh: Muhammad Farhan / Ir. H. Ahmad..." class="input-modern w-full px-3.5 py-2 text-xs">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                            <input type="email" name="email" required placeholder="user@smkn1subang.sch.id" class="input-modern w-full px-3.5 py-2 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Peran Hak Akses <span class="text-rose-500">*</span></label>
                            <select id="createRoleSelect" name="role" required onchange="handleCreateRoleChange()" class="input-modern w-full px-3.5 py-2 text-xs">
                                <option value="admin">Petugas Tata Usaha (Admin)</option>
                                <option value="kepala_sekolah">Kepala Sekolah (Pimpinan)</option>
                                <option value="pemohon" selected>Pemohon (Siswa / Alumni SMKN 1 Subang)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tipe Pemohon (Khusus Role Pemohon) -->
                    <div id="createTipePemohonContainer" class="p-3.5 bg-blue-50/60 rounded-xl border border-blue-100 space-y-2">
                        <label class="block text-xs font-bold text-blue-900">Kategori Pemohon <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <label class="flex items-center gap-2 p-2.5 bg-white rounded-lg border border-slate-200 cursor-pointer hover:border-blue-300 transition-colors">
                                <input type="radio" name="tipe_pemohon" value="siswa_aktif" checked class="text-blue-900 focus:ring-blue-900">
                                <div>
                                    <p class="font-bold text-slate-800">Siswa Aktif</p>
                                    <p class="text-[10px] text-slate-500">Masih belajar di SMK</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-2 p-2.5 bg-white rounded-lg border border-slate-200 cursor-pointer hover:border-purple-300 transition-colors">
                                <input type="radio" name="tipe_pemohon" value="alumni" class="text-purple-600 focus:ring-purple-500">
                                <div>
                                    <p class="font-bold text-slate-800">Alumni</p>
                                    <p class="text-[10px] text-slate-500">Telah lulus dari sekolah</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label id="createNipNisnLabel" class="block text-xs font-semibold text-slate-700 mb-1">NISN (Siswa/Alumni) / NIP (Staf)</label>
                            <input type="text" name="nip_nisn" placeholder="Nomor NISN atau NIP..." class="input-modern w-full px-3.5 py-2 text-xs font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp Aktif</label>
                            <input type="text" name="phone_number" placeholder="08xxxxxxxxxx" class="input-modern w-full px-3.5 py-2 text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi <span class="text-rose-500">*</span></label>
                            <input type="password" name="password" required placeholder="Minimal 6 karakter" class="input-modern w-full px-3.5 py-2 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi <span class="text-rose-500">*</span></label>
                            <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi" class="input-modern w-full px-3.5 py-2 text-xs">
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end gap-2.5 shrink-0">
                    <button type="button" onclick="closeCreateUserModal()" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors cursor-pointer shadow-2xs">Batal</button>
                    <button type="submit" class="px-4.5 py-2 text-xs font-bold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-xs transition-colors cursor-pointer flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        <span>Daftarkan Pengguna</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah Pengguna -->
<div id="editUserModal" class="fixed inset-0 z-50 hidden transition-opacity duration-200" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity" onclick="closeEditUserModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all duration-200 text-slate-800 max-h-[92vh] flex flex-col animate-in fade-in zoom-in-95">
            <!-- Header -->
            <div class="px-6 py-4.5 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-900 border border-blue-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-bold text-base text-slate-900">Ubah Data Pengguna</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Perbarui profil, hak akses peran, atau atur ulang kata sandi pengguna.</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditUserModal()" class="w-8 h-8 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 transition-colors flex items-center justify-center cursor-pointer" title="Tutup (Esc)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="editUserForm" method="POST" class="flex flex-col overflow-hidden">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-4 overflow-y-auto max-h-[calc(92vh-130px)]">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" id="editUserName" name="name" required class="input-modern w-full px-3.5 py-2 text-xs">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                            <input type="email" id="editUserEmail" name="email" required class="input-modern w-full px-3.5 py-2 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Peran Hak Akses <span class="text-rose-500">*</span></label>
                            <select id="editUserRole" name="role" required onchange="handleEditRoleChange()" class="input-modern w-full px-3.5 py-2 text-xs">
                                <option value="admin">Petugas Tata Usaha (Admin)</option>
                                <option value="kepala_sekolah">Kepala Sekolah (Pimpinan)</option>
                                <option value="pemohon">Pemohon (Siswa / Alumni SMKN 1 Subang)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tipe Pemohon (Khusus Role Pemohon) -->
                    <div id="editTipePemohonContainer" class="p-3.5 bg-blue-50/60 rounded-xl border border-blue-100 space-y-2">
                        <label class="block text-xs font-bold text-blue-900">Kategori Pemohon <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <label class="flex items-center gap-2 p-2.5 bg-white rounded-lg border border-slate-200 cursor-pointer hover:border-blue-300 transition-colors">
                                <input type="radio" id="editTipeSiswa" name="tipe_pemohon" value="siswa_aktif" class="text-blue-900 focus:ring-blue-900">
                                <div>
                                    <p class="font-bold text-slate-800">Siswa Aktif</p>
                                    <p class="text-[10px] text-slate-500">Masih belajar di SMK</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-2 p-2.5 bg-white rounded-lg border border-slate-200 cursor-pointer hover:border-purple-300 transition-colors">
                                <input type="radio" id="editTipeAlumni" name="tipe_pemohon" value="alumni" class="text-purple-600 focus:ring-purple-500">
                                <div>
                                    <p class="font-bold text-slate-800">Alumni</p>
                                    <p class="text-[10px] text-slate-500">Telah lulus dari sekolah</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label id="editNipNisnLabel" class="block text-xs font-semibold text-slate-700 mb-1">NIP / NISN</label>
                            <input type="text" id="editUserNipNisn" name="nip_nisn" class="input-modern w-full px-3.5 py-2 text-xs font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp Aktif</label>
                            <input type="text" id="editUserPhone" name="phone_number" class="input-modern w-full px-3.5 py-2 text-xs">
                        </div>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs">
                        <p class="font-semibold text-slate-700 mb-2">Ganti Kata Sandi (Kosongkan jika tidak diubah):</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <input type="password" name="password" placeholder="Kata sandi baru (min. 6)..." class="input-modern w-full px-3.5 py-2 text-xs bg-white">
                            </div>
                            <div>
                                <input type="password" name="password_confirmation" placeholder="Konfirmasi sandi..." class="input-modern w-full px-3.5 py-2 text-xs bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end gap-2.5 shrink-0">
                    <button type="button" onclick="closeEditUserModal()" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors cursor-pointer shadow-2xs">Batal</button>
                    <button type="submit" class="px-4.5 py-2 text-xs font-bold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-xs transition-colors cursor-pointer flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Profil Pengguna -->
<div id="detailUserModal" class="fixed inset-0 z-50 hidden transition-opacity duration-200" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity" onclick="closeDetailUserModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden transform transition-all duration-200 text-slate-800 animate-in fade-in zoom-in-95">
            <!-- Header -->
            <div class="px-6 py-4.5 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-900 border border-blue-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-bold text-base text-slate-900">Detail Profil Pengguna</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Informasi akun dan identitas kearsipan</p>
                    </div>
                </div>
                <button type="button" onclick="closeDetailUserModal()" class="w-8 h-8 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 transition-colors flex items-center justify-center cursor-pointer" title="Tutup (Esc)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <!-- User Avatar & Header Info -->
                <div class="flex items-center gap-3.5 p-3.5 bg-slate-50 rounded-2xl border border-slate-100">
                    <div id="detailAvatar" class="w-12 h-12 rounded-full font-bold text-base flex items-center justify-center shrink-0 border">
                        U
                    </div>
                    <div class="min-w-0">
                        <p id="detailName" class="font-bold text-sm text-slate-900 truncate">Nama Pengguna</p>
                        <p id="detailEmail" class="text-slate-500 font-mono text-xs truncate">email@example.com</p>
                        <div class="mt-1">
                            <span id="detailBadge" class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold border">
                                Peran
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Info List -->
                <div class="space-y-2.5 text-xs text-slate-600">
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Peran Hak Akses</span>
                        <span id="detailRoleText" class="font-semibold text-slate-800">-</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Kategori Pemohon</span>
                        <span id="detailTipeText" class="font-semibold text-slate-800">-</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">NIP / NISN</span>
                        <span id="detailNipNisn" class="font-mono font-semibold text-slate-800">-</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Nomor WhatsApp</span>
                        <span id="detailPhone" class="font-semibold text-slate-800">-</span>
                    </div>
                    <div class="flex items-center justify-between py-1.5 border-b border-slate-100">
                        <span class="text-slate-500">Tanggal Terdaftar</span>
                        <span id="detailCreatedAt" class="font-semibold text-slate-800">-</span>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex justify-end">
                <button type="button" onclick="closeDetailUserModal()" class="px-4 py-2 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors cursor-pointer shadow-2xs">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Create Modal Logic
    function openCreateUserModal() {
        document.getElementById('createUserModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        handleCreateRoleChange();
    }
    function closeCreateUserModal() {
        document.getElementById('createUserModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    function handleCreateRoleChange() {
        const role = document.getElementById('createRoleSelect').value;
        const container = document.getElementById('createTipePemohonContainer');
        const label = document.getElementById('createNipNisnLabel');

        if (role === 'pemohon') {
            container.classList.remove('hidden');
            label.textContent = 'NISN (Nomor Induk Siswa Nasional)';
        } else {
            container.classList.add('hidden');
            label.textContent = 'NIP / Nomor Identitas Pegawai';
        }
    }

    // Edit Modal Logic
    function openEditUserModal(user) {
        const modal = document.getElementById('editUserModal');
        const form = document.getElementById('editUserForm');
        form.action = `/admin/pengguna/${user.id}`;

        document.getElementById('editUserName').value = user.name;
        document.getElementById('editUserEmail').value = user.email;
        document.getElementById('editUserRole').value = user.role;
        document.getElementById('editUserNipNisn').value = user.nip_nisn || '';
        document.getElementById('editUserPhone').value = user.phone_number || '';

        // Tipe pemohon radio
        if (user.tipe_pemohon === 'siswa_aktif') {
            document.getElementById('editTipeSiswa').checked = true;
        } else {
            document.getElementById('editTipeAlumni').checked = true;
        }

        handleEditRoleChange();
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    function closeEditUserModal() {
        document.getElementById('editUserModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    function handleEditRoleChange() {
        const role = document.getElementById('editUserRole').value;
        const container = document.getElementById('editTipePemohonContainer');
        const label = document.getElementById('editNipNisnLabel');

        if (role === 'pemohon') {
            container.classList.remove('hidden');
            label.textContent = 'NISN (Nomor Induk Siswa Nasional)';
        } else {
            container.classList.add('hidden');
            label.textContent = 'NIP / Nomor Identitas Pegawai';
        }
    }

    // Detail Modal Logic
    function openDetailUserModal(user) {
        document.getElementById('detailName').textContent = user.name;
        document.getElementById('detailEmail').textContent = user.email;
        document.getElementById('detailNipNisn').textContent = user.nip_nisn || '-';
        document.getElementById('detailPhone').textContent = user.phone_number || '-';
        document.getElementById('detailAvatar').textContent = (user.name || 'U').charAt(0).toUpperCase();

        const createdAt = user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }) : '-';
        document.getElementById('detailCreatedAt').textContent = createdAt;

        const roleText = user.role === 'admin' ? 'Petugas Tata Usaha' : (user.role === 'kepala_sekolah' ? 'Kepala Sekolah' : 'Pemohon Legalisir');
        document.getElementById('detailRoleText').textContent = roleText;

        const detailBadge = document.getElementById('detailBadge');
        const detailAvatar = document.getElementById('detailAvatar');

        if (user.role === 'admin') {
            document.getElementById('detailTipeText').textContent = 'Staf Tata Usaha';
            detailBadge.textContent = 'Petugas TU';
            detailBadge.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold border bg-blue-50 text-blue-900 border-blue-200';
            detailAvatar.className = 'w-12 h-12 rounded-full font-bold text-base flex items-center justify-center shrink-0 border bg-blue-100 text-blue-900 border-blue-200';
        } else if (user.role === 'kepala_sekolah') {
            document.getElementById('detailTipeText').textContent = 'Pimpinan Sekolah';
            detailBadge.textContent = 'Kepala Sekolah';
            detailBadge.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold border bg-emerald-50 text-emerald-800 border-emerald-200';
            detailAvatar.className = 'w-12 h-12 rounded-full font-bold text-base flex items-center justify-center shrink-0 border bg-emerald-100 text-emerald-700 border-emerald-200';
        } else if (user.tipe_pemohon === 'siswa_aktif') {
            document.getElementById('detailTipeText').textContent = 'Siswa Aktif SMKN 1 Subang';
            detailBadge.textContent = 'Siswa Aktif';
            detailBadge.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold border bg-sky-50 text-sky-800 border-sky-200';
            detailAvatar.className = 'w-12 h-12 rounded-full font-bold text-base flex items-center justify-center shrink-0 border bg-sky-100 text-sky-700 border-sky-200';
        } else {
            document.getElementById('detailTipeText').textContent = 'Alumni SMKN 1 Subang';
            detailBadge.textContent = 'Alumni';
            detailBadge.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold border bg-purple-50 text-purple-800 border-purple-200';
            detailAvatar.className = 'w-12 h-12 rounded-full font-bold text-base flex items-center justify-center shrink-0 border bg-purple-100 text-purple-700 border-purple-200';
        }

        document.getElementById('detailUserModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    function closeDetailUserModal() {
        document.getElementById('detailUserModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateUserModal();
            closeEditUserModal();
            closeDetailUserModal();
        }
    });
</script>
@endsection
