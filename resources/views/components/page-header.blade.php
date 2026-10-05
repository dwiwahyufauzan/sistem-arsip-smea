@props([
    'badge' => '',
    'overline' => '',
    'title' => '',
    'description' => '',
    'subtitle' => '',
    'theme' => 'blue', // 'blue', 'emerald', 'teal', 'slate'
])

@php
    $badgeText = $badge ?: $overline;
    $descText = $description ?: $subtitle;
    $badgeClasses = match($theme) {
        'emerald' => 'text-emerald-700 bg-emerald-50 border-emerald-200',
        'teal' => 'text-teal-700 bg-teal-50 border-teal-200',
        'slate' => 'text-slate-700 bg-slate-100 border-slate-200',
        default => 'text-blue-700 bg-blue-50 border-blue-200',
    };
@endphp

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs">
    <div class="space-y-1">
        @if($badgeText)
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $badgeClasses }}">
                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                <span>{{ $badgeText }}</span>
            </div>
        @endif
        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
            {{ $title }}
        </h1>
        @if($descText)
            <p class="text-xs sm:text-sm text-slate-500 max-w-3xl leading-relaxed">
                {{ $descText }}
            </p>
        @endif
    </div>

    @if(isset($actions) && $actions->isNotEmpty())
        <div class="flex items-center gap-2.5 shrink-0 flex-wrap">
            {{ $actions }}
        </div>
    @elseif(!empty($slot->toHtml()))
        <div class="flex items-center gap-2.5 shrink-0 flex-wrap">
            {{ $slot }}
        </div>
    @endif
</div>
