@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-7">
            <div class="mb-3">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h4 fw-bold mb-3">Contact Us</h2>
                    <p class="text-muted">Send us a message and we’ll get back to you soon.</p>

                    <form method="POST" action="{{ route('contact.send') }}" class="row g-3">
                        @csrf

                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="message" class="form-label">Message</label>
                            <textarea id="message"
                                      name="message"
                                      rows="5"
                                      class="form-control @error('message') is-invalid @enderror"
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Send</button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Back Home</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-muted small mt-2">
                <em>Note:</em> We store your message in our database only. No email is sent.
            </div>
        </div>
    </div>
@endsection
