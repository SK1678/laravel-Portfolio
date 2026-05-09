@extends('admin.layouts.admin')

@section('title', 'Skills')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Skills</h4>
                <p class="mb-0">Manage your expertise</p>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Page Configurations</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="ti ti-layout-dashboard fs-1 text-primary opacity-50" style="font-size: 5rem;"></i>
                    </div>
                    <h2 class="fw-bold">Module Under Construction</h2>
                    <p class="text-muted mx-auto" style="max-width: 500px;">
                        We are currently building a powerful landing page builder that will allow you to drag-and-drop sections, customize layouts, and manage your site's content effortlessly.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary px-4">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
