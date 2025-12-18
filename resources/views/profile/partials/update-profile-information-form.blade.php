<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-10" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- AVATAR UPLOAD: Clean Circle --}}
        <div class="flex items-center gap-6">
            <div class="relative group cursor-pointer" onclick="document.getElementById('avatar').click()">
                <div
                    class="w-20 h-20 rounded-full overflow-hidden bg-neutral-100 ring-1 ring-neutral-200 group-hover:ring-black transition">
                    @if ($user->avatar)
                    <img id="avatarPreview" src="{{ $user->avatarUrl() }}" class="w-full h-full object-cover" />
                    @else
                    <div id="avatarPreviewPlaceholder"
                        class="w-full h-full flex items-center justify-center bg-black text-white text-2xl font-bold">
                        {{ Str::substr($user->name, 0, 1) }}
                    </div>
                    @endif
                </div>
                <div
                    class="absolute inset-0 bg-black/20 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <input id="avatar" name="avatar" type="file" class="hidden" onchange="previewAvatar(event)"
                    accept="image/*" />
            </div>
            <div>
                <button type="button" onclick="document.getElementById('avatar').click()"
                    class="text-xs font-bold uppercase tracking-widest hover:text-neutral-500 transition">Change
                    Photo</button>
                <p class="text-[10px] text-neutral-400 mt-1">JPG, PNG or WEBP. Max 1MB.</p>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <script>
            function previewAvatar(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.getElementById('avatarPreview');
                        const placeholder = document.getElementById('avatarPreviewPlaceholder');
                        if (img) img.src = e.target.result;
                        if (placeholder) {
                            placeholder.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                        }
                    }
                    reader.readAsDataURL(file);
                }
            }
        </script>

        {{-- FORM FIELDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="relative z-0 w-full group">
                <input type="text" name="name" id="name"
                    class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                    placeholder=" " value="{{ old('name', $user->name) }}" required />
                <label for="name"
                    class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">Full
                    Name</label>
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div class="relative z-0 w-full group">
                <input type="email" name="email" id="email"
                    class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                    placeholder=" " value="{{ old('email', $user->email) }}" required />
                <label for="email"
                    class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">Email
                    Address</label>
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div class="relative z-0 w-full group">
                <input type="tel" name="phone_number" id="phone_number"
                    class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                    placeholder=" " value="{{ old('phone_number', $user->phone_number) }}" />
                <label for="phone_number"
                    class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">Phone
                    Number</label>
            </div>

            <div class="relative z-0 w-full group">
                <input type="date" name="birth_date" id="birth_date"
                    class="block py-2.5 px-0 w-full text-sm text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                    placeholder=" " value="{{ old('birth_date', optional($user->birth_date)->format('Y-m-d')) }}" />
                <label for="birth_date"
                    class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">Date
                    of Birth</label>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                class="px-8 py-3 bg-black text-white font-bold uppercase text-xs tracking-widest hover:bg-neutral-800 transition">Save
                Changes</button>
            @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-xs text-green-600 font-bold uppercase tracking-wider">Saved.</p>
            @endif
        </div>
    </form>
</section>