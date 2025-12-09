<x-admin-layout>
    {{-- Form Wrapper --}}
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
        class="max-w-6xl mx-auto">
        @csrf
        @method('PUT') {{-- Quan trọng: Báo cho Laravel biết đây là lệnh UPDATE --}}

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

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24">

            {{-- LEFT COLUMN: MEDIA --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Dùng ảnh hiện tại làm giá trị mặc định cho AlpineJS --}}
                <div x-data="{ imagePreview: '{{ $product->image ? Storage::url('products/'.$product->image) : '' }}' }"
                    class="relative group w-full">
                    <label
                        class="block w-full aspect-[3/4] bg-neutral-50 border border-neutral-200 cursor-pointer overflow-hidden relative transition hover:border-black hover:bg-neutral-100">
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

                        {{-- State: Đã có ảnh (Hiện tại hoặc Mới upload) --}}
                        <img :src="imagePreview" x-show="imagePreview" class="w-full h-full object-cover">

                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition duration-300"></div>
                    </label>
                    <p class="mt-3 text-[10px] text-neutral-400 uppercase tracking-wider text-center">
                        Click image to change • Max: 2MB
                    </p>
                </div>
            </div>

            {{-- RIGHT COLUMN: SPECIFICATIONS --}}
            <div class="lg:col-span-8 space-y-12">

                {{-- 1. BASIC INFO --}}
                <div class="space-y-8">
                    {{-- Name --}}
                    <div>
                        <label for="name"
                            class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2">Product
                            Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                            class="block w-full border-0 border-b border-neutral-200 bg-transparent py-2 px-0 text-3xl font-bold text-neutral-900 focus:border-black focus:ring-0 placeholder-neutral-200 transition-colors" />
                    </div>

                    {{-- Category & SKU --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="category_id"
                                class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2">Category</label>
                            <select name="category_id" id="category_id"
                                class="block w-full border-0 border-b border-neutral-200 bg-transparent py-3 px-0 text-sm font-medium text-neutral-900 focus:border-black focus:ring-0 cursor-pointer">
                                <option value="">No Category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : ''
                                    }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="sku"
                                class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2">SKU
                                / Code</label>
                            <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}"
                                class="block w-full border-0 border-b border-neutral-200 bg-transparent py-3 px-0 text-sm font-mono text-neutral-900 focus:border-black focus:ring-0" />
                        </div>
                    </div>
                </div>

                {{-- 2. PRICING & STOCK --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-neutral-50">
                    <div>
                        <label for="price"
                            class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2">Price
                            (VND)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                            required
                            class="block w-full border-0 border-b border-neutral-200 bg-transparent py-2 px-0 text-xl font-mono font-medium text-neutral-900 focus:border-black focus:ring-0" />
                    </div>

                    <div>
                        <label for="stock"
                            class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2">Stock
                            Quantity</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}"
                            class="block w-full border-0 border-b border-neutral-200 bg-transparent py-2 px-0 text-xl font-mono font-medium text-neutral-900 focus:border-black focus:ring-0" />
                    </div>
                </div>

                {{-- 3. DESCRIPTION --}}
                <div class="pt-4">
                    <label for="description"
                        class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-4">Description</label>
                    <textarea name="description" id="description" rows="8"
                        class="block w-full bg-neutral-50 border-0 p-4 text-sm text-neutral-900 font-light leading-relaxed focus:ring-1 focus:ring-black resize-none">{{ old('description', $product->description) }}</textarea>
                </div>

            </div>
        </div>
    </form>
</x-admin-layout>