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

<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden" style="max-width: 600px; width: 100%;">
            <div class="card-body p-5">
                <!-- Logo Section -->
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="mb-3 d-inline-block text-decoration-none">
                        <img src="{{ asset('/dashboard_assets/images/logo-icon.svg') }}" alt="Logo" width="40">
                        <span class="ms-1 align-middle">
                            <img src="{{ asset('/dashboard_assets/images/logo.svg') }}" alt="InApp">
                        </span>
                    </a>
                    <h2 class="h5 fw-bold text-dark mb-1">Create your account</h2>
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

                <form method="POST" action="{{ route('register') }}" class="needs-validation" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <!-- Name Field -->
                            <div class="mb-3">
                                <label for="name" class="form-label small fw-medium text-secondary">Full Name</label>
                                <input id="name" name="name" type="text" class="form-control shadow-none"
                                    placeholder="Jane Doe" value="{{ old('name') }}" required autofocus>
                            </div>

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label small fw-medium text-secondary">Email
                                    Address</label>
                                <input id="email" name="email" type="email" class="form-control shadow-none"
                                    placeholder="name@example.com" value="{{ old('email') }}" required>
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label small fw-medium text-secondary">Password</label>
                                <input id="password" name="password" type="password" class="form-control shadow-none"
                                    placeholder="Create a password" required>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password_confirmation"
                                    class="form-label small fw-medium text-secondary">Confirm
                                    Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="form-control shadow-none" placeholder="Repeat password" required>
                            </div>
                        </div>

                        <div class="col-md-4 d-flex align-items-start justify-content-center ps-4 pt-4">
                            <div class="profile-upload-container">
                                <input type="file" name="profile_image" id="profile_image" class="d-none" accept="image/*" onchange="previewImage(this)">
                                <label for="profile_image" class="profile-preview-wrapper shadow-sm border d-flex align-items-center justify-content-center overflow-hidden rounded-3 bg-white" style="width: 140px; height: 140px; cursor: pointer;">
                                    <img id="image_preview" src="" class="w-100 h-100 object-fit-cover d-none" alt="Preview">
                                    <div id="upload_placeholder" class="text-center text-muted">
                                        <i class="ti ti-photo fs-1"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 py-2 fw-semibold shadow-sm" type="submit">
                        Sign Up
                    </button>
                </form>

                <div class="text-center mt-4">

                    <p class="small text-muted mb-0">
                        <a href="{{ route('home') }}" class="text-primary fw-medium text-decoration-none">Home</a>
                        |
                        <a href="{{ route('login') }}" class="text-primary fw-medium text-decoration-none">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image_preview');
            const placeholder = document.getElementById('upload_placeholder');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>