@props(['disabled' => false, 'name', 'label', 'type' => 'text'])

<div class="relative z-0 w-full mb-6 group">
    {{-- 1. INPUT FIELD --}}
    <input {{ $disabled ? 'disabled' : '' }} type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" placeholder=" " {{
        $attributes->merge(['class' => 'block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2
    appearance-none focus:outline-none focus:ring-0 peer transition-colors duration-200 ' .
    ($errors->has($name)
    ? 'border-red-500 text-red-900 focus:border-red-500' // Khi LỖI: Viền đỏ, Chữ đỏ, Focus vẫn đỏ
    : 'text-neutral-900 border-neutral-300 focus:border-black' // Bình thường: Viền xám, Focus đen
    )
    ]) }}
    />

    {{-- 2. FLOATING LABEL (Hiệu ứng bay lên) --}}
    <label for="{{ $name }}" class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest 
        {{ $errors->has($name) ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
        {{ $label }}
    </label>

    {{-- 3. ERROR MESSAGE (Dòng chữ báo lỗi nhỏ bên dưới) --}}
    @error($name)
    <p class="mt-1 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
        {{ $message }}
    </p>
    @enderror
</div>