@extends('layouts.admin')

@php($breadcrumb = [ ['label' => 'Products'] ])

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-ink">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-3 py-2 rounded-md bg-indigo-600 hover:bg-indigo-500 text-white">Add New</a>
</div>

<form method="GET" action="{{ route('admin.products.index') }}" class="mb-6">
    <div class="flex gap-2">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search products..." class="w-full px-3 py-2 rounded-md bg-white border border-beige text-ink placeholder-gray-400 shadow-soft dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200 dark:placeholder-slate-400">
        <button class="px-3 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white">Search</button>
    </div>
    @if($search !== '')
        <p class="mt-2 text-sm text-gray-400">Showing results for "{{ $search }}"</p>
    @endif
    </form>

<div class="overflow-hidden rounded-xl border border-beige bg-white shadow-soft dark:bg-slate-900 dark:border-slate-700">
    <table class="min-w-full divide-y divide-beige">
        <thead class="bg-warm dark:bg-slate-800">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 dark:text-slate-200">ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Image</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Category</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Price</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-300 dark:text-slate-300">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-beige dark:divide-slate-700">
            @foreach($products as $p)
                <tr class="odd:bg-white even:bg-warm dark:odd:bg-slate-900 dark:even:bg-slate-800">
                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-slate-200">{{ $p->id }}</td>
                    <td class="px-4 py-3">
                        @if($p->image)
                            <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" class="w-14 h-14 object-cover rounded-md border border-beige">
                        @else
                            <span class="text-xs text-gray-500">No image</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-ink">{{ $p->name }}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($p->category)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-warm text-ink ring-1 ring-beige dark:bg-slate-800 dark:text-slate-200 dark:ring-slate-700">{{ $p->category->name }}</span>
                        @else
                            <span class="text-xs text-gray-500">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-slate-200">${{ number_format((float) $p->price, 2) }}</td>
                    <td class="px-4 py-3 text-sm text-right">
                        <a href="{{ route('admin.products.edit', $p) }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white mr-2">Edit</a>
                        <div x-data="{ open:false }" class="inline">
                            <button @click="open=true" class="inline-flex items-center px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-500 text-white">Delete</button>
                            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-ink/20">
                                <div class="w-full max-w-md rounded-xl bg-white border border-beige p-6 shadow-soft">
                                    <h3 class="text-lg font-semibold text-ink">Confirm delete</h3>
                                    <p class="mt-2 text-sm text-gray-700">This product will be soft-deleted. Continue?</p>
                                    <div class="mt-4 flex justify-end gap-2">
                                        <button @click="open=false" class="px-3 py-1.5 rounded-md bg-warm hover:bg-beige text-ink ring-1 ring-beige">Cancel</button>
                                        <form method="POST" action="{{ route('admin.products.destroy', $p) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
