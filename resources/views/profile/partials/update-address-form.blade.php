{{-- Profile Address Book Form --}}
<form method="POST" action="{{ route('profile.address.update') }}">
    @csrf
    @method('patch')

    <div class="space-y-6">
        {{-- RECIPIENT NAME (Floating Label) --}}
        <div class="relative z-0 w-full group">
            <input type="text" name="name" id="address_name" required
                class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer transition-colors duration-200 
                {{ $errors->has('name') ? 'border-red-500 text-red-900 focus:border-red-500' : 'text-neutral-900 border-neutral-300 focus:border-black' }}" placeholder=" "
                value="{{ old('name', $defaultAddress->name ?? $user->name ?? '') }}" />

            <label for="address_name" class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest 
                {{ $errors->has('name') ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                Recipient Name
            </label>
            @error('name') <p class="mt-1 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">{{
                $message }}</p> @enderror
        </div>

        {{-- PHONE NUMBER (Floating Label) --}}
        <div class="relative z-0 w-full group">
            <input type="tel" name="phone" id="address_phone" required
                class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer transition-colors duration-200 
                {{ $errors->has('phone') ? 'border-red-500 text-red-900 focus:border-red-500' : 'text-neutral-900 border-neutral-300 focus:border-black' }}" placeholder=" "
                value="{{ old('phone', $defaultAddress->phone ?? $user->phone_number ?? '') }}" />

            <label for="address_phone" class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest 
                {{ $errors->has('phone') ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                Phone Number
            </label>
            @error('phone') <p class="mt-1 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">{{
                $message }}</p> @enderror
        </div>

        {{-- STREET ADDRESS (Floating Label - Textarea) --}}
        <div class="relative z-0 w-full group">
            <textarea name="address" id="address_street" rows="2" required
                class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer resize-none transition-colors duration-200 
                {{ $errors->has('address') ? 'border-red-500 text-red-900 focus:border-red-500' : 'text-neutral-900 border-neutral-300 focus:border-black' }}"
                placeholder=" ">{{ old('address', $defaultAddress->address ?? '') }}</textarea>

            <label for="address_street" class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest 
                {{ $errors->has('address') ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                Street Address
            </label>
            @error('address') <p class="mt-1 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
                {{ $message }}</p> @enderror
        </div>

        {{-- CITY / PROVINCE (Floating Label) --}}
        <div class="relative z-0 w-full group">
            <input type="text" name="city" id="address_city" required
                class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 peer transition-colors duration-200 
                {{ $errors->has('city') ? 'border-red-500 text-red-900 focus:border-red-500' : 'text-neutral-900 border-neutral-300 focus:border-black' }}" placeholder=" "
                value="{{ old('city', $defaultAddress->city ?? '') }}" />

            <label for="address_city" class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest 
                {{ $errors->has('city') ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                City / Province
            </label>
            @error('city') <p class="mt-1 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">{{
                $message }}</p> @enderror
        </div>
    </div>

    {{-- Status Message --}}
    @if (session('status') === 'address-updated')
    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
        class="mt-6 text-xs text-green-600 font-bold uppercase tracking-widest">
        Address saved successfully.
    </p>
    @endif

    {{-- Save Button --}}
    <div class="mt-8">
        <button type="submit"
            class="px-8 py-3 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-neutral-800 transition transform hover:-translate-y-0.5">
            Save Address
        </button>
    </div>
</form>