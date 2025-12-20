{{--
═══════════════════════════════════════════════════════════════
BluShop Careers - Editorial
═══════════════════════════════════════════════════════════════
--}}
<x-app-layout>
    <main class="bg-white text-neutral-900">

        {{-- HERO SECTION --}}
        <section class="pt-32 pb-20 px-6 sm:px-12 border-b border-neutral-100">
            <div class="max-w-[1400px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24">

                {{-- Left: Title --}}
                <div class="lg:col-span-7" data-reveal>
                    <p class="text-[10px] uppercase tracking-[0.3em] font-bold text-neutral-400 mb-8">Careers</p>
                    <h1 class="text-6xl sm:text-8xl font-bold tracking-tighter leading-none mb-10">
                        JOIN THE <br> ATELIER
                    </h1>
                </div>

                {{-- Right: Intro --}}
                <div class="lg:col-span-5 flex items-end" data-reveal style="transition-delay: 100ms">
                    <p class="text-lg text-neutral-600 font-light leading-relaxed mb-6">
                        We are a collective of designers, engineers, and storytellers building the future of digital
                        retail.
                        If you obsess over details and believe in quality over quantity, you belong here.
                    </p>
                </div>
            </div>
        </section>

        {{-- JOB LIST --}}
        <section class="py-24 px-6 sm:px-12 max-w-[1400px] mx-auto">
            <h2 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-12" data-reveal>Open Positions
            </h2>

            <div class="border-t border-neutral-200">
                {{-- Job 1 --}}
                <div class="group grid grid-cols-1 md:grid-cols-12 gap-6 py-10 border-b border-neutral-200 items-baseline hover:bg-neutral-50 transition duration-300 px-4 -mx-4 cursor-pointer"
                    data-reveal>
                    <div class="md:col-span-4 text-xs font-bold uppercase tracking-widest text-neutral-400">Design</div>
                    <div
                        class="md:col-span-6 text-2xl font-medium tracking-tight group-hover:pl-4 transition-all duration-300">
                        Senior Fashion Buyer</div>
                    <div class="md:col-span-2 text-right">
                        <span
                            class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest border-b border-transparent group-hover:border-black transition-all">
                            Apply <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </span>
                    </div>
                </div>

                {{-- Job 2 --}}
                <div class="group grid grid-cols-1 md:grid-cols-12 gap-6 py-10 border-b border-neutral-200 items-baseline hover:bg-neutral-50 transition duration-300 px-4 -mx-4 cursor-pointer"
                    data-reveal>
                    <div class="md:col-span-4 text-xs font-bold uppercase tracking-widest text-neutral-400">Creative
                    </div>
                    <div
                        class="md:col-span-6 text-2xl font-medium tracking-tight group-hover:pl-4 transition-all duration-300">
                        Visual Merchandiser</div>
                    <div class="md:col-span-2 text-right">
                        <span
                            class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest border-b border-transparent group-hover:border-black transition-all">
                            Apply <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </span>
                    </div>
                </div>

                {{-- Job 3 --}}
                <div class="group grid grid-cols-1 md:grid-cols-12 gap-6 py-10 border-b border-neutral-200 items-baseline hover:bg-neutral-50 transition duration-300 px-4 -mx-4 cursor-pointer"
                    data-reveal>
                    <div class="md:col-span-4 text-xs font-bold uppercase tracking-widest text-neutral-400">Engineering
                    </div>
                    <div
                        class="md:col-span-6 text-2xl font-medium tracking-tight group-hover:pl-4 transition-all duration-300">
                        Frontend Developer</div>
                    <div class="md:col-span-2 text-right">
                        <span
                            class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest border-b border-transparent group-hover:border-black transition-all">
                            Apply <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </span>
                    </div>
                </div>

                {{-- Job 4 --}}
                <div class="group grid grid-cols-1 md:grid-cols-12 gap-6 py-10 border-b border-neutral-200 items-baseline hover:bg-neutral-50 transition duration-300 px-4 -mx-4 cursor-pointer"
                    data-reveal>
                    <div class="md:col-span-4 text-xs font-bold uppercase tracking-widest text-neutral-400">Marketing
                    </div>
                    <div
                        class="md:col-span-6 text-2xl font-medium tracking-tight group-hover:pl-4 transition-all duration-300">
                        Brand Storyteller</div>
                    <div class="md:col-span-2 text-right">
                        <span
                            class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-widest border-b border-transparent group-hover:border-black transition-all">
                            Apply <span class="group-hover:translate-x-1 transition-transform">→</span>
                        </span>
                    </div>
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