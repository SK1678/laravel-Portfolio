<?php echo $__env->make('frontend.include.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="bg-light" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="max-width: 450px; width: 100%;">
            <div class="card-body p-5">
                <!-- Logo Section -->
                <div class="text-center mb-4">
                    <a href="<?php echo e(route('home')); ?>" class="mb-3 d-inline-block">
                        <img src="<?php echo e(asset('dashboard_assets/assets/images/logo-icon.svg')); ?>" alt="Logo" width="45">
                        <span class="ms-1 h4 fw-bold text-dark align-middle">InApp</span>
                    </a>
                    <h2 class="h4 fw-bold text-dark mb-1">Create your account</h2>
                    <p class="text-muted small">Join our community and start managing today.</p>
                </div>

                <!-- Validation Errors -->
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger border-0 rounded-3 small py-2">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('register')); ?>" class="needs-validation" novalidate>
                    <?php echo csrf_field(); ?>
                    
                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label small fw-semibold text-secondary">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="ti ti-user"></i></span>
                            <input id="name" name="name" type="text" class="form-control border-start-0 ps-0 shadow-none" 
                                placeholder="Jane Doe" value="<?php echo e(old('name')); ?>" required autofocus>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold text-secondary">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="ti ti-mail"></i></span>
                            <input id="email" name="email" type="email" class="form-control border-start-0 ps-0 shadow-none" 
                                placeholder="name@example.com" value="<?php echo e(old('email')); ?>" required>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="password" class="form-label small fw-semibold text-secondary">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="ti ti-lock"></i></span>
                            <input id="password" name="password" type="password" class="form-control border-start-0 ps-0 shadow-none" 
                                placeholder="Min. 8 characters" required>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label small fw-semibold text-secondary">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="ti ti-shield-check"></i></span>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control border-start-0 ps-0 shadow-none" 
                                placeholder="Repeat password" required>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 py-2 fw-bold shadow-sm rounded-3" type="submit" 
                        style="background: linear-gradient(to right, #6366f1, #4f46e5); border: none;">
                        Sign Up
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="small text-muted mb-0">Already have an account? 
                        <a href="<?php echo e(route('login')); ?>" class="text-primary fw-bold text-decoration-none">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus {
            border-color: #6366f1;
            background-color: #fcfcff;
        }
        .input-group-text {
            border-color: #dee2e6;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.35) !important;
            transition: all 0.2s ease;
        }
    </style>
</body>

</html><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/frontend/signup.blade.php ENDPATH**/ ?>