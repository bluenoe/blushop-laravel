@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-ink text-start text-base font-medium text-ink bg-beige focus:outline-none focus:text-ink focus:bg-beige focus:border-ink transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-ink hover:bg-beige hover:border-beige focus:outline-none focus:text-ink focus:bg-beige focus:border-beige transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
