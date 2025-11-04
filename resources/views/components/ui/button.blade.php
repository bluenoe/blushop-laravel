@props(['variant' => 'primary', 'href' => null, 'type' => 'button'])

@php
$base = 'inline-flex items-center justify-center rounded-md font-semibold transition focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
$variants = [
    'primary' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-600 dark:bg-blue-500 dark:hover:bg-blue-600',
    'secondary' => 'border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800',
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