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
IMPORTANT: x-cloak CSS must be in

<head> to prevent flash!
    Add this to your main CSS or layout head:
    [x-cloak] { display: none !important; }
    --}}

    <div x-data="{
        isVisible: true,
        storageKey: '{{ $storageKey }}',
        init() {
            // Check localStorage - hide ONLY if explicitly set to 'true'
            const shouldHide = localStorage.getItem(this.storageKey) === 'true';
            this.isVisible = !shouldHide;
            
            // DEBUG: Remove this console.log after testing
            console.log('Promo Bar Status:', this.isVisible ? 'Visible' : 'Hidden', '| localStorage:', localStorage.getItem(this.storageKey));
        },
        close() {
            this.isVisible = false;
            localStorage.setItem(this.storageKey, 'true');
            console.log('Promo Bar: Closed by user, saved to localStorage');
            // Optional: Dispatch event for other components to react
            this.$dispatch('announcement-closed');
        }
    }" x-show="isVisible" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-full" x-cloak
        class="announcement-bar relative w-full bg-black text-white z-50" role="banner" aria-label="Announcement">
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