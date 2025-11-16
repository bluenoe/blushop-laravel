<footer class="bg-warm border-t border-beige" role="contentinfo">
    <div class="max-w-7xl mx-auto px-6 py-12 sm:py-16" data-reveal>
        <!-- Top: Brand + Nav + Newsletter -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12">
            <!-- Brand column -->
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3" aria-label="BluShop Home">
                    <x-blu-logo class="text-2xl md:text-3xl" />
                </a>
                <p class="text-sm text-gray-700 leading-relaxed max-w-sm">
                    Elevated essentials for modern wardrobes. Timeless silhouettes, soft tones, and everyday comfort.
                </p>

                <!-- Social links -->
                <div class="pt-2 flex items-center gap-3" aria-label="Social links">
                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white text-ink ring-1 ring-beige shadow-sm
                                       transition hover:bg-ink hover:text-white" aria-label="Instagram">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.5" y2="6.5"></line>
                        </svg>
                    </a>
                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white text-ink ring-1 ring-beige shadow-sm
                                       transition hover:bg-ink hover:text-white" aria-label="Facebook">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M22 12a10 10 0 1 0-11.5 9.95v-7.04H7.9V12h2.6V9.8c0-2.57 1.53-3.99 3.87-3.99 1.12 0 2.29.2 2.29.2v2.52h-1.29c-1.27 0-1.66.79-1.66 1.6V12h2.83l-.45 2.91h-2.38v7.04A10 10 0 0 0 22 12Z">
                            </path>
                        </svg>
                    </a>
                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white text-ink ring-1 ring-beige shadow-sm
                                       transition hover:bg-ink hover:text-white" aria-label="TikTok">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M17 5.5c.86.73 1.9 1.23 3 1.44v2.35a6.7 6.7 0 0 1-3-.79v6.2a5 5 0 1 1-5-5c.16 0 .32.01.47.03v2.4a2.6 2.6 0 1 0 2.53 2.6V4h2v1.5Z" />
                        </svg>
                    </a>
                </div>

                <!-- Optional badges -->
                <div class="mt-4 flex items-center gap-2 text-[11px] text-gray-600">
                    <span class="inline-flex items-center rounded-full bg-white px-2 py-1 ring-1 ring-beige">Secure
                        Checkout</span>
                    <span class="inline-flex items-center rounded-full bg-white px-2 py-1 ring-1 ring-beige">Visa</span>
                    <span
                        class="inline-flex items-center rounded-full bg-white px-2 py-1 ring-1 ring-beige">Mastercard</span>
                    <span
                        class="inline-flex items-center rounded-full bg-white px-2 py-1 ring-1 ring-beige">PayPal</span>
                </div>
            </div>

            <!-- Navigation: Shop -->
            <div>
                <h3 class="text-sm font-semibold text-ink uppercase tracking-wide">Shop</h3>
                <ul class="mt-3 space-y-2 text-sm text-gray-700">
                    <li><a href="{{ route('home') }}" class="hover:text-ink">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-ink">Shop</a></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-ink">Cart</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="hover:text-ink">Account</a></li>
                </ul>
            </div>

            <!-- Navigation: Help -->
            <div>
                <h3 class="text-sm font-semibold text-ink uppercase tracking-wide">Help</h3>
                <ul class="mt-3 space-y-2 text-sm text-gray-700">
                    <li><a href="{{ route('faq') }}" class="hover:text-ink">FAQ</a></li>
                    <li><a href="{{ route('contact.index') }}" class="hover:text-ink">Contact</a></li>
                    <li><a href="{{ route('orders.index') }}" class="hover:text-ink">Orders</a></li>
                </ul>
            </div>

            <!-- Newsletter + Contact info -->
            <div class="lg:col-span-1">
                <h3 class="text-sm font-semibold text-ink uppercase tracking-wide">Newsletter</h3>
                <form x-data="{ email: '', status: null, message: '' }"
                    @submit.prevent="if(!email || !email.includes('@')){status='error'; message='Please enter a valid email.'} else { status='success'; message='Thanks for subscribing!'; }"
                    class="mt-3 space-y-3" action="#" method="POST" novalidate>
                    <div class="flex items-center gap-2">
                        <label for="newsletter-email" class="sr-only">Email address</label>
                        <input id="newsletter-email" x-model="email" type="email" placeholder="Enter your email"
                            class="flex-1 rounded-full border border-beige bg-white px-4 py-2 text-sm text-ink placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        <button type="submit"
                            class="shrink-0 rounded-full bg-ink text-white px-4 py-2 text-sm font-semibold hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500">Subscribe</button>
                    </div>
                    <p x-show="status==='success'" class="text-xs text-green-700">{{ __('Thanks for subscribing!') }}
                    </p>
                    <p x-show="status==='error'" class="text-xs text-rose-700">{{ __('Please enter a valid email.') }}
                    </p>
                </form>

                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-ink uppercase tracking-wide">Contact</h3>
                    <ul class="mt-3 space-y-2 text-sm text-gray-700">
                        <li><a href="mailto:baokhanh.dev281@gmail.com"
                                class="hover:text-ink">baokhanh.dev281@gmail.com</a></li>
                        <li><span>123 Fashion Ave, Wardrobe City</span></li>
                        <li><a href="{{ route('contact.index') }}" class="hover:text-ink">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Legal row -->
        <div
            class="mt-12 pt-6 border-t border-beige flex flex-col sm:flex-row items-center justify-between gap-3 text-xs sm:text-sm text-gray-700">
            <p>© {{ date('Y') }} BluShop — All rights reserved.</p>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-ink">Privacy Policy</a>
                <a href="#" class="hover:text-ink">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>