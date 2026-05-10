<?php $__env->startSection('title', 'Post List'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .post-table-container {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    .post-header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .search-filter-group {
        display: flex;
        gap: 15px;
        align-items: center;
    }
    .search-input-wrapper {
        position: relative;
    }
    .search-input-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #333;
        font-size: 1.1rem;
    }
    .search-input {
        border: 1px solid #777;
        border-radius: 20px;
        padding: 6px 15px 6px 35px;
        outline: none;
        width: 220px;
        font-size: 0.95rem;
    }
    .status-select {
        border: 1px solid #777;
        border-radius: 6px;
        padding: 6px 30px 6px 10px;
        outline: none;
        background-color: white;
        font-size: 0.95rem;
        cursor: pointer;
    }
    .reset-btn {
        background-color: #8f959e;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 6px 15px;
        text-decoration: none;
        font-size: 0.95rem;
    }
    .reset-btn:hover {
        background-color: #798089;
        color: white;
    }
    .new-post-btn {
        background-color: #ff5c5c;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 20px;
        font-weight: 500;
        text-decoration: none;
        font-size: 0.95rem;
    }
    .new-post-btn:hover {
        background-color: #e64a4a;
        color: white;
    }
    .post-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }
    .post-table th {
        background-color: #ff5c5c;
        color: white;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        border: none;
    }
    .post-table td {
        padding: 12px 15px;
        vertical-align: middle;
        border: none;
    }
    .post-table tr:nth-child(even) {
        background-color: #e8f4f8; /* Light cyan-blue */
    }
    .post-table tr:nth-child(odd) {
        background-color: #ffffff;
    }
    .post-table th.text-center, .post-table td.text-center {
        text-align: center;
    }
    .post-title-text {
        font-size: 1.05rem;
        color: #444;
        margin-bottom: 2px;
    }
    .post-slug {
        display: block;
        color: #ff5c5c;
        font-style: italic;
        font-size: 0.9rem;
    }
    .status-published {
        color: #00b300;
        font-weight: 700;
    }
    .status-draft {
        color: #ff5c5c;
        font-weight: 700;
    }
    .action-icons {
        display: flex;
        gap: 15px;
        justify-content: center;
        align-items: center;
    }
    .action-icons a, .action-icons button {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-size: 1.3rem;
        text-decoration: none;
    }
    .icon-view { color: #0088cc; }
    .icon-edit { color: #5a6268; }
    .icon-delete { color: #ff5c5c; }
    
    .thumbnail-img {
        width: 60px;
        height: 45px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    .thumbnail-placeholder {
        width: 60px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #b771e5;
        color: #b771e5;
        background-color: transparent;
        font-size: 1.5rem;
        border-radius: 3px;
    }
    
    .pagination-wrapper .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
        gap: 5px;
    }
    .pagination-wrapper .page-link {
        color: #ff5c5c;
        border: none;
        background: transparent;
        font-size: 1.2rem;
        padding: 5px 10px;
    }
    .pagination-wrapper .page-item.active .page-link {
        background: transparent;
        color: #ff5c5c;
        font-weight: bold;
    }
    .pagination-wrapper .page-item.disabled .page-link {
        color: #ffaaaa;
        background: transparent;
    }
</style>

<div class="container-fluid post-table-container">
    <h3 class="mb-4" style="color: #333; font-weight: 500;">Post List</h3>

    <div class="post-header-top">
        <form action="<?php echo e(route('admin.posts')); ?>" method="GET" class="search-filter-group m-0">
            <div class="search-input-wrapper">
                <i class="ti ti-search"></i>
                <input type="text" name="search" class="search-input" value="<?php echo e(request('search')); ?>">
            </div>
            <select name="status" class="status-select">
                <option value="">Status</option>
                <option value="published" <?php echo e(request('status') == 'published' ? 'selected' : ''); ?>>Published</option>
                <option value="draft" <?php echo e(request('status') == 'draft' ? 'selected' : ''); ?>>Draft</option>
            </select>
            <a href="<?php echo e(route('admin.posts')); ?>" class="reset-btn">Reset</a>
        </form>

        <a href="<?php echo e(route('admin.posts.create')); ?>" class="new-post-btn">+New Post</a>
    </div>

    <table class="post-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Thumbnail</th>
                <th>Title</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td>#<?php echo e(str_pad($post->id, 2, '0', STR_PAD_LEFT)); ?></td>
                <td>
                    <?php 
                        $gallery = is_string($post->feature_gallery) ? json_decode($post->feature_gallery, true) : $post->feature_gallery;
                        $firstImg = is_array($gallery) && count($gallery) > 0 ? $gallery[0] : null;
                        if ($firstImg && !Str::startsWith($firstImg, ['http://', 'https://'])) {
                            $path = ltrim($firstImg, '/');
                            $firstImg = Str::startsWith($path, 'storage/') ? asset($path) : asset('storage/' . $path);
                        }
                    ?>
                    <?php if($firstImg): ?>
                        <img src="<?php echo e($firstImg); ?>" class="thumbnail-img" alt="Thumbnail">
                    <?php else: ?>
                        <div class="thumbnail-placeholder"><i class="ti ti-photo"></i></div>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="post-title-text"><?php echo e($post->title); ?></div>
                    <span class="post-slug"><?php echo e($post->slug); ?></span>
                </td>
                <td>
                    <?php if($post->status == 'published'): ?>
                        <span class="status-published">Published</span>
                    <?php else: ?>
                        <span class="status-draft">Draft</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <div class="action-icons">
                        <a href="<?php echo e(route('blog.show', $post->slug)); ?>" target="_blank" class="icon-view" title="View"><i class="ti ti-eye"></i></a>
                        <a href="<?php echo e(route('admin.posts.edit', $post->id)); ?>" class="icon-edit" title="Edit"><i class="ti ti-edit"></i></a>
                        <button type="button" class="icon-delete delete-post" data-id="<?php echo e($post->id); ?>" data-url="<?php echo e(route('admin.posts.destroy', $post->id)); ?>" title="Delete"><i class="ti ti-trash"></i></button>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" class="text-center py-4 text-muted">No posts found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if($posts->hasPages()): ?>
    <div class="pagination-wrapper">
        <?php echo e($posts->links('pagination::bootstrap-4')); ?>

    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    $('.delete-post').on('click', function() {
        const id = $(this).data('id');
        const deleteUrl = $(this).data('url');
        Swal.fire({
            title: 'Are you sure?',
            text: "This post will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff5c5c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    method: 'POST',
                    data: { _token: '<?php echo e(csrf_token()); ?>', _method: 'DELETE' },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Deleted!', res.message, 'success').then(() => location.reload());
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message ?? 'Could not delete post.', 'error');
                    }
                });
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/pages/post_index.blade.php ENDPATH**/ ?>