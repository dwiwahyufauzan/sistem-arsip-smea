@props([
    'label' => '',
    'value' => '0',
    'sub' => '',
    'color' => 'blue', // 'blue', 'emerald', 'teal', 'amber', 'purple', 'rose', 'sky'
])

@php
    $colorConfig = match($color) {
        'emerald' => [
            'iconBg' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
            'valueText' => 'text-slate-900',
            'subText' => 'text-emerald-700',
        ],
        'teal' => [
            'iconBg' => 'bg-teal-50 text-teal-700 border-teal-100',
            'valueText' => 'text-slate-900',
            'subText' => 'text-teal-700',
        ],
        'amber' => [
            'iconBg' => 'bg-amber-50 text-amber-700 border-amber-100',
            'valueText' => 'text-amber-700',
            'subText' => 'text-amber-700/80',
        ],
        'purple' => [
            'iconBg' => 'bg-purple-50 text-purple-700 border-purple-100',
            'valueText' => 'text-slate-900',
            'subText' => 'text-purple-700',
        ],
        'rose' => [
            'iconBg' => 'bg-rose-50 text-rose-700 border-rose-100',
            'valueText' => 'text-rose-700',
            'subText' => 'text-rose-700/80',
        ],
        'sky' => [
            'iconBg' => 'bg-sky-50 text-sky-700 border-sky-100',
            'valueText' => 'text-slate-900',
            'subText' => 'text-sky-700',
        ],
        default => [
            'iconBg' => 'bg-blue-50 text-blue-700 border-blue-100',
            'valueText' => 'text-slate-900',
            'subText' => 'text-slate-400',
        ],
    };
@endphp

<div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs hover:border-slate-300 transition-all duration-200 flex items-center justify-between gap-4">
    <div class="space-y-0.5">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ $label }}</p>
        <h3 class="text-2xl font-extrabold tracking-tight {{ $colorConfig['valueText'] }}">{{ $value }}</h3>
        @if($sub)
            <p class="text-[11px] {{ $colorConfig['subText'] }} font-medium line-clamp-1">{{ $sub }}</p>
        @endif
    </div>
    @if(isset($icon))
        <div class="w-12 h-12 rounded-xl {{ $colorConfig['iconBg'] }} border flex items-center justify-center shrink-0 shadow-xs">
            {{ $icon }}
        </div>
    @endif
</div>
