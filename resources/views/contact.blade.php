{{--
    Contact page
    UI-only Tailwind refresh to match landing page theme.
--}}

<x-app-layout>
    <section class="max-w-3xl mx-auto px-6 py-12 sm:py-16">
        {{-- Flash success --}}
        @if(session('success'))
            <div class="mb-4 rounded-md border border-green-200 bg-green-50 text-green-700 p-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
            <div class="p-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">Contact Us</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Send us a message and we’ll get back to you soon.</p>

                <form method="POST" action="{{ route('contact.send') }}" class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Your Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                        <textarea id="message" name="message" rows="5"
                                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 @error('message') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2 flex flex-wrap gap-3">
                        <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 text-white px-4 py-2 hover:bg-indigo-700 transition">Send</button>
                        <a href="{{ route('home') }}" class="inline-flex items-center rounded-md border border-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-900 transition">Back Home</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-gray-600 dark:text-gray-400 text-sm mt-3">
            <em>Note:</em> We store your message in our database only. No email is sent.
        </div>
    </section>
</x-app-layout>
