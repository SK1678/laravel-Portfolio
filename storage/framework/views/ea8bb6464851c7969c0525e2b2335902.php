<?php $__env->startSection('content'); ?>
    <div class="user-profile-container px-3 pt-5">
        <!-- Profile Header Card -->
        <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-5 border-end d-flex align-items-center gap-4">
                        <div class="profile-img-wrapper">
                            <?php if($user->profile_image): ?>
                                <img src="<?php echo e(asset('storage/' . $user->profile_image)); ?>"
                                    class="rounded-circle object-fit-cover shadow-sm border border-3 border-light"
                                    style="width: 100px; height: 100px;" alt="<?php echo e($user->name); ?>">
                            <?php else: ?>
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white shadow-sm border border-3 border-light"
                                    style="width: 100px; height: 100px; font-size: 2.5rem;">
                                    <?php echo e(substr($user->name, 0, 1)); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-dark"><?php echo e($user->name); ?></h4>
                            <div class="d-flex align-items-center gap-2">
                                <?php 
                                    $titles = !empty($user->profile_title) ? explode(',', $user->profile_title) : ['Professional Profile'];
                                ?>
                                <p class="mb-0 text-primary small fw-semibold">
                                    <?php $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e(trim($title)); ?><?php if(!$loop->last): ?> <span class="text-muted fw-normal mx-1">|</span> <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 ps-md-5 mt-4 mt-md-0">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <p class="text-muted extra-small mb-0">User ID</p>
                                    <p class="fw-bold text-dark small mb-0">#USR-<?php echo e(str_pad($user->id, 5, '0', STR_PAD_LEFT)); ?></p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-muted extra-small mb-0">User Type</p>
                                    <span class="badge <?php echo e($user->user_type == 'admin' ? 'bg-primary' : 'bg-secondary'); ?> extra-small">
                                        <?php echo e(ucfirst($user->user_type)); ?>

                                    </span>
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-muted extra-small mb-0">Email address</p>
                                    <p class="fw-bold text-dark small mb-0 text-truncate"><?php echo e($user->email); ?></p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-muted extra-small mb-0">Authority</p>
                                    <?php if($user->is_site_owner): ?>
                                        <span class="badge bg-warning text-dark extra-small"><i class="ti ti-crown me-1"></i>Site Owner</span>
                                    <?php else: ?>
                                        <span class="text-muted small">Standard Access</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Information Grid -->
        <div class="row g-4">
            <!-- Left Column: Personal Information -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold text-secondary mb-0">Personal information</h5>
                        <a href="<?php echo e(route('user.edit', $user->id)); ?>" class="text-muted"><i class="ti ti-pencil"></i></a>
                    </div>
                    <div class="card-body px-4 pt-0">
                        <hr class="mt-0 mb-4 text-muted opacity-25">
                        <div class="row row-cols-2 g-4">
                            <?php $personal = $user->additional_info['personal'] ?? []; ?>
                            <?php $__empty_1 = true; $__currentLoopData = $personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="mb-3">
                                    <label class="text-muted small d-block mb-1"><?php echo e($item['label'] ?? 'Detail'); ?></label>
                                    <span class="fw-bold text-dark"><?php echo e($item['value'] ?? '-'); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-12 text-center py-3">
                                    <p class="text-muted small mb-0">No personal information details added.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Social & Professional Links -->
                <div class="card border-0 shadow-sm rounded-3 mt-4">
                    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold text-secondary mb-0">Web & Documents</h5>
                        <a href="<?php echo e(route('user.edit', $user->id)); ?>" class="text-muted"><i class="ti ti-pencil"></i></a>
                    </div>
                    <div class="card-body px-4 pt-0">
                        <hr class="mt-0 mb-4 text-muted opacity-25">
                        
                        <!-- CV Download -->
                        <?php if(isset($user->additional_info['cv']) && $user->additional_info['cv']): ?>
                            <div class="mb-4">
                                <a href="<?php echo e(asset('storage/' . $user->additional_info['cv']['path'])); ?>" target="_blank" class="btn btn-primary btn-sm w-100 rounded-pill fw-medium shadow-sm">
                                    <i class="ti ti-file-cv me-2"></i> Download <?php echo e($user->additional_info['cv']['name'] ?? 'Resume / CV'); ?>

                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Social Links -->
                        <?php $socialLinks = $user->additional_info['social_links'] ?? []; ?>
                        <?php if(!empty($socialLinks)): ?>
                            <div class="d-flex flex-wrap gap-2">
                                <?php $__currentLoopData = $socialLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $rawLabel = $item['label'] ?? 'ti-link';
                                        
                                        // If they just typed a word like 'Fb' or 'Facebook' instead of an icon class
                                        if (!str_contains($rawLabel, '-')) {
                                            $iconClass = 'ti ti-link';
                                            $readableLabel = $rawLabel;
                                        } else {
                                            $iconClass = $rawLabel;
                                            
                                            // Auto-fix for Tabler Icons if they forgot the 'brand-' prefix
                                            $commonBrands = ['twitter', 'facebook', 'linkedin', 'github', 'instagram', 'youtube', 'dribbble', 'behance', 'pinterest', 'skype'];
                                            foreach ($commonBrands as $brand) {
                                                if (str_contains($iconClass, "ti-{$brand}") && !str_contains($iconClass, "ti-brand-{$brand}")) {
                                                    $iconClass = str_replace("ti-{$brand}", "ti-brand-{$brand}", $iconClass);
                                                }
                                            }

                                            if (!str_contains($iconClass, 'ti ')) {
                                                $iconClass = 'ti ' . $iconClass;
                                            }
                                            // Extract a readable name from the class
                                            $readableLabel = str_replace(['ti-brand-', 'ti-', 'ti '], '', $iconClass);
                                        }
                                    ?>
                                    
                                    <a href="<?php echo e($item['link'] ?? '#'); ?>" target="_blank" class="btn btn-sm btn-light border-0 text-dark rounded-pill px-3 py-2 fw-medium d-inline-flex align-items-center gap-2 text-decoration-none">
                                        <i class="<?php echo e($iconClass); ?> fs-6 text-primary"></i> 
                                        <span class="text-capitalize"><?php echo e($readableLabel ?: 'Link'); ?></span>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-2">
                                <p class="text-muted small mb-0">No links added.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Education & Account Information -->
            <div class="col-lg-7 d-flex flex-column gap-4">
                <!-- Education Information -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold text-secondary mb-0">Education information</h5>
                        <a href="<?php echo e(route('user.edit', $user->id)); ?>" class="text-muted"><i class="ti ti-pencil"></i></a>
                    </div>
                    <div class="card-body px-4 pt-0">
                        <hr class="mt-0 mb-4 text-muted opacity-25">
                        <?php $education = $user->additional_info['education'] ?? []; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="education-item mb-4 pb-3 border-bottom border-light last-child-no-border">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold text-dark fs-6"><?php echo e($item['degree'] ?? 'Degree'); ?></span>
                                    <span class="fw-bold text-dark small"><?php echo e($item['year'] ?? ''); ?></span>
                                </div>
                                <div class="mb-2">
                                    <p class="text-primary fw-medium small mb-1"><?php echo e($item['major'] ?? 'Major'); ?></p>
                                    <p class="text-muted small mb-1"><i class="ti ti-school me-1"></i><?php echo e($item['institution'] ?? 'Institution'); ?></p>
                                    <div class="d-flex gap-3 extra-small text-muted">
                                        <span><i class="ti ti-calendar me-1"></i><?php echo e($item['duration'] ?? 'N/A'); ?></span>
                                        <span><i class="ti ti-award me-1"></i><?php echo e($item['result'] ?? 'N/A'); ?></span>
                                    </div>
                                </div>
                                
                                <!-- Attachments -->
                                <?php if(!empty($item['documents'])): ?>
                                    <div class="mt-2 d-flex flex-wrap gap-2">
                                        <?php $__currentLoopData = $item['documents']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(asset('storage/' . $doc['path'])); ?>" target="_blank" 
                                               class="btn btn-extra-sm btn-light border text-primary rounded-pill px-3 py-1 fw-medium shadow-sm"
                                               title="<?php echo e(isset($doc['password']) && $doc['password'] ? 'Password Protected' : 'Open Document'); ?>">
                                                <i class="ti ti-<?php echo e(isset($doc['password']) && $doc['password'] ? 'lock' : 'file-download'); ?> me-1"></i>
                                                <?php echo e($doc['name']); ?>

                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-muted small text-center my-3">No education history added.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold text-secondary mb-0">Professional Experience</h5>
                        <a href="<?php echo e(route('user.edit', $user->id)); ?>" class="text-muted"><i class="ti ti-pencil"></i></a>
                    </div>
                    <div class="card-body px-4 pt-0 pb-4">
                        <hr class="mt-0 mb-4 text-muted opacity-25">
                        <div class="row g-4">
                            <?php $professional = $user->additional_info['professional'] ?? []; ?>
                            <?php $__empty_1 = true; $__currentLoopData = $professional; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-12 professional-item mb-3 pb-3 border-bottom border-light last-child-no-border">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0 fs-6"><?php echo e($item['role'] ?? 'Role'); ?></h6>
                                            <p class="text-success fw-medium small mb-0"><?php echo e($item['company'] ?? 'Company'); ?></p>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-light text-dark border extra-small">
                                                <?php echo e(isset($item['start_date']) && $item['start_date'] ? \Carbon\Carbon::parse($item['start_date'])->format('M Y') : 'N/A'); ?> - 
                                                <?php echo e(isset($item['end_date']) && $item['end_date'] ? \Carbon\Carbon::parse($item['end_date'])->format('M Y') : 'Present'); ?>

                                            </span>
                                        </div>
                                    </div>
                                    
                                    <?php if(isset($item['description']) && $item['description']): ?>
                                        <p class="text-muted small mb-3 lh-sm" style="text-align: justify;"><?php echo e($item['description']); ?></p>
                                    <?php endif; ?>

                                    <!-- Experience Attachments -->
                                    <?php if(!empty($item['documents'])): ?>
                                        <div class="d-flex flex-wrap gap-2">
                                            <?php $__currentLoopData = $item['documents']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="<?php echo e(asset('storage/' . $doc['path'])); ?>" target="_blank" 
                                                   class="btn btn-extra-sm btn-light border text-success rounded-pill px-3 py-1 fw-medium shadow-sm"
                                                   title="<?php echo e(isset($doc['password']) && $doc['password'] ? 'Password Protected' : 'Open Document'); ?>">
                                                    <i class="ti ti-<?php echo e(isset($doc['password']) && $doc['password'] ? 'lock' : 'file-download'); ?> me-1"></i>
                                                    <?php echo e($doc['name']); ?>

                                                </a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col-12 text-center py-4">
                                    <i class="ti ti-briefcase text-muted fs-1 opacity-25 mb-2 d-block"></i>
                                    <p class="text-muted small mb-0">No professional experience added yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .nav-underline .nav-link {
            white-space: nowrap;
        }

        .card-title {
            letter-spacing: 0.2px;
        }

        .fw-bold {
            color: #2b3a4a !important;
        }

        .text-muted {
            color: #8c98a5 !important;
        }

        .btn-extra-sm {
            padding: 0.15rem 0.6rem;
            font-size: 0.75rem;
        }

        .last-child-no-border:last-child {
            border-bottom: 0 !important;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/user-show.blade.php ENDPATH**/ ?>