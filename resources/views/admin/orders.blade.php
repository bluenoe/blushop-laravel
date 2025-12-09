@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-neutral-900 tracking-tight">Orders</h1>
            <p class="text-sm text-neutral-500 mt-1">Manage and track customer purchases.</p>
        </div>

        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-end gap-4" x-data>
            <div class="relative group">
                <label for="status" class="block text-[10px] uppercase tracking-widest text-neutral-400 mb-1">Filter
                    Status</label>
                <select name="status" id="status" onchange="this.form.submit()"
                    class="appearance-none bg-transparent border-b border-neutral-300 text-neutral-900 py-1 pr-8 pl-0 focus:outline-none focus:border-black cursor-pointer text-sm w-32 rounded-none transition-colors">
                    <option value="">All Orders</option>
                    <option value="pending" @selected(($status ?? '' )==='pending' )>Pending</option>
                    <option value="paid" @selected(($status ?? '' )==='paid' )>Paid</option>
                    <option value="cancelled" @selected(($status ?? '' )==='cancelled' )>Cancelled</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-end pb-2 px-0 text-neutral-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </div>
            </div>
        </form>
    </div>

    @if (session('success'))
    <div class="bg-neutral-900 text-white text-sm px-4 py-3 flex justify-between items-center" x-data="{show: true}"
        x-show="show">
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="text-neutral-400 hover:text-white">&times;</button>
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-neutral-200">
                    <th class="py-3 px-4 text-[10px] uppercase tracking-widest text-neutral-400 font-semibold w-24">
                        Order ID</th>
                    <th class="py-3 px-4 text-[10px] uppercase tracking-widest text-neutral-400 font-semibold">Date</th>
                    <th class="py-3 px-4 text-[10px] uppercase tracking-widest text-neutral-400 font-semibold">Customer
                    </th>
                    <th
                        class="py-3 px-4 text-[10px] uppercase tracking-widest text-neutral-400 font-semibold text-right">
                        Total</th>
                    <th
                        class="py-3 px-4 text-[10px] uppercase tracking-widest text-neutral-400 font-semibold text-center">
                        Status</th>
                    <th
                        class="py-3 px-4 text-[10px] uppercase tracking-widest text-neutral-400 font-semibold text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-100 text-sm">
                @forelse($orders as $order)
                <tr class="group hover:bg-neutral-50 transition-colors">
                    <td class="py-4 px-4 font-mono text-neutral-500">#{{ $order->id }}</td>
                    <td class="py-4 px-4 text-neutral-600">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="py-4 px-4">
                        <div class="font-medium text-neutral-900">{{ $order->user->name ?? 'Guest' }}</div>
                        <div class="text-xs text-neutral-400">{{ $order->user->email ?? '' }}</div>
                    </td>
                    <td class="py-4 px-4 text-right font-medium text-neutral-900">
                        ₫{{ number_format((float)$order->total_amount, 0, ',', '.') }}
                    </td>
                    <td class="py-4 px-4 text-center">
                        @php
                        $statusClasses = match($order->payment_status) {
                        'paid' => 'text-emerald-700 bg-emerald-50 border border-emerald-100',
                        'cancelled' => 'text-red-700 bg-red-50 border border-red-100',
                        default => 'text-amber-700 bg-amber-50 border border-amber-100',
                        };
                        @endphp
                        <span
                            class="inline-block px-2 py-0.5 text-[10px] uppercase tracking-wider font-medium {{ $statusClasses }}">
                            {{ $order->payment_status }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div
                            class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            @if($order->payment_status !== 'paid' && $order->payment_status !== 'cancelled')
                            <form method="POST" action="{{ route('admin.orders.approve', $order) }}">
                                @csrf
                                <button title="Approve"
                                    class="p-1.5 text-neutral-400 hover:text-emerald-600 hover:bg-white border border-transparent hover:border-emerald-200 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                            </form>
                            @endif

                            <form method="POST" action="{{ route('admin.orders.cancel', $order) }}"
                                onsubmit="return confirm('Are you sure?');">
                                @csrf
                                <button title="Cancel"
                                    class="p-1.5 text-neutral-400 hover:text-red-600 hover:bg-white border border-transparent hover:border-red-200 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>

                            <button
                                class="p-1.5 text-neutral-400 hover:text-black hover:bg-white border border-transparent hover:border-neutral-200 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="1.5"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-neutral-400 font-light">
                        No orders found with this status.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection