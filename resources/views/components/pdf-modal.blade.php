<!-- Global PDF Viewer Modal Component -->
<div 
    id="globalPdfModal" 
    class="fixed inset-0 z-50 hidden transition-opacity duration-300"
    role="dialog" 
    aria-modal="true"
    aria-labelledby="pdfModalTitle"
>
    <!-- Backdrop Blur Overlay -->
    <div 
        id="pdfModalBackdrop" 
        class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity"
        onclick="window.closePdfModal()"
    ></div>

    <!-- Modal Content Box -->
    <div class="fixed inset-0 z-10 flex items-center justify-center p-3 sm:p-6 md:p-8">
        <div class="relative w-full max-w-5xl h-[90vh] bg-slate-900 border border-slate-700/80 rounded-2xl shadow-2xl flex flex-col overflow-hidden text-slate-100">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-5 py-3.5 bg-slate-800/90 border-b border-slate-700/80 shrink-0">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-8 h-8 rounded-lg bg-rose-500/20 text-rose-400 flex items-center justify-center shrink-0 border border-rose-500/30">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="truncate">
                        <h3 id="pdfModalTitle" class="font-semibold text-sm text-white truncate">Pratinjau Dokumen PDF</h3>
                        <p id="pdfModalSubtitle" class="text-xs text-slate-400 font-mono truncate">Menyiapkan berkas...</p>
                    </div>
                </div>

                <!-- Action Controls -->
                <div class="flex items-center gap-2 shrink-0">
                    <a 
                        id="pdfModalNewTabBtn" 
                        href="#" 
                        target="_blank" 
                        class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/60 transition-colors text-xs inline-flex items-center gap-1.5"
                        title="Buka Dokumen di Tab Baru"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span class="hidden sm:inline">Tab Baru</span>
                    </a>

                    <a 
                        id="pdfModalDownloadBtn" 
                        href="#" 
                        download
                        class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-700/60 transition-colors text-xs inline-flex items-center gap-1.5"
                        title="Unduh Berkas PDF"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span class="hidden sm:inline">Unduh</span>
                    </a>

                    <button 
                        type="button" 
                        onclick="window.closePdfModal()"
                        class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-700/60 transition-colors"
                        title="Tutup (Esc)"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <!-- PDF Viewer Body -->
            <div class="relative flex-grow bg-slate-950 flex items-center justify-center overflow-hidden">
                <iframe 
                    id="pdfModalFrame" 
                    src="" 
                    class="w-full h-full border-0"
                    title="Pratinjau PDF"
                    loading="lazy"
                ></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    window.openPdfModal = function(fileUrl, title = 'Dokumen PDF') {
        const modal = document.getElementById('globalPdfModal');
        const frame = document.getElementById('pdfModalFrame');
        const titleEl = document.getElementById('pdfModalTitle');
        const subtitleEl = document.getElementById('pdfModalSubtitle');
        const newTabBtn = document.getElementById('pdfModalNewTabBtn');
        const downloadBtn = document.getElementById('pdfModalDownloadBtn');

        if (!modal || !frame) return;

        titleEl.textContent = title;
        subtitleEl.textContent = fileUrl;
        frame.src = fileUrl;
        newTabBtn.href = fileUrl;
        downloadBtn.href = fileUrl;

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };

    window.closePdfModal = function() {
        const modal = document.getElementById('globalPdfModal');
        const frame = document.getElementById('pdfModalFrame');

        if (!modal) return;

        modal.classList.add('hidden');
        if (frame) frame.src = '';
        document.body.classList.remove('overflow-hidden');
    };

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            window.closePdfModal();
        }
    });
</script>
