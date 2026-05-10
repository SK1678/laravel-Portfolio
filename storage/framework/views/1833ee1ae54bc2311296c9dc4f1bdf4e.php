<?php $__env->startSection('title', 'Counter Settings'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Counter Settings</h4>
                    <p class="mb-3">Configure your statistical counters and facts</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
                <a href="<?php echo e(route('page')); ?>" class="btn btn-light btn-sm px-3 border shadow-sm">
                    <i class="ti ti-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <form id="counterSettingsForm">
            <?php echo csrf_field(); ?>
            
            <div class="hs-card mb-4">
                <p class="hs-section-label">Section Headers</p>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label small fw-bold">Section Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo e($settings->title); ?>"
                            placeholder="e.g. Facts">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Section Sub Title</label>
                        <textarea name="subtitle" class="form-control" rows="3"
                            placeholder="Enter section description..."><?php echo e($settings->subtitle); ?></textarea>
                    </div>
                </div>
            </div>

            
            <div class="hs-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="hs-section-label mb-0">Statistical Counters</p>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addCounter()">
                        <i class="ti ti-plus"></i> Add Counter
                    </button>
                </div>

                <div id="countersContainer" class="row">
                    <?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 counter-item mb-4">
                            <div class="card border shadow-sm position-relative">
                                <button type="button" class="btn btn-danger btn-sm position-absolute"
                                    style="top: -10px; right: -10px; border-radius: 50%; width: 25px; height: 25px; padding: 0; line-height: 25px; z-index: 5;"
                                    onclick="this.closest('.counter-item').remove()">
                                    <i class="ti ti-x"></i>
                                </button>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label class="form-label small fw-bold">Counter Name</label>
                                            <input type="text" name="names[]" class="form-control" value="<?php echo e($counter->name); ?>"
                                                placeholder="e.g. Clients">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Value</label>
                                            <input type="text" name="values[]" class="form-control"
                                                value="<?php echo e($counter->value); ?>" placeholder="e.g. 232">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 mb-5">
                <a href="<?php echo e(route('page')); ?>" class="btn btn-light px-4">Cancel</a>
                <button type="submit" class="btn btn-primary hs-save-btn px-4">Save Changes</button>
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

        .btn-primary {
            background: #E66239;
            border-color: #E66239;
        }

        .btn-primary:hover {
            background: #d45630;
            border-color: #d45630;
        }

        .btn-outline-primary {
            color: #E66239;
            border-color: #E66239;
        }

        .btn-outline-primary:hover {
            background: #E66239;
            color: #fff;
        }
    </style>

    <script>
        function addCounter(name = '', value = '0') {
            const container = document.getElementById('countersContainer');
            const div = document.createElement('div');
            div.className = 'col-md-6 counter-item mb-4';
            div.innerHTML = `
                    <div class="card border shadow-sm position-relative">
                        <button type="button" class="btn btn-danger btn-sm position-absolute" 
                                style="top: -10px; right: -10px; border-radius: 50%; width: 25px; height: 25px; padding: 0; line-height: 25px; z-index: 5;"
                                onclick="this.closest('.counter-item').remove()">
                            <i class="ti ti-x"></i>
                        </button>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold">Counter Name</label>
                                    <input type="text" name="names[]" class="form-control" value="${name}" placeholder="e.g. Clients">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Value</label>
                                    <input type="text" name="values[]" class="form-control" value="${value}" placeholder="e.g. 232">
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            container.appendChild(div);
        }

        document.getElementById('counterSettingsForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const btn = this.querySelector('.hs-save-btn');
            const orig = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="ti ti-loader rotate-infinite me-2"></i> Saving...';

            $.ajax({
                url: "<?php echo e(route('admin.counters.save')); ?>",
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
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/pages/counter_settings.blade.php ENDPATH**/ ?>