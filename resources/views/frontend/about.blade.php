@include('frontend.include.head')

<body class="about-page{{ (isset($siteSettings) && $siteSettings->is_dark_mode) ? ' dark-background' : '' }}">

  @include('frontend.include.header')

  <main class="main">

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>{{ $about->title ?? 'About' }}</h2>
        @if($about->subtitle)
          <p>{{ $about->subtitle }}</p>
        @endif
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 justify-content-center">
          <style>
            .about-profile-img {
              width: 100%;
              aspect-ratio: 1 / 1;
              object-fit: contain;
              object-position: center;
              background: #f8f9fa;
              border-radius: 10px;
              display: block;
              box-shadow: none !important;
            }
          </style>

          <div class="col-lg-3">
            <img
              src="{{ ($about && $about->image_path) ? asset('storage/' . $about->image_path) : (($siteOwner && $siteOwner->profile_image) ? asset('storage/' . $siteOwner->profile_image) : asset('UI/assets/img/profile-img.jpg')) }}"
              class="img-fluid rounded about-profile-img" alt="Profile Image">
          </div>
          <div class="col-lg-9 content">
            <h4>{{ $about->objective_title ?? 'Career Summary' }}</h4>
            <div class="py-3" style="text-align: justify;">
              {!! nl2br(e($about->career_objective ?? '')) !!}
            </div>
            <div class="row mt-4">
              @if($about && $about->details)
                @foreach($about->details as $item)
                  <div class="col-lg-6">
                    <ul class="ps-0">
                      <li class="list-unstyled d-flex align-items-center mb-3">
                        <i class="bi bi-chevron-right me-2" style="color: var(--accent-color);"></i>
                        <strong class="me-1">{{ $item['label'] }}:</strong>
                        <span>
                          @if($item['type'] == 'link')
                            <a href="{{ $item['value'] }}" target="_blank">{{ $item['value'] }}</a>
                          @else
                            {{ $item['value'] }}
                          @endif
                        </span>
                      </li>
                    </ul>
                  </div>
                @endforeach
              @endif
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Skills Section -->
    <section id="skills" class="skills section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>{{ $skillSettings->title ?? 'Skills' }}</h2>
        @if($skillSettings->subtitle)
          <p>{{ $skillSettings->subtitle }}</p>
        @endif
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row skills-content skills-animation">
          @if($skills && count($skills) > 0)
            @php
              $skillChunks = array_chunk($skills->toArray(), ceil(count($skills) / 2));
            @endphp
            @foreach($skillChunks as $chunk)
              <div class="col-lg-6">
                @foreach($chunk as $skill)
                  <div class="progress">
                    <span class="skill"><span>{{ $skill['name'] }}</span> <i class="val">{{ $skill['percent'] }}%</i></span>
                    <div class="progress-bar-wrap">
                      <div class="progress-bar" role="progressbar" aria-valuenow="{{ $skill['percent'] }}" aria-valuemin="0"
                        aria-valuemax="100">
                      </div>
                    </div>
                  </div><!-- End Skills Item -->
                @endforeach
              </div>
            @endforeach
          @endif
        </div>

      </div>

    </section><!-- /Skills Section -->

    <!-- Awards & Certifications Section -->
    <section id="awards" class="awards section bg-light py-5">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>{{ $awardSettings->title ?? 'Awards & Certifications' }}</h2>
        @if($awardSettings->subtitle)
          <p>{{ $awardSettings->subtitle }}</p>
        @endif
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
          @if($awards && count($awards) > 0)
            @foreach($awards as $award)
              <div class="col-lg-4 col-md-6">
                <div class="award-card p-4 h-100 bg-white rounded shadow-sm border-0 position-relative"
                  style="transition: all 0.3s ease;">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge py-2 px-3 rounded-pill small fw-bold theme-accent-bg-light theme-accent-color">
                      {{ $award->year }}
                    </span>
                    <i class="bi bi-patch-check-fill fs-4 theme-accent-color"></i>
                  </div>
                  <h5 class="fw-bold mb-1">{{ $award->title }}</h5>
                  <p class="text-muted small mb-3"><i class="bi bi-building me-1"></i> {{ $award->organization }}</p>
                  @if($award->description)
                    <p class="small text-secondary mb-3">{{ $award->description }}</p>
                  @endif

                  {{-- Multiple Proofs --}}
                  <div class="award-proofs mt-auto">
                    @if($award->proofs && count($award->proofs) > 0)
                      <div class="d-flex flex-wrap gap-2">
                        @foreach($award->proofs as $proof)
                          @php
                            $isProtected = isset($proof['is_protected']) && $proof['is_protected'];
                          @endphp
                          <a href="{{ $isProtected ? 'javascript:void(0)' : $proof['value'] }}"
                            target="{{ $isProtected ? '' : '_blank' }}"
                            class="btn btn-xs btn-outline-theme rounded-pill px-3 py-1 proof-link" @if($isProtected)
                            onclick="verifyAwardPassword('{{ $proof['value'] }}', '{{ $proof['password'] }}')" @endif>
                            @if($isProtected)
                              <i class="bi bi-lock-fill me-1 text-danger"></i>
                            @else
                              <i class="bi bi-link-45deg me-1"></i>
                            @endif
                            {{ $proof['label'] ?? 'Certificate' }}
                          </a>
                        @endforeach
                      </div>
                    @elseif($award->proof_url)
                      {{-- Fallback for old single link --}}
                      <a href="{{ $award->proof_url }}" target="_blank"
                        class="btn btn-sm btn-outline-theme w-100 rounded-pill py-2">
                        <i class="bi bi-link-45deg me-1"></i> View Certificate
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>

      <script>
        function verifyAwardPassword(url, password) {
          Swal.fire({
            title: 'Password Protected',
            text: 'Please enter the password to view this certificate',
            input: 'password',
            confirmButtonColor: 'var(--accent-color)',
            showCancelButton: true,
            confirmButtonText: 'Access',
            showLoaderOnConfirm: true,
            preConfirm: (inputPassword) => {
              if (inputPassword === password) {
                return true;
              } else {
                Swal.showValidationMessage('Incorrect password');
                return false;
              }
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.isConfirmed) {
              window.open(url, '_blank');
            }
          });
        }
      </script>

      <style>
        .award-card {
          border: 1px solid rgba(0, 0, 0, 0.05) !important;
        }

        .award-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
          border-color: var(--accent-color) !important;
        }

        .theme-accent-color {
          color: var(--accent-color) !important;
        }

        .theme-accent-bg-light {
          background-color: color-mix(in srgb, var(--accent-color), transparent 90%) !important;
        }

        .btn-outline-theme {
          color: var(--accent-color);
          border: 1px solid var(--accent-color);
          font-size: 11px;
          transition: all 0.3s;
        }

        .btn-outline-theme:hover {
          background-color: var(--accent-color);
          color: #fff;
        }

        .btn-xs {
          padding: 2px 8px;
          font-size: 0.75rem;
        }
      </style>
    </section><!-- /Awards & Certifications Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>{{ $counterSettings->title ?? 'Facts' }}</h2>
        @if($counterSettings->subtitle)
          <p>{{ $counterSettings->subtitle }}</p>
        @endif
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          @if($counters && count($counters) > 0)
            @foreach($counters as $counter)
              <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                  <span data-purecounter-start="0"
                    data-purecounter-end="{{ preg_replace('/[^0-9]/', '', $counter->value) }}" data-purecounter-duration="1"
                    class="purecounter"></span>
                  <p>{{ $counter->name }}</p>
                </div>
              </div><!-- End Stats Item -->
            @endforeach
          @endif

        </div>

      </div>

    </section><!-- /Stats Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              }
            }
          </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="{{ asset('UI/assets/img/testimonials/testimonials-1.jpg') }}" class="testimonial-img" alt="">
                <h3>Saul Goodman</h3>
                <h4>Ceo &amp; Founder</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus.
                    Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="{{ asset('UI/assets/img/testimonials/testimonials-2.jpg') }}" class="testimonial-img" alt="">
                <h3>Sara Wilsson</h3>
                <h4>Designer</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram
                    malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="{{ asset('UI/assets/img/testimonials/testimonials-3.jpg') }}" class="testimonial-img" alt="">
                <h3>Jena Karlis</h3>
                <h4>Store Owner</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis
                    minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="{{ asset('UI/assets/img/testimonials/testimonials-4.jpg') }}" class="testimonial-img" alt="">
                <h3>Matt Brandon</h3>
                <h4>Freelancer</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim
                    velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum
                    veniam.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="{{ asset('UI/assets/img/testimonials/testimonials-5.jpg') }}" class="testimonial-img" alt="">
                <h3>John Larson</h3>
                <h4>Entrepreneur</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim
                    culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum
                    quid.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

  </main>

  @include('frontend.include.footer')

</body>

</html>