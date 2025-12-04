{{-- resources/views/errors/404.blade.php --}}
<x-app-layout>
    <section class="min-h-[calc(100vh-4rem)] bg-warm flex items-center">
        <div class="max-w-3xl mx-auto px-6 py-12 text-center space-y-6">
            <p class="text-sm tracking-[0.3em] text-gray-500 uppercase">
                Error 404
            </p>

            <h1 class="text-4xl sm:text-5xl font-bold text-ink">
                Oops... This page got lost in Blu.
            </h1>

            <p class="text-gray-600 max-w-xl mx-auto">
                The page you’re looking for doesn’t exist anymore, or maybe it never did.
                Try going back home or browse our latest pieces instead.
            </p>

            <div class="flex flex-wrap justify-center gap-3 mt-4">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center rounded-md bg-ink text-warm px-5 py-2.5 text-sm font-semibold hover:bg-ink/90 transition">
                    ← Back to Blu home
                </a>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center justify-center rounded-md border border-beige bg-beige px-5 py-2.5 text-sm font-semibold text-ink hover:bg-rosebeige transition">
                    Browse products
                </a>
            </div>

            <p class="text-xs text-gray-400 mt-6">
                If you think this is a bug, ping Blu dev team 🪲
            </p>
        </div>
    </section>
</x-app-layout>