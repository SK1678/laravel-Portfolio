<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Login </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="180x180"
    href="{{ asset('/dashboard_assets/images/favicon_io/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32"
    href="{{ asset('/dashboard_assets/images/favicon_io/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16"
    href="{{ asset('/dashboard_assets/images/favicon_io/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('/dashboard_assets/images/favicon_io/site.webmanifest') }}">

  <!-- Fonts (Dashboard Style) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- CSS Files (Dashboard Style) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <link rel="stylesheet" href="{{ asset('/dashboard_assets/css/style.css') }}">
</head>

<body>


  <div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card " style="max-width:420px; width:100%;">
      <div class="card-body p-5">
        <div class="text-center mb-3">
          <a href="{{ route('home') }}" class="mb-3 d-inline-block text-decoration-none">
            <img src="{{ asset('/dashboard_assets/images/logo-icon.svg') }}" alt="Logo" width="40">
            <span class="ms-1 align-middle">
              <img src="{{ asset('/dashboard_assets/images/logo.svg') }}" alt="InApp">
            </span>
          </a>
          <h1 class="card-title mb-5 h5">Sign in to your account</h1>

        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
          <div class="alert alert-danger border-0 rounded-3 small py-2 mb-4">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="needs-validation mt-3" novalidate>
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input id="email" name="email" type="email" class="form-control" placeholder="name@example.com"
              value="{{ old('email') }}" required autofocus>
            <div class="invalid-feedback">Please enter a valid email.</div>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label d-flex justify-content-between">
              <span>Password</span>
              <a href="{{ route('password.request') }}" class="small link-primary text-decoration-none">Forgot
                Password?</a>
            </label>
            <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
            <div class="invalid-feedback">Please provide a password.</div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input id="remember" name="remember" class="form-check-input" type="checkbox">
              <label class="form-check-label small" for="remember">Remember me</label>
            </div>
          </div>

          <button class="btn btn-primary w-100" type="submit">Sign in</button>
        </form>

        <div class="text-center mt-3 small text-muted">
          <a href="{{ route('home') }}" class="link-primary text-decoration-none">Home</a> |
          <a href="{{ route('register') }}" class="link-primary text-decoration-none">Sign up</a>
        </div>
      </div>
    </div>
  </div>



  <!-- Bootstrap JS -->
  <script src="{{ asset('/dashboard_assets/js/main.js') }}" type="module"></script>


</body>

</html>""