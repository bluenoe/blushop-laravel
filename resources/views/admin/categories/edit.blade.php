<x-admin-layout>
    {{-- Form Section --}}
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="max-w-3xl mx-auto mt-20">
        @csrf
        @method('PUT')

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

            {{-- Status Badge (Trang trí cho đỡ trống) --}}
            <span
                class="px-3 py-1 rounded-full bg-neutral-100 text-neutral-500 text-[10px] font-mono font-medium uppercase tracking-wide">
                ID: #{{ $category->id }}
            </span>
        </div>

        {{-- Main Content --}}
        <div class="space-y-12">

            {{-- Input Name khổng lồ (Style Typography) --}}
            <div class="relative group">
                <label
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2 group-focus-within:text-black transition">
                    Category Name
                </label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                    class="block w-full border-0 border-b-2 border-neutral-100 bg-transparent py-4 px-0 text-4xl md:text-5xl font-bold tracking-tighter text-neutral-900 focus:border-black focus:ring-0 placeholder-neutral-200 transition-colors"
                    placeholder="Enter Name..." />
            </div>

            {{-- Metadata Info (Slug & Count) - Để lấp khoảng trống một cách tinh tế --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-dashed border-neutral-200">
                <div>
                    <span class="block text-[10px] uppercase tracking-widest text-neutral-400 mb-1">Generated
                        Slug</span>
                    <p class="font-mono text-sm text-neutral-600 bg-neutral-50 p-2 rounded inline-block">
                        {{ $category->slug }}
                    </p>
                </div>
                <div>
                    <span class="block text-[10px] uppercase tracking-widest text-neutral-400 mb-1">Total
                        Products</span>
                    <p class="font-mono text-sm text-neutral-900">
                        {{ $category->products_count ?? 0 }} items
                    </p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-4 pt-8">
                <button type="submit"
                    class="flex-1 py-4 bg-black text-white text-xs font-bold uppercase tracking-[0.15em] hover:bg-neutral-800 transition shadow-lg shadow-neutral-500/20">
                    Save Changes
                </button>

                <button type="button"
                    onclick="if(confirm('Are you sure? This action cannot be undone.')) document.getElementById('delete-form').submit()"
                    class="px-8 py-4 bg-white border border-red-100 text-red-500 text-xs font-bold uppercase tracking-widest hover:bg-red-50 hover:border-red-200 transition">
                    Delete
                </button>
            </div>
        </div>
    </form>

    {{-- Hidden Delete Form --}}
    <form id="delete-form" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="hidden">
        @csrf @method('DELETE')
    </form>
</x-admin-layout>