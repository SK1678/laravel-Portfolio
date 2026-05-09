@extends('admin.layouts.admin')

@section('content')
    <div class="row justify-content-center pt-5">
        <div class="col-lg-11">
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h3 mb-0 text-gray-800 fw-bold">Edit User Profile</h2>
                        <p class="text-muted small mb-0">Update account settings and professional history</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.show', $user->id) }}" class="btn btn-light border btn-sm px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary shadow-sm btn-sm px-4">Save Changes</button>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Left: Core Information -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div class="card-body text-center p-4">
                                <div class="profile-upload-container mb-3">
                                    <input type="file" name="profile_image" id="profile_image" class="d-none"
                                        accept="image/*" onchange="previewImage(this)">
                                    <label for="profile_image"
                                        class="profile-preview-wrapper shadow-sm border d-flex align-items-center justify-content-center overflow-hidden rounded-circle bg-white mx-auto"
                                        style="width: 130px; height: 130px; cursor: pointer;">
                                        @if($user->profile_image)
                                            <img id="image_preview" src="{{ asset('storage/' . $user->profile_image) }}"
                                                class="w-100 h-100 object-fit-cover" alt="Preview">
                                        @else
                                            <img id="image_preview" src="" class="w-100 h-100 object-fit-cover d-none"
                                                alt="Preview">
                                            <div id="upload_placeholder" class="text-center text-muted">
                                                <i class="ti ti-camera fs-2"></i>
                                            </div>
                                        @endif
                                    </label>
                                </div>
                                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                                <p class="text-muted small">{{ $user->email }}</p>

                                <div class="text-start mt-4">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-secondary">User Type</label>
                                        <select name="user_type" class="form-select shadow-none">
                                            <option value="user" {{ $user->user_type == 'user' ? 'selected' : '' }}>User
                                            </option>
                                            <option value="admin" {{ $user->user_type == 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch mt-4">
                                            <input class="form-check-input shadow-none" type="checkbox" name="is_site_owner"
                                                id="is_site_owner" value="1" {{ $user->is_site_owner ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold text-dark" for="is_site_owner">Site
                                                Owner</label>
                                        </div>
                                        <p class="text-muted extra-small mt-1 ms-1">Grants full system control and priority
                                            visibility.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                <h6 class="fw-bold text-secondary mb-3">Core Credentials</h6>
                                <div class="mb-3">
                                    <label class="form-label small fw-medium">Full Name</label>
                                    <input type="text" name="name" class="form-control shadow-none"
                                        value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-medium">Profile Title</label>
                                    <input type="text" name="profile_title" class="form-control shadow-none"
                                        value="{{ old('profile_title', $user->profile_title) }}"
                                        placeholder="e.g. UI Designer, UX Expert">
                                    <p class="extra-small text-muted mt-1">Separate multiple titles with commas.</p>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label small fw-medium">Email Address</label>
                                    <input type="email" name="email" class="form-control shadow-none"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Social & Professional Links & CV -->
                        <!-- CV Uploader -->
                        <div class="card border-0 shadow-sm rounded-3 mt-4">
                            <div class="card-header bg-white border-0 py-3 px-4">
                                <h6 class="mb-0 fw-bold text-secondary">Curriculum Vitae (CV) / Resume</h6>
                            </div>
                            <div class="card-body px-4">
                                <div class="row align-items-center">
                                    <div class="col-md-12">
                                        <input type="file" name="cv_file" class="form-control form-control-sm shadow-none"
                                            accept=".pdf,.doc,.docx">
                                    </div>
                                    @if(isset($user->additional_info['cv']) && $user->additional_info['cv'])
                                        <div class="col-md-12 mt-2 mt-md-0">
                                            <a href="{{ asset('storage/' . $user->additional_info['cv']['path']) }}"
                                                target="_blank" class="btn btn-sm btn-success w-100">
                                                <i class="ti ti-download me-1"></i> Current CV
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-3 mt-4">
                            <div
                                class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-secondary">Social & Professional Links</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                    onclick="addItem('social-container', 'social_links')">
                                    <i class="ti ti-plus me-1"></i>Link
                                </button>
                            </div>

                            <div class="card-body px-4 pt-0" id="social-container">
                                <hr class="mt-0 mb-4 opacity-25">


                                <h6 class="fw-bold text-secondary small mb-3">Web Links</h6>
                                @php $socialLinks = $user->additional_info['social_links'] ?? []; @endphp
                                @foreach($socialLinks as $index => $item)
                                    <div class="row g-2 mb-3 line-item align-items-center">
                                        <div class="col-md-4">
                                            <input type="text" name="social_links[{{ $index }}][label]"
                                                class="form-control form-control-sm shadow-none"
                                                placeholder="Icon Class (e.g. ti ti-brand-linkedin)" value="{{ $item['label'] ?? '' }}">
                                        </div>
                                        <div class="col-md-7">
                                            <input type="url" name="social_links[{{ $index }}][link]"
                                                class="form-control form-control-sm shadow-none" placeholder="https://..."
                                                value="{{ $item['link'] ?? '' }}">
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button type="button" class="btn btn-sm btn-light text-danger border-0"
                                                onclick="removeItem(this)"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                                @if(empty($socialLinks))
                                    <p class="text-muted small text-center my-3 no-items">No links added.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right: Dynamic Line Items -->
                    <div class="col-md-8">
                        <!-- Personal Information Repeater -->
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div
                                class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-secondary">Personal Information Details</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                    onclick="addItem('personal-container', 'personal_info')">
                                    <i class="ti ti-plus me-1"></i> Add Detail
                                </button>
                            </div>
                            <div class="card-body px-4 pt-0" id="personal-container">
                                <hr class="mt-0 mb-4 opacity-25">
                                @php $personal = $user->additional_info['personal'] ?? []; @endphp
                                @foreach($personal as $index => $item)
                                    <div class="row g-2 mb-3 line-item">
                                        <div class="col-md-5">
                                            <input type="text" name="personal_info[{{ $index }}][label]"
                                                class="form-control form-control-sm shadow-none"
                                                placeholder="Label (e.g. Gender)" value="{{ $item['label'] ?? '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="personal_info[{{ $index }}][value]"
                                                class="form-control form-control-sm shadow-none"
                                                placeholder="Value (e.g. Female)" value="{{ $item['value'] ?? '' }}">
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-sm btn-light text-danger border-0"
                                                onclick="removeItem(this)"><i class="ti ti-trash"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                                @if(empty($personal))
                                    <p class="text-muted small text-center my-3 no-items">No personal details added.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Education Repeater -->
                        <div class="card border-0 shadow-sm rounded-3 mb-4">
                            <div
                                class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-secondary">Education History & Document Vault</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                    onclick="addItem('education-container', 'education_info')">
                                    <i class="ti ti-plus me-1"></i> Add Education
                                </button>
                            </div>
                            <div class="card-body px-4 pt-0" id="education-container">
                                <hr class="mt-0 mb-4 opacity-25">
                                @php $education = $user->additional_info['education'] ?? []; @endphp
                                @foreach($education as $index => $item)
                                    <div class="education-block p-3 border rounded-3 mb-4 bg-light bg-opacity-10 line-item">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h6 class="fw-bold text-primary mb-0 small">Entry #{{ $loop->iteration }}</h6>
                                            <button type="button" class="btn btn-sm btn-light text-danger border-0"
                                                onclick="removeItem(this)"><i class="ti ti-trash"></i></button>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label extra-small fw-bold">Degree</label>
                                                <input type="text" name="education_info[{{ $index }}][degree]"
                                                    class="form-control form-control-sm shadow-none" placeholder="e.g. BSc"
                                                    value="{{ $item['degree'] ?? '' }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label extra-small fw-bold">Group / Major</label>
                                                <input type="text" name="education_info[{{ $index }}][major]"
                                                    class="form-control form-control-sm shadow-none"
                                                    placeholder="e.g. Computer Science" value="{{ $item['major'] ?? '' }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label extra-small fw-bold">Institution</label>
                                                <input type="text" name="education_info[{{ $index }}][institution]"
                                                    class="form-control form-control-sm shadow-none"
                                                    placeholder="e.g. Harvard University"
                                                    value="{{ $item['institution'] ?? '' }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label extra-small fw-bold">Duration</label>
                                                <input type="text" name="education_info[{{ $index }}][duration]"
                                                    class="form-control form-control-sm shadow-none" placeholder="e.g. 4 Years"
                                                    value="{{ $item['duration'] ?? '' }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label extra-small fw-bold">Result / CGPA</label>
                                                <input type="text" name="education_info[{{ $index }}][result]"
                                                    class="form-control form-control-sm shadow-none" placeholder="e.g. 3.85"
                                                    value="{{ $item['result'] ?? '' }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label extra-small fw-bold">Passing Year</label>
                                                <input type="text" name="education_info[{{ $index }}][year]"
                                                    class="form-control form-control-sm shadow-none" placeholder="e.g. 2022"
                                                    value="{{ $item['year'] ?? '' }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label extra-small fw-bold">Description</label>
                                                <textarea name="education_info[{{ $index }}][description]"
                                                    class="form-control form-control-sm shadow-none" rows="2"
                                                    placeholder="Briefly describe your course or achievements...">{{ $item['description'] ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Document Vault for this Education -->
                                        <div class="document-vault mt-3 pt-3 border-top">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="extra-small fw-bold text-muted"><i
                                                        class="ti ti-file-certificate me-1"></i> Document Vault</label>
                                                <button type="button" class="btn btn-extra-sm btn-outline-secondary py-0 px-2"
                                                    onclick="addDocument(this, {{ $index }})">+ Add File</button>
                                            </div>
                                            <div class="document-list">
                                                @php $docs = $item['documents'] ?? []; @endphp
                                                @foreach($docs as $docIndex => $doc)
                                                    <div class="row g-2 mb-2 align-items-center doc-item">
                                                        <div class="col-md-3">
                                                            <input type="text"
                                                                name="education_info[{{ $index }}][existing_docs][{{ $docIndex }}][name]"
                                                                class="form-control form-control-xs shadow-none"
                                                                placeholder="Doc Name" value="{{ $doc['name'] }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank"
                                                                class="text-primary extra-small d-block text-truncate mt-1">
                                                                <i class="ti ti-paperclip me-1"></i> View File
                                                            </a>
                                                            <input type="hidden"
                                                                name="education_info[{{ $index }}][existing_docs][{{ $docIndex }}][path]"
                                                                value="{{ $doc['path'] }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="password"
                                                                name="education_info[{{ $index }}][existing_docs][{{ $docIndex }}][password]"
                                                                class="form-control form-control-xs shadow-none"
                                                                placeholder="Password" value="{{ $doc['password'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-1 text-end">
                                                            <button type="button" class="btn btn-sm text-danger p-0"
                                                                onclick="this.closest('.doc-item').remove()"><i
                                                                    class="ti ti-x"></i></button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if(empty($education))
                                    <p class="text-muted small text-center my-3 no-items">No education history added.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Professional Repeater -->
                        <div class="card border-0 shadow-sm rounded-3">
                            <div
                                class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-secondary">Professional Experience & Experience Vault</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                    onclick="addItem('pro-container', 'professional_info')">
                                    <i class="ti ti-plus me-1"></i> Add Experience
                                </button>
                            </div>
                            <div class="card-body px-4 pt-0" id="pro-container">
                                <hr class="mt-0 mb-4 opacity-25">
                                @php $professional = $user->additional_info['professional'] ?? []; @endphp
                                @foreach($professional as $index => $item)
                                    <div class="professional-block p-3 border rounded-3 mb-4 bg-light bg-opacity-10 line-item">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h6 class="fw-bold text-success mb-0 small">Experience #{{ $loop->iteration }}</h6>
                                            <button type="button" class="btn btn-sm btn-light text-danger border-0"
                                                onclick="removeItem(this)"><i class="ti ti-trash"></i></button>
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label extra-small fw-bold">Role Title</label>
                                                <input type="text" name="professional_info[{{ $index }}][role]"
                                                    class="form-control form-control-sm shadow-none"
                                                    placeholder="e.g. Senior Developer" value="{{ $item['role'] ?? '' }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label extra-small fw-bold">Company</label>
                                                <input type="text" name="professional_info[{{ $index }}][company]"
                                                    class="form-control form-control-sm shadow-none"
                                                    placeholder="e.g. Google Inc." value="{{ $item['company'] ?? '' }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label extra-small fw-bold">Job Description</label>
                                                <textarea name="professional_info[{{ $index }}][description]"
                                                    class="form-control form-control-sm shadow-none" rows="2"
                                                    placeholder="Describe your responsibilities...">{{ $item['description'] ?? '' }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label extra-small fw-bold">Start Date</label>
                                                <input type="date" name="professional_info[{{ $index }}][start_date]"
                                                    class="form-control form-control-sm shadow-none"
                                                    value="{{ $item['start_date'] ?? '' }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label extra-small fw-bold">End Date</label>
                                                <input type="date" name="professional_info[{{ $index }}][end_date]"
                                                    class="form-control form-control-sm shadow-none"
                                                    value="{{ $item['end_date'] ?? '' }}">
                                                <p class="extra-small text-muted mb-0 mt-1">Leave blank if currently working
                                                    here.</p>
                                            </div>
                                        </div>

                                        <!-- Experience Vault -->
                                        <div class="document-vault mt-3 pt-3 border-top">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="extra-small fw-bold text-muted"><i
                                                        class="ti ti-briefcase me-1"></i>
                                                    Experience Vault</label>
                                                <button type="button" class="btn btn-extra-sm btn-outline-secondary py-0 px-2"
                                                    onclick="addProDocument(this, {{ $index }})">+ Add File</button>
                                            </div>
                                            <div class="document-list">
                                                @php $docs = $item['documents'] ?? []; @endphp
                                                @foreach($docs as $docIndex => $doc)
                                                    <div class="row g-2 mb-2 align-items-center doc-item">
                                                        <div class="col-md-3">
                                                            <input type="text"
                                                                name="professional_info[{{ $index }}][existing_docs][{{ $docIndex }}][name]"
                                                                class="form-control form-control-xs shadow-none"
                                                                placeholder="Doc Name" value="{{ $doc['name'] }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank"
                                                                class="text-success extra-small d-block text-truncate mt-1">
                                                                <i class="ti ti-paperclip me-1"></i> View File
                                                            </a>
                                                            <input type="hidden"
                                                                name="professional_info[{{ $index }}][existing_docs][{{ $docIndex }}][path]"
                                                                value="{{ $doc['path'] }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="password"
                                                                name="professional_info[{{ $index }}][existing_docs][{{ $docIndex }}][password]"
                                                                class="form-control form-control-xs shadow-none"
                                                                placeholder="Password" value="{{ $doc['password'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-1 text-end">
                                                            <button type="button" class="btn btn-sm text-danger p-0"
                                                                onclick="this.closest('.doc-item').remove()"><i
                                                                    class="ti ti-x"></i></button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if(empty($professional))
                                    <p class="text-muted small text-center my-3 no-items">No professional experience added.</p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('image_preview');
            const placeholder = document.getElementById('upload_placeholder');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    if (placeholder) placeholder.classList.add('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function addItem(containerId, fieldName) {
            const container = document.getElementById(containerId);
            const noItems = container.querySelector('.no-items');
            if (noItems) noItems.remove();

            const index = Date.now(); // Use timestamp as unique index
            let html = '';
            if (fieldName === 'personal_info') {
                html = `
                                                                                        <div class="row g-2 mb-3 line-item">
                                                                                            <div class="col-md-5"><input type="text" name="personal_info[${index}][label]" class="form-control form-control-sm shadow-none" placeholder="Label"></div>
                                                                                            <div class="col-md-6"><input type="text" name="personal_info[${index}][value]" class="form-control form-control-sm shadow-none" placeholder="Value"></div>
                                                                                            <div class="col-md-1"><button type="button" class="btn btn-sm btn-light text-danger border-0" onclick="removeItem(this)"><i class="ti ti-trash"></i></button></div>
                                                                                        </div>`;
            } else if (fieldName === 'education_info') {
                html = `
                                                                                        <div class="education-block p-3 border rounded-3 mb-4 bg-light bg-opacity-10 line-item">
                                                                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                                                                <h6 class="fw-bold text-primary mb-0 small">New Entry</h6>
                                                                                                <button type="button" class="btn btn-sm btn-light text-danger border-0" onclick="removeItem(this)"><i class="ti ti-trash"></i></button>
                                                                                            </div>
                                                                                            <div class="row g-3 mb-3">
                                                                                                <div class="col-md-4"><label class="form-label extra-small fw-bold">Degree</label><input type="text" name="education_info[${index}][degree]" class="form-control form-control-sm shadow-none" placeholder="e.g. BSc"></div>
                                                                                                <div class="col-md-4"><label class="form-label extra-small fw-bold">Group / Major</label><input type="text" name="education_info[${index}][major]" class="form-control form-control-sm shadow-none" placeholder="e.g. Computer Science"></div>
                                                                                                <div class="col-md-4"><label class="form-label extra-small fw-bold">Institution</label><input type="text" name="education_info[${index}][institution]" class="form-control form-control-sm shadow-none" placeholder="Institution"></div>
                                                                                                <div class="col-md-3"><label class="form-label extra-small fw-bold">Duration</label><input type="text" name="education_info[${index}][duration]" class="form-control form-control-sm shadow-none" placeholder="Duration"></div>
                                                                                                <div class="col-md-3"><label class="form-label extra-small fw-bold">Result</label><input type="text" name="education_info[${index}][result]" class="form-control form-control-sm shadow-none" placeholder="Result"></div>
                                                                                                <div class="col-md-3"><label class="form-label extra-small fw-bold">Passing Year</label><input type="text" name="education_info[${index}][year]" class="form-control form-control-sm shadow-none" placeholder="Year"></div>
                                                                                                <div class="col-12"><label class="form-label extra-small fw-bold">Description</label><textarea name="education_info[${index}][description]" class="form-control form-control-sm shadow-none" rows="2" placeholder="Responsibilities..."></textarea></div>
                                                                                            </div>
                                                                                            <div class="document-vault mt-3 pt-3 border-top">
                                                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                                                    <label class="extra-small fw-bold text-muted"><i class="ti ti-file-certificate me-1"></i> Document Vault</label>
                                                                                                    <button type="button" class="btn btn-extra-sm btn-outline-secondary py-0 px-2" onclick="addDocument(this, ${index})">+ Add File</button>
                                                                                                </div>
                                                                                                <div class="document-list"></div>
                                                                                            </div>
                                                                                        </div>`;
            } else if (fieldName === 'professional_info') {
                html = `
                                                                                        <div class="professional-block p-3 border rounded-3 mb-4 bg-light bg-opacity-10 line-item">
                                                                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                                                                <h6 class="fw-bold text-success mb-0 small">New Experience</h6>
                                                                                                <button type="button" class="btn btn-sm btn-light text-danger border-0" onclick="removeItem(this)"><i class="ti ti-trash"></i></button>
                                                                                            </div>
                                                                                            <div class="row g-3 mb-3">
                                                                                                <div class="col-md-6"><label class="form-label extra-small fw-bold">Role Title</label><input type="text" name="professional_info[${index}][role]" class="form-control form-control-sm shadow-none" placeholder="Role Title"></div>
                                                                                                <div class="col-md-6"><label class="form-label extra-small fw-bold">Company</label><input type="text" name="professional_info[${index}][company]" class="form-control form-control-sm shadow-none" placeholder="Company"></div>
                                                                                                <div class="col-12"><label class="form-label extra-small fw-bold">Job Description</label><textarea name="professional_info[${index}][description]" class="form-control form-control-sm shadow-none" rows="2" placeholder="Responsibilities..."></textarea></div>
                                                                                                <div class="col-md-6"><label class="form-label extra-small fw-bold">Start Date</label><input type="date" name="professional_info[${index}][start_date]" class="form-control form-control-sm shadow-none"></div>
                                                                                                <div class="col-md-6"><label class="form-label extra-small fw-bold">End Date</label><input type="date" name="professional_info[${index}][end_date]" class="form-control form-control-sm shadow-none"></div>
                                                                                            </div>
                                                                                            <div class="document-vault mt-3 pt-3 border-top">
                                                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                                                    <label class="extra-small fw-bold text-muted"><i class="ti ti-briefcase me-1"></i> Experience Vault</label>
                                                                                                    <button type="button" class="btn btn-extra-sm btn-outline-secondary py-0 px-2" onclick="addProDocument(this, ${index})">+ Add File</button>
                                                                                                </div>
                                                                                                <div class="document-list"></div>
                                                                                            </div>
                                                                                        </div>`;
            } else if (fieldName === 'social_links') {
                html = `
                                                                                        <div class="row g-2 mb-3 line-item align-items-center">
                                                                                            <div class="col-md-4"><input type="text" name="social_links[${index}][label]" class="form-control form-control-sm shadow-none" placeholder="Icon Class (e.g. ti-brand-linkedin)"></div>
                                                                                            <div class="col-md-7"><input type="url" name="social_links[${index}][link]" class="form-control form-control-sm shadow-none" placeholder="https://..."></div>
                                                                                            <div class="col-md-1 text-end"><button type="button" class="btn btn-sm btn-light text-danger border-0" onclick="removeItem(this)"><i class="ti ti-trash"></i></button></div>
                                                                                        </div>`;
            }
            container.insertAdjacentHTML('beforeend', html);
        }

        function addDocument(btn, eduIndex) {
            const list = btn.closest('.document-vault').querySelector('.document-list');
            const docIndex = Date.now();
            const html = `
                                                                                    <div class="row g-2 mb-2 align-items-center doc-item">
                                                                                        <div class="col-md-3"><input type="text" name="education_info[${eduIndex}][new_docs][${docIndex}][name]" class="form-control form-control-xs shadow-none" placeholder="Doc Name"></div>
                                                                                        <div class="col-md-4"><input type="file" name="education_info[${eduIndex}][new_docs][${docIndex}][file]" class="form-control form-control-xs shadow-none"></div>
                                                                                        <div class="col-md-4"><input type="password" name="education_info[${eduIndex}][new_docs][${docIndex}][password]" class="form-control form-control-xs shadow-none" placeholder="Protect Password"></div>
                                                                                        <div class="col-md-1 text-end"><button type="button" class="btn btn-sm text-danger p-0" onclick="this.closest('.doc-item').remove()"><i class="ti ti-x"></i></button></div>
                                                                                    </div>`;
            list.insertAdjacentHTML('beforeend', html);
        }

        function addProDocument(btn, proIndex) {
            const list = btn.closest('.document-vault').querySelector('.document-list');
            const docIndex = Date.now();
            const html = `
                                                                                    <div class="row g-2 mb-2 align-items-center doc-item">
                                                                                        <div class="col-md-3"><input type="text" name="professional_info[${proIndex}][new_docs][${docIndex}][name]" class="form-control form-control-xs shadow-none" placeholder="Doc Name"></div>
                                                                                        <div class="col-md-4"><input type="file" name="professional_info[${proIndex}][new_docs][${docIndex}][file]" class="form-control form-control-xs shadow-none"></div>
                                                                                        <div class="col-md-4"><input type="password" name="professional_info[${proIndex}][new_docs][${docIndex}][password]" class="form-control form-control-xs shadow-none" placeholder="Protect Password"></div>
                                                                                        <div class="col-md-1 text-end"><button type="button" class="btn btn-sm text-danger p-0" onclick="this.closest('.doc-item').remove()"><i class="ti ti-x"></i></button></div>
                                                                                    </div>`;
            list.insertAdjacentHTML('beforeend', html);
        }

        function removeItem(btn) {
            const lineItem = btn.closest('.line-item');
            if (lineItem) {
                const container = lineItem.parentElement;
                lineItem.remove();
                if (container.querySelectorAll('.line-item').length === 0) {
                    container.insertAdjacentHTML('beforeend', '<p class="text-muted small text-center my-3 no-items">No items added.</p>');
                }
            }
        }
    </script>

    <style>
        .extra-small {
            font-size: 0.75rem;
        }

        .form-control-sm {
            padding: 0.4rem 0.75rem;
            font-size: 0.85rem;
        }

        .form-control-xs {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .btn-extra-sm {
            font-size: 0.7rem;
        }
    </style>
@endsection