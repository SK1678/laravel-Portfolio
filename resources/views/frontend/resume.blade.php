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
                  <h4>{{ $item['degree'] ?? '' }} in {{ $item['major'] ?? '' }}</h4>
                  <h5>{{ $item['year'] ?? '' }} ({{ $item['duration'] ?? '' }})</h5>
                  <p><em>{{ $item['institution'] ?? '' }}</em></p>
                  <p>Result: {{ $item['result'] ?? '' }}</p>
                  @if(isset($item['description']) && $item['description'])
                    <p>{{ $item['description'] }}</p>
                  @endif
                  @if(isset($item['documents']) && count($item['documents']) > 0)
                    <div class="mt-2">
                      @foreach($item['documents'] as $doc)
                        <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2 me-1 mb-1" style="font-size: 0.7rem;">
                          <i class="bi bi-file-earmark-pdf"></i> {{ $doc['name'] }}
                        </a>
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
                  <h4>{{ $item['role'] ?? '' }}</h4>
                  <h5>
                    {{ \Carbon\Carbon::parse($item['start_date'])->format('M Y') }} - 
                    {{ $item['end_date'] ? \Carbon\Carbon::parse($item['end_date'])->format('M Y') : 'Present' }}
                  </h5>
                  <p><em>{{ $item['company'] ?? '' }}</em></p>
                  <p>{{ $item['description'] ?? '' }}</p>
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
  @include('frontend.include.footer')
</body>

</html>