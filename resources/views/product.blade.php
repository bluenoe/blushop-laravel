<x-app-layout>
    <section class="min-h-[calc(100vh-4rem)] bg-gradient-to-b from-gray-900 via-gray-900 to-gray-800">
        <div class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Product image -->
                <div class="group">
                    <div class="relative overflow-hidden rounded-xl ring-1 ring-white/10 bg-gray-800">
                        <img
                            src="{{ asset('images/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-[340px] sm:h-[420px] object-cover transform transition-transform duration-300 group-hover:scale-[1.03]"
                        />
                    </div>
                </div>

                <!-- Product details -->
                <div class="flex flex-col">
                    <div class="rounded-xl ring-1 ring-white/10 bg-gray-800 p-6 sm:p-8">
                        <div class="flex items-start justify-between gap-4">
                            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">{{ $product->name }}</h1>
                            <span class="text-xs text-gray-400">ID: {{ $product->id }}</span>
                        </div>

                        <div class="mt-3">
                            <p class="text-indigo-400 text-xl sm:text-2xl font-semibold">₫{{ number_format((float)$product->price, 0, ',', '.') }}</p>
                        </div>

                        @if($product->description)
                            <p class="mt-4 text-sm sm:text-base leading-relaxed text-gray-300">{{ $product->description }}</p>
                        @endif

                        <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mt-6 sm:mt-8 flex flex-wrap items-end gap-3">
                            @csrf

                            <div class="flex items-center gap-2">
                                <label for="qty" class="text-sm font-medium text-gray-300">Qty</label>
                                <input
                                    type="number"
                                    min="1"
                                    name="quantity"
                                    id="qty"
                                    value="1"
                                    required
                                    class="w-24 rounded-md border border-white/10 bg-gray-900/70 px-3 py-2 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                />
                            </div>
                            @error('quantity')
                                <p class="text-sm text-red-400">{{ $message }}</p>
                            @enderror

                            <div class="flex gap-3">
                                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                                    Add to Cart
                                </button>
                                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-md border border-white/10 bg-gray-900/50 px-4 py-2 text-sm font-semibold text-gray-200 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-white/20 transition-colors">
                                    Back to Shop
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
