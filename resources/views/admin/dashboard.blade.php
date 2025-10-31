@extends('layouts.admin')

@section('content')
    <div class="space-y-8">
        <h1 class="text-2xl font-semibold text-gray-100">Dashboard</h1>

        <!-- Overview cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="rounded-xl bg-[#0d1426] border border-gray-700 p-5">
                <div class="text-sm text-gray-400">Total Users</div>
                <div class="mt-2 text-3xl font-bold text-gray-100">{{ number_format($stats['users']) }}</div>
            </div>
            <div class="rounded-xl bg-[#0d1426] border border-gray-700 p-5">
                <div class="text-sm text-gray-400">Total Orders</div>
                <div class="mt-2 text-3xl font-bold text-gray-100">{{ number_format($stats['orders']) }}</div>
            </div>
            <div class="rounded-xl bg-[#0d1426] border border-gray-700 p-5">
                <div class="text-sm text-gray-400">Total Products</div>
                <div class="mt-2 text-3xl font-bold text-gray-100">{{ number_format($stats['products']) }}</div>
            </div>
            <div class="rounded-xl bg-[#0d1426] border border-gray-700 p-5">
                <div class="text-sm text-gray-400">Revenue</div>
                <div class="mt-2 text-3xl font-bold text-emerald-400">$ {{ number_format($stats['revenue'], 2) }}</div>
            </div>
        </div>

        <!-- Revenue chart -->
        <div class="rounded-xl bg-[#0d1426] border border-gray-700 p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-100">Revenue by Month</h2>
                <span class="text-sm text-gray-400">Last 12 months</span>
            </div>
            <canvas id="revenueChart" height="120"></canvas>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const labels = @json($chart['labels']);
        const dataSeries = @json($chart['series']);

        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue ($)',
                    data: dataSeries,
                    borderColor: '#34d399',
                    backgroundColor: 'rgba(52, 211, 153, 0.15)',
                    tension: 0.25,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { labels: { color: '#cbd5e1' } },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `$ ${ctx.parsed.y.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`
                        }
                    }
                },
                scales: {
                    x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(148, 163, 184, 0.1)' } },
                    y: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(148, 163, 184, 0.1)' } }
                }
            }
        });
    </script>
@endsection