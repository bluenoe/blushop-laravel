{{--
Shop page (Products Listing)
UI-only Tailwind refresh to match landing page theme.
--}}

<x-app-layout>
    <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
        <div class="text-center" data-reveal="fade-up">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-100">Products</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Browse our minimal lineup — crafted for calm.</p>
        </div>

        <!-- Filters -->
        <form action="{{ route('products.index') }}" method="GET"
            class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3" data-reveal="fade-up">
            <div>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..."
                    class="w-full rounded-lg bg-white/5 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="flex gap-2">
                <input type="number" name="price_min" value="{{ request('price_min') }}" min="0" step="1"
                    placeholder="Min price"
                    class="w-full rounded-lg bg-white/5 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500">
                <input type="number" name="price_max" value="{{ request('price_max') }}" min="0" step="1"
                    placeholder="Max price"
                    class="w-full rounded-lg bg-white/5 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <select name="sort"
                    class="w-full rounded-lg bg-white/5 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500">
                    <option value="newest" {{ request('sort', 'newest' )==='newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_asc" {{ request('sort')==='price_asc' ? 'selected' : '' }}>Price: Low to High
                    </option>
                    <option value="price_desc" {{ request('sort')==='price_desc' ? 'selected' : '' }}>Price: High to Low
                    </option>
                </select>
            </div>
            <div class="lg:col-span-1">
                <button type="submit"
                    class="w-full rounded-lg bg-indigo-600 text-white font-semibold px-4 py-2 shadow hover:shadow-md transition-transform duration-300 hover:scale-[1.02]">Apply</button>
            </div>
        </form>

        @if(($products ?? collect())->isEmpty())
        <div class="mt-6 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 p-4">
            No products yet. Did you run seeder?
            <code class="ml-1">php artisan db:seed --class=ProductSeeder</code>
        </div>
        @else
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="group rounded-xl overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm transition duration-300 hover:shadow-lg hover:-translate-y-[2px]"
                data-reveal="fade-up" x-data="{ loaded: false }">
                <div class="relative aspect-[4/3] overflow-hidden">
                    <template x-if="!loaded">
                        <x-skeleton.image class="aspect-[4/3]" />
                    </template>
                    <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}"
                        class="w-full h-full object-cover opacity-0 transition-opacity duration-500 group-hover:scale-105"
                        @load="loaded = true; $el.classList.remove('opacity-0')">

                    <!-- Wishlist heart (AJAX) -->
                    <div class="absolute top-3 right-3" x-data="{ id: {{ $product->id }}, active: $store.wishlist.isFav({{ $product->id }}) }">
                        <button type="button"
                                @click="active = !active; $store.wishlist.toggle(id)"
                                :class="active ? 'bg-pink-600 text-white scale-105' : 'bg-black/40 text-white'"
                                class="rounded-full backdrop-blur px-3 py-2 transition transform hover:scale-105"
                                :aria-label="active ? 'Remove from wishlist' : 'Add to wishlist'"
                                :title="active ? 'Remove from wishlist' : 'Add to wishlist'">
                            <span :class="active ? 'opacity-100' : 'opacity-80'">❤️</span>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-gray-900 dark:text-gray-100 font-semibold truncate">{{ $product->name }}</h3>
                    <p class="mt-1 text-gray-700 dark:text-gray-300 font-medium">
                        ₫{{ number_format((float)$product->price, 0, ',', '.') }}
                    </p>
                    <div class="mt-3 flex items-center gap-2">
                        <a href="{{ route('product.show', $product->id) }}"
                            class="inline-block rounded-lg bg-indigo-600 text-white font-semibold px-4 py-2 shadow hover:shadow-md transition-transform duration-300 hover:scale-[1.03]">
                            View
                        </a>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-block rounded-lg bg-gray-700 text-white font-semibold px-4 py-2 shadow hover:shadow-md transition-transform duration-300 hover:scale-[1.03]">Add
                                to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </section>
@include('partials.wishlist-script')
</x-app-layout>