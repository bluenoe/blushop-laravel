{{-- Favorites (Wishlist) Page --}}

<x-app-layout>
    <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
        <div class="flex items-center justify-between" data-reveal="fade-up">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-100">My Favorites</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Quick access to the items you love.</p>
            </div>
            @if(!empty($favorites))
                <form action="{{ route('favorites.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-lg bg-gray-700 text-white font-semibold px-4 py-2 shadow hover:shadow-md transition">Clear All</button>
                </form>
            @endif
        </div>

        @if(empty($favorites))
            <div class="mt-6 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 p-4">
                No favorites yet. Add items by tapping the heart.
            </div>
        @else
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($favorites as $id => $fav)
                    <div class="group rounded-xl overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm transition duration-300 hover:shadow-lg hover:-translate-y-[2px]" data-reveal="fade-up" x-data="{ loaded: false }">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <template x-if="!loaded">
                                <x-skeleton.image class="aspect-[4/3]" />
                            </template>
                            <img
                                src="{{ asset('images/' . $fav['image']) }}"
                                alt="{{ $fav['name'] }}"
                                class="w-full h-full object-cover opacity-0 transition-opacity duration-500 group-hover:scale-105"
                                onload="this.classList.remove('opacity-0')"
                            >
                            <div class="absolute top-3 right-3">
                                <form action="{{ route('favorites.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rounded-full bg-black/40 backdrop-blur px-3 py-2 text-white hover:bg-black/60 transition" aria-label="Remove from favorites">✖</button>
                                </form>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="text-gray-900 dark:text-gray-100 font-semibold truncate">{{ $fav['name'] }}</h3>
                            <p class="mt-1 text-gray-700 dark:text-gray-300 font-medium">₫{{ number_format((float)$fav['price'], 0, ',', '.') }}</p>
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
    </section>
</x-app-layout>