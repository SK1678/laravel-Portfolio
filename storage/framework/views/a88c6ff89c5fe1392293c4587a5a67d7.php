<footer id="footer" class="footer light-background">

    <div class="container">
        <div class="copyright text-center ">
            <p>© <span>Copyright</span> <strong
                    class="px-1 sitename"><?php echo e($siteSettings->site_title ?? 'Kelly'); ?></strong> <span>All Rights
                    Reserved<br></span></p>
        </div>
        <div class="social-links d-flex justify-content-center">
            <?php if(isset($siteOwner) && $siteOwner && !empty($siteOwner->additional_info['social_links'])): ?>
                <?php
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
                        'ti-telegram' => ['icon' => 'bi-telegram', 'css' => 'telegram'],
                        'ti-brand-telegram' => ['icon' => 'bi-telegram', 'css' => 'telegram'],
                        'ti-dribbble' => ['icon' => 'bi-dribbble', 'css' => 'dribbble'],
                        'ti-behance' => ['icon' => 'bi-behance', 'css' => 'behance'],
                    ];
                ?>
                <?php $__currentLoopData = $siteOwner->additional_info['social_links']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!empty($social['link']) && !empty($social['label'])): ?>
                        <?php
                            $label = strtolower(trim($social['label']));
                            $mapped = $iconMap[$label] ?? ['icon' => 'bi-link-45deg', 'css' => 'link'];
                            $href = str_starts_with($social['link'], 'http') ? $social['link'] : 'https://' . $social['link'];
                        ?>
                        <a href="<?php echo e($href); ?>" class="<?php echo e($mapped['css']); ?>" target="_blank" rel="noopener noreferrer"><i
                                class="bi <?php echo e($mapped['icon']); ?>"></i></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <a href=""><i class="bi bi-twitter-x"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
            <?php endif; ?>
        </div>

    </div>

</footer>

<?php echo $__env->make('frontend.include.chat_widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="<?php echo e(asset('UI/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('UI/assets/vendor/php-email-form/validate.js')); ?>"></script>
<script src="<?php echo e(asset('UI/assets/vendor/aos/aos.js')); ?>"></script>
<script src="<?php echo e(asset('UI/assets/vendor/waypoints/noframework.waypoints.js')); ?>"></script>
<script src="<?php echo e(asset('UI/assets/vendor/purecounter/purecounter_vanilla.js')); ?>"></script>
<script src="<?php echo e(asset('UI/assets/vendor/swiper/swiper-bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('UI/assets/vendor/glightbox/js/glightbox.min.js')); ?>"></script>
<script src="<?php echo e(asset('UI/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')); ?>"></script>
<script src="<?php echo e(asset('UI/assets/vendor/isotope-layout/isotope.pkgd.min.js')); ?>"></script>

<!-- Main JS File -->
<script src="<?php echo e(asset('UI/assets/js/main.js')); ?>"></script>

<script>
    document.addEventListener('click', function(e) {
        const target = e.target.closest('a, button');
        if (target) {
            fetch('<?php echo e(route("track.click")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({ 
                    url: target.href || 'button' 
                })
            }).catch(err => console.error('Click tracking failed', err));
        }
    });
</script><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/frontend/include/footer.blade.php ENDPATH**/ ?>