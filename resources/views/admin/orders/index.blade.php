@extends('layouts.admin')

@php($breadcrumb = [ ['label' => 'Orders'] ])

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold text-ink">Orders</h1>
    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap items-center gap-2">
        <input type="text" name="q" value="{{ $search }}" placeholder="Search by user or status..."
            class="w-40 sm:w-64 px-3 py-2 rounded-lg bg-white border border-beige text-ink placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200 dark:placeholder-slate-400">
        <input type="date" name="from" value="{{ $from }}"
            class="px-3 py-2 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200"
            aria-label="From date">
        <span class="text-gray-600">–</span>
        <input type="date" name="to" value="{{ $to }}"
            class="px-3 py-2 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200"
            aria-label="To date">
        <select name="status"
            class="px-3 py-2 rounded-lg bg-white border border-beige text-ink focus:border-indigo-500 focus:ring-indigo-500 shadow-soft dark:bg-slate-900 dark:border-slate-700 dark:text-slate-200">
            <option value="">All</option>
            <option value="pending" @selected(($status ?? '' )==='pending' )>Pending</option>
            <option value="approved" @selected(($status ?? '' )==='approved' )>Approved</option>
            <option value="shipped" @selected(($status ?? '' )==='shipped' )>Shipped</option>
            <option value="cancelled" @selected(($status ?? '' )==='cancelled' )>Cancelled</option>
        </select>
        <button class="px-3 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white">Apply</button>
        <a href="{{ route('admin.orders.index') }}"
            class="px-3 py-2 rounded-md border border-beige text-ink hover:bg-beige">Clear</a>
    </form>
</div>

@if(session('success'))
<div class="mb-6 rounded-md border border-green-200 bg-green-50 text-green-700 px-4 py-2">{{ session('success') }}</div>
@endif

<div
    class="overflow-hidden rounded-xl border border-beige bg-white shadow-soft dark:bg-slate-900 dark:border-slate-700">
    <table class="min-w-full divide-y divide-beige">
        <thead class="bg-warm dark:bg-slate-800">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 dark:text-slate-200">ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Date</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">User</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Total</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 dark:text-slate-300">Status</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-300 dark:text-slate-300">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-beige dark:divide-slate-700">
            @forelse($orders as $order)
            <tr class="odd:bg-white even:bg-warm dark:odd:bg-slate-900 dark:even:bg-slate-800">
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-slate-200">#{{ $order->id }}</td>
                <td class="px-4 py-3 text-sm text-gray-700 dark:text-slate-200">{{ $order->created_at->format('M d, Y
                    H:i') }}</td>
                <td class="px-4 py-3 text-sm text-ink dark:text-slate-200">
                    <div>{{ $order->user->name ?? 'User' }}</div>
                    <div class="text-gray-600 text-xs dark:text-slate-400">{{ $order->user->email ?? '' }}</div>
                </td>
                <td class="px-4 py-3 text-sm text-ink dark:text-slate-200">₫{{
                    number_format((float)$order->total_amount, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-sm">
                    @php($badge = match($order->status){
                    'pending' => ['Pending','bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200','dark:bg-yellow-900
                    dark:text-yellow-200 dark:ring-yellow-800'],
                    'approved' => ['Approved','bg-blue-50 text-blue-700 ring-1 ring-blue-200','dark:bg-blue-900
                    dark:text-blue-200 dark:ring-blue-800'],
                    'shipped' => ['Shipped','bg-green-50 text-green-700 ring-1 ring-green-200','dark:bg-green-900
                    dark:text-green-200 dark:ring-green-800'],
                    'cancelled' => ['Cancelled','bg-red-50 text-red-700 ring-1 ring-red-200','dark:bg-red-900
                    dark:text-red-200 dark:ring-red-800'],
                    default => ['Pending','bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200','dark:bg-yellow-900
                    dark:text-yellow-200 dark:ring-yellow-800']
                    })
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-xs {{ $badge[1] }} {{ $badge[2] }}">{{
                        $badge[0] }}</span>
                </td>
                <td class="px-4 py-3 text-sm text-right">
                    <a href="{{ route('admin.orders.show', $order) }}"
                        class="inline-flex items-center px-3 py-1.5 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white mr-2">View</a>
                    <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="inline">
                        @csrf
                        <input type="hidden" name="status" value="approved">
                        <button
                            class="inline-flex items-center px-3 py-1.5 rounded-md bg-green-600 hover:bg-green-500 text-white mr-2">Approve</button>
                    </form>
                    <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="inline">
                        @csrf
                        <input type="hidden" name="status" value="shipped">
                        <button
                            class="inline-flex items-center px-3 py-1.5 rounded-md bg-blue-600 hover:bg-blue-500 text-white mr-2">Mark
                            Shipped</button>
                    </form>
                    <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="inline">
                        @csrf
                        <input type="hidden" name="status" value="cancelled">
                        <button
                            class="inline-flex items-center px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-500 text-white">Cancel</button>
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