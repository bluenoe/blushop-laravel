@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-semibold text-ink mb-6">Edit Category</h1>

<form method="POST" action="{{ route('admin.categories.update', $category) }}" class="max-w-xl space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm text-ink mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
    </div>
    <div>
        <label class="block text-sm text-ink mb-1">Slug</label>
        <div class="flex items-center gap-2">
            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" x-ref="slug" readonly class="flex-1 px-3 py-2 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
            <label class="inline-flex items-center gap-2 text-xs text-gray-700">
                <input type="checkbox" x-on:change="$refs.slug.readOnly = !$refs.slug.readOnly" class="rounded">
                Edit
            </label>
        </div>
        <p class="mt-1 text-xs text-gray-600">Auto-generated from name; toggle to override.</p>
    </div>
    <div>
        <label class="block text-sm text-ink mb-1">Description</label>
        <textarea name="description" rows="4" class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">{{ old('description', $category->description) }}</textarea>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-md border border-beige text-ink hover:bg-beige">Cancel</a>
        <button class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white">Save Changes</button>
    </div>
</form>
@endsection