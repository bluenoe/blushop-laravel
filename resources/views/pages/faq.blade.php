{{--
═══════════════════════════════════════════════════════════════
BluShop FAQ v2 - Minimalist Accordion
Concept: Clean lines, Expandable content, High readability
═══════════════════════════════════════════════════════════════
--}}

<x-app-layout>
    <main class="bg-white text-neutral-900 min-h-screen">

        {{-- 1. HERO HEADER --}}
        <section class="pt-24 pb-12 sm:pt-32 sm:pb-20 px-6 border-b border-neutral-100">
            <div class="max-w-[1400px] mx-auto text-center">
                <p class="text-[10px] uppercase tracking-[0.3em] font-bold text-neutral-400 mb-4" data-reveal>
                    Support Center
                </p>
                <h1 class="text-4xl md:text-6xl font-bold tracking-tighter mb-6" data-reveal
                    style="transition-delay: 100ms">
                    How can we help?
                </h1>
                <p class="text-neutral-500 font-light max-w-lg mx-auto leading-relaxed" data-reveal
                    style="transition-delay: 200ms">
                    Answers to the most common questions about shopping, shipping, and your BluShop account.
                </p>
            </div>
        </section>

        {{-- 2. FAQ ACCORDION --}}
        <section class="max-w-3xl mx-auto px-6 py-20 sm:py-24">

            {{-- Sử dụng Alpine để quản lý trạng thái mở/đóng --}}
            {{-- active: lưu index của câu hỏi đang mở --}}
            <div x-data="{ active: 0 }" class="space-y-0 border-t border-neutral-200">

                {{-- GROUP 1: SHOPPING --}}
                <div class="py-12" data-reveal>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-8">Shopping & Orders</h3>

                    {{-- Q1 --}}
                    <div class="border-b border-neutral-200">
                        <button @click="active = (active === 1 ? null : 1)"
                            class="w-full py-6 flex justify-between items-center text-left group hover:bg-neutral-50 transition px-2 -mx-2 rounded-lg sm:rounded-none sm:px-0 sm:mx-0 sm:hover:bg-transparent">
                            <span class="text-lg font-medium group-hover:text-black transition"
                                :class="active === 1 ? 'text-black' : 'text-neutral-700'">
                                How do I add items to the cart?
                            </span>
                            <span
                                class="ml-6 flex-shrink-0 text-2xl font-light leading-none transition-transform duration-300"
                                :class="active === 1 ? 'rotate-45' : ''">+</span>
                        </button>
                        <div x-show="active === 1" x-collapse
                            class="pb-8 text-neutral-500 font-light leading-relaxed pr-8">
                            <p>Simply navigate to any product page and click the black "ADD TO CART" button. You can
                                also use the "Quick Add" feature directly from the shop listing page by hovering over a
                                product image.</p>
                        </div>
                    </div>

                    {{-- Q2 --}}
                    <div class="border-b border-neutral-200">
                        <button @click="active = (active === 2 ? null : 2)"
                            class="w-full py-6 flex justify-between items-center text-left group hover:bg-neutral-50 transition px-2 -mx-2 rounded-lg sm:rounded-none sm:px-0 sm:mx-0 sm:hover:bg-transparent">
                            <span class="text-lg font-medium group-hover:text-black transition"
                                :class="active === 2 ? 'text-black' : 'text-neutral-700'">
                                Do you support wishlist?
                            </span>
                            <span
                                class="ml-6 flex-shrink-0 text-2xl font-light leading-none transition-transform duration-300"
                                :class="active === 2 ? 'rotate-45' : ''">+</span>
                        </button>
                        <div x-show="active === 2" x-collapse
                            class="pb-8 text-neutral-500 font-light leading-relaxed pr-8">
                            <p>Yes. You can tap the heart icon on any product card or detail page to save items for
                                later. To view your saved items, go to <span class="font-medium text-black">Profile →
                                    Wishlist</span>.</p>
                        </div>
                    </div>
                </div>

                {{-- GROUP 2: SHIPPING & RETURNS --}}
                <div id="shipping" class="py-4 scroll-mt-24" data-reveal>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-8">Shipping & Delivery
                    </h3>

                    {{-- Q3 --}}
                    <div class="border-b border-neutral-200">
                        <button @click="active = (active === 3 ? null : 3)"
                            class="w-full py-6 flex justify-between items-center text-left group hover:bg-neutral-50 transition px-2 -mx-2 rounded-lg sm:rounded-none sm:px-0 sm:mx-0 sm:hover:bg-transparent">
                            <span class="text-lg font-medium group-hover:text-black transition"
                                :class="active === 3 ? 'text-black' : 'text-neutral-700'">
                                Is there free shipping?
                            </span>
                            <span
                                class="ml-6 flex-shrink-0 text-2xl font-light leading-none transition-transform duration-300"
                                :class="active === 3 ? 'rotate-45' : ''">+</span>
                        </button>
                        <div x-show="active === 3" x-collapse
                            class="pb-8 text-neutral-500 font-light leading-relaxed pr-8">
                            <p>We offer <span class="font-medium text-black">Free Shipping</span> on all orders over
                                500,000₫. For orders under this amount, a flat rate shipping fee will be calculated at
                                checkout based on your location.</p>
                        </div>
                    </div>

                    {{-- Q4 (Thêm mẫu cho đầy đặn) --}}
                    <div class="border-b border-neutral-200">
                        <button @click="active = (active === 4 ? null : 4)"
                            class="w-full py-6 flex justify-between items-center text-left group hover:bg-neutral-50 transition px-2 -mx-2 rounded-lg sm:rounded-none sm:px-0 sm:mx-0 sm:hover:bg-transparent">
                            <span class="text-lg font-medium group-hover:text-black transition"
                                :class="active === 4 ? 'text-black' : 'text-neutral-700'">
                                How long does delivery take?
                            </span>
                            <span
                                class="ml-6 flex-shrink-0 text-2xl font-light leading-none transition-transform duration-300"
                                :class="active === 4 ? 'rotate-45' : ''">+</span>
                        </button>
                        <div x-show="active === 4" x-collapse
                            class="pb-8 text-neutral-500 font-light leading-relaxed pr-8">
                            <p>Standard delivery typically takes 2-4 business days within city areas and 3-7 business
                                days for other regions.</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        {{-- 3. STILL NEED HELP CTA --}}
        <section class="bg-neutral-50 py-24 text-center px-6">
            <div class="max-w-2xl mx-auto" data-reveal>
                <h2 class="text-3xl font-bold tracking-tight mb-4">Still need help?</h2>
                <p class="text-neutral-500 mb-8 font-light">
                    Can't find the answer you're looking for? Our team is here to help.
                </p>
                <a href="{{ route('contact.index') }}"
                    class="inline-block px-10 py-4 bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition transform hover:-translate-y-1">
                    Contact Support
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
                        entry.target.classList.remove('opacity-0', 'translate-y-4');
                        entry.target.classList.add('opacity-100', 'translate-y-0');
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