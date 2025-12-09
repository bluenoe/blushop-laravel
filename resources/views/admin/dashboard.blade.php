@extends('layouts.admin')

@section('content')
<div class="space-y-10">
    <div class="flex flex-col gap-1">
        <h1 class="text-3xl font-bold text-neutral-900 tracking-tight">Dashboard</h1>
        <p class="text-sm text-neutral-500">Overview of your store performance.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
            class="bg-white border border-neutral-200 p-6 flex flex-col justify-between h-32 hover:border-black transition-colors duration-300">
            <div class="text-[10px] uppercase tracking-[0.2em] text-neutral-500 font-semibold">Total Revenue</div>
            <div class="text-3xl font-light text-neutral-900 tracking-tight">$ {{ number_format($stats['revenue'], 2) }}
            </div>
        </div>

        <div
            class="bg-white border border-neutral-200 p-6 flex flex-col justify-between h-32 hover:border-black transition-colors duration-300">
            <div class="text-[10px] uppercase tracking-[0.2em] text-neutral-500 font-semibold">Orders</div>
            <div class="text-3xl font-light text-neutral-900 tracking-tight">{{ number_format($stats['orders']) }}</div>
        </div>

        <div
            class="bg-white border border-neutral-200 p-6 flex flex-col justify-between h-32 hover:border-black transition-colors duration-300">
            <div class="text-[10px] uppercase tracking-[0.2em] text-neutral-500 font-semibold">Products</div>
            <div class="text-3xl font-light text-neutral-900 tracking-tight">{{ number_format($stats['products']) }}
            </div>
        </div>

        <div
            class="bg-white border border-neutral-200 p-6 flex flex-col justify-between h-32 hover:border-black transition-colors duration-300">
            <div class="text-[10px] uppercase tracking-[0.2em] text-neutral-500 font-semibold">Customers</div>
            <div class="text-3xl font-light text-neutral-900 tracking-tight">{{ number_format($stats['users']) }}</div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="flex items-end justify-between border-b border-neutral-200 pb-2">
            <h2 class="text-lg font-bold text-neutral-900">Revenue Trends</h2>
            <span class="text-xs text-neutral-400 uppercase tracking-wider">Last 12 Months</span>
        </div>

        <div class="relative h-80 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');

    // Gradient for a sophisticated look
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 0, 0, 0.05)'); // Very subtle black
    gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chart['labels']),
            datasets: [{
                label: 'Revenue',
                data: @json($chart['series']),
                borderColor: '#171717', // Neutral-900
                borderWidth: 1.5,
                backgroundColor: gradient,
                tension: 0, // Sharp lines for architectural feel
                fill: true,
                pointBackgroundColor: '#171717',
                pointRadius: 0, // Clean look, show points on hover only
                pointHoverRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#171717',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 0, // Sharp tooltip
                    displayColors: false,
                    callbacks: {
                        label: (ctx) => `$ ${ctx.parsed.y.toLocaleString(undefined, { minimumFractionDigits: 2 })}`
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#a3a3a3', font: { family: 'Inter', size: 10 } }
                },
                y: {
                    border: { display: false },
                    grid: { color: '#f5f5f5' },
                    ticks: { color: '#a3a3a3', font: { family: 'Inter', size: 10 } }
                }
            }
        }
    });
</script>
@endsection