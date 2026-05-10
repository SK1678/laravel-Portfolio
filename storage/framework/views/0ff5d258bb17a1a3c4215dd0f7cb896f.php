<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">General Settings</h1>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-pills custom-tabs mb-3" id="settingsTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="general-tab" data-bs-toggle="pill" data-bs-target="#general"
                    type="button" role="tab">General</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="seo-tab" data-bs-toggle="pill" data-bs-target="#seo" type="button"
                    role="tab">SEO</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="email-tab" data-bs-toggle="pill" data-bs-target="#email" type="button"
                    role="tab">Email Server</button>
            </li>
        </ul>

        <div class="tab-content" id="settingsTabsContent">
            <!-- General Tab -->
            <div class="tab-pane fade show active" id="general" role="tabpanel">
                <div class="card border-0 p-3">
                    <form id="generalSettingsForm" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row g-3">
                            <!-- Logo & Favicon -->
                            <div class="col-md-4 text-center border-end">
                                <div class="px-2">
                                    <!-- Logo Type Toggle -->
                                    <div class="btn-group btn-group-sm w-100 mb-3" role="group">
                                        <input type="radio" class="btn-check" name="logo_type" id="logoTypeText" value="text" <?php echo e(($siteSettings->logo_type ?? 'text') == 'text' ? 'checked' : ''); ?>>
                                        <label class="btn btn-outline-accent" for="logoTypeText"><i class="ti ti-typography"></i> Text Logo</label>
                                        
                                        <input type="radio" class="btn-check" name="logo_type" id="logoTypeImage" value="image" <?php echo e(($siteSettings->logo_type ?? 'text') == 'text' ? '' : 'checked'); ?>>
                                        <label class="btn btn-outline-accent" for="logoTypeImage"><i class="ti ti-photo"></i> Image Logo</label>
                                    </div>

                                    <!-- Logo Text Input -->
                                    <div id="logoTextInputBox" class="mb-3" style="<?php echo e(($siteSettings->logo_type ?? 'text') == 'image' ? 'display:none' : ''); ?>">
                                        <div class="input-group-custom shadow-sm">
                                            <span class="input-group-text p-1 px-2" style="min-width: 80px;">Text</span>
                                            <input type="text" class="form-control p-1 px-2" name="logo_text" value="<?php echo e($siteSettings->logo_text ?? ''); ?>" placeholder="Navbar Logo Text">
                                        </div>
                                    </div>

                                    <!-- Logo Image Upload -->
                                    <div id="logoUploadBox" class="logo-upload-box shadow-sm mb-3" style="<?php echo e(($siteSettings->logo_type ?? 'text') == 'text' ? 'display:none' : ''); ?>">
                                        <?php if(isset($siteSettings) && $siteSettings->logo_image): ?>
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 p-0 px-1 remove-logo-btn" style="z-index: 10;" title="Remove Logo">
                                                <i class="ti ti-x fs-6"></i>
                                            </button>
                                            <input type="hidden" name="remove_logo" id="removeLogoInput" value="0">
                                        <?php endif; ?>
                                        
                                        <div class="preview-area" id="logoPreview">
                                            <?php if(isset($siteSettings) && $siteSettings->logo_image): ?>
                                                <img src="<?php echo e(asset('storage/' . $siteSettings->logo_image)); ?>" alt="Logo">
                                            <?php else: ?>
                                                <div class="text-center">
                                                    <i class="ti ti-photo-up fs-2 text-muted"></i>
                                                    <span class="d-block text-muted x-small mt-1">Logo</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="upload-options-overlay">
                                            <button type="button" class="btn btn-primary" onclick="openMediaManager('logoImagePath', 'logoPreview')">
                                                <i class="ti ti-library"></i> Select
                                            </button>
                                            <label for="logoInput" class="btn btn-secondary mb-0">
                                                <i class="ti ti-upload"></i> Upload
                                            </label>
                                        </div>
                                        
                                        <input type="file" id="logoInput" name="logo_image" hidden accept="image/*">
                                        <input type="hidden" name="logo_image_path" id="logoImagePath">
                                    </div>

                                    <hr class="my-3 opacity-25">

                                    <!-- Favicon Upload -->
                                    <div class="text-start mb-1">
                                        <label class="x-small fw-bold text-muted">Browser Favicon</label>
                                    </div>
                                    <div class="favicon-upload-box shadow-sm mx-auto">
                                        <?php if(isset($siteSettings) && $siteSettings->favicon): ?>
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-0 p-0 px-1 remove-favicon-btn" style="z-index: 10; font-size: 10px;" title="Remove Favicon">
                                                <i class="ti ti-x"></i>
                                            </button>
                                            <input type="hidden" name="remove_favicon" id="removeFaviconInput" value="0">
                                        <?php endif; ?>
                                        
                                        <div class="preview-area" id="faviconPreview">
                                            <?php if(isset($siteSettings) && $siteSettings->favicon): ?>
                                                <img src="<?php echo e(asset('storage/' . $siteSettings->favicon)); ?>" alt="Favicon">
                                            <?php else: ?>
                                                <div class="text-center">
                                                    <i class="ti ti-upload fs-4 text-muted"></i>
                                                    <span class="d-block text-muted" style="font-size: 0.6rem;">Favicon</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="upload-options-overlay mini">
                                            <button type="button" title="Select from Media" onclick="openMediaManager('faviconPath', 'faviconPreview')">
                                                <i class="ti ti-library"></i>
                                            </button>
                                            <label for="faviconInput" title="Upload New" class="mb-0">
                                                <i class="ti ti-upload"></i>
                                            </label>
                                        </div>
                                        
                                        <input type="file" id="faviconInput" name="favicon" hidden accept="image/x-icon,image/png">
                                        <input type="hidden" name="favicon_path" id="faviconPath">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group-custom mb-2">
                                    <span class="input-group-text">Site Title</span>
                                    <input type="text" class="form-control" name="site_title" value="<?php echo e($siteSettings->site_title ?? ''); ?>">
                                </div>
                                <div class="input-group-custom mb-2">
                                    <span class="input-group-text">Time Zone</span>
                                    <select class="form-select" name="time_zone">
                                        <option value="UTC +06:00" <?php echo e(($siteSettings->time_zone ?? '') == 'UTC +06:00' ? 'selected' : ''); ?>>UTC +06:00</option>
                                        <option value="UTC +00:00" <?php echo e(($siteSettings->time_zone ?? '') == 'UTC +00:00' ? 'selected' : ''); ?>>UTC +00:00</option>
                                    </select>
                                </div>
                                <div class="input-group-custom mb-2">
                                    <span class="input-group-text">Contact Mail</span>
                                    <input type="email" class="form-control" name="contact_mail" value="<?php echo e($siteSettings->contact_mail ?? ''); ?>">
                                </div>
                                <div class="input-group-custom">
                                    <span class="input-group-text">Address</span>
                                    <input type="text" class="form-control" name="address" value="<?php echo e($siteSettings->address ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group-custom mb-2">
                                    <span class="input-group-text">Default Font</span>
                                    <input type="text" class="form-control" name="default_font" value="<?php echo e($siteSettings->default_font ?? ''); ?>">
                                </div>
                                <div class="input-group-custom mb-2">
                                    <span class="input-group-text">Heading Font</span>
                                    <input type="text" class="form-control" name="heading_font" value="<?php echo e($siteSettings->heading_font ?? ''); ?>">
                                </div>
                                <div class="input-group-custom mb-2">
                                    <span class="input-group-text">Contact No</span>
                                    <input type="text" class="form-control" name="contact_no" value="<?php echo e($siteSettings->contact_no ?? ''); ?>">
                                </div>
                                <div class="input-group-custom">
                                    <span class="input-group-text">Map Link</span>
                                    <input type="text" class="form-control" name="map_link" value="<?php echo e($siteSettings->map_link ?? ''); ?>">
                                </div>
                            </div>

                            <!-- Global Colors -->
                            <div class="col-12 mt-3">
                                <h6 class="fw-bold mb-2 mt-2">Global Colors</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <div class="color-picker-item">
                                        <span class="label">Body BG</span>
                                        <input type="text" class="color-code" name="body_bg" value="<?php echo e($siteSettings->body_bg ?? '#FFFFFF'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->body_bg ?? '#FFFFFF'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">Primary</span>
                                        <input type="text" class="color-code" name="primary_color" value="<?php echo e($siteSettings->primary_color ?? '#EA4335'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->primary_color ?? '#EA4335'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">Heading</span>
                                        <input type="text" class="color-code" name="heading_color" value="<?php echo e($siteSettings->heading_color ?? '#1A1A1A'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->heading_color ?? '#1A1A1A'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">Accent</span>
                                        <input type="text" class="color-code" name="accent_color" value="<?php echo e($siteSettings->accent_color ?? '#4285F4'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->accent_color ?? '#4285F4'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">Surface</span>
                                        <input type="text" class="color-code" name="surface_color" value="<?php echo e($siteSettings->surface_color ?? '#F8F9FA'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->surface_color ?? '#F8F9FA'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">Contrast</span>
                                        <input type="text" class="color-code" name="contrast_color" value="<?php echo e($siteSettings->contrast_color ?? '#E0E0E0'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->contrast_color ?? '#E0E0E0'); ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Nav Menu Colors -->
                            <div class="col-12 mt-4">
                                <h6 class="fw-bold mb-2">Nav Menu Colors</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <div class="color-picker-item">
                                        <span class="label">Primary</span>
                                        <input type="text" class="color-code" name="nav_primary" value="<?php echo e($siteSettings->nav_primary ?? '#EA4335'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->nav_primary ?? '#EA4335'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">Hover</span>
                                        <input type="text" class="color-code" name="nav_hover" value="<?php echo e($siteSettings->nav_hover ?? '#D33426'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->nav_hover ?? '#D33426'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">Mobile BG</span>
                                        <input type="text" class="color-code" name="nav_mobile_bg" value="<?php echo e($siteSettings->nav_mobile_bg ?? '#FFFFFF'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->nav_mobile_bg ?? '#FFFFFF'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">DD BG</span>
                                        <input type="text" class="color-code" name="nav_dd_bg" value="<?php echo e($siteSettings->nav_dd_bg ?? '#FFFFFF'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->nav_dd_bg ?? '#FFFFFF'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">DD Link</span>
                                        <input type="text" class="color-code" name="nav_dd_link" value="<?php echo e($siteSettings->nav_dd_link ?? '#333333'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->nav_dd_link ?? '#333333'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">DD Hover</span>
                                        <input type="text" class="color-code" name="nav_dd_hover" value="<?php echo e($siteSettings->nav_dd_hover ?? '#EA4335'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->nav_dd_hover ?? '#EA4335'); ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Dark Mode Toggle -->
                            <div class="col-12 mt-4">
                                <div class="form-check form-switch custom-switch d-flex align-items-center gap-2">
                                    <input class="form-check-input" type="checkbox" id="darkModeToggle" name="is_dark_mode" value="1" <?php echo e(($siteSettings->is_dark_mode ?? true) ? 'checked' : ''); ?>>
                                    <label class="form-check-label fw-bold fs-6" for="darkModeToggle">Switch To Dark
                                        Mode?</label>
                                </div>
                            </div>

                            <!-- Dark Mode Colors -->
                            <div id="darkModeColors" class="col-12 mt-4 mb-2">
                                <h6 class="fw-bold mb-2">Dark Mode Colors</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <div class="color-picker-item">
                                        <span class="label">Body BG</span>
                                        <input type="text" class="color-code" name="dark_body_bg" value="<?php echo e($siteSettings->dark_body_bg ?? '#121212'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->dark_body_bg ?? '#121212'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">Primary</span>
                                        <input type="text" class="color-code" name="dark_primary_color" value="<?php echo e($siteSettings->dark_primary_color ?? '#EA4335'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->dark_primary_color ?? '#EA4335'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">Heading</span>
                                        <input type="text" class="color-code" name="dark_heading_color" value="<?php echo e($siteSettings->dark_heading_color ?? '#FFFFFF'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->dark_heading_color ?? '#FFFFFF'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">Accent</span>
                                        <input type="text" class="color-code" name="dark_accent_color" value="<?php echo e($siteSettings->dark_accent_color ?? '#4285F4'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->dark_accent_color ?? '#4285F4'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">Surface</span>
                                        <input type="text" class="color-code" name="dark_surface_color" value="<?php echo e($siteSettings->dark_surface_color ?? '#1E1E1E'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->dark_surface_color ?? '#1E1E1E'); ?>">
                                    </div>
                                    <div class="color-picker-item">
                                        <span class="label">Contrast</span>
                                        <input type="text" class="color-code" name="dark_contrast_color" value="<?php echo e($siteSettings->dark_contrast_color ?? '#333333'); ?>">
                                        <input type="color" value="<?php echo e($siteSettings->dark_contrast_color ?? '#333333'); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-light px-3 py-1 rounded-3">Cancel</button>
                            <button type="submit"
                                class="btn btn-primary px-4 py-1 rounded-3 bg-orange-gradient border-0">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SEO Tab -->
            <div class="tab-pane fade" id="seo" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <form id="seoSettingsForm">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Meta Description</label>
                            <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description..."><?php echo e($siteSettings->meta_description ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keywords" placeholder="keyword1, keyword2, ..." value="<?php echo e($siteSettings->meta_keywords ?? ''); ?>">
                        </div>
                        <div class="row align-items-end">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Google Analytics ID</label>
                                <input type="text" class="form-control" name="google_analytics_id" placeholder="UA-XXXXXXXXX-X" value="<?php echo e($siteSettings->google_analytics_id ?? ''); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div
                                    class="form-check form-switch custom-switch d-flex align-items-center gap-2 justify-content-end">
                                    <input class="form-check-input" type="checkbox" id="indexToggle" name="allow_indexing" value="1" <?php echo e(($siteSettings->allow_indexing ?? true) ? 'checked' : ''); ?>>
                                    <label class="form-check-label fw-bold fs-6" for="indexToggle">Allow Search Engines to
                                        Index</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-light px-3 py-1 rounded-3">Cancel</button>
                            <button type="submit"
                                class="btn btn-primary px-4 py-1 rounded-3 bg-orange-gradient border-0">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Email Server Tab -->
            <div class="tab-pane fade" id="email" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <form id="emailSettingsForm">
                        <?php echo csrf_field(); ?>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">SMTP Host</label>
                                <input type="text" class="form-control" name="smtp_host" placeholder="smtp.mailtrap.io" value="<?php echo e($siteSettings->smtp_host ?? ''); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">SMTP Port</label>
                                <input type="text" class="form-control" name="smtp_port" placeholder="2525" value="<?php echo e($siteSettings->smtp_port ?? ''); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Encryption Type</label>
                                <select class="form-select" name="encryption_type">
                                    <option value="tls" <?php echo e(($siteSettings->encryption_type ?? '') == 'tls' ? 'selected' : ''); ?>>TLS</option>
                                    <option value="ssl" <?php echo e(($siteSettings->encryption_type ?? '') == 'ssl' ? 'selected' : ''); ?>>SSL</option>
                                    <option value="none" <?php echo e(($siteSettings->encryption_type ?? '') == 'none' ? 'selected' : ''); ?>>None</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">SMTP User Name</label>
                                <input type="text" class="form-control" name="smtp_username" placeholder="your_username" value="<?php echo e($siteSettings->smtp_username ?? ''); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Password</label>
                                <input type="password" class="form-control" name="smtp_password" placeholder="********" value="<?php echo e($siteSettings->smtp_password ?? ''); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Sender Name</label>
                                <input type="text" class="form-control" name="sender_name" placeholder="Lavender Portfolio" value="<?php echo e($siteSettings->sender_name ?? ''); ?>">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mb-4 border-bottom pb-3">
                            <button type="button" class="btn btn-light px-3 py-1 rounded-3">Cancel</button>
                            <button type="submit"
                                class="btn btn-primary px-4 py-1 rounded-3 bg-orange-gradient border-0">Save</button>
                        </div>

                        <!-- Test Connectivity -->
                        <div class="text-center mt-3">
                            <h6 class="fw-bold mb-3">Test Connectivity</h6>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-4 d-flex align-items-center justify-content-center gap-2">
                                    <div id="serverStatusIndicator" class="status-indicator disconnected"></div>
                                    <span id="serverStatusText" class="fw-bold fs-6 text-muted">Server Not Connected</span>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex gap-2">
                                        <div class="flex-grow-1">
                                            <label class="form-label d-none">Receiver Email</label>
                                            <input type="email" class="form-control" placeholder="Receiver Email">
                                        </div>
                                        <button type="button" id="testSmtpBtn"
                                            class="btn btn-primary px-3 bg-orange-gradient border-0">Test</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Premium Aesthetics */
        :root {
            --primary-peach: #E8C0B5;
            --secondary-blue: #E9F1F4;
            --accent-orange: #EA4335;
            --soft-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: #f8f9fa;
        }

        .container-fluid {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom Tabs */
        .custom-tabs {
            background: var(--secondary-blue);
            padding: 6px;
            border-radius: 14px;
            display: inline-flex;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .custom-tabs .nav-link {
            color: #555;
            font-weight: 600;
            padding: 8px 25px;
            border-radius: 10px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            background: transparent;
            font-size: 0.9rem;
        }

        .custom-tabs .nav-link.active {
            background: var(--primary-peach) !important;
            color: #444 !important;
            box-shadow: 0 5px 15px rgba(232, 192, 181, 0.4);
        }

        /* Accent Buttons */
        .btn-outline-accent {
            color: var(--accent-orange);
            border-color: var(--accent-orange);
        }

        .btn-outline-accent:hover {
            background-color: var(--accent-orange);
            border-color: var(--accent-orange);
            color: #fff;
        }

        .btn-check:checked + .btn-outline-accent {
            background-color: var(--accent-orange);
            border-color: var(--accent-orange);
            color: #fff;
            box-shadow: 0 4px 10px rgba(234, 67, 53, 0.3);
        }

        .custom-tabs .nav-link:hover:not(.active) {
            background: rgba(0, 0, 0, 0.05);
        }

        /* Card Styling */
        .card {
            border-radius: 20px !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            background: transparent;
            transition: transform 0.3s ease;
        }

        /* Input Groups */
        .input-group-custom {
            display: flex;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            transition: all 0.3s ease;
        }

        .input-group-custom:focus-within {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 3px rgba(234, 67, 53, 0.08);
        }

        .input-group-custom .input-group-text {
            background: var(--secondary-blue);
            border: none;
            border-right: 1px solid #e0e0e0;
            padding: 8px 15px;
            font-weight: 500;
            min-width: 110px;
            color: #444;
            font-size: 0.85rem;
        }

        .input-group-custom .form-control,
        .input-group-custom .form-select {
            border: none;
            padding: 8px 15px;
            font-size: 0.9rem;
        }

        .input-group-custom .form-control:focus,
        .input-group-custom .form-select:focus {
            box-shadow: none;
        }

        /* Logo & Favicon Upload Boxes */
        .logo-upload-box,
        .favicon-upload-box {
            width: 100%;
            height: 120px;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin: 0 auto;
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        .logo-upload-box {
            height: 130px;
        }

        .favicon-upload-box {
            width: 80px;
            height: 80px;
            border-radius: 10px;
        }

        .logo-upload-box:hover,
        .favicon-upload-box:hover {
            border-color: var(--accent-orange);
            background: rgba(234, 67, 53, 0.02);
        }

        .upload-options-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 5;
        }

        .logo-upload-box:hover .upload-options-overlay,
        .favicon-upload-box:hover .upload-options-overlay {
            opacity: 1;
        }

        .upload-options-overlay .btn {
            padding: 5px 12px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        .logo-upload-box:hover .upload-options-overlay .btn {
            transform: translateY(0);
        }

        .upload-options-overlay.mini {
            flex-direction: column;
            gap: 5px;
        }

        .upload-options-overlay.mini button,
        .upload-options-overlay.mini label {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            color: #333;
            border-radius: 50%;
            border: none;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .upload-options-overlay.mini button:hover,
        .upload-options-overlay.mini label:hover {
            background: var(--accent-orange);
            color: #fff;
            transform: scale(1.1);
        }

        .preview-area {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-area img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }

        .x-small {
            font-size: 0.7rem;
        }

        /* Color Picker Item */
        .color-picker-item {
            display: flex;
            align-items: center;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            min-width: 180px;
            background: #fff;
            transition: all 0.3s ease;
        }

        .color-picker-item:hover {
            border-color: #ccc;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .color-picker-item .label {
            background: var(--secondary-blue);
            padding: 6px 10px;
            font-size: 0.75rem;
            font-weight: 600;
            border-right: 1px solid #e0e0e0;
            flex-shrink: 0;
            min-width: 75px;
            color: #555;
        }

        .color-picker-item .color-code {
            border: none;
            padding: 6px 8px;
            font-size: 0.8rem;
            font-family: monospace;
            width: 70px;
            color: #444;
            background: transparent;
        }

        .color-picker-item .color-code:focus {
            outline: none;
            background: rgba(234, 67, 53, 0.05);
        }

        .color-picker-item input[type="color"] {
            border: none;
            width: 35px;
            height: 35px;
            padding: 0;
            background: none;
            cursor: pointer;
            flex-shrink: 0;
        }

        /* Custom Switch */
        .custom-switch .form-check-input {
            width: 3.2em;
            height: 1.6em;
            background-color: #e0e0e0;
            border-color: #e0e0e0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .custom-switch .form-check-input:checked {
            background-color: var(--accent-orange);
            border-color: var(--accent-orange);
            box-shadow: 0 4px 10px rgba(234, 67, 53, 0.3);
        }

        /* Status Indicator - Premium Glowing Effect */
        .status-indicator {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.5s ease;
        }

        .status-indicator.connected {
            background: #aaff00;
            box-shadow: 0 0 15px rgba(170, 255, 0, 0.5);
        }

        .status-indicator.disconnected {
            background: #ff4400;
            box-shadow: 0 0 15px rgba(255, 68, 0, 0.5);
        }

        .status-indicator::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: inherit;
            filter: blur(8px);
            opacity: 0.6;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.6;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.3;
            }

            100% {
                transform: scale(1);
                opacity: 0.6;
            }
        }

        /* Orange Gradient Button */
        .bg-orange-gradient {
            background: linear-gradient(135deg, #F06D4F 0%, #EA4335 100%);
            box-shadow: 0 4px 15px rgba(234, 67, 53, 0.3);
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .bg-orange-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(234, 67, 53, 0.4);
        }

        /* Dark Mode Transitions */
        #darkModeColors {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .custom-tabs {
                display: flex;
                width: 100%;
            }

            .custom-tabs .nav-link {
                flex: 1;
                padding: 10px 15px;
                font-size: 0.85rem;
            }
        }
    </style>

    <script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const darkModeColors = document.getElementById('darkModeColors');

            // Initialize Dark Mode UI state
            if (darkModeToggle.checked) {
                darkModeColors.style.opacity = '1';
                darkModeColors.style.pointerEvents = 'auto';
            } else {
                darkModeColors.style.opacity = '0.5';
                darkModeColors.style.pointerEvents = 'none';
            }

            darkModeToggle.addEventListener('change', function () {
                if (this.checked) {
                    darkModeColors.style.opacity = '1';
                    darkModeColors.style.pointerEvents = 'auto';
                } else {
                    darkModeColors.style.opacity = '0.5';
                    darkModeColors.style.pointerEvents = 'none';
                }
            });

            // Logo Type Toggle Logic
            const logoTypeText = document.getElementById('logoTypeText');
            const logoTypeImage = document.getElementById('logoTypeImage');
            const logoUploadBox = document.getElementById('logoUploadBox');
            const logoTextInputBox = document.getElementById('logoTextInputBox');

            function updateLogoVisibility() {
                if (logoTypeText.checked) {
                    logoUploadBox.style.display = 'none';
                    logoTextInputBox.style.display = 'block';
                } else {
                    logoUploadBox.style.display = 'flex';
                    logoTextInputBox.style.display = 'none';
                }
            }

            logoTypeText.addEventListener('change', updateLogoVisibility);
            logoTypeImage.addEventListener('change', updateLogoVisibility);
            
            // Trigger once on load
            updateLogoVisibility();

            // Logo Image Preview
            const logoInput = document.getElementById('logoInput');
            const logoPreview = document.getElementById('logoPreview');
            logoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        logoPreview.innerHTML = `<img src="${e.target.result}" alt="Logo">`;
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Favicon Preview
            const faviconInput = document.getElementById('faviconInput');
            const faviconPreview = document.getElementById('faviconPreview');
            faviconInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        faviconPreview.innerHTML = `<img src="${e.target.result}" alt="Favicon">`;
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Remove Buttons Logic
            $(document).on('click', '.remove-logo-btn', function(e) {
                e.preventDefault();
                $('#removeLogoInput').val('1');
                logoPreview.innerHTML = `<i class="ti ti-photo-up fs-2 text-primary"></i><span class="d-block text-primary x-small mt-1">Upload Logo</span>`;
                $(this).hide();
            });

            $(document).on('click', '.remove-favicon-btn', function(e) {
                e.preventDefault();
                $('#removeFaviconInput').val('1');
                faviconPreview.innerHTML = `<i class="ti ti-upload fs-4 text-danger"></i><span class="d-block text-danger x-small">Favicon</span>`;
                $(this).hide();
            });

            // Sync Color Inputs and HEX Codes
            const colorItems = document.querySelectorAll('.color-picker-item');
            colorItems.forEach(item => {
                const colorPicker = item.querySelector('input[type="color"]');
                const hexInput = item.querySelector('.color-code');

                if (colorPicker && hexInput) {
                    // From Picker to HEX
                    colorPicker.addEventListener('input', () => {
                        hexInput.value = colorPicker.value.toUpperCase();
                    });

                    // From HEX to Picker
                    hexInput.addEventListener('input', () => {
                        let value = hexInput.value;
                        if (!value.startsWith('#')) value = '#' + value;
                        if (/^#[0-9A-F]{6}$/i.test(value)) {
                            colorPicker.value = value;
                        }
                    });
                }
            });

            // AJAX Form Submissions
            function handleAjaxForm(formId, url) {
                $(`#${formId}`).on('submit', function(e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    
                    // Handle special file fields for the general form
                    if (formId === 'generalSettingsForm') {
                        const faviconFile = document.getElementById('faviconInput').files[0];
                        if (faviconFile) {
                            formData.append('favicon', faviconFile);
                        }
                        const logoFile = document.getElementById('logoInput').files[0];
                        if (logoFile) {
                            formData.append('logo_image', logoFile);
                        }
                    }

                    const submitBtn = $(this).find('button[type="submit"]');
                    const originalText = submitBtn.text();
                    submitBtn.prop('disabled', true).text('Saving...');

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            submitBtn.prop('disabled', false).text(originalText);
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Saved!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false,
                                    toast: true,
                                    position: 'top-end'
                                });
                            }
                        },
                        error: function(xhr) {
                            submitBtn.prop('disabled', false).text(originalText);
                            let errorMsg = 'Something went wrong.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: errorMsg
                            });
                        }
                    });
                });
            }

            handleAjaxForm('generalSettingsForm', '<?php echo e(route('settings.saveGeneral')); ?>');
            handleAjaxForm('seoSettingsForm', '<?php echo e(route('settings.saveSeo')); ?>');
            handleAjaxForm('emailSettingsForm', '<?php echo e(route('settings.saveEmail')); ?>');

            // SMTP Test
            $('#testSmtpBtn').on('click', function() {
                const email = $(this).siblings('div').find('input').val();
                if (!email) {
                    Swal.fire('Error', 'Please enter a receiver email for testing.', 'error');
                    return;
                }

                const btn = $(this);
                btn.prop('disabled', true).text('Testing...');
                $('#serverStatusText').text('Connecting...');
                $('#serverStatusIndicator').removeClass('connected disconnected').addClass('connecting');

                $.ajax({
                    url: '<?php echo e(route('settings.testSmtp')); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        test_email: email
                    },
                    success: function(response) {
                        btn.prop('disabled', false).text('Test');
                        if (response.success) {
                            $('#serverStatusIndicator').removeClass('disconnected connecting').addClass('connected');
                            $('#serverStatusText').text('Server Connected').addClass('text-success').removeClass('text-muted text-danger');
                            Swal.fire('Success', response.message, 'success');
                        } else {
                            $('#serverStatusIndicator').removeClass('connected connecting').addClass('disconnected');
                            $('#serverStatusText').text('Connection Failed').addClass('text-danger').removeClass('text-muted text-success');
                            Swal.fire('Failed', response.message, 'error');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).text('Test');
                        $('#serverStatusIndicator').removeClass('connected connecting').addClass('disconnected');
                        $('#serverStatusText').text('Connection Error').addClass('text-danger').removeClass('text-muted text-success');
                        Swal.fire('Error', 'AJAX request failed.', 'error');
                    }
                });
            });
        });
    </script>
    </script>
    <?php echo $__env->make('admin.include.media_manager_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/settings/global.blade.php ENDPATH**/ ?>