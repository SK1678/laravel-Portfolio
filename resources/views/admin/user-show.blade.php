@extends('admin.layouts.admin')

@section('content')
    <div class="user-profile-container px-3 pt-5">
        <!-- Profile Header Card -->
        <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-5 border-end d-flex align-items-center gap-4">
                        <div class="profile-img-wrapper">
                            @if($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}"
                                    class="rounded-circle object-fit-cover shadow-sm border border-3 border-light"
                                    style="width: 100px; height: 100px;" alt="{{ $user->name }}">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary text-white shadow-sm border border-3 border-light"
                                    style="width: 100px; height: 100px; font-size: 2.5rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-dark">{{ $user->name }}</h4>
                            <div class="d-flex align-items-center gap-2">
                                @php 
                                    $titles = !empty($user->profile_title) ? explode(',', $user->profile_title) : ['Professional Profile'];
                                @endphp
                                <p class="mb-0 text-primary small fw-semibold">
                                    @foreach($titles as $title)
                                        {{ trim($title) }}@if(!$loop->last) <span class="text-muted fw-normal mx-1">|</span> @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 ps-md-5 mt-4 mt-md-0">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <p class="text-muted extra-small mb-0">User ID</p>
                                    <p class="fw-bold text-dark small mb-0">#USR-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-muted extra-small mb-0">User Type</p>
                                    <span class="badge {{ $user->user_type == 'admin' ? 'bg-primary' : 'bg-secondary' }} extra-small">
                                        {{ ucfirst($user->user_type) }}
                                    </span>
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-muted extra-small mb-0">Email address</p>
                                    <p class="fw-bold text-dark small mb-0 text-truncate">{{ $user->email }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <p class="text-muted extra-small mb-0">Authority</p>
                                    @if($user->is_site_owner)
                                        <span class="badge bg-warning text-dark extra-small"><i class="ti ti-crown me-1"></i>Site Owner</span>
                                    @else
                                        <span class="text-muted small">Standard Access</span>
                                    @endif
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Information Grid -->
        <div class="row g-4">
            <!-- Left Column: Personal Information -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold text-secondary mb-0">Personal information</h5>
                        <a href="{{ route('user.edit', $user->id) }}" class="text-muted"><i class="ti ti-pencil"></i></a>
                    </div>
                    <div class="card-body px-4 pt-0">
                        <hr class="mt-0 mb-4 text-muted opacity-25">
                        <div class="row row-cols-2 g-4">
                            @php $personal = $user->additional_info['personal'] ?? []; @endphp
                            @forelse($personal as $item)
                                <div class="mb-3">
                                    <label class="text-muted small d-block mb-1">{{ $item['label'] ?? 'Detail' }}</label>
                                    <span class="fw-bold text-dark">{{ $item['value'] ?? '-' }}</span>
                                </div>
                            @empty
                                <div class="col-12 text-center py-3">
                                    <p class="text-muted small mb-0">No personal information details added.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Social & Professional Links -->
                <div class="card border-0 shadow-sm rounded-3 mt-4">
                    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold text-secondary mb-0">Web & Documents</h5>
                        <a href="{{ route('user.edit', $user->id) }}" class="text-muted"><i class="ti ti-pencil"></i></a>
                    </div>
                    <div class="card-body px-4 pt-0">
                        <hr class="mt-0 mb-4 text-muted opacity-25">
                        
                        <!-- CV Download -->
                        @if(isset($user->additional_info['cv']) && $user->additional_info['cv'])
                            <div class="mb-4">
                                <a href="{{ asset('storage/' . $user->additional_info['cv']['path']) }}" target="_blank" class="btn btn-primary btn-sm w-100 rounded-pill fw-medium shadow-sm">
                                    <i class="ti ti-file-cv me-2"></i> Download {{ $user->additional_info['cv']['name'] ?? 'Resume / CV' }}
                                </a>
                            </div>
                        @endif

                        <!-- Social Links -->
                        @php $socialLinks = $user->additional_info['social_links'] ?? []; @endphp
                        @if(!empty($socialLinks))
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($socialLinks as $item)
                                    @php
                                        $rawLabel = $item['label'] ?? 'ti-link';
                                        
                                        // If they just typed a word like 'Fb' or 'Facebook' instead of an icon class
                                        if (!str_contains($rawLabel, '-')) {
                                            $iconClass = 'ti ti-link';
                                            $readableLabel = $rawLabel;
                                        } else {
                                            $iconClass = $rawLabel;
                                            
                                            // Auto-fix for Tabler Icons if they forgot the 'brand-' prefix
                                            $commonBrands = ['twitter', 'facebook', 'linkedin', 'github', 'instagram', 'youtube', 'dribbble', 'behance', 'pinterest', 'skype'];
                                            foreach ($commonBrands as $brand) {
                                                if (str_contains($iconClass, "ti-{$brand}") && !str_contains($iconClass, "ti-brand-{$brand}")) {
                                                    $iconClass = str_replace("ti-{$brand}", "ti-brand-{$brand}", $iconClass);
                                                }
                                            }

                                            if (!str_contains($iconClass, 'ti ')) {
                                                $iconClass = 'ti ' . $iconClass;
                                            }
                                            // Extract a readable name from the class
                                            $readableLabel = str_replace(['ti-brand-', 'ti-', 'ti '], '', $iconClass);
                                        }
                                    @endphp
                                    
                                    <a href="{{ $item['link'] ?? '#' }}" target="_blank" class="btn btn-sm btn-light border-0 text-dark rounded-pill px-3 py-2 fw-medium d-inline-flex align-items-center gap-2 text-decoration-none">
                                        <i class="{{ $iconClass }} fs-6 text-primary"></i> 
                                        <span class="text-capitalize">{{ $readableLabel ?: 'Link' }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-2">
                                <p class="text-muted small mb-0">No links added.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Education & Account Information -->
            <div class="col-lg-7 d-flex flex-column gap-4">
                <!-- Education Information -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold text-secondary mb-0">Education information</h5>
                        <a href="{{ route('user.edit', $user->id) }}" class="text-muted"><i class="ti ti-pencil"></i></a>
                    </div>
                    <div class="card-body px-4 pt-0">
                        <hr class="mt-0 mb-4 text-muted opacity-25">
                        @php $education = $user->additional_info['education'] ?? []; @endphp
                        @forelse($education as $item)
                            <div class="education-item mb-4 pb-3 border-bottom border-light last-child-no-border">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-bold text-dark fs-6">{{ $item['degree'] ?? 'Degree' }}</span>
                                    <span class="fw-bold text-dark small">{{ $item['year'] ?? '' }}</span>
                                </div>
                                <div class="mb-2">
                                    <p class="text-primary fw-medium small mb-1">{{ $item['major'] ?? 'Major' }}</p>
                                    <p class="text-muted small mb-1"><i class="ti ti-school me-1"></i>{{ $item['institution'] ?? 'Institution' }}</p>
                                    <div class="d-flex gap-3 extra-small text-muted">
                                        <span><i class="ti ti-calendar me-1"></i>{{ $item['duration'] ?? 'N/A' }}</span>
                                        <span><i class="ti ti-award me-1"></i>{{ $item['result'] ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                
                                <!-- Attachments -->
                                @if(!empty($item['documents']))
                                    <div class="mt-3 d-flex flex-wrap gap-2">
                                        @foreach($item['documents'] as $doc)
                                            @php
                                                $ext = pathinfo($doc['path'], PATHINFO_EXTENSION);
                                                $icon = match(strtolower($ext)) {
                                                    'pdf' => 'file-type-pdf',
                                                    'doc', 'docx' => 'file-text',
                                                    'xls', 'xlsx' => 'file-spreadsheet',
                                                    'png', 'jpg', 'jpeg' => 'photo',
                                                    'zip', 'rar' => 'zip',
                                                    default => 'paperclip',
                                                };
                                                if (isset($doc['password']) && $doc['password']) $icon = 'lock-square';
                                            @endphp
                                            <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" 
                                               class="btn btn-extra-sm btn-light border d-inline-flex align-items-center gap-1 rounded-pill px-3 py-1 fw-semibold text-primary transition-all hover-shadow"
                                               title="{{ isset($doc['password']) && $doc['password'] ? 'Password Protected' : 'Open Document' }}">
                                                <i class="ti ti-{{ $icon }} fs-6"></i>
                                                {{ $doc['name'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted small text-center my-3">No education history added.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Account Information -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold text-secondary mb-0">Professional Experience</h5>
                        <a href="{{ route('user.edit', $user->id) }}" class="text-muted"><i class="ti ti-pencil"></i></a>
                    </div>
                    <div class="card-body px-4 pt-0 pb-4">
                        <hr class="mt-0 mb-4 text-muted opacity-25">
                        <div class="row g-4">
                            @php $professional = $user->additional_info['professional'] ?? []; @endphp
                            @forelse($professional as $item)
                                <div class="col-12 professional-item mb-3 pb-3 border-bottom border-light last-child-no-border">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0 fs-6">{{ $item['role'] ?? 'Role' }}</h6>
                                            <p class="text-success fw-medium small mb-0">{{ $item['company'] ?? 'Company' }}</p>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-light text-dark border extra-small">
                                                {{ isset($item['start_date']) && $item['start_date'] ? \Carbon\Carbon::parse($item['start_date'])->format('M Y') : 'N/A' }} - 
                                                {{ isset($item['end_date']) && $item['end_date'] ? \Carbon\Carbon::parse($item['end_date'])->format('M Y') : 'Present' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @if(isset($item['description']) && $item['description'])
                                        <p class="text-muted small mb-3 lh-sm" style="text-align: justify;">{{ $item['description'] }}</p>
                                    @endif

                                    <!-- Experience Attachments -->
                                    @if(!empty($item['documents']))
                                        <div class="mt-3 d-flex flex-wrap gap-2">
                                            @foreach($item['documents'] as $doc)
                                                @php
                                                    $ext = pathinfo($doc['path'], PATHINFO_EXTENSION);
                                                    $icon = match(strtolower($ext)) {
                                                        'pdf' => 'file-type-pdf',
                                                        'doc', 'docx' => 'file-text',
                                                        'xls', 'xlsx' => 'file-spreadsheet',
                                                        'png', 'jpg', 'jpeg' => 'photo',
                                                        'zip', 'rar' => 'zip',
                                                        default => 'paperclip',
                                                    };
                                                    if (isset($doc['password']) && $doc['password']) $icon = 'lock-square';
                                                @endphp
                                                <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" 
                                                   class="btn btn-extra-sm btn-light border d-inline-flex align-items-center gap-1 rounded-pill px-3 py-1 fw-semibold text-success transition-all hover-shadow"
                                                   title="{{ isset($doc['password']) && $doc['password'] ? 'Password Protected' : 'Open Document' }}">
                                                    <i class="ti ti-{{ $icon }} fs-6"></i>
                                                    {{ $doc['name'] }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="col-12 text-center py-4">
                                    <i class="ti ti-briefcase text-muted fs-1 opacity-25 mb-2 d-block"></i>
                                    <p class="text-muted small mb-0">No professional experience added yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .nav-underline .nav-link {
            white-space: nowrap;
        }

        .card-title {
            letter-spacing: 0.2px;
        }

        .fw-bold {
            color: #2b3a4a !important;
        }

        .text-muted {
            color: #8c98a5 !important;
        }

        .btn-extra-sm {
            padding: 0.15rem 0.6rem;
            font-size: 0.7rem;
            letter-spacing: 0.3px;
        }

        .hover-shadow:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.08) !important;
            transform: translateY(-1px);
            background-color: #fdfdfd !important;
        }

        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        .last-child-no-border:last-child {
            border-bottom: 0 !important;
        }
    </style>
@endsection