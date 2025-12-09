<x-admin-layout>
    <div class="mb-10">
        <h1 class="text-3xl font-bold tracking-tighter">Store Configuration</h1>
        <p class="text-neutral-400 text-sm mt-2">Manage your global store settings.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- COLUMN 1: General Info --}}
            <div class="space-y-8">
                <h2
                    class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 border-b border-neutral-100 pb-2">
                    Brand Identity</h2>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-neutral-900 mb-2">Shop Name</label>
                        <input type="text" name="shop_name" value="{{ $settings['shop_name'] ?? 'BluShop' }}"
                            class="w-full bg-transparent border-0 border-b border-neutral-200 py-2 px-0 focus:border-black focus:ring-0 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-neutral-900 mb-2">Contact Email</label>
                        <input type="email" name="shop_email" value="{{ $settings['shop_email'] ?? '' }}"
                            class="w-full bg-transparent border-0 border-b border-neutral-200 py-2 px-0 focus:border-black focus:ring-0 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-neutral-900 mb-2">Phone Number</label>
                        <input type="text" name="shop_phone" value="{{ $settings['shop_phone'] ?? '' }}"
                            class="w-full bg-transparent border-0 border-b border-neutral-200 py-2 px-0 focus:border-black focus:ring-0 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-neutral-900 mb-2">Address</label>
                        <textarea name="shop_address" rows="3"
                            class="w-full bg-neutral-50 border-0 py-3 px-3 focus:ring-1 focus:ring-black text-sm resize-none">{{ $settings['shop_address'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            {{-- COLUMN 2: Logistics & Commercial --}}
            <div class="space-y-8">
                <h2
                    class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 border-b border-neutral-100 pb-2">
                    Commercial</h2>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-neutral-900 mb-2">Standard Shipping Fee (₫)</label>
                        <input type="number" name="shipping_fee" value="{{ $settings['shipping_fee'] ?? '30000' }}"
                            class="w-full bg-transparent border-0 border-b border-neutral-200 py-2 px-0 focus:border-black focus:ring-0 text-sm font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-neutral-900 mb-2">Free Shipping Threshold (₫)</label>
                        <input type="number" name="free_shipping_threshold"
                            value="{{ $settings['free_shipping_threshold'] ?? '500000' }}"
                            class="w-full bg-transparent border-0 border-b border-neutral-200 py-2 px-0 focus:border-black focus:ring-0 text-sm font-mono">
                        <p class="text-[10px] text-neutral-400 mt-1">Orders above this amount will have free shipping.
                        </p>
                    </div>
                </div>
            </div>

            {{-- COLUMN 3: Social & Actions --}}
            <div class="space-y-8">
                <h2
                    class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 border-b border-neutral-100 pb-2">
                    Social Profiles</h2>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-neutral-900 mb-2">Facebook URL</label>
                        <input type="url" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}"
                            placeholder="https://..."
                            class="w-full bg-transparent border-0 border-b border-neutral-200 py-2 px-0 focus:border-black focus:ring-0 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-neutral-900 mb-2">Instagram URL</label>
                        <input type="url" name="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}"
                            placeholder="https://..."
                            class="w-full bg-transparent border-0 border-b border-neutral-200 py-2 px-0 focus:border-black focus:ring-0 text-sm">
                    </div>
                </div>

                {{-- SAVE BUTTON --}}
                <div class="pt-8 mt-8 border-t border-neutral-100">
                    <button type="submit"
                        class="w-full py-4 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition transform active:scale-95">
                        Save Configuration
                    </button>
                </div>
            </div>

        </div>
    </form>
</x-admin-layout>