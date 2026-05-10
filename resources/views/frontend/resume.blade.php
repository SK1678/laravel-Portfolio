@include('frontend.include.head')

<body class="index-page{{ (isset($siteSettings) && $siteSettings->is_dark_mode) ? ' dark-background' : '' }}">

  @include('frontend.include.header')

  <main class="main">

    <!-- Resume Section -->
    <section id="resume" class="resume section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Resume</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <h3 class="resume-title">Education</h3>
            @php $education = $siteOwner->additional_info['education'] ?? []; @endphp
            @if(count($education) > 0)
              @foreach($education as $item)
                <div class="resume-item">
                  <h4>{{ ucfirst(strtolower(($item['degree'] ?? '') . ' in ' . ($item['major'] ?? ''))) }}</h4>
                  <h5>
                    {{ $item['year'] ?? '' }} ({{ $item['duration'] ?? '' }}) 
                    @if(isset($item['result']) && $item['result'])
                      | Result: {{ $item['result'] }}
                    @endif
                  </h5>
                  <p><span class="resume-org fw-bold text-primary">{{ $item['institution'] ?? '' }}</span></p>
                  @if(isset($item['description']) && $item['description'])
                    <p class="description">{{ $item['description'] }}</p>
                  @endif
                  @if(isset($item['documents']) && count($item['documents']) > 0)
                    <div class="mt-3">
                      @foreach($item['documents'] as $doc)
                        @php 
                            $isProtected = !empty($doc['password']);
                            $fileUrl = asset('storage/' . $doc['path']);
                        @endphp
                        <button type="button" 
                           onclick="handleFileAccess('{{ $fileUrl }}', '{{ $doc['password'] ?? '' }}')"
                           class="btn-resume me-1 mb-2">
                           <i class="bi bi-file-earmark-{{ $isProtected ? 'lock' : 'pdf' }}"></i> {{ $doc['name'] }}
                        </button>
                      @endforeach
                    </div>
                  @endif
                </div><!-- Edn Resume Item -->
              @endforeach
            @else
              <p class="text-muted small">No education history added.</p>
            @endif
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <h3 class="resume-title">Professional Experience</h3>
            @php $professional = $siteOwner->additional_info['professional'] ?? []; @endphp
            @if(count($professional) > 0)
              @foreach($professional as $item)
                <div class="resume-item">
                  <h4>{{ ucfirst(strtolower($item['role'] ?? '')) }}</h4>
                  <h5>
                    {{ \Carbon\Carbon::parse($item['start_date'])->format('M Y') }} - 
                    {{ $item['end_date'] ? \Carbon\Carbon::parse($item['end_date'])->format('M Y') : 'Present' }}
                  </h5>
                  <p><span class="resume-org fw-bold text-primary">{{ $item['company'] ?? '' }}</span></p>
                  <p class="description">{{ $item['description'] ?? '' }}</p>
                  
                  @if(isset($item['documents']) && count($item['documents']) > 0)
                    <div class="mt-2">
                      @foreach($item['documents'] as $doc)
                        @php 
                            $isProtected = !empty($doc['password']);
                            $fileUrl = asset('storage/' . $doc['path']);
                        @endphp
                        <button type="button" 
                           onclick="handleFileAccess('{{ $fileUrl }}', '{{ $doc['password'] ?? '' }}')"
                           class="btn-resume me-1 mb-1">
                           <i class="bi bi-file-earmark-{{ $isProtected ? 'lock' : 'pdf' }}"></i> {{ $doc['name'] }}
                        </button>
                      @endforeach
                    </div>
                  @endif
                </div><!-- Edn Resume Item -->
              @endforeach
            @else
              <p class="text-muted small">No professional experience added.</p>
            @endif
          </div>

        </div>

      </div>

    </section><!-- /Resume Section -->

  </main>
  
  <style>
    .resume-item h4 {
        text-transform: none !important;
        font-weight: 700;
        margin-bottom: 5px;
    }
    .resume-org {
        color: var(--accent-color) !important;
        font-size: 0.95rem;
    }
    .resume-item .description {
        text-align: justify;
    }
    .btn-resume {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--accent-color);
        background-color: transparent;
        border: 1px solid var(--accent-color);
        border-radius: 50px;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .btn-resume i {
        margin-right: 5px;
    }
    .btn-resume:hover {
        background-color: var(--accent-color);
        color: var(--contrast-color);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
  </style>

  <script>
    function handleFileAccess(url, password) {
        if (!password) {
            window.open(url, '_blank');
            return;
        }

        Swal.fire({
            title: 'Password Protected',
            text: 'Please enter the password to view this document:',
            input: 'password',
            inputAttributes: {
                autocapitalize: 'off',
                autocorrect: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Open File',
            confirmButtonColor: 'var(--accent-color)',
            showLoaderOnConfirm: true,
            preConfirm: (inputPassword) => {
                if (inputPassword === password) {
                    return true;
                } else {
                    Swal.showValidationMessage('Incorrect password!');
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

  @include('frontend.include.footer')
</body>

</html>