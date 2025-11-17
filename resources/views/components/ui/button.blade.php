@props(['variant' => 'primary', 'href' => null, 'type' => 'button'])

@php
$base = 'inline-flex items-center justify-center rounded-md font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
$variants = [
    'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white focus:ring-indigo-500',
    'secondary' => 'border border-beige text-ink hover:bg-beige',
    'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-600',
];
$size = 'px-4 py-2';
$classes = $base.' '.$size.' '.($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
@else
<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
@endif