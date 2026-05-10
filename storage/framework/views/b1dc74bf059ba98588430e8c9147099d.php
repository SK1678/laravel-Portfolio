<?php echo $__env->make('frontend.include.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="index-page<?php echo e((isset($siteSettings) && $siteSettings->is_dark_mode) ? ' dark-background' : ''); ?>">

  <?php echo $__env->make('frontend.include.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <main class="main">

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Portfolio</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
            <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li data-filter=".filter-<?php echo e($sub->slug); ?>"><?php echo e($sub->name); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul><!-- End Portfolio Filters -->

          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $filterClasses = $post->categories->map(fn($c) => 'filter-' . $c->slug)->join(' ');
                    $gallery = $post->feature_gallery;
                    if (is_string($gallery)) $gallery = json_decode($gallery, true);
                    
                    $firstImg = asset('UI/assets/img/masonry-portfolio/masonry-portfolio-1.jpg');
                    if (is_array($gallery) && count($gallery) > 0) {
                        $path = is_array($gallery[0]) ? ($gallery[0]['path'] ?? null) : $gallery[0];
                        if ($path) $firstImg = asset('storage/' . $path);
                    }
                ?>
                <div class="col-lg-4 col-md-6 portfolio-item isotope-item <?php echo e($filterClasses); ?>">
                  <img src="<?php echo e($firstImg); ?>" class="img-fluid" alt="<?php echo e($post->title); ?>" style="height: 300px; width: 100%; object-fit: cover;">
                  <div class="portfolio-info">
                    <h4><?php echo e($post->title); ?></h4>
                    <p><?php echo e(Str::limit(strip_tags($post->content), 50)); ?></p>
                    <a href="<?php echo e($firstImg); ?>" title="<?php echo e($post->title); ?>"
                      data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="<?php echo e(route('blog.show', $post->slug)); ?>" title="More Details" class="details-link"><i
                        class="bi bi-link-45deg"></i></a>
                  </div>
                </div><!-- End Portfolio Item -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          </div><!-- End Portfolio Container -->

        </div>

      </div>

    </section><!-- /Portfolio Section -->

  </main>
  <?php echo $__env->make('frontend.include.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/frontend/portfolio.blade.php ENDPATH**/ ?>