<x-app-layout>
    {{-- Hero / intro --}}
    <section class="bg-warm border-b border-beige/40">
        <div class="max-w-5xl mx-auto px-4 lg:px-6 py-12 lg:py-16">
            <div class="bg-white rounded-3xl border border-beige/60 shadow-soft p-5 md:p-7 lg:p-8"
                data-reveal="fade-up">
                <div class="max-w-2xl space-y-4">
                    <p class="text-xs tracking-[0.2em] uppercase text-muted">
                        CONTACT
                    </p>
                    <h1 class="text-3xl md:text-4xl font-semibold text-ink">
                        Let’s make your wardrobe a little calmer.
                    </h1>
                    <p class="text-sm md:text-base text-muted leading-relaxed">
                        Questions about sizing, orders, or styling?
                        Leave us a message – the Blu team is here to help with fit advice,
                        order updates, or anything you’re unsure about.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Form + info + map --}}
    <section class="bg-warm/60 -mt-6 lg:-mt-10 relative z-10">
        <div class="max-w-5xl mx-auto px-4 lg:px-6 pb-14 lg:pb-18 pt-10">
            <div class="grid gap-10 lg:grid-cols-[1.1fr,1fr] items-start">
                {{-- Contact form --}}
                <div class="bg-white rounded-3xl border border-beige/60 shadow-soft p-5 md:p-7" data-reveal="fade-up">
                    @if (session('success'))
                    <div class="mb-4 rounded-xl border border-beige/70 bg-warm/80 px-4 py-3 text-sm text-ink">
                        {{ session('success') }}
                    </div>
                    @endif

                    <h2 class="text-xl md:text-2xl font-semibold text-ink mb-3">
                        Send us a message
                    </h2>
                    <p class="text-sm text-muted mb-6">
                        We usually reply within 24 hours on weekdays.
                    </p>

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-medium tracking-[0.16em] uppercase text-muted mb-2">
                                Name
                            </label>
                            <input type="text" name="name" required
                                class="w-full rounded-xl border border-beige/80 bg-warm/60 px-3 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-accent/70"
                                placeholder="Enter your full name">
                        </div>

                        <div>
                            <label class="block text-xs font-medium tracking-[0.16em] uppercase text-muted mb-2">
                                Email
                            </label>
                            <input type="email" name="email" required
                                class="w-full rounded-xl border border-beige/80 bg-warm/60 px-3 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-accent/70"
                                placeholder="you@example.com">
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-xs font-medium tracking-[0.16em] uppercase text-muted mb-2">
                                    Topic
                                </label>
                                <select name="topic"
                                    class="w-full rounded-xl border border-beige/80 bg-warm/60 px-3 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-accent/70">
                                    <option value="order">Order support</option>
                                    <option value="sizing">Sizing & fit</option>
                                    <option value="product">Product question</option>
                                    <option value="collab">Collaboration</option>
                                    <option value="other">Something else</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium tracking-[0.16em] uppercase text-muted mb-2">
                                    Order ID (optional)
                                </label>
                                <input type="text" name="order_id"
                                    class="w-full rounded-xl border border-beige/80 bg-warm/60 px-3 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-accent/70"
                                    placeholder="#BLU1234">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium tracking-[0.16em] uppercase text-muted mb-2">
                                Message
                            </label>
                            <textarea name="message" rows="4" required
                                class="w-full rounded-xl border border-beige/80 bg-warm/60 px-3 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-accent/70 resize-y"
                                placeholder="Tell us how we can help..."></textarea>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between pt-2">
                            <p class="text-[11px] text-muted">
                                By sending this form, you agree to let us contact you about your request.
                            </p>
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-full bg-ink text-warm px-5 py-2.5 text-sm font-medium hover:bg-ink/90 active:scale-[0.98] transition">
                                Send message
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Info + map --}}
                <div class="space-y-6" data-reveal="fade-up">
                    <div class="bg-white rounded-3xl border border-beige/60 shadow-soft p-5">
                        <h3 class="text-base font-semibold text-ink mb-3">
                            Contact details
                        </h3>
                        <ul class="space-y-2 text-sm text-muted">
                            <li>
                                <span class="font-medium text-ink">Email:</span>
                                <a href="mailto:hello@blushop.vn" class="hover:text-ink">
                                    hello@blushop.vn
                                </a>
                            </li>
                            <li>
                                <span class="font-medium text-ink">Phone:</span>
                                <a href="tel:+84901234567" class="hover:text-ink">
                                    +84 90 123 45 67
                                </a>
                            </li>
                            <li>
                                <span class="font-medium text-ink">Hours:</span>
                                Mon – Sun, 9:00 – 21:00 (GMT+7)
                            </li>
                            <li>
                                <span class="font-medium text-ink">Showroom:</span>
                                District 1, Ho Chi Minh City, Viet Nam
                            </li>
                        </ul>
                    </div>

                    <div class="bg-white rounded-3xl border border-beige/60 shadow-soft overflow-hidden">
                        <div class="aspect-[4/3]">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.5373213786506!2d108.21856011182456!3d16.037583284573277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314219e90334f96f%3A0x430e2149e78987c7!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIFBoxrDGoW5nIMSQw7RuZyDEkMOgIE7hurVuZw!5e0!3m2!1sen!2s!4v1764680430323!5m2!1sen!2s"
                                style="border:0;" allowfullscreen loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" class="w-full h-full"></iframe>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Support strip nhỏ phía dưới, cho đỡ trống --}}
            <div class="mt-10 pt-6 border-t border-beige/50" data-reveal="fade-up">
                <div class="grid gap-4 md:grid-cols-3 text-sm">
                    <div class="space-y-1 rounded-2xl border border-beige/40 bg-warm/70 px-4 py-3 md:px-5 md:py-4 transition
                   hover:border-accent/60 hover:bg-warm/90">
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted flex items-center gap-2">
                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-accent"></span>
                            URGENT ORDER ISSUE
                        </p>
                        <p class="text-ink">
                            Call us directly for time-sensitive problems with delivery or payment.
                        </p>
                    </div>

                    <div class="space-y-1 rounded-2xl border border-beige/40 bg-warm/70 px-4 py-3 md:px-5 md:py-4 transition
                   hover:border-accent/60 hover:bg-warm/90">
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted flex items-center gap-2">
                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-accent"></span>
                            SIZE & FIT ADVICE
                        </p>
                        <p class="text-ink">
                            Not sure which size to pick? Add your height and weight in the message.
                        </p>
                    </div>

                    <div class="space-y-1 rounded-2xl border border-beige/40 bg-warm/70 px-4 py-3 md:px-5 md:py-4 transition
                   hover:border-accent/60 hover:bg-warm/90">
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted flex items-center gap-2">
                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-accent"></span>
                            COLLAB & PARTNERSHIP
                        </p>
                        <p class="text-ink">
                            For collaborations or bulk orders, choose “Collaboration” in Topic.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
</x-app-layout>