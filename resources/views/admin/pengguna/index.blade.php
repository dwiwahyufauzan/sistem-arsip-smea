@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('page_title', 'Manajemen Pengguna Sistem')
@section('page_subtitle', 'Pengelolaan hak akses akun Staf Tata Usaha, Kepala Sekolah, dan Pemohon Legalisir')

@section('page_actions')
    <button 
        type="button" 
        onclick="openCreateUserModal()"
        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-xs transition-colors cursor-pointer"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        <span>Tambah Pengguna</span>
    </button>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Role Filter Tabs & Search Card -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Role Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto w-full md:w-auto text-xs font-semibold">
            <a href="{{ route('admin.pengguna.index', ['q' => $search]) }}" class="px-3 py-1.5 rounded-xl transition-colors {{ $selectedRole === '' ? 'bg-blue-900 text-white font-bold' : 'text-slate-600 hover:bg-slate-100' }}">
                Semua ({{ $roleCounts['total'] }})
            </a>
            <a href="{{ route('admin.pengguna.index', ['role' => 'admin', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl transition-colors {{ $selectedRole === 'admin' ? 'bg-blue-900 text-white font-bold' : 'text-slate-600 hover:bg-slate-100' }}">
                Petugas TU ({{ $roleCounts['admin'] }})
            </a>
            <a href="{{ route('admin.pengguna.index', ['role' => 'kepala_sekolah', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl transition-colors {{ $selectedRole === 'kepala_sekolah' ? 'bg-blue-900 text-white font-bold' : 'text-slate-600 hover:bg-slate-100' }}">
                Kepala Sekolah ({{ $roleCounts['kepala_sekolah'] }})
            </a>
            <a href="{{ route('admin.pengguna.index', ['role' => 'pemohon', 'q' => $search]) }}" class="px-3 py-1.5 rounded-xl transition-colors {{ $selectedRole === 'pemohon' ? 'bg-blue-900 text-white font-bold' : 'text-slate-600 hover:bg-slate-100' }}">
                Pemohon Alumni ({{ $roleCounts['pemohon'] }})
            </a>
        </div>

        <!-- Search Input -->
        <form action="{{ route('admin.pengguna.index') }}" method="GET" class="relative w-full md:w-72">
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
                placeholder="Cari nama, email, NIP/NISN..." 
                class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all"
            >
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4">Peran Hak Akses</th>
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
                                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center shrink-0 border border-slate-200">
                                        {{ substr($u->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $u->name }}</p>
                                        <p class="text-slate-400 font-mono text-[11px]">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @php
                                    $roleBadge = match($u->role) {
                                        'admin' => 'bg-blue-50 text-blue-800 border-blue-200',
                                        'kepala_sekolah' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                                        'pemohon' => 'bg-purple-50 text-purple-800 border-purple-200',
                                        default => 'bg-slate-50 text-slate-800 border-slate-200',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold border {{ $roleBadge }}">
                                    {{ $u->role_badge }}
                                </span>
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
                                <button 
                                    type="button" 
                                    onclick="openEditUserModal({{ json_encode($u) }})"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-slate-700 bg-slate-100 hover:bg-blue-100 hover:text-blue-900 font-semibold transition-colors cursor-pointer"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span>Ubah</span>
                                </button>

                                @if($u->id !== auth()->id())
                                    <form action="{{ route('admin.pengguna.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna {{ $u->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-rose-700 bg-rose-50 hover:bg-rose-100 font-semibold transition-colors cursor-pointer"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400">
                                Tidak ada akun pengguna yang ditemukan.
                            </td>
                        </tr>
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
<div id="createUserModal" class="fixed inset-0 z-50 hidden transition-opacity">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs" onclick="closeCreateUserModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 relative text-slate-800">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h3 class="font-heading font-bold text-base text-slate-900">Tambah Akun Pengguna Baru</h3>
                <button type="button" onclick="closeCreateUserModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('admin.pengguna.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="Nama lengkap dan gelar..." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" required placeholder="user@smkn1subang.sch.id" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Peran Hak Akses <span class="text-rose-500">*</span></label>
                        <select name="role" required class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="admin">Petugas Tata Usaha (Admin)</option>
                            <option value="kepala_sekolah">Kepala Sekolah (Pimpinan)</option>
                            <option value="pemohon">Pemohon Legalisir (Alumni)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">NIP (Staf) / NISN (Alumni)</label>
                        <input type="text" name="nip_nisn" placeholder="Nomor identitas..." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp Aktif</label>
                        <input type="text" name="phone_number" placeholder="08xxxxxxxxxx" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi <span class="text-rose-500">*</span></label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi <span class="text-rose-500">*</span></label>
                        <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeCreateUserModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-xs transition-colors">Daftarkan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Ubah Pengguna -->
<div id="editUserModal" class="fixed inset-0 z-50 hidden transition-opacity">
    <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs" onclick="closeEditUserModal()"></div>
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 relative text-slate-800">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h3 class="font-heading font-bold text-base text-slate-900">Ubah Data Pengguna</h3>
                <button type="button" onclick="closeEditUserModal()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="editUserForm" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" id="editUserName" name="name" required class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" id="editUserEmail" name="email" required class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Peran Hak Akses <span class="text-rose-500">*</span></label>
                        <select id="editUserRole" name="role" required class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="admin">Petugas Tata Usaha (Admin)</option>
                            <option value="kepala_sekolah">Kepala Sekolah (Pimpinan)</option>
                            <option value="pemohon">Pemohon Legalisir (Alumni)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">NIP (Staf) / NISN (Alumni)</label>
                        <input type="text" id="editUserNipNisn" name="nip_nisn" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp Aktif</label>
                        <input type="text" id="editUserPhone" name="phone_number" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs">
                    <p class="font-semibold text-slate-700 mb-2">Ganti Kata Sandi (Kosongkan jika tidak diubah):</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <input type="password" name="password" placeholder="Kata sandi baru..." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white">
                        </div>
                        <div>
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi sandi..." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeEditUserModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-blue-900 hover:bg-blue-800 rounded-xl shadow-xs transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openCreateUserModal() {
        document.getElementById('createUserModal').classList.remove('hidden');
    }
    function closeCreateUserModal() {
        document.getElementById('createUserModal').classList.add('hidden');
    }

    function openEditUserModal(user) {
        const modal = document.getElementById('editUserModal');
        const form = document.getElementById('editUserForm');
        form.action = `/admin/pengguna/${user.id}`;

        document.getElementById('editUserName').value = user.name;
        document.getElementById('editUserEmail').value = user.email;
        document.getElementById('editUserRole').value = user.role;
        document.getElementById('editUserNipNisn').value = user.nip_nisn || '';
        document.getElementById('editUserPhone').value = user.phone_number || '';

        modal.classList.remove('hidden');
    }
    function closeEditUserModal() {
        document.getElementById('editUserModal').classList.add('hidden');
    }
</script>
@endsection
