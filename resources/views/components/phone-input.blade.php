@props(['disabled' => false, 'name' => 'phone', 'label' => 'Phone Number', 'value' => ''])

{{--
PHONE INPUT COMPONENT
- Ultra-minimalist design with bottom-border only
- Fixed +84 prefix for Vietnam
- Auto-strips leading zero
- Input masking: XXX XXX XXX
- Submits clean digits only
--}}

<div class="relative z-0 w-full mb-6 group" x-data="{
        displayValue: '',
        cleanValue: '',
        focused: false,

        init() {
            // Initialize with existing value if present
            const initial = '{{ old($name, $value) }}';
            if (initial) {
                this.cleanValue = initial.replace(/\D/g, '').replace(/^0/, '');
                this.formatDisplay();
            }
        },

        handleInput(e) {
            // Get only digits from input
            let digits = e.target.value.replace(/\D/g, '');
            
            // Strip leading zero
            if (digits.startsWith('0')) {
                digits = digits.slice(1);
            }
            
            // Limit to 9 digits (Vietnam mobile format after +84)
            digits = digits.slice(0, 9);
            
            // Store clean value
            this.cleanValue = digits;
            
            // Format display
            this.formatDisplay();
        },

        handlePaste(e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            
            // Extract only digits
            let digits = pasted.replace(/\D/g, '');
            
            // Handle if pasted with country code
            if (digits.startsWith('84')) {
                digits = digits.slice(2);
            }
            
            // Strip leading zero
            if (digits.startsWith('0')) {
                digits = digits.slice(1);
            }
            
            // Limit to 9 digits
            digits = digits.slice(0, 9);
            
            this.cleanValue = digits;
            this.formatDisplay();
        },

        formatDisplay() {
            // Format as XXX XXX XXX
            const d = this.cleanValue;
            if (d.length <= 3) {
                this.displayValue = d;
            } else if (d.length <= 6) {
                this.displayValue = d.slice(0, 3) + ' ' + d.slice(3);
            } else {
                this.displayValue = d.slice(0, 3) + ' ' + d.slice(3, 6) + ' ' + d.slice(6);
            }
        },

        get isActive() {
            return this.focused || this.cleanValue.length > 0;
        }
    }">

    {{-- Hidden input for form submission (clean digits only) --}}
    <input type="hidden" name="{{ $name }}" x-model="cleanValue">

    {{-- Visual Input Container --}}
    <div class="flex items-center w-full border-b-2 transition-colors duration-300" :class="{
            'border-red-500': {{ $errors->has($name) ? 'true' : 'false' }},
            'border-black': focused && !{{ $errors->has($name) ? 'true' : 'false' }},
            'border-neutral-300': !focused && !{{ $errors->has($name) ? 'true' : 'false' }}
        }">

        {{-- Fixed Prefix +84 --}}
        <span class="text-sm py-2.5 pr-2 transition-colors duration-300 select-none" :class="{
                'text-red-500': {{ $errors->has($name) ? 'true' : 'false' }},
                'text-neutral-900': focused && !{{ $errors->has($name) ? 'true' : 'false' }},
                'text-neutral-400': !focused && !{{ $errors->has($name) ? 'true' : 'false' }}
            }">
            +84
        </span>

        {{-- Visible Input Field --}}
        <input type="text" inputmode="numeric" autocomplete="off" {{ $disabled ? 'disabled' : '' }}
            x-model="displayValue" @input="handleInput($event)" @paste="handlePaste($event)" @focus="focused = true"
            @blur="focused = false" placeholder=" " class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 appearance-none focus:outline-none focus:ring-0 peer transition-colors duration-200
                {{ $errors->has($name) ? 'text-red-500' : 'text-neutral-900' }}" {{ $attributes->except('class') }}
        />
    </div>

    {{-- Floating Label --}}
    <label class="absolute text-sm duration-300 transform origin-[0] left-0 uppercase tracking-widest pointer-events-none transition-all
        {{ $errors->has($name) ? 'text-red-500' : '' }}" :class="{
            '-translate-y-6 scale-75 top-3 font-medium': isActive,
            'translate-y-0 scale-100 top-2.5 {{ $errors->has($name) ? '' : 'text-neutral-500' }}': !isActive,
            'text-black': focused && !{{ $errors->has($name) ? 'true' : 'false' }},
            'text-neutral-500': !focused && !{{ $errors->has($name) ? 'true' : 'false' }}
        }">
        {{ $label }}
    </label>

    {{-- Error Message --}}
    @error($name)
    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
        {{ $message }}
    </p>
    @enderror
</div>