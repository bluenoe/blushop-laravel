<x-app-layout>
    <div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-6 py-20">
        {{-- Icon Check --}}
        <div class="w-16 h-16 bg-black text-white rounded-full flex items-center justify-center mb-8">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-3xl md:text-4xl font-bold tracking-tighter mb-4">Thank you for your order.</h1>
        <p class="text-neutral-500 mb-8 max-w-md">
            We've received your order <span class="text-black font-mono font-bold">#{{ $order->id }}</span>.
            We will notify you once it ships.
        </p>

        <div class="flex gap-4">
            <a href="{{ route('orders.index') }}"
                class="px-8 py-3 border border-black text-xs font-bold uppercase tracking-widest hover:bg-black hover:text-white transition">
                View Order
            </a>
            <a href="{{ route('products.index') }}"
                class="px-8 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition">
                Continue Shopping
            </a>
        </div>
    </div>
</x-app-layout>