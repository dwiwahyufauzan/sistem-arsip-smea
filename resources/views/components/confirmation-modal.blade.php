<!-- Global Confirmation & Action Modal Component -->
<div 
    id="globalConfirmModal" 
    class="fixed inset-0 z-50 hidden transition-opacity duration-200" 
    role="dialog" 
    aria-modal="true" 
    aria-labelledby="confirmModalTitle"
>
    <!-- Backdrop Blur Overlay -->
    <div 
        id="confirmModalBackdrop" 
        class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity"
        onclick="window.closeConfirmModal()"
    ></div>

    <!-- Modal Dialog Box Container -->
    <div class="fixed inset-0 z-10 flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
        <div 
            id="confirmModalCard"
            class="relative bg-white rounded-2xl max-w-md w-full shadow-2xl border border-slate-100/90 overflow-hidden transform transition-all duration-200 scale-95 opacity-0 text-slate-800"
        >
            <!-- Form Wrapper for Automatic Form Submissions -->
            <form id="confirmModalForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="confirmModalMethod" value="POST">

                <!-- Header & Icon Section -->
                <div class="p-6 pb-4">
                    <div class="flex items-start gap-4">
                        <!-- Dynamic Icon Container -->
                        <div id="confirmModalIconWrapper" class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 border transition-colors bg-rose-50 text-rose-600 border-rose-100">
                            <!-- SVG Icons (Shown dynamically based on type) -->
                            <svg id="confirmIconDanger" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <svg id="confirmIconWarning" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <svg id="confirmIconSuccess" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <svg id="confirmIconInfo" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <!-- Title & Subtitle -->
                        <div class="flex-grow pt-0.5">
                            <h3 id="confirmModalTitle" class="font-heading font-bold text-base text-slate-900 leading-snug">
                                Konfirmasi Tindakan
                            </h3>
                            <p id="confirmModalSubtitle" class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Pastikan rincian data sebelum memproses tindakan ini.
                            </p>
                        </div>

                        <!-- Top Close Button -->
                        <button 
                            type="button" 
                            onclick="window.closeConfirmModal()" 
                            class="w-7 h-7 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors cursor-pointer shrink-0"
                            title="Tutup (Esc)"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Body / Details Section -->
                <div class="px-6 pb-5 space-y-3 text-xs">
                    <!-- Main Message -->
                    <div id="confirmModalMessage" class="text-slate-600 leading-relaxed font-normal">
                        Apakah Anda yakin ingin melanjutkan tindakan ini?
                    </div>

                    <!-- Highlighted Item Card (Optional) -->
                    <div id="confirmModalItemCard" class="hidden p-3.5 bg-slate-50 rounded-xl border border-slate-100 space-y-1.5 text-xs">
                        <div id="confirmModalItemContent" class="text-slate-800 font-medium"></div>
                    </div>

                    <!-- Warning Alert Banner (Optional) -->
                    <div id="confirmModalWarning" class="hidden p-3 rounded-xl border text-[11px] leading-relaxed font-medium bg-rose-50/80 text-rose-700 border-rose-100">
                        <span id="confirmModalWarningText"></span>
                    </div>

                    <!-- Optional Textarea/Input for Notes (Catatan) -->
                    <div id="confirmModalInputWrapper" class="hidden pt-1">
                        <label id="confirmModalInputLabel" for="confirmModalInput" class="block text-[11px] font-semibold text-slate-700 mb-1">
                            Catatan Tindakan:
                        </label>
                        <textarea 
                            id="confirmModalInput" 
                            name="catatan" 
                            rows="2" 
                            class="w-full text-xs bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-transparent transition-all"
                            placeholder="Tuliskan catatan opsional..."
                        ></textarea>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button 
                        type="button" 
                        id="confirmModalCancelBtn"
                        onclick="window.closeConfirmModal()" 
                        class="px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition-colors cursor-pointer shadow-2xs"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        id="confirmModalSubmitBtn"
                        class="px-4.5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors cursor-pointer flex items-center gap-1.5"
                    >
                        <span id="confirmModalSubmitText">Ya, Lanjutkan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        let currentCallback = null;
        let originalFormToSubmit = null;

        window.confirmAction = function(options) {
            const modal = document.getElementById('globalConfirmModal');
            const card = document.getElementById('confirmModalCard');
            const form = document.getElementById('confirmModalForm');
            const methodInput = document.getElementById('confirmModalMethod');
            const titleEl = document.getElementById('confirmModalTitle');
            const subtitleEl = document.getElementById('confirmModalSubtitle');
            const messageEl = document.getElementById('confirmModalMessage');
            const itemCard = document.getElementById('confirmModalItemCard');
            const itemContent = document.getElementById('confirmModalItemContent');
            const warningEl = document.getElementById('confirmModalWarning');
            const warningText = document.getElementById('confirmModalWarningText');
            const submitBtn = document.getElementById('confirmModalSubmitBtn');
            const submitText = document.getElementById('confirmModalSubmitText');
            const cancelBtn = document.getElementById('confirmModalCancelBtn');
            const iconWrapper = document.getElementById('confirmModalIconWrapper');
            const inputWrapper = document.getElementById('confirmModalInputWrapper');
            const inputLabel = document.getElementById('confirmModalInputLabel');
            const inputField = document.getElementById('confirmModalInput');

            const iconDanger = document.getElementById('confirmIconDanger');
            const iconWarning = document.getElementById('confirmIconWarning');
            const iconSuccess = document.getElementById('confirmIconSuccess');
            const iconInfo = document.getElementById('confirmIconInfo');

            if (!modal) return;

            // Reset Callback & Form state
            currentCallback = typeof options.onConfirm === 'function' ? options.onConfirm : null;
            originalFormToSubmit = options.form || null;

            // Set Title & Subtitle
            titleEl.textContent = options.title || 'Konfirmasi Tindakan';
            subtitleEl.textContent = options.subtitle || 'Pastikan rincian data sebelum memproses tindakan ini.';

            // Set Message (Supports HTML or plain text)
            if (options.messageHtml) {
                messageEl.innerHTML = options.messageHtml;
            } else if (options.message) {
                messageEl.textContent = options.message;
            } else {
                messageEl.textContent = 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
            }

            // Set Highlighted Item Details Card
            if (options.itemDetailsHtml) {
                itemContent.innerHTML = options.itemDetailsHtml;
                itemCard.classList.remove('hidden');
            } else if (options.targetName) {
                itemContent.innerHTML = `Target: <strong class="text-slate-900">${options.targetName}</strong>` + 
                    (options.targetBadge ? ` <span class="ml-1.5 px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-blue-100 text-blue-900">${options.targetBadge}</span>` : '');
                itemCard.classList.remove('hidden');
            } else {
                itemCard.classList.add('hidden');
                itemContent.innerHTML = '';
            }

            // Set Warning Alert Banner
            if (options.warning) {
                warningText.textContent = options.warning;
                warningEl.classList.remove('hidden');
            } else {
                warningEl.classList.add('hidden');
                warningText.textContent = '';
            }

            // Set Input Field (Catatan)
            if (options.input) {
                inputWrapper.classList.remove('hidden');
                inputLabel.textContent = options.input.label || 'Catatan:';
                inputField.name = options.input.name || 'catatan';
                inputField.placeholder = options.input.placeholder || 'Tuliskan catatan...';
                inputField.required = !!options.input.required;
                inputField.value = options.input.value || '';
            } else {
                inputWrapper.classList.add('hidden');
                inputField.value = '';
                inputField.required = false;
            }

            // Type Styles (danger, success, info, warning)
            const type = options.type || 'danger';

            // Reset icons
            iconDanger.classList.add('hidden');
            iconWarning.classList.add('hidden');
            iconSuccess.classList.add('hidden');
            iconInfo.classList.add('hidden');

            // Reset classes
            iconWrapper.className = 'w-12 h-12 rounded-xl flex items-center justify-center shrink-0 border transition-colors';
            submitBtn.className = 'px-4.5 py-2 text-xs font-bold rounded-xl shadow-xs transition-colors cursor-pointer flex items-center gap-1.5 text-white';

            if (type === 'danger') {
                iconDanger.classList.remove('hidden');
                iconWrapper.classList.add('bg-rose-50', 'text-rose-600', 'border-rose-100');
                submitBtn.classList.add('bg-rose-600', 'hover:bg-rose-700');
            } else if (type === 'success') {
                iconSuccess.classList.remove('hidden');
                iconWrapper.classList.add('bg-emerald-50', 'text-emerald-600', 'border-emerald-100');
                submitBtn.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
            } else if (type === 'info') {
                iconInfo.classList.remove('hidden');
                iconWrapper.classList.add('bg-blue-50', 'text-blue-900', 'border-blue-100');
                submitBtn.classList.add('bg-blue-900', 'hover:bg-blue-800');
            } else if (type === 'warning') {
                iconWarning.classList.remove('hidden');
                iconWrapper.classList.add('bg-amber-50', 'text-amber-600', 'border-amber-100');
                submitBtn.classList.add('bg-amber-600', 'hover:bg-amber-700');
            }

            // Button texts
            submitText.textContent = options.confirmText || (type === 'danger' ? 'Ya, Hapus' : (type === 'info' || options.cancelText === null ? 'Mengerti' : 'Ya, Lanjutkan'));
            if (options.cancelText === null || options.cancelText === false) {
                cancelBtn.classList.add('hidden');
            } else {
                cancelBtn.classList.remove('hidden');
                cancelBtn.textContent = options.cancelText || 'Batal';
            }

            // Set Form action & method
            if (options.actionUrl) {
                form.action = options.actionUrl;
                methodInput.value = (options.method || 'POST').toUpperCase();
            } else {
                form.action = '';
                methodInput.value = 'POST';
            }

            // Show Modal with Animation
            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            });
            document.body.classList.add('overflow-hidden');
        };

        window.closeConfirmModal = function() {
            const modal = document.getElementById('globalConfirmModal');
            const card = document.getElementById('confirmModalCard');
            if (!modal) return;

            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                currentCallback = null;
                originalFormToSubmit = null;
            }, 150);
        };

        // Form Submit Handler
        const form = document.getElementById('confirmModalForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (currentCallback) {
                    e.preventDefault();
                    const callback = currentCallback;
                    const inputField = document.getElementById('confirmModalInput');
                    const noteValue = inputField ? inputField.value : null;
                    window.closeConfirmModal();
                    callback(noteValue);
                    return;
                }

                if (originalFormToSubmit) {
                    e.preventDefault();
                    const originalForm = originalFormToSubmit;
                    const inputField = document.getElementById('confirmModalInput');
                    if (inputField && inputField.name && inputField.value) {
                        let existingInput = originalForm.querySelector(`[name="${inputField.name}"]`);
                        if (!existingInput) {
                            existingInput = document.createElement('input');
                            existingInput.type = 'hidden';
                            existingInput.name = inputField.name;
                            originalForm.appendChild(existingInput);
                        }
                        existingInput.value = inputField.value;
                    }
                    window.closeConfirmModal();
                    originalForm.submit();
                    return;
                }

                // If form has an actionUrl, allow normal submission
                if (form.getAttribute('action') && form.getAttribute('action') !== '') {
                    return true;
                }

                e.preventDefault();
                window.closeConfirmModal();
            });
        }

        // Global Helper for form confirmations
        window.confirmForm = function(formElement, options = {}) {
            options.form = formElement;
            window.confirmAction(options);
            return false;
        };

        // Global Helper for single-button information/warning alert popups
        window.showAlertModal = function(title, message, type = 'warning') {
            window.confirmAction({
                title: title || 'Pemberitahuan Sistem',
                message: message,
                type: type,
                confirmText: 'Mengerti',
                cancelText: null
            });
        };

        // Global Escape Key Listener
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const confirmModal = document.getElementById('globalConfirmModal');
                if (confirmModal && !confirmModal.classList.contains('hidden')) {
                    window.closeConfirmModal();
                }
            }
        });
    })();
</script>
