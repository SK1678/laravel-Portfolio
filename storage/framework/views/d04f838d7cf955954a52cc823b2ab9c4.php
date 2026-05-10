<!-- Blog Grid -->
<div class="row gy-5">
    <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-lg-3 col-md-4">
        <article class="blog-item h-100">
            <div class="card-img-wrapper position-relative mb-3" style="border-radius: 15px; overflow: hidden;">
                <?php
                    $gallery = $post->feature_gallery;
                    if (is_string($gallery)) $gallery = json_decode($gallery, true);
                    $hasGallery = is_array($gallery) && count($gallery) > 0;
                ?>
                
                <?php if($hasGallery && count($gallery) > 1): ?>
                    <div id="carousel-<?php echo e($post->id); ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="carousel-item <?php echo e($idx == 0 ? 'active' : ''); ?>">
                                    <img src="<?php echo e(asset('storage/' . (is_array($item) ? $item['path'] : $item))); ?>" class="d-block w-100" style="height: 220px; object-fit: cover;">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo e($post->id); ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo e($post->id); ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                <?php elseif($hasGallery): ?>
                    <a href="<?php echo e(route('blog.show', $post->slug)); ?>">
                        <img src="<?php echo e(asset('storage/' . (is_array($gallery[0]) ? $gallery[0]['path'] : $gallery[0]))); ?>" alt="" class="img-fluid w-100" style="height: 220px; object-fit: cover;">
                    </a>
                <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center text-orange" style="height: 220px; background: #fff; border: 2px dashed #ff5c5c; border-radius: 15px;">
                        Image slider
                    </div>
                <?php endif; ?>

                <div class="category-badges position-absolute bottom-0 start-0 p-2 d-flex gap-1">
                    <?php $__currentLoopData = $post->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="badge" style="background-color: #ff5c5c; color: white; border-radius: 0; padding: 4px 8px; font-weight: normal; font-size: 0.7rem;"><?php echo e($cat->name); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="meta-line d-flex align-items-center mb-2 gap-2" style="font-size: 0.75rem;">
                <span class="text-orange d-flex align-items-center"><i class="bi bi-eye me-1"></i> <?php echo e($post->views); ?></span>
                <span class="text-orange d-flex align-items-center"><i class="bi bi-calendar-event me-1"></i> <?php echo e($post->created_at->format('d M Y')); ?></span>
                <div class="ms-auto tags text-orange">
                    <?php $__currentLoopData = $post->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span><?php echo e($tag->name); ?></span><?php echo e(!$loop->last ? ' | ' : ''); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <h2 class="title fw-bold mb-2" style="font-family: serif; font-size: 1.4rem; color: #000;">
                <a href="<?php echo e(route('blog.show', $post->slug)); ?>" style="color: inherit; text-decoration: none;"><?php echo e($post->title); ?></a>
            </h2>

            <p class="excerpt text-muted mb-2" style="font-size: 0.9rem; line-height: 1.4; text-align: justify; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                <?php echo e($post->excerpt); ?>

            </p>
            <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="text-orange fw-bold" style="text-decoration: none; font-size: 0.85rem;">Read More...</a>
        </article>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-12 text-center py-5">
        <p class="text-orange fw-bold">No posts found matching your criteria.</p>
    </div>
    <?php endif; ?>
</div>

<!-- Custom Pagination -->
<div class="mt-5 d-flex justify-content-center align-items-center gap-3 ajax-pagination">
    <?php if($posts->onFirstPage()): ?>
        <i class="bi bi-caret-left-fill text-muted" style="font-size: 1.2rem;"></i>
    <?php else: ?>
        <a href="<?php echo e($posts->previousPageUrl()); ?>" class="page-link-ajax"><i class="bi bi-caret-left-fill text-orange" style="font-size: 1.2rem;"></i></a>
    <?php endif; ?>

    <div class="pagination-numbers d-flex gap-2">
        <?php $__currentLoopData = $posts->getUrlRange(1, $posts->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($url); ?>" class="text-decoration-none page-link-ajax <?php echo e($page == $posts->currentPage() ? 'fw-bold' : ''); ?>" style="color: <?php echo e($page == $posts->currentPage() ? '#ff5c5c' : '#ff5c5c'); ?>; font-size: 1rem;"><?php echo e($page); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if($posts->hasMorePages()): ?>
        <a href="<?php echo e($posts->nextPageUrl()); ?>" class="page-link-ajax"><i class="bi bi-caret-right-fill text-orange" style="font-size: 1.2rem;"></i></a>
    <?php else: ?>
        <i class="bi bi-caret-right-fill text-muted" style="font-size: 1.2rem;"></i>
    <?php endif; ?>
</div>
<?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/frontend/include/blog_list.blade.php ENDPATH**/ ?>