<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BluShop') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-warm flex flex-col items-center justify-center px-6">
            <div>
                <a href="/" aria-label="BluShop Home" class="block">
                    <x-blu-logo class="text-4xl sm:text-5xl mx-auto mb-4" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white border border-beige/60 shadow-soft rounded-xl">
                {{ $slot }}
            </div>
        </div>

        {{-- No footer on authentication pages (login/register) --}}
    </body>
</html>
