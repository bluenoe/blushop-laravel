@props(['modelInfo' => 'Model is 175cm / 65kg and wearing size M'])

<div x-data="{ 
    open: false, 
    unit: 'cm', 
    tab: 'chart'
}" class="inline-block">

    {{-- 1. TRIGGER BUTTON --}}
    <button @click="open = true" type="button"
        class="flex items-center gap-2 text-sm font-medium text-neutral-500 hover:text-black transition-colors underline underline-offset-4 decoration-1">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
        </svg>
        Size Guide
    </button>

    {{-- 2. TELEPORT FIX --}}
    <template x-teleport="body">

        {{-- WRAPPER CHÍNH: Bỏ x-transition ở đây để tránh chớp --}}
        <div x-show="open" style="display: none;" class="fixed inset-0 z-[9999] overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">

            {{-- BACKDROP: Thêm transition riêng cho nền đen --}}
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="open = false"></div>

            {{-- CONTENT CONTAINER --}}
            <div class="flex min-h-full items-center justify-center p-4 text-center">

                {{-- MODAL PANEL: Transition riêng cho bảng trắng --}}
                <div x-show="open" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform overflow-hidden bg-white text-left shadow-2xl transition-all w-full max-w-4xl border border-neutral-100 rounded-lg flex flex-col max-h-[90vh]">

                    {{-- Close Button --}}
                    <div class="absolute top-0 right-0 z-50 pt-4 pr-4">
                        <button @click="open = false"
                            class="bg-white/80 rounded-full p-2 text-neutral-400 hover:text-black hover:bg-neutral-100 transition shadow-sm cursor-pointer">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Scrollable Content --}}
                    <div class="overflow-y-auto p-6 sm:p-0">
                        <div class="grid grid-cols-1 lg:grid-cols-12">

                            {{-- SIDE A: SIZE CHART --}}
                            <div
                                class="lg:col-span-7 p-2 sm:p-10 border-b lg:border-b-0 lg:border-r border-neutral-100">
                                <div class="flex justify-between items-baseline mb-8 pr-8">
                                    <h3 class="font-serif text-2xl font-medium text-neutral-900">Size Guide</h3>

                                    {{-- Unit Toggle --}}
                                    <div class="flex items-center bg-neutral-100 rounded-sm p-1 shrink-0">
                                        <button @click="unit = 'cm'"
                                            :class="unit === 'cm' ? 'bg-white shadow-sm text-black' : 'text-neutral-400 hover:text-neutral-600'"
                                            class="px-3 py-1 text-xs font-bold uppercase tracking-widest transition-all rounded-sm">
                                            CM
                                        </button>
                                        <button @click="unit = 'inch'"
                                            :class="unit === 'inch' ? 'bg-white shadow-sm text-black' : 'text-neutral-400 hover:text-neutral-600'"
                                            class="px-3 py-1 text-xs font-bold uppercase tracking-widest transition-all rounded-sm">
                                            IN
                                        </button>
                                    </div>
                                </div>

                                {{-- Table --}}
                                <div class="overflow-x-auto -mx-2 px-2 sm:mx-0 sm:px-0">
                                    <table class="w-full text-sm text-left">
                                        <thead
                                            class="text-xs uppercase tracking-widest text-neutral-400 border-b border-neutral-100">
                                            <tr>
                                                <th scope="col" class="py-3 pr-4 font-medium">Size</th>
                                                <th scope="col" class="py-3 px-2 sm:px-4 font-medium text-center">
                                                    Shoulder</th>
                                                <th scope="col" class="py-3 px-2 sm:px-4 font-medium text-center">Chest
                                                </th>
                                                <th scope="col" class="py-3 px-2 sm:px-4 font-medium text-center">Waist
                                                </th>
                                                <th scope="col" class="py-3 px-2 sm:px-4 font-medium text-center">Length
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-neutral-50 text-neutral-600">
                                            <tr class="hover:bg-neutral-50/50 transition-colors">
                                                <td class="py-4 pr-4 font-bold text-black">XS</td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '42' : '16.5'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '92' : '36'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '88' : '34.5'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '68' : '26.7'"></span></td>
                                            </tr>
                                            <tr class="hover:bg-neutral-50/50 transition-colors">
                                                <td class="py-4 pr-4 font-bold text-black">S</td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '44' : '17.3'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '96' : '37.8'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '92' : '36.2'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '70' : '27.5'"></span></td>
                                            </tr>
                                            <tr class="bg-neutral-50/60">
                                                <td class="py-4 pr-4 font-bold text-black">M</td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '46' : '18.1'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '100' : '39.4'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '96' : '37.8'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '72' : '28.3'"></span></td>
                                            </tr>
                                            <tr class="hover:bg-neutral-50/50 transition-colors">
                                                <td class="py-4 pr-4 font-bold text-black">L</td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '48' : '18.9'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '104' : '40.9'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '100' : '39.4'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '74' : '29.1'"></span></td>
                                            </tr>
                                            <tr class="hover:bg-neutral-50/50 transition-colors">
                                                <td class="py-4 pr-4 font-bold text-black">XL</td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '50' : '19.7'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '108' : '42.5'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '104' : '40.9'"></span></td>
                                                <td class="py-4 px-4 text-center"><span
                                                        x-text="unit === 'cm' ? '76' : '29.9'"></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div
                                    class="mt-8 pt-6 border-t border-neutral-100 text-xs text-neutral-500 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $modelInfo }}</span>
                                </div>
                            </div>

                            {{-- SIDE B: HOW TO MEASURE --}}
                            <div class="lg:col-span-5 bg-neutral-50 p-6 sm:p-10 flex flex-col justify-center">
                                <h4
                                    class="font-bold text-sm uppercase tracking-widest text-neutral-900 mb-6 mt-4 sm:mt-0">
                                    How To Measure</h4>
                                <div
                                    class="relative w-full aspect-[3/4] bg-white border border-neutral-100 mb-6 flex items-center justify-center overflow-hidden rounded-sm">
                                    <svg class="w-full h-full text-neutral-200" viewBox="0 0 200 300" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M50 80 C50 60, 150 60, 150 80 L160 120 L140 280 L60 280 L40 120 Z"
                                            fill="currentColor" opacity="0.2" />
                                        <line x1="50" y1="80" x2="150" y2="80" stroke="#000" stroke-width="2"
                                            stroke-dasharray="4 4" /><text x="100" y="70" text-anchor="middle"
                                            font-size="10" fill="#000">Shoulder</text>
                                        <line x1="45" y1="120" x2="155" y2="120" stroke="#000" stroke-width="2"
                                            stroke-dasharray="4 4" /><text x="100" y="110" text-anchor="middle"
                                            font-size="10" fill="#000">Chest</text>
                                        <line x1="60" y1="200" x2="140" y2="200" stroke="#000" stroke-width="2"
                                            stroke-dasharray="4 4" /><text x="100" y="190" text-anchor="middle"
                                            font-size="10" fill="#000">Waist</text>
                                    </svg>
                                </div>
                                <ul class="space-y-4 text-xs text-neutral-500 pb-4 sm:pb-0">
                                    <li class="flex gap-3"><span
                                            class="font-bold text-black w-16 shrink-0">Shoulder</span><span>Measure from
                                            shoulder tip to shoulder tip across the back.</span></li>
                                    <li class="flex gap-3"><span
                                            class="font-bold text-black w-16 shrink-0">Chest</span><span>Measure around
                                            the fullest part of your chest.</span></li>
                                    <li class="flex gap-3"><span
                                            class="font-bold text-black w-16 shrink-0">Waist</span><span>Measure at the
                                            narrowest part of your waistline.</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>