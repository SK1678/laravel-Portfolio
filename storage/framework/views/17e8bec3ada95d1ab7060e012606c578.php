<!-- Media Manager Modal -->
<div class="modal fade" id="mediaManagerModal" tabindex="-1" aria-labelledby="mediaManagerModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom bg-light">
                <div>
                    <h5 class="modal-title fw-bold mb-0" id="mediaManagerModalLabel">Select Media</h5>
                    <small id="mediaModalHint" class="text-muted">Click to select one item</small>
                </div>
                <div class="ms-auto d-flex gap-2 align-items-center">
                    <input type="text" id="mediaManagerSearch" class="form-control form-control-sm" placeholder="Search media..." style="width:180px;">
                    <select id="mediaManagerType" class="form-select form-select-sm" style="width: auto;">
                        <option value="all">All Types</option>
                        <option value="image">Images</option>
                        <option value="video">Videos</option>
                        <option value="pdf">PDFs</option>
                        <option value="document">Documents</option>
                    </select>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-4">
                <!-- Multi-select badge counter -->
                <div id="multiSelectBadge" class="d-none mb-3">
                    <span class="badge" style="background:#E66239; font-size:.85rem; padding:6px 14px;">
                        <i class="ti ti-photo-check me-1"></i>
                        <span id="selectedCountText">0 images selected</span>
                    </span>
                    <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="clearMultiSelection()">
                        Clear Selection
                    </button>
                </div>
                <div class="row g-3" id="mediaManagerList">
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border" style="color:#E66239;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top bg-light">
                <span id="selectionSummary" class="text-muted small me-auto"></span>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn px-4 fw-semibold" id="confirmMediaSelection"
                    style="background:#E66239; color:#fff; border:0;" disabled>
                    <i class="ti ti-check me-1"></i>
                    <span id="confirmBtnText">Select Media</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .media-selector-item {
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid transparent;
        border-radius: 10px;
        overflow: hidden;
    }
    .media-selector-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.12);
        border-color: #E66239;
    }
    .media-selector-item.selected {
        border-color: #E66239 !important;
        background-color: rgba(230, 98, 57, 0.06);
    }
    .media-selector-item.selected .selected-check { display: flex !important; }
    .selected-check {
        display: none;
        position: absolute;
        top: 6px; right: 6px;
        background: #E66239;
        color: white;
        border-radius: 50%;
        width: 22px; height: 22px;
        align-items: center; justify-content: center;
        font-size: 11px;
        z-index: 5;
        box-shadow: 0 2px 6px rgba(0,0,0,.25);
    }
    .media-item-img { height: 110px; object-fit: cover; width: 100%; }
    .media-item-icon { height: 110px; display:flex; align-items:center; justify-content:center; background:#f8f9fa; }
</style>

<script>
    // ─── STATE ───────────────────────────────────────────────────────────────
    let selectedMediaData = null;          // single-select (for attachments)
    let selectedMediaMulti = [];           // multi-select (for gallery)
    let currentTargetInput = null;
    let currentTargetPreview = null;
    let isGalleryMode = false;

    // ─── OPEN ────────────────────────────────────────────────────────────────
    function openMediaManager(targetInput, targetPreviewId = null) {
        currentTargetInput  = targetInput;
        currentTargetPreview = targetPreviewId;
        isGalleryMode = (targetPreviewId === 'gallery');

        // Reset state
        selectedMediaData  = null;
        selectedMediaMulti = [];

        const confirmBtn = document.getElementById('confirmMediaSelection');
        confirmBtn.disabled = true;

        // Update UI hints
        document.getElementById('mediaModalHint').textContent =
            isGalleryMode ? 'Click to select multiple images — click again to deselect' : 'Click to select one item';
        document.getElementById('confirmBtnText').textContent =
            isGalleryMode ? 'Add to Gallery' : 'Select Media';
        document.getElementById('multiSelectBadge').classList.toggle('d-none', !isGalleryMode);
        document.getElementById('selectionSummary').textContent = '';
        updateMultiBadge();

        const modal = new bootstrap.Modal(document.getElementById('mediaManagerModal'));
        modal.show();
        loadMediaList();
    }

    // ─── CLEAR MULTI ─────────────────────────────────────────────────────────
    function clearMultiSelection() {
        selectedMediaMulti = [];
        document.querySelectorAll('.media-selector-item.selected').forEach(el => el.classList.remove('selected'));
        updateMultiBadge();
        document.getElementById('confirmMediaSelection').disabled = true;
    }

    function updateMultiBadge() {
        const n = selectedMediaMulti.length;
        document.getElementById('selectedCountText').textContent = `${n} image${n !== 1 ? 's' : ''} selected`;
        document.getElementById('selectionSummary').textContent =
            isGalleryMode && n > 0 ? `${n} item${n !== 1 ? 's' : ''} will be added to the gallery` : '';
    }

    // ─── LOAD MEDIA LIST ─────────────────────────────────────────────────────
    function loadMediaList() {
        const search = document.getElementById('mediaManagerSearch').value;
        const type   = document.getElementById('mediaManagerType').value;
        const list   = document.getElementById('mediaManagerList');

        list.innerHTML = `<div class="col-12 text-center py-5">
            <div class="spinner-border" style="color:#E66239;" role="status"></div></div>`;

        fetch(`<?php echo e(route('admin.media.fetch')); ?>?search=${encodeURIComponent(search)}&type=${type}`)
            .then(r => r.json())
            .then(data => {
                list.innerHTML = '';
                if (!data.media || data.media.length === 0) {
                    list.innerHTML = `<div class="col-12 text-center py-5 text-muted">
                        <i class="ti ti-photo-off fs-1 d-block mb-2"></i>No media found.</div>`;
                    return;
                }

                data.media.forEach(item => {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-md-4 col-lg-3 col-xl-2';

                    let previewHtml = '';
                    if (item.type === 'image') {
                        previewHtml = `<img src="/storage/${item.file_path}" class="media-item-img">`;
                    } else if (item.type === 'pdf') {
                        previewHtml = `<div class="media-item-icon"><i class="ti ti-file-type-pdf fs-1 text-danger"></i></div>`;
                    } else if (item.type === 'video') {
                        previewHtml = `<div class="media-item-icon"><i class="ti ti-video fs-1 text-info"></i></div>`;
                    } else {
                        previewHtml = `<div class="media-item-icon"><i class="ti ti-file fs-1 text-muted"></i></div>`;
                    }

                    col.innerHTML = `
                        <div class="card h-100 media-selector-item position-relative"
                            data-path="${item.file_path}"
                            data-url="/storage/${item.file_path}"
                            data-type="${item.type}">
                            <div class="selected-check"><i class="ti ti-check"></i></div>
                            <div class="overflow-hidden">${previewHtml}</div>
                            <div class="p-2 text-center">
                                <p class="small text-truncate mb-0" style="font-size:.68rem;"
                                    title="${item.original_name}">${item.original_name}</p>
                            </div>
                        </div>`;

                    const card = col.querySelector('.media-selector-item');

                    card.addEventListener('click', function() {
                        if (isGalleryMode) {
                            // ── MULTI-SELECT MODE ──────────────────────────
                            const idx = selectedMediaMulti.findIndex(m => m.path === this.dataset.path);
                            if (idx > -1) {
                                // Deselect
                                selectedMediaMulti.splice(idx, 1);
                                this.classList.remove('selected');
                            } else {
                                // Select
                                selectedMediaMulti.push({ path: this.dataset.path, url: this.dataset.url });
                                this.classList.add('selected');
                            }
                            updateMultiBadge();
                            document.getElementById('confirmMediaSelection').disabled = selectedMediaMulti.length === 0;
                        } else {
                            // ── SINGLE-SELECT MODE ─────────────────────────
                            document.querySelectorAll('.media-selector-item').forEach(el => el.classList.remove('selected'));
                            this.classList.add('selected');
                            selectedMediaData = { path: this.dataset.path, url: this.dataset.url };
                            document.getElementById('confirmMediaSelection').disabled = false;
                        }
                    });

                    list.appendChild(col);
                });
            })
            .catch(() => {
                list.innerHTML = `<div class="col-12 text-center py-5 text-danger">Failed to load media.</div>`;
            });
    }

    // ─── SEARCH & FILTER ──────────────────────────────────────────────────────
    document.getElementById('mediaManagerSearch').addEventListener('input', debounce(loadMediaList, 400));
    document.getElementById('mediaManagerType').addEventListener('change', loadMediaList);

    // ─── CONFIRM SELECTION ────────────────────────────────────────────────────
    document.getElementById('confirmMediaSelection').addEventListener('click', function() {
        if (isGalleryMode) {
            // Push all selected images into gallery
            if (typeof galleryImages !== 'undefined' && typeof renderGallery !== 'undefined') {
                selectedMediaMulti.forEach(item => {
                    // Avoid duplicates
                    if (!galleryImages.find(g => g.path === item.path)) {
                        galleryImages.push({ url: item.url, path: item.path });
                    }
                });
                renderGallery();
            }
        } else {
            // Single select: set input value
            if (selectedMediaData && currentTargetInput) {
                const input = (typeof currentTargetInput === 'string')
                    ? document.getElementById(currentTargetInput)
                    : currentTargetInput;
                if (input) {
                    input.value = window.location.origin + selectedMediaData.url;
                    input.dispatchEvent(new Event('change'));
                }
            }
        }

        bootstrap.Modal.getInstance(document.getElementById('mediaManagerModal')).hide();
    });

    // ─── DEBOUNCE HELPER ─────────────────────────────────────────────────────
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func(...args), wait);
        };
    }
</script>
<?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/include/media_manager_modal.blade.php ENDPATH**/ ?>