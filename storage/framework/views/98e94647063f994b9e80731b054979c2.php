<?php $__env->startSection('title', 'Home Page Settings'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Home Page Settings</h4>
                    <p class="mb-3">Configure your hero section background and call-to-action buttons</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
                <a href="<?php echo e(route('page')); ?>" class="btn btn-light btn-sm px-3 border shadow-sm">
                    <i class="ti ti-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <form id="homeSettingsForm" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            
            <div class="hs-card mb-4">
                <p class="hs-section-label">Background</p>

                <div class="row align-items-start g-4">
                    
                    <div class="col-md-3">
                        
                        <div class="hs-mode-group mb-3">
                            <span class="hs-mode-badge">Mode</span>
                            <select class="hs-mode-select" name="mode" id="bgMode">
                                <option value="single" <?php echo e($homeSettings->mode == 'single' ? 'selected' : ''); ?>>Single Image
                                </option>
                                <option value="slider" <?php echo e($homeSettings->mode == 'slider' ? 'selected' : ''); ?>>Slider</option>
                                <option value="video" <?php echo e($homeSettings->mode == 'video' ? 'selected' : ''); ?>>Video</option>
                            </select>
                        </div>

                        
                        <div id="uploadTriggerBox"
                            class="hs-upload-trigger <?php echo e($homeSettings->mode == 'video' ? 'd-none' : ''); ?>"
                            onclick="document.getElementById('homeImagesInput').click()">
                            <i class="ti ti-camera-plus"></i>
                            <span>Image uploader</span>
                            <input type="file" id="homeImagesInput" name="home_images[]" multiple class="d-none"
                                accept="image/*">
                        </div>

                        
                        <div id="videoUrlSection" style="<?php echo e($homeSettings->mode != 'video' ? 'display:none' : ''); ?>">
                            
                            <div class="hs-video-tabs mb-3">
                                <button type="button" id="videoTabUrl"
                                    class="hs-video-tab <?php echo e(($homeSettings->video_source ?? 'url') == 'url' ? 'active' : ''); ?>"
                                    onclick="switchVideoSource('url')">
                                    <i class="ti ti-link me-1"></i> Paste Link
                                </button>
                                <button type="button" id="videoTabFile"
                                    class="hs-video-tab <?php echo e(($homeSettings->video_source ?? 'url') == 'file' ? 'active' : ''); ?>"
                                    onclick="switchVideoSource('file')">
                                    <i class="ti ti-upload me-1"></i> Upload File
                                </button>
                            </div>
                            <input type="hidden" name="video_source" id="videoSourceInput"
                                value="<?php echo e($homeSettings->video_source ?? 'url'); ?>">

                            
                            <div id="videoPastePanel"
                                style="<?php echo e(($homeSettings->video_source ?? 'url') == 'file' ? 'display:none' : ''); ?>">
                                <div class="hs-mode-group">
                                    <span class="hs-mode-badge" style="font-size:0.75rem; padding: 7px 10px;">
                                        <i class="ti ti-brand-youtube"></i>
                                    </span>
                                    <input type="url" class="hs-mode-select border-0 ps-2" name="video_url"
                                        value="<?php echo e($homeSettings->video_url); ?>" placeholder="YouTube or Vimeo URL">
                                </div>
                            </div>

                            
                            <div id="videoFilePanel"
                                style="<?php echo e(($homeSettings->video_source ?? 'url') != 'file' ? 'display:none' : ''); ?>">
                                <div class="hs-upload-trigger" style="height:80px; flex-direction:row; gap:12px;"
                                    onclick="document.getElementById('videoFileInput').click()">
                                    <i class="ti ti-video" style="font-size:1.5rem;"></i>
                                    <div>
                                        <span id="videoFileName" class="d-block" style="font-size:0.82rem;">
                                            <?php echo e($homeSettings->video_file ? basename($homeSettings->video_file) : 'Click to upload a video (MP4, WebM)'); ?>

                                        </span>
                                        <?php if($homeSettings->video_file): ?>
                                            <small class="text-muted">Currently:
                                                <?php echo e(basename($homeSettings->video_file)); ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" id="videoFileInput" name="video_file" class="d-none"
                                        accept="video/mp4,video/webm,video/ogg">
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-md-9" id="imageGridSection"
                        style="<?php echo e($homeSettings->mode == 'video' ? 'display:none' : ''); ?>">
                        <div class="hs-image-grid" id="imagePreviewContainer">
                            <?php if($homeSettings->images): ?>
                                <?php $__currentLoopData = $homeSettings->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="hs-img-item" data-path="<?php echo e($img); ?>">
                                        <img src="<?php echo e(asset('storage/' . $img)); ?>" alt="BG">
                                        <button type="button" class="hs-remove-img" onclick="removeImage(this, '<?php echo e($img); ?>')">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="remove_images" id="removeImagesInput" value="">
                        <p class="text-muted small mt-2 mb-0"><i class="ti ti-info-circle"></i> Recommended: 1920×1080px,
                            max 2MB.</p>
                    </div>
                </div>
            </div>

            
            <div class="hs-card mb-4">
                <p class="hs-section-label">Action Buttons</p>

                <div id="buttonsContainer">
                    
                    <?php if($homeSettings->buttons): ?>
                        <?php $__currentLoopData = $homeSettings->buttons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $btn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="hs-btn-row dynamic-btn mb-3">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    
                                    <select name="button_types[]" class="hs-type-select"
                                        onchange="toggleBtnType(this, <?php echo e($index); ?>)">
                                        <option value="btn" <?php echo e(($btn['type'] ?? 'btn') == 'btn' ? 'selected' : ''); ?>>BTN</option>
                                        <option value="core" <?php echo e(($btn['type'] ?? '') == 'core' ? 'selected' : ''); ?>>CORE</option>
                                    </select>

                                    <input type="text" class="hs-btn-label-input flex-grow-1" name="button_labels[]"
                                        value="<?php echo e($btn['label']); ?>" placeholder="Label" style="min-width: 120px;">

                                    <div class="flex-grow-1 <?php echo e(($btn['type'] ?? 'btn') == 'core' ? '' : 'd-none'); ?> hs-cv-msg"
                                        id="cv_msg_<?php echo e($index); ?>">
                                        <div class="d-flex align-items-center bg-light rounded px-2"
                                            style="height: 38px; border: 1px solid #ddd;">
                                            <i class="ti ti-link me-2 text-muted small"></i>
                                            <span class="small text-muted text-truncate">Linked to Profile CV</span>
                                        </div>
                                    </div>

                                    <div class="flex-grow-1 <?php echo e(($btn['type'] ?? 'btn') == 'core' ? 'd-none' : ''); ?> hs-link-box"
                                        id="link_box_<?php echo e($index); ?>">
                                        <input type="text" class="hs-btn-link-input w-100" name="button_links[]"
                                            value="<?php echo e($btn['link']); ?>" placeholder="Link or Upload File" id="btn_link_<?php echo e($index); ?>"
                                            style="min-width: 150px;">
                                    </div>

                                    
                                    <div class="d-flex align-items-center gap-2 bg-white border rounded px-2 py-1">
                                        <div title="BG Color">
                                            <input type="color" name="button_bg_colors[]"
                                                class="form-control form-control-color border-0 p-0"
                                                value="<?php echo e($btn['bg_color'] ?? '#34b7a7'); ?>" style="width: 24px; height: 24px;">
                                        </div>
                                        <div title="Text Color">
                                            <input type="color" name="button_text_colors[]"
                                                class="form-control form-control-color border-0 p-0"
                                                value="<?php echo e($btn['text_color'] ?? '#ffffff'); ?>" style="width: 24px; height: 24px;">
                                        </div>
                                        <div class="form-check form-switch ms-1 mb-0">
                                            <input class="form-check-input" type="checkbox" name="button_outlines[]"
                                                value="<?php echo e($index); ?>" <?php echo e(($btn['outline'] ?? false) ? 'checked' : ''); ?>>
                                            <label class="form-check-label small" style="font-size: 0.7rem;">Outline</label>
                                        </div>
                                    </div>

                                    <label class="hs-btn-icon mb-0 <?php echo e(($btn['type'] ?? 'btn') == 'core' ? 'd-none' : ''); ?>"
                                        style="cursor: pointer;" title="Attach File" id="file_trigger_<?php echo e($index); ?>">
                                        <i class="ti ti-paperclip"></i>
                                        <input type="file" name="button_files[]" class="d-none"
                                            onchange="handleBtnFile(this, <?php echo e($index); ?>)">
                                    </label>

                                    <button type="button" class="hs-remove-btn" onclick="this.closest('.hs-btn-row').remove()">
                                        <i class="ti ti-x"></i>
                                    </button>
                                </div>
                                <div class="small text-muted mt-1 ms-5 ps-2 <?php echo e(empty($btn['file_path']) || ($btn['type'] ?? 'btn') == 'core' ? 'd-none' : ''); ?>"
                                    id="file_name_<?php echo e($index); ?>">
                                    <?php if(!empty($btn['file_path'])): ?> Attached: <?php echo e(basename($btn['file_path'])); ?> <?php endif; ?>
                                </div>
                                <input type="hidden" name="button_existing_files[]" value="<?php echo e($btn['file_path'] ?? ''); ?>">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-2 align-items-center">
                    <button type="button" class="hs-add-btn" onclick="addButton()">
                        <i class="ti ti-plus"></i> Add Button
                    </button>
                </div>
            </div>

            <div class="d-none">
                <input type="checkbox" name="show_cv_button" id="showCvButtonInput" <?php echo e($homeSettings->show_cv_button ? 'checked' : ''); ?>>
            </div>

            
            <div class="hs-card mb-4">
                <div class="hs-section-label">Typography & Appearance</div>

                <div class="row g-4">
                    
                    <div class="col-md-6 border-end">
                        <label class="form-label fw-bold small text-uppercase text-muted mb-3">Hero Title (Name)</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="small text-muted">Font Size (e.g. 48px)</label>
                                <input type="text" name="title_size" class="form-control form-control-sm"
                                    value="<?php echo e($homeSettings->title_size); ?>" placeholder="48px">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted">Text Color</label>
                                <input type="color" name="title_color"
                                    class="form-control form-control-sm form-control-color w-100"
                                    value="<?php echo e($homeSettings->title_color ?? '#ffffff'); ?>">
                            </div>
                            <div class="col-12 mt-2">
                                <label class="small text-muted">Font Family</label>
                                <input type="text" name="title_font" class="form-control form-control-sm"
                                    value="<?php echo e($homeSettings->title_font); ?>" placeholder="e.g. Poppins, sans-serif">
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-uppercase text-muted mb-3">Hero Subtitle (Title)</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="small text-muted">Font Size (e.g. 24px)</label>
                                <input type="text" name="subtitle_size" class="form-control form-control-sm"
                                    value="<?php echo e($homeSettings->subtitle_size); ?>" placeholder="24px">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted">Text Color</label>
                                <input type="color" name="subtitle_color"
                                    class="form-control form-control-sm form-control-color w-100"
                                    value="<?php echo e($homeSettings->subtitle_color ?? '#ffffff'); ?>">
                            </div>
                            <div class="col-12 mt-2">
                                <label class="small text-muted">Font Family</label>
                                <input type="text" name="subtitle_font" class="form-control form-control-sm"
                                    value="<?php echo e($homeSettings->subtitle_font); ?>" placeholder="e.g. Raleway, sans-serif">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="d-flex justify-content-end gap-3 mt-4 mb-5">
                <a href="<?php echo e(route('page')); ?>" class="hs-cancel-btn">Cancel</a>
                <button type="submit" class="hs-save-btn">
                    <i class="ti ti-device-floppy me-1"></i> Save Changes
                </button>
            </div>
        </form>
    </div>

    <style>
        .container-fluid {
            overflow-x: hidden;
        }

        .hs-btn-row {
            border: 1px solid #eee;
            padding: 12px;
            border-radius: 8px;
            background: #fafafa;
            width: 100%;
        }

        .hs-btn-label-box {
            padding: 4px 10px;
            border-radius: 4px;
            background: #E66239;
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* ── Card ── */
        .hs-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e8e8e8;
            padding: 24px;
        }

        .hs-section-label {
            font-size: 1rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 18px;
        }

        /* ── Mode Selector ── */
        .hs-mode-group {
            display: flex;
            align-items: stretch;
            border: 1px solid #ccc;
            border-radius: 6px;
            overflow: hidden;
        }

        .hs-mode-badge {
            background: #E66239;
            color: #fff;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 7px 12px;
            white-space: nowrap;
            display: flex;
            align-items: center;
        }

        .hs-mode-select {
            flex: 1;
            border: none;
            outline: none;
            padding: 7px 10px;
            font-size: 0.85rem;
            background: #fff;
            appearance: auto;
        }

        /* ── Upload Trigger ── */
        .hs-upload-trigger {
            border: 1.5px solid #ccc;
            border-radius: 10px;
            height: 140px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            color: #999;
            font-size: 0.82rem;
            transition: border-color 0.2s, background 0.2s;
        }

        .hs-upload-trigger i {
            font-size: 2rem;
        }

        .hs-upload-trigger:hover {
            border-color: #E66239;
            background: #fff8f6;
        }

        /* ── Image Grid ── */
        .hs-image-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .hs-img-item {
            position: relative;
            border: 1.5px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            aspect-ratio: 16/9;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #bbb;
            font-size: 0.78rem;
        }

        .hs-img-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hs-remove-img {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #ea4335;
            color: #fff;
            border: 2px solid #fff;
            font-size: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        /* ── Action Button Rows ── */
        .hs-btn-row {
            display: flex;
            align-items: stretch;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            overflow: hidden;
            background: #fff;
        }

        .hs-btn-label-box {
            background: #fff;
            border-right: 1.5px solid #ccc;
            padding: 6px 14px;
            font-size: 0.82rem;
            font-weight: 500;
            color: #444;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .hs-btn-label-input {
            border: none;
            border-right: 1.5px solid #ccc;
            outline: none;
            padding: 6px 10px;
            font-size: 0.82rem;
            width: 100px;
            background: #fff;
        }

        .hs-btn-link-input {
            border: none;
            border-right: 1.5px solid #ccc;
            outline: none;
            padding: 6px 10px;
            font-size: 0.82rem;
            flex: 1;
            min-width: 140px;
            background: #fff;
        }

        .hs-btn-icon {
            display: flex;
            align-items: center;
            padding: 0 10px;
            border-right: 1.5px solid #ccc;
            color: #E66239;
            font-size: 1rem;
        }

        .hs-remove-btn {
            background: transparent;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 10px;
            cursor: pointer;
        }

        .hs-remove-btn i {
            font-size: 1rem;
            color: #ea4335;
            background: #ea4335;
            color: #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

        /* ── Add Button ── */
        .hs-add-btn {
            border: 1.5px dashed #ccc;
            background: #fff;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 0.85rem;
            color: #666;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .hs-add-btn:hover {
            border-color: #E66239;
            color: #E66239;
            background-color: #fff8f6;
            transform: translateY(-1px);
        }

        /* ── Video Source Tabs ── */
        .hs-video-tabs {
            display: inline-flex;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            overflow: hidden;
        }

        .hs-video-tab {
            background: #fff;
            border: none;
            padding: 6px 18px;
            font-size: 0.82rem;
            color: #555;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        .hs-video-tab:not(:last-child) {
            border-right: 1.5px solid #ccc;
        }

        .hs-video-tab.active {
            background: #E66239;
            color: #fff;
            font-weight: 600;
        }

        .hs-video-tab:not(.active):hover {
            background: #fdf3f0;
            color: #E66239;
        }

        .hs-cancel-btn {
            border: 1px solid #ccc;
            background: #fff;
            border-radius: 6px;
            padding: 8px 28px;
            font-size: 0.85rem;
            color: #444;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .hs-save-btn {
            background: #E66239;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 32px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(230, 98, 57, 0.25);
            display: inline-flex;
            align-items: center;
        }

        .hs-save-btn:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(230, 98, 57, 0.35);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bgMode = document.getElementById('bgMode');
            const uploadTrigger = document.getElementById('uploadTriggerBox');
            const videoSection = document.getElementById('videoUrlSection');
            const imageGridSection = document.getElementById('imageGridSection');
            const homeImagesInput = document.getElementById('homeImagesInput');
            const previewContainer = document.getElementById('imagePreviewContainer');

            // Mode Change
            bgMode.addEventListener('change', function () {
                if (this.value === 'video') {
                    uploadTrigger.classList.add('d-none');
                    imageGridSection.style.display = 'none';
                    videoSection.style.display = 'block';
                } else {
                    uploadTrigger.classList.remove('d-none');
                    imageGridSection.style.display = 'block';
                    videoSection.style.display = 'none';
                }
            });

            // Image Preview
            homeImagesInput.addEventListener('change', function () {
                Array.from(this.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const div = document.createElement('div');
                        div.className = 'hs-img-item';
                        div.innerHTML = `
                                    <img src="${e.target.result}" alt="Preview">
                                    <button type="button" class="hs-remove-img" onclick="this.closest('.hs-img-item').remove()">
                                        <i class="ti ti-x"></i>
                                    </button>`;
                        previewContainer.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            });

            // AJAX Submit
            document.getElementById('homeSettingsForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const btn = this.querySelector('.hs-save-btn');
                const orig = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '...Saving';

                $.ajax({
                    url: "<?php echo e(route('admin.page.home.save')); ?>",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: res => {
                        btn.disabled = false;
                        btn.innerHTML = orig;
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Saved!', text: res.message, timer: 1500, showConfirmButton: false })
                                .then(() => location.reload());
                        }
                    },
                    error: xhr => {
                        btn.disabled = false;
                        btn.innerHTML = orig;
                        Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message ?? 'Something went wrong!' });
                    }
                });
            });
        });

        function removeImage(btn, path) {
            const input = document.getElementById('removeImagesInput');
            const arr = input.value ? input.value.split(',') : [];
            arr.push(path);
            input.value = arr.join(',');
            btn.closest('.hs-img-item').remove();
        }

        function switchVideoSource(source) {
            document.getElementById('videoSourceInput').value = source;

            const urlPanel = document.getElementById('videoPastePanel');
            const filePanel = document.getElementById('videoFilePanel');
            const tabUrl = document.getElementById('videoTabUrl');
            const tabFile = document.getElementById('videoTabFile');

            if (source === 'url') {
                urlPanel.style.display = 'block';
                filePanel.style.display = 'none';
                tabUrl.classList.add('active');
                tabFile.classList.remove('active');
            } else {
                urlPanel.style.display = 'none';
                filePanel.style.display = 'block';
                tabUrl.classList.remove('active');
                tabFile.classList.add('active');
            }
        }

        // Video file name display (wired here, outside DOMContentLoaded for safety)
        document.addEventListener('DOMContentLoaded', function () {
            const videoFileInput = document.getElementById('videoFileInput');
            if (videoFileInput) {
                videoFileInput.addEventListener('change', function () {
                    const name = this.files[0] ? this.files[0].name : 'Click to upload a video (MP4, WebM)';
                    document.getElementById('videoFileName').textContent = name;
                });
            }
        });

        function toggleCvButton(show) {
            const box = document.getElementById('cvButtonBox');
            const input = document.getElementById('showCvButtonInput');
            const restoreBtn = document.getElementById('restoreCvBtn');
            box.classList.toggle('d-none', !show);
            input.checked = show;
            restoreBtn.classList.toggle('d-none', show);
        }

        function addButton() {
            const container = document.getElementById('buttonsContainer');
            const index = container.querySelectorAll('.hs-btn-row').length;
            const div = document.createElement('div');
            div.className = 'hs-btn-row dynamic-btn mb-3';
            div.innerHTML = `
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <select name="button_types[]" class="hs-type-select" onchange="toggleBtnType(this, ${index})">
                                <option value="btn">BTN</option>
                                <option value="core">CORE</option>
                            </select>

                            <input type="text" class="hs-btn-label-input flex-grow-1" name="button_labels[]" placeholder="Label" style="min-width: 120px;">

                            <div class="flex-grow-1 d-none hs-cv-msg" id="cv_msg_${index}">
                                <div class="d-flex align-items-center bg-light rounded px-2" style="height: 38px; border: 1px solid #ddd;">
                                    <i class="ti ti-link me-2 text-muted small"></i>
                                    <span class="small text-muted text-truncate">Linked to Profile CV</span>
                                </div>
                            </div>

                            <div class="flex-grow-1 hs-link-box" id="link_box_${index}">
                                <input type="text" class="hs-btn-link-input w-100" name="button_links[]" placeholder="Link or Upload File" id="btn_link_${index}" style="min-width: 150px;">
                            </div>

                            
                            <div class="d-flex align-items-center gap-2 bg-white border rounded px-2 py-1">
                                <div title="BG Color">
                                    <input type="color" name="button_bg_colors[]" class="form-control form-control-color border-0 p-0" 
                                           value="#34b7a7" style="width: 24px; height: 24px;">
                                </div>
                                <div title="Text Color">
                                    <input type="color" name="button_text_colors[]" class="form-control form-control-color border-0 p-0" 
                                           value="#ffffff" style="width: 24px; height: 24px;">
                                </div>
                                <div class="form-check form-switch ms-1 mb-0">
                                    <input class="form-check-input" type="checkbox" name="button_outlines[]" value="${index}">
                                    <label class="form-check-label small" style="font-size: 0.7rem;">Outline</label>
                                </div>
                            </div>

                            <label class="hs-btn-icon mb-0" style="cursor: pointer;" title="Attach File" id="file_trigger_${index}">
                                <i class="ti ti-paperclip"></i>
                                <input type="file" name="button_files[]" class="d-none" onchange="handleBtnFile(this, ${index})">
                            </label>

                            <button type="button" class="hs-remove-btn" onclick="this.closest('.hs-btn-row').remove()">
                                <i class="ti ti-x"></i>
                            </button>
                        </div>
                        <div class="small text-muted mt-1 ms-5 ps-2 d-none" id="file_name_${index}"></div>
                    `;
            container.appendChild(div);
        }

        function toggleBtnType(select, index) {
            const isCore = select.value === 'core';
            document.getElementById(`cv_msg_${index}`).classList.toggle('d-none', !isCore);
            document.getElementById(`link_box_${index}`).classList.toggle('d-none', isCore);
            document.getElementById(`file_trigger_${index}`).classList.toggle('d-none', isCore);
            if (isCore) {
                document.getElementById(`file_name_${index}`).classList.add('d-none');
            }
        }

        function handleBtnFile(input, index) {
            const fileNameBox = document.getElementById(`file_name_${index}`);
            const linkInput = document.getElementById(`btn_link_${index}`);
            if (input.files && input.files[0]) {
                fileNameBox.textContent = "Attached: " + input.files[0].name;
                fileNameBox.classList.remove('d-none');
                linkInput.placeholder = "File attached (overrides link)";
                linkInput.value = ""; // Clear link if file is selected
            }
        }
    </script>

    <style>
        .hs-type-select {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 8px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #eee;
            cursor: pointer;
            outline: none;
        }

        .hs-type-select:focus {
            border-color: #E66239;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/pages/home_settings.blade.php ENDPATH**/ ?>