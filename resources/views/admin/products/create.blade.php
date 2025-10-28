@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-semibold text-gray-100 mb-6">Add Product</h1>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @csrf
    <div class="space-y-4">
        <div>
            <label class="block text-sm text-gray-300 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 rounded-md bg-[#0d1426] border border-gray-700 text-gray-100">
        </div>
        <div>
            <label class="block text-sm text-gray-300 mb-1">Price</label>
            <input type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" required class="w-full px-3 py-2 rounded-md bg-[#0d1426] border border-gray-700 text-gray-100">
        </div>
        <div>
            <label class="block text-sm text-gray-300 mb-1">Description</label>
            <textarea name="description" rows="6" class="w-full px-3 py-2 rounded-md bg-[#0d1426] border border-gray-700 text-gray-100">{{ old('description') }}</textarea>
        </div>
    </div>
    <div class="space-y-4">
        <div>
            <label class="block text-sm text-gray-300 mb-1">Image</label>
            <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 rounded-md bg-[#0d1426] border border-gray-700 text-gray-100">
            <p class="mt-1 text-xs text-gray-400">PNG/JPG/WebP — max 2MB</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-100">Cancel</a>
            <button class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-500 text-white">Create</button>
        </div>
    </div>
</form>
@endsection