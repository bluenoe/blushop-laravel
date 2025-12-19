<x-admin-layout>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="mt-8 pb-20">
        @csrf
        @method('PUT')

        {{-- TOP BAR: Navigation & Main Actions --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-12 border-b border-black pb-6">
            <div>
                <a href="{{ route('admin.categories.index') }}"
                    class="group inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400 hover:text-black transition mb-2">
                    <svg class="w-3 h-3 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Categories
                </a>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tighter">
                    {{ $category->name }}
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="px-8 py-3 bg-black text-white text-[10px] font-bold uppercase tracking-[0.2em] hover:bg-neutral-800 transition shadow-xl shadow-black/10">
                    Save Changes
                </button>
            </div>
        </div>

        {{-- MAIN LAYOUT: 2 Columns --}}
        {{-- 1. Thêm x-data vào đây để bao trọn khu vực Main Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-24"
            x-data="{ name: '{{ addslashes($category->name) }}' }">

            {{-- COL 1: Main Content --}}
            <div class="lg:col-span-2 space-y-12">

                {{-- Field: Name --}}
                <div class="group">
                    <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-4">
                        Category Name
                    </label>

                    {{-- 2. Thêm x-model="name" vào input để bắt sự kiện gõ phím --}}
                    <input type="text" name="name" x-model="name" required
                        class="block w-full border-0 border-b border-neutral-200 bg-transparent py-2 px-0 text-5xl md:text-6xl font-bold tracking-tighter text-neutral-900 focus:border-black focus:ring-0 placeholder-neutral-200 transition-all"
                        placeholder="Name..." />

                    <p class="text-xs text-neutral-400 mt-4 font-light mb-8">
                        The name is how it appears on your site. Make it short and clear.
                    </p>

                    {{-- 3. CHÈN PHẦN PREVIEW VÀO ĐÂY (Đã style lại cho hợp layout Edit) --}}
                    <div class="pl-4 border-l-2 border-neutral-100 transition-opacity duration-500"
                        :class="name.length > 0 ? 'opacity-100' : 'opacity-0'">
                        <span class="block text-[10px] uppercase tracking-widest text-neutral-400 mb-1">Generated URL
                            Preview</span>
                        <p class="font-mono text-sm text-neutral-500">
                            blushop.com/category/<span
                                x-text="name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '')"
                                class="text-black font-bold bg-neutral-100 px-1 rounded"></span>
                        </p>
                    </div>
                </div>

                {{-- Field: Slug (Advanced Edit) --}}
                <div x-data="{ editing: false, slug: '{{ $category->slug }}' }"
                    class="pt-8 border-t border-dashed border-neutral-200">
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400">
                            Official URL Slug (DB)
                        </label>
                        <button type="button"
                            @click="editing = !editing; if(editing) $nextTick(() => $refs.slugInput.focus())"
                            class="text-[10px] font-bold uppercase tracking-wider text-neutral-400 hover:text-black underline decoration-neutral-300 underline-offset-4">
                            <span x-text="editing ? 'Cancel' : 'Edit Slug'"></span>
                        </button>
                    </div>

                    <div class="relative">
                        {{-- Read-only View --}}
                        <div x-show="!editing"
                            class="flex items-center gap-2 font-mono text-sm text-neutral-500 bg-neutral-50 p-4 rounded-sm border border-neutral-100">
                            <span class="text-neutral-300">blushop.com/category/</span>
                            {{-- Hiển thị slug thực tế đang lưu trong DB --}}
                            <span class="text-black font-medium">{{ $category->slug }}</span>
                        </div>

                        {{-- Editable View --}}
                        <div x-show="editing" x-cloak class="relative">
                            <span
                                class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400 font-mono text-sm select-none">/category/</span>
                            <input x-ref="slugInput" type="text" name="slug" value="{{ old('slug', $category->slug) }}"
                                class="block w-full pl-24 pr-4 py-4 bg-white border border-black font-mono text-sm text-black focus:ring-0 focus:border-black" />
                        </div>
                    </div>
                    <p class="text-[10px] text-orange-500 mt-2 font-medium" x-show="editing" x-cloak>
                        ⚠ Changing the slug might affect existing SEO links.
                    </p>
                </div>
            </div>

            {{-- COL 2: Sidebar --}}
            <div class="space-y-10">
                {{-- Giữ nguyên phần Sidebar cũ của bà --}}
                <div class="bg-neutral-50 p-8 border border-neutral-100">
                    <h3
                        class="text-xs font-bold uppercase tracking-widest text-black mb-6 border-b border-neutral-200 pb-2">
                        Insights
                    </h3>
                    <dl class="space-y-6">
                        <div class="flex justify-between items-center">
                            <dt class="text-[10px] uppercase tracking-wider text-neutral-400">Products</dt>
                            <dd class="font-mono text-xl font-bold text-black">{{ $category->products_count ?? 0 }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-[10px] uppercase tracking-wider text-neutral-400">System ID</dt>
                            <dd class="font-mono text-xs text-neutral-600">#{{ $category->id }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-[10px] uppercase tracking-wider text-neutral-400">Created</dt>
                            <dd class="font-mono text-xs text-neutral-600">{{ $category->created_at->format('M d, Y') }}
                            </dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-[10px] uppercase tracking-wider text-neutral-400">Last Update</dt>
                            <dd class="font-mono text-xs text-neutral-600">{{ $category->updated_at->diffForHumans() }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="pt-6">
                    <button type="button"
                        onclick="if(confirm('Are you sure you want to delete \'{{ $category->name }}\'?')) document.getElementById('delete-form').submit()"
                        class="w-full group flex items-center justify-between px-6 py-4 border border-red-100 bg-white hover:bg-red-50 hover:border-red-200 transition text-left">
                        <div>
                            <span class="block text-xs font-bold uppercase tracking-widest text-red-600 mb-1">Delete
                                Category</span>
                            <span class="block text-[10px] text-red-400">Irreversible action</span>
                        </div>
                        <svg class="w-4 h-4 text-red-300 group-hover:text-red-600 transition" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <form id="delete-form" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="hidden">
        @csrf @method('DELETE')
    </form>
</x-admin-layout>