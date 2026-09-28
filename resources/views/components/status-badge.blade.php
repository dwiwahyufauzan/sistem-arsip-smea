@props([
    'status' => '',
    'type' => 'general'
])

@php
    $statusKey = strtolower(trim($status));
    
    $badgeConfig = match($statusKey) {
        // Surat Masuk
        'diterima' => [
            'label' => 'Diterima',
            'class' => 'bg-sky-50 text-sky-700 border-sky-200 ring-1 ring-sky-500/20',
            'dot' => 'bg-sky-500'
        ],
        'didisposisikan' => [
            'label' => 'Didisposisikan',
            'class' => 'bg-indigo-50 text-indigo-700 border-indigo-200 ring-1 ring-indigo-500/20',
            'dot' => 'bg-indigo-500'
        ],
        'diarsipkan' => [
            'label' => 'Diarsipkan',
            'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-1 ring-emerald-500/20',
            'dot' => 'bg-emerald-500'
        ],

        // Surat Keluar & Persetujuan
        'draft' => [
            'label' => 'Draf Konsep',
            'class' => 'bg-slate-100 text-slate-700 border-slate-200 ring-1 ring-slate-500/20',
            'dot' => 'bg-slate-400'
        ],
        'menunggu_persetujuan' => [
            'label' => 'Menunggu Persetujuan Kepsek',
            'class' => 'bg-amber-50 text-amber-800 border-amber-300 ring-1 ring-amber-500/30',
            'dot' => 'bg-amber-500 animate-pulse'
        ],
        'disetujui' => [
            'label' => 'Disetujui',
            'class' => 'bg-emerald-50 text-emerald-800 border-emerald-300 ring-1 ring-emerald-500/20',
            'dot' => 'bg-emerald-600'
        ],
        'ditolak' => [
            'label' => 'Ditolak',
            'class' => 'bg-rose-50 text-rose-800 border-rose-300 ring-1 ring-rose-500/20',
            'dot' => 'bg-rose-600'
        ],

        // Disposisi
        'menunggu' => [
            'label' => 'Menunggu Tindak Lanjut',
            'class' => 'bg-amber-50 text-amber-700 border-amber-200 ring-1 ring-amber-500/20',
            'dot' => 'bg-amber-500'
        ],
        'ditindaklanjuti' => [
            'label' => 'Sedang Ditindaklanjuti',
            'class' => 'bg-blue-50 text-blue-700 border-blue-200 ring-1 ring-blue-500/20',
            'dot' => 'bg-blue-600'
        ],
        'selesai' => [
            'label' => 'Selesai',
            'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-1 ring-emerald-500/20',
            'dot' => 'bg-emerald-600'
        ],

        // Pengajuan Legalisir
        'menunggu_verifikasi' => [
            'label' => 'Menunggu Verifikasi TU',
            'class' => 'bg-amber-50 text-amber-800 border-amber-300 ring-1 ring-amber-500/30',
            'dot' => 'bg-amber-500 animate-pulse'
        ],
        'diverifikasi' => [
            'label' => 'Terverifikasi TU',
            'class' => 'bg-sky-50 text-sky-800 border-sky-300 ring-1 ring-sky-500/20',
            'dot' => 'bg-sky-600'
        ],
        'menunggu_approval_kepsek' => [
            'label' => 'Menunggu Pengesahan Kepsek',
            'class' => 'bg-indigo-50 text-indigo-800 border-indigo-300 ring-1 ring-indigo-500/20',
            'dot' => 'bg-indigo-600 animate-pulse'
        ],
        'disetujui_kepsek' => [
            'label' => 'Disahkan Kepala Sekolah',
            'class' => 'bg-teal-50 text-teal-800 border-teal-300 ring-1 ring-teal-500/20',
            'dot' => 'bg-teal-600'
        ],
        'sedang_diproses' => [
            'label' => 'Sedang Diproses & Distempel',
            'class' => 'bg-purple-50 text-purple-800 border-purple-300 ring-1 ring-purple-500/20',
            'dot' => 'bg-purple-600 animate-pulse'
        ],
        'siap_diambil' => [
            'label' => 'Siap Diambil di TU',
            'class' => 'bg-emerald-100 text-emerald-900 border-emerald-400 ring-2 ring-emerald-500/30 animate-pulse font-bold',
            'dot' => 'bg-emerald-600'
        ],

        default => [
            'label' => ucfirst(str_replace('_', ' ', $statusKey)),
            'class' => 'bg-slate-100 text-slate-700 border-slate-200 ring-1 ring-slate-500/10',
            'dot' => 'bg-slate-400'
        ]
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold border ' . $badgeConfig['class']]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $badgeConfig['dot'] }}"></span>
    <span>{{ $badgeConfig['label'] }}</span>
</span>
