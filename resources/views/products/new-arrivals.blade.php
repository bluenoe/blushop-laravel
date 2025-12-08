{{--
═══════════════════════════════════════════════════════════════
BluShop New Arrivals - Editorial Drop Style
Location: resources/views/products/new-arrivals.blade.php
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    <main class="bg-white min-h-screen text-neutral-900">

        {{-- 1. HERO HEADER: Marquee & Title --}}
        <div class="border-b border-neutral-100">
            {{-- Marquee chạy chữ --}}
            <div class="bg-black text-white overflow-hidden py-3">
                <div class="animate-marquee whitespace-nowrap flex gap-8">
                    @for($i=0; $i<10; $i++) <span class="text-[10px] uppercase tracking-[0.3em] font-bold">Just Landed •
                        New Season Essentials • Limited Quantities</span>
                        @endfor
                </div>
            </div>

            <div class="max-w-[1600px] mx-auto px-6 py-16 sm:py-24 text-center">
                <p class="text-xs uppercase tracking-[0.4em] text-neutral-400 mb-6" data-reveal>The Latest Drop</p>
                <h1 class="text-5xl sm:text-7xl lg:text-9xl font-bold tracking-tighter leading-none mb-8" data-reveal
                    style="transition-delay: 100ms">
                    NEW <span class="font-serif italic font-light text-neutral-400">IN.</span>
                </h1>
                <p class="max-w-xl mx-auto text-lg text-neutral-500 font-light leading-relaxed" data-reveal
                    style="transition-delay: 200ms">
                    Fresh cuts and fabrics for the season. <br class="hidden sm:block">Curated pieces to refresh your
                    daily rotation.
                </p>
            </div>
        </div>

        {{-- 2. EDITORIAL GRID --}}
        <section class="max-w-[1600px] mx-auto px-6 pb-24">

            {{-- Filter Bar (Minimal) --}}
            <div
                class="flex justify-between items-center py-8 mb-8 sticky top-[64px] z-20 bg-white/95 backdrop-blur-sm">
                <span class="text-xs font-bold uppercase tracking-widest">{{ $products->total() }} Items</span>
                <div class="flex gap-4">
                    {{-- Chỉ là nút giả lập vibe, vì đây là trang New In --}}
                    <button
                        class="text-xs font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition">View:
                        Grid</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-12">

                {{-- ITEM 1: Feature Image (Lookbook style) --}}
                {{-- Chiếm 2 cột ở màn hình lớn để tạo điểm nhấn --}}
                <div class="sm:col-span-2 aspect-[4/3] sm:aspect-auto bg-neutral-100 relative group overflow-hidden"
                    data-reveal>
                    <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=1200&auto=format&fit=crop"
                        alt="Campaign"
                        class="w-full h-full object-cover transition duration-[2s] group-hover:scale-105 filter grayscale group-hover:grayscale-0">
                    <div class="absolute bottom-6 left-6 text-white mix-blend-difference">
                        <span class="text-[10px] uppercase tracking-[0.3em] block mb-2">Campaign</span>
                        <h3 class="text-3xl font-bold tracking-tight">Quiet Luxury</h3>
                    </div>
                </div>

                {{-- PRODUCTS LOOP --}}
                @foreach($products as $product)
                <div class="group flex flex-col" data-reveal>
                    <div class="relative aspect-[3/4] bg-neutral-100 overflow-hidden mb-4">
                        <a href="{{ route('products.show', $product) }}" class="block w-full h-full">
                            <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}"
                                loading="lazy"
                                class="w-full h-full object-cover transition duration-700 ease-out group-hover:scale-105">
                        </a>

                        {{-- Badge "Just In" --}}
                        <div class="absolute top-2 left-2">
                            <span
                                class="bg-black text-white text-[9px] font-bold uppercase px-2 py-1 tracking-widest">Just
                                In</span>
                        </div>

                        {{-- Quick Add Overlay --}}
                        <div
                            class="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition duration-300 ease-out hidden lg:block">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                    class="w-full py-3 bg-white/90 backdrop-blur text-black text-[10px] font-bold uppercase tracking-widest hover:bg-black hover:text-white transition">
                                    Quick Add +
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-sm font-bold uppercase tracking-wide leading-none">
                                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                            </h3>
                            @if($product->category)
                            <p class="text-[10px] text-neutral-400 uppercase tracking-widest mt-1.5">{{
                                $product->category->name }}</p>
                            @endif
                        </div>
                        <span class="text-sm font-medium">₫{{ number_format($product->price) }}</span>
                    </div>
                </div>
                @endforeach

            </div>

            {{-- Load More / Pagination --}}
            <div class="mt-24 text-center border-t border-neutral-100 pt-12">
                @if($products->hasPages())
                {{ $products->links('pagination::simple-tailwind') }}
                @else
                <p class="text-xs uppercase tracking-widest text-neutral-400">You've reached the end</p>
                @endif
            </div>

        </section>

    </main>

    {{-- CSS cho chữ chạy Marquee --}}
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
            animation: marquee 20s linear infinite;
        }
    </style>
    @endpush

    {{-- Script Reveal Effect --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', 'translate-y-4');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('[data-reveal]').forEach(el => {
                el.classList.add('opacity-0', 'translate-y-4', 'transition-all', 'duration-700', 'ease-out');
                observer.observe(el);
            });
        });
    </script>
    @endpush
</x-app-layout>