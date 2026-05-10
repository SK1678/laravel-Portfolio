<!--  -->

<?php $__env->startSection('title', isset($post) ? 'Edit Post' : 'New Post'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .post-form-container {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        color: #333;
        overflow-x: hidden;
    }
    .form-title {
        font-size: 1.5rem;
        font-weight: 500;
        margin-bottom: 20px;
        color: #000;
    }
    .custom-input {
        border: 2px solid #ccc;
        border-radius: 4px;
        padding: 8px 12px;
        width: 100%;
        margin-bottom: 15px;
        outline: none;
    }
    .custom-input:focus {
        border-color: #ff5c5c;
        font-style: italic;
    }
    .custom-input::placeholder {
        color: #999;
        font-style: italic;
    }
    .summernote-wrapper {
        margin-bottom: 15px;
        border: 2px solid #ccc;
    }
    /* Simple Toolbar styling */
    .note-editor.note-frame {
        border: none !important;
    }
    .excerpt-area {
        height: 80px;
        resize: none;
    }
    
    .attachment-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }
    .attachment-label {
        width: 100px;
        border: 2px solid #ccc;
        border-radius: 4px;
        padding: 5px;
    }
    .attachment-link-group {
        display: flex;
        border: 2px solid #ccc;
        border-radius: 4px;
        flex: 1;
        max-width: 250px;
        align-items: center;
    }
    .attachment-link-group input {
        border: none;
        padding: 5px;
        flex: 1;
        outline: none;
    }
    .attachment-link-group i {
        color: #ff5c5c;
        padding: 0 8px;
    }
    /* Toggle switch */
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.2em;
        cursor: pointer;
    }
    .form-switch .form-check-input:checked {
        background-color: #ff5c5c;
        border-color: #ff5c5c;
    }
    .attachment-password {
        border: 2px solid #ccc;
        border-radius: 4px;
        padding: 5px;
        width: 120px;
    }
    .remove-attachment {
        color: white;
        background-color: #ff5c5c;
        border: none;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
    }
    .more-link-btn {
        background-color: #ff5c5c;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 6px 15px;
        font-size: 0.9rem;
        cursor: pointer;
    }
    
    /* Right Column */
    .feature-gallery-box {
        border: 2px dashed #ff5c5c;
        border-radius: 6px;
        padding: 20px;
        text-align: center;
        color: #ff5c5c;
        cursor: pointer;
        margin-bottom: 10px;
        font-weight: 500;
    }
    .gallery-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }
    .gallery-item {
        position: relative;
        width: 80px;
        height: 80px;
        border: 1px solid #ff5c5c;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff5c5c;
        font-size: 0.8rem;
        text-align: center;
        background-size: cover;
        background-position: center;
    }
    .gallery-item span.placeholder-text {
        padding: 5px;
    }
    .gallery-item .remove-gallery {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: #ff5c5c;
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 10px;
        border: none;
    }
    
    .category-section {
        margin-bottom: 20px;
    }
    .category-title {
        font-weight: bold;
        margin-bottom: 10px;
    }
    .category-list {
        list-style: none;
        padding-left: 0;
    }
    .category-list ul {
        list-style: none;
        padding-left: 20px;
    }
    .category-item {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }
    .category-radio {
        appearance: none;
        width: 16px;
        height: 16px;
        border: 1px solid #ff5c5c;
        border-radius: 50%;
        margin-right: 8px;
        cursor: pointer;
    }
    .category-radio:checked {
        background-color: #ff5c5c;
        border-color: #ff5c5c;
    }
    .category-child-bullet {
        width: 10px;
        height: 10px;
        background-color: #ff5c5c;
        border-radius: 50%;
        margin-right: 8px;
        display: inline-block;
    }
    
    .tag-input-label {
        font-size: 0.8rem;
        color: #666;
        margin-bottom: 5px;
    }
    .tagify {
        border: none !important;
        padding: 0 !important;
        display: flex;
        flex-wrap: wrap;
    }
    .tagify__input {
        width: 100% !important;
        border: 2px solid #ccc !important;
        border-radius: 4px !important;
        padding: 8px 12px !important;
        margin: 0 0 5px 0 !important;
        order: -1;
    }
    .tagify__input:focus {
        border-color: #ff5c5c !important;
        font-style: italic;
        box-shadow: none !important;
    }
    /* Tagify Customization to match image */
    .tagify__tag {
        background-color: #f5cfcc !important;
        margin-top: 5px;
        margin-right: 5px;
    }
    .tagify__tag-text {
        color: #ff5c5c !important;
    }
    .tagify__tag__removeBtn {
        color: white !important;
        background-color: #ff5c5c !important;
        border-radius: 50% !important;
        transform: translate(50%, -50%) !important;
        top: 0 !important;
        right: 0 !important;
        margin: 0 !important;
        width: 16px;
        height: 16px;
        line-height: 14px;
    }
    
    .bottom-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-top: 30px;
    }
    .status-dropdown {
        border: 1px solid #ff5c5c;
        color: #ff5c5c;
        border-radius: 4px;
        padding: 5px 10px;
        outline: none;
        background: transparent;
    }
    .btn-save {
        background-color: #ff5c5c;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 6px 20px;
    }
    .btn-cancel {
        background-color: white;
        color: #666;
        border: 1px solid #ccc;
        border-radius: 4px;
</style>

<?php $__env->startPush('styles'); ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<div class="container-fluid post-form-container py-4">
    <div class="form-title">
        <?php echo e(isset($post) ? 'Edit Post' : 'New Post/ Edit Post'); ?>

    </div>

    <form id="postForm" action="<?php echo e(isset($post) ? route('admin.posts.update', $post->id) : route('admin.posts.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php if(isset($post)): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

        <div class="row">
            <div class="col-md-8">
                <input type="text" name="title" id="title" class="custom-input" placeholder="Post Title" value="<?php echo e(old('title', $post->title ?? '')); ?>" required>
                
                <input type="text" name="slug" id="slug" class="custom-input" placeholder="Post Slug [auto generated live according to title but editable]" value="<?php echo e(old('slug', $post->slug ?? '')); ?>" required>
                
                <div class="summernote-wrapper">
                    <textarea name="content" id="content_editor"><?php echo e(old('content', $post->content ?? '')); ?></textarea>
                </div>
                
                <textarea name="excerpt" class="custom-input excerpt-area" placeholder="Excerpt"><?php echo e(old('excerpt', $post->excerpt ?? '')); ?></textarea>
                
                <div id="attachments-container">
                    <?php
                        $attachments = old('attachments', isset($post) ? $post->attachments : []);
                        if (!is_array($attachments)) $attachments = [];
                    ?>
                    <?php $__currentLoopData = $attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="attachment-row">
                        <input type="text" name="attachments[<?php echo e($index); ?>][label]" class="attachment-label" placeholder="Label" value="<?php echo e($att['label'] ?? ''); ?>">
                        <div class="attachment-link-group">
                            <input type="text" name="attachments[<?php echo e($index); ?>][link]" placeholder="Link" value="<?php echo e($att['link'] ?? ''); ?>">
                            <i class="ti ti-upload direct-attachment-upload" title="Direct Upload" style="cursor:pointer;"></i>
                            <i class="ti ti-paperclip media-attachment-select" title="Select from Media Library" style="cursor:pointer;"></i>
                            <input type="file" class="d-none attachment-file-input" accept="*">
                        </div>
                        <div class="form-check form-switch m-0 ms-2">
                            <input class="form-check-input pwd-toggle" type="checkbox" name="attachments[<?php echo e($index); ?>][has_password]" value="1" <?php echo e(!empty($att['has_password']) ? 'checked' : ''); ?>>
                        </div>
                        <input type="text" name="attachments[<?php echo e($index); ?>][password]" class="attachment-password pwd-input <?php echo e(empty($att['has_password']) ? 'd-none' : ''); ?>" placeholder="Password" value="<?php echo e($att['password'] ?? ''); ?>">
                        <button type="button" class="remove-attachment"><i class="ti ti-x"></i></button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <button type="button" class="more-link-btn mt-2" id="addMoreLink">+ More Link</button>
            </div>
            
            <div class="col-md-4">
                <div class="feature-gallery-box d-flex flex-column align-items-center justify-content-center text-center p-3" style="min-height: 120px;">
                    <div id="directUploadBtn" style="cursor:pointer; font-weight: 500;">
                        <i class="ti ti-upload fs-2 mb-1"></i><br>
                        Feature Gallery uploader
                    </div>
                    <div class="text-muted my-1" style="font-size: 0.8rem;">or</div>
                    <div id="mediaLibraryBtn" style="color: #ff5c5c; cursor:pointer; font-size: 0.9rem;">
                        <i class="ti ti-link fs-2 mb-1"></i><br>Select from Media Library
                    </div>
                    <input type="file" id="galleryFileInput" multiple class="d-none" accept="image/*">
                </div>
                
                <div class="gallery-preview-container" id="galleryPreviewContainer">
                    <?php
                        $gallery = old('feature_gallery', isset($post) ? $post->feature_gallery : []);
                        if (is_string($gallery)) $gallery = json_decode($gallery, true);
                        if (!is_array($gallery)) $gallery = [];
                    ?>
                </div>
                
                <div class="category-section">
                    <div class="category-title">Select Category</div>
                    <ul class="category-list">
                        <?php if(!isset($categories) || $categories->isEmpty()): ?>
                        <li class="category-item">
                            <label class="d-flex align-items-center m-0" style="cursor: pointer;">
                                <input type="checkbox" name="categories[]" class="category-radio" value="1"> 
                                <span class="ms-2">Parent Category 1</span>
                            </label>
                        </li>
                        <li>
                            <ul class="list-unstyled ps-4">
                                <li class="category-item">
                                    <label class="d-flex align-items-center m-0" style="cursor: pointer;">
                                        <input type="checkbox" name="categories[]" class="category-radio" value="child1"> 
                                        <span class="ms-2">Child category 1</span>
                                    </label>
                                </li>
                                <li>
                                    <ul class="list-unstyled ps-4">
                                        <li class="category-item">
                                            <label class="d-flex align-items-center m-0" style="cursor: pointer;">
                                                <input type="checkbox" name="categories[]" class="category-radio" value="childn"> 
                                                <span class="ms-2">Child category n</span>
                                            </label>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="category-item">
                            <label class="d-flex align-items-center m-0" style="cursor: pointer;">
                                <input type="checkbox" name="categories[]" class="category-radio" value="2"> 
                                <span class="ms-2">Parent Category n</span>
                            </label>
                        </li>
                        <?php else: ?>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="category-item">
                                <label class="d-flex align-items-center m-0" style="cursor: pointer;">
                                    <input type="checkbox" name="categories[]" class="category-radio" value="<?php echo e($cat->id); ?>" 
                                        <?php echo e((is_array(old('categories')) && in_array($cat->id, old('categories'))) || (isset($post) && $post->categories->contains($cat->id)) ? 'checked' : ''); ?>> 
                                    <span class="ms-2"><?php echo e($cat->name); ?></span>
                                </label>
                            </li>
                                <?php if($cat->children && $cat->children->count()): ?>
                                <li>
                                    <ul class="list-unstyled ps-4">
                                    <?php $__currentLoopData = $cat->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="category-item">
                                            <label class="d-flex align-items-center m-0" style="cursor: pointer;">
                                                <input type="checkbox" name="categories[]" class="category-radio" value="<?php echo e($child->id); ?>"
                                                    <?php echo e((is_array(old('categories')) && in_array($child->id, old('categories'))) || (isset($post) && $post->categories->contains($child->id)) ? 'checked' : ''); ?>> 
                                                <span class="ms-2 text-muted"><?php echo e($child->name); ?></span>
                                            </label>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <div class="tag-input-label">Tags</div>
                <?php
                    $tagsData = '';
                    if(isset($post) && $post->tags) {
                        $tagsData = implode(',', $post->tags->pluck('name')->toArray());
                    } elseif (old('tags')) {
                        // Tagify output is usually JSON string or array, handle accordingly
                        $tagsData = is_array(old('tags')) ? implode(',', old('tags')) : old('tags');
                    }
                ?>
                <input name="tags" id="tagFilter" class="form-control" value="<?php echo e($tagsData); ?>">
                
                <div class="bottom-actions">
                    <select name="status" class="status-dropdown">
                        <option value="draft" <?php echo e(old('status', $post->status ?? '') == 'draft' ? 'selected' : ''); ?>>Draft</option>
                        <option value="published" <?php echo e(old('status', $post->status ?? '') == 'published' ? 'selected' : ''); ?>>Published</option>
                    </select>
                    <button type="submit" class="btn-save">Save</button>
                    <a href="<?php echo e(route('admin.posts')); ?>" class="btn-cancel btn btn-secondary rounded text-decoration-none">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Media Library Integration -->
<?php echo $__env->make('admin.include.media_manager_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script>
$(document).ready(function() {
    // Initialize Summernote
    $('#content_editor').summernote({
        placeholder: 'Live Text editor with image option where image can be resizable',
        tabsize: 2,
        height: 300,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
          ['fontname', ['fontname']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']],
          ['insert', ['link', 'picture', 'video', 'table', 'hr']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                for (let i = 0; i < files.length; i++) {
                    uploadSummernoteImage(files[i]);
                }
            }
        }
    });

    function uploadSummernoteImage(file) {
        let data = new FormData();
        data.append("file", file);
        data.append("_token", "<?php echo e(csrf_token()); ?>");
        $.ajax({
            url: "<?php echo e(route('admin.media.upload')); ?>",
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "POST",
            success: function(response) {
                if (response.success) {
                    var image = $('<img>').attr('src', response.url);
                    $('#content_editor').summernote("insertNode", image[0]);
                } else {
                    alert(response.message || 'Upload failed');
                }
            },
            error: function(err) {
                console.error("Upload error:", err);
                alert("Failed to upload image to server.");
            }
        });
    }

    // Title to Slug logic
    $('#title').on('keyup', function() {
        let title = $(this).val();
        let slug = title.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
        $('#slug').val(slug);
    });

    // Attachments Password Toggle
    $(document).on('change', '.pwd-toggle', function() {
        if($(this).is(':checked')) {
            $(this).closest('.attachment-row').find('.pwd-input').removeClass('d-none');
        } else {
            $(this).closest('.attachment-row').find('.pwd-input').addClass('d-none');
        }
    });

    // Remove Attachment
    $(document).on('click', '.remove-attachment', function() {
        $(this).closest('.attachment-row').remove();
    });

    // Add More Link
    let attachmentIndex = <?php echo e(count($attachments)); ?>;
    $('#addMoreLink').on('click', function() {
        const tpl = `
        <div class="attachment-row">
            <input type="text" name="attachments[${attachmentIndex}][label]" class="attachment-label" placeholder="Label">
            <div class="attachment-link-group">
                <input type="text" name="attachments[${attachmentIndex}][link]" placeholder="Link">
                <i class="ti ti-upload direct-attachment-upload" title="Direct Upload" style="cursor:pointer;"></i>
                <i class="ti ti-paperclip media-attachment-select" title="Select from Media Library" style="cursor:pointer;"></i>
                <input type="file" class="d-none attachment-file-input" accept="*">
            </div>
            <div class="form-check form-switch m-0 ms-2">
                <input class="form-check-input pwd-toggle" type="checkbox" name="attachments[${attachmentIndex}][has_password]" value="1">
            </div>
            <input type="text" name="attachments[${attachmentIndex}][password]" class="attachment-password pwd-input d-none" placeholder="Password">
            <button type="button" class="remove-attachment"><i class="ti ti-x"></i></button>
        </div>`;
        $('#attachments-container').append(tpl);
        attachmentIndex++;
    });

    // Tagify
    var tagInput = document.querySelector('#tagFilter');
    var tagify = new Tagify(tagInput, {
        delimiters: ",", // Explicitly define comma as delimiter
        whitelist: [],
        enforceWhitelist: false,
        maxTags: 10,
        dropdown: { maxItems: 20, enabled: 0 }
    });

    tagify.on('input', function(e) {
        var value = e.detail.value;
        if(value.length < 2) return;
        tagify.whitelist = null;
        tagify.loading(true);
        fetch("<?php echo e(route('admin.tags.fetch')); ?>?q=" + value)
            .then(res => res.json())
            .then(function(newWhitelist) {
                tagify.whitelist = newWhitelist;
                tagify.loading(false).dropdown.show(value);
            });
    });

    // Gallery Uploader Logic
    window.galleryImages = [];
    <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        galleryImages.push({ url: '<?php echo e(Str::startsWith($img, ["http", "/"]) ? $img : asset("storage/".$img)); ?>', path: '<?php echo e($img); ?>' });
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    window.renderGallery = function() {
        $('#galleryPreviewContainer').empty();
        galleryImages.forEach((img, index) => {
            let tpl = `
            <div class="gallery-item" style="background-image: url('${img.url}')">
                <input type="hidden" name="feature_gallery[]" value="${img.path}">
                <button type="button" class="remove-gallery" data-index="${index}"><i class="ti ti-x"></i></button>
            </div>`;
            $('#galleryPreviewContainer').append(tpl);
        });
    };
    
    // Initial Render
    renderGallery();

    $(document).on('click', '.remove-gallery', function() {
        if ($(this).closest('.dummy-gallery').length) {
            $(this).closest('.dummy-gallery').remove();
        } else {
            let idx = $(this).data('index');
            galleryImages.splice(idx, 1);
            renderGallery();
        }
    });

    $('#directUploadBtn').on('click', function() {
        $('#galleryFileInput').click();
    });

    $('#mediaLibraryBtn').on('click', function() {
        if (typeof openMediaManager === 'function') {
            openMediaManager(null, 'gallery');
        } else {
            Swal.fire('Error', 'Media manager not loaded', 'error');
        }
    });

    // Attachments Media Manager
    $(document).on('click', '.media-attachment-select', function() {
        let input = $(this).closest('.attachment-link-group').find('input[type="text"]');
        if (typeof openMediaManager === 'function') {
            openMediaManager(input);
        }
    });

    // Attachments Direct Upload
    $(document).on('click', '.direct-attachment-upload', function() {
        $(this).closest('.attachment-link-group').find('.attachment-file-input').click();
    });

    $(document).on('change', '.attachment-file-input', function() {
        const file = this.files[0];
        if (!file) return;

        let input = $(this).closest('.attachment-link-group').find('input[type="text"]');
        let formData = new FormData();
        formData.append('file', file);
        formData.append('_token', '<?php echo e(csrf_token()); ?>');

        $.ajax({
            url: '<?php echo e(route("admin.media.upload")); ?>',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    input.val(window.location.origin + '/storage/' + res.path).trigger('change');
                }
            },
            error: function() {
                Swal.fire('Error', 'File upload failed', 'error');
            }
        });
        $(this).val('');
    });

    $('#galleryFileInput').on('change', function() {
        const files = this.files;
        if (files.length === 0) return;

        for (let i = 0; i < files.length; i++) {
            let formData = new FormData();
            formData.append('file', files[i]);
            formData.append('_token', '<?php echo e(csrf_token()); ?>');

            $.ajax({
                url: '<?php echo e(route("admin.media.upload")); ?>',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.success) {
                        galleryImages.push({ url: res.url, path: res.path });
                        renderGallery();
                    }
                },
                error: function() {
                    Swal.fire('Error', 'File upload failed', 'error');
                }
            });
        }
        $(this).val(''); 
    });

    // Form submit AJAX
    $('#postForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let tags = tagify.value.map(t => t.value);
        formData.set('tags', JSON.stringify(tags));
        
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    Swal.fire('Success', res.message, 'success').then(() => {
                        window.location.href = res.redirect;
                    });
                }
            },
            error: function(xhr) {
                Swal.fire('Error', xhr.responseJSON?.message || 'Validation error', 'error');
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/pages/post_create.blade.php ENDPATH**/ ?>