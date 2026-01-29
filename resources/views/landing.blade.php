<x-app-layout>
    @push('head')
    {{-- 1. LOAD FONTS: Playfair Display (Luxury Serif) & Inter (Clean Sans) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap"
        rel="stylesheet">

    {{-- 2. CUSTOM CSS CHO EDITORIAL VIBE --}}
    <style>
        /* Font Definitions */
        .font-serif-display {
            font-family: 'Playfair Display', serif;
        }

        .font-sans-clean {
            font-family: 'Inter', sans-serif;
        }

        /* Hide Scrollbar for clean look */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* REVEAL ANIMATION CLASSES */
        .reveal-element {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1.2s ease-out, transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-element.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Delay Utilities */
        .delay-200 {
            transition-delay: 100ms;
        }

        .delay-400 {
            transition-delay: 200ms;
        }

        /* Image Hover Zoom */
        .img-zoom-wrapper {
            overflow: hidden;
        }

        .img-zoom-wrapper img {
            transition: transform 1.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .img-zoom-wrapper:hover img {
            transform: scale(1.03);
        }

        /* Cinematic Hero Animation */
        @keyframes ken-burns {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.1);
            }
        }

        .animate-ken-burns {
            animation: ken-burns 15s ease-out infinite alternate;
            will-change: transform;
        }
    </style>
    @endpush

    {{-- LƯU Ý: Header đang để position fixed, nên ta cần xử lý Hero Section
    để ảnh tràn lên dưới Header tạo cảm giác Immersive --}}

    <div class="bg-white text-neutral-900 overflow-x-hidden">

        {{-- 1. HERO SECTION (Magazine Cover Style) --}}
        {{-- -mt-20 để kéo ảnh lên nằm dưới Header trong suốt --}}
        <section class="relative w-full h-[100vh] min-h-[700px] -mt-20 overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=2073&auto=format&fit=crop"
                    alt="BluShop Editorial Campaign" class="w-full h-full object-cover animate-ken-burns">
                {{-- Scrim Gradient Overlay for better text readability --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
            </div>

            <div class="absolute bottom-0 left-0 w-full p-6 md:p-12 pb-20 md:pb-32 text-white z-10">
                <div class="max-w-4xl mx-auto md:mx-0">
                    <p
                        class="reveal-element font-sans-clean text-xs md:text-sm tracking-[0.3em] uppercase mb-4 text-neutral-200">
                        Spring / Summer 2025
                    </p>
                    <h1 class="reveal-element delay-200 font-serif-display text-5xl md:text-8xl leading-none mb-6">
                        The New <br> <span class="italic font-light opacity-90">Silence</span>
                    </h1>
                    <div class="reveal-element delay-400 h-px w-24 bg-white/50 mb-8"></div>
                    <a href="{{ route('products.index') }}"
                        class="reveal-element delay-400 inline-block font-sans-clean text-xs tracking-[0.2em] uppercase px-8 py-3 border border-white/30 bg-white/5 backdrop-blur-sm transition-all duration-300 hover:bg-white hover:text-black hover:-translate-y-0.5 hover:shadow-lg">
                        View Collection
                    </a>
                </div>
            </div>
        </section>

        {{-- 2. PHILOSOPHY (Typography Focused) --}}
        <section class="relative py-24 md:py-40 px-6 md:px-12 bg-white">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-12 items-end">
                <div class="md:col-span-4 reveal-element">
                    <span
                        class="block text-[12rem] leading-[0.8] font-serif-display text-neutral-50 -ml-4 select-none">01</span>
                </div>
                <div class="md:col-span-6 md:col-start-6 reveal-element delay-200">
                    <h2 class="font-serif-display text-3xl md:text-4xl mb-8 leading-snug text-neutral-900">
                        Minimalism is not about absence.<br>
                        It is about the <span class="italic text-neutral-500">perfect amount</span> of something.
                    </h2>
                    <p
                        class="font-sans-clean text-neutral-500 text-sm md:text-base leading-relaxed max-w-md font-light">
                        We strip away the unnecessary to reveal the essential. BluShop focuses on silhouette, fabric,
                        and the feeling of wearing something made with intent. No noise, just style.
                    </p>
                </div>
            </div>
        </section>

        {{-- 3. VISUAL STORYTELLING (Asymmetric Layout) --}}
        <section class="py-12 md:py-24 px-4 md:px-8 bg-neutral-50">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-24 mb-32 items-center">
                    <div class="reveal-element img-zoom-wrapper aspect-[3/4] md:aspect-[4/5] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1532453288672-3a27e9be9efd?q=80&w=1964&auto=format&fit=crop"
                            alt="Fabric Detail"
                            class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
                    </div>
                    <div class="reveal-element delay-200 md:-ml-12 bg-white p-8 md:p-12 shadow-sm z-10 max-w-md">
                        <p class="font-sans-clean text-xs tracking-widest uppercase text-neutral-400 mb-4">The Fabric
                        </p>
                        <h3 class="font-serif-display text-3xl mb-4">Tactile Luxury</h3>
                        <p class="font-sans-clean text-neutral-500 mb-6 font-light leading-relaxed text-sm">
                            Sourced from the finest mills, our organic cotton and raw linens breathe with you. Designed
                            to age gracefully.
                        </p>
                        <a href="{{ route('products.index') }}"
                            class="font-sans-clean text-xs uppercase tracking-widest border-b border-neutral-300 pb-1 hover:border-black transition-colors">
                            Explore Materials
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                    <div class="md:col-span-5 md:col-start-2 reveal-element mt-12 md:mt-32 order-2 md:order-1">
                        <div class="md:sticky md:top-32 pr-8">
                            <p class="font-sans-clean text-xs tracking-widest uppercase text-neutral-400 mb-4">The Form
                            </p>
                            <h3 class="font-serif-display text-4xl mb-6">Effortless Motion</h3>
                            <p class="font-sans-clean text-neutral-500 font-light leading-relaxed mb-8">
                                Structured yet fluid. Our cuts are engineered for movement, ensuring you look composed
                                in the chaos of the city.
                            </p>
                            <a href="{{ route('new-arrivals') }}"
                                class="inline-block px-6 py-3 bg-neutral-900 text-white text-xs uppercase tracking-widest hover:bg-neutral-800 transition">
                                Shop New Arrivals
                            </a>
                        </div>
                    </div>
                    <div class="md:col-span-6 md:col-start-7 reveal-element delay-200 order-1 md:order-2">
                        <div class="img-zoom-wrapper aspect-[3/4] overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=1888&auto=format&fit=crop"
                                alt="Model Posing" class="w-full h-full object-cover">
                        </div>
                        <p class="text-right text-[10px] tracking-widest uppercase text-neutral-400 mt-3">Look 04 — The
                            Trench</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. HIGHLIGHT MOMENT (Full Width Parallax Feel) --}}
        <section class="reveal-element relative w-full h-[70vh] overflow-hidden">
            <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=2070&auto=format&fit=crop"
                alt="Campaign Highlight" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="absolute bottom-12 right-6 md:bottom-24 md:right-24 text-white text-right">
                <h2 class="font-serif-display text-5xl md:text-7xl mb-6 italic">Evening Hues</h2>
                <a href="{{ route('lookbook') }}"
                    class="inline-block font-sans-clean text-xs tracking-[0.2em] uppercase bg-white text-black px-8 py-4 hover:bg-neutral-200 transition-colors">
                    View Lookbook
                </a>
            </div>
        </section>

        {{-- 5. CURATED GRID (Essentials) --}}
        <section class="py-24 px-6 bg-white">
            <div class="text-center mb-16 reveal-element">
                <h2 class="font-serif-display text-3xl md:text-4xl text-neutral-900">Essentials</h2>
                <div class="h-8 w-px bg-neutral-200 mx-auto mt-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-1 md:gap-8 max-w-7xl mx-auto">
                {{-- 1. WOMAN --}}
                <a href="{{ route('products.index', ['category' => 'women']) }}"
                    class="group block cursor-pointer reveal-element">
                    <div class="aspect-[4/5] bg-neutral-100 overflow-hidden relative">
                        {{-- Ảnh mẫu nữ minimalist --}}
                        <img src="{{ Storage::url('products/landing/woman-collection.jpg') }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            alt="Woman Collection">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-500">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between items-baseline px-1">
                        <h4 class="font-serif-display text-lg italic text-neutral-800">Woman</h4>
                        <span
                            class="font-sans-clean text-[10px] uppercase tracking-widest text-neutral-400 group-hover:text-black transition-colors">Shop</span>
                    </div>
                </a>

                {{-- 2. MAN --}}
                <a href="{{ route('products.index', ['category' => 'men']) }}"
                    class="group block cursor-pointer reveal-element delay-200 md:mt-12">
                    <div class="aspect-[4/5] bg-neutral-100 overflow-hidden relative">
                        {{-- Ảnh mẫu nam clean --}}
                        <img src="{{ Storage::url('products/landing/man-collection.jpg') }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            alt="Man Collection">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-500">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between items-baseline px-1">
                        <h4 class="font-serif-display text-lg italic text-neutral-800">Man</h4>
                        <span
                            class="font-sans-clean text-[10px] uppercase tracking-widest text-neutral-400 group-hover:text-black transition-colors">Shop</span>
                    </div>
                </a>

                {{-- 3. FRAGRANCE --}}
                <a href="{{ route('products.index', ['category' => 'fragrance']) }}"
                    class="group block cursor-pointer reveal-element delay-400">
                    <div class="aspect-[4/5] bg-neutral-100 overflow-hidden relative">
                        {{-- Ảnh nước hoa luxury --}}
                        <img src="{{ Storage::url('products/landing/fragrance-collection.jpg') }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            alt="Fragrance Collection">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-500">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between items-baseline px-1">
                        <h4 class="font-serif-display text-lg italic text-neutral-800">Fragrance</h4>
                        <span
                            class="font-sans-clean text-[10px] uppercase tracking-widest text-neutral-400 group-hover:text-black transition-colors">Shop</span>
                    </div>
                </a>
            </div>
        </section>

        {{-- SCROLL INTERACTION SCRIPT --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const observerOptions = {
                    root: null,
                    rootMargin: '0px',
                    threshold: 0.1 // Kích hoạt khi thấy 10%
                };

                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                const elementsToReveal = document.querySelectorAll('.reveal-element');
                elementsToReveal.forEach(el => observer.observe(el));
            });
        </script>
    </div>
</x-app-layout>