@extends('layouts.admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="rounded-xl bg-[#0d1426] border border-gray-700 p-6 shadow-sm">
        <div class="text-sm text-gray-400">Products</div>
        <div class="mt-2 text-3xl font-semibold text-gray-100">{{ $stats['products'] }}</div>
    </div>
    <div class="rounded-xl bg-[#0d1426] border border-gray-700 p-6 shadow-sm">
        <div class="text-sm text-gray-400">Users</div>
        <div class="mt-2 text-3xl font-semibold text-gray-100">{{ $stats['users'] }}</div>
    </div>
    <div class="rounded-xl bg-[#0d1426] border border-gray-700 p-6 shadow-sm">
        <div class="text-sm text-gray-400">Orders</div>
        <div class="mt-2 text-3xl font-semibold text-gray-100">{{ $stats['orders'] }}</div>
    </div>
</div>

<div class="mt-8 rounded-xl bg-[#0d1426] border border-gray-700 p-6">
    <h2 class="text-lg font-semibold text-gray-100">Quick Actions</h2>
    <div class="mt-4 flex flex-wrap gap-3">
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-500 text-white">Add Product</a>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-500 text-white">Add Category</a>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-100">Manage Users</a>
    </div>
</div>
@endsection