<x-app-layout>
    <section class="max-w-7xl mx-auto px-6 lg:px-8 py-12" x-data="{ tab: 'account' }">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                    <div class="p-4 flex items-center gap-3">
                        @php($u = $user ?? Auth::user())
                        @if ($u && $u->avatar)
                            <img data-avatar-sync="true" src="{{ $u->avatarUrl() }}" alt="User avatar" style="width:60px;height:60px" class="rounded-full object-cover ring-1 ring-gray-700/60 transform transition hover:scale-105 hover:ring-indigo-500" />
                        @else
                            <div data-avatar-placeholder="true" data-class="rounded-full object-cover ring-1 ring-gray-700/60 transform transition hover:scale-105 hover:ring-indigo-500" style="width:60px;height:60px" class="rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold">
                                {{ Str::of($u->name)->substr(0, 1)->upper() }}
                            </div>
                        @endif
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Hello</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $user->name ?? Auth::user()->name }}</p>
                        </div>
                    </div>

                    <!-- Quick Links: Orders & Wishlist -->
                    @php($ordersCount = optional(Auth::user())->orders()->count())
                    @php($favoritesCount = is_array(session('favorites')) ? count(session('favorites')) : 0)
                    <div class="px-4 pb-4 grid grid-cols-2 gap-3">
                        <a href="{{ route('orders.index') }}" class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-3 hover:border-indigo-500 transition">
                            <div class="text-xs text-gray-500 dark:text-gray-400">My Orders</div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $ordersCount }}</div>
                        </a>
                        <button type="button" @click="tab='wishlist'" class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-3 hover:border-indigo-500 transition">
                            <div class="text-xs text-gray-500 dark:text-gray-400">My Wishlist</div>
                            <div id="wishlist-count" class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $favoritesCount }}</div>
                        </button>
                    </div>

                    <nav class="border-t border-gray-200 dark:border-gray-700" aria-label="Account navigation">
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            <li>
                                <button type="button" @click="tab='account'"
                                        :class="tab==='account' ? 'bg-gray-900 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900'"
                                        class="w-full text-left px-4 py-3 flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <!-- icon -->
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>My Account</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" @click="tab='orders'"
                                        :class="tab==='orders' ? 'bg-gray-900 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900'"
                                        class="w-full text-left px-4 py-3 flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M3 7h18M5 11h14v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6z"/></svg>
                                    <span>My Orders</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" @click="tab='returns'"
                                        :class="tab==='returns' ? 'bg-gray-900 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900'"
                                        class="w-full text-left px-4 py-3 flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M9 16h6M5 8h14M4 4l4 4-4 4"/></svg>
                                    <span>Returns & Cancel</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" @click="tab='reviews'"
                                        :class="tab==='reviews' ? 'bg-gray-900 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900'"
                                        class="w-full text-left px-4 py-3 flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.45a1 1 0 00-.364 1.118l1.286 3.957c.3.92-.755 1.688-1.54 1.118l-3.37-2.45a1 1 0 00-1.176 0l-3.37 2.45c-.784.57-1.838-.198-1.539-1.118l1.285-3.957a1 1 0 00-.364-1.118l-3.37-2.45c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z"/></svg>
                                    <span>My Ratings & Reviews</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" @click="tab='wishlist'"
                                        :class="tab==='wishlist' ? 'bg-gray-900 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900'"
                                        class="w-full text-left px-4 py-3 flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.5l-7.682-7.818a4.5 4.5 0 010-6.364z"/></svg>
                                    <span>My Wishlist</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" @click="tab='payment'"
                                        :class="tab==='payment' ? 'bg-gray-900 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900'"
                                        class="w-full text-left px-4 py-3 flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 7h20M2 11h20M4 15h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                                    <span>Payment</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" @click="tab='password'"
                                        :class="tab==='password' ? 'bg-gray-900 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900'"
                                        class="w-full text-left px-4 py-3 flex items-center gap-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3V6a3 3 0 10-6 0v2c0 1.657 1.343 3 3 3zm0 0v4m0 4h.01"/></svg>
                                    <span>Change Password</span>
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <!-- Right content panel -->
            <div class="lg:col-span-3 space-y-8">
                <!-- My Account -->
                <div x-show="tab==='account'" x-cloak class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Personal Information</h2>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Last updated: {{ optional($user->updated_at)->diffForHumans() ?? '—' }}</span>
                        </div>

                        <!-- Avatar display: current image or initial-based placeholder -->
                        <!-- Removed duplicate avatar display block to unify avatar in the form -->

                        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                            <!-- Right panel reserved for future widgets; kept empty to avoid duplicate inputs -->
                            <div class="space-y-4"></div>
                        </div>
                    </div>
                </div>

                <!-- My Orders (placeholder) -->
                <div x-show="tab==='orders'" x-cloak class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="p-6 sm:p-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">My Orders</h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">View your order history and details.</p>
                        <div class="mt-6">
                            <a href="{{ route('orders.index') }}" class="inline-flex items-center rounded-md bg-indigo-600 text-white px-4 py-2 hover:bg-indigo-700 transition">Go to Orders</a>
                        </div>
                    </div>
                </div>

                <!-- Returns & Cancel (placeholder) -->
                <div x-show="tab==='returns'" x-cloak class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="p-6 sm:p-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Returns & Cancel</h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">No return requests. This section will list your return or cancellation history.</p>
                    </div>
                </div>

                <!-- Ratings & Reviews (placeholder) -->
                <div x-show="tab==='reviews'" x-cloak class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="p-6 sm:p-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">My Ratings & Reviews</h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">You haven’t posted any reviews yet.</p>
                    </div>
                </div>

                <!-- Wishlist (inline) -->
                <div x-show="tab==='wishlist'" x-cloak class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">My Wishlist</h2>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Saved products you love.</p>
                            </div>
                            @php($favorites = is_array(session('favorites')) ? session('favorites') : [])
                            @if(!empty($favorites))
                            <button type="button"
                                    @click="$store.wishlist.clear(); $refs.wishlistGrid?.querySelectorAll('[data-wish-card]').forEach(el => el.remove())"
                                    class="rounded-lg bg-gray-700 text-white font-semibold px-4 py-2 hover:bg-gray-600">Clear All</button>
                            @endif
                        </div>

                        @if(empty($favorites))
                        <div class="mt-6 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 p-4">
                            No favorites yet 💜 — go find something you like!
                        </div>
                        @else
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" x-ref="wishlistGrid">
                            @foreach($favorites as $id => $fav)
                            <div class="group rounded-xl overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm transition hover:shadow-lg" data-wish-card>
                                <div class="relative aspect-[4/3] overflow-hidden">
                                    <img src="{{ Storage::url('products/' . ($fav['image'] ?? '')) }}" alt="{{ $fav['name'] ?? 'Product' }}" class="w-full h-full object-cover group-hover:scale-105 transition" />
                                    <div class="absolute top-3 right-3" x-data="{ id: {{ $id }} }">
                                        <button type="button" @click="$store.wishlist.remove(id); $el.closest('[data-wish-card]').remove()"
                                                class="rounded-full bg-black/40 backdrop-blur px-3 py-2 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-white/20"
                                                aria-label="Remove from wishlist" title="Remove from wishlist">✖</button>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-gray-900 dark:text-gray-100 font-semibold truncate">{{ $fav['name'] }}</h3>
                                    <p class="mt-1 text-gray-700 dark:text-gray-300 font-medium">₫{{ number_format((float)($fav['price'] ?? 0), 0, ',', '.') }}</p>
                                    <div class="mt-3 flex items-center gap-2">
                                        <a href="{{ route('product.show', $id) }}" class="inline-block rounded-lg bg-indigo-600 text-white font-semibold px-4 py-2 shadow hover:shadow-md transition-transform duration-300 hover:scale-[1.03]">View</a>
                                        <form action="{{ route('cart.add', $id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-block rounded-lg bg-gray-700 text-white font-semibold px-4 py-2 shadow hover:shadow-md transition-transform duration-300 hover:scale-[1.03]">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment (placeholder) -->
                <div x-show="tab==='payment'" x-cloak class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="p-6 sm:p-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Payment Methods</h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Add and manage your payment methods here. Coming soon.</p>
                    </div>
                </div>

                <!-- Change Password -->
                <div x-show="tab==='password'" x-cloak class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="p-6 sm:p-8">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account -->
                <div x-show="tab==='delete'" x-cloak class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <div class="p-6 sm:p-8">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('partials.wishlist-script')
</x-app-layout>
