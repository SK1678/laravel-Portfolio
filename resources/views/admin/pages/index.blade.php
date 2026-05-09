@extends('admin.layouts.admin')

@section('title', 'Page Configurations')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Page Configurations</h4>
                    <p class="mb-3 text-muted">Manage your landing page sections</p>
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
            <!-- Home Section Card -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="section-card shadow-sm border-0">
                    <a href="{{ route('admin.page.home') }}"
                        class="text-center w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="section-icon-container bg-light-primary text-primary mb-3">
                            <i class="ti ti-home fs-1"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Home</h6>
                    </a>
                </div>
            </div>

            <!-- About Section Card -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="section-card shadow-sm border-0">
                    <a href="{{ route('admin.page.about') }}"
                        class="text-center w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="section-icon-container bg-light-info text-info mb-3"
                            style="background-color: rgba(230, 98, 57, 0.12);">
                            <i class="ti ti-user fs-1" style="color: #E66239;"></i>
                        </div>
                        <h6 class="fw-bold mb-0">About</h6>
                    </a>
                </div>
            </div>

            <!-- Skills Section Card -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="section-card shadow-sm border-0">
                    <a href="{{ route('admin.skills') }}"
                        class="text-center w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="section-icon-container bg-light-info text-info mb-3">
                            <i class="ti ti-bulb fs-1"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Skills</h6>
                    </a>
                </div>
            </div>

            <!-- Awards & Certifications Section Card -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="section-card shadow-sm border-0">
                    <a href="{{ route('admin.awards') }}"
                        class="text-center w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="section-icon-container bg-light-warning text-warning mb-3">
                            <i class="ti ti-trophy fs-1"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Awards & Certifications</h6>
                    </a>
                </div>
            </div>

            <!-- Counters Section Card -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="section-card shadow-sm border-0">
                    <a href="{{ route('admin.counters') }}"
                        class="text-center w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="section-icon-container bg-light-warning text-warning mb-3">
                            <i class="ti ti-numbers fs-1"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Counters</h6>
                    </a>
                </div>
            </div>

            <!-- Services Section Card -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="section-card shadow-sm border-0">
                    <a href="{{ route('admin.services') }}"
                        class="text-center w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="section-icon-container bg-light-danger text-danger mb-3">
                            <i class="ti ti-briefcase fs-1"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Services</h6>
                    </a>
                </div>
            </div>

            <!-- Messages Section Card -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="section-card shadow-sm border-0">
                    <a href="{{ route('admin.messages') }}"
                        class="text-center w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="section-icon-container bg-light-success text-success mb-3">
                            <i class="ti ti-mail fs-1"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Messages</h6>
                    </a>
                </div>
            </div>





            <!-- Blogs Section Card -->
            <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                <div class="section-card shadow-sm border-0">
                    <a href="javascript:void(0)"
                        class="text-center w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="section-icon-container bg-light-danger text-danger mb-3">
                            <i class="ti ti-news fs-1"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Blogs</h6>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .section-card {
            background: #fff;
            border-radius: 15px;
            transition: all 0.3s ease;
            margin-bottom: 25px;
            cursor: pointer;
        }

        .section-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12) !important;
        }

        .section-card a {
            text-decoration: none;
            color: #333;
        }

        .section-icon-container {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .section-card:hover .section-icon-container {
            transform: scale(1.1) rotate(5deg);
        }

        .bg-light-primary {
            background-color: rgba(66, 133, 244, 0.12);
        }

        .bg-light-success {
            background-color: rgba(52, 168, 83, 0.12);
        }

        .bg-light-warning {
            background-color: rgba(251, 188, 5, 0.12);
        }

        .bg-light-info {
            background-color: rgba(0, 172, 193, 0.12);
        }

        .bg-light-danger {
            background-color: rgba(234, 67, 53, 0.12);
        }
    </style>
@endsection