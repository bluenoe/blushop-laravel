<x-app-layout>
    <main class="bg-white min-h-screen text-neutral-900">
        <div class="max-w-[1400px] mx-auto px-6 py-20 lg:py-32">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24 items-start">

                {{-- LEFT: ACCOUNT NAVIGATION (Đồng bộ với trang Order History) --}}
                <div class="lg:col-span-3 lg:sticky lg:top-32">
                    <div class="mb-10">
                        <h2 class="text-3xl font-bold tracking-tighter">My Account.</h2>
                        <p class="text-sm text-neutral-400 mt-2 font-light">Welcome back, {{ Auth::user()->name }}</p>
                    </div>

                    <nav class="space-y-1 border-l-2 border-neutral-100 pl-6">
                        {{-- Profile (Active) --}}
                        <a href="{{ route('profile.edit') }}"
                            class="block py-2 text-xs font-bold uppercase tracking-widest text-black border-l-2 border-black -ml-[26px] pl-6 transition">
                            Settings
                        </a>

                        {{-- Orders (Link sang trang riêng) --}}
                        <a href="{{ route('orders.index') }}"
                            class="block py-2 text-xs font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition">
                            Order History
                        </a>

                        {{-- Wishlist (Link sang trang riêng) --}}
                        <a href="{{ route('wishlist.index') }}"
                            class="block py-2 text-xs font-bold uppercase tracking-widest text-neutral-400 hover:text-black transition">
                            Wishlist
                        </a>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}" class="pt-8">
                            @csrf
                            <button type="submit"
                                class="text-xs text-red-500 uppercase tracking-widest hover:text-red-700 hover:underline underline-offset-4">
                                Log Out
                            </button>
                        </form>
                    </nav>
                </div>

                {{-- RIGHT: CONTENT AREA --}}
                <div class="lg:col-span-9">

                    {{-- Alpine Tab cho nội bộ Profile (Info vs Password) --}}
                    <div
                        x-data="{ tab: '{{ $errors->updatePassword->any() || session('status') === 'password-updated' ? 'password' : 'info' }}' }">
                        {{-- Inner Tabs Header --}}
                        <div class="flex gap-8 border-b border-neutral-200 mb-12 pb-1">
                            <button @click="tab='info'"
                                class="text-xs font-bold uppercase tracking-widest pb-4 transition border-b-2"
                                :class="tab==='info' ? 'border-black text-black' : 'border-transparent text-neutral-400 hover:text-black'">
                                Personal Info
                            </button>
                            <button @click="tab='password'"
                                class="text-xs font-bold uppercase tracking-widest pb-4 transition border-b-2"
                                :class="tab==='password' ? 'border-black text-black' : 'border-transparent text-neutral-400 hover:text-black'">
                                Security
                            </button>
                        </div>

                        {{-- TAB 1: INFO --}}
                        <div x-show="tab==='info'" x-transition.opacity>
                            <div class="max-w-xl space-y-12">
                                <div>
                                    <h3 class="text-lg font-bold mb-6">Details</h3>
                                    @include('profile.partials.update-profile-information-form')
                                </div>

                                <div class="pt-12 border-t border-neutral-100">
                                    <h3 class="text-lg font-bold mb-4 text-red-600">Danger Zone</h3>
                                    <p class="text-sm text-neutral-500 mb-6">Once you delete your account, there is no
                                        going back. Please be certain.</p>
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>

                        {{-- TAB 2: PASSWORD --}}
                        <div x-show="tab==='password'" x-cloak x-transition.opacity>
                            <div class="max-w-xl">
                                <h3 class="text-lg font-bold mb-6">Change Password</h3>
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>