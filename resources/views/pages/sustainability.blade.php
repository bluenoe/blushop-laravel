{{--
═══════════════════════════════════════════════════════════════
BluShop Sustainability - Editorial
═══════════════════════════════════════════════════════════════
--}}
<x-app-layout>
    <main class="bg-white text-neutral-900 selection:bg-black selection:text-white">

        {{-- HERO SECTION --}}
        <section class="min-h-[80vh] flex items-center justify-center px-6 border-b border-neutral-100">
            <div class="max-w-[1600px] text-center" data-reveal>
                <p class="text-[10px] uppercase tracking-[0.4em] font-bold text-neutral-400 mb-8">Role: Responsibility
                </p>
                <h1 class="text-6xl sm:text-8xl lg:text-9xl font-bold tracking-tighter leading-none mb-10">
                    CONSCIOUS<br>CRAFTSMANSHIP
                </h1>
                <div class="w-px h-24 bg-black mx-auto"></div>
            </div>
        </section>

        {{-- MISSION STATEMENT --}}
        <section class="py-24 sm:py-40 px-6">
            <div class="max-w-[1400px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-32 items-center">
                <div class="text-4xl sm:text-5xl font-light tracking-tight leading-tight" data-reveal>
                    We believe luxury lies in <span class="font-serif italic text-neutral-500">longevity</span>.
                    Creating less, but creating better.
                </div>
                <div class="text-lg text-neutral-600 font-light leading-relaxed space-y-6" data-reveal>
                    <p>
                        The fashion industry is noisy. We choose silence. Our approach is grounded in a deep respect for
                        materials and the hands that shape them.
                    </p>
                    <p>
                        Every garment is designed to solve a problem, not create one. We don't chase trends; we build
                        archives. Our commitment is to a wardrobe that serves you for years, not weeks.
                    </p>
                </div>
            </div>
        </section>

        {{-- PILLARS GRID --}}
        <section class="border-t border-neutral-100">
            <div class="grid grid-cols-1 lg:grid-cols-3 divide-y lg:divide-y-0 lg:divide-x divide-neutral-100">

                {{-- Pillar 1 --}}
                <div class="group p-12 lg:p-20 hover:bg-neutral-50 transition duration-700" data-reveal>
                    <span
                        class="block text-6xl font-serif italic text-neutral-200 group-hover:text-black transition duration-500 mb-8">01</span>
                    <h3 class="text-lg font-bold uppercase tracking-[0.2em] mb-4">Ethical Sourcing</h3>
                    <p class="text-neutral-500 font-light leading-relaxed">
                        We map our supply chain down to the fiber. Partnering only with factories that uphold the
                        highest standards of fair labor and safety.
                    </p>
                </div>

                {{-- Pillar 2 --}}
                <div class="group p-12 lg:p-20 hover:bg-neutral-50 transition duration-700" data-reveal
                    style="transition-delay: 100ms">
                    <span
                        class="block text-6xl font-serif italic text-neutral-200 group-hover:text-black transition duration-500 mb-8">02</span>
                    <h3 class="text-lg font-bold uppercase tracking-[0.2em] mb-4">Zero Waste</h3>
                    <p class="text-neutral-500 font-light leading-relaxed">
                        Refining our patterns to minimize off-cuts. Repurposing fabric scraps into accessories or
                        packaging. Nothing is wasted.
                    </p>
                </div>

                {{-- Pillar 3 --}}
                <div class="group p-12 lg:p-20 hover:bg-neutral-50 transition duration-700" data-reveal
                    style="transition-delay: 200ms">
                    <span
                        class="block text-6xl font-serif italic text-neutral-200 group-hover:text-black transition duration-500 mb-8">03</span>
                    <h3 class="text-lg font-bold uppercase tracking-[0.2em] mb-4">Timeless Design</h3>
                    <p class="text-neutral-500 font-light leading-relaxed">
                        We reject planned obsolescence. Our palettes are neutral, our cuts are classic, and our quality
                        ensures they last a lifetime.
                    </p>
                </div>

            </div>
        </section>

        {{-- CTA FOOTER --}}
        <section class="py-32 text-center bg-black text-white">
            <div class="max-w-2xl mx-auto" data-reveal>
                <h2 class="text-3xl font-bold tracking-tight mb-8">Transparency Report 2025</h2>
                <a href="#"
                    class="inline-block border-b border-white pb-1 text-sm uppercase tracking-widest hover:opacity-50 transition">Download
                    PDF</a>
            </div>
        </section>

    </main>

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