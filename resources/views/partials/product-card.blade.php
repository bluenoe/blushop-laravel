<div class="group relative flex flex-col">
    {{-- Image Wrapper --}}
    <div class="relative aspect-[3/4] overflow-hidden bg-neutral-100 mb-4 cursor-pointer">
        <a href="{{ route('products.show', $product) }}" class="block w-full h-full">
            <img src="{{ $product->image_url }}"
                alt="{{ ($product->category?->name ?? 'Product') . ' ' . $product->name }}" loading="lazy"
                class="w-full h-full object-cover transition duration-700 ease-out group-hover:scale-105 filter grayscale-[10%] group-hover:grayscale-0">
        </a>

        {{-- Badges --}}
        <div class="absolute top-2 left-2 flex flex-col gap-1">
            @if($product->is_new)
            <span class="bg-white/90 backdrop-blur text-black text-[10px] font-bold uppercase px-2 py-1">New</span>
            @endif
            @if($product->is_on_sale)
            <span class="bg-black text-white text-[10px] font-bold uppercase px-2 py-1">Sale</span>
            @endif
        </div>

        {{-- Quick Add Overlay (AJAX Enabled) --}}
        <div
            class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition duration-300 ease-out hidden lg:block">
            <div x-data>
                <button type="button" @click="
    $el.innerHTML = 'Adding...';
    fetch('{{ route('cart.add', $product->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(res => res.json())
    .then(data => {
        $el.innerHTML = 'Added';
        $dispatch('notify', { message: data.message }); // Bắn thông báo
        // THÊM DÒNG NÀY ĐỂ UPDATE HEADER:
        // Alpine.store('cart').set(data.cart_count);
        window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.cart_count } }));
        setTimeout(() => $el.innerHTML = 'Quick Add +', 2000);
    })
    .catch(err => console.error(err));
" class="w-full py-3 bg-white/90 backdrop-blur text-black text-[10px] font-bold uppercase tracking-widest hover:bg-black hover:text-white transition">
                    Quick Add +
                </button>
            </div>
        </div>
    </div>

    {{-- Product Info --}}
    <div class="flex justify-between items-start gap-2">
        <div>
            <h3 class="text-sm font-bold text-neutral-900 leading-tight">
                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
            </h3>
            @if($product->category)
            <p class="text-[10px] text-neutral-400 uppercase tracking-wider mt-1">
                {{ ucfirst($product->category->name) }}
            </p>
            @endif
        </div>
        {{-- Price Section: Sale vs Normal --}}
        <div class="text-right">
            @if($product->is_on_sale && $product->original_price > $product->base_price)
            {{-- ON SALE: Show both prices --}}
            <div class="flex flex-col items-end gap-0.5">
                <span class="text-sm font-medium text-neutral-900">
                    {{ number_format($product->base_price ?? 0, 0, ',', '.') }}₫
                </span>
                <span class="text-xs text-neutral-400 line-through decoration-neutral-400">
                    {{ number_format($product->original_price, 0, ',', '.') }}₫
                </span>
            </div>
            @else
            {{-- NORMAL: Single price --}}
            <span class="text-sm font-medium text-neutral-900">
                {{ number_format($product->base_price ?? $product->variants->first()?->price ?? 0, 0,
                ',', '.') }}₫
            </span>
            @endif
        </div>
    </div>
</div>