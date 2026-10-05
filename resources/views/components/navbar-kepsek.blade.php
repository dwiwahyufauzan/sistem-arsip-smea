<!-- Top Navigation Bar - Portal Eksekutif Kepala Sekolah (Full Width) -->
<header {{ $attributes->merge(['class' => 'h-20 bg-white border-b border-slate-200 fixed top-0 inset-x-0 z-40 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-xs']) }}>
    <!-- Left: Brand Logo, System Name & Mobile Menu Toggle -->
    <div class="flex items-center gap-3 sm:gap-4 shrink-0">
        <!-- Mobile menu toggle button -->
        <button 
            type="button" 
            onclick="toggleKepsekSidebar()"
            class="md:hidden p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 transition-colors cursor-pointer"
            title="Buka / Tutup Navigasi"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        <!-- School Brand Header on Navbar -->
        <a href="{{ route('kepsek.dashboard') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMKN 1 Subang" class="w-10 h-12 object-contain shrink-0 group-hover:scale-105 transition-transform drop-shadow-xs">
            <div class="overflow-hidden">
                <div class="flex items-center gap-1.5">
                    <span class="font-heading font-extrabold text-slate-900 text-base sm:text-lg tracking-tight truncate group-hover:text-emerald-700 transition-colors">EKSEKUTIF</span>
                    <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">KEPSEK</span>
                </div>
                <p class="text-xs text-slate-500 font-medium truncate hidden sm:block">SMK Negeri 1 Subang</p>
            </div>
        </a>
    </div>

    <!-- Center: Search Input Bar -->
    <div class="hidden md:flex items-center flex-1 max-w-xl mx-4 lg:mx-8">
        <form action="{{ url('/kepala-sekolah/pencarian-kmp') }}" method="GET" class="relative w-full">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Cari arsip & pengesahan pimpinan (KMP Search)..." 
                    class="w-full pl-10 sm:pl-11 pr-16 sm:pr-20 py-2 sm:py-2.5 text-xs sm:text-sm rounded-xl bg-slate-50 border border-slate-200 hover:bg-slate-100/70 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent transition-all placeholder:text-slate-400 shadow-2xs"
                >
                <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <kbd class="px-2 py-0.5 sm:py-1 text-[10px] sm:text-[11px] font-mono text-slate-500 bg-slate-200/80 border border-slate-300/60 rounded font-semibold">KMP</kbd>
                </span>
            </div>
        </form>
    </div>

    <!-- Right Action Menus -->
    <div class="flex items-center gap-3 sm:gap-4 shrink-0">
        <a href="{{ route('landing') }}" target="_blank" class="p-2.5 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-colors cursor-pointer" title="Buka Portal Beranda Publik">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>

        <!-- Profile Dropdown Menu Kepsek -->
        <div class="relative pl-2 sm:pl-3 border-l border-slate-200" id="kepsekProfileDropdownContainer">
            <button 
                type="button" 
                onclick="toggleKepsekProfileDropdown(event)" 
                class="flex items-center gap-2.5 sm:gap-3 py-1 px-1.5 rounded-xl hover:bg-slate-100/80 transition-colors cursor-pointer group focus:outline-none"
                aria-expanded="false"
                id="kepsekProfileDropdownBtn"
                title="Menu Pengguna & Logout"
            >
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-emerald-800 text-white font-bold flex items-center justify-center text-xs sm:text-sm shadow-xs shrink-0 group-hover:scale-105 transition-transform ring-2 ring-transparent group-hover:ring-emerald-200">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="hidden sm:block text-left text-xs">
                    <p class="font-semibold text-slate-900 leading-tight truncate max-w-[130px]">{{ auth()->user()->name }}</p>
                    <span class="text-[10px] font-semibold text-emerald-800 bg-emerald-50 border border-emerald-100 px-1.5 py-0.5 rounded-md mt-0.5 inline-block">Kepala Sekolah</span>
                </div>
            </button>

            <!-- Dropdown Menu Box (Lebar, Elegan, dan Nyaman) -->
            <div 
                id="kepsekProfileDropdownMenu" 
                class="hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl shadow-slate-900/15 border border-slate-200/90 py-1 z-50 animate-in fade-in zoom-in-95 duration-150"
            >
                <!-- User Identity Card -->
                <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/70 rounded-t-2xl">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-emerald-800 text-white font-bold flex items-center justify-center text-sm shadow-xs shrink-0 ring-2 ring-emerald-100">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-slate-900 truncate leading-snug">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate mt-0.5">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <!-- Role Badge & NIP Stacked Vertically -->
                    <div class="flex flex-col items-start gap-2 mt-3.5 pt-3 border-t border-slate-200/70">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/80">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            <span>Pimpinan / Kepala Sekolah</span>
                        </span>
                        @if(auth()->user()->nip_nisn)
                            <div class="w-full flex items-center gap-2 px-2.5 py-1.5 rounded-lg bg-white border border-slate-200 text-xs shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                                <span class="text-[11px] font-medium text-slate-500 font-sans">NIP:</span>
                                <span class="font-mono font-semibold text-slate-800 tracking-tight">{{ auth()->user()->nip_nisn }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="p-2 space-y-1">
                    <a 
                        href="{{ route('profile.edit') }}" 
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-emerald-50/80 transition-all group"
                    >
                        <div class="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-emerald-100 text-slate-500 group-hover:text-emerald-700 flex items-center justify-center shrink-0 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-slate-800 group-hover:text-emerald-800">Pengaturan Akun & Password</span>
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
                            <span class="block text-xs font-semibold text-slate-800 group-hover:text-slate-900">Buka Portal Publik</span>
                            <span class="block text-[10px] text-slate-400 font-normal">Halaman utama SMKN 1 Subang</span>
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
                                <span class="block text-xs font-bold">Keluar dari Sistem</span>
                                <span class="block text-[10px] text-rose-500/90 group-hover:text-rose-100 font-normal">Akhiri sesi login pimpinan</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
