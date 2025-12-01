@extends('layouts.admin')

@php($breadcrumb = [ ['label' => 'Users'] ])

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-ink">Users</h1>
</div>

<form method="GET" action="{{ route('admin.users.index') }}" class="mb-6">
    <div class="flex flex-wrap items-center gap-2">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search users..."
            class="flex-1 min-w-[200px] px-3 py-2 rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200 dark:placeholder-slate-400">
        <select name="role"
            class="px-3 py-2 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200">
            <option value="">All roles</option>
            <option value="admin" @selected(($role ?? '' )==='admin' )>Admin</option>
            <option value="user" @selected(($role ?? '' )==='user' )>User</option>
        </select>
        <button class="px-3 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white">Apply</button>
        <a href="{{ route('admin.users.index') }}"
            class="px-3 py-2 rounded-md border border-beige text-ink hover:bg-beige">Clear</a>
    </div>
    @if(($search ?? '') !== '')
    <p class="mt-2 text-sm text-gray-400">Showing results for "{{ $search }}"</p>
    @endif
</form>

<div class="overflow-hidden rounded-xl border border-beige bg-white shadow-soft dark:bg-slate-900 dark:border-slate-700">
    <table class="min-w-full divide-y divide-beige">
        <thead class="bg-warm dark:bg-slate-800">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Email</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Admin</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-300 dark:text-slate-300">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-beige dark:divide-slate-700">
            @foreach($users as $u)
            <tr class="odd:bg-white even:bg-warm dark:odd:bg-slate-900 dark:even:bg-slate-800">
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-slate-200">{{ $u->id }}</td>
                <td class="px-4 py-3 text-sm text-ink dark:text-slate-200">{{ $u->name }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-slate-200">{{ $u->email }}</td>
                <td class="px-4 py-3 text-sm">
                    @if($u->is_admin)
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded bg-green-50 text-green-700 ring-1 ring-green-200 text-xs">Admin</span>
                    @else
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded bg-warm text-ink ring-1 ring-beige text-xs dark:bg-slate-800 dark:text-slate-200 dark:ring-slate-700">User</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-sm text-right">
                    <a href="{{ route('admin.users.edit', $u) }}"
                        class="inline-flex items-center px-3 py-1.5 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white mr-2">Edit</a>
                    <div x-data="{ open:false }" class="inline">
                        <button @click="open=true"
                            class="inline-flex items-center px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-500 text-white">Delete</button>
                        <div x-show="open" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-ink/20">
                            <div class="w-full max-w-md rounded-xl bg-white border border-beige p-6 shadow-soft">
                                <h3 class="text-lg font-semibold text-ink">Confirm delete</h3>
                                <p class="mt-2 text-sm text-gray-700">This will permanently remove the user. Continue?
                                </p>
                                <div class="mt-4 flex justify-end gap-2">
                                    <button @click="open=false"
                                        class="px-3 py-1.5 rounded-md bg-warm hover:bg-beige text-ink ring-1 ring-beige">Cancel</button>
                                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-500 text-white">Delete</button>
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

<div class="mt-6">{{ $users->links() }}</div>
@endsection
