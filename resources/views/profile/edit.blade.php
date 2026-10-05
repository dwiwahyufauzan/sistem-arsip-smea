@extends(auth()->user()->isAdmin() ? 'layouts.admin' : (auth()->user()->isKepalaSekolah() ? 'layouts.kepsek' : 'layouts.pemohon'))

@section('title', 'Profil Pengguna')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Modern Page Header -->
    <x-page-header 
        title="Pengaturan Akun & Profil" 
        subtitle="Kelola informasi identitas pribadi dan keamanan kata sandi akun Anda."
        overline="Identitas Akun • Personalisasi"
    />

    <!-- Grid 2 Kolom: Informasi Profil & Keamanan Password -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Card 1: Biodata Akun -->
        <div class="card-modern p-6">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h3 class="font-heading font-bold text-sm text-slate-900">Informasi Pribadi</h3>
                    <p class="text-xs text-slate-400">Pembaruan nama, email, dan kontak resmi</p>
                </div>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name', $user->name) }}" 
                        required 
                        class="input-modern w-full px-3 py-2 text-xs"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email <span class="text-rose-500">*</span></label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $user->email) }}" 
                        required 
                        class="input-modern w-full px-3 py-2 text-xs"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">NIP (Staf) / NISN (Alumni)</label>
                    <input 
                        type="text" 
                        name="nip_nisn" 
                        value="{{ old('nip_nisn', $user->nip_nisn) }}" 
                        class="input-modern w-full px-3 py-2 text-xs font-mono"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor WhatsApp Aktif</label>
                    <input 
                        type="text" 
                        name="phone_number" 
                        value="{{ old('phone_number', $user->phone_number) }}" 
                        placeholder="08xxxxxxxxxx"
                        class="input-modern w-full px-3 py-2 text-xs"
                    >
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs transition-all active:scale-[0.98] cursor-pointer">
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- Card 2: Keamanan Kata Sandi -->
        <div class="card-modern p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-heading font-bold text-sm text-slate-900">Perbarui Kata Sandi</h3>
                        <p class="text-xs text-slate-400">Pastikan akun Anda terlindungi kata sandi yang kuat</p>
                    </div>
                </div>

                <form action="{{ route('profile.password') }}" method="POST" class="mt-4 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Saat Ini <span class="text-rose-500">*</span></label>
                        <input 
                            type="password" 
                            name="current_password" 
                            required 
                            placeholder="Masukkan kata sandi lama..." 
                            class="input-modern w-full px-3 py-2 text-xs"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Baru <span class="text-rose-500">*</span></label>
                        <input 
                            type="password" 
                            name="password" 
                            required 
                            placeholder="Minimal 6 karakter..." 
                            class="input-modern w-full px-3 py-2 text-xs"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Ulangi Kata Sandi Baru <span class="text-rose-500">*</span></label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            placeholder="Konfirmasi kata sandi baru..." 
                            class="input-modern w-full px-3 py-2 text-xs"
                        >
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-2.5 text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-xl shadow-xs transition-all active:scale-[0.98] cursor-pointer">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Role Badge Footer -->
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Peran Sistem:</span>
                <span class="font-bold text-blue-900">{{ $user->role_badge }}</span>
            </div>
        </div>

    </div>

</div>
@endsection
