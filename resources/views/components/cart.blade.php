@props([
    'product',
    'type' => 'grid', // variants: grid, featured
    'isWished' => false,
])

<article class="group relative flex flex-col overflow-hidden rounded-3xl border border-beige bg-white shadow-soft
           transition-transform duration-200 hover:-translate-y-1 hover:shadow-lg"
         x-data="{ pid: {{ (int) $product->id }}, active: {{ $isWished ? 'true' : 'false' }} }"
         x-init="active = $store.wishlist ? $store.wishlist.isFav(pid) : active">

    {{-- Link toàn bộ card (trừ wishlist + nút Add to cart) --}}
    <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="absolute inset-0 z-10"
        aria-label="Xem chi tiết {{ $product->name }}">
    </a>

    <div class="relative z-20 flex flex-col h-full">
        {{-- Top: ảnh full khung + wishlist --}}
        <div class="relative {{ $type === 'featured' ? 'aspect-[4/3]' : 'aspect-[4/5]' }} overflow-hidden bg-warm">
            <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition-transform duration-300
                       group-hover:scale-105">

            {{-- Overlay nhẹ cho cảm giác premium --}}
            <div
                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/8 via-transparent to-transparent">
            </div>

            {{-- Wishlist toggle --}}
            <button type="button"
                    class="group/heart absolute top-4 right-4 z-20 inline-flex h-9 w-9 items-center justify-center rounded-full
                           bg-white/90 text-ink shadow-sm ring-1 ring-beige/70
                           transition hover:bg-rose-50 hover:text-rose-500 hover:ring-rose-200 hover:scale-105"
                    :class="active ? 'bg-rose-50 text-rose-600 ring-rose-200' : ''"
                    :aria-pressed="active"
                    :title="active ? 'Remove from wishlist' : 'Add to wishlist'"
                    @click.stop="$store.wishlist.toggle(pid); active = $store.wishlist.isFav(pid)">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5">
                    <path
                        d="M12 20.25s-4.92-3.13-7.36-5.57C3.11 13.16 2.25 11.9 2.25 10.4c0-2.02 1.63-3.65 3.65-3.65 1.22 0 2.39.6 3.1 1.53.71-.93 1.88-1.53 3.1-1.53 2.02 0 3.65 1.63 3.65 3.65 0 1.5-.86 2.76-2.39 4.28C16.92 17.12 12 20.25 12 20.25Z"
                        :fill="active ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>

            @if($type === 'featured')
                <span class="absolute top-3 left-3 inline-flex items-center rounded-full bg-indigo-600/90 text-white text-xs font-semibold px-2 py-0.5 shadow">
                    Featured
                </span>
            @endif
        </div>

        {{-- Body: tên, tag, mô tả, giá + nút --}}
        <div class="px-5 pt-4 pb-5 flex flex-col gap-3">
            {{-- Tên sản phẩm + tags --}}
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-ink line-clamp-2">
                    {{ $product->name }}
                </h3>

                @if($product->category)
                <div class="mt-2 flex flex-wrap gap-2">
                    {{-- Category tag --}}
                    <span class="inline-flex items-center rounded-full border border-beige bg-warm/70
                                   px-2.5 py-0.5 text-[11px] font-medium uppercase tracking-wide text-ink
                                   transition-transform duration-150 hover:-translate-y-[1px] hover:shadow-sm
                                   hover:border-indigo-100 hover:bg-white">
                        {{ $product->category->name }}
                    </span>

                    {{-- Tag brand Blu --}}
                    <span class="inline-flex items-center rounded-full border border-beige bg-white
                                   px-2.5 py-0.5 text-[11px] font-medium uppercase tracking-wide text-gray-600
                                   transition-transform duration-150 hover:-translate-y-[1px] hover:shadow-sm
                                   hover:border-indigo-100 hover:bg-warm/80 hover:text-ink">
                        Blu
                    </span>
                </div>
                @endif
            </div>

            {{-- Mô tả ngắn --}}
            <p class="text-sm text-gray-600 leading-relaxed line-clamp-2">
                {{ $product->short_description ?? 'Minimal Blu everyday gear for students — simple, durable, easy to mix
                & match.' }}
            </p>

            {{-- Giá + actions --}}
            <div class="mt-1 flex items-end justify-between gap-3">
                <div>
                    <span class="block text-[11px] font-semibold uppercase tracking-wide text-gray-500">
                        Price
                    </span>
                    <p class="text-xl font-semibold text-ink">
                        ₫{{ number_format((float) $product->price, 0, ',', '.') }}
                    </p>
                </div>
                @if($type === 'featured')
                    <a href="{{ route('products.show', $product->slug ?? $product->id) }}"
                       class="shrink-0 relative z-20 inline-flex items-center rounded-full bg-indigo-50 px-4 py-2.5 text-sm font-semibold text-indigo-700
                              ring-1 ring-indigo-200 shadow-sm hover:bg-white hover:text-indigo-800 hover:ring-indigo-300
                              transition-transform duration-150 hover:scale-[1.03]">
                        View product
                    </a>
                @else
                    {{-- Nút Add to cart (không bị overlay che nhờ z-20) --}}
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="shrink-0 relative z-20">
                        @csrf
                        <button type="submit" class="inline-flex items-center rounded-full bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white
                                   shadow-md shadow-indigo-500/30 hover:bg-indigo-700 hover:shadow-lg
                                   transition-transform duration-150 hover:scale-[1.03]
                                   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500
                                   focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                            Add to cart
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</article>