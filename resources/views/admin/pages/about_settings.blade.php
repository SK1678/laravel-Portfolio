@extends('admin.layouts.admin')

@section('title', 'About Page Settings')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>About Page Settings</h4>
                    <p class="mb-3">Configure your career objective and personal details</p>
                </div>
            </div>
        </div>

        <form id="aboutSettingsForm" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Left Side: Image & Objective --}}
                <div class="col-md-5">
                    <div class="hs-card mb-4">
                        <p class="hs-section-label">Section Headers</p>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Page Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $about->title ?? 'About' }}" placeholder="e.g. About Me">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Section Subtitle</label>
                            <textarea name="subtitle" class="form-control" rows="2" placeholder="Enter a brief subtitle...">{{ $about->subtitle }}</textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold">Objective Heading</label>
                            <input type="text" name="objective_title" class="form-control" value="{{ $about->objective_title ?? 'Career Summary' }}" placeholder="e.g. Professional Profile">
                        </div>
                    </div>

                    <div class="hs-card mb-4">
                        <p class="hs-section-label">About Profile Image</p>
                        <div class="text-center mb-3">
                            <div class="position-relative d-inline-block">
                                <img id="aboutImagePreview" 
                                     src="{{ $about->image_path ? asset('storage/' . $about->image_path) : ($siteOwner->profile_image ? asset('storage/' . $siteOwner->profile_image) : asset('UI/assets/img/profile-img.jpg')) }}" 
                                     alt="Profile" 
                                     class="rounded shadow-sm" 
                                     style="width: 240px; height: 280px; object-fit: cover; border: 4px solid #fff;">
                                
                                <button type="button" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 mb-2 me-2 shadow"
                                        onclick="document.getElementById('aboutImageInput').click()">
                                    <i class="ti ti-camera"></i> Change
                                </button>
                            </div>
                            <input type="file" name="about_image" id="aboutImageInput" class="d-none" accept="image/*">
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="alert('Media Library is coming soon!')">
                                <i class="ti ti-photo"></i> Select from Media
                            </button>
                        </div>
                    </div>

                    <div class="hs-card">
                        <p class="hs-section-label">Career Objective</p>
                        <textarea name="career_objective" class="form-control" rows="8" placeholder="Enter your career objective...">{{ $about->career_objective }}</textarea>
                    </div>
                </div>

                {{-- Right Side: Biometric Details --}}
                <div class="col-md-7">
                    <div class="hs-card h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <p class="hs-section-label mb-0">Biometric Details</p>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-info" onclick="syncFromBasic()">
                                    <i class="ti ti-refresh"></i> Sync from Basic
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addField()">
                                    <i class="ti ti-plus"></i> Add Field
                                </button>
                            </div>
                        </div>

                        <div id="detailsContainer" class="sortable-list">
                            @if($about->details && count($about->details) > 0)
                                @foreach($about->details as $index => $item)
                                    <div class="hs-detail-row mb-2">
                                        <div class="d-flex align-items-center gap-2 border rounded p-2 bg-light">
                                            <div class="d-flex flex-column gap-1 sort-handle" style="cursor: move;">
                                                <i class="ti ti-chevron-up small text-muted" onclick="moveUp(this)"></i>
                                                <i class="ti ti-chevron-down small text-muted" onclick="moveDown(this)"></i>
                                            </div>
                                            <input type="text" name="labels[]" class="form-control form-control-sm w-25" value="{{ $item['label'] }}" placeholder="Label">
                                            <input type="text" name="values[]" class="form-control form-control-sm flex-grow-1" value="{{ $item['value'] }}" placeholder="Value">
                                            <select name="types[]" class="form-select form-select-sm" style="width: 100px;">
                                                <option value="text" {{ $item['type'] == 'text' ? 'selected' : '' }}>Text</option>
                                                <option value="date" {{ $item['type'] == 'date' ? 'selected' : '' }}>Date</option>
                                                <option value="link" {{ $item['type'] == 'link' ? 'selected' : '' }}>Link</option>
                                            </select>
                                            <button type="button" class="btn btn-sm btn-outline-danger px-2" onclick="this.closest('.hs-detail-row').remove()">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{-- Default Fields if empty --}}
                                <div class="text-center text-muted py-5" id="noDetailsMsg">
                                    No details added yet. Click "Sync from Basic" or "Add Field".
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4 mb-5">
                <a href="{{ route('page') }}" class="hs-cancel-btn">Cancel</a>
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
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
    </style>

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
                    url: "{{ route('admin.page.about.save') }}",
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
            div.className = 'hs-detail-row mb-2';
            div.innerHTML = `
                <div class="d-flex align-items-center gap-2 border rounded p-2 bg-light">
                    <div class="d-flex flex-column gap-1 sort-handle" style="cursor: move;">
                        <i class="ti ti-chevron-up small text-muted" onclick="moveUp(this)"></i>
                        <i class="ti ti-chevron-down small text-muted" onclick="moveDown(this)"></i>
                    </div>
                    <input type="text" name="labels[]" class="form-control form-control-sm w-25" value="${label}" placeholder="Label">
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

        function syncFromBasic() {
            const basicInfo = {
                'Name': "{{ $siteOwner->name }}",
                'Email': "{{ $siteOwner->email }}",
                'Alt Email': "{{ $siteOwner->additional_info['alt_email'] ?? '' }}",
                'Birthday': "{{ $siteOwner->additional_info['birthday'] ?? '' }}",
                'Gender': "{{ $siteOwner->additional_info['gender'] ?? '' }}",
                'Nationality': "{{ $siteOwner->additional_info['nationality'] ?? '' }}",
                'Religion': "{{ $siteOwner->additional_info['religion'] ?? '' }}",
                'NID No': "{{ $siteOwner->additional_info['nid'] ?? '' }}",
                'Phone': "{{ $siteOwner->phone ?? '' }}",
                'Address': "{{ $siteOwner->address ?? '' }}"
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
@endsection
