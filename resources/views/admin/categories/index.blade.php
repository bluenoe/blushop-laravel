<x-admin-layout>
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

    <div class="bg-white">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-neutral-100 text-[10px] uppercase tracking-[0.2em] text-neutral-400">
                    <th class="py-4 pl-2 font-medium">Category Name</th>
                    <th class="py-4 font-medium">Slug</th>
                    <th class="py-4 font-medium text-right">Items</th>
                    <th class="py-4 pr-2 font-medium text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-50 text-sm">
                @foreach($categories as $cat)
                <tr class="group hover:bg-neutral-50 transition">
                    <td class="py-4 pl-2">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-neutral-100 overflow-hidden">
                                @if($cat->image)
                                <img src="{{ Storage::url('categories/'.$cat->image) }}"
                                    class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full flex items-center justify-center text-neutral-400 text-xs">IMG
                                </div>
                                @endif
                            </div>
                            <span class="font-bold text-neutral-900">{{ $cat->name }}</span>
                        </div>
                    </td>
                    <td class="py-4 text-neutral-500 font-mono text-xs">{{ $cat->slug }}</td>
                    <td class="py-4 text-right font-mono">{{ $cat->products_count }}</td>
                    <td class="py-4 pr-2 text-right">
                        <a href="{{ route('admin.categories.edit', $cat->id) }}"
                            class="text-neutral-400 hover:text-black transition text-xs font-bold uppercase tracking-wider">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $categories->links() }}</div>
    </div>
</x-admin-layout>