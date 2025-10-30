@props(['lines' => 2])
<div class="space-y-2">
    @for ($i = 0; $i < $lines; $i++)
        <div class="h-4 bg-gray-700 rounded animate-pulse"></div>
    @endfor
</div>