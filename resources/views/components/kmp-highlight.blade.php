@props([
    'text' => '',
    'keyword' => ''
])

@php
    $rawText = (string) $text;
    $kw = trim((string) $keyword);

    if ($kw !== '' && stripos($rawText, $kw) !== false) {
        $escapedKw = preg_quote($kw, '/');
        $highlighted = preg_replace(
            "/($escapedKw)/i",
            '<mark class="bg-amber-200/90 text-amber-950 font-bold px-1 py-0.5 rounded shadow-xs">$1</mark>',
            e($rawText)
        );
    } else {
        $highlighted = e($rawText);
    }
@endphp

{!! $highlighted !!}
