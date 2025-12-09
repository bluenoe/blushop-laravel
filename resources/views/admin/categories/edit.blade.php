<x-admin-layout>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data"
        class="max-w-2xl mx-auto mt-12">
        @csrf
        @method('PUT')

        <div class="flex items-center justify-between mb-10 border-b border-neutral-100 pb-6">
            <h1 class="text-2xl font-bold tracking-tighter">Edit Category</h1>
            <a href="{{ route('admin.categories.index') }}"
                class="text-xs font-bold uppercase tracking-widest text-neutral-400 hover:text-black">Cancel</a>
        </div>

        <div class="space-y-8">
            <div class="w-full">
                <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2">Category
                    Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                    class="w-full border-0 border-b border-neutral-200 bg-transparent py-2 px-0 text-xl font-bold text-neutral-900 focus:border-black focus:ring-0" />
            </div>

            <div
                x-data="{ imagePreview: '{{ $category->image ? Storage::url('categories/'.$category->image) : '' }}' }">
                <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-4">Category
                    Image</label>
                <label
                    class="block w-full h-48 bg-neutral-50 border border-dashed border-neutral-300 hover:border-black cursor-pointer relative transition-colors">
                    <input type="file" name="image" class="hidden" accept="image/*" @change="const file = $event.target.files[0]; 
                                    const reader = new FileReader(); 
                                    reader.onload = (e) => { imagePreview = e.target.result }; 
                                    reader.readAsDataURL(file)">

                    <div class="absolute inset-0 flex flex-col items-center justify-center text-neutral-400"
                        x-show="!imagePreview">
                        <span class="text-2xl mb-2">+</span>
                        <span class="text-[10px] uppercase tracking-widest">Change Banner</span>
                    </div>
                    <img :src="imagePreview" x-show="imagePreview" class="absolute inset-0 w-full h-full object-cover">
                </label>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 py-4 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition">
                    Update Category
                </button>

                {{-- Nút xóa luôn cho tiện --}}
                <button type="button"
                    onclick="if(confirm('Delete this category? Products inside will become uncategorized.')) document.getElementById('delete-form').submit()"
                    class="px-8 py-4 border border-red-200 text-red-500 text-xs font-bold uppercase tracking-widest hover:bg-red-50 transition">
                    Delete
                </button>
            </div>
        </div>
    </form>

    <form id="delete-form" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="hidden">
        @csrf @method('DELETE')
    </form>
</x-admin-layout>