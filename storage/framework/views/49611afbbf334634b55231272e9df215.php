<?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr id="message-row-<?php echo e($msg->id); ?>" style="<?php echo e(!$msg->is_read ? 'background-color: #fff5f5;' : ''); ?>">
    <td class="ps-4">
        <div class="d-flex align-items-center gap-2">
            <?php if($msg->type == 'user'): ?>
                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="ti ti-message-circle fs-5"></i>
                </div>
            <?php else: ?>
                <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="ti ti-mail fs-5"></i>
                </div>
            <?php endif; ?>
            <div>
                <div class="fw-bold text-dark" style="font-size: 0.85rem;"><?php echo e($msg->name); ?></div>
                <div class="text-muted" style="font-size: 0.75rem;"><?php echo e($msg->email); ?></div>
            </div>
        </div>
    </td>
    <td>
        <div class="fw-bold <?php echo e($msg->type == 'user' ? 'text-primary' : 'text-danger'); ?>" style="font-size: 0.85rem;">
            <?php echo e($msg->subject); ?>

            <?php if($msg->type == 'user'): ?>
                <span class="badge bg-primary-subtle text-primary ms-1" style="font-size: 0.6rem;">Messenger</span>
            <?php endif; ?>
        </div>
    </td>
    <td>
        <div class="text-muted text-wrap" style="max-width: 300px; font-size: 0.8rem;">
            <?php echo e(Str::limit($msg->message, 100)); ?>

        </div>
    </td>
    <td class="text-center">
        <span class="badge <?php echo e($msg->is_read ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'); ?>" style="font-size: 0.7rem;">
            <?php echo e($msg->is_read ? 'Read' : 'Unread'); ?>

        </span>
    </td>
    <td class="text-center">
        <div class="fw-bold" style="font-size: 0.85rem;"><?php echo e(\Carbon\Carbon::parse($msg->created_at)->format('d M, Y')); ?></div>
        <div class="text-muted" style="font-size: 0.75rem;"><?php echo e(\Carbon\Carbon::parse($msg->created_at)->format('h:i A')); ?></div>
    </td>
    <td class="pe-4 text-end">
        <?php if($msg->type == 'user'): ?>
            <a href="<?php echo e(route('admin.chats')); ?>?user=<?php echo e($msg->user_id); ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                Open Chat
            </a>
        <?php else: ?>
            <button class="btn btn-light btn-sm rounded-pill px-3 view-message" 
                    data-id="<?php echo e($msg->id); ?>" 
                    data-name="<?php echo e($msg->name); ?>" 
                    data-email="<?php echo e($msg->email); ?>" 
                    data-subject="<?php echo e($msg->subject); ?>" 
                    data-body="<?php echo e($msg->message); ?>">
                View
            </button>
        <?php endif; ?>
        
        <?php if($msg->type == 'guest'): ?>
        <button class="btn btn-light btn-sm rounded-circle delete-message ms-1" data-id="<?php echo e($msg->id); ?>">
            <i class="ti ti-trash text-danger"></i>
        </button>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
    <td colspan="6" class="text-center py-5 text-muted">No messages found.</td>
</tr>
<?php endif; ?>
<?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/pages/messages_list.blade.php ENDPATH**/ ?>