@if(session('success') || session('error') || session('warning') || session('info') || $errors->any())
    <div id="toastContainer" class="fixed top-5 right-5 z-50 flex flex-col gap-2.5 max-w-md w-full pointer-events-auto transition-all duration-300">
        {{-- Success Alert --}}
        @if(session('success'))
            <div class="toast-item flex items-start gap-3 p-4 rounded-xl bg-white border border-emerald-200 text-slate-800 shadow-xl shadow-emerald-900/10 transition-all">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="flex-grow text-xs">
                    <h4 class="font-bold text-emerald-900 text-sm">Berhasil!</h4>
                    <p class="text-slate-600 mt-0.5">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.closest('.toast-item').remove()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        {{-- Error Alert --}}
        @if(session('error'))
            <div class="toast-item flex items-start gap-3 p-4 rounded-xl bg-white border border-rose-200 text-slate-800 shadow-xl shadow-rose-900/10 transition-all">
                <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div class="flex-grow text-xs">
                    <h4 class="font-bold text-rose-900 text-sm">Terjadi Kesalahan</h4>
                    <p class="text-slate-600 mt-0.5">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="this.closest('.toast-item').remove()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        {{-- Warning Alert --}}
        @if(session('warning'))
            <div class="toast-item flex items-start gap-3 p-4 rounded-xl bg-white border border-amber-200 text-slate-800 shadow-xl shadow-amber-900/10 transition-all">
                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="flex-grow text-xs">
                    <h4 class="font-bold text-amber-900 text-sm">Peringatan</h4>
                    <p class="text-slate-600 mt-0.5">{{ session('warning') }}</p>
                </div>
                <button type="button" onclick="this.closest('.toast-item').remove()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        {{-- Validation Errors Alert --}}
        @if($errors->any())
            <div class="toast-item flex items-start gap-3 p-4 rounded-xl bg-white border border-rose-200 text-slate-800 shadow-xl shadow-rose-900/10 transition-all">
                <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="flex-grow text-xs">
                    <h4 class="font-bold text-rose-900 text-sm">Validasi Formulir Gagal</h4>
                    <ul class="list-disc list-inside text-rose-700 mt-1 space-y-0.5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" onclick="this.closest('.toast-item').remove()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif
    </div>

    <script>
        // Auto-dismiss toasts after 5 seconds
        setTimeout(() => {
            const toasts = document.querySelectorAll('.toast-item');
            toasts.forEach(toast => {
                toast.classList.add('opacity-0', 'translate-x-4');
                setTimeout(() => toast.remove(), 300);
            });
        }, 5000);
    </script>
@endif
