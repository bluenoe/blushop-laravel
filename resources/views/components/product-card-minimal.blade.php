@props(['product'])

@php
// 1. Xử lý ảnh: Fallback an toàn
$fallbackImage = 'https://images.unsplash.com/photo-1578768079052-aa76e52ff62e?q=80&w=800&auto=format&fit=crop';

if (filter_var($product->img ?? '', FILTER_VALIDATE_URL)) {
$image = $product->img;
} else {
$image = $product->image ? Storage::url('products/'.$product->image) : $fallbackImage;
}

// 2. Xử lý Giá tiền - Use base_price as primary
$basePrice = $product->base_price ?? $product->price ?? 0;
$originalPrice = $product->original_price ?? null;
$isOnSale = $product->is_on_sale ?? false;

// Format prices in VND
$basePriceFormatted = number_format($basePrice, 0, ',', '.') . '₫';
$originalPriceFormatted = $originalPrice ? number_format($originalPrice, 0, ',', '.') . '₫' : null;

// Check if we should show sale pricing (on sale AND original > base)
$showSalePrice = $isOnSale && $originalPrice && $originalPrice > $basePrice;

// 3. Category
$categoryName = $product->cat ?? ($product->category->name ?? ($product->category ?? 'Essential'));
if (is_string($categoryName)) {
$categoryName = ucfirst($categoryName);
}
@endphp

<div class="group relative cursor-pointer flex flex-col h-full">
    {{-- IMAGE CONTAINER --}}
    <div class="aspect-[3/4] w-full overflow-hidden bg-neutral-100 relative mb-4">
        <img src="{{ $image }}" alt="{{ $product->name }}" loading="lazy"
            class="w-full h-full object-cover transition duration-[1.2s] ease-out group-hover:scale-105 group-hover:grayscale-[10%]">

        {{-- Badge: New --}}
        @if(isset($product->is_new) && $product->is_new)
        <span
            class="absolute top-2 left-2 bg-white/90 backdrop-blur text-[10px] font-bold uppercase px-2 py-1 z-20 tracking-wider">New</span>
        @endif

        {{-- Badge: Sale (Minimalist High-End Style) --}}
        @if($isOnSale)
        <span
            class="absolute top-2 right-2 bg-white text-red-600 text-[10px] font-bold uppercase tracking-wider px-2 py-1 shadow-sm z-20">Sale</span>
        @endif

        {{-- Quick View - Slide Up Effect --}}
        <div
            class="absolute bottom-0 left-0 w-full bg-white/95 backdrop-blur text-neutral-900 text-[10px] font-bold uppercase py-4 text-center translate-y-full group-hover:translate-y-0 transition-transform duration-300 border-t border-neutral-100 z-20">
            Quick View
        </div>

        {{-- Link Full Card --}}
        <a href="{{ route('products.show', $product->id ?? 1) }}" class="absolute inset-0 z-10"></a>
    </div>

    {{-- INFO CONTAINER --}}
    <div class="flex justify-between items-start mt-auto">
        <div class="pr-4">
            {{-- PRODUCT NAME WITH ANIMATED UNDERLINE --}}
            <h3 class="text-sm font-bold text-neutral-900 leading-tight mb-1">
                <a href="{{ route('products.show', $product->id ?? 1) }}"
                    class="relative inline-block overflow-hidden pb-0.5">
                    {{ $product->name }}
                    {{-- The Magic Line: Chạy từ trái qua phải khi hover vào group cha --}}
                    <span
                        class="absolute bottom-0 left-0 h-[1px] w-0 bg-neutral-900 transition-all duration-300 ease-out group-hover:w-full"></span>
                </a>
            </h3>
            <p class="text-[10px] text-neutral-400 uppercase tracking-widest">{{ $categoryName }}</p>
        </div>

        {{-- PRICE SECTION: Sale vs Normal (Minimalist Style) --}}
        <div class="flex flex-col items-end">
            @if($showSalePrice)
            {{-- Sale Price (Current - Dark, readable) --}}
            <span class="text-sm font-medium text-neutral-900 whitespace-nowrap tracking-tight">
                {{ $basePriceFormatted }}
            </span>
            {{-- Original Price (Struck-through, muted) --}}
            <span class="text-xs text-neutral-400 line-through decoration-neutral-400 whitespace-nowrap">
                {{ $originalPriceFormatted }}
            </span>
            @else
            {{-- Normal Price --}}
            <span class="text-sm font-medium text-neutral-900 whitespace-nowrap tracking-tight">
                {{ $basePriceFormatted }}
            </span>
            @endif
        </div>
    </div>
</div>