@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-gray-100">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-3 py-2 rounded-md bg-indigo-600 hover:bg-indigo-500 text-white">Add New</a>
</div>

<form method="GET" action="{{ route('admin.products.index') }}" class="mb-6">
    <div class="flex gap-2">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search products..." class="w-full px-3 py-2 rounded-md bg-[#0d1426] border border-gray-700 text-gray-100 placeholder-gray-400">
        <button class="px-3 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-100">Search</button>
    </div>
    @if($search !== '')
        <p class="mt-2 text-sm text-gray-400">Showing results for "{{ $search }}"</p>
    @endif
    </form>

<div class="overflow-hidden rounded-xl border border-gray-700 bg-[#0d1426]">
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-[#0b1220]">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">Image</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">Price</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-300">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
            @foreach($products as $p)
                <tr class="odd:bg-[#0d1426] even:bg-[#101831]">
                    <td class="px-4 py-3 text-sm text-gray-300">{{ $p->id }}</td>
                    <td class="px-4 py-3">
                        @if($p->image)
                            <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" class="w-14 h-14 object-cover rounded-md border border-gray-700">
                        @else
                            <span class="text-xs text-gray-500">No image</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-100">{{ $p->name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-200">${{ number_format((float) $p->price, 2) }}</td>
                    <td class="px-4 py-3 text-sm text-right">
                        <a href="{{ route('admin.products.edit', $p) }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-100 mr-2">Edit</a>
                        <div x-data="{ open:false }" class="inline">
                            <button @click="open=true" class="inline-flex items-center px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-500 text-white">Delete</button>
                            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
                                <div class="w-full max-w-md rounded-xl bg-[#0d1426] border border-gray-700 p-6">
                                    <h3 class="text-lg font-semibold text-gray-100">Confirm delete</h3>
                                    <p class="mt-2 text-sm text-gray-300">This product will be soft-deleted. Continue?</p>
                                    <div class="mt-4 flex justify-end gap-2">
                                        <button @click="open=false" class="px-3 py-1.5 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-100">Cancel</button>
                                        <form method="POST" action="{{ route('admin.products.destroy', $p) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-500 text-white">Delete</button>
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