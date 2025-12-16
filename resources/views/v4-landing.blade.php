<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BluShop — Editorial Collection</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        neutral: {
                            50: '#F9FAFB',
                            100: '#F3F4F6',
                            400: '#9CA3AF',
                            500: '#6B7280',
                            900: '#111827', // Ink Black
                        }
                    },
                    height: {
                        'screen-dvh': '100dvh', // Dynamic Viewport Height for mobile
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Scrollbar Hide */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* LUXURY ANIMATION LOGIC */
        .reveal-element {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 1.2s ease-out, transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-element.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Delay utilities for staggered effect */
        .delay-200 {
            transition-delay: 200ms;
        }

        .delay-400 {
            transition-delay: 400ms;
        }

        .delay-600 {
            transition-delay: 600ms;
        }

        /* Image Hover Zoom - Subtle */
        .img-zoom-container {
            overflow: hidden;
        }

        .img-zoom {
            transition: transform 1.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .img-zoom-container:hover .img-zoom {
            transform: scale(1.03);
        }
    </style>
</head>

<body class="antialiased bg-white text-neutral-900 overflow-x-hidden selection:bg-neutral-900 selection:text-white">

    <nav
        class="fixed top-0 left-0 w-full z-50 px-6 py-6 md:px-12 md:py-8 flex justify-between items-center mix-blend-difference text-white reveal-element">
        <div class="text-2xl font-serif tracking-tighter font-bold">Blu.</div>
        <div class="hidden md:flex space-x-12 text-sm tracking-widest uppercase opacity-80">
            <a href="#" class="hover:opacity-100 transition-opacity">Editorial</a>
            <a href="#" class="hover:opacity-100 transition-opacity">Campaign</a>
            <a href="#" class="hover:opacity-100 transition-opacity">Atelier</a>
        </div>
        <button class="text-sm tracking-widest uppercase hover:underline underline-offset-4">Menu</button>
    </nav>

    <header class="relative w-full h-screen-dvh bg-neutral-900 overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=2073&auto=format&fit=crop"
                alt="BluShop Hero" class="w-full h-full object-cover opacity-80 animate-slow-zoom">
        </div>

        <div class="absolute bottom-0 left-0 w-full p-6 md:p-12 pb-16 md:pb-24 text-white z-10">
            <div class="max-w-4xl">
                <p class="reveal-element text-xs md:text-sm tracking-[0.3em] uppercase mb-4 text-neutral-300">Spring /
                    Summer 2025</p>
                <h1 class="reveal-element delay-200 font-serif text-5xl md:text-8xl leading-none mb-6">
                    The New <br> <span class="italic font-light opacity-90">Silence</span>
                </h1>
                <div class="reveal-element delay-400 h-px w-24 bg-white/50 mb-6"></div>
                <a href="#editorial"
                    class="reveal-element delay-600 inline-block text-sm tracking-widest uppercase border-b border-white/40 pb-1 hover:border-white transition-colors">
                    Explore Chapter 01
                </a>
            </div>
        </div>
    </header>

    <section id="editorial" class="relative py-24 md:py-40 px-6 md:px-12 bg-white">
        <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-12 items-end">
            <div class="md:col-span-4 reveal-element">
                <span class="block text-9xl font-serif text-neutral-100 leading-none -ml-2 select-none">01</span>
            </div>
            <div class="md:col-span-6 md:col-start-6 reveal-element delay-200">
                <h2 class="font-serif text-3xl md:text-4xl mb-8 leading-snug">
                    Minimalism is not about absence.<br>
                    It is about the <span class="italic text-neutral-500">perfect amount</span> of something.
                </h2>
                <p class="text-neutral-500 text-sm md:text-base leading-relaxed max-w-md">
                    We strip away the unnecessary to reveal the essential. BluShop focuses on silhouette, fabric, and
                    the feeling of wearing something made with intent. No noise, just style.
                </p>
            </div>
        </div>
    </section>

    <section class="py-12 md:py-24 px-4 md:px-8 bg-neutral-50">
        <div class="max-w-screen-2xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-24 mb-24 items-center">
                <div class="img-zoom-container reveal-element aspect-[3/4] md:aspect-[4/5] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1532453288672-3a27e9be9efd?q=80&w=1964&auto=format&fit=crop"
                        alt="Texture Detail"
                        class="img-zoom w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
                </div>
                <div class="reveal-element delay-200 pr-0 md:pr-12 mt-8 md:mt-0">
                    <p class="text-xs tracking-widest uppercase text-neutral-400 mb-4">The Fabric</p>
                    <h3 class="font-serif text-4xl mb-6">Tactile Luxury</h3>
                    <p class="text-neutral-500 mb-8 font-light leading-relaxed">
                        Sourced from the finest mills, our organic cotton and raw linens breathe with you. Designed to
                        age gracefully, creating a patina that is uniquely yours.
                    </p>
                    <a href="#"
                        class="text-xs uppercase tracking-widest border-b border-neutral-300 pb-1 hover:border-neutral-900 transition-colors">Read
                        Journal</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                <div class="md:col-span-4 md:col-start-2 reveal-element mt-12 md:mt-32 order-2 md:order-1">
                    <div class="sticky top-32">
                        <p class="text-xs tracking-widest uppercase text-neutral-400 mb-4">The Form</p>
                        <h3 class="font-serif text-4xl mb-6">Effortless Motion</h3>
                        <p class="text-neutral-500 font-light leading-relaxed">
                            Structured yet fluid. Our cuts are engineered for movement, ensuring you look composed in
                            the chaos of the city.
                        </p>
                    </div>
                </div>
                <div class="md:col-span-6 md:col-start-7 reveal-element delay-200 order-1 md:order-2">
                    <div class="img-zoom-container aspect-[3/4] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=1888&auto=format&fit=crop"
                            alt="Model Posing" class="img-zoom w-full h-full object-cover">
                    </div>
                    <p class="text-right text-xs text-neutral-400 mt-2 italic">Look 04 — The oversized trench</p>
                </div>
            </div>
        </div>
    </section>

    <section class="relative w-full h-[80vh] overflow-hidden reveal-element">
        <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=2070&auto=format&fit=crop"
            alt="Campaign Highlight" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute bottom-12 right-6 md:bottom-24 md:right-24 text-white text-right">
            <h2 class="font-serif text-5xl md:text-7xl mb-4 italic">Evening Hues</h2>
            <a href="#"
                class="inline-block text-sm tracking-widest uppercase bg-white text-black px-8 py-4 hover:bg-neutral-200 transition-colors">
                View Lookbook
            </a>
        </div>
    </section>

    <section class="py-24 px-6 bg-white">
        <div class="text-center mb-16 reveal-element">
            <h2 class="font-serif text-3xl md:text-4xl text-neutral-900">Essentials</h2>
            <div class="h-8 w-px bg-neutral-300 mx-auto mt-6"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-1 md:gap-8 max-w-screen-xl mx-auto">
            <div class="group cursor-pointer reveal-element">
                <div class="aspect-[4/5] bg-neutral-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1551488852-d81a2d5356a7?q=80&w=2070&auto=format&fit=crop"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        alt="Item">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-500">
                    </div>
                </div>
                <div class="mt-4 flex justify-between items-baseline">
                    <h4 class="font-serif text-lg italic text-neutral-800">The Silk Shirt</h4>
                    <span
                        class="text-xs uppercase tracking-widest text-neutral-400 group-hover:text-black transition-colors">Explore</span>
                </div>
            </div>

            <div class="group cursor-pointer reveal-element delay-200 md:mt-12">
                <div class="aspect-[4/5] bg-neutral-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1605763240004-7d93b47053e3?q=80&w=1887&auto=format&fit=crop"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        alt="Item">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-500">
                    </div>
                </div>
                <div class="mt-4 flex justify-between items-baseline">
                    <h4 class="font-serif text-lg italic text-neutral-800">Classic Trouser</h4>
                    <span
                        class="text-xs uppercase tracking-widest text-neutral-400 group-hover:text-black transition-colors">Explore</span>
                </div>
            </div>

            <div class="group cursor-pointer reveal-element delay-400">
                <div class="aspect-[4/5] bg-neutral-100 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=2069&auto=format&fit=crop"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        alt="Item">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-500">
                    </div>
                </div>
                <div class="mt-4 flex justify-between items-baseline">
                    <h4 class="font-serif text-lg italic text-neutral-800">Noir Blazer</h4>
                    <span
                        class="text-xs uppercase tracking-widest text-neutral-400 group-hover:text-black transition-colors">Explore</span>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-neutral-900 text-white py-16 px-6 reveal-element">
        <div
            class="max-w-screen-xl mx-auto flex flex-col md:flex-row justify-between items-center md:items-start space-y-8 md:space-y-0">
            <div class="text-center md:text-left">
                <h2 class="text-2xl font-serif font-bold mb-2">Blu.</h2>
                <p class="text-neutral-500 text-xs tracking-wider uppercase">&copy; 2025 BluShop. All rights reserved.
                </p>
            </div>
            <div class="flex space-x-8 text-xs tracking-widest uppercase text-neutral-400">
                <a href="#" class="hover:text-white transition-colors">Instagram</a>
                <a href="#" class="hover:text-white transition-colors">Pinterest</a>
                <a href="#" class="hover:text-white transition-colors">Contact</a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Setup Intersection Observer for scroll animations
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15 // Trigger when 15% of element is visible
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target); // Only animate once
                    }
                });
            }, observerOptions);

            const elementsToReveal = document.querySelectorAll('.reveal-element');
            elementsToReveal.forEach(el => observer.observe(el));
        });
    </script>
</body>

</html>