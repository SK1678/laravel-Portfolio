<?php $__env->startSection('title', 'Inquiries & Messages'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Messages</h2>
    <div class="d-flex align-items-center">
        <a href="<?php echo e(route('page')); ?>" class="btn btn-light btn-sm px-3 border shadow-sm">
            <i class="ti ti-arrow-left me-1"></i> Back
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Sender</th>
                        <th class="py-3">Subject</th>
                        <th class="py-3">Message Preview</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 text-center">Date</th>
                        <th class="pe-4 py-3 text-end">Action</th>
                    </tr>
                </thead>
                <tbody id="messages-table-body">
                    <?php echo $__env->make('admin.pages.messages_list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="pagination-container">
        <?php if($messages->hasPages()): ?>
        <div class="card-footer bg-white border-0 py-3">
            <?php echo e($messages->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<!-- View Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 bg-danger text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="modalSubject">Message Subject</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="text-muted small text-uppercase fw-bold">From</label>
                    <div id="modalSender" class="fw-bold text-dark"></div>
                    <div id="modalEmail" class="text-danger small"></div>
                </div>
                <hr class="opacity-10">
                <div class="mb-0">
                    <label class="text-muted small text-uppercase fw-bold">Message</label>
                    <p id="modalBody" class="text-dark mt-2" style="white-space: pre-wrap; line-height: 1.6;"></p>
                </div>
            </div>
            <div class="modal-footer border-0 p-3">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                <a href="" id="replyBtn" class="btn btn-danger rounded-pill px-4">Reply via Email</a>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Polling for new messages
    function fetchMessages() {
        // Only fetch if not currently viewing a modal or typing (optional)
        if ($('#messageModal').is(':visible')) return;

        $.ajax({
            url: window.location.href,
            type: 'GET',
            success: function(data) {
                // We only want to update the table body to avoid jumping
                // However, the pagination might also need updating.
                // A better way is to compare content or count.
                const currentHtml = $('#messages-table-body').html();
                // Extract only the tbody content from the response
                const $response = $(data);
                // Wait, I returned the partial directly if AJAX!
                const newHtml = data; 
                
                if (currentHtml.trim() !== newHtml.trim()) {
                    $('#messages-table-body').html(newHtml);
                }
            }
        });
    }

    // Poll every 10 seconds
    setInterval(fetchMessages, 10000);

    // View Message
    $(document).on('click', '.view-message', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const email = $(this).data('email');
        const subject = $(this).data('subject');
        const body = $(this).data('body');
        
        $('#modalSubject').text(subject);
        $('#modalSender').text(name);
        $('#modalEmail').text(email);
        $('#modalBody').text(body);
        $('#replyBtn').attr('href', 'mailto:' + email + '?subject=Re: ' + subject);
        
        const myModal = new bootstrap.Modal(document.getElementById('messageModal'));
        myModal.show();

        // Mark as read via AJAX
        $.ajax({
            url: `<?php echo e(url('/dashboard/messages')); ?>/${id}/mark-as-read`,
            type: 'POST',
            data: { _token: '<?php echo e(csrf_token()); ?>' },
            success: function() {
                $(`#message-row-${id}`).css('background-color', 'transparent');
                $(`#message-row-${id} .badge`).removeClass('bg-danger-subtle text-danger').addClass('bg-success-subtle text-success').text('Read');
            }
        });
    });

    // Delete Message
    $(document).on('click', '.delete-message', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Delete Message?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `<?php echo e(url('/dashboard/messages')); ?>/${id}`,
                    type: 'DELETE',
                    data: { _token: '<?php echo e(csrf_token()); ?>' },
                    success: function() {
                        $(`#message-row-${id}`).fadeOut();
                        Swal.fire('Deleted!', 'Message removed.', 'success');
                    }
                });
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/pages/messages.blade.php ENDPATH**/ ?>