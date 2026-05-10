<?php echo $__env->make('frontend.include.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="index-page<?php echo e((isset($siteSettings) && $siteSettings->is_dark_mode) ? ' dark-background' : ''); ?>">

  <?php echo $__env->make('frontend.include.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

  <main class="main">

    <!-- Resume Section -->
    <section id="resume" class="resume section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Resume</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <h3 class="resume-title">Education</h3>
            <?php $education = $siteOwner->additional_info['education'] ?? []; ?>
            <?php if(count($education) > 0): ?>
              <?php $__currentLoopData = $education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="resume-item">
                  <h4><?php echo e(ucfirst(strtolower(($item['degree'] ?? '') . ' in ' . ($item['major'] ?? '')))); ?></h4>
                  <h5>
                    <?php echo e($item['year'] ?? ''); ?> (<?php echo e($item['duration'] ?? ''); ?>) 
                    <?php if(isset($item['result']) && $item['result']): ?>
                      | Result: <?php echo e($item['result']); ?>

                    <?php endif; ?>
                  </h5>
                  <p><span class="resume-org fw-bold text-primary"><?php echo e($item['institution'] ?? ''); ?></span></p>
                  <?php if(isset($item['description']) && $item['description']): ?>
                    <p class="description"><?php echo e($item['description']); ?></p>
                  <?php endif; ?>
                  <?php if(isset($item['documents']) && count($item['documents']) > 0): ?>
                    <div class="mt-3">
                      <?php $__currentLoopData = $item['documents']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $isProtected = !empty($doc['password']);
                            $fileUrl = asset('storage/' . $doc['path']);
                        ?>
                        <button type="button" 
                           onclick="handleFileAccess('<?php echo e($fileUrl); ?>', '<?php echo e($doc['password'] ?? ''); ?>')"
                           class="btn-resume me-1 mb-2">
                           <i class="bi bi-file-earmark-<?php echo e($isProtected ? 'lock' : 'pdf'); ?>"></i> <?php echo e($doc['name']); ?>

                        </button>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                  <?php endif; ?>
                </div><!-- Edn Resume Item -->
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
              <p class="text-muted small">No education history added.</p>
            <?php endif; ?>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <h3 class="resume-title">Professional Experience</h3>
            <?php $professional = $siteOwner->additional_info['professional'] ?? []; ?>
            <?php if(count($professional) > 0): ?>
              <?php $__currentLoopData = $professional; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="resume-item">
                  <h4><?php echo e(ucfirst(strtolower($item['role'] ?? ''))); ?></h4>
                  <h5>
                    <?php echo e(\Carbon\Carbon::parse($item['start_date'])->format('M Y')); ?> - 
                    <?php echo e($item['end_date'] ? \Carbon\Carbon::parse($item['end_date'])->format('M Y') : 'Present'); ?>

                  </h5>
                  <p><span class="resume-org fw-bold text-primary"><?php echo e($item['company'] ?? ''); ?></span></p>
                  <p class="description"><?php echo e($item['description'] ?? ''); ?></p>
                  
                  <?php if(isset($item['documents']) && count($item['documents']) > 0): ?>
                    <div class="mt-2">
                      <?php $__currentLoopData = $item['documents']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $isProtected = !empty($doc['password']);
                            $fileUrl = asset('storage/' . $doc['path']);
                        ?>
                        <button type="button" 
                           onclick="handleFileAccess('<?php echo e($fileUrl); ?>', '<?php echo e($doc['password'] ?? ''); ?>')"
                           class="btn-resume me-1 mb-1">
                           <i class="bi bi-file-earmark-<?php echo e($isProtected ? 'lock' : 'pdf'); ?>"></i> <?php echo e($doc['name']); ?>

                        </button>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                  <?php endif; ?>
                </div><!-- Edn Resume Item -->
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
              <p class="text-muted small">No professional experience added.</p>
            <?php endif; ?>
          </div>

        </div>

      </div>

    </section><!-- /Resume Section -->

  </main>
  
  <style>
    .resume-item h4 {
        text-transform: none !important;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .resume-org {
        color: var(--accent-color) !important;
        font-size: 0.95rem;
    }
    .resume-item .description {
        text-align: justify;
    }
    .btn-resume {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--accent-color);
        background-color: transparent;
        border: 1px solid var(--accent-color);
        border-radius: 50px;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .btn-resume i {
        margin-right: 5px;
    }
    .btn-resume:hover {
        background-color: var(--accent-color);
        color: var(--contrast-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
  </style>

  <script>
    function handleFileAccess(url, password) {
        if (!password) {
            window.open(url, '_blank');
            return;
        }

        Swal.fire({
            title: 'Password Protected',
            text: 'Please enter the password to view this document:',
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Open File',
            confirmButtonColor: 'var(--accent-color)',
            showLoaderOnConfirm: true,
            preConfirm: (inputPassword) => {
                if (inputPassword === password) {
                    return true;
                } else {
                    Swal.showValidationMessage('Incorrect password!');
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

  <?php echo $__env->make('frontend.include.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/frontend/resume.blade.php ENDPATH**/ ?>