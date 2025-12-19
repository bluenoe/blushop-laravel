<x-admin-layout>
    {{-- Form Section --}}
    <form action="{{ route('admin.categories.store') }}" method="POST" class="max-w-3xl mx-auto mt-20">
        @csrf

        {{-- Header Navigation --}}
        <div class="flex items-center justify-between mb-16">
            <a href="{{ route('admin.categories.index') }}"
                class="group flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>

            <h1 class="text-xl font-bold tracking-tighter">New Category</h1>
        </div>

        {{-- Main Content với Alpine Data để làm Slug Preview --}}
        <div class="space-y-12" x-data="{ name: '' }">

            {{-- Input Name khổng lồ --}}
            <div class="relative group">
                <label
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2 group-focus-within:text-black transition">
                    Category Name
                </label>
                <input type="text" name="name" x-model="name" required autofocus
                    class="block w-full border-0 border-b-2 border-neutral-100 bg-transparent py-4 px-0 text-4xl md:text-5xl font-bold tracking-tighter text-neutral-900 focus:border-black focus:ring-0 placeholder-neutral-200 transition-colors"
                    placeholder="E.g. Tops" />
            </div>

            {{-- Slug Preview Realtime --}}
            <div class="pt-8 border-t border-dashed border-neutral-200 transition-opacity duration-500"
                :class="name.length > 0 ? 'opacity-100' : 'opacity-0'">
                <span class="block text-[10px] uppercase tracking-widest text-neutral-400 mb-1">URL Preview</span>
                <p class="font-mono text-sm text-neutral-600 bg-neutral-50 p-2 rounded inline-block">
                    /category/<span x-text="name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '')"
                        class="text-black font-bold"></span>
                </p>
            </div>

            {{-- Submit Button --}}
            <div class="pt-4">
                <button type="submit"
                    class="w-full py-4 bg-black text-white text-xs font-bold uppercase tracking-[0.15em] hover:bg-neutral-800 transition shadow-lg shadow-neutral-500/20">
                    Create Category
                </button>
            </div>
        </div>

        {{-- Validation Error --}}
        @error('name')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </form>
</x-admin-layout>