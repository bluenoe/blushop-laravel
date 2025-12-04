{{-- Landing Page (BluShop v2) --}}
<x-app-layout>
    @push('head')
    <link rel="preload" as="image" href="{{ asset('images/hero-bg.jpg') }}" fetchpriority="high">
    @endpush

    <main class="bg-white">
        {{-- HERO: editorial fashion vibe --}}
        <section x-data="{ bgLoaded: false }" x-init="(() => {
                const img = new Image();
                img.src = '{{ asset('images/hero-bg.jpg') }}';
                img.onload = () => { bgLoaded = true; };
            })()" class="relative overflow-hidden bg-slate-950 text-white">
            {{-- background image --}}
            <div class="absolute inset-0 bg-cover bg-center lg:bg-fixed transition-opacity duration-700"
                :class="bgLoaded ? 'opacity-100' : 'opacity-0'"
                style="background-image: url('{{ asset('images/hero-bg.jpg') }}');"></div>

            {{-- gradient overlay --}}
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/30"></div>

            {{-- skeleton while loading --}}
            <div class="absolute inset-0" x-show="!bgLoaded" x-transition.opacity x-cloak>
                <x-skeleton.image class="w-full h-full" />
            </div>

            {{-- content --}}
            <div class="relative z-20 max-w-7xl mx-auto px-6 py-16 sm:py-20 lg:py-24">
                <div class="grid gap-10 lg:grid-cols-[1.1fr,0.9fr] items-center">
                    {{-- Left: copy / USP --}}
                    <div>
                        <p data-reveal style="transition-delay: 150ms"
                            class="opacity-0 translate-y-2 transition duration-700 text-sm uppercase tracking-[0.22em] text-white/70">
                            BLUSHOP / DAILY ESSENTIALS
                        </p>

                        <h1 data-reveal style="transition-delay: 300ms"
                            class="opacity-0 translate-y-2 transition duration-700 mt-3 text-4xl sm:text-5xl lg:text-6xl font-semibold tracking-tight">
                            Minimal pieces<br class="hidden sm:block">
                            for everyday students.
                        </h1>

                        <p data-reveal style="transition-delay: 450ms"
                            class="opacity-0 translate-y-2 transition duration-700 mt-4 text-base sm:text-lg text-white/80 max-w-xl">
                            Curated Blu essentials designed to mix, match and survive 8AM classes, library marathons
                            and late-night coffee runs – without breaking your budget.
                        </p>

                        {{-- hero stats --}}
                        <dl data-reveal style="transition-delay: 550ms"
                            class="opacity-0 translate-y-2 transition duration-700 mt-6 flex flex-wrap gap-6 text-sm text-white/80">
                            <div>
                                <dt class="text-xs uppercase tracking-[0.22em] text-white/50">Students served</dt>
                                <dd class="mt-1 text-lg font-semibold">10k+</dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-[0.22em] text-white/50">Average rating</dt>
                                <dd class="mt-1 text-lg font-semibold">4.8 / 5.0</dd>
                            </div>
                            <div>
                                <dt class="text-xs uppercase tracking-[0.22em] text-white/50">Campuses</dt>
                                <dd class="mt-1 text-lg font-semibold">35+ cities</dd>
                            </div>
                        </dl>

                        <div data-reveal style="transition-delay: 650ms"
                            class="opacity-0 translate-y-2 transition duration-700 mt-8 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-full bg-white text-slate-950 font-semibold px-7 py-3 text-sm sm:text-base
                                      shadow-lg shadow-slate-900/30 hover:shadow-xl hover:scale-[1.03] transition">
                                Shop Blu collection
                            </a>

                            <a href="#section-new-in" class="inline-flex items-center justify-center rounded-full border border-white/70 text-white font-medium px-7 py-3 text-sm
                                      bg-white/5 hover:bg-white/10 backdrop-blur-sm transition">
                                View this week’s drops
                            </a>
                        </div>
                    </div>

                    {{-- Right: hero product collage --}}
                    <div data-reveal style="transition-delay: 450ms"
                        class="opacity-0 translate-y-3 transition duration-700">
                        <div class="grid grid-cols-2 gap-4 sm:gap-5">
                            <div class="space-y-4 sm:space-y-5">
                                <div
                                    class="rounded-3xl overflow-hidden bg-warm/90 border border-white/10 shadow-2xl shadow-black/40">
                                    <img src="{{ asset('images/hero-product-1.jpg') }}" alt="Blu tote & desk essentials"
                                        class="h-44 sm:h-56 w-full object-cover">
                                </div>
                                <div
                                    class="rounded-3xl overflow-hidden bg-warm/90 border border-white/10 shadow-xl shadow-black/40">
                                    <img src="{{ asset('images/hero-product-2.jpg') }}" alt="Minimal Blu bottle"
                                        class="h-36 sm:h-44 w-full object-cover">
                                </div>
                            </div>
                            <div class="space-y-4 sm:space-y-5 pt-8 sm:pt-10">
                                <div
                                    class="rounded-3xl overflow-hidden bg-warm/90 border border-white/10 shadow-2xl shadow-black/40">
                                    <img src="{{ asset('images/hero-product-3.jpg') }}" alt="Blu hoodie & campus gear"
                                        class="h-48 sm:h-64 w-full object-cover">
                                </div>

                                <div
                                    class="rounded-2xl border border-beige bg-warm/60 backdrop-blur-sm px-4 py-3 sm:px-5 sm:py-4">
                                    <p class="text-xs text-white/80">
                                        “Feels like a calm corner of the internet. Clean, simple and everything just
                                        works.”
                                    </p>
                                    <p class="mt-2 text-xs font-medium text-white/70">
                                        Minh Anh – CS Student, HCM
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- TRUST / HIGHLIGHTS --}}
        <section class="bg-white">
            <div class="max-w-7xl mx-auto px-6 py-10 sm:py-12">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                    <div data-reveal class="text-center lg:text-left">
                        <p class="text-xs uppercase tracking-[0.22em] text-gray-500">
                            WHY BLUSHOP
                        </p>
                        <h2 class="mt-2 text-xl sm:text-2xl font-semibold text-ink">
                            Built for students. Styled like a brand.
                        </h2>
                    </div>

                    @php
                    $highlights = [
                    ['title' => 'Calm shopping', 'desc' => 'Minimal interface, no pop-up chaos, just products.'],
                    ['title' => 'Student-friendly pricing', 'desc' => 'Blu pieces priced for real life, not runway.'],
                    ['title' => 'Fast, secure checkout', 'desc' => 'Modern, encrypted payment flow you can trust.'],
                    ['title' => 'Curated essentials', 'desc' => 'Every item picked to actually be used on campus.'],
                    ];
                    @endphp

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 w-full lg:w-auto">
                        @foreach($highlights as $h)
                        <article data-reveal
                            class="opacity-0 translate-y-2 transition duration-500 rounded-2xl border border-beige bg-white px-4 py-3 shadow-soft">
                            <h3 class="text-sm font-semibold text-ink">
                                {{ $h['title'] }}
                            </h3>
                            <p class="mt-1 text-xs text-gray-600">
                                {{ $h['desc'] }}
                            </p>
                        </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- NEW IN / FEATURED --}}
        <section id="section-new-in" class="bg-warm/60">
            <div class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
                <div class="flex items-end justify-between gap-4" data-reveal>
                    <div>
                        <p class="text-xs uppercase tracking-[0.22em] text-gray-600">
                            THIS WEEK
                        </p>
                        <h2 class="mt-2 text-2xl sm:text-3xl font-bold text-ink">
                            New in Blu.
                        </h2>
                        <p class="mt-1 text-sm text-gray-700 max-w-md">
                            A small curated drop of pieces students are actually reaching for right now.
                        </p>
                    </div>
                    <a href="{{ route('products.index') }}"
                        class="hidden sm:inline-flex text-indigo-600 text-sm font-medium hover:underline">
                        View full collection
                    </a>
                </div>

                @if(($featured ?? collect())->isEmpty())
                <div class="mt-6 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 p-4">
                    No featured products yet. Seed some data:
                    <code class="ml-1">php artisan db:seed --class=ProductSeeder</code>
                </div>
                @else
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($featured as $product)
                    <x-cart :product="$product" type="featured" :is-wished="in_array($product->id, $wishedIds ?? [])"
                        :spotlight="true" :imageOnly="true" />
                    @endforeach
                </div>
                @endif

                <div class="mt-6 sm:hidden text-center">
                    <a href="{{ route('products.index') }}"
                        class="inline-flex text-indigo-600 text-sm font-medium hover:underline">
                        View all products
                    </a>
                </div>
            </div>
        </section>

        {{-- SHOP BY EDIT / CATEGORY STYLE --}}
        <section class="bg-white">
            <div class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
                <div class="flex items-end justify-between gap-4" data-reveal>
                    <div>
                        <p class="text-xs uppercase tracking-[0.22em] text-gray-500">
                            CURATED EDITS
                        </p>
                        <h2 class="mt-2 text-2xl sm:text-3xl font-bold text-ink">
                            Build your Blu uniform.
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 max-w-md">
                            Browse by mood instead of product type. Pick an edit that matches your campus routine.
                        </p>
                    </div>
                </div>

                @php
                $collections = [
                [
                'name' => 'Lecture-ready',
                'desc' => 'Bags, bottles & sleeves that survive packed schedules and crowded buses.',
                'pill' => 'Everyday carry',
                ],
                [
                'name' => 'Desk & focus',
                'desc' => 'Stands, cables and little upgrades that make your study corner feel calm.',
                'pill' => 'Study setup',
                ],
                [
                'name' => 'Off-campus slow days',
                'desc' => 'Soft layers and cozy pieces for coffee shops, libraries and late walks.',
                'pill' => 'Lifestyle',
                ],
                ];
                @endphp

                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($collections as $c)
                    <article data-reveal
                        class="opacity-0 translate-y-2 transition duration-500 rounded-2xl bg-warm/40 border border-beige shadow-soft hover:shadow-lg hover:-translate-y-[2px]">
                        <div class="p-5 flex flex-col h-full">
                            <span
                                class="inline-flex items-center rounded-full bg-indigo-50 text-[11px] font-medium text-indigo-700 px-3 py-1">
                                {{ $c['pill'] }}
                            </span>
                            <h3 class="mt-4 text-lg font-semibold text-ink">
                                {{ $c['name'] }}
                            </h3>
                            <p class="mt-2 text-sm text-gray-700 leading-relaxed">
                                {{ $c['desc'] }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('products.index') }}"
                                    class="inline-flex items-center text-indigo-600 text-sm font-medium hover:underline">
                                    Shop this edit
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- SOCIAL PROOF / REVIEWS --}}
        <section class="bg-slate-950">
            <div class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
                <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-6">
                    <div data-reveal>
                        <p class="text-xs uppercase tracking-[0.22em] text-slate-400">
                            STUDENT REVIEWS
                        </p>
                        <h2 class="mt-2 text-2xl sm:text-3xl font-bold text-white">
                            What the Blu community is saying.
                        </h2>
                        <p class="mt-2 text-sm text-slate-300 max-w-md">
                            Real students, real timelines, real backpacks. No staged “perfect” lives – just useful gear.
                        </p>
                    </div>

                    <div data-reveal style="transition-delay: 150ms"
                        class="opacity-0 translate-y-2 transition duration-700 flex items-center gap-3 text-slate-200">
                        <div class="flex items-center gap-1">
                            @for($i = 0; $i < 5; $i++) <svg viewBox="0 0 24 24" class="h-4 w-4 text-amber-400"
                                aria-hidden="true">
                                <path
                                    d="M12 4.5 14.09 8.7l4.69.68-3.39 3.3.8 4.62L12 15.9 7.81 17.3l.8-4.62-3.39-3.3 4.69-.68L12 4.5Z"
                                    fill="currentColor" />
                                </svg>
                                @endfor
                        </div>
                        <span class="text-sm">
                            4.8 average rating from 500+ orders
                        </span>
                    </div>
                </div>

                @php
                $reviews = [
                [
                'name' => 'Linh, 3rd-year Marketing',
                'quote' => 'Feels like a friend curated my cart. Nothing loud, just pieces I actually use.',
                'tag' => 'Everyday carry',
                ],
                [
                'name' => 'Nam, CS freshman',
                'quote' => 'The site is calm. I came for one bottle, ended up staying to read the code.',
                'tag' => 'Learner / dev',
                ],
                [
                'name' => 'Thao, Architecture',
                'quote' => 'The “lecture-ready” edit basically solved my whole weekday outfit + gear problem.',
                'tag' => 'Lecture-ready',
                ],
                ];
                @endphp

                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($reviews as $r)
                    <figure data-reveal
                        class="opacity-0 translate-y-2 transition duration-500 rounded-2xl border border-slate-800 bg-slate-900/70 p-6 shadow-lg shadow-black/40">
                        <figcaption class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-white">
                                    {{ $r['name'] }}
                                </p>
                                <p
                                    class="mt-1 inline-flex items-center rounded-full bg-slate-800 text-[11px] text-slate-200 px-2 py-0.5">
                                    {{ $r['tag'] }}
                                </p>
                            </div>
                        </figcaption>
                        <p class="mt-4 text-sm text-slate-200 leading-relaxed">
                            “{{ $r['quote'] }}”
                        </p>
                    </figure>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- HOW IT WORKS (SHORT) --}}
        <section class="bg-white">
            <div class="max-w-5xl mx-auto px-6 py-12 sm:py-16">
                <h2 data-reveal class="text-2xl sm:text-3xl font-bold text-ink text-center">
                    How BluShop fits into your day.
                </h2>
                <p data-reveal style="transition-delay: 150ms"
                    class="opacity-0 translate-y-2 transition duration-700 mt-3 text-center text-sm text-gray-600 max-w-xl mx-auto">
                    Think of BluShop as a calm layer on top of your student life: browse, add to cart, and quietly
                    upgrade your everyday routine.
                </p>

                @php
                $steps = [
                [
                'title' => 'Browse clean edits',
                'desc' => 'No infinite carousels. Use a few focused edits or filters to discover pieces that match your
                routine.',
                ],
                [
                'title' => 'Build your Blu stack',
                'desc' => 'Add items to cart or wishlist as you go. Mix gear, desk items and lifestyle pieces.',
                ],
                [
                'title' => 'Check out & repeat',
                'desc' => 'Secure checkout, simple tracking, and then you’re back to shipping your own projects.',
                ],
                ];
                @endphp

                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($steps as $i => $step)
                    <article data-reveal
                        class="opacity-0 translate-y-2 transition duration-500 rounded-2xl border border-beige bg-white p-6 shadow-soft">
                        <div
                            class="flex items-center justify-center h-9 w-9 rounded-full bg-indigo-600 text-white text-sm font-semibold">
                            {{ $i + 1 }}
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-ink">
                            {{ $step['title'] }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-700 leading-relaxed">
                            {{ $step['desc'] }}
                        </p>
                    </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ABOUT + FINAL CTA --}}
        <section id="about-blushop" class="bg-warm/40">
            <div class="max-w-3xl mx-auto px-6 py-12 sm:py-16 text-center">
                <h2 data-reveal class="text-2xl sm:text-3xl font-bold text-ink">
                    Built for students. Designed for learning.
                </h2>
                <p data-reveal style="transition-delay: 200ms"
                    class="opacity-0 translate-y-2 transition duration-700 mt-4 text-gray-700 leading-relaxed">
                    BluShop is both a calm e-commerce experience and a learning sandbox. Behind every product card
                    is Laravel 11, Blade components, Vite and Tailwind – wired in a way that’s easy to read,
                    extend and break (in a good way). Browse like a customer, then explore the code like a dev.
                </p>

                <div data-reveal style="transition-delay: 350ms"
                    class="opacity-0 translate-y-2 transition duration-700 mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-8 py-3 text-sm sm:text-base font-semibold text-white
                              shadow-md shadow-indigo-500/40 hover:bg-indigo-700 hover:shadow-lg hover:scale-[1.03] transition">
                        Start shopping Blu
                    </a>
                    <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="inline-flex items-center justify-center rounded-full border border-indigo-200 bg-white px-8 py-3 text-sm sm:text-base font-medium text-indigo-700
                              hover:bg-indigo-50 transition">
                        Explore latest arrivals
                    </a>
                </div>
            </div>
        </section>
    </main>

    @include('partials.wishlist-script')
</x-app-layout>