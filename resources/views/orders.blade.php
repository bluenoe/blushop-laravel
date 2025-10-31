<x-app-layout>
    <section class="max-w-7xl mx-auto px-6 py-12 sm:py-16" x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 300)">
        <div class="flex items-center justify-between" data-reveal="fade-up">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">My Orders</h1>
            <a href="{{ route('products.index') }}" class="rounded-md bg-indigo-600 text-white px-4 py-2 font-semibold hover:bg-indigo-500">Shop More</a>
        </div>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.opacity class="mt-4 rounded-md bg-green-600/15 border border-green-600/30 text-green-700 dark:text-green-300 px-4 py-3">
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
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden" x-data="{ open: false }">
                        <div class="p-4 sm:p-6 flex items-center justify-between">
                            <div class="space-y-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Order #{{ $order->id }} • {{ $order->created_at->format('M d, Y') }}</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">₫{{ number_format((float)$order->total_amount, 0, ',', '.') }}</p>
                                @php($cls = match($order->status){
                                    'pending' => 'bg-gray-600/15 text-gray-300 ring-1 ring-gray-600/30',
                                    'approved' => 'bg-blue-600/15 text-blue-300 ring-1 ring-blue-600/30',
                                    'shipped' => 'bg-green-600/15 text-green-300 ring-1 ring-green-600/30',
                                    'cancelled' => 'bg-red-600/15 text-red-300 ring-1 ring-red-600/30',
                                    default => 'bg-gray-600/15 text-gray-300 ring-1 ring-gray-600/30'
                                })
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $cls }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <button type="button" @click="open = !open" class="rounded-md bg-gray-900/50 text-gray-200 px-3 py-2 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-white/20">
                                <span x-text="open ? 'Hide Items' : 'View Items'"></span>
                            </button>
                        </div>
                        <div x-show="open" x-transition>
                            <div class="border-t border-gray-200 dark:border-gray-700">
                                <ul>
                                    @foreach($order->orderItems as $item)
                                        <li class="p-4 sm:p-6 flex items-center gap-4">
                                            <img src="{{ Storage::url('products/' . ($item->product->image ?? '')) }}" alt="{{ $item->product->name ?? 'Product' }}" class="w-16 h-16 rounded-md object-cover" />
                                            <div class="flex-1">
                                                <p class="text-gray-900 dark:text-gray-100 font-semibold">{{ $item->product->name ?? 'Product' }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-300">Qty: {{ $item->quantity }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-gray-900 dark:text-gray-100 font-medium">₫{{ number_format((float)$item->price_at_purchase, 0, ',', '.') }}</p>
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