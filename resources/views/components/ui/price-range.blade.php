@props([
'min' => 0,
'max' => 1000000,
'valueMin' => null,
'valueMax' => null,
'nameMin' => 'price_min',
'nameMax' => 'price_max',
])

@php
$start = is_null($valueMin) ? (int) $min : (int) $valueMin;
$end = is_null($valueMax) ? (int) $max : (int) $valueMax;
if ($start < $min) $start=(int) $min; if ($end> $max) $end = (int) $max;
    if ($start > $end) { $tmp = $start; $start = $end; $end = $tmp; }
    @endphp

    <div x-data="{ min: {{ $start }}, max: {{ $end }}, floor: {{ (int) $min }}, ceil: {{ (int) $max }} }"
        class="space-y-2">
        <div class="flex items-center justify-between text-sm">
            <span class="text-gray-600">Price range</span>
            <span class="font-medium text-ink">₫<span x-text="min.toLocaleString('vi-VN')"></span> – ₫<span
                    x-text="max.toLocaleString('vi-VN')"></span></span>
        </div>

        <div class="space-y-2 mt-2">
            <input type="range" x-model.number="min" :min="floor" :max="ceil" step="1000"
                class="w-full accent-indigo-600" aria-label="Minimum price">
            <input type="range" x-model.number="max" :min="floor" :max="ceil" step="1000"
                class="w-full accent-indigo-600" aria-label="Maximum price">
            <div class="h-2 rounded-full bg-beige/60">
                <div class="h-2 bg-indigo-500 rounded-full"
                    :style="`width: ${(max - min) / (ceil - floor) * 100}%; margin-left: ${(min - floor) / (ceil - floor) * 100}%`">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <input type="hidden" name="{{ $nameMin }}" x-model.number="min">
            <input type="hidden" name="{{ $nameMax }}" x-model.number="max">
        </div>
    </div>