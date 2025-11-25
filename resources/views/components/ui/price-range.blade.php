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

        <div class="relative mt-3" data-range>
            <div class="h-2 rounded-full bg-beige/60"></div>
            <div class="absolute inset-y-0 left-0 h-2 bg-indigo-500 rounded-full"
                :style="`width: ${(max - min) / (ceil - floor) * 100}%; margin-left: ${(min - floor) / (ceil - floor) * 100}%`">
            </div>
            <input type="range" x-model.number="min" :min="floor" :max="ceil" step="1000"
                class="absolute inset-0 w-full h-8 appearance-none bg-transparent pointer-events-auto"
                aria-label="Minimum price">
            <input type="range" x-model.number="max" :min="floor" :max="ceil" step="1000"
                class="absolute inset-0 w-full h-8 appearance-none bg-transparent pointer-events-auto"
                aria-label="Maximum price">
            <style>
                [data-range] input[type="range"]::-webkit-slider-runnable-track {
                    background: transparent;
                    border: none;
                }

                [data-range] input[type="range"]::-moz-range-track {
                    background: transparent;
                    border: none;
                }

                [data-range] input[type="range"] {
                    outline: none;
                }

                [data-range] input[type="range"]::-webkit-slider-thumb {
                    -webkit-appearance: none;
                    appearance: none;
                    width: 16px;
                    height: 16px;
                    border-radius: 9999px;
                    background: #4f46e5;
                    border: 2px solid white;
                    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.25);
                }

                [data-range] input[type="range"]::-moz-range-thumb {
                    width: 16px;
                    height: 16px;
                    border-radius: 9999px;
                    background: #4f46e5;
                    border: 2px solid white;
                    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.25);
                }
            </style>
        </div>

        <div class="flex items-center gap-2">
            <input type="hidden" name="{{ $nameMin }}" x-model.number="min">
            <input type="hidden" name="{{ $nameMax }}" x-model.number="max">
        </div>
    </div>