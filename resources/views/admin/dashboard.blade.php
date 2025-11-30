@extends('layouts.admin')

@php($breadcrumb = [ ['label' => 'Dashboard'] ])

@section('content')
    <div class="space-y-8">
        <h1 class="text-2xl font-semibold text-ink">Dashboard</h1>

        <!-- Overview cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="rounded-xl bg-white border border-beige p-5 shadow-soft">
                <div class="text-sm text-gray-700">Total Users</div>
                <div class="mt-2 text-3xl font-bold text-ink">{{ number_format($stats['users']) }}</div>
            </div>
            <div class="rounded-xl bg-white border border-beige p-5 shadow-soft">
                <div class="text-sm text-gray-700">Total Orders</div>
                <div class="mt-2 text-3xl font-bold text-ink">{{ number_format($stats['orders']) }}</div>
            </div>
            <div class="rounded-xl bg-white border border-beige p-5 shadow-soft">
                <div class="text-sm text-gray-700">Total Products</div>
                <div class="mt-2 text-3xl font-bold text-ink">{{ number_format($stats['products']) }}</div>
            </div>
            <div class="rounded-xl bg-white border border-beige p-5 shadow-soft">
                <div class="text-sm text-gray-700">Revenue</div>
                <div class="mt-2 text-3xl font-bold text-emerald-600">$ {{ number_format($stats['revenue'], 2) }}</div>
            </div>
        </div>

        <!-- Revenue chart -->
        <div class="rounded-xl bg-white border border-beige p-5 shadow-soft">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-ink">Revenue by Month</h2>
                <span class="text-sm text-gray-700">Last 12 months</span>
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
                    legend: { labels: { color: '#374151' } },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `$ ${ctx.parsed.y.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`
                        }
                    }
                },
                scales: {
                    x: { ticks: { color: '#6b7280' }, grid: { color: 'rgba(107, 114, 128, 0.15)' } },
                    y: { ticks: { color: '#6b7280' }, grid: { color: 'rgba(107, 114, 128, 0.15)' } }
                }
            }
        });
    </script>
@endsection
