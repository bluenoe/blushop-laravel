<x-app-layout>
    <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-ink">Admin • Orders</h1>
            <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-center gap-2">
                <select name="status" class="rounded-lg bg-white border border-beige text-ink px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 shadow-soft">
                    <option value="">All</option>
                    <option value="pending" @selected(($status ?? '')==='pending')>Pending</option>
                    <option value="paid" @selected(($status ?? '')==='paid')>Paid</option>
                    <option value="cancelled" @selected(($status ?? '')==='cancelled')>Cancelled</option>
                </select>
                <button class="rounded-md bg-indigo-600 text-white px-4 py-2 font-semibold hover:bg-indigo-500">Filter</button>
            </form>
        </div>

        @if (session('success'))
            <div class="mt-4 rounded-md border border-green-200 bg-green-50 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-8 space-y-4">
            @forelse($orders as $order)
                <div class="rounded-xl border border-beige bg-white shadow-soft overflow-hidden">
                    <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-5 gap-4 items-center">
                        <div>
                            <p class="text-sm text-gray-700">#{{ $order->id }}</p>
                            <p class="text-sm text-gray-700">{{ $order->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-ink font-semibold">{{ $order->user->name ?? 'User' }}</p>
                            <p class="text-sm text-gray-700">{{ $order->user->email ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-ink">₫{{ number_format((float)$order->total_amount, 0, ',', '.') }}</p>
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                {{ $order->payment_status === 'paid' ? 'bg-green-50 text-green-700 ring-1 ring-green-200' : ($order->payment_status === 'cancelled' ? 'bg-red-50 text-red-700 ring-1 ring-red-200' : 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div class="sm:col-span-2 flex gap-2 sm:justify-end">
                            <form method="POST" action="{{ route('admin.orders.approve', $order) }}">
                                @csrf
                                <button class="rounded-md bg-green-600 text-white px-3 py-2 hover:bg-green-500">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('admin.orders.ship', $order) }}">
                                @csrf
                                <button class="rounded-md bg-blue-600 text-white px-3 py-2 hover:bg-blue-500">Mark Shipped</button>
                            </form>
                            <form method="POST" action="{{ route('admin.orders.cancel', $order) }}">
                                @csrf
                                <button class="rounded-md bg-red-600 text-white px-3 py-2 hover:bg-red-500">Cancel</button>
                            </form>
                        </div>
                    </div>
                        <div class="border-t border-beige">
                        <ul>
                            @foreach($order->orderItems as $item)
                                <li class="p-4 sm:p-6 flex items-center gap-4">
                                    <img src="{{ Storage::url('products/' . ($item->product->image ?? '')) }}" alt="{{ $item->product->name ?? 'Product' }}" class="w-14 h-14 rounded-md object-cover" />
                                    <div class="flex-1">
                                        <p class="text-ink font-semibold">{{ $item->product->name ?? 'Product' }}</p>
                                        <p class="text-sm text-gray-700">Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-ink font-medium">₫{{ number_format((float)$item->price_at_purchase, 0, ',', '.') }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 p-4">
                    No orders found.
                </div>
            @endforelse
        </div>
    </section>
</x-app-layout>