<x-app-layout>
    <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16" x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 300)">
        <div class="flex items-center justify-between" data-reveal="fade-up">
            <h1 class="text-3xl font-bold text-ink">My Orders</h1>
            <a href="{{ route('products.index') }}" class="rounded-md bg-indigo-600 text-white px-4 py-2 font-semibold hover:bg-indigo-500">Shop More</a>
        </div>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity class="mt-4 rounded-md border border-green-200 bg-green-50 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if (($orders ?? collect())->isEmpty())
            <div class="mt-6 rounded-lg border border-yellow-200 bg-yellow-50 text-yellow-700 p-4">
                You have no orders yet.
            </div>
        @else
            <div class="mt-8 space-y-4">
                @foreach($orders as $order)
                    <div class="rounded-xl border border-beige bg-white shadow-soft overflow-hidden" x-data="{ open: false }">
                        <div class="p-4 sm:p-6 flex items-center justify-between">
                            <div class="space-y-1">
                                <p class="text-sm text-gray-700">Order #{{ $order->id }} • {{ $order->created_at->format('M d, Y') }}</p>
                                <p class="text-lg font-semibold text-ink">₫{{ number_format((float)$order->total_amount, 0, ',', '.') }}</p>
                                @php($cls = match($order->status){
                                    'pending' => 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200',
                                    'approved' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
                                    'shipped' => 'bg-green-50 text-green-700 ring-1 ring-green-200',
                                    'cancelled' => 'bg-red-50 text-red-700 ring-1 ring-red-200',
                                    default => 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200'
                                })
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $cls }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <button type="button" @click="open = !open" class="rounded-md border border-beige text-ink px-3 py-2 hover:bg-beige focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <span x-text="open ? 'Hide Items' : 'View Items'"></span>
                            </button>
                        </div>
                        <div x-show="open" x-transition>
                            <div class="border-t border-beige">
                                <ul>
                                    @foreach($order->orderItems as $item)
                                        <li class="p-4 sm:p-6 flex items-center gap-4">
                                            <img src="{{ Storage::url('products/' . ($item->product->image ?? '')) }}" alt="{{ $item->product->name ?? 'Product' }}" class="w-16 h-16 rounded-md object-cover" />
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
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</x-app-layout>