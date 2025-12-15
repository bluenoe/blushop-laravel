@props(['product'])

@php
// Xử lý ảnh: Ưu tiên ảnh thật, nếu không có thì dùng ảnh mẫu Unsplash
$fallbackImage = 'https://images.unsplash.com/photo-1578768079052-aa76e52ff62e?q=80&w=800&auto=format&fit=crop';

// Kiểm tra nếu product->image là đường dẫn full (mockup) hay đường dẫn file (storage)
if (filter_var($product->img ?? '', FILTER_VALIDATE_URL)) {
$image = $product->img; // Dùng cho data giả lập (mockup array)
} else {
$image = $product->image ? Storage::url('products/'.$product->image) : $fallbackImage;
}

// Xử lý giá tiền
$price = is_numeric($product->price)
? number_format($product->price, 0, ',', '.')
: $product->price;

// Xử lý tên Category (An toàn null)
$categoryName = $product->cat ?? ($product->category->name ?? 'Essential');
@endphp

<div class="group relative cursor-pointer">
    {{-- Image Container --}}
    <div class="aspect-[3/4] w-full overflow-hidden bg-neutral-100 relative mb-4">
        <img src="{{ $image }}" alt="{{ $product->name }}" loading="lazy"
            class="w-full h-full object-cover transition duration-[1.2s] ease-out group-hover:scale-105 group-hover:grayscale-[20%]">

        {{-- Badge (Optional) --}}
        @if(isset($product->is_new) && $product->is_new)
        <span
            class="absolute top-2 left-2 bg-white/90 backdrop-blur text-[10px] font-bold uppercase px-2 py-1">New</span>
        @endif

        {{-- Quick View Button Slide Up --}}
        <div
            class="absolute bottom-0 left-0 w-full bg-white/95 backdrop-blur text-black text-[10px] font-bold uppercase py-4 text-center translate-y-full group-hover:translate-y-0 transition-transform duration-300 border-t border-neutral-100 z-20">
            Quick View
        </div>

        {{-- Full Link --}}
        <a href="{{ route('products.show', $product->id ?? 1) }}" class="absolute inset-0 z-10"></a>
    </div>

    {{-- Info --}}
    <div class="flex justify-between items-start space-x-4">
        <div>
            <h3
                class="text-sm font-bold text-neutral-900 leading-tight group-hover:underline underline-offset-4 decoration-1">
                <a href="{{ route('products.show', $product->id ?? 1) }}">{{ $product->name }}</a>
            </h3>
            <p class="text-[10px] text-neutral-500 mt-1 uppercase tracking-wider">{{ $categoryName }}</p>
        </div>
        <span class="text-sm font-medium text-neutral-900 whitespace-nowrap">{{ $price }} ₫</span>
    </div>
</div>