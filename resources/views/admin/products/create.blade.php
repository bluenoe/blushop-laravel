<x-admin-layout>
    {{-- Form Wrapper --}}
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
        class="max-w-6xl mx-auto">
        @csrf

        {{-- HEADER & ACTIONS --}}
        <div class="flex items-end justify-between mb-12 border-b border-neutral-100 pb-6">
            <div>
                <a href="{{ route('admin.products.index') }}"
                    class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition mb-2 block">
                    &larr; Back to Catalogue
                </a>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tighter">New Entry</h1>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="px-8 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition transform active:scale-95">
                    Publish Item
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24">

            {{-- LEFT COLUMN: MEDIA (IMAGE UPLOAD) --}}
            <div class="lg:col-span-4 space-y-6">
                <div x-data="{ imagePreview: null }" class="relative group w-full">
                    <label
                        class="block w-full aspect-[3/4] bg-neutral-50 border border-neutral-200 cursor-pointer overflow-hidden relative transition hover:border-black hover:bg-neutral-100">
                        {{-- Hidden Input --}}
                        <input type="file" name="image" class="hidden" accept="image/*" @change="const file = $event.target.files[0]; 
                                        const reader = new FileReader(); 
                                        reader.onload = (e) => { imagePreview = e.target.result }; 
                                        reader.readAsDataURL(file)">

                        {{-- Default State --}}
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-neutral-400"
                            x-show="!imagePreview">
                            <span class="text-4xl font-thin mb-2">+</span>
                            <span class="text-[10px] uppercase tracking-widest">Upload Cover</span>
                        </div>

                        {{-- Preview State --}}
                        <img :src="imagePreview" x-show="imagePreview" class="w-full h-full object-cover"
                            style="display: none;">

                        {{-- Hover Effect --}}
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition duration-300"></div>
                    </label>
                    <p class="mt-3 text-[10px] text-neutral-400 uppercase tracking-wider text-center">
                        Format: JPG, PNG • Max: 2MB
                    </p>
                </div>
            </div>

            {{-- RIGHT COLUMN: SPECIFICATIONS --}}
            <div class="lg:col-span-8 space-y-12">

                {{-- 1. BASIC INFO --}}
                <div class="space-y-8">
                    {{-- Product Name --}}
                    <div class="group">
                        <label for="name"
                            class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2">Product
                            Name</label>
                        <input type="text" name="name" id="name" required
                            class="block w-full border-0 border-b border-neutral-200 bg-transparent py-2 px-0 text-3xl font-bold text-neutral-900 focus:border-black focus:ring-0 placeholder-neutral-200 transition-colors"
                            placeholder="E.g. Oversized Hoodie" />
                    </div>

                    {{-- Category & SKU Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Category Select --}}
                        <div>
                            <label for="category_id"
                                class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2">Category</label>
                            <select name="category_id" id="category_id"
                                class="block w-full border-0 border-b border-neutral-200 bg-transparent py-3 px-0 text-sm font-medium text-neutral-900 focus:border-black focus:ring-0 cursor-pointer">
                                <option value="" disabled selected>Select Category</option>
                                @foreach($categories ?? [] as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- SKU Input --}}
                        <div>
                            <label for="sku"
                                class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2">SKU
                                / Code</label>
                            <input type="text" name="sku" id="sku"
                                class="block w-full border-0 border-b border-neutral-200 bg-transparent py-3 px-0 text-sm font-mono text-neutral-900 focus:border-black focus:ring-0 placeholder-neutral-300"
                                placeholder="AUTO-GENERATED" />
                        </div>
                    </div>
                </div>

                {{-- 2. PRICING & STOCK --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-neutral-50">
                    {{-- Price --}}
                    <div>
                        <label for="price"
                            class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2">Price
                            (VND)</label>
                        <input type="number" name="price" id="price" required
                            class="block w-full border-0 border-b border-neutral-200 bg-transparent py-2 px-0 text-xl font-mono font-medium text-neutral-900 focus:border-black focus:ring-0 placeholder-neutral-200"
                            placeholder="0" />
                    </div>

                    {{-- Stock --}}
                    <div>
                        <label for="stock"
                            class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2">Stock
                            Quantity</label>
                        <input type="number" name="stock" id="stock" value="0"
                            class="block w-full border-0 border-b border-neutral-200 bg-transparent py-2 px-0 text-xl font-mono font-medium text-neutral-900 focus:border-black focus:ring-0 placeholder-neutral-200"
                            placeholder="0" />
                    </div>
                </div>

                {{-- 3. DESCRIPTION --}}
                <div class="pt-4">
                    <label for="description"
                        class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-4">Description
                        / Details</label>
                    <textarea name="description" id="description" rows="8"
                        class="block w-full bg-neutral-50 border-0 p-4 text-sm text-neutral-900 font-light leading-relaxed focus:ring-1 focus:ring-black placeholder-neutral-400 resize-none"
                        placeholder="Write a description about the material, fit, and style..."></textarea>
                </div>

            </div>
        </div>
    </form>
</x-admin-layout>