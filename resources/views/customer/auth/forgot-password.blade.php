@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="auth-page">
    <div class="auth-card">

        <div class="brand">
            <a href="{{ url('/') }}" class="logo">LUXE<span>.</span></a>
            <div class="tagline">Premium Essentials</div>
        </div>

        <p class="subtitle">Enter your email and choose a new password</p>

        {{--
            NOTE FOR STUDENTS: a "real" forgot-password flow emails the
            customer a reset link/token. That needs SMTP configured in
            .env, which most XAMPP setups don't have out of the box.
            To keep this beginner-friendly and testable immediately,
            this page just checks the email exists and lets you set a
            new password directly in one step.
        --}}

        @if(session('error'))
            <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="success-msg"><i class="bi bi-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ url('/customer/forgot-password') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       id="email" placeholder="Enter your registered email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
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
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <div class="password-toggle">
                    <input type="password" name="password_confirmation" class="form-control"
                           id="password_confirmation" placeholder="Confirm your new password" required>
                    <button type="button" class="toggle-eye"><i class="bi bi-eye"></i></button>
                </div>
            </div>

            <button type="submit" class="btn-auth">Reset Password</button>
        </form>

        <p class="text-center small text-muted mt-3 mb-0">
            Remembered your password? <a href="{{ url('/customer/login') }}" class="auth-link">Sign in</a>
        </p>
    </div>
</div>
@endsection
