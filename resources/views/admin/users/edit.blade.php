@extends('layouts.admin')

@php($breadcrumb = [ ['label' => 'Users', 'url' => route('admin.users.index')], ['label' => 'Edit'] ])

@section('content')
<h1 class="text-xl font-semibold text-ink mb-6">Edit User</h1>

<form method="POST" action="{{ route('admin.users.update', $user) }}" class="max-w-xl space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm text-ink mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
    </div>
    <div>
        <label class="block text-sm text-ink mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3 py-2 rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
    </div>
    <div>
        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="is_admin" value="1" @checked(old('is_admin', $user->is_admin)) class="rounded bg-white border-beige text-indigo-600 focus:ring-indigo-500">
            Admin
        </label>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md border border-beige text-ink hover:bg-beige">Cancel</a>
        <button class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white">Save Changes</button>
    </div>
</form>
@endsection
