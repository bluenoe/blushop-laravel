<x-guest-layout>
    <div class="max-w-md mx-auto pt-10 pb-20 px-4 sm:px-0">

        <div class="text-center mb-12">
            <h1 class="text-2xl md:text-3xl font-bold uppercase tracking-tighter mb-3">
                Security Check
            </h1>
            <p class="text-xs text-neutral-400 font-light leading-relaxed max-w-xs mx-auto">
                This is a secure area. Please confirm your password before continuing.
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-10">
            @csrf

            {{-- Password --}}
            <div class="group relative">
                <label for="password"
                    class="block text-[10px] uppercase tracking-[0.2em] font-bold text-neutral-400 mb-2 group-focus-within:text-black transition">
                    Password
                </label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full border-0 border-b border-neutral-200 bg-transparent py-3 px-0 text-xl font-medium text-black focus:border-black focus:ring-0 placeholder-neutral-200 transition-all" />
                <x-input-error :messages="$errors->get('password')"
                    class="absolute -bottom-6 left-0 text-[10px] text-red-500 font-medium" />
            </div>

            <div class="pt-4 flex justify-between items-center">
                {{-- Nút quay lại (nếu muốn huỷ) --}}
                <a href="{{ url()->previous() }}"
                    class="text-[10px] uppercase tracking-widest text-neutral-400 hover:text-black transition">
                    Cancel
                </a>

                <button type="submit"
                    class="bg-black text-white py-3 px-8 uppercase tracking-[0.2em] text-[10px] font-bold hover:bg-neutral-800 transition shadow-xl shadow-black/10">
                    Confirm
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>