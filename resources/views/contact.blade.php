<x-app-layout>
    <main class="bg-white text-neutral-900 min-h-screen">

        {{-- 1. HERO HEADER --}}
        <section class="pt-24 pb-12 sm:pt-32 sm:pb-20 px-6 border-b border-neutral-100">
            <div class="max-w-[1400px] mx-auto">
                <div class="max-w-3xl" data-reveal>
                    <p class="text-[10px] uppercase tracking-[0.3em] font-bold text-neutral-400 mb-6 pl-1">
                        Get in Touch
                    </p>
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold tracking-tighter leading-[0.9] mb-8">
                        Let's Start a <br>
                        <span class="font-serif italic font-light text-neutral-500 ml-4">Conversation.</span>
                    </h1>
                </div>
            </div>
        </section>

        {{-- 2. MAIN CONTENT --}}
        <section class="max-w-[1400px] mx-auto px-6 py-20 lg:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24">

                {{-- LEFT COLUMN: INFO & MAP --}}
                <div class="lg:col-span-5 space-y-16" data-reveal>

                    {{-- Contact Info Block --}}
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-widest mb-8">Contact Details</h3>
                        <div class="space-y-8 text-lg font-light">
                            <div>
                                <p class="text-xs uppercase text-neutral-400 mb-1">Email</p>
                                <a href="mailto:baokhanh.dev281@gmail.com"
                                    class="hover:underline decoration-1 underline-offset-4">baokhanh.dev281@gmail.com</a>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-neutral-400 mb-1">Phone</p>
                                <a href="tel:+84901234567" class="hover:underline decoration-1 underline-offset-4">+84
                                    90 123 45 67</a>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-neutral-400 mb-1">Studio</p>
                                <p>District Hai Chau, Da Nang City<br>Vietnam</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-neutral-400 mb-1">Hours</p>
                                <p>Mon – Sun<br>9:00 – 21:00 (GMT+7)</p>
                            </div>
                        </div>
                    </div>

                    {{-- Map (Grayscale Filter) --}}
                    <div
                        class="aspect-square bg-neutral-100 grayscale opacity-80 hover:grayscale-0 hover:opacity-100 transition duration-700">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3833.835766299076!2d108.21782297592658!3d16.07399853931037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142183742462e73%3A0x6296330030d32d38!2sDa%20Nang%2C%20Hai%20Chau%20District%2C%20Da%20Nang%2C%20Vietnam!5e0!3m2!1sen!2s!4v1700000000000!5m2!1sen!2s"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                {{-- RIGHT COLUMN: FORM (VALIDATE NÂNG CẤP) --}}
                <div class="lg:col-span-7" data-reveal style="transition-delay: 200ms">

                    @if (session('success'))
                    <div class="mb-12 p-6 bg-black text-white flex items-center gap-3 shadow-xl">
                        <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-sm font-medium tracking-wide uppercase">{{ session('success') }}</p>
                    </div>
                    @endif

                    {{-- Thêm novalidate để tắt popup mặc định --}}
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-12" novalidate>
                        @csrf

                        {{-- Name --}}
                        <div class="group relative z-0 w-full">
                            <input type="text" name="name" id="name" required value="{{ old('name') }}" class="block py-4 px-0 w-full text-xl bg-transparent border-0 border-b appearance-none focus:outline-none focus:ring-0 peer transition-colors duration-300
                                {{ $errors->has('name') 
                                    ? 'border-red-500 text-red-900 focus:border-red-500' 
                                    : 'border-neutral-300 text-neutral-900 focus:border-black' }}" placeholder=" " />

                            <label for="name"
                                class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest
                                {{ $errors->has('name') ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                                Your Name
                            </label>

                            {{-- Error Message --}}
                            @error('name')
                            <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="group relative z-0 w-full">
                            <input type="email" name="email" id="email" required value="{{ old('email') }}" class="block py-4 px-0 w-full text-xl bg-transparent border-0 border-b appearance-none focus:outline-none focus:ring-0 peer transition-colors duration-300
                                {{ $errors->has('email') 
                                    ? 'border-red-500 text-red-900 focus:border-red-500' 
                                    : 'border-neutral-300 text-neutral-900 focus:border-black' }}" placeholder=" " />

                            <label for="email"
                                class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest
                                {{ $errors->has('email') ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                                Email Address
                            </label>

                            @error('email')
                            <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- Topic (Select) --}}
                        <div class="group relative z-0 w-full">
                            <select name="topic" id="topic" class="block py-4 px-0 w-full text-xl bg-transparent border-0 border-b appearance-none focus:outline-none focus:ring-0 peer transition-colors duration-300
                                {{ $errors->has('topic') 
                                    ? 'border-red-500 text-red-900 focus:border-red-500' 
                                    : 'border-neutral-300 text-neutral-900 focus:border-black' }}">
                                <option value="" disabled selected class="text-neutral-400">Select a topic</option>
                                <option value="order" {{ old('topic')=='order' ? 'selected' : '' }}>Order Inquiry
                                </option>
                                <option value="product" {{ old('topic')=='product' ? 'selected' : '' }}>Product & Sizing
                                </option>
                                <option value="collab" {{ old('topic')=='collab' ? 'selected' : '' }}>Collaboration
                                </option>
                                <option value="other" {{ old('topic')=='other' ? 'selected' : '' }}>Other</option>
                            </select>

                            <label for="topic"
                                class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest
                                {{ $errors->has('topic') ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                                Subject
                            </label>

                            @error('topic')
                            <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- Message --}}
                        <div class="group relative z-0 w-full">
                            <textarea name="message" id="message" rows="4" required class="block py-4 px-0 w-full text-xl bg-transparent border-0 border-b appearance-none focus:outline-none focus:ring-0 peer resize-none transition-colors duration-300
                                {{ $errors->has('message') 
                                    ? 'border-red-500 text-red-900 focus:border-red-500' 
                                    : 'border-neutral-300 text-neutral-900 focus:border-black' }}"
                                placeholder=" ">{{ old('message') }}</textarea>

                            <label for="message"
                                class="peer-focus:font-medium absolute text-sm duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest
                                {{ $errors->has('message') ? 'text-red-500' : 'text-neutral-500 peer-focus:text-black' }}">
                                How can we help?
                            </label>

                            @error('message')
                            <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider animate-pulse">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-8">
                            <button type="submit"
                                class="inline-block px-12 py-4 bg-black text-white font-bold uppercase tracking-widest text-xs hover:bg-neutral-800 transition transform hover:-translate-y-1">
                                Send Message
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </section>

    </main>

    {{-- Script Reveal Effect --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', 'translate-y-4');
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('[data-reveal]').forEach(el => {
                el.classList.add('opacity-0', 'translate-y-4', 'transition-all', 'duration-1000', 'ease-out');
                observer.observe(el);
            });
        });
    </script>
    @endpush
</x-app-layout>