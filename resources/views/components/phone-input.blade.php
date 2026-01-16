@props(['disabled' => false, 'name', 'label' => 'Phone Number', 'value' => ''])

<div class="relative z-0 w-full mb-6 group" x-data="{
        displayVal: '',
        realVal: '',
        formatting() {
            // Remove all non-numeric characters
            let numbers = this.displayVal.replace(/\D/g, '');

            // Strip leading zero if present
            if (numbers.startsWith('0')) {
                numbers = numbers.substring(1);
            }

            // Limit to 9 digits (since we assume +84)
            numbers = numbers.substring(0, 9);
            this.realVal = numbers;

            // Format as XXX XXX XXX
            if (numbers.length > 6) {
                this.displayVal = `${numbers.slice(0, 3)} ${numbers.slice(3, 6)} ${numbers.slice(6)}`;
            } else if (numbers.length > 3) {
                this.displayVal = `${numbers.slice(0, 3)} ${numbers.slice(3)}`;
            } else {
                this.displayVal = numbers;
            }
        },
        init() {
            let initial = '{{ old($name, $value) }}';
            if (initial) {
                this.displayVal = initial;
                this.formatting();
            }
        }
    }">
    {{-- Hidden Input for actual submission --}}
    <input type="hidden" name="{{ $name }}" x-model="realVal">

    <div class="flex items-end">
        {{-- Prefix +84 --}}
        <span class="mb-2.5 mr-2 text-sm text-neutral-500 font-medium pt-1">+84</span>

        {{-- Visible Input Field --}}
        <div class="relative w-full">
            <input x-model="displayVal" @input="formatting" {{ $disabled ? 'disabled' : '' }} type="tel"
                id="{{ $name }}_display" placeholder=" " {{ $attributes->merge(['class' => 'block py-2.5 px-0 w-full
            text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer
            transition-colors duration-200 ' .
            ($errors->has($name)
            ? 'border-red-500 text-red-900 focus:border-red-500'
            : 'text-neutral-900 border-neutral-300 focus:border-black'
            )
            ]) }}
            />

            {{-- Floating Label --}}
            <label for="{{ $name }}_display" class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                peer-focus:left-0
                peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0
                peer-focus:scale-75 peer-focus:-translate-y-6
                uppercase tracking-widest
                {{ $errors->has($name) ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                {{ $label }}
            </label>
        </div>
    </div>

    {{-- Error Message --}}
    @error($name)
    <p class="mt-1 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
        {{ $message }}
    </p>
    @enderror
</div>