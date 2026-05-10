<x-guest-layout>
    <x-slot name="title">
        Sign in to your account
    </x-slot>

    <!-- Validation Errors -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if(session('error'))
        <div class="alert alert-danger small py-2 mb-4 text-center border-0 bg-danger bg-opacity-10 text-danger rounded-3 fw-medium">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label small fw-medium text-secondary">Email Address</label>
            <input id="email" name="email" type="email" class="form-control" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-danger small" />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label d-flex justify-content-between small fw-medium text-secondary">
                <span>Password</span>
                <a href="{{ route('password.request') }}" class="link-primary text-decoration-none">Forgot Password?</a>
            </label>
            <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-danger small" />
        </div>

        <div class="form-check mb-4">
            <input id="remember" name="remember" class="form-check-input" type="checkbox">
            <label class="form-check-label small text-muted" for="remember">Remember me</label>
        </div>

        <div class="d-grid mb-4">
            <button class="btn btn-primary" type="submit">Sign in</button>
        </div>

        <div class="text-center position-relative mb-4">
            <hr class="text-muted opacity-25">
            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">Or continue with</span>
        </div>

        <div class="d-grid">
            <a href="{{ route('auth.google') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2 py-2 border-opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="18" height="18" viewBox="0 0 48 48">
                    <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path><path fill="#1976D2" d="M43.611,20.083L43.611,20.083L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                </svg>
                <span class="fw-medium small">Sign in with Google</span>
            </a>
        </div>

        <div class="text-center mt-4 pt-3">
            <p class="small text-muted mb-0">Don't have an account? <a href="{{ route('register') }}" class="link-primary fw-medium">Sign up</a></p>
        </div>
    </form>
</x-guest-layout>