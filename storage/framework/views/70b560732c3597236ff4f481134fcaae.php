<?php $__env->startSection('title', 'About Page Settings'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>About Page Settings</h4>
                    <p class="mb-3">Configure your career objective and personal details</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
                <a href="<?php echo e(route('page')); ?>" class="btn btn-light btn-sm px-3 border shadow-sm">
                    <i class="ti ti-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <form id="aboutSettingsForm" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                
                <div class="col-md-5">
                    <div class="hs-card mb-4">
                        <p class="hs-section-label">Section Headers</p>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Page Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo e($about->title ?? 'About'); ?>"
                                placeholder="e.g. About Me">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Section Subtitle</label>
                            <textarea name="subtitle" class="form-control" rows="2"
                                placeholder="Enter a brief subtitle..."><?php echo e($about->subtitle); ?></textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold">Objective Heading</label>
                            <input type="text" name="objective_title" class="form-control"
                                value="<?php echo e($about->objective_title ?? 'Career Summary'); ?>"
                                placeholder="e.g. Professional Profile">
                        </div>
                    </div>

                    <div class="hs-card mb-4">
                        <p class="hs-section-label">About Profile Image</p>
                        <div class="text-center mb-3">
                            <div class="position-relative d-inline-block">
                                <img id="aboutImagePreview"
                                    src="<?php echo e($about->image_path ? asset('storage/' . $about->image_path) : ($siteOwner->profile_image ? asset('storage/' . $siteOwner->profile_image) : asset('UI/assets/img/profile-img.jpg'))); ?>"
                                    alt="Profile" class="rounded shadow-sm"
                                    style="width: 240px; height: 280px; object-fit: cover; border: 4px solid #fff;">

                                <button type="button"
                                    class="btn btn-sm btn-primary position-absolute bottom-0 end-0 mb-2 me-2 shadow"
                                    onclick="document.getElementById('aboutImageInput').click()">
                                    <i class="ti ti-camera"></i> Change
                                </button>
                            </div>
                            <input type="file" name="about_image" id="aboutImageInput" class="d-none" accept="image/*">
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="alert('Media Library is coming soon!')">
                                <i class="ti ti-photo"></i> Select from Media
                            </button>
                        </div>
                    </div>

                    <div class="hs-card">
                        <p class="hs-section-label">Career Objective</p>
                        <textarea name="career_objective" class="form-control" rows="8"
                            placeholder="Enter your career objective..."><?php echo e($about->career_objective); ?></textarea>
                    </div>
                </div>

                
                <div class="col-md-7">
                    <div class="hs-card h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <p class="hs-section-label mb-0">Biometric Details</p>
                            <div class="d-flex gap-2">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="ti ti-user-circle"></i> Add From Profile
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="syncFromBasic()">Sync All Basic Info</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><h6 class="dropdown-header">Quick Add Field</h6></li>
                                        <?php
                                            $quickFields = [
                                                'Name' => $siteOwner->name,
                                                'Email' => $siteOwner->email,
                                                'Phone' => $siteOwner->phone,
                                                'Birthday' => $siteOwner->additional_info['birthday'] ?? '',
                                                'Nationality' => $siteOwner->additional_info['nationality'] ?? '',
                                                'Address' => $siteOwner->address ?? '',
                                                'GitHub' => $siteOwner->additional_info['github'] ?? '',
                                                'LinkedIn' => $siteOwner->additional_info['linkedin'] ?? '',
                                            ];
                                        ?>
                                        <?php $__currentLoopData = $quickFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($val): ?>
                                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="addField('<?php echo e($label); ?>', '<?php echo e($val); ?>', '<?php echo e(str_contains(strtolower($label), 'birthday') ? 'date' : 'text'); ?>')"><?php echo e($label); ?></a></li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addField()">
                                    <i class="ti ti-plus"></i> Add Field
                                </button>
                            </div>
                        </div>

                        <div id="detailsContainer" class="sortable-list">
                            <?php if($about->details && count($about->details) > 0): ?>
                                <?php $__currentLoopData = $about->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="hs-detail-row mb-3">
                                        <div class="d-flex align-items-center gap-2 border rounded p-2 bg-light">
                                            <div class="d-flex flex-column gap-1 sort-handle" style="cursor: move;">
                                                <i class="ti ti-chevron-up small text-muted" onclick="moveUp(this)"></i>
                                                <i class="ti ti-chevron-down small text-muted" onclick="moveDown(this)"></i>
                                            </div>
                                            <input type="text" name="labels[]" class="form-control form-control-sm w-25 hs-label-input"
                                                value="<?php echo e($item['label']); ?>" placeholder="Label" onfocus="showLabelPopup(this)">
                                            <input type="text" name="values[]" class="form-control form-control-sm flex-grow-1"
                                                value="<?php echo e($item['value']); ?>" placeholder="Value">
                                            <select name="types[]" class="form-select form-select-sm" style="width: 100px;">
                                                <option value="text" <?php echo e($item['type'] == 'text' ? 'selected' : ''); ?>>Text</option>
                                                <option value="date" <?php echo e($item['type'] == 'date' ? 'selected' : ''); ?>>Date</option>
                                                <option value="link" <?php echo e($item['type'] == 'link' ? 'selected' : ''); ?>>Link</option>
                                            </select>
                                            <button type="button" class="btn btn-sm btn-outline-danger px-2"
                                                onclick="this.closest('.hs-detail-row').remove()">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                
                                <div class="text-center text-muted py-5" id="noDetailsMsg">
                                    No details added yet. Click "Add From Profile" or "Add Field".
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 mb-5">
                <a href="<?php echo e(route('page')); ?>" class="hs-cancel-btn">Cancel</a>
                <button type="submit" class="hs-save-btn">Save About Settings</button>
            </div>
        </form>
    </div>

    <style>
        .hs-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #eee;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        .hs-section-label {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }

        .hs-detail-row:hover {
            border-color: #E66239;
        }

        .hs-save-btn {
            background: #E66239;
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 6px;
            font-weight: 600;
        }

        .hs-cancel-btn {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
            padding: 10px 25px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
        }

        .sort-handle i:hover {
            color: #E66239 !important;
        }

        /* ── Selection Popup (Custom Datalist) ── */
        .hs-label-popup {
            position: absolute;
            z-index: 1000;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            width: 320px;
            display: none;
            padding: 10px;
            border: 1px solid #eee;
        }

        .hs-popup-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6px;
            max-height: 200px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .hs-popup-item {
            padding: 8px 12px;
            font-size: 0.82rem;
            color: #444;
            cursor: pointer;
            border-radius: 6px;
            background: #f8f9fa;
            transition: all 0.2s;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            border: 1px solid transparent;
        }

        .hs-popup-item:hover {
            background: #E66239;
            color: #fff;
            border-color: #E66239;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(230, 98, 57, 0.2);
        }

        /* Custom scrollbar for popup */
        .hs-popup-grid::-webkit-scrollbar { width: 4px; }
        .hs-popup-grid::-webkit-scrollbar-track { background: #f1f1f1; }
        .hs-popup-grid::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
    </style>

    
    <div id="labelPopup" class="hs-label-popup">
        <div class="small text-muted mb-2 ps-1 fw-bold border-bottom pb-1">Select Label</div>
        <div id="popupGrid" class="hs-popup-grid">
            
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Image Preview
            document.getElementById('aboutImageInput').addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        document.getElementById('aboutImagePreview').src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // AJAX Submit
            document.getElementById('aboutSettingsForm').addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const btn = this.querySelector('.hs-save-btn');
                const orig = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="ti ti-loader rotate-infinite me-2"></i> Saving...';

                $.ajax({
                    url: "<?php echo e(route('admin.page.about.save')); ?>",
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

        function addField(label = '', value = '', type = 'text') {
            const container = document.getElementById('detailsContainer');
            const noMsg = document.getElementById('noDetailsMsg');
            if (noMsg) noMsg.remove();
            
            const div = document.createElement('div');
            div.className = 'hs-detail-row mb-3';
            div.innerHTML = `
                    <div class="d-flex align-items-center gap-2 border rounded p-2 bg-light">
                        <div class="d-flex flex-column gap-1 sort-handle" style="cursor: move;">
                            <i class="ti ti-chevron-up small text-muted" onclick="moveUp(this)"></i>
                            <i class="ti ti-chevron-down small text-muted" onclick="moveDown(this)"></i>
                        </div>
                        <input type="text" name="labels[]" class="form-control form-control-sm w-25 hs-label-input" value="${label}" placeholder="Label" onfocus="showLabelPopup(this)">
                        <input type="text" name="values[]" class="form-control form-control-sm flex-grow-1" value="${value}" placeholder="Value">
                        <select name="types[]" class="form-select form-select-sm" style="width: 100px;">
                            <option value="text" ${type === 'text' ? 'selected' : ''}>Text</option>
                            <option value="date" ${type === 'date' ? 'selected' : ''}>Date</option>
                            <option value="link" ${type === 'link' ? 'selected' : ''}>Link</option>
                        </select>
                        <button type="button" class="btn btn-sm btn-outline-danger px-2" onclick="this.closest('.hs-detail-row').remove()">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                `;
            container.appendChild(div);
        }

        const PROFILE_DATA = {
            'Name': <?php echo json_encode($siteOwner->name, 15, 512) ?>,
            'Email': <?php echo json_encode($siteOwner->email, 15, 512) ?>,
            'Phone': <?php echo json_encode($siteOwner->phone ?? '', 15, 512) ?>,
            'Address': <?php echo json_encode($siteOwner->address ?? '', 15, 512) ?>,
        };

        // Dynamically fetch and merge all items from "Personal Information Details"
        const personalDetails = <?php echo json_encode($siteOwner->additional_info['personal'] ?? [], 15, 512) ?>;
        if (Array.isArray(personalDetails)) {
            personalDetails.forEach(item => {
                if (item.label && item.value) {
                    // Use the label exactly as defined in the profile
                    PROFILE_DATA[item.label] = item.value;
                }
            });
        }

        function populatePopupGrid() {
            const grid = document.getElementById('popupGrid');
            grid.innerHTML = '';
            
            // Only show labels that have actual data
            for (const label in PROFILE_DATA) {
                if (PROFILE_DATA[label]) {
                    const item = document.createElement('div');
                    item.className = 'hs-popup-item';
                    item.onmousedown = function() { selectLabelOption(this); };
                    item.innerText = label;
                    grid.appendChild(item);
                }
            }
        }

        // Initialize grid
        document.addEventListener('DOMContentLoaded', populatePopupGrid);

        let currentLabelInput = null;

        function showLabelPopup(input) {
            currentLabelInput = input;
            const popup = document.getElementById('labelPopup');
            const rect = input.getBoundingClientRect();
            
            popup.style.display = 'block';
            popup.style.top = (rect.bottom + window.scrollY + 5) + 'px';
            popup.style.left = (rect.left + window.scrollX) + 'px';
        }

        // Hide popup when clicking outside
        document.addEventListener('mousedown', function(e) {
            const popup = document.getElementById('labelPopup');
            if (popup.style.display === 'block' && !popup.contains(e.target) && !e.target.classList.contains('hs-label-input')) {
                popup.style.display = 'none';
            }
        });

        function selectLabelOption(item) {
            if (currentLabelInput) {
                const label = item.innerText;
                currentLabelInput.value = label;
                handleLabelInput(currentLabelInput);
                document.getElementById('labelPopup').style.display = 'none';
            }
        }

        function handleLabelInput(input) {
            const label = input.value;
            const row = input.closest('.hs-detail-row');
            const valueInput = row.querySelector('input[name="values[]"]');
            const typeSelect = row.querySelector('select[name="types[]"]');

            if (PROFILE_DATA[label]) {
                valueInput.value = PROFILE_DATA[label];
                
                // Auto type detection
                const lower = label.toLowerCase();
                if (lower.includes('birthday') || lower.includes('date')) {
                    typeSelect.value = 'date';
                } else if (lower.includes('github') || lower.includes('linkedin') || lower.includes('website') || lower.includes('twitter')) {
                    typeSelect.value = 'link';
                } else {
                    typeSelect.value = 'text';
                }
            }
        }

        // Also trigger on manual input
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('hs-label-input')) {
                handleLabelInput(e.target);
            }
        });

        function syncFromBasic() {
            const basicInfo = {
                'Name': "<?php echo e($siteOwner->name); ?>",
                'Email': "<?php echo e($siteOwner->email); ?>",
                'Alt Email': "<?php echo e($siteOwner->additional_info['alt_email'] ?? ''); ?>",
                'Birthday': "<?php echo e($siteOwner->additional_info['birthday'] ?? ''); ?>",
                'Gender': "<?php echo e($siteOwner->additional_info['gender'] ?? ''); ?>",
                'Nationality': "<?php echo e($siteOwner->additional_info['nationality'] ?? ''); ?>",
                'Religion': "<?php echo e($siteOwner->additional_info['religion'] ?? ''); ?>",
                'NID No': "<?php echo e($siteOwner->additional_info['nid'] ?? ''); ?>",
                'Phone': "<?php echo e($siteOwner->phone ?? ''); ?>",
                'Address': "<?php echo e($siteOwner->address ?? ''); ?>"
            };

            const container = document.getElementById('detailsContainer');
            container.innerHTML = ''; // Clear existing

            for (const [label, value] of Object.entries(basicInfo)) {
                if (value) {
                    const type = label.toLowerCase().includes('date') || label.toLowerCase().includes('birthday') ? 'date' :
                        (label.toLowerCase().includes('email') ? 'text' : 'text');
                    addField(label, value, type);
                }
            }
        }

        function moveUp(btn) {
            const row = btn.closest('.hs-detail-row');
            if (row.previousElementSibling) {
                row.parentNode.insertBefore(row, row.previousElementSibling);
            }
        }

        function moveDown(btn) {
            const row = btn.closest('.hs-detail-row');
            if (row.nextElementSibling) {
                row.parentNode.insertBefore(row.nextElementSibling, row);
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/pages/about_settings.blade.php ENDPATH**/ ?>