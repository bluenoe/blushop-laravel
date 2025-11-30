@extends('layouts.admin')

@php($breadcrumb = [ ['label' => 'Orders'] ])

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-ink">Orders</h1>
    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-2">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search by user or status..." class="w-64 px-3 py-2 rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
        <select name="status" class="px-3 py-2 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
            <option value="">All</option>
            <option value="pending" @selected(($status ?? '')==='pending')>Pending</option>
            <option value="approved" @selected(($status ?? '')==='approved')>Approved</option>
            <option value="shipped" @selected(($status ?? '')==='shipped')>Shipped</option>
            <option value="cancelled" @selected(($status ?? '')==='cancelled')>Cancelled</option>
        </select>
        <button class="px-3 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white">Filter</button>
    </form>
</div>

@if(session('success'))
    <div class="mb-6 rounded-md border border-green-200 bg-green-50 text-green-700 px-4 py-2">{{ session('success') }}</div>
@endif

<div class="overflow-hidden rounded-xl border border-beige bg-white shadow-soft">
    <table class="min-w-full divide-y divide-beige">
        <thead class="bg-warm">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700">ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">Date</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">User</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">Total</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">Status</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-300">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-beige">
            @forelse($orders as $order)
                <tr class="odd:bg-white even:bg-warm">
                    <td class="px-4 py-3 text-sm text-gray-700">#{{ $order->id }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $order->created_at->format('M d, Y H:i') }}</td>
                    <td class="px-4 py-3 text-sm text-ink">
                        <div>{{ $order->user->name ?? 'User' }}</div>
                        <div class="text-gray-600 text-xs">{{ $order->user->email ?? '' }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-ink">₫{{ number_format((float)$order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-sm">
                        @php($badge = match($order->status){
                            'pending' => ['Pending','bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200'],
                            'approved' => ['Approved','bg-blue-50 text-blue-700 ring-1 ring-blue-200'],
                            'shipped' => ['Shipped','bg-green-50 text-green-700 ring-1 ring-green-200'],
                            'cancelled' => ['Cancelled','bg-red-50 text-red-700 ring-1 ring-red-200'],
                            default => ['Pending','bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200']
                        })
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs {{ $badge[1] }}">{{ $badge[0] }}</span>
                    </td>
                    <td class="px-4 py-3 text-sm text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white mr-2">View</a>
                        <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="approved">
                            <button class="inline-flex items-center px-3 py-1.5 rounded-md bg-green-600 hover:bg-green-500 text-white mr-2">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="shipped">
                            <button class="inline-flex items-center px-3 py-1.5 rounded-md bg-blue-600 hover:bg-blue-500 text-white mr-2">Mark Shipped</button>
                        </form>
                        <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="inline">
                            @csrf
                            <input type="hidden" name="status" value="cancelled">
                            <button class="inline-flex items-center px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-500 text-white">Cancel</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-sm text-center text-gray-300">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $orders->links() }}</div>
@endsection
