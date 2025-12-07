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

                {{-- Socials & Contact --}}
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-6">Connect</h3>
                    <ul class="space-y-4 text-sm text-neutral-600">
                        <li class="flex items-center gap-4">
                            <a href="#" class="hover:text-black transition" aria-label="Instagram">Instagram</a>
                        </li>
                        <li class="flex items-center gap-4">
                            <a href="#" class="hover:text-black transition" aria-label="TikTok">TikTok</a>
                        </li>
                        <li class="flex items-center gap-4">
                            <a href="#" class="hover:text-black transition" aria-label="Facebook">Facebook</a>
                        </li>
                    </ul>

                    <div class="mt-8">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-4">Accepts</h3>
                        <div class="flex gap-3 opacity-60 grayscale hover:grayscale-0 transition duration-300">
                            {{-- Minimal Payment Icons (SVG) --}}
                            <svg class="h-6" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M35 0H3C1.3 0 0 1.3 0 3V21C0 22.7 1.3 24 3 24H35C36.7 24 38 22.7 38 21V3C38 1.3 36.7 0 35 0Z"
                                    fill="#2566AF" />
                                <path
                                    d="M12.9 14.5L14.7 4.1H18.2L16.4 14.5H12.9ZM22.3 9.4C22.3 6.9 19 6.7 19 5.8C19 5.5 19.3 5.3 20 5.2C20.3 5.2 21.3 5.2 22.3 5.7L22.7 3.5C22.1 3.3 21.3 3.1 20.3 3.1C17.6 3.1 15.6 4.5 15.6 6.6C15.6 9.4 19.5 9.5 19.5 10.7C19.5 11.1 19.1 11.4 18.2 11.4C17.1 11.4 16.5 11.2 16 11L15.5 13.2C16.1 13.5 17.2 13.7 18.3 13.7C21.1 13.7 22.3 12.3 22.3 9.4ZM28.5 14.5H31.4L29.5 4.1H26.6C26 4.1 25.5 4.4 25.3 5L21.6 14.5H25.1L25.8 12.5H29.1L29.4 14.5ZM26.7 10L27.6 7.4L28.4 10H26.7ZM10.5 4.1L8.3 10.1C8.1 10.6 8 10.7 7.7 10.8C7.4 10.9 6.8 11 6.2 11H5L5.2 11.4C6.5 13.8 8.4 14.5 11.1 14.5H14.1L10.5 4.1Z"
                                    fill="white" />
                            </svg>
                            <svg class="h-6" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M35 0H3C1.3 0 0 1.3 0 3V21C0 22.7 1.3 24 3 24H35C36.7 24 38 22.7 38 21V3C38 1.3 36.7 0 35 0Z"
                                    fill="#1A1F71" />
                                <path
                                    d="M12.9 15.3H8.3C7.9 15.3 7.6 15 7.6 14.6V9.4C7.6 9 7.9 8.7 8.3 8.7H12.9V15.3ZM20.6 8.7C18.6 8.7 17.1 9.6 16.2 10.8V15.3H19.2V11.8C19.2 11.2 19.7 10.8 20.3 10.8H21.5V8.7H20.6ZM25.5 8.7H23.3V15.3H26.3V8.7H25.5ZM24.4 7.6C25.3 7.6 26.1 6.8 26.1 5.9C26.1 5 25.3 4.2 24.4 4.2C23.5 4.2 22.7 5 22.7 5.9C22.7 6.8 23.5 7.6 24.4 7.6ZM30.9 13.1C30.9 12.3 30.6 11.7 30 11.3C29.6 11 29.1 10.9 28.7 10.9C28.2 10.9 27.8 11 27.4 11.2V8.7H24.4V15.3H27.4V12.8C27.4 12.4 27.6 12 28 12C28.4 12 28.6 12.3 28.6 12.7V15.3H31.6V12.4C31.6 12.4 31.6 13.1 30.9 13.1Z"
                                    fill="white" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BOTTOM BAR --}}
        <div class="border-t border-neutral-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[10px] uppercase tracking-widest text-neutral-400">
                &copy; {{ date('Y') }} BluShop. Saigon, Vietnam.
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