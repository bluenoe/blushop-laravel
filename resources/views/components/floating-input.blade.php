@props(['disabled' => false, 'name', 'label', 'type' => 'text'])

<div class="relative z-0 w-full mb-6 group">
    {{-- Wrapper Container for Input and Label to ensure correct stacking and centering --}}
    <div
        class="relative flex items-center w-full rounded-lg border bg-transparent transition-all duration-200 
        {{ $errors->has($name) ? 'border-red-500' : 'border-neutral-200 focus-within:border-black hover:border-neutral-300' }}">

        {{-- 1. INPUT FIELD --}}
        <input {{ $disabled ? 'disabled' : '' }} type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" placeholder=" "
            {{ $attributes->merge(['class' => 'block px-4 py-3.5 w-full text-sm text-neutral-900 bg-transparent
        appearance-none focus:outline-none focus:ring-0 peer border-none']) }}
        />

        {{-- 2. FLOATING LABEL (Hiệu ứng bay lên) --}}
        <label for="{{ $name }}" class="absolute text-[11px] font-medium tracking-[0.05em] uppercase text-neutral-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-3 
            {{ $errors->has($name) ? 'text-red-500' : 'peer-focus:text-black' }}">
            {{ $label }}
        </label>
    </div>

    {{-- 3. ERROR MESSAGE (Dòng chữ báo lỗi nhỏ bên dưới) --}}
    @error($name)
    <p class="mt-1 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
        {{ $message }}
    </p>
    @enderror
</div>