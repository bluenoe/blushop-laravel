<footer class="bg-warm border-t border-beige" role="contentinfo">
    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="text-center space-y-2">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2">
                <x-application-logo class="h-6 w-auto fill-current text-ink" />
                <span class="sr-only">BluShop</span>
            </a>
            <p class="text-[12px] sm:text-xs text-gray-700">© {{ date('Y') }} BluShop — Crafted with ❤️ in Vietnam.</p>
            <div class="flex items-center justify-center gap-4 text-[12px] sm:text-xs text-gray-600">
                <a href="#" class="hover:text-ink">Privacy Policy</a>
                <a href="{{ route('contact.index') }}" class="hover:text-ink">Contact Support</a>
            </div>
        </div>
    </div>
</footer>