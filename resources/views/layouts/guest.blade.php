<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BluShop') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('images/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}" />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- [FIX AUTOFILL] XỬ LÝ LỖI LABEL BỊ CHE TRÊN TRANG LOGIN/REGISTER --}}
    <style>
        /* 1. Tắt nền màu xanh/vàng của trình duyệt */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-background-clip: text;
            -webkit-text-fill-color: #171717;
            /* Màu chữ đen */
            transition: background-color 5000s ease-in-out 0s;
            box-shadow: inset 0 0 20px 20px #ffffff00;
            /* Trong suốt */
        }

        /* 2. Bắt buộc Label phải BAY LÊN khi có Autofill */
        input:-webkit-autofill+label {
            transform: translateY(-1.5rem) scale(0.75) !important;
            top: 0.75rem !important;
            /* top-3 */
            left: 0 !important;
            color: #171717 !important;
            /* text-black */
            font-weight: 500 !important;
            /* font-medium */
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-warm flex flex-col items-center justify-center px-6">
        <div>
            <a href="/" aria-label="BluShop Home" class="block">
                <x-blu-logo class="text-4xl sm:text-5xl mx-auto mb-4" />
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-10 py-10 sm:px-12 sm:py-12 bg-white border border-white/60 shadow-[0_20px_40px_rgba(0,0,0,0.04)] rounded-3xl">
            {{ $slot }}
        </div>
    </div>

    {{-- No footer on authentication pages (login/register) --}}
</body>

</html>