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

        <!-- Avatar upload with preview -->
        <div>
            <x-input-label for="avatar" :value="__('Avatar')" />
            <div class="mt-2 flex items-center gap-4">
                <template x-if="preview">
                    <img :src="preview" alt="Current avatar" class="h-16 w-16 rounded-full object-cover" />
                </template>
                <template x-if="!preview">
                    <div class="h-16 w-16 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xl font-bold" aria-hidden="true">
                        {{ Str::of($user->name)->substr(0, 1)->upper() }}
                    </div>
                </template>
                <input
                    id="avatar"
                    name="avatar"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700"
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
