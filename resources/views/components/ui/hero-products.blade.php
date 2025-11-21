@props([
    'title' => 'Products',
    'subtitle' => 'Everyday essentials crafted for calm.',
    'bg' => asset('images/hero-bg.jpg'),
])

<section x-data="{ loaded: false }" x-init="(() => { const img = new Image(); img.src='{{ $bg }}'; img.onload = () => loaded = true; })()"
    class="relative isolate overflow-hidden bg-warm">
    <div class="absolute inset-0 bg-cover bg-center will-change-transform" data-parallax-bg
        :class="loaded ? 'opacity-100' : 'opacity-0'" style="background-image: url('{{ $bg }}');"></div>
    <div class="absolute inset-0 bg-warm/70 mix-blend-multiply"></div>

    <div class="relative mx-auto max-w-7xl px-6">
        <div class="min-h-[240px] sm:min-h-[260px] lg:min-h-[320px] flex items-center">
            <div class="w-full" data-parallax-content>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-ink">{{ $title }}</h1>
                <p class="mt-2 text-gray-700 text-sm sm:text-base">{{ $subtitle }}</p>
            </div>
        </div>
    </div>
</section>
