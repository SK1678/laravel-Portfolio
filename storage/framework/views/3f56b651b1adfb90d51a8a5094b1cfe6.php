<?php echo $__env->make('frontend.include.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="index-page<?php echo e((isset($siteSettings) && $siteSettings->is_dark_mode) ? ' dark-background' : ''); ?>">

    <?php echo $__env->make('frontend.include.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">

            <?php if($homeSettings): ?>
                <?php if($homeSettings->mode == 'single' && !empty($homeSettings->images)): ?>
                    <img src="<?php echo e(asset('storage/' . $homeSettings->images[0])); ?>?v=<?php echo e(time()); ?>" alt="Hero Background"
                        class="hero-img">
                <?php elseif($homeSettings->mode == 'slider' && !empty($homeSettings->images)): ?>
                    <div class="swiper hero-slider">
                        <div class="swiper-wrapper">
                            <?php $__currentLoopData = $homeSettings->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo e(asset('storage/' . $img)); ?>?v=<?php echo e(time()); ?>" alt="Slider Image" class="hero-img">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php elseif($homeSettings->mode == 'video'): ?>
                    <?php if($homeSettings->video_source == 'file' && $homeSettings->video_file): ?>
                        <video autoplay muted loop id="hero-video" class="hero-bg-video">
                            <source src="<?php echo e(asset('storage/' . $homeSettings->video_file)); ?>" type="video/mp4">
                        </video>
                    <?php elseif($homeSettings->video_source == 'url' && $homeSettings->video_url): ?>
                        <?php
                            $videoUrl = $homeSettings->video_url;
                            if (str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be')) {
                                $videoId = explode('?v=', $videoUrl)[1] ?? explode('/', $videoUrl)[count(explode('/', $videoUrl)) - 1];
                                $videoUrl = "https://www.youtube.com/embed/" . $videoId . "?autoplay=1&mute=1&loop=1&playlist=" . $videoId;
                            }
                        ?>
                        <iframe class="hero-bg-video" src="<?php echo e($videoUrl); ?>" frameborder="0" allow="autoplay; encrypted-media"
                            allowfullscreen></iframe>
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: ?>
                <img src="<?php echo e(asset('assets/img/hero-bg.jpg')); ?>" alt="" class="hero-img">
            <?php endif; ?>

            <div class="container text-center" data-aos="zoom-out" data-aos-delay="100">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2 style="
                            <?php if($homeSettings->title_size): ?> font-size: <?php echo e($homeSettings->title_size); ?>; <?php endif; ?>
                            <?php if($homeSettings->title_color): ?> color: <?php echo e($homeSettings->title_color); ?>; <?php endif; ?>
                            <?php if($homeSettings->title_font): ?> font-family: <?php echo e($homeSettings->title_font); ?>; <?php endif; ?>
                        "><?php echo e($siteOwner->name ?? 'Your Name'); ?></h2>

                        <p style="
                            <?php if($homeSettings->subtitle_size): ?> font-size: <?php echo e($homeSettings->subtitle_size); ?>; <?php endif; ?>
                            <?php if($homeSettings->subtitle_color): ?> color: <?php echo e($homeSettings->subtitle_color); ?>; <?php endif; ?>
                            <?php if($homeSettings->subtitle_font): ?> font-family: <?php echo e($homeSettings->subtitle_font); ?>; <?php endif; ?>
                        ">I'm <span class="typed"
                                data-typed-items="<?php echo e($siteOwner->profile_title ?? 'Your Title'); ?>"></span></p>

                        <div class="d-flex justify-content-center gap-3 mt-4">
                            
                            <?php if($homeSettings && $homeSettings->buttons): ?>
                                <?php $__currentLoopData = $homeSettings->buttons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $btn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $type = $btn['type'] ?? 'btn';
                                        $link = $btn['link'] ?? '#';
                                        $download = false;

                                        if ($type == 'core' && isset($siteOwner->additional_info['cv'])) {
                                            $link = asset('storage/' . $siteOwner->additional_info['cv']['path']);
                                            $download = true;
                                        }

                                        $btnClass = 'btn-get-started';
                                        if ($btn['outline'] ?? false)
                                            $btnClass .= ' btn-outline-custom';
                                    ?>
                                    <a href="<?php echo e($link); ?>" class="<?php echo e($btnClass); ?>" <?php if($download): ?> download <?php endif; ?> style="
                                                 <?php if(!empty($btn['bg_color'])): ?> --custom-bg: <?php echo e($btn['bg_color']); ?>; <?php endif; ?>
                                                 <?php if(!empty($btn['text_color'])): ?> --custom-text: <?php echo e($btn['text_color']); ?>; <?php endif; ?>
                                               ">
                                        <?php echo e($btn['label']); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <style>
            #hero {
                position: relative;
                overflow: hidden;
                width: 100%;
                height: 100vh;
                /* Force height to see background */
            }

            .hero-img {
                position: absolute;
                inset: 0;
                display: block;
                width: 100% !important;
                height: 100% !important;
                object-fit: cover;
                z-index: 1;
            }

            .hero-bg-video,
            .hero-slider {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                z-index: 1;
            }

            .hero-bg-video {
                object-fit: cover;
                border: none;
            }

            .hero .container {
                position: relative;
                z-index: 3;
            }

            .hero-slider .swiper-slide {
                width: 100%;
                height: 100%;
            }

            /* Button Themes */
            .btn-get-started {
                background: var(--custom-bg, var(--accent-color)) !important;
                color: var(--custom-text, #fff) !important;
            }

            .btn-get-started:hover {
                filter: brightness(0.9);
                color: var(--custom-text, #fff) !important;
            }

            .btn-dark-custom {
                background: #222 !important;
                color: #fff !important;
            }

            .btn-dark-custom:hover {
                background: #444 !important;
            }

            .btn-light-custom {
                background: #fff !important;
                color: #222 !important;
            }

            .btn-light-custom:hover {
                background: #f0f0f0 !important;
            }

            .btn-outline-custom {
                background: transparent !important;
                border: 2px solid var(--custom-bg, var(--accent-color)) !important;
                color: var(--custom-bg, var(--accent-color)) !important;
            }

            .btn-outline-custom:hover {
                background: var(--custom-bg, var(--accent-color)) !important;
                color: var(--custom-text, #fff) !important;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof Swiper !== 'undefined') {
                    new Swiper('.hero-slider', {
                        loop: true,
                        speed: 1000,
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        }
                    });
                }
            });
        </script>

    </main>



    <?php echo $__env->make('frontend.include.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectTyped = document.querySelector('.typed');
            if (selectTyped) {
                let typed_strings = selectTyped.getAttribute('data-typed-items');
                typed_strings = typed_strings.split(',');
                new Typed('.typed', {
                    strings: typed_strings,
                    loop: true,
                    typeSpeed: 100,
                    backSpeed: 50,
                    backDelay: 2000
                });
            }
        });
    </script>

</body>

</html><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/frontend/home.blade.php ENDPATH**/ ?>