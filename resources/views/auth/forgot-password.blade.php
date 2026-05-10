<x-guest-layout>
    <x-slot name="title">
        Forgot Password
    </x-slot>

    <div class="mb-4 text-muted small">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-success small fw-medium" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label small fw-medium text-secondary">{{ __('Email Address') }}</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="link-primary small fw-medium">Back to Login</a>
    </div>
</x-guest-layout>
