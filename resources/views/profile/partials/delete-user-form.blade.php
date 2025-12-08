<section class="space-y-6">
    <p class="text-sm text-neutral-500 max-w-xl">
        Once your account is deleted, all of its resources and data will be permanently deleted. Please download any
        data or information that you wish to retain before proceeding.
    </p>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="text-xs font-bold uppercase tracking-widest text-red-600 border border-red-200 px-6 py-3 hover:bg-red-50 transition">{{
        __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-neutral-900 mb-4">
                {{ __('Are you sure?') }}
            </h2>

            <p class="text-sm text-neutral-500 mb-6">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please
                enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="relative z-0 w-full group mb-6">
                <input type="password" name="password" id="password"
                    class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                    placeholder=" " />
                <label for="password"
                    class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">Password</label>
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')"
                    class="text-xs font-bold uppercase tracking-widest text-neutral-500 hover:text-black transition">
                    {{ __('Cancel') }}
                </button>

                <button type="submit"
                    class="px-6 py-2 bg-red-600 text-white font-bold uppercase text-xs tracking-widest hover:bg-red-700 transition">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>