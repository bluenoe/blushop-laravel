<x-admin-layout>
    {{-- HEADER & TABS --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-neutral-400 mb-1">Logistics</p>
            <h1 class="text-3xl font-bold tracking-tighter">Orders</h1>
        </div>

        {{-- Status Filter Tabs --}}
        <div class="flex overflow-x-auto hide-scrollbar border-b border-neutral-200 md:border-none pb-2 md:pb-0">
            @php
            $currentStatus = request('status', 'all');
            $statuses = ['all', 'pending', 'processing', 'shipped', 'completed', 'cancelled'];
            @endphp

            <div class="flex p-1 bg-neutral-100 rounded-lg">
                @foreach($statuses as $status)
                <a href="{{ route('admin.orders.index', ['status' => $status]) }}"
                    class="px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest rounded-md transition-all
                       {{ $currentStatus === $status ? 'bg-white text-black shadow-sm' : 'text-neutral-500 hover:text-neutral-900' }}">
                    {{ $status }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ORDER LIST TABLE --}}
    <div class="bg-white">
        @if($orders->isEmpty())
        <div class="text-center py-24 border-t border-neutral-100">
            <p class="text-neutral-400">No orders found in this category.</p>
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
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                class="underline decoration-neutral-300 underline-offset-4 hover:text-black hover:decoration-black transition">
                                #{{ $order->id }}
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
                            <a href="{{ route('admin.orders.show', $order->id) }}"
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