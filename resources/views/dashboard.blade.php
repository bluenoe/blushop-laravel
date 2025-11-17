@extends('layout')

@section('content')
<div class="py-5">
    <x-ui.card class="p-5">
        <h1 class="text-2xl font-bold">Welcome back, {{ auth()->user()->name }} 👋</h1>
        <p class="mt-2 text-gray-700">This is your BluShop dashboard.</p>
        <x-ui.button href="{{ route('home') }}" class="mt-4">Go to Home</x-ui.button>
    </x-ui.card>
</div>
@endsection
