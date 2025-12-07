<footer class="bg-white border-t border-neutral-200 pt-20 pb-12 text-neutral-900" role="contentinfo">
    <div class="max-w-[1600px] mx-auto px-6 lg:px-8">

        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-16 mb-20">

            {{-- 1. BRAND & NEWSLETTER --}}
            <div class="md:col-span-5 lg:col-span-4 space-y-8">
                <a href="{{ route('home') }}" class="inline-block" aria-label="BluShop Home">
                    <span class="font-bold text-3xl tracking-tighter">BLUSHOP.</span>
                </a>

                <p class="text-sm text-neutral-500 leading-relaxed max-w-sm font-light">
                    Elevated essentials for the modern student. Timeless silhouettes, neutral tones, and uncompromising
                    quality.
                </p>

                {{-- CHỈ HIỆN NEWSLETTER KHI KHÔNG PHẢI LÀ TRANG HOME --}}
                @unless(request()->routeIs('home'))
                <div class="pt-4">
                    <h3 class="text-xs font-bold uppercase tracking-widest mb-4">Subscribe to our newsletter</h3>
                    <form x-data="{ email: '', status: null, message: '' }"
                        @submit.prevent="if(!email || !email.includes('@')){status='error'; message='Please enter a valid email.'} else { status='success'; message='You are on the list.'; email=''; }"
                        class="relative max-w-sm">

                        <div
                            class="relative flex items-center border-b border-neutral-300 focus-within:border-black transition-colors duration-300">
                            <input id="newsletter-email" x-model="email" type="email" placeholder="Your email address"
                                class="w-full bg-transparent border-none p-0 py-3 text-sm placeholder:text-neutral-400 focus:ring-0" />
                            <button type="submit"
                                class="absolute right-0 text-xs font-bold uppercase tracking-widest hover:text-neutral-500 transition">
                                Join
                            </button>
                        </div>

                        <div class="absolute top-full left-0 mt-2">
                            <p x-show="status==='success'" x-transition
                                class="text-xs text-green-600 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span x-text="message"></span>
                            </p>
                            <p x-show="status==='error'" x-transition class="text-xs text-red-600" x-text="message"></p>
                        </div>
                    </form>
                </div>
                @endunless
            </div>

            {{-- SPACING COL (Desktop) --}}
            <div class="hidden lg:block lg:col-span-1"></div>

            {{-- 2. LINKS COLUMNS (Grid nhỏ bên trong) --}}
            <div class="md:col-span-7 lg:col-span-7 grid grid-cols-2 sm:grid-cols-3 gap-8">

                {{-- Shop Links --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-6">Shop</h3>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="{{ route('products.index', ['sort' => 'newest']) }}"
                                class="hover:text-neutral-500 hover:underline decoration-1 underline-offset-4 transition">New
                                Arrivals</a></li>
                        <li><a href="{{ route('products.index') }}"
                                class="hover:text-neutral-500 hover:underline decoration-1 underline-offset-4 transition">All
                                Products</a></li>
                        <li><a href="#"
                                class="hover:text-neutral-500 hover:underline decoration-1 underline-offset-4 transition">Best
                                Sellers</a></li>
                        <li><a href="#"
                                class="hover:text-neutral-500 hover:underline decoration-1 underline-offset-4 transition text-red-600">Sale</a>
                        </li>
                    </ul>
                </div>

                {{-- Help Links --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-6">Support</h3>
                    <ul class="space-y-4 text-sm text-neutral-600">
                        <li><a href="{{ route('orders.index') }}" class="hover:text-black transition">Order Status</a>
                        </li>
                        <li><a href="#" class="hover:text-black transition">Shipping & Returns</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-black transition">FAQ</a></li>
                        <li><a href="{{ route('contact.index') }}" class="hover:text-black transition">Contact Us</a>
                        </li>
                        <li><a href="#" class="hover:text-black transition">Size Guide</a></li>
                    </ul>
                </div>

                {{-- Socials & Payment --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-6">Connect</h3>
                    <ul class="space-y-4">
                        <li>
                            <a href="#"
                                class="flex items-center gap-2 text-sm text-neutral-600 hover:text-black transition group"
                                aria-label="Instagram">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                                <span>Instagram</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center gap-2 text-sm text-neutral-600 hover:text-black transition group"
                                aria-label="TikTok">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                                </svg>
                                <span>TikTok</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center gap-2 text-sm text-neutral-600 hover:text-black transition group"
                                aria-label="Facebook">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                                <span>Facebook</span>
                            </a>
                        </li>
                    </ul>

                    {{-- Payment Methods --}}
                    <div class="mt-10">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-4">We Accept</h3>
                        <div class="flex gap-2">
                            {{-- Visa Card --}}
                            <div
                                class="bg-white border border-neutral-200 rounded px-2 py-1.5 hover:border-neutral-400 transition">
                                <svg class="h-6 w-auto" viewBox="0 0 48 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="32" rx="4" fill="white" />
                                    <path
                                        d="M20.146 21.845h-2.882l1.803-11.177h2.882l-1.803 11.177zm-5.55-11.177l-2.762 7.644-.323-1.644-1.074-5.527s-.13-.473-.755-.473H5.528l-.044.14s1.147.239 2.488.992l2.065 7.957h3.005l4.604-11.089h-3.001zM38.67 21.845h2.647l-2.309-11.177h-2.432c-.502 0-.627.388-.627.388l-4.313 10.789h3.005l.596-1.658h3.667l.346 1.658zm-3.184-3.944l1.506-4.161.862 4.161h-2.368zm-6.288-5.175l.417-2.421s-1.292-.489-2.647-.489c-1.463 0-4.938.64-4.938 3.754 0 2.933 4.087 2.968 4.087 4.51 0 1.542-3.667 1.265-4.875.293l-.43 2.507s1.305.64 3.302.64c1.998 0 5.063-.835 5.063-3.884 0-2.946-4.13-3.238-4.13-4.51 0-1.272 2.993-1.056 4.151-.4z"
                                        fill="#1434CB" />
                                </svg>
                            </div>

                            {{-- Mastercard --}}
                            <div
                                class="bg-white border border-neutral-200 rounded px-2 py-1.5 hover:border-neutral-400 transition">
                                <svg class="h-6 w-auto" viewBox="0 0 48 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="32" rx="4" fill="white" />
                                    <circle cx="18" cy="16" r="8" fill="#EB001B" />
                                    <circle cx="30" cy="16" r="8" fill="#F79E1B" />
                                    <path
                                        d="M24 9.6c-1.6 1.4-2.6 3.4-2.6 5.6s1 4.2 2.6 5.6c1.6-1.4 2.6-3.4 2.6-5.6s-1-4.2-2.6-5.6z"
                                        fill="#FF5F00" />
                                </svg>
                            </div>

                            {{-- PayPal --}}
                            <div
                                class="bg-white border border-neutral-200 rounded px-2 py-1.5 hover:border-neutral-400 transition">
                                <svg class="h-6 w-auto" viewBox="0 0 48 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="32" rx="4" fill="white" />
                                    <path
                                        d="M20.905 9h-5.526c-.384 0-.712.28-.772.662l-2.274 14.42c-.046.29.175.554.47.554h2.73c.384 0 .712-.28.772-.662l.614-3.893c.06-.382.388-.662.772-.662h1.778c3.702 0 5.842-1.792 6.397-5.347.25-1.553.011-2.773-.708-3.626-.791-.938-2.195-1.446-4.063-1.446zm.649 5.266c-.305 2.002-1.833 2.002-3.31 2.002h-.841l.59-3.738c.035-.229.234-.399.464-.399h.39c1.017 0 1.977 0 2.472.579.297.347.385.86.235 1.556z"
                                        fill="#003087" />
                                    <path
                                        d="M33.905 14.217h-2.738c-.23 0-.429.17-.464.399l-.119.755-.189-.274c-.586-.85-1.892-1.134-3.197-1.134-2.99 0-5.543 2.266-6.039 5.445-.258 1.586.11 3.1 1.008 4.153.826.967 2.004 1.368 3.407 1.368 2.409 0 3.745-1.548 3.745-1.548l-.121.753c-.046.29.175.554.47.554h2.467c.384 0 .712-.28.772-.662l1.456-9.219c.046-.29-.175-.554-.47-.554zm-3.816 5.24c-.261 1.544-1.506 2.581-3.096 2.581-.796 0-1.434-.256-1.844-.74-.408-.48-.562-1.164-.434-1.925.25-1.531 1.514-2.602 3.076-2.602.78 0 1.413.258 1.829.746.418.492.583 1.18.469 1.94z"
                                        fill="#009CDE" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BOTTOM BAR --}}
        <div class="border-t border-neutral-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] uppercase tracking-widest text-neutral-400">
                &copy; {{ date('Y') }} BluShop. Danang, Vietnam.
            </p>

            <div class="flex gap-6">
                <a href="#"
                    class="text-[10px] uppercase tracking-widest text-neutral-400 hover:text-black transition">Privacy</a>
                <a href="#"
                    class="text-[10px] uppercase tracking-widest text-neutral-400 hover:text-black transition">Terms</a>
                <a href="#"
                    class="text-[10px] uppercase tracking-widest text-neutral-400 hover:text-black transition">Cookies</a>
            </div>
        </div>
    </div>
</footer>