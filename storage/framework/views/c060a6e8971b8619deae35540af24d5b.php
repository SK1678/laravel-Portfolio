<?php echo $__env->make('frontend.include.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="about-page<?php echo e((isset($siteSettings) && $siteSettings->is_dark_mode) ? ' dark-background' : ''); ?>">

  <?php echo $__env->make('frontend.include.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <main class="main">

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2><?php echo e($about->title ?? 'About'); ?></h2>
        <?php if($about->subtitle): ?>
          <p><?php echo e($about->subtitle); ?></p>
        <?php endif; ?>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 justify-content-center">
          <style>
            .about-profile-img {
              width: 100%;
              aspect-ratio: 1 / 1;
              object-fit: contain;
              object-position: center;
              background: #f8f9fa;
              border-radius: 10px;
              display: block;
              box-shadow: none !important;
            }
          </style>

          <div class="col-lg-3">
            <img
              src="<?php echo e(($about && $about->image_path) ? asset('storage/' . $about->image_path) : (($siteOwner && $siteOwner->profile_image) ? asset('storage/' . $siteOwner->profile_image) : asset('UI/assets/img/profile-img.jpg'))); ?>"
              class="img-fluid rounded about-profile-img" alt="Profile Image">
          </div>
          <div class="col-lg-9 content">
            <h4><?php echo e($about->objective_title ?? 'Career Summary'); ?></h4>
            <div class="py-3" style="text-align: justify;">
              <?php echo nl2br(e($about->career_objective ?? '')); ?>

            </div>
            <div class="row mt-4">
              <?php if($about && $about->details): ?>
                <?php $__currentLoopData = $about->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-lg-6">
                    <ul class="ps-0">
                      <li class="list-unstyled d-flex align-items-center mb-3">
                        <i class="bi bi-chevron-right me-2" style="color: var(--accent-color);"></i>
                        <strong class="me-1"><?php echo e($item['label']); ?>:</strong>
                        <span>
                          <?php if($item['type'] == 'link'): ?>
                            <a href="<?php echo e($item['value']); ?>" target="_blank"><?php echo e($item['value']); ?></a>
                          <?php else: ?>
                            <?php echo e($item['value']); ?>

                          <?php endif; ?>
                        </span>
                      </li>
                    </ul>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Skills Section -->
    <section id="skills" class="skills section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2><?php echo e($skillSettings->title ?? 'Skills'); ?></h2>
        <?php if($skillSettings->subtitle): ?>
          <p><?php echo e($skillSettings->subtitle); ?></p>
        <?php endif; ?>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row skills-content skills-animation">
          <?php if($skills && count($skills) > 0): ?>
            <?php
              $skillChunks = array_chunk($skills->toArray(), ceil(count($skills) / 2));
            ?>
            <?php $__currentLoopData = $skillChunks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="col-lg-6">
                <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="progress">
                    <span class="skill"><span><?php echo e($skill['name']); ?></span> <i class="val"><?php echo e($skill['percent']); ?>%</i></span>
                    <div class="progress-bar-wrap">
                      <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo e($skill['percent']); ?>" aria-valuemin="0"
                        aria-valuemax="100">
                      </div>
                    </div>
                  </div><!-- End Skills Item -->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </div>

      </div>

    </section><!-- /Skills Section -->

    <!-- Awards & Certifications Section -->
    <section id="awards" class="awards section bg-light py-5">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2><?php echo e($awardSettings->title ?? 'Awards & Certifications'); ?></h2>
        <?php if($awardSettings->subtitle): ?>
          <p><?php echo e($awardSettings->subtitle); ?></p>
        <?php endif; ?>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          <?php if($awards && count($awards) > 0): ?>
            <?php $__currentLoopData = $awards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="col-lg-4 col-md-6">
                <div class="award-card p-4 h-100 bg-white rounded shadow-sm border-0 position-relative"
                  style="transition: all 0.3s ease;">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge py-2 px-3 rounded-pill small fw-bold theme-accent-bg-light theme-accent-color">
                      <?php echo e($award->year); ?>

                    </span>
                    <i class="bi bi-patch-check-fill fs-4 theme-accent-color"></i>
                  </div>
                  <h5 class="fw-bold mb-1"><?php echo e($award->title); ?></h5>
                  <p class="text-muted small mb-3"><i class="bi bi-building me-1"></i> <?php echo e($award->organization); ?></p>
                  <?php if($award->description): ?>
                    <p class="small text-secondary mb-3"><?php echo e($award->description); ?></p>
                  <?php endif; ?>

                  
                  <div class="award-proofs mt-auto">
                    <?php if($award->proofs && count($award->proofs) > 0): ?>
                      <div class="d-flex flex-wrap gap-2">
                        <?php $__currentLoopData = $award->proofs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php
                            $isProtected = isset($proof['is_protected']) && $proof['is_protected'];
                          ?>
                          <a href="<?php echo e($isProtected ? 'javascript:void(0)' : $proof['value']); ?>"
                            target="<?php echo e($isProtected ? '' : '_blank'); ?>"
                            class="btn btn-xs btn-outline-theme rounded-pill px-3 py-1 proof-link" <?php if($isProtected): ?>
                            onclick="verifyAwardPassword('<?php echo e($proof['value']); ?>', '<?php echo e($proof['password']); ?>')" <?php endif; ?>>
                            <?php if($isProtected): ?>
                              <i class="bi bi-lock-fill me-1 text-danger"></i>
                            <?php else: ?>
                              <i class="bi bi-link-45deg me-1"></i>
                            <?php endif; ?>
                            <?php echo e($proof['label'] ?? 'Certificate'); ?>

                          </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </div>
                    <?php elseif($award->proof_url): ?>
                      
                      <a href="<?php echo e($award->proof_url); ?>" target="_blank"
                        class="btn btn-sm btn-outline-theme w-100 rounded-pill py-2">
                        <i class="bi bi-link-45deg me-1"></i> View Certificate
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </div>
      </div>

      <script>
        function verifyAwardPassword(url, password) {
          Swal.fire({
            title: 'Password Protected',
            text: 'Please enter the password to view this certificate',
            input: 'password',
            confirmButtonColor: 'var(--accent-color)',
            showCancelButton: true,
            confirmButtonText: 'Access',
            showLoaderOnConfirm: true,
            preConfirm: (inputPassword) => {
              if (inputPassword === password) {
                return true;
              } else {
                Swal.showValidationMessage('Incorrect password');
                return false;
              }
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.isConfirmed) {
              window.open(url, '_blank');
            }
          });
        }
      </script>

      <style>
        .award-card {
          border: 1px solid rgba(0, 0, 0, 0.05) !important;
        }

        .award-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
          border-color: var(--accent-color) !important;
        }

        .theme-accent-color {
          color: var(--accent-color) !important;
        }

        .theme-accent-bg-light {
          background-color: color-mix(in srgb, var(--accent-color), transparent 90%) !important;
        }

        .btn-outline-theme {
          color: var(--accent-color);
          border: 1px solid var(--accent-color);
          font-size: 11px;
          transition: all 0.3s;
        }

        .btn-outline-theme:hover {
          background-color: var(--accent-color);
          color: #fff;
        }

        .btn-xs {
          padding: 2px 8px;
          font-size: 0.75rem;
        }
      </style>
    </section><!-- /Awards & Certifications Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2><?php echo e($counterSettings->title ?? 'Facts'); ?></h2>
        <?php if($counterSettings->subtitle): ?>
          <p><?php echo e($counterSettings->subtitle); ?></p>
        <?php endif; ?>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <?php if($counters && count($counters) > 0): ?>
            <?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                  <span data-purecounter-start="0"
                    data-purecounter-end="<?php echo e(preg_replace('/[^0-9]/', '', $counter->value)); ?>" data-purecounter-duration="1"
                    class="purecounter"></span>
                  <p><?php echo e($counter->name); ?></p>
                </div>
              </div><!-- End Stats Item -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>

        </div>

      </div>

    </section><!-- /Stats Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              }
            }
          </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="<?php echo e(asset('UI/assets/img/testimonials/testimonials-1.jpg')); ?>" class="testimonial-img" alt="">
                <h3>Saul Goodman</h3>
                <h4>Ceo &amp; Founder</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus.
                    Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="<?php echo e(asset('UI/assets/img/testimonials/testimonials-2.jpg')); ?>" class="testimonial-img" alt="">
                <h3>Sara Wilsson</h3>
                <h4>Designer</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram
                    malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="<?php echo e(asset('UI/assets/img/testimonials/testimonials-3.jpg')); ?>" class="testimonial-img" alt="">
                <h3>Jena Karlis</h3>
                <h4>Store Owner</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis
                    minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="<?php echo e(asset('UI/assets/img/testimonials/testimonials-4.jpg')); ?>" class="testimonial-img" alt="">
                <h3>Matt Brandon</h3>
                <h4>Freelancer</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim
                    velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum
                    veniam.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="<?php echo e(asset('UI/assets/img/testimonials/testimonials-5.jpg')); ?>" class="testimonial-img" alt="">
                <h3>John Larson</h3>
                <h4>Entrepreneur</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim
                    culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum
                    quid.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

  </main>

  <?php echo $__env->make('frontend.include.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>

</html><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/frontend/about.blade.php ENDPATH**/ ?>