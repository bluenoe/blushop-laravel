@extends('layout')

@section('content')
<section class="max-w-7xl mx-auto px-6 py-12 sm:py-16">
    <div class="text-center">
        <h1 class="text-3xl sm:text-4xl font-bold text-ink">Welcome to BluShop</h1>
        <p class="mt-2 text-gray-700">A mini Laravel e-commerce for students. Built with ❤️.</p>
        <div class="mt-6 flex items-center justify-center gap-3">
            <x-ui.button href="{{ route('products.index') }}">Shop Now</x-ui.button>
            <x-ui.button href="{{ route('contact.index') }}" variant="secondary">Contact Us</x-ui.button>
        </div>
    </div>
</section>
@endsection