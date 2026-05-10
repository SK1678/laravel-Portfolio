@extends('admin.layouts.admin')

@section('title', 'Awards & Certifications Settings')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Awards & Certifications</h4>
                    <p class="mb-3">Manage your professional achievements, certifications, and proof files</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
                <a href="{{ route('page') }}" class="btn btn-light btn-sm px-3 border shadow-sm">
                    <i class="ti ti-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        <form id="awardSettingsForm">
            @csrf
            {{-- Header Settings --}}
            <div class="hs-card mb-4">
                <p class="hs-section-label">Section Headers</p>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label small fw-bold">Section Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $settings->title }}"
                            placeholder="e.g. Awards & Certifications">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Section Sub Title</label>
                        <textarea name="subtitle" class="form-control" rows="3"
                            placeholder="Enter section description...">{{ $settings->subtitle }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Awards List --}}
            <div id="awardsContainer">
                @foreach($awards as $index => $award)
                    <div class="hs-card mb-4 award-item position-relative" data-index="{{ $index }}">
                        <button type="button" class="btn btn-danger btn-sm position-absolute"
                            style="top: -10px; right: -10px; border-radius: 50%; width: 25px; height: 25px; padding: 0; line-height: 25px; z-index: 5;"
                            onclick="this.closest('.award-item').remove()">
                            <i class="ti ti-x"></i>
                        </button>

                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label class="form-label small fw-bold">Year</label>
                                <input type="text" name="years[]" class="form-control" value="{{ $award->year }}"
                                    placeholder="e.g. 10 Sep 2025">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small fw-bold">Award / Certificate Title</label>
                                <input type="text" name="titles[]" class="form-control" value="{{ $award->title }}"
                                    placeholder="Certificate Name">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small fw-bold">Issuing Organization</label>
                                <input type="text" name="organizations[]" class="form-control"
                                    value="{{ $award->organization }}" placeholder="e.g. HackerRank">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Description (Optional)</label>
                            <textarea name="descriptions[]" class="form-control" rows="2"
                                placeholder="Brief details about this achievement...">{{ $award->description }}</textarea>
                        </div>

                        <div class="p-3 bg-light rounded proofs-section">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small fw-bold text-muted"><i class="ti ti-award me-1"></i> Certificate Files &
                                    Proof</span>
                                <button type="button" class="btn btn-xs btn-primary py-0 px-2" onclick="addProof({{ $index }})">
                                    <i class="ti ti-plus"></i> Add Certificate
                                </button>
                            </div>

                            <div class="proofs-container">
                                @if($award->proofs)
                                    @foreach($award->proofs as $pIndex => $proof)
                                        <div class="proof-item mb-2">
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="proofs[{{ $index }}][{{ $pIndex }}][label]"
                                                    class="form-control" value="{{ $proof['label'] ?? 'Certificate' }}"
                                                    style="max-width: 120px;">
                                                <input type="text" name="proofs[{{ $index }}][{{ $pIndex }}][value]"
                                                    class="form-control proof-value-input" value="{{ $proof['value'] ?? '' }}"
                                                    placeholder="Link or File URL">

                                                <button type="button" class="btn btn-outline-secondary btn-upload-proof"
                                                    title="Upload"><i class="ti ti-upload"></i></button>
                                                <button type="button" class="btn btn-outline-secondary" title="Media Library"
                                                    onclick="openMediaManager(this.closest('.input-group').querySelector('.proof-value-input'))"><i
                                                        class="ti ti-photo"></i></button>

                                                <div class="input-group-text bg-white">
                                                    <div class="form-check form-switch mb-0">
                                                        <input class="form-check-input proof-lock-toggle" type="checkbox"
                                                            name="proofs[{{ $index }}][{{ $pIndex }}][is_protected]" value="1" {{ isset($proof['is_protected']) && $proof['is_protected'] ? 'checked' : '' }}>
                                                        <i
                                                            class="ti ti-lock ms-1 {{ isset($proof['is_protected']) && $proof['is_protected'] ? 'text-danger' : 'text-muted' }}"></i>
                                                    </div>
                                                </div>

                                                <input type="text" name="proofs[{{ $index }}][{{ $pIndex }}][password]"
                                                    class="form-control proof-password-input {{ isset($proof['is_protected']) && $proof['is_protected'] ? '' : 'd-none' }}"
                                                    value="{{ $proof['password'] ?? '' }}" placeholder="Password"
                                                    style="max-width: 100px;">

                                                <button type="button" class="btn btn-danger"
                                                    onclick="this.closest('.proof-item').remove()">
                                                    <i class="ti ti-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mb-5">
                <button type="button" class="btn btn-outline-primary w-100" onclick="addAward()"
                    style="border-style: dashed;">
                    <i class="ti ti-plus me-1"></i> Add Certification / Award
                </button>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-5">
                <a href="{{ route('page') }}" class="btn btn-light px-4">Cancel</a>
                <button type="submit" class="btn btn-primary hs-save-btn px-4">Save Changes</button>
            </div>
        </form>
    </div>

    {{-- Hidden File Input for Uploads --}}
    <input type="file" id="globalMediaUploader" class="d-none">

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

        .btn-xs {
            padding: 2px 8px;
            font-size: 0.75rem;
        }
    </style>

    <script>
        let awardCounter = {{ count($awards) }};

        function addAward() {
            const container = document.getElementById('awardsContainer');
            const index = awardCounter++;
            const div = document.createElement('div');
            div.className = 'hs-card mb-4 award-item position-relative';
            div.dataset.index = index;
            div.innerHTML = `
                    <button type="button" class="btn btn-danger btn-sm position-absolute" 
                            style="top: -10px; right: -10px; border-radius: 50%; width: 25px; height: 25px; padding: 0; line-height: 25px; z-index: 5;"
                            onclick="this.closest('.award-item').remove()">
                        <i class="ti ti-x"></i>
                    </button>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label class="form-label small fw-bold">Year</label>
                            <input type="text" name="years[]" class="form-control" placeholder="e.g. 2025">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Award / Certificate Title</label>
                            <input type="text" name="titles[]" class="form-control" placeholder="Certificate Name">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label small fw-bold">Issuing Organization</label>
                            <input type="text" name="organizations[]" class="form-control" placeholder="e.g. HackerRank">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Description (Optional)</label>
                        <textarea name="descriptions[]" class="form-control" rows="2" placeholder="Brief details about this achievement..."></textarea>
                    </div>

                    <div class="p-3 bg-light rounded proofs-section">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small fw-bold text-muted"><i class="ti ti-award me-1"></i> Certificate Files & Proof</span>
                            <button type="button" class="btn btn-xs btn-primary py-0 px-2" onclick="addProof(${index})">
                                <i class="ti ti-plus"></i> Add Certificate
                            </button>
                        </div>
                        <div class="proofs-container"></div>
                    </div>
                `;
            container.appendChild(div);
            // Add initial proof automatically
            addProof(index);
        }

        function addProof(awardIndex) {
            const awardCard = document.querySelector(`.award-item[data-index="${awardIndex}"]`);
            const container = awardCard.querySelector('.proofs-container');
            const proofIndex = container.children.length;

            const div = document.createElement('div');
            div.className = 'proof-item mb-2';
            div.innerHTML = `
                    <div class="input-group input-group-sm">
                        <input type="text" name="proofs[${awardIndex}][${proofIndex}][label]" class="form-control" value="Certificate" style="max-width: 120px;">
                        <input type="text" name="proofs[${awardIndex}][${proofIndex}][value]" class="form-control proof-value-input" placeholder="Link or File URL">

                        <button type="button" class="btn btn-outline-secondary btn-upload-proof" title="Upload"><i class="ti ti-upload"></i></button>
                        <button type="button" class="btn btn-outline-secondary" title="Media Library" onclick="openMediaManager(this.closest('.input-group').querySelector('.proof-value-input'))"><i class="ti ti-photo"></i></button>

                        <div class="input-group-text bg-white">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input proof-lock-toggle" type="checkbox" name="proofs[${awardIndex}][${proofIndex}][is_protected]" value="1">
                                <i class="ti ti-lock ms-1 text-muted"></i>
                            </div>
                        </div>

                        <input type="text" name="proofs[${awardIndex}][${proofIndex}][password]" class="form-control proof-password-input d-none" placeholder="Password" style="max-width: 100px;">

                        <button type="button" class="btn btn-danger" onclick="this.closest('.proof-item').remove()">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                `;
            container.appendChild(div);
        }

        // Handle lock toggle
        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('proof-lock-toggle')) {
                const inputGroup = e.target.closest('.input-group');
                const passwordInput = inputGroup.querySelector('.proof-password-input');
                const lockIcon = inputGroup.querySelector('.ti-lock');

                if (e.target.checked) {
                    passwordInput.classList.remove('d-none');
                    lockIcon.classList.add('text-danger');
                    lockIcon.classList.remove('text-muted');
                } else {
                    passwordInput.classList.add('d-none');
                    lockIcon.classList.remove('text-danger');
                    lockIcon.classList.add('text-muted');
                }
            }
        });

        document.getElementById('awardSettingsForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const btn = this.querySelector('.hs-save-btn');
            const orig = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="ti ti-loader rotate-infinite me-2"></i> Saving...';

            $.ajax({
                url: "{{ route('admin.awards.save') }}",
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

        // Upload Logic
        let currentUploadInput = null;
        let currentUploadBtn = null;

        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-upload-proof');
            if (btn) {
                currentUploadBtn = btn;
                currentUploadInput = btn.closest('.input-group').querySelector('.proof-value-input');
                document.getElementById('globalMediaUploader').click();
            }
        });

        document.getElementById('globalMediaUploader').addEventListener('change', function (e) {
            if (this.files && this.files[0]) {
                const formData = new FormData();
                formData.append('file', this.files[0]);
                formData.append('_token', '{{ csrf_token() }}');

                const origIcon = currentUploadBtn.innerHTML;
                currentUploadBtn.disabled = true;
                currentUploadBtn.innerHTML = '<i class="ti ti-loader rotate-infinite"></i>';

                $.ajax({
                    url: "{{ route('admin.media.upload') }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: res => {
                        currentUploadBtn.disabled = false;
                        currentUploadBtn.innerHTML = origIcon;
                        if (res.success) {
                            currentUploadInput.value = res.url;
                            Swal.fire({ icon: 'success', title: 'Uploaded!', text: 'File uploaded successfully', timer: 1000, showConfirmButton: false });
                        }
                    },
                    error: xhr => {
                        currentUploadBtn.disabled = false;
                        currentUploadBtn.innerHTML = origIcon;
                        Swal.fire({ icon: 'error', title: 'Upload Failed', text: xhr.responseJSON?.message ?? 'Check file size and type' });
                    }
                });
                // Reset input
                this.value = '';
            }
        });
    </script>
    @include('admin.include.media_manager_modal')
@endsection