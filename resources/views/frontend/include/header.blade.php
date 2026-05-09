<header id="header" class="header d-flex align-items-center light-background sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

        <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
            @if(isset($siteSettings) && $siteSettings->logo_type == 'image' && $siteSettings->logo_image)
                <img src="{{ asset('storage/' . $siteSettings->logo_image) }}"
                    alt="{{ $siteSettings->site_title ?? 'Logo' }}">
            @else
                <h1 class="sitename">{{ $siteSettings->logo_text ?? ($siteSettings->site_title ?? 'Kelly') }}</h1>
            @endif
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                </li>
                <li><a href="{{ route('resume') }}"
                        class="{{ request()->routeIs('resume') ? 'active' : '' }}">Resume</a></li>
                <li><a href="{{ route('services') }}"
                        class="{{ request()->routeIs('services') ? 'active' : '' }}">Services</a></li>
                <li><a href="{{ route('portfolio') }}"
                        class="{{ request()->routeIs('portfolio') ? 'active' : '' }}">Portfolio</a></li>
                <li class="dropdown"><a href="#"><span>Dropdown</span> <i
                            class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="#">Dropdown 1</a></li>
                        <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="#">Deep Dropdown 1</a></li>
                                <li><a href="#">Deep Dropdown 2</a></li>
                                <li><a href="#">Deep Dropdown 3</a></li>
                                <li><a href="#">Deep Dropdown 4</a></li>
                                <li><a href="#">Deep Dropdown 5</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Dropdown 2</a></li>
                        <li><a href="#">Dropdown 3</a></li>
                        <li><a href="#">Dropdown 4</a></li>
                    </ul>
                </li>
                <li><a href="contact.html">Contact</a></li>
                @if (Auth::check())
                    <li class="dropdown"><a href="#"><i class="bi bi-person-circle"></i> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="dropdown"><a href="#"><span>Account</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>

                        </ul>
                    </li>
                @endif
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <div class="header-social-links">
            @if(isset($siteOwner) && $siteOwner && !empty($siteOwner->additional_info['social_links']))
                @php
                    // Map Tabler icon labels → Bootstrap Icon class + link CSS class
                    $iconMap = [
                        'ti-linkedin' => ['icon' => 'bi-linkedin', 'css' => 'linkedin'],
                        'ti-brand-linkedin' => ['icon' => 'bi-linkedin', 'css' => 'linkedin'],
                        'ti-facebook' => ['icon' => 'bi-facebook', 'css' => 'facebook'],
                        'ti-brand-facebook' => ['icon' => 'bi-facebook', 'css' => 'facebook'],
                        'ti-twitter' => ['icon' => 'bi-twitter-x', 'css' => 'twitter'],
                        'ti-brand-twitter' => ['icon' => 'bi-twitter-x', 'css' => 'twitter'],
                        'ti-brand-x' => ['icon' => 'bi-twitter-x', 'css' => 'twitter'],
                        'ti-instagram' => ['icon' => 'bi-instagram', 'css' => 'instagram'],
                        'ti-brand-instagram' => ['icon' => 'bi-instagram', 'css' => 'instagram'],
                        'ti-github' => ['icon' => 'bi-github', 'css' => 'github'],
                        'ti-brand-github' => ['icon' => 'bi-github', 'css' => 'github'],
                        'ti-youtube' => ['icon' => 'bi-youtube', 'css' => 'youtube'],
                        'ti-brand-youtube' => ['icon' => 'bi-youtube', 'css' => 'youtube'],
                        'ti-whatsapp' => ['icon' => 'bi-whatsapp', 'css' => 'whatsapp'],
                        'ti-brand-whatsapp' => ['icon' => 'bi-whatsapp', 'css' => 'whatsapp'],
                        'ti-telegram' => ['icon' => 'bi-telegram', 'css' => 'telegram'],
                        'ti-brand-telegram' => ['icon' => 'bi-telegram', 'css' => 'telegram'],
                        'ti-dribbble' => ['icon' => 'bi-dribbble', 'css' => 'dribbble'],
                        'ti-brand-dribbble' => ['icon' => 'bi-dribbble', 'css' => 'dribbble'],
                        'ti-behance' => ['icon' => 'bi-behance', 'css' => 'behance'],
                        'ti-brand-behance' => ['icon' => 'bi-behance', 'css' => 'behance'],
                    ];
                @endphp
                @foreach($siteOwner->additional_info['social_links'] as $social)
                    @if(!empty($social['link']) && !empty($social['label']))
                        @php
                            $label = strtolower(trim($social['label']));
                            $mapped = $iconMap[$label] ?? ['icon' => 'bi-link-45deg', 'css' => 'link'];
                            $href = str_starts_with($social['link'], 'http') ? $social['link'] : 'https://' . $social['link'];
                        @endphp
                        <a href="{{ $href }}" class="{{ $mapped['css'] }}" target="_blank" rel="noopener noreferrer">
                            <i class="bi {{ $mapped['icon'] }}"></i>
                        </a>
                    @endif
                @endforeach
            @else
                {{-- Fallback static links --}}
                <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            @endif
        </div>

    </div>
</header>