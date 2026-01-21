<x-admin-layout>
    {{-- Form Wrapper --}}
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
        class="max-w-5xl mx-auto">
        @csrf
        @method('PUT') {{-- Quan trọng: Báo Laravel đây là update --}}

        {{-- VALIDATION ERRORS DISPLAY --}}
        @if ($errors->any())
        <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-lg">
            <p class="font-bold text-red-700 text-sm uppercase tracking-wide mb-2">⚠️ Validation Failed</p>
            <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
        <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="font-medium text-green-700 text-sm">✅ {{ session('success') }}</p>
        </div>
        @endif

        {{-- HEADER & ACTIONS --}}
        <div class="flex items-end justify-between mb-12 border-b border-neutral-100 pb-6">
            <div>
                <a href="{{ route('admin.products.index') }}"
                    class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition mb-2 block">
                    &larr; Back to Catalogue
                </a>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tighter">Edit Entry</h1>
                <p class="text-xs text-neutral-400 mt-2 font-mono">ID: #{{ $product->id }}</p>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="px-8 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition transform active:scale-95">
                    Save Changes
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">

            {{-- LEFT COLUMN: MEDIA (IMAGE UPLOAD) --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Logic Alpine: Build correct URL using slug --}}
                @php
                $editImgSlug = $product->slug ?? '';
                $editImgRaw = $product->image ?? null;
                $editImgPreview = '';

                if ($editImgSlug && $editImgRaw) {
                if (Str::startsWith($editImgRaw, ['http://', 'https://'])) {
                $editImgPreview = $editImgRaw;
                } else {
                $editImgPreview = asset('storage/products/' . $editImgSlug . '/' . basename($editImgRaw));
                }
                }
                @endphp
                <div x-data="{ imagePreview: '{{ $editImgPreview }}' }" class="relative group">
                    <label
                        class="block w-full aspect-[3/4] bg-neutral-50 border border-neutral-200 cursor-pointer overflow-hidden relative transition hover:border-black hover:bg-neutral-100">
                        {{-- Hidden Input --}}
                        <input type="file" name="image" class="hidden" accept="image/*" @change="const file = $event.target.files[0]; 
                                        const reader = new FileReader(); 
                                        reader.onload = (e) => { imagePreview = e.target.result }; 
                                        reader.readAsDataURL(file)">

                        {{-- State: Chưa có ảnh --}}
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-neutral-400"
                            x-show="!imagePreview">
                            <span class="text-4xl font-thin mb-2">+</span>
                            <span class="text-[10px] uppercase tracking-widest">Upload Cover</span>
                        </div>

                        {{-- State: Preview (Ảnh cũ hoặc Ảnh mới) --}}
                        <img :src="imagePreview" x-show="imagePreview" class="w-full h-full object-cover">

                        {{-- Hover Effect --}}
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition duration-300"></div>
                    </label>
                    <p class="mt-3 text-[10px] text-neutral-400 uppercase tracking-wider text-center">
                        Click image to change • Max: 2MB
                    </p>
                </div>
            </div>

            {{-- RIGHT COLUMN: SPECIFICATIONS --}}
            <div class="lg:col-span-8 space-y-10">

                {{-- 1. BASIC INFO --}}
                <div class="space-y-8">
                    {{-- Product Name (Floating Label) --}}
                    <div class="relative z-0 w-full group">
                        <input type="text" name="name" id="name" required value="{{ old('name', $product->name) }}"
                            class="block py-2.5 px-0 w-full text-xl font-bold text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                            placeholder=" " />
                        <label for="name"
                            class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                            Product Name
                        </label>
                    </div>

                    {{-- Category & SKU Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Category Select (Dynamic from DB) --}}
                        <div class="relative z-0 w-full group">
                            <select name="category_id" id="category_id"
                                class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) ==
                                    $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            <label for="category_id"
                                class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                                Category
                            </label>
                        </div>

                        {{-- SKU Input --}}
                        <div class="relative z-0 w-full group">
                            <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}"
                                class="block py-2.5 px-0 w-full text-sm font-mono text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                                placeholder=" " />
                            <label for="sku"
                                class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                                SKU / Code
                            </label>
                        </div>
                    </div>
                </div>

                {{-- 2. PRICING & STOCK --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                    {{-- Selling Price (Base Price) --}}
                    <div class="relative z-0 w-full group">
                        <input type="number" name="base_price" id="base_price" required
                            value="{{ old('base_price', $product->base_price) }}" step="10000" min="0"
                            class="block py-2.5 px-0 w-full text-lg font-mono font-medium text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                            placeholder=" " />
                        <label for="base_price"
                            class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                            Selling Price (VND)
                        </label>
                        <p class="mt-2 text-[10px] text-neutral-400">Giá bán thực tế cho khách hàng</p>
                    </div>

                    {{-- Original Price (List Price - for strikethrough) --}}
                    <div class="relative z-0 w-full group">
                        <input type="number" name="original_price" id="original_price"
                            value="{{ old('original_price', $product->original_price) }}" step="10000" min="0"
                            class="block py-2.5 px-0 w-full text-lg font-mono font-medium text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                            placeholder=" " />
                        <label for="original_price"
                            class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                            Original Price (VND)
                        </label>
                        <p class="mt-2 text-[10px] text-neutral-400">Giá gốc - Hiển thị gạch ngang nếu cao hơn Selling
                            Price</p>
                    </div>

                    {{-- Stock --}}
                    <div class="relative z-0 w-full group">
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                            class="block py-2.5 px-0 w-full text-lg font-mono font-medium text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                            placeholder=" " />
                        <label for="stock"
                            class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                            Stock Qty
                        </label>
                    </div>

                    {{-- On Sale Toggle --}}
                    <div class="flex items-center gap-4 pt-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_on_sale" value="1" {{ old('is_on_sale',
                                $product->is_on_sale) ? 'checked' : '' }}
                            class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-neutral-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-black rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black">
                            </div>
                        </label>
                        <div>
                            <span class="text-sm font-medium text-neutral-900">On Sale</span>
                            <p class="text-[10px] text-neutral-400">Hiển thị badge "Sale" và giá gạch ngang</p>
                        </div>
                    </div>
                </div>

                {{-- 3. DESCRIPTION --}}
                <div class="pt-4">
                    <label for="description"
                        class="block mb-4 text-xs font-bold uppercase tracking-widest text-neutral-400">Description /
                        Details</label>
                    <textarea name="description" id="description" rows="6"
                        class="block p-4 w-full text-sm text-neutral-900 bg-neutral-50 border-0 focus:ring-1 focus:ring-black placeholder-neutral-400 font-light leading-relaxed"
                        placeholder="Describe the silhouette, fabric, and fit...">{{ old('description', $product->description) }}</textarea>
                </div>

            </div>
        </div>
    </form>
</x-admin-layout>