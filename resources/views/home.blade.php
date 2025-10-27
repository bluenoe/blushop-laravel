{{--
    Shop page (Products Listing)
    UI-only Tailwind refresh to match landing page theme.
--}}

<x-app-layout>
    <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
        <div class="text-center">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-100">Products</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-300">Pick your favorites — session cart coming in Day 3 👀</p>
        </div>

        @if(($products ?? collect())->isEmpty())
            <div class="mt-6 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 p-4">
                No products yet. Did you run seeder?
                <code class="ml-1">php artisan db:seed --class=ProductSeeder</code>
            </div>
        @else
            <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="group rounded-xl overflow-hidden bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition duration-300">
                        <div class="aspect-[4/3] overflow-hidden">
                            <img
                                src="{{ asset('images/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover transform transition duration-300 group-hover:scale-105"
                            >
                        </div>
                        <div class="p-4">
                            <h3 class="text-gray-900 dark:text-gray-100 font-semibold truncate">{{ $product->name }}</h3>
                            <p class="mt-1 text-gray-700 dark:text-gray-300 font-medium">
                                ₫{{ number_format((float)$product->price, 0, ',', '.') }}
                            </p>
                            <div class="mt-3">
                                <a href="{{ route('product.show', $product->id) }}"
                                   class="inline-block rounded-lg bg-indigo-600 text-white font-semibold px-4 py-2 shadow hover:shadow-md transition-transform duration-300 hover:scale-105">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</x-app-layout>
