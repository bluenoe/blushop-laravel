@extends('layouts.admin')

@section('content')
<h1 class="text-xl font-semibold text-gray-100 mb-6">Edit User</h1>

<form method="POST" action="{{ route('admin.users.update', $user) }}" class="max-w-xl space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm text-gray-300 mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3 py-2 rounded-md bg-[#0d1426] border border-gray-700 text-gray-100">
    </div>
    <div>
        <label class="block text-sm text-gray-300 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3 py-2 rounded-md bg-[#0d1426] border border-gray-700 text-gray-100">
    </div>
    <div>
        <label class="inline-flex items-center gap-2 text-sm text-gray-300">
            <input type="checkbox" name="is_admin" value="1" @checked(old('is_admin', $user->is_admin)) class="rounded bg-[#0d1426] border-gray-700">
            Admin
        </label>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-100">Cancel</a>
        <button class="px-4 py-2 rounded-md bg-indigo-600 hover:bg-indigo-500 text-white">Save Changes</button>
    </div>
</form>
@endsection