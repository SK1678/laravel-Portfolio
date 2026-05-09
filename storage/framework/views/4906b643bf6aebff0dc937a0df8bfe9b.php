<?php echo $__env->make('frontend.include.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="index-page<?php echo e((isset($siteSettings) && $siteSettings->is_dark_mode) ? ' dark-background' : ''); ?>">

  <?php echo $__env->make('frontend.include.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <main class="main">

    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2><?php echo e($serviceSetting->title ?? 'Services'); ?></h2>
        <?php if($serviceSetting->subtitle): ?>
          <p><?php echo e($serviceSetting->subtitle); ?></p>
        <?php endif; ?>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">
          <?php if($services && count($services) > 0): ?>
            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
                $colors = ['item-cyan', 'item-orange', 'item-teal', 'item-red', 'item-indigo', 'item-pink'];
                $colorClass = $colors[$index % count($colors)];
                $delay = ($index + 1) * 100;
              ?>
              <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo e($delay); ?>">
                <div class="service-item <?php echo e($colorClass); ?> position-relative">
                  <div class="icon">
                    <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                      <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,521.0016835830174C376.1290562159157,517.8887921683347,466.0731472004068,529.7835943286574,510.70327084640275,468.03025145048787C554.3714126377745,407.6079735673963,508.03601936045806,328.9844924480964,491.2728898941984,256.3432110539036C474.5976632858925,184.082847569629,479.9380746630129,96.60480741107993,416.23090153303,58.64404602377083C348.86323505073057,18.502131276798302,261.93793281208167,40.57373210992963,193.5410806939664,78.93577620505333C130.42746243093433,114.334589627462,98.30271207620316,179.96522072025542,76.75703585869454,249.04625023123273C51.97151888228291,328.5150500222984,13.704378332031375,421.85034740162234,66.52175969318436,486.19268352777647C119.04800174914682,550.1803526380478,217.28368757567262,524.383925680826,300,521.0016835830174"></path>
                    </svg>
                    <i class="bi <?php echo e($service->icon ?? 'bi-briefcase'); ?>"></i>
                  </div>
                  <h3><?php echo e($service->title); ?></h3>
                  <p><?php echo e($service->description); ?></p>
                </div>
              </div><!-- End Service Item -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php else: ?>
            <div class="col-12 text-center py-5">
              <p class="text-muted">No services added yet.</p>
            </div>
          <?php endif; ?>
        </div>

      </div>

    </section><!-- /Services Section -->

  </main>

  <?php echo $__env->make('frontend.include.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



</body>

</html><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/frontend/services.blade.php ENDPATH**/ ?>