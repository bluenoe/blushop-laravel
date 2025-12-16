{{--
═══════════════════════════════════════════════════════════════
BluShop Product Detail v3 - Optimized Flow
Luồng: Product → Gallery → Variants → Complete Look → Reviews → Curated
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    @push('head')
    <link rel="preload" as="image" href="{{ Storage::url('products/' . $product->image) }}" fetchpriority="high">
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Tối ưu chuyển động */
        [x-cloak] {
            display: none !important;
        }
    </style>
    @endpush

    <main class="bg-white text-neutral-900 selection:bg-neutral-900 selection:text-white">

        {{-- 1. BREADCRUMBS --}}
        <div class="max-w-[1400px] mx-auto px-6 pt-6 pb-2">
            <nav class="flex text-xs uppercase tracking-widest text-neutral-500">
                <a href="{{ route('home') }}" class="hover:text-black transition">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.index') }}" class="hover:text-black transition">Shop</a>
                @if($product->category)
                <span class="mx-2">/</span>
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                    class="hover:text-black transition">{{ $product->category->name }}</a>
                @endif
                <span class="mx-2">/</span>
                <span class="text-black border-b border-black">{{ $product->name }}</span>
            </nav>
        </div>

        {{-- 2. MAIN PRODUCT SECTION --}}
        <section class="max-w-[1400px] mx-auto px-0 sm:px-6 lg:px-8 py-0 lg:py-12">
            @php
            // 1. Logic tìm ảnh mặc định thông minh hơn
            // Ưu tiên 1: Lấy ảnh có cờ is_main = 1
            $defImgObj = $product->images->firstWhere('is_main', 1);

            // Ưu tiên 2: Nếu không có is_main, lấy đại cái ảnh đầu tiên trong list
            if (!$defImgObj) {
            $defImgObj = $product->images->first();
            }

            // 3. Tạo đường dẫn ảnh (Handle trường hợp null để không bị lỗi trắng trang)
            $defaultImage = $defImgObj
            ? Storage::url('products/' . $defImgObj->image_path)
            : 'https://placehold.co/600x800?text=No+Image'; // Fallback nếu SP không có ảnh nào

            // 4. Lấy luôn cái màu của ảnh đó để set mặc định
            $defaultColor = $defImgObj ? $defImgObj->color : null;
            @endphp

            {{-- KHỞI TẠO ALPINE VỚI DỮ LIỆU MẶC ĐỊNH ĐÃ TÍNH TOÁN --}}
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-start" x-data="{
        // Gán màu mặc định ngay khi vào trang (thay vì null)
        size: null,
        color: '{{ $defaultColor }}', 
        qty: 1,
        loading: false,
        added: false,
        
        // Ảnh đang hiển thị
        currentImage: '{{ $defaultImage }}',

        // Map dữ liệu PHP sang JS
        imageMap: {{ json_encode($variantImages) }},

        selectColor(selectedColor) {
            this.color = selectedColor;
            if (this.imageMap[selectedColor]) {
                this.currentImage = this.imageMap[selectedColor];
            }
        }
    }">

                {{-- LEFT: GALLERY (SINGLE HERO IMAGE - RESPONSIVE) --}}
                <div class="lg:col-span-7 col-span-12 w-full mb-8 lg:mb-0">
                    <div
                        class="relative w-full aspect-[3/4] lg:aspect-[4/5] bg-neutral-100 overflow-hidden group cursor-zoom-in">
                        {{-- Main Image --}}
                        <img :src="currentImage" alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110"
                            loading="eager" fetchpriority="high">

                        {{-- Badge 'View Detail' (Desktop only) --}}
                        <div
                            class="absolute bottom-6 left-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden lg:block">
                            <span
                                class="bg-white/90 backdrop-blur px-4 py-2 text-[10px] uppercase tracking-widest font-bold shadow-sm">
                                View Detail
                            </span>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: PRODUCT INFO (Sticky) --}}
                <div class="lg:col-span-5 col-span-12 px-6 lg:px-0 mt-8 lg:mt-0 lg:sticky lg:top-24">

                    {{-- Header --}}
                    <div class="mb-8 border-b border-neutral-200 pb-6">
                        <div class="flex justify-between items-start">
                            <h1
                                class="text-3xl md:text-4xl font-bold tracking-tighter leading-tight text-neutral-900 mb-2">
                                {{ $product->name }}
                            </h1>

                            {{-- Wishlist Button --}}
                            <div x-data="{ id: {{ $product->id }} }">
                                <button @click="$store.wishlist.toggle(id)"
                                    class="group p-2 -mr-2 rounded-full hover:bg-neutral-100 transition-colors duration-300">
                                    <svg class="w-6 h-6 transition-all duration-300"
                                        :class="$store.wishlist.isFav(id) 
                                            ? 'text-black fill-current transform scale-110' 
                                            : 'text-neutral-400 fill-none group-hover:text-black group-hover:scale-105'" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 mt-2">
                            <span class="text-xl font-medium text-neutral-900">
                                ₫{{ number_format((float)$product->price, 0, ',', '.') }}
                            </span>
                            @if($product->is_on_sale)
                            <span class="bg-black text-white text-[10px] uppercase font-bold px-2 py-1">Sale</span>
                            @endif
                        </div>
                    </div>

                    {{-- Add to Cart Form --}}
                    <form method="POST" action="{{ route('cart.add', $product->id) }}" @submit.prevent="
                        if(!size) { alert('Please select a size'); return; }
                        loading = true;
                        fetch($el.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-Token': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({ quantity: qty, size: size, color: color })
                        }).then(r => r.ok ? r.json() : Promise.reject(r))
                        .then(data => {
        loading = false;

    if (data && data.success) { 
        // Bắn pháo hiệu cho Header biết
        // Chú ý: data.cart_count phải khớp với cái log ở trên
        window.dispatchEvent(new CustomEvent('cart-updated', {
            detail: { count: data.cart_count }
        }));
        
        // Hiệu ứng nút bấm (Giữ nguyên)
        added = true; 
        setTimeout(() => added = false, 3000);
    }
});
                    ">
                        @csrf

                        {{-- Color Selection --}}
                        <div class="mb-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-xs font-bold uppercase tracking-widest text-neutral-500">Color</span>
                                <span class="text-xs text-neutral-900" x-text="color ? color : 'Select'"></span>
                            </div>

                            {{-- Hiển thị danh sách màu CÓ THẬT từ Database --}}
                            @if(count($availableColors) > 0)
                            <div class="flex gap-3">
                                @foreach($availableColors as $c)
                                {{-- Logic hiển thị màu Background --}}
                                @php
                                $bgClass = match(strtolower($c)) {
                                // Basic Monochromes
                                'black' => 'bg-[#171717]', // Neutral-900 (Đen lì)
                                'white' => 'bg-[#FFFFFF] border border-[#E5E5E5]', // Trắng tinh khôi
                                'grey', 'gray', 'charcoal' => 'bg-[#52525B]', // Zinc-600 (Xám chuột)

                                // Minimalist Earth Tones (Màu đất dịu mắt)
                                'beige', 'cream' => 'bg-[#E8E0D5]', // Beige (Màu kem)
                                'brown', 'khaki' => 'bg-[#5D4037]', // Nâu đất
                                'olive' => 'bg-[#556B2F]', // Xanh rêu trầm
                                'taupe' => 'bg-[#8B8589]', // Màu nâu xám

                                // Muted Colors (Màu trầm sang trọng)
                                'navy' => 'bg-[#1F2937]', // Xanh than (Gray-800)
                                'blue' => 'bg-[#64748B]', // Slate-500 (Xanh ghi, không phải xanh dương chói)
                                'red', 'burgundy' => 'bg-[#7F1D1D]', // Red-900 (Đỏ rượu vang)
                                'green' => 'bg-[#3F6212]', // Green-800 (Xanh lá già)
                                'yellow', 'mustard' => 'bg-[#CA8A04]', // Yellow-700 (Vàng mù tạt)
                                'pink', 'rose' => 'bg-[#FB7185]', // Rose-400 (Hồng đất)
                                'purple' => 'bg-[#581C87]', // Tím than

                                // Fallback (Màu mặc định nếu lạ)
                                default => 'bg-[#D4D4D4]' // Xám nhạt
                                };
                                @endphp

                                {{-- Gọi hàm selectColor khi click --}}
                                <button type="button" @click="selectColor('{{ $c }}')"
                                    class="w-8 h-8 rounded-full focus:outline-none ring-1 ring-offset-2 transition-all duration-200"
                                    :class="color === '{{ $c }}' ? 'ring-black scale-110' : 'ring-transparent hover:ring-gray-300 hover:scale-105'">

                                    {{-- Nếu không có class màu cụ thể thì dùng style inline --}}
                                    <div class="{{ $bgClass }} w-full h-full rounded-full" @if($bgClass=='bg-gray-200' )
                                        style="background-color: {{ $c }}" @endif>
                                    </div>
                                </button>
                                @endforeach
                            </div>
                            @else
                            <p class="text-sm text-neutral-400 italic">One color only</p>
                            @endif
                        </div>

                        {{-- Size Selection --}}
                        <div class="mb-8">
                            <div class="flex justify-between mb-2">
                                <span class="text-xs font-bold uppercase tracking-widest text-neutral-500">Size</span>
                                <button type="button" class="text-xs underline text-neutral-400 hover:text-black">Size
                                    Guide</button>
                            </div>
                            <div class="grid grid-cols-4 gap-2">
                                <template x-for="s in ['S','M','L','XL']" :key="s">
                                    <button type="button" @click="size = s"
                                        class="py-3 border text-sm font-medium transition-all duration-200"
                                        :class="size === s 
                                            ? 'border-black bg-black text-white' 
                                            : 'border-neutral-200 text-neutral-600 hover:border-black hover:text-black'">
                                        <span x-text="s"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="space-y-3">
                            <button type="submit" :disabled="loading"
                                class="w-full py-4 bg-neutral-900 text-white font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition disabled:opacity-50 disabled:cursor-not-allowed relative">
                                <span x-show="!loading && !added">Add to Bag</span>
                                <span x-show="loading" class="animate-pulse">Processing...</span>
                                <span x-show="added" class="flex items-center justify-center gap-2">
                                    Added
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                            </button>
                            <p class="text-center text-[10px] text-neutral-400 uppercase tracking-widest">
                                Free shipping on orders over 500k
                            </p>
                        </div>
                    </form>

                    {{-- Accordion Sections (CSS Grid Animation - 300ms) --}}
                    <div class="mt-12 border-t border-neutral-200" x-data="{ activeTab: 'details' }">

                        {{-- Details --}}
                        <div class="border-b border-neutral-200">
                            <button @click="activeTab = activeTab === 'details' ? null : 'details'"
                                class="w-full py-5 flex justify-between items-center text-left group select-none">
                                <span
                                    class="text-xs font-bold uppercase tracking-widest group-hover:text-neutral-600 transition">
                                    Details & Composition
                                </span>
                                <span
                                    class="text-xl leading-none transition-transform duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]"
                                    :class="activeTab === 'details' ? 'rotate-45' : 'rotate-0'">+</span>
                            </button>
                            <div class="grid transition-[grid-template-rows] duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]"
                                :class="activeTab === 'details' ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                                <div class="overflow-hidden">
                                    <div class="pb-6 text-sm text-neutral-600 font-light leading-relaxed">
                                        <p class="mb-5">{{ $product->description ?? 'Timeless design meets modern
                                            functionality.' }}</p>
                                        @if(!empty($product->specifications))
                                        <dl class="space-y-2">
                                            @foreach($product->specifications as $key => $value)
                                            <div
                                                class="flex justify-between py-2 border-b border-dashed border-neutral-100 last:border-0">
                                                <dt class="text-neutral-900 font-medium">{{ $key }}</dt>
                                                <dd class="text-neutral-500">{{ $value }}</dd>
                                            </div>
                                            @endforeach
                                        </dl>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Care Guide --}}
                        <div class="border-b border-neutral-200">
                            <button @click="activeTab = activeTab === 'care' ? null : 'care'"
                                class="w-full py-5 flex justify-between items-center text-left group select-none">
                                <span
                                    class="text-xs font-bold uppercase tracking-widest group-hover:text-neutral-600 transition">
                                    Care Guide
                                </span>
                                <span
                                    class="text-xl leading-none transition-transform duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]"
                                    :class="activeTab === 'care' ? 'rotate-45' : ''">+</span>
                            </button>
                            <div class="grid transition-[grid-template-rows] duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]"
                                :class="activeTab === 'care' ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                                <div class="overflow-hidden">
                                    <div class="pb-6 text-sm text-neutral-600 font-light leading-relaxed space-y-2">
                                        @if($product->care_guide)
                                        {!! nl2br(e($product->care_guide)) !!}
                                        @else
                                        <p>Do not wash. Do not bleach. Do not iron. Do not dry clean.</p>
                                        <p>Clean with a soft dry cloth. Keep away from direct heat.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Shipping --}}
                        <div class="border-b border-neutral-200">
                            <button @click="activeTab = activeTab === 'ship' ? null : 'ship'"
                                class="w-full py-5 flex justify-between items-center text-left group select-none">
                                <span
                                    class="text-xs font-bold uppercase tracking-widest group-hover:text-neutral-600 transition">
                                    Shipping & Returns
                                </span>
                                <span
                                    class="text-xl leading-none transition-transform duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]"
                                    :class="activeTab === 'ship' ? 'rotate-45' : ''">+</span>
                            </button>
                            <div class="grid transition-[grid-template-rows] duration-300 ease-[cubic-bezier(0.4,0,0.2,1)]"
                                :class="activeTab === 'ship' ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'">
                                <div class="overflow-hidden">
                                    <div class="pb-6 text-sm text-neutral-600 font-light">
                                        Free standard shipping on orders over 500k. Returns accepted within 30 days.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. COMPLETE THE LOOK (Smart Logic: Apparel + Same Gender) --}}
        @if(isset($completeLook) && $completeLook->count() > 0)
        <section class="max-w-[1400px] mx-auto px-6 py-20 border-t border-neutral-100">
            <div class="md:flex md:items-end md:justify-between mb-8">
                <h2 class="text-2xl font-bold tracking-tight text-neutral-900">Complete The Look</h2>
                <a href="#"
                    class="hidden md:block text-xs border-b border-black pb-0.5 hover:text-neutral-600 transition">
                    Shop the full set
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-y-10 gap-x-6">
                @foreach($completeLook as $lookItem)
                <div class="group relative">
                    <div class="aspect-[3/4] overflow-hidden bg-neutral-100 mb-4">
                        <img src="{{ Storage::url('products/' . $lookItem->image) }}"
                            class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                    </div>
                    <h3 class="text-sm font-medium">
                        <a href="{{ route('products.show', $lookItem->id) }}">
                            <span class="absolute inset-0"></span>
                            {{ $lookItem->name }}
                        </a>
                    </h3>
                    <p class="text-sm text-neutral-500 mt-1">₫{{ number_format($lookItem->price, 0, ',', '.') }}</p>

                    <button
                        class="absolute bottom-20 right-4 w-8 h-8 bg-white rounded-full shadow-md flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity translate-y-2 group-hover:translate-y-0 duration-300 z-10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- 4. REVIEWS SECTION (AJAX Enabled) --}}
        <section class="border-t border-neutral-100 py-16 lg:py-24 bg-neutral-50/30" id="reviews">
            <div class="max-w-[1400px] mx-auto px-6 grid lg:grid-cols-12 gap-12">
                {{-- LEFT COLUMN: Summary & Form --}}
                <div class="lg:col-span-4">
                    <h2 class="text-2xl font-bold mb-4 tracking-tight">Reviews</h2>
                    <div class="flex items-baseline gap-4 mb-6">
                        <span class="text-5xl font-bold tracking-tighter">{{ number_format($product->avg_rating, 1)
                            }}</span>
                        <div class="flex flex-col">
                            <div class="flex text-black text-xs">
                                @for($i=1; $i<=5; $i++) <svg
                                    class="w-4 h-4 {{ $i <= round($product->avg_rating) ? 'fill-black' : 'text-neutral-300 fill-none' }}"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    @endfor
                            </div>
                            <span class="text-xs text-neutral-500 mt-1 font-medium">{{ $product->reviews_count }}
                                reviews</span>
                        </div>
                    </div>

                    {{-- Minimalist Validation --}}
                    <div x-data="{ 
    open: false, 
    submitting: false, 
    success: false,
    rating: 5, 
    hoverRating: 0,
    fit: 3,
    errors: {}, // 1. Biến chứa lỗi từ Server
    imagePreview: null,

    // Hàm xử lý file ảnh review
    handleImage(e) {
        const file = e.target.files[0];
        if(file) {
            this.imagePreview = URL.createObjectURL(file);
        }
    },

    submitReview(e) {
        this.submitting = true;
        this.errors = {}; // Reset lỗi cũ
        const formData = new FormData(e.target);

        fetch(e.target.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json' // Bắt buộc để Laravel trả về JSON
            },
            body: formData
        }).then(response => {
            // 2. Nếu lỗi Validate (422), ném ra catch
            if (response.status === 422) {
                return response.json().then(data => {
                    this.errors = data.errors;
                    throw new Error('Validation Failed');
                });
            }
            if (!response.ok) throw response;
            return response.json();
        }).then(data => {
            // 3. Thành công
            this.success = true;
            this.submitting = false;
            this.open = false;
            setTimeout(() => { window.location.reload(); }, 1500);
        }).catch(err => {
            this.submitting = false;
            // Nếu không phải lỗi validate thì mới alert
            if (!this.errors || Object.keys(this.errors).length === 0) {
                console.error(err);
                alert('Something went wrong. Please try again.');
            }
        });
    }
}">
                        @auth
                        <button @click="open = !open" x-show="!success"
                            class="w-full py-4 border border-black text-black text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition duration-300">
                            <span x-text="open ? 'Close' : 'Write a Review'"></span>
                        </button>

                        {{-- Thông báo thành công --}}
                        <div x-show="success" x-transition
                            class="p-4 bg-black text-white text-center text-sm mb-4 flex flex-col items-center justify-center">
                            <svg class="w-6 h-6 mb-2 text-green-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <p class="font-bold uppercase tracking-widest text-xs">Review Submitted</p>
                        </div>

                        {{-- Form Area --}}
                        <div x-show="open && !success" x-collapse class="mt-8">
                            {{-- Thêm novalidate để tắt popup trình duyệt --}}
                            <form action="{{ route('reviews.store', $product->id) }}" method="POST"
                                enctype="multipart/form-data" @submit.prevent="submitReview" novalidate>

                                {{-- 1. RATING --}}
                                <div class="mb-8">
                                    <label
                                        class="block text-[10px] font-bold uppercase tracking-widest mb-3 transition-colors duration-300"
                                        :class="errors.rating ? 'text-red-500 animate-pulse' : 'text-neutral-500'">
                                        Rating <span x-show="errors.rating" x-text="'(* Required)'"
                                            class="normal-case font-medium"></span>
                                    </label>
                                    <div class="flex gap-2 cursor-pointer" @mouseleave="hoverRating = 0">
                                        <template x-for="i in 5">
                                            <svg @click="rating = i" @mouseover="hoverRating = i"
                                                class="w-8 h-8 transition-all duration-200 transform hover:scale-110"
                                                :class="(hoverRating || rating) >= i ? 'fill-black text-black' : 'text-neutral-200 fill-none'"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        </template>
                                    </div>
                                    <input type="hidden" name="rating" :value="rating">
                                    <p x-show="errors.rating" x-text="errors.rating[0]"
                                        class="mt-2 text-[10px] text-red-500 font-bold uppercase tracking-wide"></p>
                                </div>

                                {{-- 2. FIT RATING (Slider) --}}
                                <div class="mb-8">
                                    <label
                                        class="block text-[10px] font-bold uppercase tracking-widest mb-4 transition-colors duration-300"
                                        :class="errors.fit_rating ? 'text-red-500 animate-pulse' : 'text-neutral-500'">
                                        How's the fit?
                                    </label>
                                    <div class="relative pt-1">
                                        <input type="range" name="fit_rating" min="1" max="5" step="1" x-model="fit"
                                            class="w-full h-1 bg-neutral-200 rounded-lg appearance-none cursor-pointer accent-black focus:outline-none">
                                        <div
                                            class="flex justify-between text-[9px] text-neutral-400 uppercase mt-3 font-bold tracking-wider">
                                            <span :class="fit == 1 ? 'text-black' : ''">Tight</span>
                                            <span :class="fit == 3 ? 'text-black' : ''">True to Size</span>
                                            <span :class="fit == 5 ? 'text-black' : ''">Loose</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- 3. REVIEW CONTENT (Floating Label - Minimalist Style) --}}
                                <div class="relative z-0 w-full mb-8 group">
                                    <textarea name="content" id="content" rows="4" placeholder=" "
                                        class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer resize-none transition-colors duration-300"
                                        :class="errors.content 
                        ? 'border-red-500 text-red-900 focus:border-red-500 placeholder-red-300' 
                        : 'border-neutral-300 text-neutral-900 focus:border-black'"></textarea>

                                    {{-- Label bay lên --}}
                                    <label for="content"
                                        class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest"
                                        :class="errors.content ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black'">
                                        Your Review
                                    </label>

                                    {{-- Lỗi hiển thị bên dưới --}}
                                    <p x-show="errors.content" x-text="errors.content[0]"
                                        class="mt-1 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
                                    </p>
                                </div>

                                {{-- 4. IMAGE UPLOAD (Custom Minimalist Button) --}}
                                <div class="mb-8">
                                    <label
                                        class="block text-[10px] font-bold uppercase tracking-widest mb-3 text-neutral-500">
                                        Add Photo (Optional)
                                    </label>

                                    <div class="flex items-center gap-4">
                                        {{-- Nút upload giả --}}
                                        <label
                                            class="cursor-pointer group flex items-center gap-2 px-4 py-3 border border-neutral-300 hover:border-black transition duration-300">
                                            <svg class="w-4 h-4 text-neutral-500 group-hover:text-black" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span
                                                class="text-[10px] font-bold uppercase tracking-wider text-neutral-600 group-hover:text-black">Choose
                                                File</span>
                                            <input type="file" name="image" accept="image/*" class="hidden"
                                                @change="handleImage">
                                        </label>

                                        {{-- Preview Ảnh --}}
                                        <template x-if="imagePreview">
                                            <div class="relative w-12 h-12 border border-neutral-200 overflow-hidden">
                                                <img :src="imagePreview" class="w-full h-full object-cover">
                                                <button type="button"
                                                    @click="imagePreview = null; $el.closest('form').querySelector('input[type=file]').value = ''"
                                                    class="absolute top-0 right-0 bg-black text-white w-4 h-4 flex items-center justify-center text-[10px] hover:bg-red-600 transition">&times;</button>
                                            </div>
                                        </template>
                                    </div>
                                    <p x-show="errors.image" x-text="errors.image[0]"
                                        class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wide"></p>
                                </div>

                                <button type="submit" :disabled="submitting"
                                    class="w-full py-4 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span x-text="submitting ? 'Submitting...' : 'Post Review'"></span>
                                </button>
                            </form>
                        </div>
                        @else
                        <div class="bg-neutral-50 p-8 text-center border border-neutral-100">
                            <p class="text-xs text-neutral-500 mb-4 font-light">Please login to share your thoughts.</p>
                            <a href="{{ route('login') }}"
                                class="inline-block border-b border-black text-xs font-bold uppercase tracking-widest pb-0.5 hover:text-neutral-600 hover:border-neutral-600 transition">
                                Login / Register
                            </a>
                        </div>
                        @endauth
                    </div>
                </div>

                {{-- RIGHT COLUMN: Reviews List --}}
                <div class="lg:col-span-8 space-y-10">
                    @forelse($reviews as $review)
                    <div class="border-b border-neutral-200 pb-8 last:border-0 last:pb-0">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-neutral-100 flex items-center justify-center text-xs font-bold text-neutral-900 uppercase tracking-widest border border-neutral-200">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-neutral-900">{{ $review->user->name }}</h4>
                                    <span class="text-[10px] text-neutral-400 uppercase tracking-wider font-medium">{{
                                        $review->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <div class="flex gap-0.5">
                                @for($i=1; $i<=5; $i++) <svg
                                    class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-black' : 'text-neutral-200 fill-none' }}"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                    @endfor
                            </div>
                        </div>
                        <div class="pl-14">
                            @php
                            $fitLabel = match($review->fit_rating) {
                            1 => 'Runs Small', 2 => 'Slightly Small', 3 => 'True to Size', 4 => 'Slightly Large', 5 =>
                            'Runs Large', default => 'True to Size'
                            };
                            @endphp
                            <div class="mb-3">
                                <span
                                    class="inline-block text-[9px] font-bold uppercase tracking-widest border border-neutral-200 px-2 py-1 bg-white text-neutral-600">
                                    Fit: {{ $fitLabel }}
                                </span>
                            </div>
                            <p class="text-sm text-neutral-700 leading-relaxed font-light mb-4">
                                {!! nl2br(e($review->content)) !!}
                            </p>
                            @if($review->image)
                            <div class="mt-4">
                                <img src="{{ Storage::url($review->image) }}"
                                    class="w-24 h-24 object-cover cursor-zoom-in grayscale hover:grayscale-0 transition duration-500 border border-neutral-100"
                                    onclick="window.open(this.src)">
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="py-16 text-center border border-dashed border-neutral-200 rounded-lg">
                        <p class="text-neutral-400 font-light text-sm italic">No reviews yet.</p>
                    </div>
                    @endforelse
                    <div class="mt-8">
                        {{ $reviews->fragment('reviews')->links() }}
                    </div>
                </div>
            </div>
        </section>

        {{-- 5. CURATED FOR YOU (Apparel + Random) --}}
        @if(isset($curated) && $curated->count() > 0)
        <section class="border-t border-black py-20 lg:py-24 bg-white">
            <div class="max-w-[1400px] mx-auto px-6">
                {{-- Typography Heading --}}
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                    <h2 class="text-4xl md:text-6xl font-light tracking-tighter leading-none text-neutral-900">
                        Curated <br> <span class="font-serif italic text-neutral-400 pl-16">for you.</span>
                    </h2>
                    <a href="{{ route('products.index') }}"
                        class="mt-6 md:mt-0 text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:text-neutral-600 hover:border-neutral-600 transition">View
                        Collection</a>
                </div>

                {{-- BENTO GRID LAYOUT --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 h-auto md:h-[600px]">
                    @foreach($curated->take(5) as $index => $related)
                    @php
                    $imgUrl = $related->image ? Storage::url('products/' . $related->image) :
                    'https://loremflickr.com/800/1000/fashion';
                    // LOGIC: Item đầu tiên (index 0) chiếm 2 cột 2 dòng
                    $classes = ($index === 0)
                    ? 'col-span-2 row-span-2 md:h-full relative group'
                    : 'col-span-1 row-span-1 relative group';
                    @endphp

                    <div class="{{ $classes }} overflow-hidden bg-neutral-100">
                        {{-- Ảnh --}}
                        <img src="{{ $imgUrl }}"
                            class="w-full h-full object-cover transition duration-[1.5s] ease-out group-hover:scale-105"
                            loading="lazy">

                        {{-- Badges --}}
                        @if($index === 0)
                        <div
                            class="absolute top-4 left-4 bg-black text-white text-[10px] font-bold uppercase px-3 py-1.5 z-10">
                            New Drop
                        </div>
                        @elseif($related->is_new)
                        <div class="absolute top-2 left-2 w-2 h-2 bg-red-500 rounded-full z-10"></div>
                        @endif

                        {{-- Info Overlay --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                            <div
                                class="translate-y-4 group-hover:translate-y-0 transition-transform duration-300 text-white">
                                <h3 class="text-sm md:text-lg font-bold uppercase tracking-widest">
                                    {{ $related->name }}
                                </h3>
                                <p class="text-xs md:text-sm font-light mt-1 opacity-90">
                                    ₫{{ number_format($related->price, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('products.show', $related->id) }}"
                                    class="inline-block mt-3 text-[10px] font-bold uppercase border-b border-white pb-0.5">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                        {{-- Link bao trùm --}}
                        <a href="{{ route('products.show', $related->id) }}" class="absolute inset-0 z-20"></a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

    </main>
    @include('partials.wishlist-script')
</x-app-layout>