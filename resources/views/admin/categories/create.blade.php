@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-semibold text-gray-100 mb-6">Add Category</h1>

<form method="POST" action="{{ route('admin.categories.store') }}" class="max-w-xl space-y-4">
    @csrf
    <div>
        <label class="block text-sm text-gray-300 mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 rounded-md bg-[#0d1426] border border-gray-700 text-gray-100">
    </div>
    <div>
        <label class="block text-sm text-gray-300 mb-1">Slug (optional)</label>
        <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-3 py-2 rounded-md bg-[#0d1426] border border-gray-700 text-gray-100">
        <p class="mt-1 text-xs text-gray-400">Leave blank to auto-generate.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-100">Cancel</a>
        <button class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-500 text-white">Create</button>
    </div>
</form>
@endsection