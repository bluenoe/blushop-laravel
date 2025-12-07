{{--
═══════════════════════════════════════════════════════════════
BluShop Contact v3 - Minimalist Underline Form
Concept: Clean, Editorial, High-End Feel
═══════════════════════════════════════════════════════════════
--}}

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
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.494532679872!2d106.6994763153561!3d10.773385262194605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f40a3b49e59%3A0xa1bd14565e1148af!2zQ2jhu6MgQuG6v24gVGjDoG5o!5e0!3m2!1svi!2s!4v1654321234567!5m2!1svi!2s"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                {{-- RIGHT COLUMN: FORM --}}
                <div class="lg:col-span-7" data-reveal style="transition-delay: 200ms">

                    @if (session('success'))
                    <div class="mb-12 p-6 bg-neutral-50 border border-neutral-200 flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-sm text-neutral-600">{{ session('success') }}</p>
                    </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-12">
                        @csrf

                        {{-- Name --}}
                        <div class="group relative z-0 w-full mb-6">
                            <input type="text" name="name" id="name" required
                                class="block py-4 px-0 w-full text-xl text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                                placeholder=" " />
                            <label for="name"
                                class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                                Your Name
                            </label>
                        </div>

                        {{-- Email --}}
                        <div class="group relative z-0 w-full mb-6">
                            <input type="email" name="email" id="email" required
                                class="block py-4 px-0 w-full text-xl text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer"
                                placeholder=" " />
                            <label for="email"
                                class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                                Email Address
                            </label>
                        </div>

                        {{-- Topic --}}
                        <div class="group relative z-0 w-full mb-6">
                            <select name="topic" id="topic"
                                class="block py-4 px-0 w-full text-xl text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer">
                                <option value="" disabled selected class="text-neutral-400">Select a topic</option>
                                <option value="order">Order Inquiry</option>
                                <option value="product">Product & Sizing</option>
                                <option value="collab">Collaboration</option>
                                <option value="other">Other</option>
                            </select>
                            <label for="topic"
                                class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                                Subject
                            </label>
                        </div>

                        {{-- Message --}}
                        <div class="group relative z-0 w-full mb-6">
                            <textarea name="message" id="message" rows="4" required
                                class="block py-4 px-0 w-full text-xl text-neutral-900 bg-transparent border-0 border-b border-neutral-300 appearance-none focus:outline-none focus:ring-0 focus:border-black peer resize-none"
                                placeholder=" "></textarea>
                            <label for="message"
                                class="peer-focus:font-medium absolute text-sm text-neutral-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-black peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 uppercase tracking-widest">
                                How can we help?
                            </label>
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