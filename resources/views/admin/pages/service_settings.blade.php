@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Services Manager</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Services</li>
                    </ol>
                </div>
            </div>
        </div>

        <form id="servicesForm">
            @csrf
            {{-- Section Headers --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Section Headers</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Main Title</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ $serviceSetting->title ?? 'Services' }}" placeholder="e.g. My Services">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" class="form-control"
                                value="{{ $serviceSetting->subtitle ?? '' }}" placeholder="Enter section description">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Services List --}}
            <div id="servicesContainer">
                @if ($services && count($services) > 0)
                    @foreach ($services as $index => $service)
                        <div class="card service-card mb-3 position-relative" data-index="{{ $index }}">
                            <div class="card-body">
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-service">
                                    <i class="ti ti-x"></i>
                                </button>
                                <input type="hidden" name="services[{{ $index }}][id]" value="{{ $service->id }}">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label small fw-bold">Service Title</label>
                                        <input type="text" name="services[{{ $index }}][title]" class="form-control"
                                            value="{{ $service->title }}" placeholder="e.g. Web Development">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label small fw-bold">Icon Class (Bootstrap Icons)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="bi {{ $service->icon ?? 'bi-briefcase' }}"></i></span>
                                            <input type="text" name="services[{{ $index }}][icon]" class="form-control icon-input"
                                                value="{{ $service->icon }}" placeholder="e.g. bi-activity">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label small fw-bold">Description</label>
                                        <textarea name="services[{{ $index }}][description]" class="form-control" rows="2" placeholder="Describe the service...">{{ $service->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="text-center mb-4">
                <button type="button" id="addService" class="btn btn-outline-primary px-4 border-dashed w-100 py-3">
                    <i class="ti ti-plus me-1"></i> Add New Service
                </button>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-5">
                <a href="{{ route('admin.services') }}" class="btn btn-light px-4">Cancel</a>
                <button type="submit" class="btn btn-primary px-5 shadow">Save Changes</button>
            </div>
        </form>
    </div>

    <style>
        .service-card {
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }
        .service-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .border-dashed {
            border-style: dashed !important;
        }
    </style>

@push('scripts')
    <script>
        $(document).ready(function() {
            let serviceIndex = {{ count($services) }};

            // Add Service
            $('#addService').click(function() {
                const html = `
                <div class="card service-card mb-3 position-relative" data-index="${serviceIndex}">
                    <div class="card-body">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-service">
                            <i class="ti ti-x"></i>
                        </button>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-bold">Service Title</label>
                                <input type="text" name="services[${serviceIndex}][title]" class="form-control" placeholder="e.g. App Design">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small fw-bold">Icon Class</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-briefcase"></i></span>
                                    <input type="text" name="services[${serviceIndex}][icon]" class="form-control icon-input" placeholder="e.g. bi-cpu">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label small fw-bold">Description</label>
                                <textarea name="services[${serviceIndex}][description]" class="form-control" rows="2" placeholder="Describe the service..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>`;
                $('#servicesContainer').append(html);
                serviceIndex++;
            });

            // Remove Service
            $(document).on('click', '.remove-service', function() {
                $(this).closest('.service-card').fadeOut(300, function() {
                    $(this).remove();
                });
            });

            // Update Icon Preview
            $(document).on('input', '.icon-input', function() {
                const icon = $(this).val();
                $(this).closest('.input-group').find('i').attr('class', 'bi ' + icon);
            });

            // Submit Form
            $('#servicesForm').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                Swal.fire({
                    title: 'Saving...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: "{{ route('admin.services.save') }}",
                    method: 'POST',
                    data: formData,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: res.message,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong!'
                        });
                    }
                });
            });
        });
    </script>
@endpush
@endsection
