@include('frontend.include.head')

<body class="index-page{{ (isset($siteSettings) && $siteSettings->is_dark_mode) ? ' dark-background' : '' }}">

    @include('frontend.include.header')

    <main class="main">
        <div class="container py-5">
            <!-- Full Width Title -->
            <h1 class="fw-bold mb-5" style="font-family: serif; font-size: 2.2rem; border-left: 8px solid #ff5c5c; padding-left: 20px; line-height: 1.2;">
                {{ $post->title }}
            </h1>

            <div class="row gy-5">
                <!-- Left Column -->
                <div class="col-lg-5">
                    <!-- Image Slider -->
                    <div class="post-img-container mb-3">
                        @php
                            $gallery = $post->feature_gallery;
                            if (is_string($gallery)) $gallery = json_decode($gallery, true);
                            $hasGallery = is_array($gallery) && count($gallery) > 0;
                        @endphp
                        
                        @if($hasGallery && count($gallery) > 1)
                            <div id="blogCarousel" class="carousel slide rounded-4 overflow-hidden shadow-sm" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($gallery as $idx => $item)
                                        <div class="carousel-item {{ $idx == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . (is_array($item) ? $item['path'] : $item)) }}" class="d-block w-100" style="height: 350px; object-fit: contain; background: #fff;">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#blogCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#blogCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                            </div>
                        @elseif($hasGallery)
                            <div class="rounded-4 overflow-hidden shadow-sm">
                                <img src="{{ asset('storage/' . (is_array($gallery[0]) ? $gallery[0]['path'] : $gallery[0])) }}" class="img-fluid w-100" style="height: 350px; object-fit: cover;">
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center rounded-4 shadow-sm" style="height: 350px; background: #f8f9fa; color: #ff5c5c;">
                                Image slider
                            </div>
                        @endif
                    </div>

                    <!-- Meta Info below Slider -->
                    <div class="meta-line d-flex align-items-center mb-5 gap-3 text-orange" style="font-size: 0.8rem;">
                        <span><i class="bi bi-eye me-1"></i> {{ $post->views }}</span>
                        <span><i class="bi bi-calendar-event me-1"></i> {{ $post->created_at->format('d M Y') }}</span>
                        <div class="ms-auto tags">
                            @foreach($post->tags as $tag)
                                <span>{{ $tag->name }}</span>{{ !$loop->last ? ' | ' : '' }}
                            @endforeach
                        </div>
                    </div>

                    @php
                        $attachments = $post->attachments;
                        if (is_string($attachments)) $attachments = json_decode($attachments, true);
                    @endphp
                    @if(is_array($attachments) && count($attachments) > 0)
                    <!-- Attachments & Links -->
                    <div class="sidebar-section mb-5">
                        <h4 class="fw-bold mb-3" style="font-family: serif; font-size: 1.3rem;">Attachments & linkes</h4>
                        <div class="d-flex flex-wrap gap-2">
                                @foreach($attachments as $att)
                                    <a href="{{ $att['url'] ?? '#' }}" target="_blank" class="badge text-decoration-none" style="background-color: #ff5c5c; color: white; border-radius: 0; padding: 6px 12px; font-weight: normal; font-size: 0.8rem;">
                                        {{ $att['label'] ?? 'Link' }}
                                    </a>
                                @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Recent Posts -->
                    <div class="sidebar-section">
                        <h4 class="fw-bold mb-3" style="font-family: serif; font-size: 1.3rem;">Rescent posts</h4>
                        <ul class="list-unstyled">
                            @foreach($recentPosts as $recent)
                                <li class="mb-2">
                                    <a href="{{ route('blog.show', $recent->slug) }}" class="text-dark fw-bold text-decoration-none hover-orange" style="font-family: serif; font-size: 1.1rem;">
                                        {{ $recent->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-7 ps-lg-5">
                    <!-- Categories at Top Right of this column -->
                    <div class="d-flex gap-1 mb-3">
                        @foreach($post->categories as $cat)
                            <span class="badge" style="background-color: #ff5c5c; color: white; border-radius: 0; padding: 3px 8px; font-weight: normal; font-size: 0.75rem;">{{ $cat->name }}</span>
                        @endforeach
                    </div>

                    <!-- Blog Content -->
                    <div class="blog-content mb-5" style="font-size: 1.1rem; line-height: 1.6; color: #000; text-align: justify; font-family: inherit;">
                        {!! $post->content !!}
                    </div>

                    <!-- Comments Section -->
                    <div class="comments-area mt-3 pt-2 border-top">
                        <h4 class="fw-bold mb-2" style="font-family: serif; font-size: 1.2rem;">Coments ({{ $post->comments->count() }})</h4>

                        <div class="comments-list">
                            @foreach($comments as $comment)
                                @include('frontend.include.comment', ['comment' => $comment])
                            @endforeach
                        </div>

                        <!-- Main New Comment Box -->
                        @auth
                            <div class="main-comment-box mt-4 pt-2">
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <div class="position-relative">
                                        <input type="text" name="body" class="form-control px-3" 
                                               style="border: 2px solid #ccc; border-radius: 6px; height: 45px; font-size: 0.85rem;" 
                                               placeholder="New Cment Box">
                                        <button type="submit" class="btn position-absolute end-0 top-50 translate-middle-y me-2" style="background: transparent; border: none;">
                                            <i class="bi bi-send-fill text-orange fs-3" style="transform: rotate(45deg);"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('frontend.include.footer')

    <script>
        $(document).ready(function() {
            $('.reply-trigger').click(function() {
                var id = $(this).data('id');
                var $targetForm = $('#reply-form-' + id);
                
                // Hide all other reply and edit forms
                $('.reply-form, .edit-form').not($targetForm).addClass('d-none');
                
                // Toggle the clicked reply form
                $targetForm.toggleClass('d-none');
                
                // If any form is now visible, hide the main comment box
                if ($('.reply-form:not(.d-none), .edit-form:not(.d-none)').length > 0) {
                    $('.main-comment-box').addClass('d-none');
                } else {
                    $('.main-comment-box').removeClass('d-none');
                }
            });

            $('.edit-trigger').click(function() {
                var id = $(this).data('id');
                var $targetForm = $('#edit-form-' + id);
                
                // Hide all other reply and edit forms
                $('.reply-form, .edit-form').not($targetForm).addClass('d-none');
                
                // Toggle the clicked edit form
                $targetForm.toggleClass('d-none');
                
                // If any form is now visible, hide the main comment box
                if ($('.reply-form:not(.d-none), .edit-form:not(.d-none)').length > 0) {
                    $('.main-comment-box').addClass('d-none');
                } else {
                    $('.main-comment-box').removeClass('d-none');
                }
            });
        });
    </script>

    <style>
        .text-orange { color: #ff5c5c !important; }
        .hover-orange:hover { color: #ff5c5c !important; }
        .blog-content img { max-width: 100%; height: auto !important; border-radius: 0; margin: 10px 0; }
        .blog-content p { margin-bottom: 1rem; }
        .carousel-control-prev-icon, .carousel-control-next-icon { filter: invert(1) grayscale(100) brightness(0.5); }
    </style>

</body>
</html>
