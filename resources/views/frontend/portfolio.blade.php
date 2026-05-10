@include('frontend.include.head')

<body class="index-page{{ (isset($siteSettings) && $siteSettings->is_dark_mode) ? ' dark-background' : '' }}">

  @include('frontend.include.header')

  <main class="main">

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Portfolio</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
            @foreach($subCategories as $sub)
                <li data-filter=".filter-{{ $sub->slug }}">{{ $sub->name }}</li>
            @endforeach
          </ul><!-- End Portfolio Filters -->

          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">

            @foreach($posts as $post)
                @php
                    $filterClasses = $post->categories->map(fn($c) => 'filter-' . $c->slug)->join(' ');
                    $gallery = $post->feature_gallery;
                    if (is_string($gallery)) $gallery = json_decode($gallery, true);
                    
                    $firstImg = asset('UI/assets/img/masonry-portfolio/masonry-portfolio-1.jpg');
                    if (is_array($gallery) && count($gallery) > 0) {
                        $path = is_array($gallery[0]) ? ($gallery[0]['path'] ?? null) : $gallery[0];
                        if ($path) $firstImg = asset('storage/' . $path);
                    }
                @endphp
                <div class="col-lg-4 col-md-6 portfolio-item isotope-item {{ $filterClasses }}">
                  <img src="{{ $firstImg }}" class="img-fluid" alt="{{ $post->title }}" style="height: 300px; width: 100%; object-fit: cover;">
                  <div class="portfolio-info">
                    <h4>{{ $post->title }}</h4>
                    <p>{{ Str::limit(strip_tags($post->content), 50) }}</p>
                    <a href="{{ $firstImg }}" title="{{ $post->title }}"
                      data-gallery="portfolio-gallery" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                    <a href="{{ route('blog.show', $post->slug) }}" title="More Details" class="details-link"><i
                        class="bi bi-link-45deg"></i></a>
                  </div>
                </div><!-- End Portfolio Item -->
            @endforeach

          </div><!-- End Portfolio Container -->

        </div>

      </div>

    </section><!-- /Portfolio Section -->

  </main>
  @include('frontend.include.footer')
</body>

</html>