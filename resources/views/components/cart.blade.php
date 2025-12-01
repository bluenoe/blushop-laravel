@props([
'product',
'type' => 'grid', // variants: grid, featured
'isWished' => false,
'spotlight' => false,
'imageOnly' => false,
])

@php
$isSpotlight = (bool) $spotlight;
@endphp

<article
    class="group relative z-0 flex flex-col overflow-hidden rounded-3xl border border-beige bg-white shadow-soft
           transition-transform duration-200 hover:-translate-y-1 hover:shadow-lg cursor-pointer transition-colors hover:bg-warm/40 hover:ring-1 hover:ring-ink/10 {{ $isSpotlight ? 'hover:-translate-y-[10px] hover:shadow-2xl hover:shadow-indigo-200/60 ring-1 ring-indigo-50/60' : '' }}"
    x-data="{ pid: {{ (int) $product->id }}, active: {{ $isWished ? 'true' : 'false' }} }"
    x-init="active = $store.wishlist ? $store.wishlist.isFav(pid) : active">

    {{-- Full-card clickable overlay (card body navigates to details) --}}
    <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="absolute inset-0 z-0"
        aria-label="View details of {{ $product->name }}"></a>

    {{-- 🖼️ Image Section --}}
    <div class="relative z-0 flex flex-col h-full pointer-events-none">
        {{-- Top: ảnh full khung + wishlist --}}
        <div class="relative {{ $type === 'featured' ? 'aspect-[4/3]' : 'aspect-[4/5]' }} overflow-hidden bg-warm">
            <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition-transform duration-300
                       group-hover:scale-105">

            <div class="absolute top-3 left-3 z-20 flex flex-col space-y-2">
                @if ($product->is_on_sale)
                <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">On sale</span>
                @endif
                @if ($product->is_bestseller)
                <span
                    class="rounded-full bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-800">Bestseller</span>
                @endif
                @if ($product->is_new)
                <span class="rounded-full bg-beige px-2 py-0.5 text-xs font-medium text-ink">New</span>
                @endif
            </div>

            {{-- Wishlist toggle --}}
            <button type="button" class="group/heart absolute top-4 right-4 z-20 inline-flex h-9 w-9 items-center justify-center rounded-full pointer-events-auto
                           bg-white/90 text-ink shadow-sm ring-1 ring-beige/70
                           transition hover:bg-rose-50 hover:text-rose-500 hover:ring-rose-200 hover:scale-105"
                :class="active ? 'bg-rose-50 text-rose-600 ring-rose-200' : ''" :aria-pressed="active"
                :title="active ? 'Remove from wishlist' : 'Add to wishlist'"
                @click.stop="$store.wishlist.toggle(pid); active = $store.wishlist.isFav(pid)">
                <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5">
                    <!-- Lucide-style precise heart, centered in 24x24 viewBox -->
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                        :fill="active ? 'currentColor' : 'none'" :stroke="active ? 'none' : 'currentColor'"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>

            @if($type === 'featured')
            <span
                class="absolute top-3 left-3 z-20 inline-flex items-center rounded-full bg-indigo-600/90 text-white text-xs font-semibold px-2 py-0.5 shadow">
                Featured
            </span>
            @endif
        </div>

        @if($isSpotlight)
        {{-- Full-card hover reveal for landing spotlight --}}
        <div
            class="pointer-events-none absolute inset-0 z-10 opacity-0 transition duration-100 ease-out group-hover:opacity-100">
            <div class="absolute inset-0 bg-white/70 backdrop-blur-md"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-white/0 via-white/0 to-white/30"></div>
            <div class="relative h-full w-full flex flex-col justify-end p-5 text-slate-900">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-indigo-700">
                    Quick peek
                </p>
                <h3 class="mt-2 text-lg font-semibold leading-tight">
                    {{ $product->name }}
                </h3>
                <p class="mt-2 text-sm text-slate-700 leading-relaxed line-clamp-3">
                    {{ $product->short_description ?? 'Minimal Blu everyday gear for students - simple, durable, easy to
                    mix & match.' }}
                </p>
                <div class="mt-4 flex items-center justify-between text-sm font-semibold text-ink">
                    <span class="text-base">
                        ₫{{ number_format((float) $product->price, 0, ',', '.') }}
                    </span>
                    <span class="inline-flex items-center gap-1 text-indigo-700">
                        View details
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14"></path>
                            <path d="m13 6 6 6-6 6"></path>
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        {{-- Minimal base state: only image + name (hidden when imageOnly) --}}
        @unless($imageOnly)
        <div class="px-5 py-4">
            <h3 class="text-base sm:text-lg font-semibold text-ink line-clamp-2">
                {{ $product->name }}
            </h3>
        </div>
        @endunless
        @else
        {{-- 🧾 Info Section (hidden when imageOnly) --}}
        @unless($imageOnly)
        <div class="px-5 pt-4 pb-5 flex flex-col gap-3 flex-1">
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-ink line-clamp-2">
                    {{ $product->name }}
                </h3>
                @if($product->category && $product->category->name != 'Uncategorized')
                <div class="mt-2 flex flex-wrap gap-2">
                    <span
                        class="inline-flex items-center rounded-full border border-beige bg-warm/70 px-2.5 py-0.5 text-[11px] font-medium uppercase tracking-wide text-ink transition-transform duration-150 hover:-translate-y-[1px] hover:shadow-sm hover:border-indigo-100 hover:bg-white">
                        {{ $product->category->name }}
                    </span>
                    <span
                        class="inline-flex items-center rounded-full border border-beige bg-white px-2.5 py-0.5 text-[11px] font-medium uppercase tracking-wide text-gray-600 transition-transform duration-150 hover:-translate-y-[1px] hover:shadow-sm hover:border-indigo-100 hover:bg-warm/80 hover:text-ink">
                        Blu
                    </span>
                </div>
                @endif
            </div>
            <p class="text-sm text-gray-600 leading-relaxed line-clamp-2">
                {{ $product->short_description ?? 'Minimal Blu everyday gear for students — simple, durable, easy to mix
                & match.' }}
            </p>
            <div class="mt-1 flex items-end justify-between gap-3">
                <div>
                    <span class="block text-[11px] font-semibold uppercase tracking-wide text-gray-500">Price</span>
                    <p class="text-xl font-semibold text-ink">₫{{ number_format((float) $product->price, 0, ',', '.') }}
                    </p>
                </div>
                @if($type === 'featured')
                <a href="{{ route('products.show', $product->slug ?? $product->id) }}"
                    class="shrink-0 relative z-20 inline-flex items-center rounded-full bg-indigo-50 px-4 py-2.5 text-sm font-semibold text-indigo-700 ring-1 ring-indigo-200 shadow-sm hover:bg-white hover:text-indigo-800 hover:ring-indigo-300 transition-transform duration-150 hover:scale-[1.03] pointer-events-auto">View
                    product</a>
                @else
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="shrink-0 relative z-30 pointer-events-auto"
                    x-data="{loading:false,ok:false}" @click.stop @submit.prevent="
                    loading = true;
                    fetch($el.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-Token': document.querySelector('meta[name=csrf-token]')?.content || ''
                        },
                        body: JSON.stringify({ quantity: 1 })
                    }).then(r => r.ok ? r.json() : Promise.reject(r)).then(data => {
                        if (data && data.success) { 
                            if (window.Alpine && Alpine.store('cart')) {
                                Alpine.store('cart').set(data.cart_count);
                                ok = true; 
                                setTimeout(() => ok = false, 2000);
                            }
                        }
                    }).catch(() => {}).finally(() => { loading = false; });
                ">
                    @csrf
                    <button type="submit" :class="loading ? 'opacity-70 cursor-wait' : ''"
                        class="inline-flex items-center rounded-full bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-500/30 hover:bg-indigo-700 hover:shadow-lg transition-transform duration-150 hover:scale-[1.03] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 focus-visible:ring-offset-white">Add
                        to cart</button>
                    <span x-show="ok" x-transition class="ml-2 text-xs text-green-600 font-medium">Added</span>
                </form>
                @endif
            </div>
        </div>
        @endunless
        @endif
    </div>
</article>
