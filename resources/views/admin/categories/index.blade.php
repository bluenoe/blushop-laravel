@extends('layouts.admin')

@php($breadcrumb = [ ['label' => 'Categories'] ])

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-ink">Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-3 py-2 rounded-md bg-indigo-600 hover:bg-indigo-500 text-white">Add New</a>
</div>

<form method="GET" action="{{ route('admin.categories.index') }}" class="mb-6">
    <div class="flex gap-2">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search categories..." class="w-full px-3 py-2 rounded-md bg-white border border-beige text-ink placeholder-gray-400 shadow-soft dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200 dark:placeholder-slate-400">
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
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Slug</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Products</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-300 dark:text-slate-300">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-beige dark:divide-slate-700">
            @foreach($categories as $c)
                <tr class="odd:bg-white even:bg-warm dark:odd:bg-slate-900 dark:even:bg-slate-800">
                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-slate-200">{{ $c->id }}</td>
                    <td class="px-4 py-3 text-sm text-ink dark:text-slate-200">{{ $c->name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-slate-200">{{ $c->slug }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-slate-200">{{ $c->products_count }}</td>
                    <td class="px-4 py-3 text-sm text-right">
                        <a href="{{ route('admin.categories.edit', $c) }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white mr-2">Edit</a>
                        <div x-data="{ open:false }" class="inline">
                            <button @click="open=true" class="inline-flex items-center px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-500 text-white">Delete</button>
                            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-ink/20">
                                <div class="w-full max-w-md rounded-xl bg-white border border-beige p-6 shadow-soft">
                                    <h3 class="text-lg font-semibold text-ink">Confirm delete</h3>
                                    <p class="mt-2 text-sm text-gray-700">This will permanently remove the category.</p>
                                    @if($c->products_count > 0)
                                        <p class="mt-2 text-sm text-yellow-700">This category currently has products. Please choose a category to reassign them before deletion.</p>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $c) }}" class="mt-4">
                                            @csrf
                                            @method('DELETE')
                                            <label class="block text-sm text-ink mb-1">Reassign products to</label>
                                            <select name="reassign_to" class="w-full px-3 py-2 rounded-md bg-white border border-beige text-ink shadow-soft">
                                                @foreach(($allCategories ?? collect()) as $opt)
                                                    @if($opt->id !== $c->id)
                                                        <option value="{{ $opt->id }}" {{ $opt->slug==='uncategorized' ? 'selected' : '' }}>{{ $opt->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="mt-4 flex justify-end gap-2">
                                                <button type="button" @click="open=false" class="px-3 py-1.5 rounded-md bg-warm hover:bg-beige text-ink ring-1 ring-beige">Cancel</button>
                                                <button class="px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white">Delete</button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="mt-4 flex justify-end gap-2">
                                            <button type="button" @click="open=false" class="px-3 py-1.5 rounded-md bg-warm hover:bg-beige text-ink ring-1 ring-beige">Cancel</button>
                                            <form method="POST" action="{{ route('admin.categories.destroy', $c) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-500 text-white">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $categories->links() }}</div>
@endsection
