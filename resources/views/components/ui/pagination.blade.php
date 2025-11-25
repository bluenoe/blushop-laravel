@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="inline-flex items-center justify-center">
        <div class="inline-flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg border border-beige bg-warm text-gray-400 cursor-not-allowed shadow-soft" aria-disabled="true" aria-label="Previous">Prev</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg border border-beige bg-warm text-ink hover:bg-beige transition-colors shadow-soft">Prev</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 py-1 text-gray-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-indigo-600 text-white border border-indigo-600 shadow-soft">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg border border-beige bg-warm text-ink hover:bg-beige hover:text-ink transition-colors shadow-soft">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg border border-beige bg-warm text-ink hover:bg-beige transition-colors shadow-soft">Next</a>
            @else
                <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg border border-beige bg-warm text-gray-400 cursor-not-allowed shadow-soft" aria-disabled="true" aria-label="Next">Next</span>
            @endif
        </div>
    </nav>
@endif
