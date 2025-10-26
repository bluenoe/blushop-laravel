@extends('layout')

@section('content')
<div class="py-5">
    <h1>Welcome back, {{ auth()->user()->name }} 👋</h1>
    <p class="lead">This is your BluShop dashboard.</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Go to Home</a>
</div>
@endsection
