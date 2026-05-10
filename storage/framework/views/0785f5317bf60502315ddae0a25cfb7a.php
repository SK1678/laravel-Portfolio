<?php $__env->startSection('content'); ?>
  <div class="row ">
    <div class="col-12">
      <div class="mb-6">
        <h1 class="fs-3 mb-1">Dashboard</h1>
        <p>Your main content goes here…</p>
      </div>
    </div>
  </div>
  <div class="row g-3 mb-3">
    <div class="col-lg-3 col-12">
      <div class="card p-4 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-2">
        <div class="d-flex gap-3">
          <div class="icon-shape icon-md bg-primary text-white rounded-2">
            <i class="ti ti-news fs-4"></i>
          </div>
          <div>
            <h2 class="mb-3 fs-6">Total Post</h2>
            <h3 class="fw-bold mb-0"><?php echo e(number_format($stats['total_posts'])); ?></h3>
            <p class="text-primary mb-0 small">Active Content</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-12">
      <div class="card p-4 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-2">
        <div class="d-flex gap-3">
          <div class="icon-shape icon-md bg-success text-white rounded-2">
            <i class="ti ti-eye fs-4"></i>
          </div>
          <div>
            <h2 class="mb-3 fs-6">Total Post Views</h2>
            <h3 class="fw-bold mb-0"><?php echo e(number_format($stats['total_post_views'])); ?></h3>
            <p class="text-success mb-0 small">Engagement</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-12">
      <div class="card p-4 bg-info bg-opacity-10 border border-info border-opacity-25 rounded-2">
        <div class="d-flex gap-3">
          <div class="icon-shape icon-md bg-info text-white rounded-2">
            <i class="ti ti-chart-bar fs-4"></i>
          </div>
          <div>
            <h2 class="mb-3 fs-6">Total Site Views</h2>
            <h3 class="fw-bold mb-0"><?php echo e(number_format($stats['total_site_views'])); ?></h3>
            <p class="text-info mb-0 small">Traffic</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-12">
      <div class="card p-4 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-2">
        <div class="d-flex gap-3">
          <div class="icon-shape icon-md bg-warning text-white rounded-2">
            <i class="ti ti-messages fs-4"></i>
          </div>
          <div>
            <h2 class="mb-3 fs-6">Total Comments</h2>
            <h3 class="fw-bold mb-0"><?php echo e(number_format($stats['total_comments'])); ?></h3>
            <p class="text-warning mb-0 small">Interactions</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3 mb-3">
    <div class="col-12 col-lg-6">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-transparent px-4 py-3">
          <h3 class="h5 mb-0">Views vs Clicks</h3>
          <div>
            <select class="form-select form-select-sm" id="chartPeriodSelector">
              <option value="today">Today</option>
              <option value="this_week" selected>This Week</option>
              <option value="this_month">This Month</option>
              <option value="last_6_months">Last 6 Months</option>
            </select>
          </div>
        </div>
        <div class="card-body p-4">
          <div id="salesPurchaseChart" 
               data-initial='<?php echo json_encode($initialChartData, 15, 512) ?>'
               data-url="<?php echo e(route('admin.dashboard.chartData')); ?>"></div>
        </div>
      </div>
    </div>


    <div class="col-12 col-lg-6">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-transparent px-4 py-3">
          <h3 class="h5 mb-0">Overall Information</h3>
          <div>
            <select class="form-select form-select-sm">
              <option selected>Last 6 Months</option>
              <option>This Month</option>
              <option>This Week</option>
            </select>
          </div>
        </div>
        <div class="card-body p-4">
          <h3 class="h6">Visitors Overview</h3>
          <div class="row align-items-center">
            <div class="col-sm-6">
              <div id="customerChart" 
                   data-first="<?php echo e($stats['first_time_views']); ?>" 
                   data-return="<?php echo e($stats['returning_views']); ?>"></div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <?php
                  $totalViews = $stats['total_site_views'] ?: 1;
                  $firstPercent = round(($stats['first_time_views'] / $totalViews) * 100);
                  $returnPercent = round(($stats['returning_views'] / $totalViews) * 100);

                  if (!function_exists('formatStat')) {
                      function formatStat($n) {
                          if ($n >= 1000) return round($n / 1000, 1) . 'K';
                          return $n;
                      }
                  }
                ?>
                <div class="col-6 border-end">
                  <div class="text-center">
                    <h2 class="mb-1"><?php echo e(formatStat($stats['first_time_views'])); ?></h2>
                    <p class="text-success mb-2 small">First Time</p>
                    <span class="badge bg-success-subtle text-success border border-success"><i class="ti ti-arrow-up-right me-1"></i><?php echo e($firstPercent); ?>%</span>
                  </div>
                </div>
                <div class="col-6">
                  <div class="text-center">
                    <h2 class="mb-1"><?php echo e(formatStat($stats['returning_views'])); ?></h2>
                    <p class="text-warning mb-2 small">Return</p>
                    <span class="badge bg-warning-subtle text-warning border border-warning"><i class="ti ti-rotate-clockwise me-1"></i><?php echo e($returnPercent); ?>%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row text-center border-top mt-4 pt-4">
            <div class="col-4 border-end">
              <h3 class="fw-bold mb-2"><?php echo e(number_format($stats['total_posts'])); ?></h3>
              <small class="text-secondary">Total Posts</small>
            </div>
            <div class="col-4 border-end">
              <h3 class="fw-bold mb-2"><?php echo e(number_format($stats['total_post_views'])); ?></h3>
              <small class="text-secondary">Post Views</small>
            </div>
            <div class="col-4">
              <h3 class="fw-bold mb-2"><?php echo e(number_format($stats['total_comments'])); ?></h3>
              <small class="text-secondary">Comments</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row g-3">

    <!-- CARD 1 — Post View Statistics -->
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header bg-white d-flex justify-content-between align-items-center px-4 py-3">
          <h4 class="mb-0 h5">Post View Statistics</h4>
          <span class="badge bg-primary-subtle text-primary">Live</span>
        </div>

        <ul class="list-group list-group-flush">
          <?php $__currentLoopData = $postStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interval => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="list-group-item d-flex align-items-center justify-content-between py-3">
            <div class="d-flex align-items-center gap-3">
              <div class="icon-shape icon-sm bg-light text-primary rounded-circle">
                <i class="ti ti-chart-bar fs-5"></i>
              </div>
              <p class="mb-0 text-capitalize"><?php echo e($interval); ?> Views</p>
            </div>
            <h5 class="mb-0 fw-bold"><?php echo e(number_format($count)); ?></h5>
          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>

    <!-- CARD 2 — Popular Content -->
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header bg-white d-flex justify-content-between align-items-center px-4 py-3">
          <h4 class="mb-0 h5">Popular Content</h4>
          <a href="<?php echo e(route('admin.posts')); ?>" class="small text-primary text-decoration-underline">View All</a>
        </div>

        <ul class="list-group list-group-flush">
          <?php $__currentLoopData = $topPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $thumbnail = null;
            if ($post->feature_gallery && is_array($post->feature_gallery) && count($post->feature_gallery) > 0) {
                $thumbnail = $post->feature_gallery[0];
            }
          ?>
          <li class="list-group-item p-0">
            <a href="<?php echo e(route('blog.show', $post->slug)); ?>" target="_blank" class="d-flex align-items-center gap-3 p-3 text-decoration-none hover-bg-light">
              <img src="<?php echo e($thumbnail ? asset('storage/' . $thumbnail) : asset('/dashboard_assets/images/product-8.png')); ?>" class="rounded" width="48" height="48" style="object-fit: cover; min-width: 48px;">
              <div class="flex-grow-1 overflow-hidden">
                <p class="mb-0 text-dark fw-semibold text-truncate"><?php echo e($post->title); ?></p>
                <small class="text-muted"><?php echo e($post->created_at->format('M d, Y')); ?></small>
              </div>
              <div class="text-end" style="min-width: 60px;">
                <span class="fw-bold text-primary"><?php echo e(number_format($post->views)); ?></span>
                <br>
                <small class="text-muted">Views</small>
              </div>
            </a>
          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>

    <!-- CARD 3 — Latest Interactions -->
    <div class="col-lg-4">
      <div class="card h-100">
        <div class="card-header bg-white d-flex justify-content-between align-items-center px-4 py-3">
          <h4 class="mb-0 h5">Latest Interactions</h4>
          <a href="<?php echo e(route('admin.messages')); ?>" class="small text-primary text-decoration-underline">View All</a>
        </div>

        <ul class="list-group list-group-flush">
          <?php $__currentLoopData = $interactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="list-group-item p-0">
            <a href="<?php echo e($interaction->link); ?>" class="d-flex align-items-center gap-3 p-3 text-decoration-none hover-bg-light">
              <div class="avatar avatar-sm bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; min-width: 48px;">
                  <?php echo e(strtoupper(substr($interaction->user_name ?? 'G', 0, 1))); ?>

              </div>
              <div class="flex-grow-1 overflow-hidden">
                <p class="mb-0 text-dark fw-semibold text-truncate"><?php echo e($interaction->body); ?></p>
                <small class="text-muted">by <?php echo e($interaction->user_name); ?> • <?php echo e($interaction->type); ?></small>
              </div>
              <div class="text-end" style="min-width: 80px;">
                  <span class="badge bg-light text-dark x-small"><?php echo e($interaction->date->diffForHumans(null, true)); ?></span>
              </div>
            </a>
          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>

  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/index.blade.php ENDPATH**/ ?>