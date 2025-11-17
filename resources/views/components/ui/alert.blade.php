@props(['type' => 'info'])

@php
$base = 'rounded-md p-3';
$map = [
    'success' => 'bg-green-50 text-green-700 border border-green-200',
    'warning' => 'bg-yellow-50 text-yellow-700 border border-yellow-200',
    'info' => 'bg-blue-50 text-blue-700 border border-blue-200',
    'danger' => 'bg-red-50 text-red-700 border border-red-200',
];
$classes = $base.' '.($map[$type] ?? $map['info']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
    
</div>