@props([
    'title' => 'Tidak Ada Data',
    'description' => 'Belum ada dokumen atau arsip yang terdaftar pada modul ini.',
    'actionText' => '',
    'actionUrl' => '',
    'colspan' => null,
])

@php
    $content = '
        <div class="flex flex-col items-center justify-center text-center p-8 sm:p-12">
            <div class="w-16 h-16 rounded-2xl bg-slate-100 border border-slate-200 text-slate-400 flex items-center justify-center mb-4 shadow-xs">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <h3 class="text-sm font-bold text-slate-800">' . e($title) . '</h3>
            <p class="text-xs text-slate-500 max-w-sm mt-1 leading-relaxed">' . e($description) . '</p>
    ';

    if ($actionText && $actionUrl) {
        $content .= '
            <div class="mt-4">
                <a href="' . e($actionUrl) . '" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-xs transition-all">
                    <span>' . e($actionText) . '</span>
                </a>
            </div>
        ';
    }

    $content .= '</div>';
@endphp

@if($colspan)
    <tr>
        <td colspan="{{ $colspan }}">
            {!! $content !!}
        </td>
    </tr>
@else
    {!! $content !!}
@endif
