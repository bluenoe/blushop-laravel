<section x-data="{ preview: @json($user->avatar ? asset('storage/'.$user->avatar) : null) }">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data" aria-label="Update profile information">
        @csrf
        @method('patch')

        <!-- Avatar upload with clickable preview (no visible file button) -->
        <div>
            <x-input-label for="avatar" :value="__('Avatar')" />
            <div class="mt-3">
                <!-- Clickable avatar circle triggers hidden file input -->
                <div
                    class="group relative h-24 w-24 sm:h-28 sm:w-28 md:h-32 md:w-32 rounded-full overflow-hidden ring-1 ring-gray-700/60 bg-gray-900 flex items-center justify-center cursor-pointer transform-gpu transition duration-200 ease-out hover:scale-105 hover:opacity-95"
                    @click="$refs.avatarInput.click()"
                    aria-label="Change avatar"
                >
                    <template x-if="preview">
                        <img :src="preview" alt="Avatar preview" class="h-full w-full object-cover" />
                    </template>
                    <template x-if="!preview">
                        <div class="h-full w-full flex items-center justify-center text-xl sm:text-2xl font-bold bg-indigo-600 text-white" aria-hidden="true">
                            {{ Str::of($user->name)->substr(0, 1)->upper() }}
                        </div>
                    </template>

                    <!-- Minimal pencil overlay icon -->
                    <span class="pointer-events-none absolute bottom-2 right-2 h-7 w-7 rounded-full bg-gray-800/80 text-gray-200 flex items-center justify-center ring-1 ring-gray-700/50 opacity-0 group-hover:opacity-100 transition-opacity duration-200" aria-hidden="true">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z" />
                        </svg>
                    </span>
                </div>

                <!-- Hidden file input -->
                <input
                    id="avatar"
                    name="avatar"
                    x-ref="avatarInput"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    class="hidden"
                    @change="const f = $event.target.files[0]; if (f) { const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(f); }"
                    aria-describedby="avatar-help"
                />
            </div>
            <p id="avatar-help" class="mt-2 text-xs text-gray-600 dark:text-gray-400">JPG, JPEG, PNG, WEBP up to 2MB.</p>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" name="phone_number" type="tel" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)" autocomplete="tel" placeholder="+123456789" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <!-- Gender -->
        <div>
            <x-input-label :value="__('Gender')" />
            <div class="mt-2 flex items-center gap-6">
                @php($g = old('gender', $user->gender))
                <label class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300">
                    <input type="radio" name="gender" value="male" @checked($g === 'male') class="rounded dark:bg-gray-900" />
                    <span>Male</span>
                </label>
                <label class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300">
                    <input type="radio" name="gender" value="female" @checked($g === 'female') class="rounded dark:bg-gray-900" />
                    <span>Female</span>
                </label>
                <label class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300">
                    <input type="radio" name="gender" value="other" @checked($g === 'other' || $g === null) class="rounded dark:bg-gray-900" />
                    <span>Other</span>
                </label>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <!-- Birth Date -->
        <div>
            <x-input-label for="birth_date" :value="__('Date of Birth')" />
            <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="old('birth_date', optional($user->birth_date)->format('Y-m-d'))" />
            <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
