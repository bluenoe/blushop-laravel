<x-app-layout>
    {{-- Hero / story --}}
    <section class="bg-warm min-h-[60vh] border-b border-beige/40">
        <div class="max-w-5xl mx-auto px-4 lg:px-6 py-16 lg:py-24" data-reveal="fade-up">
            <div class="grid gap-10 lg:grid-cols-[1.3fr,1fr] items-center">
                {{-- Text side --}}
                <div>
                    <p class="text-xs tracking-[0.2em] uppercase text-muted mb-3">
                        ABOUT BLUSHOP
                    </p>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-semibold text-ink mb-4">
                        Everyday pieces, <span class="text-accent">quietly confident</span>.
                    </h1>
                    <p class="text-sm md:text-base text-muted leading-relaxed mb-4">
                        BluShop is a modern fashion label born in Saigon, built for
                        calm mornings, late-night work sessions, and everything in between.
                        We design wardrobe staples that feel effortless, with muted tones,
                        soft textures, and silhouettes that never scream for attention –
                        they just feel right.
                    </p>
                    <p class="text-sm md:text-base text-muted leading-relaxed">
                        Every detail – from the weight of a hoodie to the finish on a button –
                        is considered. We keep the palette warm and grounded so you can mix,
                        match, and rewear your favorite pieces without thinking too much.
                    </p>

                    {{-- Stats --}}
                    <div class="mt-8 pt-6 border-t border-beige/40">
                        <div class="grid grid-cols-3 gap-4 md:gap-6 text-sm">
                            <div>
                                <p class="text-2xl md:text-3xl font-semibold text-ink mb-1">
                                    2025
                                </p>
                                <p class="text-[11px] uppercase tracking-[0.16em] text-muted">
                                    YEAR BLUSHOP LAUNCHED
                                </p>
                            </div>
                            <div>
                                <p class="text-2xl md:text-3xl font-semibold text-ink mb-1">
                                    +50
                                </p>
                                <p class="text-[11px] uppercase tracking-[0.16em] text-muted">
                                    CORE WARDROBE PIECES
                                </p>
                            </div>
                            <div>
                                <p class="text-2xl md:text-3xl font-semibold text-ink mb-1">
                                    24/7
                                </p>
                                <p class="text-[11px] uppercase tracking-[0.16em] text-muted">
                                    ONLINE SUPPORT
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Image + BLU NOTE --}}
                <div class="relative" data-reveal="fade-up">
                    <div class="aspect-[4/5] rounded-3xl bg-card shadow-soft overflow-hidden">
                        {{-- Đổi ảnh này thành asset thật của BluShop --}}
                        <img src="{{ asset('images/about/lookbook-blu.jpg') }}" alt="BluShop lookbook"
                            class="w-full h-full object-cover">
                    </div>

                    {{-- BLU NOTE badge: overlay nhẹ trên ảnh, không che quá nhiều --}}
                    <div class="absolute bottom-4 left-4">
                        <div
                            class="max-w-[240px] rounded-2xl border border-beige/60 bg-card/95 px-4 py-3 shadow-soft backdrop-blur-sm">
                            <p class="text-[11px] uppercase tracking-[0.2em] text-muted mb-1">
                                BLU NOTE
                            </p>
                            <p class="text-xs text-ink/90 leading-relaxed">
                                Designed in Viet Nam, inspired by quiet confidence.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Values / Why BluShop --}}
    <section class="bg-warm/60">
        <div class="max-w-5xl mx-auto px-4 lg:px-6 py-16 lg:py-20" data-reveal="fade-up">
            <div class="grid gap-10 md:grid-cols-3">
                <div class="md:col-span-1">
                    <p class="text-xs tracking-[0.2em] uppercase text-muted mb-3">
                        WHAT WE CARE ABOUT
                    </p>
                    <h2 class="text-2xl md:text-3xl font-semibold text-ink mb-4">
                        Built to be worn, not just posted.
                    </h2>
                    <p class="text-sm text-muted leading-relaxed">
                        We design with repeat wear in mind – pieces you’ll actually reach
                        for every day, not just for one photo.
                    </p>
                </div>

                <div class="md:col-span-2 grid gap-6 md:grid-cols-3">
                    <div class="bg-card rounded-2xl border border-beige/60 p-4 md:p-5 shadow-soft/40">
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted mb-2">
                            FABRIC FIRST
                        </p>
                        <p class="text-sm text-ink mb-2">
                            Soft-touch cotton blends and breathable weaves chosen for comfort
                            and long-term wear.
                        </p>
                        <p class="text-xs text-muted">
                            Tested across real, everyday routines – commute, café,
                            office, and late-night coding sessions.
                        </p>
                    </div>

                    <div class="bg-card rounded-2xl border border-beige/60 p-4 md:p-5 shadow-soft/40">
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted mb-2">
                            WARM NEUTRALS
                        </p>
                        <p class="text-sm text-ink mb-2">
                            A warm Blu signature palette that makes mixing & matching effortless.
                        </p>
                        <p class="text-xs text-muted">
                            Beige, ink, soft browns – colors that quietly match your day
                            instead of shouting over it.
                        </p>
                    </div>

                    <div class="bg-card rounded-2xl border border-beige/60 p-4 md:p-5 shadow-soft/40">
                        <p class="text-[11px] uppercase tracking-[0.2em] text-muted mb-2">
                            SMALL BATCH
                        </p>
                        <p class="text-sm text-ink mb-2">
                            Focused drops instead of endless noise. We’d rather get one hoodie
                            perfect than ship ten that feel “just ok”.
                        </p>
                        <p class="text-xs text-muted">
                            Limited runs help us listen, learn, and refine what you actually love.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>