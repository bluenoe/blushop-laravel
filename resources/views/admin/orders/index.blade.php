@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-gray-100">Orders</h1>
    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-2">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search by user or status..." class="w-64 px-3 py-2 rounded-md bg-[#0d1426] border border-gray-700 text-gray-100 placeholder-gray-400">
        <select name="status" class="px-3 py-2 rounded-md bg-[#0d1426] border border-gray-700 text-gray-100">
            <option value="">All</option>
            <option value="pending" @selected(($status ?? '')==='pending')>Pending</option>
            <option value="approved" @selected(($status ?? '')==='approved')>Approved</option>
            <option value="shipped" @selected(($status ?? '')==='shipped')>Shipped</option>
            <option value="cancelled" @selected(($status ?? '')==='cancelled')>Cancelled</option>
        </select>
        <button class="px-3 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-100">Filter</button>
    </form>
</div>

@if(session('success'))
    <div class="mb-6 rounded-md bg-emerald-900/40 border border-emerald-700 text-emerald-200 px-4 py-2">{{ session('success') }}</div>
@endif

<div class="overflow-hidden rounded-xl border border-gray-700 bg-[#0d1426]">
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-[#0b1220]">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">Date</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">User</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">Total</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300">Status</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-300">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
            @forelse($orders as $order)
                <tr class="odd:bg-[#0d1426] even:bg-[#101831]">
                    <td class="px-4 py-3 text-sm text-gray-300">#{{ $order->id }}</td>
                    <td class="px-4 py-3 text-sm text-gray-300">{{ $order->created_at->format('M d, Y H:i') }}</td>
                    <td class="px-4 py-3 text-sm text-gray-100">
                        <div>{{ $order->user->name ?? 'User' }}</div>
                        <div class="text-gray-400 text-xs">{{ $order->user->email ?? '' }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-100">₫{{ number_format((float)$order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-sm">
                        @php($badge = match($order->status){
                            'pending' => ['Pending','bg-gray-700 text-gray-200'],
                            'approved' => ['Approved','bg-blue-700 text-blue-100'],
                            'shipped' => ['Shipped','bg-green-700 text-green-100'],
                            'cancelled' => ['Cancelled','bg-red-700 text-red-100'],
                            default => ['Pending','bg-gray-700 text-gray-200']
                        })
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs {{ $badge[1] }}">{{ $badge[0] }}</span>
                    </td>
                    <td class="px-4 py-3 text-sm text-right">
                        <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-100 mr-2">View</a>
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