@props(['lines' => 2])
<div class="space-y-2">
    @for ($i = 0; $i < $lines; $i++)
        <div class="h-4 bg-ash rounded animate-pulse"></div>
    @endfor
</div>