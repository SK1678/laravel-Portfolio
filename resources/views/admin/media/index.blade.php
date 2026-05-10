@extends('admin.layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fs-3 mb-1">Media Library</h1>
                <p class="text-muted">Manage all your uploaded files, images, and documents.</p>
            </div>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadMediaModal">
                    <i class="ti ti-upload me-1"></i> Upload New Media
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('admin.media') }}" method="GET" class="row g-3 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="ti ti-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by original file name..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="type" class="form-select">
                            <option value="all">All Media Types</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <div class="form-check d-inline-block me-3">
                <input class="form-check-input" type="checkbox" id="selectAllMedia">
                <label class="form-check-label" for="selectAllMedia">
                    Select All on Page
                </label>
            </div>
            <button class="btn btn-sm btn-danger d-none" id="bulkDeleteBtn">
                <i class="ti ti-trash"></i> Delete Selected (<span id="selectedCount">0</span>)
            </button>
        </div>
        <div>
            {{ $media->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<div class="row g-3" id="mediaContainer">
    @forelse($media as $item)
        <div class="col-6 col-md-4 col-lg-3 col-xl-2 media-item-wrapper">
            <div class="card h-100 border-0 shadow-sm position-relative media-card overflow-hidden">
                <div class="position-absolute top-0 start-0 m-2 z-3">
                    <input class="form-check-input media-checkbox shadow-sm" type="checkbox" value="{{ $item->id }}">
                </div>
                
                <div class="position-absolute top-0 end-0 m-2 z-3">
                    <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this file?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger rounded-circle shadow-sm p-1 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;" title="Delete">
                            <i class="ti ti-trash fs-5"></i>
                        </button>
                    </form>
                </div>

                <div class="card-img-top bg-light d-flex align-items-center justify-content-center overflow-hidden" style="height: 150px;">
                    @if($item->type == 'image')
                        <img src="{{ asset('storage/'.$item->file_path) }}" class="img-fluid object-fit-cover w-100 h-100" alt="{{ $item->original_name }}">
                    @elseif($item->type == 'video')
                        <i class="ti ti-video fs-1 text-primary"></i>
                    @elseif($item->type == 'audio')
                        <i class="ti ti-music fs-1 text-info"></i>
                    @elseif($item->type == 'pdf')
                        <i class="ti ti-file-type-pdf fs-1 text-danger"></i>
                    @elseif($item->type == 'archive')
                        <i class="ti ti-file-zip fs-1 text-warning"></i>
                    @else
                        <i class="ti ti-file fs-1 text-secondary"></i>
                    @endif
                </div>
                <div class="card-body p-2 text-center">
                    <p class="card-title text-truncate mb-1 small fw-bold" title="{{ $item->original_name }}">
                        {{ $item->original_name }}
                    </p>
                    <p class="card-text text-muted mb-1" style="font-size: 0.75rem;">
                        {{ number_format($item->file_size / 1024, 2) }} KB • {{ ucfirst($item->type) }}
                    </p>
                    <p class="card-text mb-0" style="font-size: 0.7rem;">
                        @if($item->isUsed())
                            <span class="badge bg-success-subtle text-success rounded-pill border border-success">Used</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary rounded-pill border border-secondary">Unused</span>
                        @endif
                    </p>
                </div>
                <div class="card-footer p-2 bg-white text-center border-top-0 d-flex justify-content-between">
                    <button class="btn btn-sm btn-light w-100 border copy-url-btn" data-url="{{ asset('storage/'.$item->file_path) }}">
                        <i class="ti ti-copy"></i> Copy URL
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                No media found. Upload some files to get started!
            </div>
        </div>
    @endforelse
</div>

<div class="row mt-4">
    <div class="col-12 d-flex justify-content-center">
        {{ $media->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Upload Media Modal (Pro Option) -->
<div class="modal fade" id="uploadMediaModal" tabindex="-1" aria-labelledby="uploadMediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold" id="uploadMediaModalLabel">Upload New Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="upload-zone border border-2 border-dashed border-primary rounded-3 bg-primary bg-opacity-10 text-center p-5 position-relative" id="uploadZone">
                    <input type="file" id="mediaFileInput" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;" multiple>
                    <div class="icon-shape icon-xl bg-primary text-white rounded-circle mx-auto mb-3">
                        <i class="ti ti-cloud-upload fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-1">Drag and drop files here</h4>
                    <p class="text-muted mb-0">or click to browse your files</p>
                    <p class="small text-muted mt-2">Maximum file size: 10MB</p>
                </div>

                <div id="uploadProgressContainer" class="mt-4 d-none">
                    <h6 class="fw-bold mb-2">Uploading Files...</h6>
                    <div class="progress" style="height: 10px;">
                        <div id="uploadProgressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="text-end small text-muted mt-1" id="uploadProgressText">0%</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .media-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .media-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .upload-zone.dragover {
        background-color: rgba(var(--bs-primary-rgb), 0.2) !important;
        border-color: var(--bs-primary) !important;
    }
    .media-checkbox {
        width: 1.5em;
        height: 1.5em;
        cursor: pointer;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Checkbox Logic for Bulk Delete
    const selectAllCheckbox = document.getElementById('selectAllMedia');
    const mediaCheckboxes = document.querySelectorAll('.media-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectedCountSpan = document.getElementById('selectedCount');

    function updateBulkDeleteBtn() {
        const checkedBoxes = document.querySelectorAll('.media-checkbox:checked');
        const count = checkedBoxes.length;
        selectedCountSpan.textContent = count;
        
        if (count > 0) {
            bulkDeleteBtn.classList.remove('d-none');
        } else {
            bulkDeleteBtn.classList.add('d-none');
        }

        if (count === mediaCheckboxes.length && mediaCheckboxes.length > 0) {
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.checked = false;
        }
    }

    if(selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            mediaCheckboxes.forEach(cb => {
                cb.checked = this.checked;
            });
            updateBulkDeleteBtn();
        });
    }

    mediaCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkDeleteBtn);
    });

    if(bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete selected media files?')) {
                const checkedBoxes = document.querySelectorAll('.media-checkbox:checked');
                const ids = Array.from(checkedBoxes).map(cb => cb.value);

                fetch('{{ route("admin.media.bulkDelete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ids: ids })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to delete selected media.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });
            }
        });
    }

    // Copy URL
    document.querySelectorAll('.copy-url-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            navigator.clipboard.writeText(url).then(() => {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="ti ti-check text-success"></i> Copied!';
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            });
        });
    });

    // File Upload Logic
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('mediaFileInput');
    const progressContainer = document.getElementById('uploadProgressContainer');
    const progressBar = document.getElementById('uploadProgressBar');
    const progressText = document.getElementById('uploadProgressText');

    if(uploadZone && fileInput) {
        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.classList.add('dragover');
        });

        uploadZone.addEventListener('dragleave', () => {
            uploadZone.classList.remove('dragover');
        });

        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadZone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                uploadFiles(fileInput.files);
            }
        });

        fileInput.addEventListener('change', function() {
            if (this.files.length) {
                uploadFiles(this.files);
            }
        });
    }

    function uploadFiles(files) {
        progressContainer.classList.remove('d-none');
        let totalFiles = files.length;
        let uploadedFiles = 0;

        Array.from(files).forEach(file => {
            let formData = new FormData();
            formData.append('file', file);

            // Simple AJAX upload per file
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("admin.media.upload") }}', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    // Update progress (this is simplistic for multiple files, 
                    // a better way is to track individual file progress and average them)
                }
            };

            xhr.onload = function() {
                if (xhr.status === 200) {
                    uploadedFiles++;
                    let percentage = Math.round((uploadedFiles / totalFiles) * 100);
                    progressBar.style.width = percentage + '%';
                    progressBar.setAttribute('aria-valuenow', percentage);
                    progressText.textContent = percentage + '%';

                    if (uploadedFiles === totalFiles) {
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }
                } else {
                    console.error('Upload failed for file:', file.name);
                }
            };

            xhr.onerror = function() {
                console.error('Upload error for file:', file.name);
            };

            xhr.send(formData);
        });
    }
});
</script>
@endsection
