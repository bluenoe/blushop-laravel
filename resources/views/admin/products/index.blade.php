<x-admin-layout>
    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-neutral-400 mb-1">Inventory</p>
            <h1 class="text-3xl md:text-4xl font-bold tracking-tighter">Products</h1>
        </div>

        <div class="flex items-center gap-2">
            {{-- Search Bar (Minimal) --}}
            <div class="relative group">
                <input type="text" placeholder="SEARCH SKU..."
                    class="pl-3 pr-8 py-2 bg-transparent border-b border-neutral-200 text-sm focus:border-black focus:ring-0 placeholder-neutral-400 w-40 transition-all focus:w-64">
                <svg class="w-4 h-4 text-neutral-400 absolute right-2 top-2.5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            {{-- Add Button --}}
            <a href="{{ route('admin.products.create') }}"
                class="ml-4 px-6 py-2.5 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition">
                + New Item
            </a>
        </div>
    </div>

    {{-- TABLE SECTION --}}
    <div class="bg-white min-h-[500px]">
        {{-- Nếu không có sản phẩm --}}
        @if($products->isEmpty())
        <div class="flex flex-col items-center justify-center h-64 text-neutral-400">
            <p class="text-sm font-light mb-4">No products found in the catalogue.</p>
            <a href="{{ route('admin.products.create') }}"
                class="underline decoration-1 underline-offset-4 hover:text-black">Create your first product</a>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-neutral-100 text-[10px] uppercase tracking-[0.2em] text-neutral-400">
                        <th class="py-4 pl-2 font-medium">Product</th>
                        <th class="py-4 font-medium">Category</th>
                        <th class="py-4 font-medium">Status</th>
                        <th class="py-4 font-medium text-right">Price</th>
                        <th class="py-4 pr-2 font-medium text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-neutral-50">
                    @foreach($products as $product)
                    <tr class="group hover:bg-neutral-50 transition duration-200">
                        {{-- Product Info + Image --}}
                        <td class="py-4 pl-2">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-16 bg-neutral-100 overflow-hidden relative">
                                    {{-- Smart Image Path with Slug --}}
                                    @php
                                    $prodSlug = $product->slug ?? '';
                                    $prodImg = $product->image ?? null;
                                    $prodImgSrc = 'https://placehold.co/150x200?text=No+Image';

                                    if ($prodSlug && $prodImg) {
                                    if (Str::startsWith($prodImg, ['http://', 'https://'])) {
                                    $prodImgSrc = $prodImg;
                                    } else {
                                    $prodImgSrc = asset('storage/products/' . $prodSlug . '/' . basename($prodImg));
                                    }
                                    }
                                    @endphp
                                    <img src="{{ $prodImgSrc }}"
                                        class="w-full h-full object-cover mix-blend-multiply filter grayscale group-hover:grayscale-0 transition duration-500"
                                        onerror="this.src='https://placehold.co/150x200?text=No+Image'">
                                </div>
                                <div>
                                    <div class="font-bold text-neutral-900 leading-tight mb-1">{{ $product->name }}
                                    </div>
                                    <div class="font-mono text-xs text-neutral-400">SKU: {{ $product->sku ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td class="py-4 text-neutral-600">
                            {{ ucfirst($product->category ?? 'Uncategorized') }}
                        </td>

                        {{-- Status Badge (Minimal Pill) --}}
                        <td class="py-4">
                            <span
                                class="inline-flex items-center gap-1.5 px-2 py-1 rounded border border-neutral-200 text-[10px] font-bold uppercase tracking-wider
                                    {{ $product->stock > 0 ? 'text-neutral-600' : 'text-neutral-400 bg-neutral-100 decoration-line-through' }}">
                                <span
                                    class="w-1.5 h-1.5 rounded-full {{ $product->stock > 0 ? 'bg-green-500' : 'bg-neutral-400' }}"></span>
                                {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </td>

                        {{-- Price (Monospace) --}}
                        <td class="py-4 text-right font-mono text-neutral-900">
                            {{ number_format($product->base_price ?? 0, 0, ',', '.') }}₫
                        </td>

                        {{-- Actions --}}
                        <td class="py-4 pr-2 text-right">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="text-neutral-400 hover:text-black transition p-2">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination Minimal --}}
        <div class="mt-8">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>