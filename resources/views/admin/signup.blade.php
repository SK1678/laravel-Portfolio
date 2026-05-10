<x-guest-layout>
    <x-slot name="title">
        Create your account
    </x-slot>

    <style>
        .auth-card {
            max-width: 600px !important;
        }
        .custom-input {
            border: 1px solid #8e959e;
            border-radius: 4px;
            box-shadow: none;
            padding: 8px 12px;
            font-size: 0.95rem;
            color: #495057;
            height: auto;
        }
        .custom-input::placeholder {
            color: #6c757d;
        }
        .custom-input:focus {
            border-color: #e76f51;
            box-shadow: 0 0 0 0.2rem rgba(231, 111, 81, 0.25);
        }
        .btn-orange {
            background-color: #e76f51;
            border-color: #e76f51;
            color: white;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 4px;
        }
        .btn-orange:hover {
            background-color: #d76245;
            border-color: #d76245;
            color: white;
        }
        .btn-gray {
            background-color: #ced4da;
            border-color: #adb5bd;
            color: #212529;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 4px;
        }
        .btn-gray:hover {
            background-color: #adb5bd;
            border-color: #868e96;
            color: #212529;
        }
        .text-orange {
            color: #e76f51 !important;
        }
        .eye-icon-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #8e959e;
            padding: 0;
            cursor: pointer;
        }
        .image-upload-box {
            border: 1px solid #8e959e;
            border-radius: 4px;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            overflow: hidden;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

    </style>

    <form method="POST" action="{{ route('register') }}" class="needs-validation" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row gx-3 mb-3 align-items-stretch">
            <!-- Left Column: User Details -->
            <div class="col-7 d-flex flex-column justify-content-between gap-2">
                <div class="position-relative">
                    <input id="name" name="name" type="text" class="form-control custom-input w-100" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-danger small" />
                </div>

                <div class="position-relative">
                    <input id="email" name="email" type="email" class="form-control custom-input w-100" placeholder="Email" value="{{ old('email') }}" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-danger small" />
                </div>

                <div class="position-relative">
                    <input id="password" name="password" type="password" class="form-control custom-input w-100 pe-5" placeholder="Password" required>
                    <button type="button" class="eye-icon-btn" onclick="togglePassword('password', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-danger small" />
                </div>

                <div class="position-relative">
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control custom-input w-100 pe-5" placeholder="Confirm Password" required>
                    <button type="button" class="eye-icon-btn" onclick="togglePassword('password_confirmation', this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <!-- Right Column: Profile Image Uploader -->
            <div class="col-5">
                <div class="w-100 h-100 position-relative">
                    <div class="image-upload-box" onclick="document.getElementById('profile_image').click()">
                        <i id="default_icon" class="ti ti-user" style="font-size: 5rem; color: #aebac9;"></i>
                        <img id="image_preview" src="" class="w-100 h-100 object-fit-cover d-none" alt="Preview">
                    </div>
                </div>
                <input type="file" name="profile_image" id="profile_image" class="d-none" accept="image/*" onchange="previewImage(this)">
                <x-input-error :messages="$errors->get('profile_image')" class="mt-1 text-danger small" />
            </div>
        </div>

        <div class="row gx-3 mb-3 mt-4">
            <div class="col-6">
                <button class="btn btn-orange w-100 h-100" type="submit">Sign Up</button>
            </div>
            <div class="col-6">
                <a href="{{ route('auth.google') }}" class="btn btn-gray w-100 text-decoration-none text-center d-flex align-items-center justify-content-center h-100 gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="18" height="18" viewBox="0 0 48 48">
                        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path><path fill="#1976D2" d="M43.611,20.083L43.611,20.083L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                    </svg>
                    Sign Up with Google
                </a>
            </div>
        </div>

        <div class="text-center pt-2">
            <p class="text-dark mb-0">Already have an account? <a href="{{ route('login') }}" class="text-orange text-decoration-none">Login</a></p>
        </div>
    </form>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('svg');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>';
            }
        }

        function previewImage(input) {
            const preview = document.getElementById('image_preview');
            const defaultIcon = document.getElementById('default_icon');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    if (defaultIcon) defaultIcon.classList.add('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-guest-layout>