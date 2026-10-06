<!-- Top Navigation Bar - Portal Pemohon / Alumni (Konsisten dengan Landing Page) -->
<header {{ $attributes->merge(['class' => 'sticky top-0 z-40 bg-white/85 backdrop-blur-xl border-b border-slate-200/80 transition-all duration-300 shadow-xs']) }}>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20">
            <!-- Brand Logo & School Identity -->
            <a href="{{ route('pemohon.dashboard') }}" class="flex items-center gap-3.5 group focus-visible:outline-2 focus-visible:outline-teal-600 rounded-xl">
                <div class="relative">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-9 h-11 sm:w-11 sm:h-13 object-contain shrink-0 group-hover:scale-105 transition-transform duration-300 filter drop-shadow-sm">
                </div>
                <div class="leading-tight">
                    <div class="flex items-center gap-2">
                        <span class="font-heading font-extrabold text-lg sm:text-xl text-blue-950 tracking-tight">SMEA ARCHIVE</span>
                        <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-md bg-teal-100 text-teal-800 border border-teal-200">LEGALISIR SMEA</span>
                    </div>
                    <p class="text-[11px] sm:text-xs font-semibold text-slate-600">SMK Negeri 1 Subang · Portal Alumni</p>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-1 text-xs font-semibold text-slate-600" aria-label="Navigasi portal pemohon">
                <a href="{{ route('pemohon.dashboard') }}" class="px-3 py-1.5 rounded-lg transition-colors {{ request()->routeIs('pemohon.dashboard') ? 'bg-teal-50 text-teal-900 font-bold border border-teal-200/70' : 'hover:bg-slate-100/90 hover:text-blue-950' }}">
                    Beranda Pemohon
                </a>
                <a href="{{ url('/pemohon/legalisir/create') }}" class="px-3 py-1.5 rounded-lg transition-colors {{ request()->is('pemohon/legalisir/create*') ? 'bg-teal-50 text-teal-900 font-bold border border-teal-200/70' : 'hover:bg-slate-100/90 hover:text-blue-950' }}">
                    Ajukan Legalisir Baru
                </a>
                <a href="{{ url('/pemohon/legalisir') }}" class="px-3 py-1.5 rounded-lg transition-colors {{ request()->is('pemohon/legalisir') ? 'bg-teal-50 text-teal-900 font-bold border border-teal-200/70' : 'hover:bg-slate-100/90 hover:text-blue-950' }}">
                    Riwayat & Tracking Berkas
                </a>
                <a href="{{ route('landing') }}#alur" target="_blank" class="px-3 py-1.5 rounded-lg hover:bg-slate-100/90 hover:text-blue-950 transition-colors flex items-center gap-1">
                    <span>Panduan Alur</span>
                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </nav>

            <!-- Profile Dropdown Menu Pemohon -->
            <div class="relative" id="pemohonProfileDropdownContainer">
                <button 
                    type="button" 
                    onclick="togglePemohonProfileDropdown(event)" 
                    class="flex items-center gap-2.5 py-1.5 px-2.5 rounded-xl hover:bg-slate-100 border border-transparent hover:border-slate-200 transition-colors cursor-pointer group focus:outline-none"
                    aria-expanded="false"
                    id="pemohonProfileDropdownBtn"
                    title="Menu Akun & Logout"
                >
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-blue-900 to-indigo-900 text-white font-bold flex items-center justify-center text-xs sm:text-sm shadow-xs shrink-0 group-hover:scale-105 transition-transform ring-2 ring-transparent group-hover:ring-blue-200">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="hidden sm:block text-left text-xs">
                        <p class="font-bold text-slate-900 leading-tight truncate max-w-[140px]">{{ auth()->user()->name }}</p>
                        <span class="text-[10px] font-semibold text-teal-800 bg-teal-50 border border-teal-200/80 px-1.5 py-0.5 rounded-md mt-0.5 inline-block">{{ auth()->user()->role_badge }}</span>
                    </div>
                </button>

                <!-- Dropdown Menu Box -->
                <div 
                    id="pemohonProfileDropdownMenu" 
                    class="hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl shadow-slate-900/15 border border-slate-200/90 py-1.5 z-50 animate-in fade-in zoom-in-95 duration-150"
                >
                    <!-- User Identity Card -->
                    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/70 rounded-t-2xl">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl bg-blue-900 text-white font-bold flex items-center justify-center text-sm shadow-xs shrink-0 ring-2 ring-blue-100">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-bold text-slate-900 truncate leading-snug">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate mt-0.5 font-mono">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <!-- Role Badge & NISN Stacked Vertically -->
                        <div class="flex flex-col items-start gap-2 mt-3.5 pt-3 border-t border-slate-200/70">
                            @if(auth()->user()->isSiswaAktif())
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-800 border border-cyan-200/80">
                                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-600"></span>
                                    <span>Siswa Aktif SMKN 1</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-teal-50 text-teal-800 border border-teal-200/80">
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-600"></span>
                                    <span>Alumni SMKN 1 Subang</span>
                                </span>
                            @endif

                            @if(auth()->user()->nip_nisn)
                                <div class="w-full flex items-center gap-2 px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 text-xs shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                    <span class="text-[11px] font-medium text-slate-500 font-sans">NISN:</span>
                                    <span class="font-mono font-semibold text-slate-800 tracking-tight">{{ auth()->user()->nip_nisn }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="p-2 space-y-1">
                        <a 
                            href="{{ route('profile.edit') }}" 
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-teal-50/80 transition-all group"
                        >
                            <div class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-teal-100 text-slate-500 group-hover:text-teal-700 flex items-center justify-center shrink-0 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-slate-800 group-hover:text-teal-800">Pengaturan Akun & Password</span>
                                <span class="block text-[10px] text-slate-400 font-normal">Perbarui profil dan kata sandi</span>
                            </div>
                        </a>

                        <a 
                            href="{{ route('landing') }}" 
                            target="_blank"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-slate-100 transition-all group"
                        >
                            <div class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-slate-200 text-slate-500 group-hover:text-slate-700 flex items-center justify-center shrink-0 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-slate-800 group-hover:text-slate-900">Buka Beranda Publik</span>
                                <span class="block text-[10px] text-slate-400 font-normal">Portal kearsipan SMKN 1 Subang</span>
                            </div>
                        </a>
                    </div>

                    <!-- Logout Action -->
                    <div class="p-2 pt-1 border-t border-slate-100">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button 
                                type="submit" 
                                class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-rose-700 hover:text-white bg-rose-50/80 hover:bg-rose-600 transition-all cursor-pointer group shadow-2xs"
                            >
                                <div class="w-8 h-8 rounded-lg bg-rose-100 group-hover:bg-rose-700 text-rose-600 group-hover:text-white flex items-center justify-center shrink-0 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <span class="block text-xs font-bold">Keluar dari Akun</span>
                                    <span class="block text-[10px] text-rose-500/90 group-hover:text-rose-100 font-normal">Akhiri sesi login pemohon</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
