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
        {{-- Stat 1 --}}
        <div
            class="p-8 bg-white border border-neutral-100 md:border-transparent md:bg-white md:shadow-[0_0_40px_-15px_rgba(0,0,0,0.05)] rounded-sm group hover:border-black transition duration-500">
            <div class="flex justify-between items-start mb-8">
                <span class="text-[10px] uppercase tracking-widest text-neutral-400">Total Revenue</span>
                <span
                    class="text-xs font-medium text-green-600 flex items-center gap-1 bg-green-50 px-2 py-1 rounded-full">
                    +12.5%
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                </span>
            </div>
            <div class="text-4xl lg:text-5xl font-bold tracking-tighter text-neutral-900 mb-2">
                {{ number_format($revenue, 0, ',', '.') }}
            </div>
            <p class="text-xs text-neutral-400 font-light">Last 30 days</p>
        </div>

        {{-- Stat 2 --}}
        <div
            class="p-8 bg-white border border-neutral-100 md:border-transparent md:bg-white md:shadow-[0_0_40px_-15px_rgba(0,0,0,0.05)] rounded-sm group hover:border-black transition duration-500">
            <div class="flex justify-between items-start mb-8">
                <span class="text-[10px] uppercase tracking-widest text-neutral-400">Total Orders</span>
                <span
                    class="text-xs font-medium text-neutral-500 flex items-center gap-1 bg-neutral-100 px-2 py-1 rounded-full">
                    0.0%
                </span>
            </div>
            <div class="text-4xl lg:text-5xl font-bold tracking-tighter text-neutral-900 mb-2">
                {{ $totalOrders }}
            </div>
            <p class="text-xs text-neutral-400 font-light">Processing: {{ $processingOrders }}</p>
        </div>

        {{-- Stat 3 --}}
        <div
            class="p-8 bg-white border border-neutral-100 md:border-transparent md:bg-white md:shadow-[0_0_40px_-15px_rgba(0,0,0,0.05)] rounded-sm group hover:border-black transition duration-500">
            <div class="flex justify-between items-start mb-8">
                <span class="text-[10px] uppercase tracking-widest text-neutral-400">Avg. Order Value</span>
                <span class="text-xs font-medium text-red-600 flex items-center gap-1 bg-red-50 px-2 py-1 rounded-full">
                    -2.1%
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </span>
            </div>
            <div class="text-4xl lg:text-5xl font-bold tracking-tighter text-neutral-900 mb-2">
                ₫600k
            </div>
            <p class="text-xs text-neutral-400 font-light">Per customer</p>
        </div>
    </div>

    {{-- Recent Orders Section --}}
    <div
        class="bg-white border border-neutral-100 md:border-transparent md:shadow-[0_0_40px_-15px_rgba(0,0,0,0.05)] rounded-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-neutral-100 flex justify-between items-center">
            <h2 class="text-lg font-bold tracking-tight">Recent Orders</h2>
            <a href="#"
                class="text-xs font-bold uppercase tracking-widest border-b border-black pb-0.5 hover:opacity-60 transition">View
                All</a>
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
                    {{-- Loop Placeholder --}}
                    @for($i = 0; $i < 5; $i++) <tr class="group hover:bg-neutral-50 transition duration-200">
                        <td class="px-8 py-5 font-mono text-xs">#BLU-{{ rand(1000, 9999) }}</td>
                        <td class="px-8 py-5 font-medium">
                            Minh Khanh
                            <span class="block text-xs text-neutral-400 font-light mt-0.5">khanh@example.com</span>
                        </td>
                        <td class="px-8 py-5">
                            @php $status = ['Pending', 'Processing', 'Shipped'][rand(0,2)]; @endphp
                            <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full text-xs font-medium border
                                {{ $status === 'Shipped' ? 'border-green-200 text-green-700 bg-green-50' : '' }}
                                {{ $status === 'Processing' ? 'border-blue-200 text-blue-700 bg-blue-50' : '' }}
                                {{ $status === 'Pending' ? 'border-neutral-200 text-neutral-600 bg-neutral-50' : '' }}
                            ">
                                <span
                                    class="w-1.5 h-1.5 rounded-full {{ $status === 'Shipped' ? 'bg-green-500' : ($status === 'Processing' ? 'bg-blue-500' : 'bg-neutral-400') }}"></span>
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-neutral-500 font-light">
                            {{ now()->subHours($i*2)->format('M d, H:i') }}
                        </td>
                        <td class="px-8 py-5 text-right font-mono font-medium">
                            ₫{{ number_format(rand(500000, 2000000), 0, ',', '.') }}
                        </td>
                        </tr>
                        @endfor
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>