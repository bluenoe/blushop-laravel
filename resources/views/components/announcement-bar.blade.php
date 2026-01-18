{{--
Global Announcement Bar / Promo Bar

Usage: <x-announcement-bar />

Configure the message in config/announcement.php or translation file.
The bar will remember if the user closed it using localStorage.
--}}

@php
// Get announcement message from config or use default
$message = config('announcement.message', __('announcement.message'));
$storageKey = config('announcement.storage_key', 'hide_promo_bar');
@endphp

{{--
FIX: Using inline script to check localStorage BEFORE render
This completely prevents flash because we decide visibility synchronously
--}}
<script>
    (function () {
        var shouldHide = localStorage.getItem('{{ $storageKey }}') === 'true';
        console.log('Promo Bar Status:', shouldHide ? 'Hidden' : 'Visible', '| localStorage:', localStorage.getItem('{{ $storageKey }}'));
        if (shouldHide) {
            document.write('<style>#announcement-bar-container{display:none!important}</style>');
        }
    })();
</script>

<div id="announcement-bar-container" x-data="{
        close() {
            localStorage.setItem('{{ $storageKey }}', 'true');
            console.log('Promo Bar: Closed by user, saved to localStorage');
            this.$el.remove();
        }
    }" class="relative w-full bg-black text-white z-50 md:sticky md:top-0" role="banner" aria-label="Announcement">
    <div class="flex items-center justify-center h-10 px-4">
        {{-- Main Message --}}
        <p class="text-xs sm:text-sm font-medium tracking-wide text-center">
            {{ $message }}
        </p>

        {{-- Close Button --}}
        <button @click="close()" type="button"
            class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 p-1.5 text-white/60 hover:text-white transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white/30 rounded"
            aria-label="Close announcement">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>