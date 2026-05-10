<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('/dashboard_assets/images/favicon_io/apple-touch-icon.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('/dashboard_assets/images/favicon_io/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('/dashboard_assets/images/favicon_io/favicon-16x16.png')); ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .auth-card {
            max-width: 450px;
            width: 100%;
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }
        .btn-primary {
            background-color: #ea4335;
            border-color: #ea4335;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #d3382c;
            border-color: #d3382c;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(234, 67, 53, 0.3);
        }
        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.25 margin-top: 5px;rem rgba(234, 67, 53, 0.1);
            border-color: #ea4335;
        }
        .logo-icon {
            width: 45px;
            margin-bottom: 1rem;
        }
        .text-primary {
            color: #ea4335 !important;
        }
        .link-primary {
            color: #ea4335;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .link-primary:hover {
            color: #d3382c;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">
        <div class="card auth-card">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <a href="<?php echo e(route('home')); ?>">
                        <img src="<?php echo e(asset('/dashboard_assets/images/logo-icon.svg')); ?>" alt="Logo" class="logo-icon">
                    </a>
                    <h1 class="h4 fw-bold text-dark"><?php echo e($title ?? 'Account'); ?></h1>
                </div>

                <?php echo e($slot); ?>


                <div class="text-center mt-4 pt-2 border-top">
                    <a href="<?php echo e(route('home')); ?>" class="link-primary small fw-medium">Return to Website</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/layouts/guest.blade.php ENDPATH**/ ?>