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

    {{-- FLASH MESSAGES --}}
    @if (session('success'))
    <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-800 text-sm flex items-center gap-3">
        <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if (session('error'))
    <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 text-red-800 text-sm flex items-center gap-3">
        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

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
                            {{ $product->category?->name ?? 'Uncategorized' }}
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
                            <div class="flex items-center justify-end gap-3">
                                {{-- Edit Button --}}
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="text-neutral-400 hover:text-black transition-colors" title="Edit">
                                    <span class="sr-only">Edit</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </a>

                                {{-- Delete Button (SweetAlert2) --}}
                                <form id="delete-form-{{ $product->id }}"
                                    action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                        class="text-neutral-400 hover:text-red-600 transition-colors" title="Delete">
                                        <span class="sr-only">Delete</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
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

    @push('scripts')
    <script>
        function confirmDelete(productId, productName) {
            Swal.fire({
                title: 'Delete Product?',
                html: `<p class="text-gray-600">You are about to delete: <span class="font-semibold text-black">${productName}</span></p>
                       <p class="text-sm text-red-500 mt-2">This action cannot be undone.</p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000000',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-none',
                    confirmButton: 'rounded-none font-bold uppercase tracking-wider text-xs px-6 py-3',
                    cancelButton: 'rounded-none font-bold uppercase tracking-wider text-xs px-6 py-3',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${productId}`).submit();
                }
            });
        }
    </script>
    @endpush
</x-admin-layout>