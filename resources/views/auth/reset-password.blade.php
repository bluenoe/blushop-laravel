<x-guest-layout>
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold mb-2 text-neutral-900">Set new password</h1>
        <p class="text-sm text-neutral-500 font-medium">
            Secure your account with a new password
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <x-floating-input name="email" label="Email Address" type="email" :value="old('email', $request->email)"
            required autofocus autocomplete="username" />

        <!-- Password -->
        <x-floating-input name="password" label="New Password" type="password" required autocomplete="new-password" />

        <!-- Confirm Password -->
        <x-floating-input name="password_confirmation" label="Confirm Password" type="password" required
            autocomplete="new-password" />

        <div class="pt-2">
            <button type="submit"
                class="w-full py-3.5 bg-black text-white font-semibold rounded-lg hover:bg-neutral-800 transition duration-300 hover:shadow-lg hover:-translate-y-0.5">
                {{ __('Reset password') }}
            </button>
        </div>
    </form>
</x-guest-layout>