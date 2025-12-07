{{--
═══════════════════════════════════════════════════════════════
BluShop Landing Page - Modern Minimalist Edition
Theme: Editorial Fashion, High Contrast, Clean Lines
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    @push('head')
    <link rel="preload" as="image" href="{{ asset('images/landing-hero.jpg') }}" fetchpriority="high">
    <meta name="description" content="Minimalist fashion essentials for students. 15% off first order.">

    {{-- Inline Styles for smooth scrolling and clean font rendering --}}
    <style>
        html {
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    @endpush

    <main class="bg-white text-neutral-900 overflow-x-hidden selection:bg-neutral-900 selection:text-white">

        {{-- HERO SECTION: Editorial Style --}}
        <section
            class="relative h-screen min-h-[700px] flex items-center justify-center bg-neutral-900 text-white overflow-hidden"
            id="hero">
            {{-- Background Image with refined overlay --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/landing-hero.jpg') }}" alt="BluShop Aesthetic"
                    class="w-full h-full object-cover opacity-80 scale-105" style="transition: transform 10s ease-out"
                    onload="this.style.transform='scale(1)'" loading="eager" fetchpriority="high" />
                <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
                {{-- Grain texture for modern feel (optional) --}}
                <div class="absolute inset-0 opacity-[0.03] mix-blend-overlay"
                    style="background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPgo8cmVjdCB3aWR0aD0iNCIgaGVpZ2h0PSI0IiBmaWxsPSIjZmZmIi8+CjxyZWN0IHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9IiMwMDAiLz4KPC9zdmc+');">
                </div>
            </div>

            <div class="relative z-10 w-full max-w-3xl mx-auto px-6 text-center mt-10">
                {{-- Badge --}}
                <div data-reveal class="inline-block mb-8">
                    <span
                        class="px-3 py-1 border border-white/30 rounded-full text-[10px] uppercase tracking-[0.2em] backdrop-blur-md">
                        Limited Offer: 48h Left
                    </span>
                </div>

                {{-- Headline: Tight tracking, thinner font weight for elegance --}}
                <h1 data-reveal style="transition-delay: 100ms"
                    class="opacity-0 translate-y-4 transition-all duration-1000 ease-out text-5xl sm:text-7xl md:text-8xl font-medium tracking-tighter leading-[0.9] mb-8">
                    Elevate Your<br><span class="text-neutral-300 font-light italic">Everyday.</span>
                </h1>

                <p data-reveal style="transition-delay: 200ms"
                    class="opacity-0 translate-y-4 transition-all duration-1000 ease-out text-lg sm:text-xl text-white/70 font-light max-w-lg mx-auto mb-10 leading-relaxed">
                    Student-friendly essentials reimagined. Quality that lasts. <br class="hidden sm:block">Unlock
                    <strong>15% off</strong> your first curated order.
                </p>

                {{-- Minimalist Input Form --}}
                <div data-reveal style="transition-delay: 300ms"
                    class="opacity-0 translate-y-4 transition-all duration-1000 ease-out max-w-md mx-auto"
                    x-data="{ email: '', loading: false, success: false, error: '' }">

                    <form @submit.prevent="
                        if (!email || !email.includes('@')) { error = 'Please enter a valid email'; return; }
                        loading = true; error = '';
                        // Simulated API Call
                        setTimeout(() => { success = true; loading = false; setTimeout(() => { window.location.href = '/products?welcome=true'; }, 1500); }, 800);
                    " class="relative group">

                        <div
                            class="relative flex items-center border-b border-white/30 focus-within:border-white transition-colors duration-300 pb-1">
                            <input type="email" x-model="email" placeholder="email@university.edu" required
                                :disabled="loading || success"
                                class="w-full bg-transparent border-none p-4 text-center text-xl placeholder-white/30 text-white focus:ring-0 focus:outline-none" />

                            <button type="submit" :disabled="loading || success"
                                class="absolute right-0 top-1/2 -translate-y-1/2 text-sm font-medium uppercase tracking-widest hover:text-neutral-300 transition-colors disabled:opacity-50">
                                <span x-show="!loading && !success">Join</span>
                                <span x-show="loading">...</span>
                                <span x-show="success">Done</span>
                            </button>
                        </div>

                        {{-- Status Messages --}}
                        <div class="absolute -bottom-8 left-0 w-full text-center h-6">
                            <p x-show="success" x-transition class="text-xs text-green-400 tracking-wide">Code sent.
                                Redirecting...</p>
                            <p x-show="error" x-text="error" x-transition class="text-xs text-red-400 tracking-wide">
                            </p>
                            <p x-show="!success && !error" class="text-[10px] text-white/40 uppercase tracking-widest">
                                No spam, just style.</p>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Scroll Indicator --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce opacity-50">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 14l-7 7-7-7" />
                </svg>
            </div>
        </section>

        {{-- TRUST STRIP: Clean typography, no boxes --}}
        <section class="border-b border-neutral-100 py-12">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-wrap justify-between items-center gap-8 md:gap-12 opacity-80" data-reveal>
                    <div class="flex-1 text-center md:text-left">
                        <span class="block text-3xl font-bold tracking-tighter">10k+</span>
                        <span class="text-xs uppercase tracking-widest text-neutral-500">Students</span>
                    </div>
                    <div class="w-px h-10 bg-neutral-200 hidden md:block"></div>
                    <div class="flex-1 text-center md:text-left">
                        <span class="block text-3xl font-bold tracking-tighter">4.9</span>
                        <span class="text-xs uppercase tracking-widest text-neutral-500">Avg Rating</span>
                    </div>
                    <div class="w-px h-10 bg-neutral-200 hidden md:block"></div>
                    <div class="flex-1 text-center md:text-left">
                        <span class="block text-3xl font-bold tracking-tighter">24h</span>
                        <span class="text-xs uppercase tracking-widest text-neutral-500">Dispatch</span>
                    </div>
                    <div class="w-px h-10 bg-neutral-200 hidden md:block"></div>
                    <div class="flex-1 text-center md:text-left">
                        <span class="block text-3xl font-bold tracking-tighter">Free</span>
                        <span class="text-xs uppercase tracking-widest text-neutral-500">Ship > 500k</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- BENEFITS: Editorial Layout --}}
        <section id="benefits" class="py-32">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 lg:gap-24 items-start">
                    <div class="sticky top-24" data-reveal>
                        <h2 class="text-4xl md:text-5xl font-bold tracking-tighter leading-tight mb-6">
                            Designed for the <br> <span class="text-neutral-400 font-serif italic">Campus Life.</span>
                        </h2>
                        <p class="text-neutral-600 leading-relaxed text-lg max-w-md">
                            We strip away the branding and markup. You get premium materials, perfect fits, and prices
                            that make sense for a student budget.
                        </p>
                        <div class="mt-8">
                            <a href="{{ route('products.index') }}"
                                class="group inline-flex items-center text-sm font-semibold uppercase tracking-widest border-b border-neutral-900 pb-1 hover:opacity-60 transition">
                                Explore Collection
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="space-y-16">
                        {{-- Feature 1 --}}
                        <div data-reveal class="group">
                            <div
                                class="w-12 h-12 border border-neutral-200 rounded-full flex items-center justify-center mb-6 text-neutral-400 group-hover:bg-neutral-900 group-hover:text-white group-hover:border-neutral-900 transition duration-300">
                                <span class="font-serif italic text-xl">1</span>
                            </div>
                            <h3 class="text-xl font-bold mb-3">Honest Pricing</h3>
                            <p class="text-neutral-500 leading-relaxed">No hidden retail markups. Just high-quality
                                fabrics sourced directly, passed on to you.</p>
                        </div>

                        {{-- Feature 2 --}}
                        <div data-reveal class="group">
                            <div
                                class="w-12 h-12 border border-neutral-200 rounded-full flex items-center justify-center mb-6 text-neutral-400 group-hover:bg-neutral-900 group-hover:text-white group-hover:border-neutral-900 transition duration-300">
                                <span class="font-serif italic text-xl">2</span>
                            </div>
                            <h3 class="text-xl font-bold mb-3">Minimalist Aesthetic</h3>
                            <p class="text-neutral-500 leading-relaxed">Timeless cuts and neutral tones. Mix and match
                                everything in our store effortlessly.</p>
                        </div>

                        {{-- Feature 3 --}}
                        <div data-reveal class="group">
                            <div
                                class="w-12 h-12 border border-neutral-200 rounded-full flex items-center justify-center mb-6 text-neutral-400 group-hover:bg-neutral-900 group-hover:text-white group-hover:border-neutral-900 transition duration-300">
                                <span class="font-serif italic text-xl">3</span>
                            </div>
                            <h3 class="text-xl font-bold mb-3">Rapid Local Delivery</h3>
                            <p class="text-neutral-500 leading-relaxed">From our warehouse to your dorm room in 2-4
                                days. Easy returns if it doesn't fit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- TESTIMONIALS: Clean Typography --}}
        <section class="py-32 bg-neutral-50 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6">
                <p data-reveal class="text-center text-xs font-bold uppercase tracking-[0.3em] text-neutral-400 mb-16">
                    The Community</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @php
                    $reviews = [
                    ['txt' => "The quality rivals brands that charge triple. My wardrobe is basically 80% BluShop now.",
                    'user' => 'Linh N.', 'loc' => 'RMIT'],
                    ['txt' => "Finally simple clothes without giant logos. Perfect for presentations and hanging out.",
                    'user' => 'Minh T.', 'loc' => 'FPT U'],
                    ['txt' => "Packaging was eco-friendly and shipping was super fast. The fabric feels premium.",
                    'user' => 'Sarah V.', 'loc' => 'BUV'],
                    ];
                    @endphp

                    @foreach($reviews as $r)
                    <div data-reveal class="bg-white p-8 md:p-10 shadow-sm hover:shadow-md transition duration-300">
                        <div class="mb-6 text-neutral-900">
                            @for($i=0; $i<5; $i++) <span class="text-xs">★</span> @endfor
                        </div>
                        <p class="text-lg text-neutral-800 leading-relaxed mb-8 font-light">"{{ $r['txt'] }}"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-neutral-200 rounded-full"></div> {{-- Placeholder Avatar --}}
                            <div>
                                <p class="text-sm font-bold text-neutral-900">{{ $r['user'] }}</p>
                                <p class="text-[10px] uppercase tracking-wider text-neutral-400">{{ $r['loc'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- FINAL CTA: High Contrast --}}
        <section class="py-32 bg-black text-white text-center px-6">
            <div class="max-w-2xl mx-auto" data-reveal>
                <h2 class="text-4xl md:text-6xl font-bold tracking-tighter mb-8">Ready to upgrade?</h2>
                <p class="text-neutral-400 text-lg mb-12 font-light">Join the movement of smarter student fashion.
                    <br>Minimal effort, maximum style.</p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a href="#hero"
                        class="w-full sm:w-auto px-10 py-4 bg-white text-black font-bold uppercase tracking-widest text-xs hover:bg-neutral-200 transition transform hover:-translate-y-1">
                        Get 15% Off
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="w-full sm:w-auto px-10 py-4 border border-white/20 text-white font-bold uppercase tracking-widest text-xs hover:bg-white/10 transition">
                        Shop All
                    </a>
                </div>
            </div>
        </section>

    </main>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', 'translate-y-4');
                    }
                });
            }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

            document.querySelectorAll('[data-reveal]').forEach(el => observer.observe(el));
        });
    </script>
    @endpush
</x-app-layout>