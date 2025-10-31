@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-xl font-semibold text-gray-100">Order #{{ $order->id }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-3 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-100">Back to Orders</a>
    </div>

@if(session('success'))
    <div class="mb-6 rounded-md bg-emerald-900/40 border border-emerald-700 text-emerald-200 px-4 py-2">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 rounded-xl bg-[#0d1426] border border-gray-700 p-6">
        <h2 class="text-lg font-semibold text-gray-100 mb-4">Items</h2>
        <ul class="divide-y divide-gray-700">
            @foreach($order->orderItems as $item)
                <li class="py-4 flex items-center gap-4">
                    <img src="{{ Storage::url('products/' . ($item->product->image ?? '')) }}" alt="{{ $item->product->name ?? 'Product' }}" class="w-16 h-16 rounded-md object-cover" />
                    <div class="flex-1">
                        <div class="text-gray-100 font-medium">{{ $item->product->name ?? 'Product' }}</div>
                        <div class="text-sm text-gray-400">Qty: {{ $item->quantity }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-gray-100 font-medium">₫{{ number_format((float)$item->price_at_purchase, 0, ',', '.') }}</div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="rounded-xl bg-[#0d1426] border border-gray-700 p-6">
        <h2 class="text-lg font-semibold text-gray-100 mb-4">Summary</h2>
        <dl class="space-y-3">
            <div class="flex justify-between">
                <dt class="text-sm text-gray-400">Placed</dt>
                <dd class="text-sm text-gray-100">{{ $order->created_at->format('M d, Y H:i') }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-400">Customer</dt>
                <dd class="text-sm text-gray-100">{{ $order->user->name ?? 'User' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-400">Email</dt>
                <dd class="text-sm text-gray-100">{{ $order->user->email ?? '' }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-sm text-gray-400">Total</dt>
                <dd class="text-sm text-gray-100">₫{{ number_format((float)$order->total_amount, 0, ',', '.') }}</dd>
            </div>
            <div class="flex items-center justify-between">
                <dt class="text-sm text-gray-400">Status</dt>
                <dd>
                    @php($badge = match($order->status){
                        'pending' => ['Pending','bg-gray-700 text-gray-200'],
                        'approved' => ['Approved','bg-blue-700 text-blue-100'],
                        'shipped' => ['Shipped','bg-green-700 text-green-100'],
                        'cancelled' => ['Cancelled','bg-red-700 text-red-100'],
                        default => ['Pending','bg-gray-700 text-gray-200']
                    })
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs {{ $badge[1] }}">{{ $badge[0] }}</span>
                </dd>
            </div>
        </dl>

        <div class="mt-6 space-y-2">
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf
                <input type="hidden" name="status" value="approved">
                <button class="w-full inline-flex items-center justify-center px-3 py-2 rounded-md bg-green-600 hover:bg-green-500 text-white">Approve</button>
            </form>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf
                <input type="hidden" name="status" value="shipped">
                <button class="w-full inline-flex items-center justify-center px-3 py-2 rounded-md bg-blue-600 hover:bg-blue-500 text-white">Mark Shipped</button>
            </form>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf
                <input type="hidden" name="status" value="pending">
                <button class="w-full inline-flex items-center justify-center px-3 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-100">Set Pending</button>
            </form>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf
                <input type="hidden" name="status" value="cancelled">
                <button class="w-full inline-flex items-center justify-center px-3 py-2 rounded-md bg-red-600 hover:bg-red-500 text-white">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection