<x-admin-layout>
    {{--
    OPTIMIZATION NOTE:
    Defining status styles once at the top to avoid re-declaration in the loop.
    Using a "Dot System" instead of "Colored Badges" for a cleaner, editorial look.
    --}}
    @php
    $statusMap = [
    'pending' => ['dot' => 'bg-yellow-500', 'text' => 'text-neutral-600'],
    'processing' => ['dot' => 'bg-blue-600', 'text' => 'text-neutral-900'],
    'shipped' => ['dot' => 'bg-purple-600', 'text' => 'text-neutral-900'],
    'completed' => ['dot' => 'bg-green-600', 'text' => 'text-neutral-900'],
    'cancelled' => ['dot' => 'bg-neutral-400','text' => 'text-neutral-400 line-through'],
    ];
    @endphp

    {{-- Header Section --}}
    <div class="mb-12 border-b border-black pb-6 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-neutral-500 mb-1">Store Overview</p>
            <h1 class="text-4xl md:text-5xl font-bold tracking-tighter text-black">
                Dashboard
            </h1>
        </div>
        <div class="text-right flex flex-col items-end">
            <span
                class="inline-flex items-center gap-2 px-3 py-1 border border-neutral-200 rounded-full text-xs font-medium bg-white">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                Live
            </span>
            <p class="text-xs font-mono text-neutral-400 mt-2 text-right">
                {{ now()->format('Y-m-d') }} <span class="mx-1">/</span> {{ now()->format('H:i') }}
            </p>
        </div>
    </div>

    {{-- Metrics Grid (Swiss Style: No shadows, strict borders) --}}
    <div
        class="grid grid-cols-1 md:grid-cols-3 gap-px bg-neutral-200 border border-neutral-200 mb-16 overflow-hidden rounded-sm">

        {{-- Stat 1: Revenue --}}
        <div class="p-8 bg-white group hover:bg-neutral-50 transition duration-300">
            <div class="flex justify-between items-start mb-6">
                <span class="text-[10px] uppercase tracking-widest text-neutral-400 font-bold">Total Revenue</span>
                <span class="text-[10px] font-mono font-medium text-green-600">+12.5%</span>
            </div>
            <div class="text-4xl lg:text-5xl font-bold tracking-tighter text-black mb-1">
                <span class="text-2xl align-top text-neutral-400 font-normal mr-1">₫</span>{{ number_format($revenue, 0,
                ',', '.') }}
            </div>
            <p class="text-[10px] text-neutral-400 font-medium uppercase tracking-wider">Gross Income</p>
        </div>

        {{-- Stat 2: Orders --}}
        <div class="p-8 bg-white group hover:bg-neutral-50 transition duration-300">
            <div class="flex justify-between items-start mb-6">
                <span class="text-[10px] uppercase tracking-widest text-neutral-400 font-bold">Total Orders</span>
                <span class="text-[10px] font-mono font-medium text-neutral-400">{{ $processingOrders }}
                    Processing</span>
            </div>
            <div class="text-4xl lg:text-5xl font-bold tracking-tighter text-black mb-1">
                {{ $totalOrders }}
            </div>
            <p class="text-[10px] text-neutral-400 font-medium uppercase tracking-wider">Lifetime Volume</p>
        </div>

        {{-- Stat 3: AOV --}}
        <div class="p-8 bg-white group hover:bg-neutral-50 transition duration-300">
            <div class="flex justify-between items-start mb-6">
                <span class="text-[10px] uppercase tracking-widest text-neutral-400 font-bold">AOV</span>
            </div>
            <div class="text-4xl lg:text-5xl font-bold tracking-tighter text-black mb-1">
                <span class="text-2xl align-top text-neutral-400 font-normal mr-1">₫</span>{{ number_format($aov, 0,
                ',', '.') }}
            </div>
            <p class="text-[10px] text-neutral-400 font-medium uppercase tracking-wider">Avg. Order Value</p>
        </div>
    </div>

    {{-- Recent Orders Section --}}
    <div class="bg-white">
        <div class="mb-6 flex justify-between items-end">
            <h2 class="text-xl font-bold tracking-tight">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}"
                class="text-[10px] font-bold uppercase tracking-[0.2em] border-b border-black pb-1 hover:text-neutral-600 hover:border-neutral-300 transition">
                View All Orders
            </a>
        </div>

        <div class="overflow-x-auto border border-neutral-100 rounded-sm">
            <table class="w-full text-left border-collapse">
                <thead
                    class="bg-white border-b border-neutral-100 text-[10px] uppercase tracking-[0.2em] text-neutral-400 font-bold">
                    <tr>
                        <th class="px-6 py-4">Order ID</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100 text-sm">
                    @forelse($recentOrders as $order)
                    @php
                    $style = $statusMap[$order->status] ?? ['dot' => 'bg-neutral-300', 'text' => 'text-neutral-500'];
                    @endphp
                    <tr class="group hover:bg-neutral-50 transition duration-150 cursor-pointer"
                        onclick="window.location='{{ route('admin.orders.show', $order->id) }}'">

                        {{-- ID --}}
                        <td
                            class="px-6 py-4 font-mono text-xs text-neutral-500 group-hover:text-black transition-colors">
                            #{{ $order->id }}
                        </td>

                        {{-- Customer --}}
                        <td class="px-6 py-4">
                            <div class="font-bold text-neutral-900 text-xs">{{ $order->user->name ?? 'Guest' }}</div>
                            <div class="text-[10px] text-neutral-400 font-mono mt-0.5">{{ $order->user->email ??
                                $order->email }}</div>
                        </td>

                        {{-- Status (Dot System) --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full {{ $style['dot'] }}"></span>
                                <span class="text-xs font-medium uppercase tracking-wide {{ $style['text'] }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </td>

                        {{-- Date --}}
                        <td class="px-6 py-4 text-neutral-400 text-xs font-mono">
                            {{ $order->created_at->format('M d, H:i') }}
                        </td>

                        {{-- Total --}}
                        <td class="px-6 py-4 text-right font-mono font-medium text-neutral-900">
                            ₫{{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-neutral-300 text-4xl mb-2 font-thin">∅</div>
                            <p class="text-xs uppercase tracking-widest text-neutral-400">No orders recorded</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>