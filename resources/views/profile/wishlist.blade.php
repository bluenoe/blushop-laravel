<x-app-layout>
    <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">My Wishlist</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Saved products you love.</p>
            </div>
            @if(($products ?? collect())->isNotEmpty())
                <form action="{{ route('wishlist.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded-lg bg-gray-700 text-white font-semibold px-4 py-2 hover:bg-gray-600">Clear All</button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="mt-4 rounded-md bg-emerald-900/40 border border-emerald-700 text-emerald-200 px-4 py-2">{{ session('success') }}</div>
        @endif

        @if(($products ?? collect())->isEmpty())
            <div class="mt-6 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 p-4">
                No favorites yet 💜 — go find something you like!
            </div>
        @else
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <x-cart :product="$product" :is-wished="in_array($product->id, $wishedIds ?? [])" />
                @endforeach
            </div>
        @endif
    </section>
    @include('partials.wishlist-script')
</x-app-layout>