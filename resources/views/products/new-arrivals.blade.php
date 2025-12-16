{{--
═══════════════════════════════════════════════════════════════
BluShop New Arrivals - Editorial Layout v2
Style: Clean, Hierarchy-focused, Magazine look
Location: resources/views/products/new-arrivals.blade.php
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    {{-- Chỉnh background hơi xám nhẹ để làm nổi bật ảnh sản phẩm trắng --}}
    <main class="bg-[#FDFDFD] min-h-screen text-neutral-900 font-sans selection:bg-black selection:text-white">

        {{-- 1. MARQUEE (Giữ lại vì nó tạo vibe rất tốt) --}}
        <div class="bg-black text-white overflow-hidden py-2.5 relative z-30">
            <div class="animate-marquee whitespace-nowrap flex gap-12">
                @for($i=0; $i<10; $i++) <span
                    class="text-[10px] font-medium uppercase tracking-[0.3em] flex items-center gap-4">
                    New Season Drop <span class="w-1 h-1 bg-white rounded-full"></span>
                    Limited Quantities <span class="w-1 h-1 bg-white rounded-full"></span>
                    </span>
                    @endfor
            </div>
        </div>

        {{-- 2. HERO SECTION (Magazine Style) --}}
        {{-- Thay vì text căn giữa nhàm chán, ta làm layout 2 cột --}}
        <section class="border-b border-neutral-100">
            <div class="grid grid-cols-1 lg:grid-cols-2 min-h-[60vh]">
                {{-- Cột trái: Text giới thiệu --}}
                <div class="flex flex-col justify-center px-8 py-16 lg:px-24 bg-white order-2 lg:order-1">
                    <p class="text-xs font-bold uppercase tracking-[0.4em] text-neutral-400 mb-6" data-reveal>The Edit
                    </p>
                    <h1 class="text-5xl sm:text-7xl font-bold tracking-tighter leading-[0.9] mb-8" data-reveal
                        style="transition-delay: 100ms">
                        FRESH <br>
                        <span class="font-serif italic font-light text-neutral-400">PERSPECTIVE.</span>
                    </h1>
                    <p class="text-lg text-neutral-500 font-light leading-relaxed max-w-md mb-10" data-reveal
                        style="transition-delay: 200ms">
                        Khám phá bộ sưu tập mới nhất. Những thiết kế tối giản, tập trung vào chất liệu và phom dáng hiện
                        đại.
                    </p>
                    <div data-reveal style="transition-delay: 300ms">
                        <a href="#collection"
                            class="inline-block text-xs font-bold uppercase tracking-widest border-b border-black pb-1 hover:text-neutral-500 hover:border-neutral-300 transition-all">
                            Explore Collection &darr;
                        </a>
                    </div>
                </div>

                {{-- Cột phải: Ảnh Lookbook chủ đạo --}}
                <div class="relative h-[50vh] lg:h-auto overflow-hidden group order-1 lg:order-2">
                    <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1200&auto=format&fit=crop"
                        alt="New Collection Campaign"
                        class="absolute inset-0 w-full h-full object-cover transition duration-[2s] ease-out group-hover:scale-105">
                    {{-- Overlay mờ nhẹ --}}
                    <div class="absolute inset-0 bg-black/5"></div>
                </div>
            </div>
        </section>

        {{-- 3. PRODUCT LIST --}}
        <section id="collection" class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8 pb-32">

            {{-- Sticky Toolbar --}}
            <div class="sticky top-[64px] z-20 bg-[#FDFDFD]/90 backdrop-blur-md py-6 mb-10 flex justify-between items-end border-b border-transparent transition-all duration-300"
                x-data="{ stuck: false }" @scroll.window="stuck = (window.pageYOffset > 600)"
                :class="{ 'border-neutral-100 py-4': stuck }">

                <div>
                    <h2 class="text-sm font-bold uppercase tracking-widest">Arrivals</h2>
                    <p class="text-[10px] text-neutral-400 mt-1 uppercase tracking-wider">{{ $products->count() }}
                        Products Found</p>
                </div>


            </div>

            {{--
            [LOGIC MỚI] HIGHLIGHT SECTION
            Lấy 2 sản phẩm đầu tiên hiển thị to (Big Cards) để tạo điểm nhấn
            --}}
            @php
            $highlightProducts = $products->take(2);
            $normalProducts = $products->skip(2);
            @endphp

            @if($highlightProducts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                @foreach($highlightProducts as $product)
                <div class="group relative aspect-[3/4] md:aspect-[4/5] overflow-hidden bg-white" data-reveal>
                    <a href="{{ route('products.show', $product) }}" class="block w-full h-full">
                        <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition duration-1000 group-hover:scale-105">
                    </a>

                    {{-- Thông tin nổi nằm đè lên ảnh (Overlay style) cho sang --}}
                    <div
                        class="absolute bottom-0 left-0 w-full p-8 text-white bg-gradient-to-t from-black/60 to-transparent opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-500 flex justify-between items-end">
                        <div>
                            <p
                                class="text-[10px] uppercase tracking-widest mb-1 bg-white text-black inline-block px-2 py-0.5">
                                Highlight</p>
                            <h3 class="text-xl font-serif italic">{{ $product->name }}</h3>
                            <p class="text-sm mt-1 opacity-90">{{ number_format($product->price) }}đ</p>
                        </div>
                        <button
                            class="w-10 h-10 bg-white text-black rounded-full flex items-center justify-center hover:bg-neutral-200 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- STANDARD GRID (Các sản phẩm còn lại) --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-10">
                @foreach($normalProducts as $product)
                <div class="group" data-reveal>
                    {{-- Image Wrapper --}}
                    <div class="relative aspect-[3/4] overflow-hidden bg-neutral-100 mb-4">
                        <a href="{{ route('products.show', $product) }}" class="block w-full h-full">
                            <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}"
                                loading="lazy"
                                class="w-full h-full object-cover transition duration-700 ease-out group-hover:scale-110">
                        </a>

                        {{-- Quick Add Button (Chỉ hiện khi hover) --}}
                        <div
                            class="absolute inset-x-4 bottom-4 translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition duration-300">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                    class="w-full py-3 bg-white text-black text-[10px] font-bold uppercase tracking-widest shadow-lg hover:bg-black hover:text-white transition">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="space-y-1">
                        <h3
                            class="text-sm text-neutral-900 group-hover:underline decoration-1 underline-offset-4 decoration-neutral-300">
                            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        </h3>
                        <div class="flex justify-between items-center">
                            <p class="text-xs text-neutral-500 uppercase tracking-wide">{{ $product->category->name ??
                                'Essentials' }}</p>
                            <span class="text-sm font-medium">₫{{ number_format($product->price) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Footer Text --}}
            <div class="mt-32 text-center">
                <span class="text-3xl font-serif italic text-neutral-200">BluShop.</span>
            </div>
        </section>
    </main>

    {{-- Script & Style giữ nguyên --}}
    @push('head')
    <style>
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-marquee {
            animation: marquee 30s linear infinite;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', 'translate-y-8');
                    }
                });
            }, { threshold: 0.05, rootMargin: '0px 0px -50px 0px' }); // Trigger sớm hơn chút

            document.querySelectorAll('[data-reveal]').forEach(el => {
                el.classList.add('opacity-0', 'translate-y-8', 'transition-all', 'duration-700', 'ease-out');
                observer.observe(el);
            });
        });
    </script>
    @endpush
</x-app-layout>