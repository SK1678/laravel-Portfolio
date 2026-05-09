@include('frontend.include.head')

<body class="index-page{{ (isset($siteSettings) && $siteSettings->is_dark_mode) ? ' dark-background' : '' }}">

    @include('frontend.include.header')

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">

            @if($homeSettings)
                @if($homeSettings->mode == 'single' && !empty($homeSettings->images))
                    <img src="{{ asset('storage/' . $homeSettings->images[0]) }}?v={{ time() }}" alt="Hero Background"
                        class="hero-img">
                @elseif($homeSettings->mode == 'slider' && !empty($homeSettings->images))
                    <div class="swiper hero-slider">
                        <div class="swiper-wrapper">
                            @foreach($homeSettings->images as $img)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $img) }}?v={{ time() }}" alt="Slider Image" class="hero-img">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($homeSettings->mode == 'video')
                    @if($homeSettings->video_source == 'file' && $homeSettings->video_file)
                        <video autoplay muted loop id="hero-video" class="hero-bg-video">
                            <source src="{{ asset('storage/' . $homeSettings->video_file) }}" type="video/mp4">
                        </video>
                    @elseif($homeSettings->video_source == 'url' && $homeSettings->video_url)
                        @php
                            $videoUrl = $homeSettings->video_url;
                            if (str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be')) {
                                $videoId = explode('?v=', $videoUrl)[1] ?? explode('/', $videoUrl)[count(explode('/', $videoUrl)) - 1];
                                $videoUrl = "https://www.youtube.com/embed/" . $videoId . "?autoplay=1&mute=1&loop=1&playlist=" . $videoId;
                            }
                        @endphp
                        <iframe class="hero-bg-video" src="{{ $videoUrl }}" frameborder="0" allow="autoplay; encrypted-media"
                            allowfullscreen></iframe>
                    @endif
                @endif
            @else
                <img src="{{ asset('assets/img/hero-bg.jpg') }}" alt="" class="hero-img">
            @endif

            <div class="container text-center" data-aos="zoom-out" data-aos-delay="100">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2 style="
                            @if($homeSettings->title_size) font-size: {{ $homeSettings->title_size }}; @endif
                            @if($homeSettings->title_color) color: {{ $homeSettings->title_color }}; @endif
                            @if($homeSettings->title_font) font-family: {{ $homeSettings->title_font }}; @endif
                        ">{{ $siteOwner->name ?? 'Your Name' }}</h2>

                        <p style="
                            @if($homeSettings->subtitle_size) font-size: {{ $homeSettings->subtitle_size }}; @endif
                            @if($homeSettings->subtitle_color) color: {{ $homeSettings->subtitle_color }}; @endif
                            @if($homeSettings->subtitle_font) font-family: {{ $homeSettings->subtitle_font }}; @endif
                        ">I'm <span class="typed"
                                data-typed-items="{{ $siteOwner->profile_title ?? 'Your Title' }}"></span></p>

                        <div class="d-flex justify-content-center gap-3 mt-4">
                            {{-- Unified Dynamic Buttons --}}
                            @if($homeSettings && $homeSettings->buttons)
                                @foreach($homeSettings->buttons as $btn)
                                    @php
                                        $type = $btn['type'] ?? 'btn';
                                        $link = $btn['link'] ?? '#';
                                        $download = false;

                                        if ($type == 'core' && isset($siteOwner->additional_info['cv'])) {
                                            $link = asset('storage/' . $siteOwner->additional_info['cv']['path']);
                                            $download = true;
                                        }

                                        $btnClass = 'btn-get-started';
                                        if ($btn['outline'] ?? false)
                                            $btnClass .= ' btn-outline-custom';
                                    @endphp
                                    <a href="{{ $link }}" class="{{ $btnClass }}" @if($download) download @endif style="
                                                 @if(!empty($btn['bg_color'])) --custom-bg: {{ $btn['bg_color'] }}; @endif
                                                 @if(!empty($btn['text_color'])) --custom-text: {{ $btn['text_color'] }}; @endif
                                               ">
                                        {{ $btn['label'] }}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <style>
            #hero {
                position: relative;
                overflow: hidden;
                width: 100%;
                height: 100vh;
                /* Force height to see background */
            }

            .hero-img {
                position: absolute;
                inset: 0;
                display: block;
                width: 100% !important;
                height: 100% !important;
                object-fit: cover;
                z-index: 1;
            }

            .hero-bg-video,
            .hero-slider {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                z-index: 1;
            }

            .hero-bg-video {
                object-fit: cover;
                border: none;
            }

            .hero .container {
                position: relative;
                z-index: 3;
            }

            .hero-slider .swiper-slide {
                width: 100%;
                height: 100%;
            }

            /* Button Themes */
            .btn-get-started {
                background: var(--custom-bg, var(--accent-color)) !important;
                color: var(--custom-text, #fff) !important;
            }

            .btn-get-started:hover {
                filter: brightness(0.9);
                color: var(--custom-text, #fff) !important;
            }

            .btn-dark-custom {
                background: #222 !important;
                color: #fff !important;
            }

            .btn-dark-custom:hover {
                background: #444 !important;
            }

            .btn-light-custom {
                background: #fff !important;
                color: #222 !important;
            }

            .btn-light-custom:hover {
                background: #f0f0f0 !important;
            }

            .btn-outline-custom {
                background: transparent !important;
                border: 2px solid var(--custom-bg, var(--accent-color)) !important;
                color: var(--custom-bg, var(--accent-color)) !important;
            }

            .btn-outline-custom:hover {
                background: var(--custom-bg, var(--accent-color)) !important;
                color: var(--custom-text, #fff) !important;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof Swiper !== 'undefined') {
                    new Swiper('.hero-slider', {
                        loop: true,
                        speed: 1000,
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                        effect: 'fade',
                        fadeEffect: {
                            crossFade: true
                        }
                    });
                }
            });
        </script>

    </main>



    @include('frontend.include.footer')

    {{-- Typing Effect --}}
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectTyped = document.querySelector('.typed');
            if (selectTyped) {
                let typed_strings = selectTyped.getAttribute('data-typed-items');
                typed_strings = typed_strings.split(',');
                new Typed('.typed', {
                    strings: typed_strings,
                    loop: true,
                    typeSpeed: 100,
                    backSpeed: 50,
                    backDelay: 2000
                });
            }
        });
    </script>

</body>

</html>