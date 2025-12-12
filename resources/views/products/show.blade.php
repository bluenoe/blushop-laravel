{{-- ═══════════════════════════════════════════════════════════════
BluShop Product Detail v3 - High-End Minimalist Concept
Sticky Sidebar & Vertical Gallery - FIXED VERSION
═══════════════════════════════════════════════════════════════ --}}

@extends('layouts.app')

@push('head')
<meta name="description" content="{{ Str::limit($product->description, 160) }}">
<meta property="og:title" content="{{ $product->name }}">
<meta property="og:description" content="{{ Str::limit($product->description, 160) }}">
@if($product->images->first())
<meta property="og:image" content="{{ $product->images->first()->url }}">
@endif

{{-- Swiper CSS for mobile gallery --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<style>
    /* Gallery Styles */
    .swiper-container {
        width: 100%;
        height: 500px;
    }

    .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Color/Size Selection Styles */
    .color-option input:checked+span {
        border-color: #000;
        border-width: 3px;
    }

    .size-option input:checked+span {
        background-color: #000;
        color: #fff;
        border-color: #000;
    }

    .size-option input:disabled+span {
        opacity: 0.3;
        text-decoration: line-through;
    }

    /* Star Rating Styles */
    .star-rating-input label {
        position: relative;
    }

    .star-rating-input input:checked~label svg,
    .star-rating-input label:hover svg,
    .star-rating-input label:hover~label svg {
        fill: #fbbf24;
    }

    /* Accordion Animation */
    [x-cloak] {
        display: none !important;
    }

    /* Wishlist Button */
    .wishlist-toggle.active svg {
        fill: currentColor;
    }

    .wishlist-toggle:not(.active) svg {
        fill: none;
    }

    /* Fit Scale Indicator */
    .fit-scale-bar {
        position: relative;
        height: 4px;
        background: #e5e7eb;
    }

    .fit-scale-indicator {
        position: absolute;
        width: 12px;
        height: 12px;
        background: #000;
        border-radius: 50%;
        top: -4px;
        transform: translateX(-50%);
    }
</style>
@endpush

<div class="product-detail-page bg-white">
    {{-- BREADCRUMBS: Minimal --}}
    <nav class="breadcrumbs container mx-auto px-4 py-6 text-sm text-gray-600">
        <a href="/" class="hover:text-black">Home</a> /
        <a href="/shop" class="hover:text-black">Shop</a>
        @if($product->category)
        / <a href="/shop?category={{ $product->category->slug }}" class="hover:text-black">
            {{ $product->category->name }}
        </a>
        @endif
        / <span class="text-black">{{ $product->name }}</span>
    </nav>

    {{-- MAIN PRODUCT SECTION --}}
    <div class="container mx-auto px-4 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

            {{-- LEFT COLUMN: GALLERY (Mobile Slider / Desktop Grid) --}}
            <div class="gallery-section">
                {{-- Mobile View: Horizontal Slider --}}
                <div class="gallery-mobile lg:hidden">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @forelse($product->images as $image)
                            <div class="swiper-slide">
                                <img src="{{ $image->url }}" alt="{{ $product->name }} - Image {{ $loop->iteration }}"
                                    class="w-full h-full object-cover">
                            </div>
                            @empty
                            <div class="swiper-slide">
                                <img src="/images/placeholder.jpg" alt="No image available"
                                    class="w-full h-full object-cover">
                            </div>
                            @endforelse
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                {{-- Desktop View: Vertical Masonry/Grid --}}
                <div class="gallery-desktop hidden lg:grid lg:grid-cols-2 gap-4">
                    @forelse($product->images as $image)
                    <div class="gallery-item {{ $loop->first ? 'lg:col-span-2' : '' }}">
                        <img src="{{ $image->url }}" alt="{{ $product->name }} - Image {{ $loop->iteration }}"
                            class="w-full h-auto object-cover cursor-zoom-in hover:opacity-90 transition">
                    </div>
                    @empty
                    <div class="gallery-item lg:col-span-2">
                        <img src="/images/placeholder.jpg" alt="No image available" class="w-full h-auto object-cover">
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- RIGHT COLUMN: PRODUCT INFO (Sticky on Desktop) --}}
            <div class="product-info lg:sticky lg:top-24 lg:self-start">
                {{-- Header --}}
                <div class="flex justify-between items-start mb-4">
                    <h1 class="text-3xl lg:text-4xl font-light tracking-tight">
                        {{ $product->name }}
                    </h1>

                    {{-- Wishlist Button - Minimalist Style --}}
                    <button type="button"
                        class="wishlist-toggle {{ auth()->check() && auth()->user()->wishlist->contains($product->id) ? 'active' : '' }}"
                        data-product-id="{{ $product->id }}" aria-label="Add to wishlist">
                        <svg class="w-6 h-6 stroke-current hover:scale-110 transition-transform" viewBox="0 0 24 24"
                            stroke-width="1.5">
                            <path
                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                    </button>
                </div>

                {{-- Price --}}
                <div class="flex items-center gap-3 mb-8">
                    <span class="text-2xl font-medium">
                        ₫{{ number_format((float)$product->price, 0, ',', '.') }}
                    </span>
                    @if($product->is_on_sale)
                    <span class="px-3 py-1 bg-red-600 text-white text-xs uppercase tracking-wider">
                        Sale
                    </span>
                    @endif
                </div>

                {{-- Add to Cart Form --}}
                <form action="{{ route('cart.add', $product) }}" method="POST" id="add-to-cart-form" class="space-y-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    {{-- 1. COLOR SELECTION --}}
                    @if($product->colors && $product->colors->count() > 0)
                    <div class="color-selection">
                        <label class="block text-sm font-medium uppercase tracking-wider mb-3">
                            Color
                        </label>
                        <div class="flex flex-wrap gap-3">
                            @foreach($product->colors as $color)
                            <label class="color-option cursor-pointer">
                                <input type="radio" name="color_id" value="{{ $color->id }}" class="sr-only peer" {{
                                    $loop->first ? 'checked' : '' }}
                                required>
                                <span class="block w-12 h-12 rounded-full border-2 border-gray-300 
                                                     hover:border-gray-400 transition"
                                    style="background-color: {{ $color->hex }}" title="{{ $color->name }}">
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- 2. SIZE SELECTION --}}
                    @if($product->sizes && $product->sizes->count() > 0)
                    <div class="size-selection">
                        <div class="flex justify-between items-center mb-3">
                            <label class="text-sm font-medium uppercase tracking-wider">
                                Size
                            </label>
                            <button type="button" class="text-xs underline hover:no-underline"
                                onclick="alert('Size guide coming soon!')">
                                Size Guide
                            </button>
                        </div>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($product->sizes as $size)
                            <label class="size-option">
                                <input type="radio" name="size_id" value="{{ $size->id }}" class="sr-only peer" {{
                                    $size->stock <= 0 ? 'disabled' : '' }} {{ $loop->first && $size->stock > 0 ?
                                    'checked' : '' }}
                                    required>
                                    <span class="block px-4 py-3 border border-gray-300 text-center text-sm
                                                     hover:border-gray-400 transition cursor-pointer">
                                        {{ $size->name }}
                                    </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- 3. QUANTITY SELECTOR --}}
                    <div class="quantity-selector">
                        <label class="block text-sm font-medium uppercase tracking-wider mb-3">
                            Quantity
                        </label>
                        <div class="flex items-center gap-4">
                            <button type="button"
                                class="qty-decrease w-10 h-10 border border-gray-300 hover:bg-gray-100 transition"
                                aria-label="Decrease quantity">
                                −
                            </button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                class="w-20 h-10 text-center border border-gray-300 focus:border-black outline-none"
                                readonly>
                            <button type="button"
                                class="qty-increase w-10 h-10 border border-gray-300 hover:bg-gray-100 transition"
                                aria-label="Increase quantity">
                                +
                            </button>
                        </div>
                    </div>

                    {{-- Error Display --}}
                    <div id="form-errors" class="hidden text-red-600 text-sm"></div>

                    {{-- 4. ACTION BUTTONS --}}
                    <button type="submit" class="add-to-cart-btn w-full py-4 bg-black text-white font-medium uppercase tracking-wider
                                   hover:bg-gray-800 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="btn-text">Add to Bag</span>
                        <span class="btn-loading hidden">Processing...</span>
                        <span class="btn-success hidden">Added ✓</span>
                    </button>

                    <p class="text-sm text-center text-gray-600">
                        Free shipping on orders over ₫500,000
                    </p>
                </form>

                {{-- ========================================================
                ACCORDION SECTIONS (Animation Mượt & Đầm)
                ======================================================== --}}
                <div class="accordion-sections mt-8 space-y-0 border-t" x-data="{ open: 'details' }">

                    {{-- 1. DESCRIPTION & DETAILS --}}
                    <div class="border-b">
                        <button @click="open = open === 'details' ? '' : 'details'"
                            class="w-full flex justify-between items-center py-5 text-left">
                            <span class="font-medium uppercase tracking-wider text-sm">
                                Details & Composition
                            </span>
                            <span class="transform transition-transform duration-300 text-2xl font-light"
                                :class="{ 'rotate-45': open === 'details' }">
                                +
                            </span>
                        </button>

                        <div x-show="open === 'details'" x-collapse class="pb-5 text-sm text-gray-700 leading-relaxed">
                            {{-- Mô tả chung --}}
                            <p class="mb-4">
                                {{ $product->description ?? 'Timeless design meets modern functionality.' }}
                            </p>

                            {{-- Thông số kỹ thuật (Từ JSON) --}}
                            @if(!empty($product->specifications) && is_array($product->specifications))
                            <dl class="space-y-2">
                                @foreach($product->specifications as $key => $value)
                                <div class="flex">
                                    <dt class="w-1/3 font-medium">{{ ucfirst($key) }}</dt>
                                    <dd class="w-2/3 text-gray-600">{{ $value }}</dd>
                                </div>
                                @endforeach
                            </dl>
                            @else
                            {{-- Fallback mẫu nếu chưa có dữ liệu DB --}}
                            <dl class="space-y-2">
                                <div class="flex">
                                    <dt class="w-1/3 font-medium">Product Code</dt>
                                    <dd class="w-2/3 text-gray-600">REF-{{ $product->id }}</dd>
                                </div>
                                <div class="flex">
                                    <dt class="w-1/3 font-medium">Material</dt>
                                    <dd class="w-2/3 text-gray-600">Premium Quality</dd>
                                </div>
                                <div class="flex">
                                    <dt class="w-1/3 font-medium">Made In</dt>
                                    <dd class="w-2/3 text-gray-600">Vietnam</dd>
                                </div>
                            </dl>
                            @endif
                        </div>
                    </div>

                    {{-- 2. CARE GUIDE --}}
                    <div class="border-b">
                        <button @click="open = open === 'care' ? '' : 'care'"
                            class="w-full flex justify-between items-center py-5 text-left">
                            <span class="font-medium uppercase tracking-wider text-sm">
                                Care Guide
                            </span>
                            <span class="transform transition-transform duration-300 text-2xl font-light"
                                :class="{ 'rotate-45': open === 'care' }">
                                +
                            </span>
                        </button>

                        <div x-show="open === 'care'" x-collapse class="pb-5 text-sm text-gray-700 leading-relaxed">
                            @if($product->care_guide)
                            {!! nl2br(e($product->care_guide)) !!}
                            @else
                            <ul class="space-y-2">
                                <li>• Do not wash. Do not bleach.</li>
                                <li>• Do not iron. Do not dry clean.</li>
                                <li>• Clean with a soft dry cloth.</li>
                                <li>• Keep away from direct heat and sunlight.</li>
                            </ul>
                            @endif
                        </div>
                    </div>

                    {{-- 3. SHIPPING --}}
                    <div class="border-b">
                        <button @click="open = open === 'shipping' ? '' : 'shipping'"
                            class="w-full flex justify-between items-center py-5 text-left">
                            <span class="font-medium uppercase tracking-wider text-sm">
                                Shipping & Returns
                            </span>
                            <span class="transform transition-transform duration-300 text-2xl font-light"
                                :class="{ 'rotate-45': open === 'shipping' }">
                                +
                            </span>
                        </button>

                        <div x-show="open === 'shipping'" x-collapse class="pb-5 text-sm text-gray-700 leading-relaxed">
                            <p class="mb-2">
                                <strong>Free standard shipping</strong> on orders over ₫500,000.
                            </p>
                            <p>
                                Returns accepted within 30 days of purchase.
                                Items must be unworn and in original condition.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================
    SECTION: COMPLETE THE LOOK (Curated Set)
    ======================================================== --}}
    @if($product->completeLookProducts && $product->completeLookProducts->count() > 0)
    <section class="complete-the-look bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-light tracking-tight mb-2">Complete The Look</h2>
                <p class="text-gray-600">Shop the full set</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($product->completeLookProducts as $lookItem)
                <a href="{{ route('products.show', $lookItem) }}" class="group block">
                    <div class="aspect-square mb-4 overflow-hidden bg-white">
                        @if($lookItem->images->first())
                        <img src="{{ $lookItem->images->first()->url }}" alt="{{ $lookItem->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                        <img src="/images/placeholder.jpg" alt="{{ $lookItem->name }}"
                            class="w-full h-full object-cover">
                        @endif
                    </div>
                    <h3 class="text-sm font-medium mb-1 group-hover:underline">
                        {{ $lookItem->name }}
                    </h3>
                    <p class="text-sm text-gray-600">
                        ₫{{ number_format($lookItem->price, 0, ',', '.') }}
                    </p>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════
    REVIEWS SECTION
    ═══════════════════════════════════════════════════════════════ --}}
    <section class="reviews-section py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                {{-- COLUMN 1: RATINGS SUMMARY --}}
                <div class="reviews-summary">
                    <h2 class="text-2xl font-light mb-8">Reviews</h2>

                    {{-- Overall Rating --}}
                    <div class="text-center mb-8 pb-8 border-b">
                        <div class="text-5xl font-light mb-2">
                            {{ number_format($product->avg_rating ?? 0, 1) }}
                        </div>
                        <div class="flex justify-center gap-1 mb-2">
                            @for($i=1; $i<=5; $i++) <svg
                                class="w-5 h-5 {{ $i <= round($product->avg_rating ?? 0) ? 'fill-yellow-400' : 'fill-gray-300' }}"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                                @endfor
                        </div>
                        <p class="text-sm text-gray-600">
                            Based on {{ $product->reviews->count() }} reviews
                        </p>
                    </div>

                    {{-- Fit Scale Visualization --}}
                    @php
                    $avgFit = $product->reviews->avg('fit_rating') ?? 3;
                    $fitPercent = (($avgFit - 1) / 4) * 100;
                    $fitPercent = max(0, min(100, $fitPercent));
                    @endphp
                    <div class="mb-8">
                        <h3 class="text-sm font-medium uppercase tracking-wider mb-4">Fit Scale</h3>
                        <div class="fit-scale-bar mb-2">
                            <div class="fit-scale-indicator" style="left: {{ $fitPercent }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-600">
                            <span>Tight</span>
                            <span>True to Size</span>
                            <span>Loose</span>
                        </div>
                    </div>

                    {{-- Write Review Button --}}
                    @auth
                    <button type="button" onclick="document.getElementById('review-form').classList.toggle('hidden')"
                        class="w-full py-3 border-2 border-black font-medium uppercase tracking-wider
                                       hover:bg-black hover:text-white transition">
                        Write a Review
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="block w-full py-3 border-2 border-black font-medium uppercase tracking-wider text-center
                                  hover:bg-black hover:text-white transition">
                        Login to Review
                    </a>
                    @endauth

                    {{-- REVIEW FORM (Toggle) --}}
                    @auth
                    <div id="review-form" class="hidden mt-6 p-6 bg-gray-50 rounded">
                        <form action="{{ route('reviews.store', $product) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            {{-- Star Rating Input --}}
                            <div class="star-rating-input mb-4">
                                <label class="block text-sm font-medium mb-2">Rating *</label>
                                <div class="flex gap-1 flex-row-reverse justify-end">
                                    @for($i = 5; $i >= 1; $i--)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" class="sr-only peer"
                                            required>
                                        <svg class="w-8 h-8 fill-gray-300 hover:fill-yellow-400 transition"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                        </svg>
                                    </label>
                                    @endfor
                                </div>
                            </div>

                            {{-- Fit Rating Input (Range Slider) --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">How's the fit?</label>
                                <input type="range" name="fit_rating" min="1" max="5" value="3" step="1" class="w-full">
                                <div class="flex justify-between text-xs text-gray-600 mt-1">
                                    <span>Tight</span>
                                    <span>True to Size</span>
                                    <span>Loose</span>
                                </div>
                            </div>

                            {{-- Comment --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Review *</label>
                                <textarea name="comment" rows="4" required placeholder="Share your thoughts..."
                                    class="w-full px-3 py-2 border border-gray-300 rounded focus:border-black outline-none"></textarea>
                            </div>

                            {{-- Image Upload --}}
                            <div class="mb-4" x-data="{ preview: null }">
                                <label class="block text-sm font-medium mb-2">Photo (Optional)</label>
                                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg"
                                    @change="preview = URL.createObjectURL($event.target.files[0])"
                                    class="block w-full text-sm">

                                <div x-show="preview" class="mt-2">
                                    <img :src="preview" class="w-32 h-32 object-cover rounded">
                                </div>
                            </div>

                            <button type="submit" class="w-full py-3 bg-black text-white font-medium uppercase tracking-wider
                                               hover:bg-gray-800 transition">
                                Submit Review
                            </button>
                        </form>
                    </div>
                    @endauth
                </div>

                {{-- COLUMN 2 & 3: REVIEWS LIST --}}
                <div class="lg:col-span-2">
                    @if($product->reviews->count() > 0)
                    <div class="space-y-8">
                        @foreach($product->reviews as $review)
                        <div class="pb-8 border-b">
                            <div class="flex items-start gap-4 mb-4">
                                {{-- Avatar --}}
                                <div
                                    class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>

                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <h4 class="font-medium">{{ $review->user->name }}</h4>
                                        <span class="text-sm text-gray-500">
                                            {{ $review->created_at->format('M d, Y') }}
                                        </span>
                                    </div>

                                    {{-- Stars --}}
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="flex gap-0.5">
                                            @for($i=1; $i<=5; $i++) <svg
                                                class="w-4 h-4 {{ $i <= $review->rating ? 'fill-yellow-400' : 'fill-gray-300' }}"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                </svg>
                                                @endfor
                                        </div>

                                        {{-- Fit Badge --}}
                                        @php
                                        $fitLabel = match($review->fit_rating) {
                                        1 => 'Runs Small',
                                        2 => 'Slightly Small',
                                        3 => 'True to Size',
                                        4 => 'Slightly Large',
                                        5 => 'Runs Large',
                                        default => 'True to Size'
                                        };
                                        @endphp
                                        <span class="text-xs px-2 py-1 bg-gray-100 rounded">
                                            Fit: {{ $fitLabel }}
                                        </span>
                                    </div>

                                    {{-- Comment --}}
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ $review->comment }}
                                    </p>

                                    {{-- Review Image --}}
                                    @if($review->image)
                                    <div class="mt-4">
                                        <img src="{{ $review->image }}" alt="Review photo"
                                            class="w-48 h-48 object-cover rounded">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12 text-gray-500">
                        <p>No reviews yet. Be the first to share your thoughts.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================================
    SECTION: YOU MIGHT ALSO LIKE (Related Products Slider)
    ======================================================== --}}
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <section class="related-products py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-light tracking-tight text-center mb-12">
                You Might Also Like
            </h2>

            {{-- Horizontal Scroll Container --}}
            <div class="overflow-x-auto scrollbar-hide -mx-4 px-4">
                <div class="flex gap-6" style="width: max-content;">
                    @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related) }}" class="group block" style="width: 280px;">
                        <div class="aspect-square mb-4 overflow-hidden bg-white relative">
                            @if($related->images->first())
                            <img src="{{ $related->images->first()->url }}" alt="{{ $related->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                            <img src="/images/placeholder.jpg" alt="{{ $related->name }}"
                                class="w-full h-full object-cover">
                            @endif

                            {{-- Wishlist Toggle (Mini) --}}
                            <button type="button"
                                class="wishlist-toggle absolute top-4 right-4 w-8 h-8 bg-white rounded-full 
                                                   flex items-center justify-center shadow-md opacity-0 group-hover:opacity-100 transition"
                                data-product-id="{{ $related->id }}" onclick="event.preventDefault();">
                                <svg class="w-4 h-4 stroke-current" viewBox="0 0 24 24" stroke-width="2" fill="none">
                                    <path
                                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                </svg>
                            </button>
                        </div>

                        <h3 class="text-sm font-medium mb-1 group-hover:underline">
                            {{ $related->name }}
                        </h3>
                        <p class="text-sm text-gray-600">
                            ₫{{ number_format($related->price, 0, ',', '.') }}
                        </p>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
</div>

@push('scripts')
{{-- Swiper JS for Mobile Gallery --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

{{-- Alpine.js for Accordion (if not already loaded) --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    // ============================================
    // 1. MOBILE GALLERY SLIDER
    // ============================================
    const swiper = new Swiper('.swiper-container', {
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        }
    });

    // ============================================
    // 2. QUANTITY CONTROLS
    // ============================================
    const qtyInput = document.querySelector('input[name="quantity"]');
    const maxQty = parseInt(qtyInput.max);

    document.querySelector('.qty-increase').addEventListener('click', function () {
        let val = parseInt(qtyInput.value);
        if (val < maxQty) {
            qtyInput.value = val + 1;
        }
    });

    document.querySelector('.qty-decrease').addEventListener('click', function () {
        let val = parseInt(qtyInput.value);
        if (val > 1) {
            qtyInput.value = val - 1;
        }
    });

    // ============================================
    // 3. ADD TO CART FORM VALIDATION & SUBMISSION
    // ============================================
    document.getElementById('add-to-cart-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = this;
        const btn = form.querySelector('.add-to-cart-btn');
        const btnText = btn.querySelector('.btn-text');
        const btnLoading = btn.querySelector('.btn-loading');
        const btnSuccess = btn.querySelector('.btn-success');
        const errorDiv = document.getElementById('form-errors');

        // Validate color and size selection
        const color = form.querySelector('input[name="color_id"]:checked');
        const size = form.querySelector('input[name="size_id"]:checked');

        if (!color || !size) {
            errorDiv.textContent = 'Please select both color and size';
            errorDiv.classList.remove('hidden');
            return;
        }

        errorDiv.classList.add('hidden');

        // Show loading state
        btn.disabled = true;
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');

        // Submit form via AJAX
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success state
                    btnLoading.classList.add('hidden');
                    btnSuccess.classList.remove('hidden');

                    // Update cart count in header if exists
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount && data.cartCount) {
                        cartCount.textContent = data.cartCount;
                    }

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        btn.disabled = false;
                        btnSuccess.classList.add('hidden');
                        btnText.classList.remove('hidden');
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorDiv.textContent = error.message || 'Something went wrong. Please try again.';
                errorDiv.classList.remove('hidden');

                // Reset button
                btn.disabled = false;
                btnLoading.classList.add('hidden');
                btnText.classList.remove('hidden');
            });
    });

    // ============================================
    // 4. STAR RATING INPUT (Hover Effect)
    // ============================================
    const starInputs = document.querySelectorAll('.star-rating-input input[type="radio"]');
    const starLabels = document.querySelectorAll('.star-rating-input label');

    starLabels.forEach((label, index) => {
        label.addEventListener('mouseenter', function () {
            // Highlight this star and all previous stars
            for (let i = starLabels.length - 1; i >= index; i--) {
                starLabels[i].querySelector('svg').style.fill = '#fbbf24';
            }
        });

        label.addEventListener('mouseleave', function () {
            // Reset to checked state
            const checked = document.querySelector('.star-rating-input input:checked');
            starLabels.forEach((lbl, idx) => {
                const svg = lbl.querySelector('svg');
                if (checked) {
                    const checkedValue = parseInt(checked.value);
                    svg.style.fill = (5 - idx) <= checkedValue ? '#fbbf24' : '#d1d5db';
                } else {
                    svg.style.fill = '#d1d5db';
                }
            });
        });
    });

    // ============================================
    // 5. WISHLIST TOGGLE FUNCTIONALITY
    // ============================================
    document.querySelectorAll('.wishlist-toggle').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const productId = this.dataset.productId;
            const isActive = this.classList.contains('active');

            // Send AJAX request
            fetch('/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Toggle active class
                        this.classList.toggle('active');

                        // Update SVG fill
                        const svg = this.querySelector('svg');
                        if (this.classList.contains('active')) {
                            svg.style.fill = 'currentColor';
                        } else {
                            svg.style.fill = 'none';
                        }
                    }
                })
                .catch(error => {
                    console.error('Wishlist error:', error);
                    alert('Please login to add items to wishlist');
                });
        });
    });

    // ============================================
    // 6. SMOOTH SCROLL FOR HORIZONTAL SLIDER
    // ============================================
    document.querySelectorAll('.overflow-x-auto').forEach(container => {
        let isDown = false;
        let startX;
        let scrollLeft;

        container.addEventListener('mousedown', (e) => {
            isDown = true;
            startX = e.pageX - container.offsetLeft;
            scrollLeft = container.scrollLeft;
        });

        container.addEventListener('mouseleave', () => {
            isDown = false;
        });

        container.addEventListener('mouseup', () => {
            isDown = false;
        });

        container.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - container.offsetLeft;
            const walk = (x - startX) * 2;
            container.scrollLeft = scrollLeft - walk;
        });
    });
</script>

{{-- Custom Scrollbar Hide CSS --}}
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endpush