<?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $lastMsg = $user->last_message;
        $timeStr = $lastMsg ? (\Carbon\Carbon::parse($lastMsg->created_at)->isToday() ? \Carbon\Carbon::parse($lastMsg->created_at)->format('g:i A') : (\Carbon\Carbon::parse($lastMsg->created_at)->isYesterday() ? 'Yesterday' : \Carbon\Carbon::parse($lastMsg->created_at)->format('l'))) : '';
        $msgText = $lastMsg ? ($lastMsg->message ?: ($lastMsg->file_name ?: 'Attachment')) : '';
        $isOut = $lastMsg && $lastMsg->sender_id === auth()->id();
    ?>

<button class="list-group-item list-group-item-action p-3 border-0 border-bottom select-user user-item" 
        data-id="<?php echo e($user->id); ?>" 
        data-name="<?php echo e($user->name); ?>" 
        data-unread="<?php echo e($user->unread_count > 0 ? 'true' : 'false'); ?>"
        data-image="<?php echo e($user->profile_image ? asset('storage/'.$user->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name)); ?>">
    
    <div class="d-flex align-items-center gap-3">
        <img src="<?php echo e($user->profile_image ? asset('storage/'.$user->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name)); ?>" 
             class="rounded-circle object-fit-cover" width="48" height="48">
        
        <div class="flex-grow-1 overflow-hidden">
            <div class="d-flex justify-content-between align-items-baseline mb-1">
                <h6 class="mb-0 text-truncate <?php echo e($user->unread_count > 0 ? 'fw-bold text-dark' : 'text-dark'); ?>" style="font-size: 1.05rem;"><?php echo e($user->name); ?></h6>
                <span class="small <?php echo e($user->unread_count > 0 ? 'text-success fw-bold' : 'text-muted'); ?>" style="font-size: 0.75rem;"><?php echo e($timeStr); ?></span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0 small text-muted text-truncate pe-2" style="font-size: 0.85rem;">
                    <?php if($lastMsg): ?>
                        <?php if($isOut): ?>
                            <span class="<?php echo e($lastMsg->is_read ? 'text-info' : 'text-muted'); ?>" style="font-size: 0.9rem;">
                                <?php echo $lastMsg->is_read ? '&#10003;&#10003;' : '&#10003;'; ?>

                            </span> 
                        <?php endif; ?>
                        <?php echo e(Str::limit($msgText, 40)); ?>

                    <?php else: ?>
                        <span class="fst-italic text-black-50">No messages yet</span>
                    <?php endif; ?>
                </p>
                <?php if($user->unread_count > 0): ?>
                    <span class="badge rounded-pill bg-success text-white d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 0.7rem;"><?php echo e($user->unread_count); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</button>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div class="p-4 text-center text-muted">No active conversations.</div>
<?php endif; ?>
<?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/components/chat_sidebar_items.blade.php ENDPATH**/ ?>