{{-- resources/views/landing.blade.php --}}
@push('head')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('bluLanding', () => ({
            // ===== STATE =====
            active: 0,
            progress: 0,
            duration: 8000, // ms per slide
            heroTimer: null,
            railTimer: null,

            slides: [
                {
                    image: @json(asset('images/hero-bg.jpg')),
                    label: 'WINTER • 25',
                    title: 'Soft Blu layers.',
                    subtitle: 'Warm, quiet pieces for cold mornings.'
                },
                {
                    image: @json(asset('images/hero-bg2.jpg')),
                    label: 'EVERYDAY BLU',
                    title: 'Campus, all day.',
                    subtitle: 'From lecture to late coffee.'
                },
                {
                    image: @json(asset('images/hero-bg3.jpg')),
                    label: 'JUST BLU THINGS',
                    title: 'Little daily things.',
                    subtitle: 'Socks, bottles, totes & more.'
                },
            ],

            init() {
                this.startHero();
                this.startRail();
                this.setupReveal();
            },

            // ===== HERO SLIDER (AUTO) =====
            startHero() {
                this.stopHero();
                this.progress = 0;

                const steps = 120;
                const stepTime = this.duration / steps;

                this.heroTimer = setInterval(() => {
                    this.progress += 1 / steps;
                    if (this.progress >= 1) {
                        this.progress = 0;
                        this.nextSlide();
                    }
                }, stepTime);
            },
            stopHero() {
                if (this.heroTimer) {
                    clearInterval(this.heroTimer);
                    this.heroTimer = null;
                }
            },
            nextSlide() {
                this.active = (this.active + 1) % this.slides.length;
                this.progress = 0;
            },
            prevSlide() {
                this.active = (this.active - 1 + this.slides.length) % this.slides.length;
                this.progress = 0;
            },
            goToSlide(i) {
                this.active = i;
                this.progress = 0;
                this.startHero();
            },

            // ===== PRODUCT RAIL AUTO-SCROLL =====
            startRail() {
                this.stopRail();
                this.railTimer = setInterval(() => {
                    const rail = this.$refs.productRail;
                    if (!rail) return;

                    const step = rail.clientWidth * 0.55;
                    rail.scrollBy({ left: step, behavior: 'smooth' });

                    if (rail.scrollLeft + rail.clientWidth >= rail.scrollWidth - 32) {
                        setTimeout(() => {
                            rail.scrollTo({ left: 0, behavior: 'smooth' });
                        }, 600);
                    }
                }, 5200);
            },
            stopRail() {
                if (this.railTimer) {
                    clearInterval(this.railTimer);
                    this.railTimer = null;
                }
            },

            // ===== SCROLL REVEAL (NHẸ) =====
            setupReveal() {
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.remove('opacity-0', 'translate-y-6');
                            entry.target.classList.add('opacity-100', 'translate-y-0');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.14 });

                document.querySelectorAll('[data-reveal]').forEach(el => {
                    el.classList.add(
                        'opacity-0',
                        'translate-y-6',
                        'transition-all',
                        'duration-700'
                    );
                    observer.observe(el);
                });
            },

            // Smooth scroll
            scrollTo(id) {
                const el = document.getElementById(id);
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
            },
        }));
    });
</script>
@endpush

<x-app-layout>
    <div x-data="bluLanding()" x-init="init" class="bg-warm text-ink">
        <main>

            {{-- ================= HERO FULLSCREEN ================= --}}
            <section class="relative h-[88vh] md:h-[94vh] overflow-hidden">

                {{-- Background slides --}}
                <div class="absolute inset-0">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="active === index" x-transition:enter="transition ease-out duration-700"
                            x-transition:enter-start="opacity-0 scale-[1.02]"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" class="absolute inset-0">
                            <img :src="slide.image" alt="" class="w-full h-full object-cover object-center" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/10"></div>
                        </div>
                    </template>
                </div>

                {{-- Content --}}
                <div class="relative z-10 h-full">
                    <div class="max-w-7xl mx-auto h-full px-4 sm:px-6 lg:px-8 flex flex-col justify-between py-6">

                        {{-- Top line --}}
                        <div class="flex justify-between items-center text-[11px] text-white/75">
                            <span class="uppercase tracking-[0.22em]">BLUSHOP</span>
                            <button type="button" @click="scrollTo('rail')"
                                class="hidden sm:inline-flex items-center gap-1 hover:text-white">
                                Scroll
                                <svg class="h-3 w-3" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                    <path d="M5 8l5 5 5-5" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>

                        {{-- Center copy --}}
                        <div class="flex-1 flex items-center">
                            <div class="max-w-xl space-y-3">
                                <p class="text-[11px] font-semibold tracking-[0.28em] text-white/70"
                                    x-text="slides[active].label"></p>
                                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-[52px] leading-tight font-semibold text-white"
                                    x-text="slides[active].title"></h1>
                                <p class="text-sm md:text-base text-white/70 max-w-md" x-text="slides[active].subtitle">
                                </p>

                                <div class="flex flex-wrap items-center gap-3 pt-2">
                                    <a href="{{ route('home') }}"
                                        class="inline-flex items-center justify-center px-6 py-2.5 rounded-full bg-ink text-warm text-sm md:text-base font-medium shadow-soft hover:bg-black transition">
                                        Enter BluShop
                                    </a>
                                    <a href="{{ route('products.index') }}"
                                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-full bg-white/10 border border-white/35 text-xs md:text-sm text-white hover:bg-white/20 backdrop-blur">
                                        Shop collection
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Bottom: short line + controls + slide index --}}
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex items-center gap-3 text-[11px] text-white/70">
                                <span>Calm, everyday pieces.</span>
                                <span class="hidden sm:inline h-[1px] w-8 bg-white/30"></span>
                                <span class="hidden sm:inline" x-text="(active + 1) + ' / ' + slides.length"></span>
                            </div>

                            <div class="flex items-center gap-4 md:self-auto self-end">
                                {{-- Slide controls --}}
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="prevSlide()"
                                        class="h-8 w-8 rounded-full border border-white/40 text-white/80 flex items-center justify-center hover:bg-white/15">
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                            <path d="M12 5l-4 5 4 5" stroke-width="1.6" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                    <button type="button" @click="nextSlide()"
                                        class="h-8 w-8 rounded-full border border-white/40 text-white/80 flex items-center justify-center hover:bg-white/15">
                                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                            <path d="M8 5l4 5-4 5" stroke-width="1.6" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>

                                {{-- Dots --}}
                                <div class="flex items-center gap-1.5">
                                    <template x-for="(slide, index) in slides" :key="'dot-' + index">
                                        <button type="button" @click="goToSlide(index)"
                                            class="h-1.5 rounded-full transition-all duration-300"
                                            :class="active === index ? 'w-6 bg-white' : 'w-2 bg-white/40 hover:bg-white/70'"></button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- Progress bar --}}
                        <div class="mt-4 h-[2px] w-full bg-white/15 overflow-hidden rounded-full">
                            <div class="h-full bg-white"
                                :style="`width: ${Math.min(progress * 100, 100)}%; transition: width 80ms linear;`">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- =============== THIN INFO STRIP =============== --}}
            <section class="bg-warm border-b border-beige/70" data-reveal>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                    <div class="flex flex-wrap items-center justify-between gap-3 text-[11px] sm:text-xs text-muted">
                        <span>Designed in Viet Nam. Built for campus life.</span>
                        <span class="hidden sm:inline">Neutral, be–toned, easy to wear.</span>
                    </div>
                </div>
            </section>

            {{-- =============== CATEGORIES STRIP =============== --}}
            <section class="bg-warm py-8 md:py-10" data-reveal>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">
                    <div class="flex items-end justify-between gap-3">
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.28em] text-muted">CATEGORIES</p>
                            <h2 class="text-lg md:text-xl font-semibold text-ink">Pick your lane.</h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-5">
                        <a href="{{ route('products.index') }}"
                            class="group relative overflow-hidden rounded-3xl border border-beige bg-white/80 px-4 py-5 md:px-5 md:py-6 flex flex-col justify-between">
                            <div class="space-y-1">
                                <p class="text-xs uppercase tracking-[0.2em] text-muted">APPAREL</p>
                                <h3 class="text-base md:text-lg font-semibold text-ink">Tees & layers.</h3>
                            </div>
                            <span class="mt-3 text-[11px] text-muted group-hover:text-ink flex items-center gap-1">
                                Shop apparel
                                <span>→</span>
                            </span>
                        </a>

                        <a href="{{ route('products.index') }}"
                            class="group relative overflow-hidden rounded-3xl border border-beige bg-white/80 px-4 py-5 md:px-5 md:py-6 flex flex-col justify-between">
                            <div class="space-y-1">
                                <p class="text-xs uppercase tracking-[0.2em] text-muted">EVERYDAY</p>
                                <h3 class="text-base md:text-lg font-semibold text-ink">Bottles & totes.</h3>
                            </div>
                            <span class="mt-3 text-[11px] text-muted group-hover:text-ink flex items-center gap-1">
                                Daily carry
                                <span>→</span>
                            </span>
                        </a>

                        <a href="{{ route('products.index') }}"
                            class="group relative overflow-hidden rounded-3xl border border-beige bg-white/80 px-4 py-5 md:px-5 md:py-6 flex flex-col justify-between">
                            <div class="space-y-1">
                                <p class="text-xs uppercase tracking-[0.2em] text-muted">DESK</p>
                                <h3 class="text-base md:text-lg font-semibold text-ink">Stationery.</h3>
                            </div>
                            <span class="mt-3 text-[11px] text-muted group-hover:text-ink flex items-center gap-1">
                                Study setup
                                <span>→</span>
                            </span>
                        </a>
                    </div>
                </div>
            </section>

            {{-- =============== PRODUCT RAIL =============== --}}
            <section id="rail" class="bg-warm pb-9 md:pb-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 md:space-y-6">
                    <div class="flex items-end justify-between gap-3" data-reveal>
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.28em] text-muted">BLU PREVIEW</p>
                            <h2 class="text-lg md:text-xl font-semibold text-ink">New & loved.</h2>
                        </div>
                        <a href="{{ route('products.index') }}"
                            class="hidden sm:inline-flex items-center text-xs md:text-sm text-indigo-700 hover:text-indigo-800 underline-offset-2 hover:underline">
                            View all products →
                        </a>
                    </div>

                    @php
                    $railProducts = isset($landingProducts) && $landingProducts->count()
                    ? $landingProducts
                    : collect([
                    ['name' => 'Soft campus socks', 'price' => '199.000', 'tag' => 'Socks'],
                    ['name' => 'Frost sky bottle', 'price' => '329.000', 'tag' => 'Bottle'],
                    ['name' => 'Canvas tote', 'price' => '289.000', 'tag' => 'Tote'],
                    ['name' => 'Blu knit beanie', 'price' => '249.000', 'tag' => 'Beanie'],
                    ['name' => 'Minimal crewneck', 'price' => '449.000', 'tag' => 'Crew'],
                    ]);
                    @endphp

                    <div x-ref="productRail" @mouseover="stopRail()" @mouseleave="startRail()"
                        class="relative flex gap-4 overflow-x-auto no-scrollbar scroll-smooth snap-x snap-mandatory pb-3"
                        data-reveal>
                        @foreach($railProducts as $p)
                        <article class="snap-start shrink-0 w-[210px] sm:w-[230px] md:w-[250px]
                                       bg-white rounded-3xl shadow-soft hover:shadow-xl
                                       transition-transform duration-300 will-change-transform overflow-hidden">
                            <a href="{{ isset($p->id) ? route('products.show', $p->slug ?? $p->id) : route('products.index') }}"
                                class="block">
                                <div class="aspect-[4/3] bg-warm/60 overflow-hidden">
                                    @if(isset($p->image_url))
                                    <img src="{{ $p->image_url }}" alt="{{ $p->name }}"
                                        class="w-full h-full object-cover object-center hover:scale-105 transition-transform duration-500" />
                                    @else
                                    <img src="{{ asset('images/landing/rail-' . (($loop->index % 3) + 1) . '.jpg') }}"
                                        alt="{{ is_array($p) ? $p['name'] : $p->name }}"
                                        class="w-full h-full object-cover object-center hover:scale-105 transition-transform duration-500" />
                                    @endif
                                </div>
                            </a>
                            <div class="p-3.5 space-y-1">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-sm font-semibold text-ink truncate">
                                        {{ is_array($p) ? $p['name'] : $p->name }}
                                    </p>
                                    <span class="text-[10px] rounded-full bg-rosebeige/70 text-ink px-2 py-0.5">
                                        {{ is_array($p) ? $p['tag'] : 'Blu' }}
                                    </span>
                                </div>
                                <p class="text-sm font-semibold text-ink">
                                    {{ is_array($p)
                                    ? $p['price'] . 'đ'
                                    : number_format($p->unit_price ?? $p->price ?? 0, 0, ',', '.') . 'đ' }}
                                </p>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    <div class="flex justify-center sm:hidden pt-1">
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center text-xs text-indigo-700 hover:text-indigo-800 underline-offset-2 hover:underline">
                            View all products →
                        </a>
                    </div>
                </div>
            </section>

            {{-- =============== STORY + LOOKBOOK =============== --}}
            <section class="bg-warm pb-10 md:pb-14" data-reveal>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid gap-6 md:gap-10 md:grid-cols-[minmax(0,1.05fr)_minmax(0,1fr)] items-start">
                        <div class="space-y-4 md:space-y-5">
                            <p class="text-[11px] uppercase tracking-[0.28em] text-muted">STORY</p>
                            <h2 class="text-xl md:text-2xl font-semibold text-ink">
                                Designed in Viet Nam, made for campus.
                            </h2>
                            <p class="text-sm md:text-base text-muted max-w-md">
                                Blu is about quiet confidence — warm layers, neutral tones, and small objects you carry
                                every day.
                            </p>
                            <p class="text-sm text-muted max-w-md">
                                One calm place for tees, crews, socks, bottles, totes and stationery that actually
                                match.
                            </p>
                        </div>

                        <div class="grid gap-3 md:gap-4">
                            <div class="relative overflow-hidden rounded-3xl bg-ink/5 aspect-[4/5]">
                                <img src="{{ asset('images/landing/lookbook-1.jpg') }}" alt="Blu lookbook outfit"
                                    class="w-full h-full object-cover object-center" />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent">
                                </div>
                                <span
                                    class="absolute bottom-3 left-3 text-[11px] text-warm/90 uppercase tracking-[0.18em]">
                                    LOOKBOOK • FW
                                </span>
                            </div>
                            <div class="relative overflow-hidden rounded-3xl bg-ink/5 aspect-[16/9] md:aspect-[3/2]">
                                <img src="{{ asset('images/landing/lookbook-2.jpg') }}" alt="Blu desk setup"
                                    class="w-full h-full object-cover object-center" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/35 via-black/5 to-transparent">
                                </div>
                                <span
                                    class="absolute bottom-3 left-3 text-[11px] text-warm/90 uppercase tracking-[0.18em]">
                                    DESK • STATIONERY
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- =============== FINAL CTA =============== --}}
            <section class="bg-warm pb-12 md:pb-16" data-reveal>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="rounded-3xl border border-beige bg-white/85 backdrop-blur px-5 py-6 md:px-8 md:py-8
                               flex flex-col md:flex-row items-start md:items-center justify-between gap-4 md:gap-8">
                        <div class="space-y-2 max-w-xl">
                            <p class="text-[11px] uppercase tracking-[0.28em] text-muted">BLUSHOP</p>
                            <h3 class="text-lg md:text-xl font-semibold text-ink">
                                Your quiet campus wardrobe.
                            </h3>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center justify-center px-6 py-2.5 rounded-full bg-ink text-warm text-sm md:text-base font-medium shadow-soft hover:bg-black transition">
                                Enter BluShop
                            </a>
                            <a href="{{ route('products.index') }}"
                                class="inline-flex items-center justify-center px-5 py-2.5 rounded-full border border-ink/20 text-sm text-ink hover:bg-warm/80">
                                Browse all
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</x-app-layout>