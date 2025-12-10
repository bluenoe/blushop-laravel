<x-admin-layout>

    {{-- Header --}}
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-neutral-400 mb-2">Overview</p>
            <h1 class="text-4xl md:text-5xl font-bold tracking-tighter text-neutral-900">
                Dashboard
            </h1>
        </div>
        <div class="text-right hidden md:block">
            <p class="text-sm font-medium text-neutral-900">{{ now()->format('l, F j, Y') }}</p>
            <p class="text-xs text-neutral-400">Đà Nẵng</p>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
        {{-- Stat 1: Revenue --}}
        <div
            class="p-8 bg-white border border-neutral-100 md:border-transparent md:bg-white md:shadow-[0_0_40px_-15px_rgba(0,0,0,0.05)] rounded-sm group hover:border-black transition duration-500">
            <div class="flex justify-between items-start mb-8">
                <span class="text-[10px] uppercase tracking-widest text-neutral-400">Total Revenue</span>
                <span
                    class="text-xs font-medium text-green-600 flex items-center gap-1 bg-green-50 px-2 py-1 rounded-full">
                    +12.5% <span class="text-[10px] text-green-400">(Demo)</span>
                </span>
            </div>
            <div class="text-4xl lg:text-5xl font-bold tracking-tighter text-neutral-900 mb-2">
                ₫{{ number_format($revenue, 0, ',', '.') }}
            </div>
            <p class="text-xs text-neutral-400 font-light">Paid Orders</p>
        </div>

        {{-- Stat 2: Orders --}}
        <div
            class="p-8 bg-white border border-neutral-100 md:border-transparent md:bg-white md:shadow-[0_0_40px_-15px_rgba(0,0,0,0.05)] rounded-sm group hover:border-black transition duration-500">
            <div class="flex justify-between items-start mb-8">
                <span class="text-[10px] uppercase tracking-widest text-neutral-400">Total Orders</span>
                <span
                    class="text-xs font-medium text-neutral-500 flex items-center gap-1 bg-neutral-100 px-2 py-1 rounded-full">
                    Active
                </span>
            </div>
            <div class="text-4xl lg:text-5xl font-bold tracking-tighter text-neutral-900 mb-2">
                {{ $totalOrders }}
            </div>
            <p class="text-xs text-neutral-400 font-light">Processing: {{ $processingOrders }}</p>
        </div>

        {{-- Stat 3: AOV --}}
        <div
            class="p-8 bg-white border border-neutral-100 md:border-transparent md:bg-white md:shadow-[0_0_40px_-15px_rgba(0,0,0,0.05)] rounded-sm group hover:border-black transition duration-500">
            <div class="flex justify-between items-start mb-8">
                <span class="text-[10px] uppercase tracking-widest text-neutral-400">Avg. Order Value</span>
            </div>
            <div class="text-4xl lg:text-5xl font-bold tracking-tighter text-neutral-900 mb-2">
                ₫{{ number_format($aov, 0, ',', '.') }}
            </div>
            <p class="text-xs text-neutral-400 font-light">Per customer</p>
        </div>
    </div>

    {{-- Recent Orders Section --}}
    <div
        class="bg-white border border-neutral-100 md:border-transparent md:shadow-[0_0_40px_-15px_rgba(0,0,0,0.05)] rounded-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-neutral-100 flex justify-between items-center">
            <h2 class="text-lg font-bold tracking-tight">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}"
                class="text-xs font-bold uppercase tracking-widest border-b border-black pb-0.5 hover:opacity-60 transition">
                View All
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-neutral-50/50 text-[10px] uppercase tracking-[0.2em] text-neutral-400 font-medium">
                    <tr>
                        <th class="px-8 py-5">Order ID</th>
                        <th class="px-8 py-5">Customer</th>
                        <th class="px-8 py-5">Status</th>
                        <th class="px-8 py-5">Date</th>
                        <th class="px-8 py-5 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 text-sm">
                    @forelse($recentOrders as $order)
                    <tr class="group hover:bg-neutral-50 transition duration-200 cursor-pointer"
                        onclick="window.location='{{ route('admin.orders.show', $order->id) }}'">

                        {{-- ID --}}
                        <td class="px-8 py-5 font-mono text-xs font-medium text-black">
                            #{{ $order->id }}
                        </td>

                        {{-- Customer --}}
                        <td class="px-8 py-5 font-medium">
                            {{ $order->user->name ?? 'Guest Customer' }}
                            <span class="block text-xs text-neutral-400 font-light mt-0.5">
                                {{ $order->user->email ?? $order->email ?? 'No Email' }}
                            </span>
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-8 py-5">
                            @php
                            $colors = [
                            'pending' => 'border-yellow-200 text-yellow-700 bg-yellow-50',
                            'processing' => 'border-blue-200 text-blue-700 bg-blue-50',
                            'shipped' => 'border-purple-200 text-purple-700 bg-purple-50',
                            'completed' => 'border-green-200 text-green-700 bg-green-50',
                            'cancelled' => 'border-neutral-200 text-neutral-500 bg-neutral-50',
                            ];
                            $statusClass = $colors[$order->status] ?? 'border-neutral-200 text-neutral-600
                            bg-neutral-50';
                            @endphp
                            <span
                                class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide border {{ $statusClass }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current opacity-60"></span>
                                {{ $order->status }}
                            </span>
                        </td>

                        {{-- Date --}}
                        <td class="px-8 py-5 text-neutral-500 font-light">
                            {{ $order->created_at->format('M d, H:i') }}
                        </td>

                        {{-- Total --}}
                        <td class="px-8 py-5 text-right font-mono font-medium">
                            ₫{{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-neutral-400">
                            <p class="mb-2">No orders placed yet.</p>
                            <p class="text-xs uppercase tracking-widest">Waiting for the first sale!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>