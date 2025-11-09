@props(['product', 'type' => 'shop'])

@php
$isShop = $type === 'shop';
$isLanding = $type === 'landing';
$isFeatured = $type === 'featured';
@endphp

<article class="group relative flex flex-col overflow-hidden rounded-3xl border border-beige bg-white shadow-soft
           transition-transform duration-200 hover:-translate-y-1 hover:shadow-lg h-full">

    {{-- ✅ Full-card clickable overlay (trừ Add to cart) --}}
    <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="absolute inset-0 z-10"
        aria-label="Xem chi tiết {{ $product->name }}"></a>

    {{-- 🖼️ Image Section --}}
    <div class="relative aspect-[4/5] overflow-hidden bg-warm max-h-[260px]">
        <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}"
            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
        {{-- Wishlist button --}}
        {{-- Wishlist button (heart đẹp, cân đối) --}}
        <button type="button" class="group/heart absolute top-3 right-3 z-20 inline-flex h-9 w-9 items-center justify-center rounded-full
           bg-white/90 text-ink shadow-sm ring-1 ring-beige/70
           transition hover:bg-rose-50 hover:text-rose-500 hover:ring-rose-200 hover:scale-105">
            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5">
                <path
                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"
                    fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>

    </div>

    {{-- 🧾 Info Section --}}
    <div class="relative z-20 flex flex-col justify-between px-5 pt-4 pb-5 flex-1">
        <div class="flex-1">
            <h3 class="text-base sm:text-lg font-semibold text-ink line-clamp-2 mb-2">
                {{ $product->name }}
            </h3>

            @if($isShop)
            <div class="flex flex-wrap gap-2 mb-3">
                <span class="inline-flex items-center rounded-full border border-beige bg-warm/60
                               px-2.5 py-0.5 text-[11px] font-medium uppercase tracking-wide text-ink
                               transition-transform duration-150 hover:-translate-y-[1px] hover:shadow-sm
                               hover:border-indigo-100 hover:bg-white">
                    {{ $product->category->name ?? 'Uncategorized' }}
                </span>
                <span class="inline-flex items-center rounded-full border border-beige bg-white
                               px-2.5 py-0.5 text-[11px] font-medium uppercase tracking-wide text-gray-600
                               transition-transform duration-150 hover:-translate-y-[1px] hover:shadow-sm
                               hover:border-indigo-100 hover:bg-warm/80 hover:text-ink">
                    Blu
                </span>
            </div>

            <p class="text-sm text-gray-600 leading-relaxed line-clamp-2">
                {{ $product->short_description ?? 'Minimal Blu everyday gear for students — simple, durable, easy to mix
                & match.' }}
            </p>
            @endif
        </div>

        {{-- 💰 Price & Add to Cart --}}
        <div class="mt-4 flex items-center justify-between">
            <div>
                <span class="block text-[11px] font-semibold uppercase tracking-wide text-gray-500">
                    Price
                </span>
                <p class="text-lg font-semibold text-ink">
                    ₫{{ number_format((float) $product->price, 0, ',', '.') }}
                </p>
            </div>

            @if($isShop)
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="z-20">
                @csrf
                <button type="submit"
                    class="inline-flex items-center rounded-full bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white
                               shadow-md shadow-indigo-500/30 hover:bg-indigo-700 hover:shadow-lg
                               transition-transform duration-150 hover:scale-[1.03] focus-visible:outline-none
                               focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                    Add to cart
                </button>
            </form>
            @endif
        </div>
    </div>
</article>