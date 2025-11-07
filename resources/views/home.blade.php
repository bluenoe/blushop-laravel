{{--
Shop page (Products Listing)
Tailwind theme to match landing page.
--}}

<x-app-layout>
    @php
    // Category đang active (ưu tiên biến từ controller, fallback request)
    $active = $activeCategory ?? request('category');

    // Đang có filter nào không?
    $hasFilters = request()->filled('q')
    || request()->filled('price_min')
    || request()->filled('price_max')
    || request()->filled('sort')
    || !empty($active);
    @endphp

    <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
        {{-- Heading --}}
        <div class="text-center" data-reveal="fade-up">
            <h1 class="text-3xl sm:text-4xl font-bold text-ink">Products</h1>
            <p class="mt-2 text-gray-700">
                Browse our minimal lineup — crafted for calm.
            </p>
        </div>

        {{-- Category filter (pills) --}}
        <div class="mt-8" data-reveal="fade-up">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('products.index') }}"
                    class="px-3 py-1.5 rounded-full text-sm font-medium border transition-colors
                          {{ empty($active) 
                              ? 'bg-indigo-600 text-white border-indigo-600' 
                              : 'bg-warm border-beige text-ink hover:bg-indigo-600 hover:text-white hover:border-indigo-600' }}">
                    All
                </a>

                @foreach(($categories ?? collect()) as $cat)
                <a href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}"
                    class="px-3 py-1.5 rounded-full text-sm font-medium border transition-colors
                              {{ ($active === $cat->slug) 
                                  ? 'bg-indigo-600 text-white border-indigo-600' 
                                  : 'bg-warm border-beige text-ink hover:bg-indigo-600 hover:text-white hover:border-indigo-600' }}">
                    {{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Filters --}}
        <form action="{{ route('products.index') }}" method="GET"
            class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3" data-reveal="fade-up">

            {{-- Preserve category when Apply --}}
            @if($active)
            <input type="hidden" name="category" value="{{ $active }}">
            @endif

            <div>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..." class="w-full rounded-lg bg-white border border-beige text-ink placeholder-gray-400
                              focus:ring-2 focus:ring-indigo-500 shadow-soft">
            </div>

            <div class="flex gap-2">
                <input type="number" name="price_min" value="{{ request('price_min') }}" min="0" step="1"
                    placeholder="Min price" class="w-full rounded-lg bg-white border border-beige text-ink placeholder-gray-400
                              focus:ring-2 focus:ring-indigo-500 shadow-soft">

                <input type="number" name="price_max" value="{{ request('price_max') }}" min="0" step="1"
                    placeholder="Max price" class="w-full rounded-lg bg-white border border-beige text-ink placeholder-gray-400
                              focus:ring-2 focus:ring-indigo-500 shadow-soft">
            </div>

            <div>
                <select name="sort" class="w-full rounded-lg bg-white border border-beige text-ink
                               focus:ring-2 focus:ring-indigo-500 shadow-soft">
                    <option value="newest" {{ request('sort', 'newest' )==='newest' ? 'selected' : '' }}>
                        Newest
                    </option>
                    <option value="price_asc" {{ request('sort')==='price_asc' ? 'selected' : '' }}>
                        Price: Low to High
                    </option>
                    <option value="price_desc" {{ request('sort')==='price_desc' ? 'selected' : '' }}>
                        Price: High to Low
                    </option>
                </select>
            </div>

            <div class="lg:col-span-1 flex gap-2">
                <button type="submit" class="w-full rounded-lg bg-indigo-600 text-white font-semibold px-4 py-2
                               shadow hover:shadow-md transition-transform duration-300 hover:scale-[1.02]">
                    Apply
                </button>

                @if($hasFilters)
                <a href="{{ route('products.index') }}" class="hidden sm:inline-flex items-center justify-center rounded-lg border border-beige
                              bg-warm text-sm font-medium text-ink px-4 py-2 hover:bg-beige transition">
                    Clear
                </a>
                @endif
            </div>
        </form>

        @if(($products ?? collect())->isEmpty())
        {{-- Empty state --}}
        <div class="mt-6 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-800 p-4">
            @if($hasFilters)
            <p class="font-medium">Không tìm thấy sản phẩm phù hợp với bộ lọc hiện tại.</p>
            <p class="mt-1 text-sm">
                Thử bỏ bớt điều kiện hoặc
                <a href="{{ route('products.index') }}" class="font-semibold underline">
                    clear filters
                </a>
                để xem toàn bộ sản phẩm.
            </p>
            @else
            <p class="font-medium">No products yet.</p>
            <p class="mt-1 text-sm">
                For demo data, run seeder:
                <code class="ml-1 bg-yellow-100 px-1 py-0.5 rounded">
                            php artisan db:seed --class=ProductSeeder
                        </code>
            </p>
            @endif
        </div>
        @else
        {{-- Products grid --}}
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="group rounded-xl overflow-hidden bg-white border border-beige shadow-soft
                                transition duration-300 hover:shadow-lg hover:-translate-y-[2px]" data-reveal="fade-up"
                x-data="{ loaded: false }">

                {{-- Image --}}
                <div class="relative aspect-[4/3] overflow-hidden">
                    <template x-if="!loaded">
                        <x-skeleton.image class="aspect-[4/3]" />
                    </template>

                    <img src="{{ Storage::url('products/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover opacity-0 transition-opacity duration-500
                                        group-hover:scale-105"
                        @load="loaded = true; $el.classList.remove('opacity-0')">

                    {{-- Wishlist heart (AJAX) --}}
                    <div class="absolute top-3 right-3"
                        x-data="{ id: {{ $product->id }}, active: $store.wishlist.isFav({{ $product->id }}) }">
                        <button type="button" @click="active = !active; $store.wishlist.toggle(id)"
                            :class="active ? 'bg-pink-600 text-white scale-105' : 'bg-black/40 text-white'"
                            class="rounded-full backdrop-blur px-3 py-2 transition transform hover:scale-105"
                            :aria-label="active ? 'Remove from wishlist' : 'Add to wishlist'"
                            :aria-pressed="active ? 'true' : 'false'"
                            :title="active ? 'Remove from wishlist' : 'Add to wishlist'">
                            <span :class="active ? 'opacity-100' : 'opacity-80'">❤️</span>
                        </button>
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-4">
                    <h3 class="text-ink font-semibold truncate">
                        {{ $product->name }}
                    </h3>

                    @if($product->category)
                    <a href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $product->category->slug])) }}"
                        class="mt-1 inline-flex items-center gap-1 text-xs text-gray-600 hover:text-indigo-500">
                        <span class="inline-block w-2 h-2 rounded-full bg-indigo-500"></span>
                        <span>{{ $product->category->name }}</span>
                    </a>
                    @endif

                    <p class="mt-1 text-gray-700 font-medium">
                        ₫{{ number_format((float) $product->price, 0, ',', '.') }}
                    </p>

                    <div class="mt-3 flex items-center gap-2">
                        <a href="{{ route('product.show', $product->id) }}" class="inline-block rounded-lg bg-indigo-600 text-white font-semibold px-4 py-2
                                          shadow hover:shadow-md transition-transform duration-300 hover:scale-[1.03]">
                            View
                        </a>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-block rounded-lg bg-beige text-ink font-semibold px-4 py-2
                                                   border border-beige shadow-soft hover:bg-rosebeige
                                                   transition-transform duration-300 hover:scale-[1.03]">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination (nếu dùng paginate) --}}
        @if(method_exists($products, 'links'))
        <div class="mt-10">
            {{ $products->links() }}
        </div>
        @endif
        @endif
    </section>

    @include('partials.wishlist-script')
</x-app-layout>