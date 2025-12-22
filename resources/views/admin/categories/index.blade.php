<x-admin-layout>
    {{-- HEADER SECTION --}}
    <div class="flex items-center justify-between mb-10">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-neutral-400 mb-1">Organization</p>
            <h1 class="text-3xl font-bold tracking-tighter">Categories</h1>
        </div>
        <a href="{{ route('admin.categories.create') }}"
            class="px-6 py-2.5 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition">
            + New Category
        </a>
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
    <div class="bg-white">
        @if($categories->isEmpty())
        <div class="flex flex-col items-center justify-center h-64 text-neutral-400">
            <p class="text-sm font-light mb-4">No categories found.</p>
            <a href="{{ route('admin.categories.create') }}"
                class="underline decoration-1 underline-offset-4 hover:text-black">Create your first category</a>
        </div>
        @else
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-neutral-100 text-[10px] uppercase tracking-[0.2em] text-neutral-400">
                    <th class="py-4 pl-2 font-medium">Category Name</th>
                    <th class="py-4 font-medium">Slug</th>
                    <th class="py-4 font-medium text-right">Products</th>
                    <th class="py-4 pr-2 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-50 text-sm">
                @foreach($categories as $cat)
                <tr class="group hover:bg-neutral-50 transition">
                    <td class="py-4 pl-2">
                        <span class="font-bold text-neutral-900">{{ $cat->name }}</span>
                    </td>
                    <td class="py-4 text-neutral-500 font-mono text-xs">{{ $cat->slug }}</td>
                    <td class="py-4 text-right font-mono">
                        <span class="{{ $cat->products_count > 0 ? 'text-black' : 'text-neutral-400' }}">
                            {{ $cat->products_count }}
                        </span>
                    </td>
                    <td class="py-4 pr-2 text-right">
                        <div class="flex items-center justify-end gap-3">
                            {{-- Edit Button --}}
                            <a href="{{ route('admin.categories.edit', $cat->id) }}"
                                class="text-neutral-400 hover:text-black transition-colors" title="Edit">
                                <span class="sr-only">Edit</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </a>

                            {{-- Delete Button (SweetAlert2) --}}
                            <form id="delete-form-{{ $cat->id }}"
                                action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    onclick="confirmDeleteCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}', {{ $cat->products_count }})"
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
        <div class="mt-4">{{ $categories->links() }}</div>
        @endif
    </div>

    @push('scripts')
    <script>
        function confirmDeleteCategory(categoryId, categoryName, productCount) {
            // If category has products, show warning that deletion will be blocked
            let warningHtml = '';
            if (productCount > 0) {
                warningHtml = `<p class="text-sm text-amber-600 mt-2 font-medium">⚠️ This category has ${productCount} product(s). Deletion will be blocked by the server.</p>`;
            }

            Swal.fire({
                title: 'Delete Category?',
                html: `<p class="text-gray-600">You are about to delete: <span class="font-semibold text-black">${categoryName}</span></p>
                       <p class="text-sm text-red-500 mt-2">This action cannot be undone.</p>${warningHtml}`,
                icon: productCount > 0 ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: '#000000',
                cancelButtonColor: '#6b7280',
                confirmButtonText: productCount > 0 ? 'Try Anyway' : 'Yes, Delete',
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
                    document.getElementById(`delete-form-${categoryId}`).submit();
                }
            });
        }
    </script>
    @endpush
</x-admin-layout>