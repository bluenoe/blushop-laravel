{{--
═══════════════════════════════════════════════════════════════
BluShop Landing Page - High Conversion Focus
Goal: Collect emails + Drive first purchase with 15% discount
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    @push('head')
    <link rel="preload" as="image" href="{{ asset('images/landing-hero.jpg') }}" fetchpriority="high">
    <meta name="description"
        content="Get 15% off your first BluShop order. Minimalist fashion essentials for modern students.">

    {{-- [TODO: INSERT TRACKING] Place Google Analytics / Meta Pixel here --}}
    @endpush

    <main class="bg-white overflow-x-hidden">

        {{-- HERO SECTION --}}
        <section class="relative min-h-screen flex items-center bg-slate-950" id="hero">
            <div class="absolute inset-0">
                <img src="{{ asset('images/landing-hero.jpg') }}" alt="BluShop fashion"
                    class="w-full h-full object-cover" loading="eager" fetchpriority="high" />
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/30"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-6 py-20 sm:py-24">
                <div class="max-w-2xl">
                    <div data-reveal
                        class="inline-flex items-center gap-2 rounded-full bg-rose-500/90 text-white px-4 py-2 text-xs sm:text-sm font-medium mb-6 animate-pulse">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd" />
                        </svg>
                        Limited Offer: 48 Hours Only
                    </div>

                    <h1 data-reveal style="transition-delay: 100ms"
                        class="opacity-0 translate-y-3 transition duration-700 text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                        Get 15% Off Your<br>First BluShop Order
                    </h1>

                    <p data-reveal style="transition-delay: 200ms"
                        class="opacity-0 translate-y-3 transition duration-700 text-lg sm:text-xl text-white/90 mb-8 leading-relaxed">
                        Minimalist essentials for students. Quality pieces that last. Free shipping over ₫500,000. Join
                        10,000+ happy customers.
                    </p>

                    <div data-reveal style="transition-delay: 300ms"
                        class="opacity-0 translate-y-3 transition duration-700"
                        x-data="{ email: '', loading: false, success: false, error: '' }">
                        <form @submit.prevent="
                            if (!email || !email.includes('@')) { error = 'Please enter a valid email'; return; }
                            loading = true; error = '';
                            fetch('/api/landing/subscribe', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                                body: JSON.stringify({ email: email, source: 'landing_hero', campaign: 'welcome_15off' })
                            })
                            .then(r => r.json())
                            .then(data => {
                                if (data.success) {
                                    success = true;
                                    setTimeout(() => { window.location.href = '/products?welcome=true'; }, 2000);
                                } else { error = data.message || 'Something went wrong.'; }
                            })
                            .catch(() => { error = 'Connection error.'; })
                            .finally(() => { loading = false; });
                        " class="space-y-4">

                            <div class="flex flex-col sm:flex-row gap-3">
                                <input type="email" x-model="email" placeholder="Enter your email" required
                                    :disabled="loading || success"
                                    class="flex-1 px-5 py-4 rounded-lg text-base bg-white text-ink border-2 border-transparent focus:outline-none focus:border-indigo-500 transition" />

                                <button type="submit" :disabled="loading || success"
                                    x-text="loading ? 'Processing...' : success ? '✓ Sent!' : 'Get My 15% Off'"
                                    class="px-8 py-4 rounded-lg bg-indigo-600 text-white font-semibold text-base hover:bg-indigo-700 active:scale-95 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                </button>
                            </div>

                            <div x-show="success" x-transition
                                class="flex items-start gap-3 rounded-lg bg-green-50 border border-green-200 text-green-800 px-4 py-3">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <p class="font-semibold">Check your email!</p>
                                    <p class="text-sm mt-1">We've sent your 15% discount code. Redirecting to shop...
                                    </p>
                                </div>
                            </div>

                            <p x-show="error" x-text="error" x-transition class="text-sm text-rose-200 font-medium"></p>

                            <p class="text-xs text-white/70">
                                <svg class="inline w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Your data is safe. We'll never spam. Unsubscribe anytime.
                            </p>
                        </form>
                    </div>

                    <div data-reveal style="transition-delay: 400ms"
                        class="opacity-0 translate-y-3 transition duration-700 mt-6">
                        <a href="#benefits"
                            class="inline-flex items-center gap-2 text-white/80 hover:text-white text-sm font-medium transition">
                            <span>Learn more about BluShop</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- TRUST SIGNALS --}}
        <section class="bg-warm/60 py-8 sm:py-12 border-b border-beige">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8" data-reveal>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-indigo-600 mb-1">10,000+</div>
                        <div class="text-xs sm:text-sm text-gray-600">Happy Customers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-indigo-600 mb-1">4.8/5.0</div>
                        <div class="text-xs sm:text-sm text-gray-600">Average Rating</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-indigo-600 mb-1">35+</div>
                        <div class="text-xs sm:text-sm text-gray-600">Cities Served</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-bold text-indigo-600 mb-1">24/7</div>
                        <div class="text-xs sm:text-sm text-gray-600">Customer Support</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- BENEFITS --}}
        <section id="benefits" class="py-16 sm:py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-12" data-reveal>
                    <p class="text-xs tracking-[0.3em] uppercase text-gray-500 mb-3">Why Students Love Us</p>
                    <h2 class="text-3xl sm:text-4xl font-bold text-ink">Built for Your Campus Life</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div data-reveal class="text-center space-y-4">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-ink">Student-Friendly Pricing</h3>
                        <p class="text-sm text-gray-600">Quality essentials that won't break your budget</p>
                    </div>

                    <div data-reveal style="transition-delay: 100ms" class="text-center space-y-4">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-ink">Fast Campus Delivery</h3>
                        <p class="text-sm text-gray-600">Free shipping over ₫500k, delivered in 2-4 days</p>
                    </div>

                    <div data-reveal style="transition-delay: 200ms" class="text-center space-y-4">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-ink">Curated Quality</h3>
                        <p class="text-sm text-gray-600">Every item tested and approved by students</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- TESTIMONIALS --}}
        <section class="py-16 sm:py-24 bg-warm/40">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-12" data-reveal>
                    <p class="text-xs tracking-[0.3em] uppercase text-gray-500 mb-3">Student Reviews</p>
                    <h2 class="text-3xl sm:text-4xl font-bold text-ink">Real Stories, Real People</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                    $testimonials = [
                    ['quote' => 'Best student-friendly fashion I\'ve found. The quality is amazing for the price.',
                    'author' => 'Linh Nguyen', 'role' => '3rd Year Marketing'],
                    ['quote' => 'Fast delivery to my dorm. The hoodie became my daily go-to for campus.', 'author' =>
                    'Nam Tran', 'role' => 'CS Freshman'],
                    ['quote' => 'Finally, a brand that gets student life. Minimal, practical, affordable.', 'author' =>
                    'Thao Pham', 'role' => 'Architecture Student'],
                    ];
                    @endphp

                    @foreach($testimonials as $t)
                    <div data-reveal class="rounded-2xl border border-beige bg-white p-6">
                        <div class="flex items-center gap-1 mb-4">
                            @for($i = 0; $i < 5; $i++) <svg class="w-4 h-4 text-amber-400" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                @endfor
                        </div>
                        <p class="text-sm text-gray-700 mb-4">"{{ $t['quote'] }}"</p>
                        <div class="border-t border-beige pt-4">
                            <p class="text-sm font-semibold text-ink">{{ $t['author'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $t['role'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- FINAL CTA --}}
        <section class="py-20 sm:py-32 bg-gradient-to-br from-indigo-600 to-indigo-800 text-white">
            <div class="max-w-4xl mx-auto px-6 text-center" data-reveal>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-6">Ready to Upgrade Your Wardrobe?</h2>
                <p class="text-lg sm:text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                    Join 10,000+ students who've already discovered smarter shopping. Get your 15% welcome discount now.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#hero"
                        class="inline-flex items-center justify-center px-8 py-4 rounded-lg bg-white text-indigo-600 font-semibold hover:bg-gray-100 transition-colors duration-200">
                        Get My 15% Off Code
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center justify-center px-8 py-4 rounded-lg border-2 border-white text-white font-semibold hover:bg-white hover:text-indigo-600 transition-all duration-200">
                        Browse Without Discount
                    </a>
                </div>

                <p class="text-xs text-white/70 mt-6">Offer expires in 48 hours. One-time use per customer.</p>
            </div>
        </section>
    </main>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('[data-reveal]').forEach(el => observer.observe(el));
        });
    </script>
    @endpush
</x-app-layout>