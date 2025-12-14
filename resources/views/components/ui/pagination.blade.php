@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination" class="flex items-center justify-center mt-8">
    <div class="flex flex-wrap items-center gap-2">
        {{-- Nút Previous --}}
        @if ($paginator->onFirstPage())
        <span
            class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold uppercase tracking-widest text-neutral-300 border border-neutral-100 cursor-not-allowed">
            Prev
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
            class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold uppercase tracking-widest text-black border border-neutral-200 hover:bg-black hover:text-white transition duration-300">
            Prev
        </a>
        @endif

        {{-- Các con số (Pagination Elements) --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <span class="px-2 py-2 text-neutral-400 text-xs font-medium">{{ $element }}</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        {{-- Trang hiện tại (Màu đen, chữ trắng) --}}
        <span aria-current="page"
            class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold border border-black bg-black text-white">
            {{ $page }}
        </span>
        @else
        {{-- Các trang khác (Trắng, chữ đen, hover đen) --}}
        <a href="{{ $url }}"
            class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-neutral-600 border border-neutral-100 hover:border-black hover:text-black transition duration-300">
            {{ $page }}
        </a>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Nút Next --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
            class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold uppercase tracking-widest text-black border border-neutral-200 hover:bg-black hover:text-white transition duration-300">
            Next
        </a>
        @else
        <span
            class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold uppercase tracking-widest text-neutral-300 border border-neutral-100 cursor-not-allowed">
            Next
        </span>
        @endif
    </div>
</nav>
@endif