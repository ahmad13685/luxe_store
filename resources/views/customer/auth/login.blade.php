@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-page">
    <div class="auth-card">

        <div class="brand">
            <a href="{{ url('/') }}" class="logo">LUXE<span>.</span></a>
            <div class="tagline">Premium Essentials</div>
        </div>

        <p class="subtitle">Welcome back — sign in to your account</p>

        {{-- Session flash messages (set by AuthController) --}}
        @if(session('error'))
            <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="success-msg"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ url('/customer/login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="password-toggle">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" placeholder="Enter your password" required>
                    <button type="button" class="toggle-eye"><i class="bi bi-eye"></i></button>
                </div>
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="{{ url('/customer/forgot-password') }}" class="auth-link small">Forgot Password?</a>
            </div>

            <button type="submit" class="btn-auth">Sign In</button>
        </form>

        <div class="divider">or continue with</div>

        <div class="social-buttons">
            <button type="button" class="btn-social" onclick="alert('Google login coming soon!')">
                <i class="bi bi-google"></i> Google
            </button>
            <button type="button" class="btn-social" onclick="alert('Facebook login coming soon!')">
                <i class="bi bi-facebook"></i> Facebook
            </button>
        </div>

        <p class="text-center small text-muted mt-3 mb-0">
            Don't have an account? <a href="{{ url('/customer/register') }}" class="auth-link">Create one</a>
        </p>
    </div>
</div>
@endsection
