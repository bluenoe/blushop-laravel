@extends('layouts.admin')

@php($breadcrumb = [ ['label' => 'Orders', 'url' => route('admin.orders.index')], ['label' => '#'.$order->id] ])

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-xl font-semibold text-ink">Order #{{ $order->id }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-3 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white">Back to Orders</a>
    </div>

@if(session('success'))
    <div class="mb-6 rounded-md border border-green-200 bg-green-50 text-green-700 px-4 py-2">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 rounded-xl bg-white border border-beige p-6 shadow-soft dark:bg-slate-900 dark:border-slate-700">
        <h2 class="text-lg font-semibold text-ink mb-4">Items</h2>
        <ul class="divide-y divide-beige">
            @foreach($order->orderItems as $item)
                <li class="py-4 flex items-center gap-4">
                    <img src="{{ Storage::url('products/' . ($item->product->image ?? '')) }}" alt="{{ $item->product->name ?? 'Product' }}" class="w-16 h-16 rounded-md object-cover" />
                    <div class="flex-1">
                        <div class="text-ink font-medium">{{ $item->product->name ?? 'Product' }}</div>
                        <div class="text-sm text-gray-700">Qty: {{ $item->quantity }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-ink font-medium">₫{{ number_format((float)$item->price_at_purchase, 0, ',', '.') }}</div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="rounded-xl bg-white border border-beige p-6 shadow-soft dark:bg-slate-900 dark:border-slate-700">
        <h2 class="text-lg font-semibold text-ink mb-4">Summary</h2>
        <dl class="space-y-3">
            <div class="flex justify-between">
                <dt class="text-sm text-gray-700">Placed</dt>
                <dd class="text-sm text-ink">{{ $order->created_at->format('M d, Y H:i') }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-700">Customer</dt>
                <dd class="text-sm text-ink">{{ $order->user->name ?? 'User' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-700">Email</dt>
                <dd class="text-sm text-ink">{{ $order->user->email ?? '' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-700">Total</dt>
                <dd class="text-sm text-ink">₫{{ number_format((float)$order->total_amount, 0, ',', '.') }}</dd>
            </div>
            <div class="flex items-center justify-between">
                <dt class="text-sm text-gray-700">Status</dt>
                <dd>
                    @php($badge = match($order->status){
                        'pending' => ['Pending','bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200','dark:bg-yellow-900 dark:text-yellow-200 dark:ring-yellow-800'],
                        'approved' => ['Approved','bg-blue-50 text-blue-700 ring-1 ring-blue-200','dark:bg-blue-900 dark:text-blue-200 dark:ring-blue-800'],
                        'shipped' => ['Shipped','bg-green-50 text-green-700 ring-1 ring-green-200','dark:bg-green-900 dark:text-green-200 dark:ring-green-800'],
                        'cancelled' => ['Cancelled','bg-red-50 text-red-700 ring-1 ring-red-200','dark:bg-red-900 dark:text-red-200 dark:ring-red-800'],
                        default => ['Pending','bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200','dark:bg-yellow-900 dark:text-yellow-200 dark:ring-yellow-800']
                    })
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs {{ $badge[1] }} {{ $badge[2] }}">{{ $badge[0] }}</span>
                </dd>
            </div>
        </dl>

        <div class="mt-6 space-y-2">
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf
                <input type="hidden" name="status" value="approved">
            <button class="w-full inline-flex items-center justify-center px-3 py-2 rounded-md bg-green-600 hover:bg-green-700 text-white">Approve</button>
            </form>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf
                <input type="hidden" name="status" value="shipped">
            <button class="w-full inline-flex items-center justify-center px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white">Mark Shipped</button>
            </form>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf
                <input type="hidden" name="status" value="pending">
            <button class="w-full inline-flex items-center justify-center px-3 py-2 rounded-md border border-beige text-ink hover:bg-beige">Set Pending</button>
            </form>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf
                <input type="hidden" name="status" value="cancelled">
            <button class="w-full inline-flex items-center justify-center px-3 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection
