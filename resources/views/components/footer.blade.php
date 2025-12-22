<footer class="bg-white border-t border-neutral-100 pt-32 pb-16 text-neutral-900" role="contentinfo">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-8">

        {{-- TOP GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-8 mb-24">

            {{-- 1. BRAND (Left) --}}
            <div class="md:col-span-4 lg:col-span-3 space-y-6">
                <a href="{{ route('home') }}" class="inline-block" aria-label="BluShop Home">
                    <span class="font-bold text-2xl tracking-tighter">BLUSHOP.</span>
                </a>

                <p class="text-xs text-neutral-500 leading-relaxed max-w-xs font-light">
                    Timeless silhouettes. Uncompromising quality. <br>
                    Elevated essentials for the modern wardrobe.
                </p>
            </div>

            {{-- 2. LINKS (Center - Flexible) --}}
            <div class="md:col-span-8 lg:col-span-6 grid grid-cols-2 sm:grid-cols-3 gap-10 lg:pl-12">

                {{-- Shop --}}
                <div class="space-y-6">
                    <h3 class="text-[10px] uppercase tracking-[0.2em] font-bold">Shop</h3>
                    <ul class="space-y-3 text-sm font-light text-neutral-500">
                        <li><a href="{{ route('new-arrivals') }}"
                                class="hover:text-black hover:underline underline-offset-4 transition-colors">New
                                Arrivals</a></li>
                        <li><a href="{{ route('products.index') }}"
                                class="hover:text-black hover:underline underline-offset-4 transition-colors">All
                                Products</a></li>
                        <li><a href="{{ route('best-sellers') }}"
                                class="hover:text-black hover:underline underline-offset-4 transition-colors">Best
                                Sellers</a></li>
                        <li><a href="{{ route('on-sale') }}"
                                class="hover:text-black hover:underline underline-offset-4 transition-colors">Sale</a>
                        </li>
                    </ul>
                </div>

                {{-- Support --}}
                <div class="space-y-6">
                    <h3 class="text-[10px] uppercase tracking-[0.2em] font-bold">Support</h3>
                    <ul class="space-y-3 text-sm font-light text-neutral-500">
                        <li><a href="{{ route('orders.index') }}"
                                class="hover:text-black hover:underline underline-offset-4 transition-colors">Order
                                Status</a></li>
                        <li><a href="{{ route('faq') }}#shipping"
                                class="hover:text-black hover:underline underline-offset-4 transition-colors">Shipping</a>
                        </li>
                        <li><a href="{{ route('faq') . '#shipping' }}"
                                class="hover:text-black hover:underline underline-offset-4 transition-colors">FAQ</a>
                        </li>
                        <li><a href="{{ route('contact.index') }}"
                                class="hover:text-black hover:underline underline-offset-4 transition-colors">Contact</a>
                        </li>
                    </ul>
                </div>

                {{-- Legal / Company --}}
                <div class="space-y-6">
                    <h3 class="text-[10px] uppercase tracking-[0.2em] font-bold">Company</h3>
                    <ul class="space-y-3 text-sm font-light text-neutral-500">
                        <li><a href="{{ route('about') }}"
                                class="hover:text-black hover:underline underline-offset-4 transition-colors">About</a>
                        </li>
                        <li><a href="{{ route('sustainability') }}"
                                class="hover:text-black hover:underline underline-offset-4 transition-colors">Sustainability</a>
                        </li>
                        <li><a href="{{ route('careers') }}"
                                class="hover:text-black hover:underline underline-offset-4 transition-colors">Careers</a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- 3. NEWSLETTER (Right) --}}
            <div class="md:col-span-12 lg:col-span-3 mt-12 lg:mt-0 lg:text-right">
                @unless(request()->routeIs('home'))
                <div class="flex flex-col lg:items-end">
                    <h3 class="text-[10px] uppercase tracking-[0.2em] font-bold mb-6">Newsletter</h3>

                    <form x-data="{
                            email: '',
                            status: null,
                            message: '',
                            loading: false,
                            timer: null,
                            submitForm() {
                                if (this.timer) clearTimeout(this.timer);
                                this.status = null;
                                this.message = '';

                                if (!this.email || !this.email.includes('@')) {
                                    this.status = 'error';
                                    this.message = 'Invalid email.';
                                    this.autoDismiss();
                                    return;
                                }
                                this.loading = true;
                                fetch('{{ route('newsletter.subscribe') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ email: this.email })
                                })
                                .then(async response => {
                                    this.loading = false;
                                    const data = await response.json();
                                    this.status = response.ok ? 'success' : 'error';
                                    this.message = response.ok ? data.message : (data.errors?.email?.[0] || 'Error');
                                    if(response.ok) this.email = '';
                                    this.autoDismiss();
                                })
                                .catch(() => {
                                    this.loading = false;
                                    this.status = 'error';
                                    this.message = 'Connection error.';
                                    this.autoDismiss();
                                });
                            },
                            autoDismiss() {
                                this.timer = setTimeout(() => { this.status = null; }, 4000);
                            }
                        }" @submit.prevent="submitForm()" class="relative w-full max-w-sm lg:ml-auto">

                        {{-- High Contrast Input Group --}}
                        <div class="flex gap-0">
                            <input type="email" placeholder="Email address" x-model="email"
                                class="w-full bg-neutral-100 border-none px-4 py-3 text-sm focus:ring-1 focus:ring-black placeholder:text-neutral-500 font-medium">
                            <button type="submit"
                                class="bg-black text-white px-6 py-3 text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition-colors shrink-0">
                                <span x-show="!loading">Join</span>
                                <span x-show="loading">...</span>
                            </button>
                        </div>

                        {{-- Notifications --}}
                        <div class="absolute top-full right-0 mt-2 text-xs" x-cloak>
                            <span x-show="status === 'success'" class="text-green-600 block font-medium"
                                x-text="message" x-transition></span>
                            <span x-show="status === 'error'" class="text-red-600 block font-medium" x-text="message"
                                x-transition></span>
                        </div>
                    </form>
                </div>
                @endunless

                {{-- Socials (Horizontal) --}}
                <div class="mt-12 flex flex-col lg:items-end">
                    <h3 class="text-[10px] uppercase tracking-[0.2em] font-bold mb-6 lg:hidden">Follow Us</h3>
                    <div class="flex gap-6 items-center">
                        <a href="#" class="text-neutral-400 hover:text-black transition-colors" aria-label="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="#" class="text-neutral-400 hover:text-black transition-colors" aria-label="TikTok">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                            </svg>
                        </a>
                        <a href="#" class="text-neutral-400 hover:text-black transition-colors" aria-label="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        {{-- BOTTOM BAR --}}
        <div
            class="flex flex-col-reverse md:flex-row justify-between items-center gap-8 pt-8 border-t border-neutral-100">

            {{-- Copyright & Location --}}
            <div class="text-center md:text-left">
                <p class="text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400">
                    &copy; {{ date('Y') }} BluShop.
                </p>
            </div>

            {{-- Payment Methods (Grayscale) --}}
            <div
                class="flex gap-3 grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition-all duration-700">
                <svg class="h-5 w-auto" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="32" rx="2" fill="white" stroke="#e5e5e5" />
                    <path
                        d="M20.146 21.845h-2.882l1.803-11.177h2.882l-1.803 11.177zm-5.55-11.177l-2.762 7.644-.323-1.644-1.074-5.527s-.13-.473-.755-.473H5.528l-.044.14s1.147.239 2.488.992l2.065 7.957h3.005l4.604-11.089h-3.001zM38.67 21.845h2.647l-2.309-11.177h-2.432c-.502 0-.627.388-.627.388l-4.313 10.789h3.005l.596-1.658h3.667l.346 1.658zm-3.184-3.944l1.506-4.161.862 4.161h-2.368zm-6.288-5.175l.417-2.421s-1.292-.489-2.647-.489c-1.463 0-4.938.64-4.938 3.754 0 2.933 4.087 2.968 4.087 4.51 0 1.542-3.667 1.265-4.875.293l-.43 2.507s1.305.64 3.302.64c1.998 0 5.063-.835 5.063-3.884 0-2.946-4.13-3.238-4.13-4.51 0-1.272 2.993-1.056 4.151-.4z"
                        fill="#1434CB" />
                </svg>
                <svg class="h-5 w-auto" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="32" rx="2" fill="white" stroke="#e5e5e5" />
                    <circle cx="18" cy="16" r="8" fill="#EB001B" />
                    <circle cx="30" cy="16" r="8" fill="#F79E1B" />
                    <path d="M24 9.6c-1.6 1.4-2.6 3.4-2.6 5.6s1 4.2 2.6 5.6c1.6-1.4 2.6-3.4 2.6-5.6s-1-4.2-2.6-5.6z"
                        fill="#FF5F00" />
                </svg>
                <svg class="h-5 w-auto" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="32" rx="2" fill="white" stroke="#e5e5e5" />
                    <path
                        d="M20.905 9h-5.526c-.384 0-.712.28-.772.662l-2.274 14.42c-.046.29.175.554.47.554h2.73c.384 0 .712-.28.772-.662l.614-3.893c.06-.382.388-.662.772-.662h1.778c3.702 0 5.842-1.792 6.397-5.347.25-1.553.011-2.773-.708-3.626-.791-.938-2.195-1.446-4.063-1.446zm.649 5.266c-.305 2.002-1.833 2.002-3.31 2.002h-.841l.59-3.738c.035-.229.234-.399.464-.399h.39c1.017 0 1.977 0 2.472.579.297.347.385.86.235 1.556z"
                        fill="#003087" />
                    <path
                        d="M33.905 14.217h-2.738c-.23 0-.429.17-.464.399l-.119.755-.189-.274c-.586-.85-1.892-1.134-3.197-1.134-2.99 0-5.543 2.266-6.039 5.445-.258 1.586.11 3.1 1.008 4.153.826.967 2.004 1.368 3.407 1.368 2.409 0 3.745-1.548 3.745-1.548l-.121.753c-.046.29.175.554.47.554h2.467c.384 0 .712-.28.772-.662l1.456-9.219c.046-.29-.175-.554-.47-.554zm-3.816 5.24c-.261 1.544-1.506 2.581-3.096 2.581-.796 0-1.434-.256-1.844-.74-.408-.48-.562-1.164-.434-1.925.25-1.531 1.514-2.602 3.076-2.602.78 0 1.413.258 1.829.746.418.492.583 1.18.469 1.94z"
                        fill="#009CDE" />
                </svg>
            </div>

            {{-- Privacy Links --}}
            <div class="flex gap-6">
                <a href="#"
                    class="text-[10px] uppercase tracking-widest text-neutral-400 hover:text-black transition-colors">Privacy</a>
                <a href="#"
                    class="text-[10px] uppercase tracking-widest text-neutral-400 hover:text-black transition-colors">Terms</a>
                <a href="#"
                    class="text-[10px] uppercase tracking-widest text-neutral-400 hover:text-black transition-colors">Cookies</a>
            </div>

        </div>
    </div>
</footer>