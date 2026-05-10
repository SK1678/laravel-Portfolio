<header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

        <a href="<?php echo e(route('home')); ?>" class="logo d-flex align-items-center me-auto me-xl-0">
            <?php if(isset($siteSettings) && $siteSettings->logo_type == 'image' && $siteSettings->logo_image): ?>
                <img src="<?php echo e(asset('storage/' . $siteSettings->logo_image)); ?>"
                    alt="<?php echo e($siteSettings->site_title ?? 'Logo'); ?>">
            <?php else: ?>
                <h1 class="sitename"><?php echo e($siteSettings->logo_text ?? ($siteSettings->site_title ?? 'Kelly')); ?></h1>
            <?php endif; ?>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Home</a></li>
                <li><a href="<?php echo e(route('about')); ?>" class="<?php echo e(request()->routeIs('about') ? 'active' : ''); ?>">About</a>
                </li>
                <li><a href="<?php echo e(route('resume')); ?>"
                        class="<?php echo e(request()->routeIs('resume') ? 'active' : ''); ?>">Resume</a></li>
                <li><a href="<?php echo e(route('services')); ?>"
                        class="<?php echo e(request()->routeIs('services') ? 'active' : ''); ?>">Services</a></li>
                <li><a href="<?php echo e(route('portfolio')); ?>"
                        class="<?php echo e(request()->routeIs('portfolio') ? 'active' : ''); ?>">Portfolio</a></li>
                <li><a href="<?php echo e(route('blogs')); ?>" class="<?php echo e(request()->routeIs('blogs') ? 'active' : ''); ?>">Blog</a>
                </li>
                <li><a href="<?php echo e(route('contact')); ?>"
                        class="<?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>">Contact</a></li>

                <?php if(Auth::check()): ?>
                    <?php if(Auth::user()->isAdmin()): ?>
                        <li class="dropdown"><a href="#"><i class="bi bi-person-circle"></i> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                                <li>
                                    <a href="<?php echo e(route('logout')); ?>"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?php echo e(route('logout')); ?>"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                    <?php endif; ?>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                        <?php echo csrf_field(); ?>
                    </form>
                <?php else: ?>
                    <li class="dropdown"><a href="#"><span>Account</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                            <li><a href="<?php echo e(route('register')); ?>">Register</a></li>

                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <div class="header-social-links">
            <?php if(isset($siteOwner) && $siteOwner && !empty($siteOwner->additional_info['social_links'])): ?>
                <?php
                    // Map Tabler icon labels → Bootstrap Icon class + link CSS class
                    $iconMap = [
                        'ti-linkedin' => ['icon' => 'bi-linkedin', 'css' => 'linkedin'],
                        'ti-brand-linkedin' => ['icon' => 'bi-linkedin', 'css' => 'linkedin'],
                        'ti-facebook' => ['icon' => 'bi-facebook', 'css' => 'facebook'],
                        'ti-brand-facebook' => ['icon' => 'bi-facebook', 'css' => 'facebook'],
                        'ti-twitter' => ['icon' => 'bi-twitter-x', 'css' => 'twitter'],
                        'ti-brand-twitter' => ['icon' => 'bi-twitter-x', 'css' => 'twitter'],
                        'ti-brand-x' => ['icon' => 'bi-twitter-x', 'css' => 'twitter'],
                        'ti-instagram' => ['icon' => 'bi-instagram', 'css' => 'instagram'],
                        'ti-brand-instagram' => ['icon' => 'bi-instagram', 'css' => 'instagram'],
                        'ti-github' => ['icon' => 'bi-github', 'css' => 'github'],
                        'ti-brand-github' => ['icon' => 'bi-github', 'css' => 'github'],
                        'ti-youtube' => ['icon' => 'bi-youtube', 'css' => 'youtube'],
                        'ti-brand-youtube' => ['icon' => 'bi-youtube', 'css' => 'youtube'],
                        'ti-whatsapp' => ['icon' => 'bi-whatsapp', 'css' => 'whatsapp'],
                        'ti-brand-whatsapp' => ['icon' => 'bi-whatsapp', 'css' => 'whatsapp'],
                        'ti-telegram' => ['icon' => 'bi-telegram', 'css' => 'telegram'],
                        'ti-brand-telegram' => ['icon' => 'bi-telegram', 'css' => 'telegram'],
                        'ti-dribbble' => ['icon' => 'bi-dribbble', 'css' => 'dribbble'],
                        'ti-brand-dribbble' => ['icon' => 'bi-dribbble', 'css' => 'dribbble'],
                        'ti-behance' => ['icon' => 'bi-behance', 'css' => 'behance'],
                        'ti-brand-behance' => ['icon' => 'bi-behance', 'css' => 'behance'],
                    ];
                ?>
                <?php $__currentLoopData = $siteOwner->additional_info['social_links']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!empty($social['link']) && !empty($social['label'])): ?>
                        <?php
                            $label = strtolower(trim($social['label']));
                            $mapped = $iconMap[$label] ?? ['icon' => 'bi-link-45deg', 'css' => 'link'];
                            $href = str_starts_with($social['link'], 'http') ? $social['link'] : 'https://' . $social['link'];
                        ?>
                        <a href="<?php echo e($href); ?>" class="<?php echo e($mapped['css']); ?>" target="_blank" rel="noopener noreferrer">
                            <i class="bi <?php echo e($mapped['icon']); ?>"></i>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                
                <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            <?php endif; ?>
        </div>

    </div>
</header><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/frontend/include/header.blade.php ENDPATH**/ ?>