{{-- ========================================================
ACCORDION SECTIONS (Animation Mượt & Đầm)
======================================================== --}}
<section>
    <div class="mt-12 border-t border-neutral-200" x-data="{ activeTab: 'details' }">

        {{-- 1. DESCRIPTION & DETAILS (JSON Attributes) --}}
        <div class="border-b border-neutral-200">
            <button @click="activeTab = activeTab === 'details' ? null : 'details'"
                class="w-full py-5 flex justify-between items-center text-left group">
                <span class="text-xs font-bold uppercase tracking-widest group-hover:text-neutral-600 transition">
                    Details & Composition
                </span>
                {{-- Icon xoay mượt --}}
                <span class="text-xl leading-none transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]"
                    :class="activeTab === 'details' ? 'rotate-45' : 'rotate-0'">+</span>
            </button>

            {{-- Nội dung sổ xuống --}}
            <div x-show="activeTab === 'details'" x-collapse.duration.500ms class="overflow-hidden">
                <div class="pb-6 text-sm text-neutral-600 font-light leading-relaxed">
                    {{-- Mô tả chung --}}
                    <p class="mb-5">
                        {{ $product->description ?? 'Timeless design meets modern functionality.' }}
                    </p>

                    {{-- Thông số kỹ thuật (Từ JSON) --}}
                    @if(!empty($product->specifications))
                    <dl class="space-y-2">
                        @foreach($product->specifications as $key => $value)
                        <div class="flex justify-between py-2 border-b border-dashed border-neutral-100 last:border-0">
                            <dt class="text-neutral-900 font-medium">{{ $key }}</dt>
                            <dd class="text-neutral-500">{{ $value }}</dd>
                        </div>
                        @endforeach
                        {{-- Fallback mẫu nếu chưa có dữ liệu DB --}}
                        @if(count($product->specifications) == 0)
                        <div class="flex justify-between py-1">
                            <dt>Product Code</dt>
                            <dd>REF-{{ $product->id }}</dd>
                        </div>
                        <div class="flex justify-between py-1">
                            <dt>Heel Height</dt>
                            <dd>9 cm</dd>
                        </div>
                        <div class="flex justify-between py-1">
                            <dt>Composition</dt>
                            <dd>100% Calf Leather</dd>
                        </div>
                        @endif
                    </dl>
                    @endif
                </div>
            </div>
        </div>

        {{-- 2. CARE GUIDE --}}
        <div class="border-b border-neutral-200">
            <button @click="activeTab = activeTab === 'care' ? null : 'care'"
                class="w-full py-5 flex justify-between items-center text-left group">
                <span class="text-xs font-bold uppercase tracking-widest group-hover:text-neutral-600 transition">Care
                    Guide</span>
                <span class="text-xl leading-none transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]"
                    :class="activeTab === 'care' ? 'rotate-45' : ''">+</span>
            </button>
            <div x-show="activeTab === 'care'" x-collapse.duration.500ms class="overflow-hidden">
                <div class="pb-6 text-sm text-neutral-600 font-light leading-relaxed space-y-2">
                    @if($product->care_guide)
                    {!! nl2br(e($product->care_guide)) !!}
                    @else
                    {{-- Mẫu --}}
                    <p>Do not wash. Do not bleach. Do not iron. Do not dry clean.</p>
                    <p>Clean with a soft dry cloth. Keep away from direct heat.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- 3. SHIPPING (Giữ nguyên logic cũ) --}}
        <div class="border-b border-neutral-200">
            <button @click="activeTab = activeTab === 'ship' ? null : 'ship'"
                class="w-full py-5 flex justify-between items-center text-left group">
                <span
                    class="text-xs font-bold uppercase tracking-widest group-hover:text-neutral-600 transition">Shipping
                    & Returns</span>
                <span class="text-xl leading-none transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)]"
                    :class="activeTab === 'ship' ? 'rotate-45' : ''">+</span>
            </button>
            <div x-show="activeTab === 'ship'" x-collapse.duration.500ms class="overflow-hidden">
                <div class="pb-6 text-sm text-neutral-600 font-light">
                    Free standard shipping on orders over 500k. Returns accepted within 30 days.
                </div>
            </div>
        </div>
    </div>
</section>