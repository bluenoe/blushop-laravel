{{--
Shop page (Products Listing)
Tailwind theme to match landing page.
--}}

<x-app-layout>
    @php
    $active = $activeCategory ?? request('category');
    $hasFilters = request()->filled('q') || request()->filled('price_min') || request()->filled('price_max') ||
    request()->filled('sort') || !empty($active);
    @endphp

    <x-ui.hero-products title="Products" subtitle="Everyday essentials crafted for calm." variant="dark" />

    <section class="max-w-7xl mx-auto px-6 pt-6">
        <x-breadcrumbs :items="$breadcrumbs" />
    </section>

    <section class="max-w-7xl mx-auto px-6 py-8 sm:py-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <aside class="md:col-span-3 space-y-6">
                <div class="rounded-xl border border-beige bg-white shadow-soft p-4">
                    <div class="text-sm font-semibold text-ink">Categories</div>
                    <div class="mt-3 flex flex-wrap md:block gap-2">
                        <a href="{{ route('products.index', request()->except('category','page')) }}"
                            class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium border transition-colors {{ empty($active) ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-warm border-beige text-ink hover:bg-indigo-600 hover:text-white hover:border-indigo-600' }}">All</a>
                        @foreach(($categories ?? collect()) as $cat)
                        <a href="{{ route('products.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}"
                            class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium border transition-colors {{ ($active === $cat->slug) ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-warm border-beige text-ink hover:bg-indigo-600 hover:text-white hover:border-indigo-600' }}">{{
                            $cat->name }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="rounded-xl border border-beige bg-white shadow-soft p-4">
                    <div class="text-sm font-semibold text-ink">Filters</div>
                    <form action="{{ route('products.index') }}" method="GET" class="mt-3 space-y-4">
                        @if($active)
                        <input type="hidden" name="category" value="{{ $active }}">
                        @endif
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..."
                            class="w-full rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 shadow-soft">
                        <div>
                            <x-ui.price-range :min="$priceMinBound" :max="$priceMaxBound"
                                :valueMin="request('price_min')" :valueMax="request('price_max')" />
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : ''
                                    }} class="rounded border-beige text-indigo-600 focus:ring-indigo-500">
                                In stock
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                <input type="checkbox" name="on_sale" value="1" {{ request('on_sale') ? 'checked' : ''
                                    }} class="rounded border-beige text-indigo-600 focus:ring-indigo-500">
                                On sale
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700 col-span-2">
                                <input type="checkbox" name="featured" value="1" {{ request('featured') ? 'checked' : ''
                                    }} class="rounded border-beige text-indigo-600 focus:ring-indigo-500">
                                Featured
                            </label>
                        </div>
                        <button type="submit"
                            class="w-full rounded-lg bg-indigo-600 text-white font-semibold px-4 py-2 shadow hover:shadow-md transition-transform duration-300 hover:scale-[1.02]">Apply</button>
                        @if($hasFilters)
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center justify-center w-full rounded-lg border border-beige bg-warm text-sm font-medium text-ink px-4 py-2 hover:bg-beige transition">Clear</a>
                        @endif
                    </form>
                </div>
                <div class="rounded-xl border border-beige bg-white shadow-soft p-4">
                    <div class="text-sm font-semibold text-ink">Shipping & help</div>
                    <p class="mt-2 text-sm text-gray-700">Fast campus delivery, secure checkout, and easy returns.
                        Questions? Chat with us.</p>
                </div>
            </aside>
            <div class="md:col-span-9">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    @php
                    $z = method_exists($products, 'total') ? $products->total() : $products->count();
                    $x = method_exists($products, 'firstItem') ? ($products->firstItem() ?? ($z ? 1 : 0)) : ($z ? 1 :
                    0);
                    $y = method_exists($products, 'lastItem') ? ($products->lastItem() ?? $products->count()) :
                    $products->count();
                    @endphp
                    <div class="text-sm text-gray-700">Showing {{ $x }}–{{ $y }} of {{ $z }} products</div>
                    <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-2">
                        @foreach(request()->except('sort','page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ is_array($val) ? json_encode($val) : $val }}">
                        @endforeach
                        <label for="sort" class="text-sm text-gray-600">Sort by</label>
                        <select id="sort" name="sort"
                            class="rounded-lg bg-white border border-beige text-ink focus:ring-2 focus:ring-indigo-500 shadow-soft"
                            onchange="this.form.submit()">
                            <option value="newest" {{ request('sort', 'newest' )==='newest' ? 'selected' : '' }}>Newest
                            </option>
                            <option value="price_asc" {{ request('sort')==='price_asc' ? 'selected' : '' }}>Price: Low
                                to High</option>
                            <option value="price_desc" {{ request('sort')==='price_desc' ? 'selected' : '' }}>Price:
                                High to Low</option>
                            <option value="featured" {{ request('sort')==='featured' ? 'selected' : '' }}>Featured
                            </option>
                        </select>
                    </form>
                </div>
                @if(($products ?? collect())->isEmpty())
                <div class="mt-6 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-800 p-4">
                    @if($hasFilters)
                    <p class="font-medium">Không tìm thấy sản phẩm phù hợp với bộ lọc hiện tại.</p>
                    <p class="mt-1 text-sm">Thử bỏ bớt điều kiện hoặc <a href="{{ route('products.index') }}"
                            class="font-semibold underline">clear filters</a> để xem toàn bộ sản phẩm.</p>
                    @else
                    <p class="font-medium">No products yet.</p>
                    <p class="mt-1 text-sm">For demo data, run seeder: <code
                            class="ml-1 bg-yellow-100 px-1 py-0.5 rounded">php artisan db:seed --class=ProductSeeder</code>
                    </p>
                    @endif
                </div>
                @else
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <x-cart :product="$product" :is-wished="in_array($product->id, $wishedIds ?? [])" />
                    @endforeach
                </div>
                @if(method_exists($products, 'links'))
                <div class="mt-10 text-center">{{ $products->links('components.ui.pagination') }}</div>
                @endif
                @endif
            </div>
        </div>
    </section>

    @include('partials.wishlist-script')
</x-app-layout>