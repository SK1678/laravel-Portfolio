<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('/dashboard_assets/images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('/dashboard_assets/images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('/dashboard_assets/images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/dashboard_assets/images/favicon_io/site.webmanifest') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('/dashboard_assets/css/style.css') }}">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        .nav-link.active {
            background-color: rgba(234, 67, 53, 0.1) !important;
            color: #ea4335 !important;
            border-radius: 8px;
        }

        .nav-link.active i {
            color: #ea4335 !important;
        }

        .nav-text {
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
</head>
<div id="overlay" class="overlay"></div>
<!-- TOPBAR -->
<nav id="topbar" class="navbar bg-white border-bottom fixed-top topbar px-3">
    <button id="toggleBtn" class="d-none d-lg-inline-flex btn btn-light btn-icon btn-sm ">
        <i class="ti ti-layout-sidebar-left-expand"></i>
    </button>

    <!-- MOBILE -->
    <button id="mobileBtn" class="btn btn-light btn-icon btn-sm d-lg-none me-2">
        <i class="ti ti-layout-sidebar-left-expand"></i>
    </button>
    <div>
        <!-- Navbar nav -->
        <ul class="list-unstyled d-flex align-items-center mb-0 gap-1">
            <!-- Pages link -->

            <!-- Bell icon -->
            <li>
                <a class="position-relative btn-icon btn-sm btn-light btn rounded-circle" data-bs-toggle="dropdown"
                    aria-expanded="false" href="#" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-bell">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                    </svg>
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger mt-2 ms-n2">
                        2
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-0">
                    <ul class="list-unstyled p-0 m-0">
                        <li class="p-3 border-bottom ">
                            <div class="d-flex gap-3">
                                <img src="{{ asset('Dashboard/assets/images/avatar/avatar-1.jpg') }}" alt=""
                                    class="avatar avatar-sm rounded-circle" />
                                <div class="flex-grow-1 small">
                                    <p class="mb-0">New order received</p>
                                    <p class="mb-1">Order #12345 has been placed</p>
                                    <div class="text-secondary">5 minutes ago</div>
                                </div>
                            </div>
                        </li>
                        <li class="p-3 border-bottom ">
                            <div class="d-flex gap-3">
                                <img src="{{ asset('Dashboard/assets/images/avatar/avatar-4.jpg') }}" alt=""
                                    class="avatar avatar-sm rounded-circle" />
                                <div class="flex-grow-1 small">
                                    <p class="mb-0">New user registered</p>
                                    <p class="mb-1">User @john_doe has signed up</p>
                                    <div class="text-secondary">30 minutes ago</div>
                                </div>
                        </li>

                        <li class="p-3 border-bottom">
                            <div class="d-flex gap-3">
                                <img src="{{ asset('Dashboard/assets/images/avatar/avatar-2.jpg') }}" alt=""
                                    class="avatar avatar-sm rounded-circle" />
                                <div class="flex-grow-1 small">
                                    <p class="mb-0">Payment confirmed</p>
                                    <p class="mb-1">Payment of $299 has been received</p>
                                    <div class="text-secondary">1 hour ago</div>
                                </div>
                            </div>
                        </li>
                        <li class="px-4 py-3 text-center">
                            <a href="#" class="text-primary ">View all notifications</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Dropdown -->
            <li class="ms-3">
                <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('/dashboard_assets/images/avatar/avatar-1.jpg') }}"
                    alt="" class="avatar avatar-sm rounded-circle" />
            </li>
        </ul>
    </div>

</nav>


<!-- SIDEBAR -->
<aside id="sidebar" class="sidebar">
    <div class="logo-area">
        <a href="{{ route('dashboard') }}" class="d-inline-flex"><img
                src="{{ asset('/dashboard_assets/images/logo-icon.svg') }}" alt="" width="24">
            <span class="logo-text ms-2"> <img src="{{ asset('/dashboard_assets/images/logo.svg') }}" alt=""></span>
        </a>
    </div>
    <ul class="nav flex-column">
        <li><a class="nav-link {{ (request()->routeIs('home') || request()->is('/')) ? 'active' : '' }}"
                href="{{ route('home') }}" target="blank"><i class="ti ti-world"></i><span
                    class="nav-text">Home</span></a></li>
        <li class="px-4 py-2"><small class="nav-text text-muted">Main</small></li>

        <li><a class="nav-link {{ (request()->routeIs('dashboard') || request()->is('dashboard*')) ? 'active' : '' }}"
                href="{{ route('dashboard') }}"><i class="ti ti-home"></i><span class="nav-text">Dashboard</span></a>
        </li>
        <li><a class="nav-link {{ (request()->routeIs('settings.global') || request()->is('settings/global*')) ? 'active' : '' }}"
                href="{{ route('settings.global') }}"><i class="ti ti-settings"></i><span class="nav-text">Global
                    Settings</span></a></li>
        <li><a class="nav-link {{ (request()->routeIs('page') || request()->is('page*')) ? 'active' : '' }}"
                href="{{route('page')}}"><i class="ti ti-layout-dashboard"></i><span class="nav-text">Page
                    Configurations</span></a></li>
        <li><a class="nav-link {{ request()->routeIs('admin.portfolio') ? 'active' : '' }}"
                href="{{ route('admin.portfolio') }}"><i class="ti ti-receipt"></i><span
                    class="nav-text">Portfolio</span></a>
        </li>
        <li><a class="nav-link {{ request()->routeIs('admin.messages') ? 'active' : '' }}"
                href="{{ route('admin.messages') }}"><i class="ti ti-file-text"></i><span
                    class="nav-text">Messages</span></a>
        </li>


        <li class="px-4 pt-4 pb-2"><small class="nav-text text-muted">Account</small></li>
        <li><a class="nav-link {{ (request()->routeIs('user*') || request()->is('user*')) ? 'active' : '' }}"
                href="{{ route('user') }}"><i class="ti ti-user"></i><span class="nav-text">User</span></a>
        </li>
        <li>
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="ti ti-logout"></i><span class="nav-text">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>

</aside>