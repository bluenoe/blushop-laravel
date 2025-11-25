@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-semibold text-ink mb-6">Edit Product</h1>

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @csrf
    @method('PUT')
    <div class="space-y-4">
        <div>
            <label class="block text-sm text-ink mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
        </div>
        <div>
            <label class="block text-sm text-ink mb-1">Category</label>
            <select name="category_id" required class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
                <option value="">Select a category…</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-ink mb-1">Price</label>
            <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" required class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
        </div>
        <div>
            <label class="block text-sm text-ink mb-1">Description</label>
            <textarea name="description" rows="6" class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">{{ old('description', $product->description) }}</textarea>
        </div>
    </div>
    <div class="space-y-4">
        <div>
            <label class="block text-sm text-ink mb-1">Image</label>
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-24 h-24 object-cover rounded-md border border-beige mb-2">
            @endif
            <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
            <p class="mt-1 text-xs text-gray-600">PNG/JPG/WebP — max 2MB</p>
        </div>
        <div class="flex gap-2">
        <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-md border border-beige text-ink hover:bg-beige">Cancel</a>
        <button class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white">Save Changes</button>
        </div>
    </div>
</form>
@endsection