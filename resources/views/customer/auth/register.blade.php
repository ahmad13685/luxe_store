@extends('layouts.auth')

@section('title', 'Create Account')

@section('content')
<div class="auth-page">
    <div class="auth-card">

        <div class="brand">
            <a href="{{ url('/') }}" class="logo">LUXE<span>.</span></a>
            <div class="tagline">Premium Essentials</div>
        </div>

        <p class="subtitle">Create your account — join the luxury experience</p>

        @if(session('error'))
            <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ url('/customer/register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       id="name" placeholder="Enter your full name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="password-toggle">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" placeholder="Min 6 characters" required>
                    <button type="button" class="toggle-eye"><i class="bi bi-eye"></i></button>
                </div>
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="password-toggle">
                    <input type="password" name="password_confirmation" class="form-control"
                           id="password_confirmation" placeholder="Confirm your password" required>
                    <button type="button" class="toggle-eye"><i class="bi bi-eye"></i></button>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required>
                <label class="form-check-label" for="terms">
                    I agree to the <a href="#" class="auth-link">Terms &amp; Conditions</a>
                </label>
                @error('terms')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-auth">Create Account</button>
        </form>

        <p class="text-center small text-muted mt-3 mb-0">
            Already have an account? <a href="{{ url('/customer/login') }}" class="auth-link">Sign in</a>
        </p>
    </div>
</div>
@endsection
