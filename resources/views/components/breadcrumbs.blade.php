@props(['items' => []])

@if(!empty($items))
<nav aria-label="Breadcrumb" class="max-w-full overflow-x-auto">
    <ol class="inline-flex items-center gap-1 rounded-md border border-beige bg-warm px-2 py-1 text-sm shadow-soft dark:bg-slate-900 dark:border-slate-700">
        @foreach($items as $i => $seg)
            @php $isLast = ($i === count($items) - 1); @endphp
            <li class="flex items-center">
                @if(!$isLast && !empty($seg['url']))
                    <a href="{{ $seg['url'] }}" class="text-gray-700 hover:text-ink focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded dark:text-slate-300 dark:hover:text-white">
                        {{ $seg['label'] }}
                    </a>
                @else
                    <span @if($isLast) aria-current="page" @endif class="{{ $isLast ? 'text-ink font-semibold' : 'text-gray-700' }} dark:text-slate-300 dark:font-medium">
                        {{ $seg['label'] }}
                    </span>
                @endif
            </li>
            @if(!$isLast)
                <li class="px-1 text-gray-400 dark:text-slate-500">/</li>
            @endif
        @endforeach
    </ol>
@endif
