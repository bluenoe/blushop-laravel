@props(['type' => 'info'])

@php
$base = 'rounded-md p-3';
$map = [
    'success' => 'bg-green-50 text-green-800 dark:bg-green-950 dark:text-green-200 border border-green-500/30',
    'warning' => 'bg-yellow-50 text-yellow-800 dark:bg-yellow-950 dark:text-yellow-200 border border-yellow-500/30',
    'info' => 'bg-blue-50 text-blue-800 dark:bg-blue-950 dark:text-blue-200 border border-blue-500/30',
    'danger' => 'bg-red-50 text-red-800 dark:bg-red-950 dark:text-red-200 border border-red-500/30',
];
$classes = $base.' '.($map[$type] ?? $map['info']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
    
</div>