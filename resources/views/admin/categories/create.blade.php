<x-admin-layout>
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
        class="max-w-2xl mx-auto mt-12">
        @csrf

        <div class="flex items-center justify-between mb-10 border-b border-neutral-100 pb-6">
            <h1 class="text-2xl font-bold tracking-tighter">New Category</h1>
            <a href="{{ route('admin.categories.index') }}"
                class="text-xs font-bold uppercase tracking-widest text-neutral-400 hover:text-black">Cancel</a>
        </div>

        <div class="space-y-8">
            {{-- Name --}}
            <div class="w-full">
                <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2">Category
                    Name</label>
                <input type="text" name="name" required
                    class="w-full border-0 border-b border-neutral-200 bg-transparent py-2 px-0 text-xl font-bold text-neutral-900 focus:border-black focus:ring-0 placeholder-neutral-200"
                    placeholder="E.g. Accessories" />
            </div>

            {{-- Image Upload (Minimal) --}}
            <div x-data="{ imagePreview: null }">
                <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-4">Category
                    Image</label>
                <label
                    class="block w-full h-48 bg-neutral-50 border border-dashed border-neutral-300 hover:border-black cursor-pointer relative transition-colors flex flex-col items-center justify-center">
                    <input type="file" name="image" class="hidden" accept="image/*" @change="const file = $event.target.files[0]; 
                                    const reader = new FileReader(); 
                                    reader.onload = (e) => { imagePreview = e.target.result }; 
                                    reader.readAsDataURL(file)">

                    <div class="text-neutral-400 flex flex-col items-center" x-show="!imagePreview">
                        <span class="text-2xl mb-2">+</span>
                        <span class="text-[10px] uppercase tracking-widest">Upload Banner</span>
                    </div>
                    <img :src="imagePreview" x-show="imagePreview" class="absolute inset-0 w-full h-full object-cover"
                        style="display: none;">
                </label>
            </div>

            <button type="submit"
                class="w-full py-4 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition">
                Create Category
            </button>
        </div>
    </form>
</x-admin-layout>