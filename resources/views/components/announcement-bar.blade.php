{{--
Global Announcement Bar / Promo Bar

Usage: <x-announcement-bar />

Configure the message in config/announcement.php or translation file.
The bar will remember if the user closed it using localStorage.
--}}

@php
$message = config('announcement.message', __('announcement.message'));
$storageKey = config('announcement.storage_key', 'hide_promo_bar');
@endphp

{{-- Check localStorage synchronously to prevent flash --}}
<script>
    (function () {
        var shouldHide = localStorage.getItem('{{ $storageKey }}') === 'true';
        console.log('Promo Bar Status:', shouldHide ? 'Hidden' : 'Visible');
        if (!shouldHide) {
            // Bar is visible - set CSS variable
            document.documentElement.style.setProperty('--announcement-bar-height', '40px');
            document.documentElement.classList.add('has-announcement-bar');
        }
    })();
</script>

<div id="announcement-bar-container" x-data="{
        isVisible: !localStorage.getItem('{{ $storageKey }}'),
        close() {
            // 1. Animate out
            this.isVisible = false;
            
            // 2. Save to localStorage
            localStorage.setItem('{{ $storageKey }}', 'true');
            
            // 3. Update CSS variable for navigation offset
            document.documentElement.style.setProperty('--announcement-bar-height', '0px');
            document.documentElement.classList.remove('has-announcement-bar');
            
            console.log('Promo Bar: Closed');
        }
    }" x-show="isVisible" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed top-0 left-0 right-0 w-full bg-black text-white z-[60]"
    style="height: 40px;" role="banner" aria-label="Announcement">
    <div class="flex items-center justify-center h-full px-4">
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

{{-- Spacer to push content down when bar is visible --}}
<div id="announcement-bar-spacer" class="h-0 transition-all duration-200"
    style="height: var(--announcement-bar-height, 0px);"></div>