@extends('layout')

@section('content')
<div class="container py-5">
  <h1>Profile</h1>
  @if (session('status') === 'profile-updated')
    <div class="alert alert-success">Profile updated!</div>
  @endif

  <form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div class="mb-3">
      <label class="form-label">Name</label>
      <input name="name" value="{{ old('name', $user->name) }}" class="form-control">
    </div>

    <button class="btn btn-primary">Save</button>
  </form>

  <hr>
  <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Delete your account?')">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger">Delete Account</button>
  </form>
</div>
@endsection
