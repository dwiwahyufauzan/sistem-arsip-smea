@props([
    'portal' => 'admin', // 'admin', 'kepsek', 'pemohon'
])

@if($portal === 'kepsek')
    <x-navbar-kepsek {{ $attributes }} />
@elseif($portal === 'pemohon')
    <x-navbar-pemohon {{ $attributes }} />
@else
    <x-navbar-admin {{ $attributes }} />
@endif
