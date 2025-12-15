@props(['disabled' => false, 'messages' => [], 'label' => '', 'name' => ''])

<div class="mb-5">
    {{-- 1. Label: Chữ nhỏ, in hoa --}}
    @if($label)
    <label for="{{ $name }}" class="block text-[10px] font-bold uppercase tracking-widest mb-2 text-neutral-500">
        {{ $label }}
    </label>
    @endif

    {{-- 2. Input Field --}}
    {{-- Logic: Nếu có lỗi ($messages) -> Viền đỏ. Không lỗi -> Viền xám, focus đen --}}
    <input {{ $disabled ? 'disabled' : '' }} name="{{ $name }}" id="{{ $name }}" {!! $attributes->merge([
    'class' => 'w-full bg-neutral-50 border p-4 text-sm transition duration-200 outline-none placeholder-neutral-400
    disabled:opacity-50 disabled:bg-neutral-100 ' .
    ($errors->has($name)
    ? 'border-red-500 text-red-900 focus:border-red-500 focus:ring-1 focus:ring-red-500' // Style khi LỖI
    : 'border-transparent focus:bg-white focus:border-black focus:ring-0' // Style BÌNH THƯỜNG
    )
    ]) !!}
    >

    {{-- 3. Error Message: Dòng chữ đỏ nhỏ bên dưới --}}
    @error($name)
    <p class="mt-1 text-[10px] font-medium text-red-500 uppercase tracking-wider animate-pulse">
        {{ $message }}
    </p>
    @enderror
</div>