<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Signup </title>
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS Files (Dashboard Style) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('/dashboard_assets/css/style.css') }}">
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="" style="max-width: 500px; width: 100%;">
            <div class="text-center">
                <div class="mb-4">
                    <a href="index.html" class="d-inline-block mb-4">
                        <img src="{{ asset('/dashboard_assets/images/logo-icon.svg') }}" alt="" width="36">
                        <span class="ms-2"><img src="{{ asset('/dashboard_assets/images/logo.svg') }}" alt=""></span>
                    </a>
                </div>

                @php
                    $status = $status ?? (isset($exception) ? $exception->getStatusCode() : (view()->hasSection('code') ? view()->getSection('code') : 500));
                    $title = view()->hasSection('title') ? view()->getSection('title') : match($status) {
                        403 => 'Access Denied',
                        404 => 'Page Not Found',
                        500 => 'Server Error',
                        503 => 'Service Unavailable',
                        default => 'Something Went Wrong'
                    };
                    $message = view()->hasSection('message') ? view()->getSection('message') : match($status) {
                        403 => "Sorry, you don't have permission to access this page.",
                        404 => "Oops! The page you are looking for doesn't exist or has been moved.",
                        500 => "Something went wrong on our end. We are working on it.",
                        503 => "We'll be back soon! The server is temporarily down for maintenance.",
                        default => "An unexpected error occurred. Please try again later."
                    };
                @endphp

                <h1 class="display-1 fw-bold text-primary mb-2">{{ $status }}</h1>
                <h2 class="card-title h4 mb-3">{{ $title }}</h2>
                <p class="text-muted mb-4">{{ $message }}</p>

                <a href="{{ url()->previous() == url()->current() ? route('home') : url()->previous() }}" class="btn btn-outline-secondary me-2">Go Back</a>
                <a href="{{ route('home') }}" class="btn btn-primary">Go to Home</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('/dashboard_assets/js/main.js') }}" type="module"></script>


</body>

</html>