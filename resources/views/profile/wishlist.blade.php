<x-app-layout>
    <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">My Wishlist</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Saved products you love.</p>
            </div>
            @if(!empty($favorites))
            <button type="button"
                    @click="$store.wishlist.clear(); document.querySelectorAll('[data-wish-card]').forEach(el => el.remove())"
                    class="rounded-lg bg-gray-700 text-white font-semibold px-4 py-2 hover:bg-gray-600">Clear All</button>
            @endif
        </div>

        @if(session('success'))
            <div class="mt-4 rounded-md bg-emerald-900/40 border border-emerald-700 text-emerald-200 px-4 py-2">{{ session('success') }}</div>
        @endif

        @php($favorites = is_array(session('favorites')) ? session('favorites') : [])
        @if(empty($favorites))
            <div class="mt-6 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 p-4">
                No favorites yet 💜 — go find something you like!
            </div>
        @else
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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
                        <a href="{{ route('product.show', $id) }}" class="inline-block rounded-lg bg-indigo-600 text-white font-semibold px-4 py-2 hover:bg-indigo-500">View</a>
                        <form action="{{ route('cart.add', $id) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-block rounded-lg bg-gray-700 text-white font-semibold px-4 py-2 hover:bg-gray-600">Add to Cart</button>
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