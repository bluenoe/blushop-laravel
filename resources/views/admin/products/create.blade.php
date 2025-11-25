@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-semibold text-ink mb-6">Add Product</h1>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @csrf
    <div class="space-y-4">
        <div>
            <label class="block text-sm text-ink mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
        </div>
        <div>
            <label class="block text-sm text-ink mb-1">Category</label>
            <select name="category_id" required class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
                <option value="">Select a category…</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-ink mb-1">Price</label>
            <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" required class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
        </div>
        <div>
            <label class="block text-sm text-ink mb-1">Description</label>
            <textarea name="description" rows="6" class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">{{ old('description') }}</textarea>
        </div>
    </div>
    <div class="space-y-4">
        <div>
            <label class="block text-sm text-ink mb-1">Image</label>
            <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
            <p class="mt-1 text-xs text-gray-600">PNG/JPG/WebP — max 2MB</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_new" value="1" {{ old('is_new') ? 'checked' : '' }} class="rounded border-beige text-indigo-600 focus:ring-indigo-500">
                Mark as New
            </label>
            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller') ? 'checked' : '' }} class="rounded border-beige text-indigo-600 focus:ring-indigo-500">
                Mark as Bestseller
            </label>
            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                <input type="checkbox" name="is_on_sale" value="1" {{ old('is_on_sale') ? 'checked' : '' }} class="rounded border-beige text-indigo-600 focus:ring-indigo-500">
                Mark as On sale
            </label>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-md border border-beige text-ink hover:bg-beige">Cancel</a>
            <button class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white">Create</button>
        </div>
    </div>
</form>
@endsection
