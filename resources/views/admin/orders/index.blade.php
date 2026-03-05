<x-admin-layout>
    {{-- HEADER & TABS --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-neutral-400 mb-1">Logistics</p>
            <h1 class="text-3xl font-bold tracking-tighter">Orders</h1>
        </div>

        {{-- Search and Status Filters --}}
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4 w-full md:w-auto">

            {{-- Search Bar (Minimalist) --}}
            <form action="{{ route('admin.orders.index') }}" method="GET"
                class="relative group flex items-center gap-2 w-full md:w-auto">
                @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="relative w-full md:w-auto">
                    <input type="text" name="search" placeholder="SEARCH ORDERS..." value="{{ $search ?? '' }}"
                        class="w-full md:w-48 pl-10 pr-4 py-2 bg-neutral-50 border border-neutral-200 rounded-full text-sm focus:bg-white focus:border-black focus:ring-1 focus:ring-black placeholder-neutral-400 transition-all shadow-sm">
                    <div
                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-400 group-focus-within:text-black transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                @if(!empty($search))
                <a href="{{ route('admin.orders.index', ['status' => request('status')]) }}"
                    class="text-xs text-neutral-400 hover:text-black transition whitespace-nowrap">
                    Clear
                </a>
                @endif
            </form>

            {{-- Status Filter Tabs --}}
            <div
                class="flex overflow-x-auto hide-scrollbar border-b border-neutral-200 md:border-none pb-2 md:pb-0 w-full md:w-auto">
                @php
                $currentStatus = request('status', 'all');
                $statuses = ['all', 'pending', 'processing', 'shipped', 'completed', 'cancelled'];
                @endphp

                <div class="flex p-1 bg-neutral-100 rounded-full">
                    @foreach($statuses as $status)
                    <a href="{{ route('admin.orders.index', ['status' => $status, 'search' => request('search')]) }}"
                        class="px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest rounded-full transition-all
                           {{ $currentStatus === $status ? 'bg-white text-black shadow-sm' : 'text-neutral-500 hover:text-neutral-900' }}">
                        {{ $status }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Search Results Indicator --}}
    @if(!empty($search))
    <div class="mb-6 text-sm text-neutral-500">
        Results for "<span class="font-medium text-neutral-900">{{ Str::limit($search, 50) }}</span>"
        <span class="text-neutral-400 ml-2">({{ $orders->total() }} found)</span>
    </div>
    @endif

    {{-- ORDER LIST TABLE --}}
    <div class="bg-white">
        @if($orders->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 border-t border-neutral-100">
            <div class="text-neutral-300 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <p class="text-neutral-500 text-sm">
                @if(!empty($search))
                No orders found matching "<span class="font-medium text-neutral-800">{{ Str::limit($search, 30)
                    }}</span>".
                @else
                No orders found in this category.
                @endif
            </p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-neutral-100 text-[10px] uppercase tracking-[0.2em] text-neutral-400">
                        <th class="py-4 pl-2 font-medium">Order ID</th>
                        <th class="py-4 font-medium">Customer</th>
                        <th class="py-4 font-medium">Date</th>
                        <th class="py-4 font-medium">Status</th>
                        <th class="py-4 font-medium text-right">Total</th>
                        <th class="py-4 pr-2 font-medium text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-50 text-sm">
                    @foreach($orders as $order)
                    <tr class="group hover:bg-neutral-50 transition">
                        {{-- ID --}}
                        <td class="py-4 pl-2 font-mono text-xs font-medium">
                            <a href="{{ route('admin.orders.show', $order->order_code) }}"
                                class="underline decoration-neutral-300 underline-offset-4 hover:text-black hover:decoration-black transition">
                                #{{ $order->order_code }}
                            </a>
                        </td>

                        {{-- Customer --}}
                        <td class="py-4">
                            <div class="font-bold text-neutral-900">{{ $order->user->name ?? 'Guest' }}</div>
                            <div class="text-xs text-neutral-400">{{ $order->user->email ?? $order->email ?? 'N/A' }}
                            </div>
                        </td>

                        {{-- Date --}}
                        <td class="py-4 text-neutral-500 font-light">
                            {{ $order->created_at->format('M d, Y') }}
                            <span class="text-xs text-neutral-300 ml-1">{{ $order->created_at->format('H:i') }}</span>
                        </td>

                        {{-- Minimal Status Badge --}}
                        <td class="py-4">
                            @php
                            $colors = [
                            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                            'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'shipped' => 'bg-purple-50 text-purple-700 border-purple-200',
                            'completed' => 'bg-green-50 text-green-700 border-green-200',
                            'cancelled' => 'bg-neutral-100 text-neutral-500 border-neutral-200',
                            ];
                            $statusClass = $colors[$order->status] ?? 'bg-neutral-50 text-neutral-900
                            border-neutral-200';
                            @endphp
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded border text-[10px] font-bold uppercase tracking-wide {{ $statusClass }}">
                                {{ $order->status }}
                            </span>
                        </td>

                        {{-- Total --}}
                        <td class="py-4 text-right font-mono text-neutral-900">
                            ₫{{ number_format($order->total_amount ?? $order->total, 0, ',', '.') }}
                        </td>

                        {{-- Action --}}
                        <td class="py-4 pr-2 text-right">
                            <a href="{{ route('admin.orders.show', $order->order_code) }}"
                                class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition border border-neutral-200 px-3 py-1.5 rounded hover:border-black">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $orders->appends(request()->query())->links() }}</div>
        @endif
    </div>
</x-admin-layout>