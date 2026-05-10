<div class="comment-item mb-2">
    <div class="d-flex align-items-center gap-2 mb-0" style="line-height: 1;">
        <span class="fw-bold" style="font-family: serif; font-size: 0.95rem;"><?php echo e($comment->user->name); ?></span>
        <span class="text-muted small ms-1" style="font-size: 0.7rem;"><?php echo e($comment->created_at->format('d M Y, h:i A')); ?></span>
    </div>
    <div class="comment-text ps-1" style="line-height: 1.2;">
        <p class="mb-0 text-muted" style="font-size: 0.85rem;"><?php echo e($comment->body); ?></p>
        <div class="d-flex align-items-center gap-2 mt-1">
            <?php if(auth()->guard()->check()): ?>
                <a href="javascript:void(0)" class="text-orange small fw-bold reply-trigger" data-id="<?php echo e($comment->id); ?>" style="text-decoration: none; font-size: 0.7rem; line-height: 1;">Replay</a>
                <?php if($comment->user_id == auth()->id()): ?>
                    <a href="javascript:void(0)" class="text-muted small fw-bold edit-trigger" data-id="<?php echo e($comment->id); ?>" style="text-decoration: none; font-size: 0.7rem; line-height: 1;">Edit</a>
                    <form action="<?php echo e(route('comments.destroy', $comment->id)); ?>" method="POST" class="d-inline-flex" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-muted small fw-bold border-0 bg-transparent p-0 m-0" style="text-decoration: none; font-size: 0.7rem; line-height: 1;">Delete</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Edit Form -->
    <?php if(auth()->check() && $comment->user_id == auth()->id()): ?>
        <div class="edit-form mt-1 d-none" id="edit-form-<?php echo e($comment->id); ?>">
            <form action="<?php echo e(route('comments.update', $comment->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="position-relative">
                    <input type="text" name="body" value="<?php echo e($comment->body); ?>" class="form-control px-2" 
                           style="border: 1px solid #ccc; border-radius: 4px; height: 32px; font-size: 0.8rem;" 
                           placeholder="Edit comment...">
                    <button type="submit" class="btn position-absolute end-0 top-50 translate-middle-y me-1 p-0" style="background: transparent; border: none;">
                        <i class="bi bi-check-circle-fill text-orange fs-6"></i>
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- Reply Form -->
    <div class="reply-form mt-1 d-none" id="reply-form-<?php echo e($comment->id); ?>">
        <form action="<?php echo e(route('comments.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="post_id" value="<?php echo e($post->id); ?>">
            <input type="hidden" name="parent_id" value="<?php echo e($comment->id); ?>">
            <div class="position-relative">
                <input type="text" name="body" class="form-control px-2" 
                       style="border: 1px solid #ccc; border-radius: 4px; height: 32px; font-size: 0.8rem;" 
                       placeholder="Reply...">
                <button type="submit" class="btn position-absolute end-0 top-50 translate-middle-y me-1 p-0" style="background: transparent; border: none;">
                    <i class="bi bi-send-fill text-orange fs-6" style="transform: rotate(45deg);"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Recursive Replies -->
    <?php if($comment->replies->count() > 0): ?>
        <div class="replies-container ps-2 mt-1 border-start" style="border-left: 1px solid #eee !important;">
            <?php $__currentLoopData = $comment->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('frontend.include.comment', ['comment' => $reply], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/frontend/include/comment.blade.php ENDPATH**/ ?>