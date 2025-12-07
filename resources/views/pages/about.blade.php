{{--
═══════════════════════════════════════════════════════════════
BluShop About Page v3 - Editorial Minimalist
Concept: Visual Storytelling, High Contrast, Clean Typography
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    <main class="bg-white text-neutral-900 selection:bg-black selection:text-white">

        {{-- 1. HERO HEADER: Big Statement --}}
        <section class="pt-24 pb-12 sm:pt-32 sm:pb-20 px-6 border-b border-neutral-100">
            <div class="max-w-[1400px] mx-auto">
                <div class="max-w-4xl" data-reveal>
                    <p class="text-[10px] uppercase tracking-[0.3em] font-bold text-neutral-400 mb-6 pl-1">
                        Est. 2025 • Saigon
                    </p>
                    <h1 class="text-5xl sm:text-7xl lg:text-8xl font-bold tracking-tighter leading-[0.9] mb-8">
                        Quietly <br>
                        <span class="font-serif italic font-light ml-2 sm:ml-4 text-neutral-500">Confident.</span>
                    </h1>
                    <p
                        class="text-lg sm:text-2xl font-light text-neutral-800 leading-relaxed max-w-2xl pl-1 border-l-2 border-black pl-6 mt-12">
                        We design wardrobe staples that feel effortless. Muted tones, soft textures, and silhouettes
                        that never scream for attention — they just feel right.
                    </p>
                </div>
            </div>
        </section>

        {{-- 2. THE STORY: Editorial Layout --}}
        <section class="py-20 sm:py-32">
            <div class="max-w-[1400px] mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24 items-start">

                    {{-- Left: Image (Parallax feel) --}}
                    <div class="relative group" data-reveal>
                        <div class="aspect-[4/5] overflow-hidden bg-neutral-100 relative">
                            {{-- Placeholder Image --}}
                            <img src="{{ asset('images/about/story-hero.jpg') }}"
                                onerror="this.src='https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=1200&auto=format&fit=crop'"
                                alt="BluShop Studio"
                                class="w-full h-full object-cover grayscale transition duration-[1.5s] group-hover:grayscale-0 group-hover:scale-105"
                                loading="lazy">
                        </div>
                        {{-- Caption --}}
                        <div class="mt-4 flex justify-between text-[10px] uppercase tracking-widest text-neutral-400">
                            <span>The Studio</span>
                            <span>DN — VN</span>
                        </div>
                    </div>

                    {{-- Right: Content --}}
                    <div class="lg:pt-20 space-y-12" data-reveal>
                        <div>
                            <h2 class="text-3xl font-bold tracking-tight mb-6">Born in Saigon.</h2>
                            <div class="space-y-6 text-neutral-600 font-light text-lg leading-relaxed">
                                <p>
                                    BluShop began with a simple question: Why is it so hard to find high-quality basics
                                    that don't cost a fortune?
                                </p>
                                <p>
                                    We stripped away the loud logos and the retail markups. Instead, we focused on the
                                    weight of the hoodie, the finish of a button, and the cut of a tee.
                                </p>
                                <p>
                                    Built for calm mornings, late-night work sessions, and everything in between. We
                                    keep the palette grounded so you can mix, match, and rewear without thinking twice.
                                </p>
                            </div>
                        </div>

                        {{-- Stats Row (Clean) --}}
                        <div class="grid grid-cols-3 gap-8 border-t border-neutral-200 pt-12">
                            <div>
                                <span class="block text-4xl font-bold tracking-tighter mb-1">2025</span>
                                <span class="text-[10px] uppercase tracking-widest text-neutral-400">Founded</span>
                            </div>
                            <div>
                                <span class="block text-4xl font-bold tracking-tighter mb-1">50+</span>
                                <span class="text-[10px] uppercase tracking-widest text-neutral-400">Essentials</span>
                            </div>
                            <div>
                                <span class="block text-4xl font-bold tracking-tighter mb-1">10k</span>
                                <span class="text-[10px] uppercase tracking-widest text-neutral-400">Community</span>
                            </div>
                        </div>

                        {{-- Signature --}}
                        <div class="pt-8">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/Signature_sample.svg/1200px-Signature_sample.svg.png"
                                alt="Signature" class="h-12 opacity-30 invert-0">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. VALUES: 3-Column Minimal Grid --}}
        <section class="bg-neutral-50 py-24 border-y border-neutral-200">
            <div class="max-w-[1400px] mx-auto px-6">
                <div class="mb-16 md:text-center max-w-2xl mx-auto" data-reveal>
                    <span
                        class="text-[10px] uppercase tracking-[0.3em] font-bold text-neutral-400 block mb-4">Philosophy</span>
                    <h2 class="text-3xl md:text-4xl font-bold tracking-tight">Built to be worn,<br> not just posted.
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    {{-- Value 1 --}}
                    <div class="group" data-reveal>
                        <div
                            class="w-12 h-12 bg-white border border-neutral-200 flex items-center justify-center mb-6 group-hover:bg-black group-hover:text-white transition duration-300">
                            <span class="font-serif italic text-xl">01</span>
                        </div>
                        <h3 class="text-sm font-bold uppercase tracking-widest mb-4">Fabric First</h3>
                        <p class="text-neutral-500 font-light leading-relaxed">
                            Soft-touch blends and breathable weaves. Tested across real routines—commute, café, and
                            coding sessions.
                        </p>
                    </div>

                    {{-- Value 2 --}}
                    <div class="group" data-reveal style="transition-delay: 100ms">
                        <div
                            class="w-12 h-12 bg-white border border-neutral-200 flex items-center justify-center mb-6 group-hover:bg-black group-hover:text-white transition duration-300">
                            <span class="font-serif italic text-xl">02</span>
                        </div>
                        <h3 class="text-sm font-bold uppercase tracking-widest mb-4">Warm Neutrals</h3>
                        <p class="text-neutral-500 font-light leading-relaxed">
                            A signature palette of beige, ink, and stone. Colors that quietly match your day instead of
                            shouting over it.
                        </p>
                    </div>

                    {{-- Value 3 --}}
                    <div class="group" data-reveal style="transition-delay: 200ms">
                        <div
                            class="w-12 h-12 bg-white border border-neutral-200 flex items-center justify-center mb-6 group-hover:bg-black group-hover:text-white transition duration-300">
                            <span class="font-serif italic text-xl">03</span>
                        </div>
                        <h3 class="text-sm font-bold uppercase tracking-widest mb-4">Small Batch</h3>
                        <p class="text-neutral-500 font-light leading-relaxed">
                            Limited runs help us listen, learn, and refine what you actually love. Less waste, more
                            intention.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. TEAM / CAREER CTA --}}
        <section class="py-32 text-center px-6">
            <div class="max-w-2xl mx-auto" data-reveal>
                <h2 class="text-4xl md:text-5xl font-bold tracking-tighter mb-8">Join the Movement</h2>
                <p class="text-neutral-500 text-lg font-light mb-10">
                    We are always looking for creative minds to help us redefine student essentials.
                </p>
                <a href="{{ route('contact.index') }}"
                    class="inline-block px-10 py-4 bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition transform hover:-translate-y-1">
                    Get in Touch
                </a>
            </div>
        </section>

    </main>

    {{-- Script Reveal Effect (Nếu chưa có trong layout chính) --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', 'translate-y-8');
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('[data-reveal]').forEach(el => {
                el.classList.add('opacity-0', 'translate-y-8', 'transition-all', 'duration-1000', 'ease-out');
                observer.observe(el);
            });
        });
    </script>
    @endpush
</x-app-layout>