<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $siteSettings->site_title ?? 'Lavender Portfolio' }}</title>
    <meta name="description" content="{{ $siteSettings->meta_description ?? '' }}">
    <meta name="keywords" content="{{ $siteSettings->meta_keywords ?? '' }}">

    <!-- Favicons -->
    @if(isset($siteSettings) && $siteSettings->favicon)
        <link href="{{ asset('storage/' . $siteSettings->favicon) }}" rel="icon">
        <link href="{{ asset('storage/' . $siteSettings->favicon) }}" rel="apple-touch-icon">
    @else
        <link href="{{ asset('UI/assets/img/favicon.png') }}" rel="icon">
        <link href="{{ asset('UI/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    @endif

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('UI/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('UI/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Main CSS File -->
    <link href="{{ asset('UI/assets/css/main.css') }}" rel="stylesheet">

    <!-- Dynamic Custom Colors -->
    <style>
        :root {
            --default-font: "{{ $siteSettings->default_font ?? 'Poppins' }}", sans-serif;
            --heading-font: "{{ $siteSettings->heading_font ?? 'Outfit' }}", sans-serif;
            
            --background-color: {{ $siteSettings->body_bg ?? '#ffffff' }};
            --default-color: {{ $siteSettings->primary_color ?? '#444444' }};
            --heading-color: {{ $siteSettings->heading_color ?? '#222222' }};
            --accent-color: {{ $siteSettings->accent_color ?? '#34b7a7' }};
            --surface-color: {{ $siteSettings->surface_color ?? '#ffffff' }};
            --contrast-color: {{ $siteSettings->contrast_color ?? '#ffffff' }};

            --nav-color: {{ $siteSettings->nav_primary ?? '#444444' }};
            --nav-hover-color: {{ $siteSettings->nav_hover ?? '#34b7a7' }};
            --nav-mobile-background-color: {{ $siteSettings->nav_mobile_bg ?? '#ffffff' }};
            --nav-dropdown-background-color: {{ $siteSettings->nav_dd_bg ?? '#ffffff' }};
            --nav-dropdown-color: {{ $siteSettings->nav_dd_link ?? '#444444' }};
            --nav-dropdown-hover-color: {{ $siteSettings->nav_dd_hover ?? '#34b7a7' }};
        }

        @if(isset($siteSettings) && $siteSettings->is_dark_mode)
        /* =============================================
           SITE-WIDE DARK MODE — Applied from settings
           ============================================= */
        :root,
        body,
        .light-background,
        .dark-background {
            --background-color: {{ $siteSettings->dark_body_bg ?? '#060606' }};
            --default-color: {{ $siteSettings->dark_primary_color ?? '#ffffff' }};
            --heading-color: {{ $siteSettings->dark_heading_color ?? '#ffffff' }};
            --accent-color: {{ $siteSettings->dark_accent_color ?? '#34b7a7' }};
            --surface-color: {{ $siteSettings->dark_surface_color ?? '#252525' }};
            --contrast-color: {{ $siteSettings->dark_contrast_color ?? '#ffffff' }};
            --nav-color: {{ $siteSettings->dark_primary_color ?? '#ffffff' }};
            --nav-hover-color: {{ $siteSettings->dark_accent_color ?? '#34b7a7' }};
            --nav-mobile-background-color: {{ $siteSettings->dark_body_bg ?? '#060606' }};
            --nav-dropdown-background-color: {{ $siteSettings->dark_surface_color ?? '#252525' }};
            --nav-dropdown-color: {{ $siteSettings->dark_primary_color ?? '#ffffff' }};
            --nav-dropdown-hover-color: {{ $siteSettings->dark_accent_color ?? '#34b7a7' }};
        }

        body {
            background-color: {{ $siteSettings->dark_body_bg ?? '#060606' }} !important;
            color: {{ $siteSettings->dark_primary_color ?? '#ffffff' }} !important;
        }

        /* Header & Nav */
        .header,
        .navmenu,
        .sticky-top {
            background-color: {{ $siteSettings->dark_surface_color ?? '#252525' }} !important;
            border-color: rgba(255,255,255,0.08) !important;
        }

        /* Light background sections → dark surface */
        .light-background {
            background-color: {{ $siteSettings->dark_surface_color ?? '#252525' }} !important;
        }

        /* Footer */
        .footer {
            background-color: {{ $siteSettings->dark_surface_color ?? '#252525' }} !important;
            color: {{ $siteSettings->dark_primary_color ?? '#ffffff' }} !important;
        }

        /* Cards, inputs, form controls */
        .card,
        .form-control,
        .form-select,
        input, textarea, select {
            background-color: {{ $siteSettings->dark_surface_color ?? '#252525' }} !important;
            color: {{ $siteSettings->dark_primary_color ?? '#ffffff' }} !important;
            border-color: rgba(255,255,255,0.12) !important;
        }

        /* Sitename / logo text */
        .sitename {
            color: {{ $siteSettings->dark_heading_color ?? '#ffffff' }} !important;
        }

        /* Links */
        a {
            color: {{ $siteSettings->dark_accent_color ?? '#34b7a7' }};
        }

        /* Scrollbar */
        ::-webkit-scrollbar-track { background: {{ $siteSettings->dark_body_bg ?? '#060606' }}; }
        ::-webkit-scrollbar-thumb { background: {{ $siteSettings->dark_surface_color ?? '#252525' }}; }
        @endif
    </style>

    @if(isset($siteSettings) && $siteSettings->google_analytics_id)
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $siteSettings->google_analytics_id }}');
        </script>
    @endif

    @if(isset($siteSettings) && !$siteSettings->allow_indexing)
        <meta name="robots" content="noindex, nofollow">
    @endif

    <!-- =======================================================
  * Template Name: Kelly
  * Template URL: https://bootstrapmade.com/kelly-free-bootstrap-cv-resume-html-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>