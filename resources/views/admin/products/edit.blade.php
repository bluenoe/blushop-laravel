<x-admin-layout>
    {{-- Form Wrapper --}}
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
        class="max-w-5xl mx-auto">
        @csrf
        @method('PUT') {{-- Quan trọng: Báo Laravel đây là update --}}

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
                {{-- Logic Alpine: Nếu có ảnh cũ thì load URL, nếu upload mới thì load Base64 --}}
                <div x-data="{ imagePreview: '{{ $product->image ? Storage::url('products/'.$product->image) : '' }}' }"
                    class="relative group">
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
                        {{-- Category Select --}}
                        <div class="relative z-0 w-full group">
                            <select name="category_id" id="category_id"
                                class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer">
                                <option value="">No Category</option>
                                @foreach($categories ?? [] as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : ''
                                    }}>
                                    {{ $cat->name }}
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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-4">
                    {{-- Price --}}
                    <div class="relative z-0 w-full group">
                        <input type="number" name="price" id="price" required
                            value="{{ old('price', $product->price) }}"
                            class="block py-2.5 px-0 w-full text-lg font-mono font-medium text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                            placeholder=" " />
                        <label for="price"
                            class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                            Price (VND)
                        </label>
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