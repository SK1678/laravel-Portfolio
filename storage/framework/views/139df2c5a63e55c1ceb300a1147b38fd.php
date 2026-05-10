<?php echo $__env->make('frontend.include.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="index-page<?php echo e((isset($siteSettings) && $siteSettings->is_dark_mode) ? ' dark-background' : ''); ?>">

    <?php echo $__env->make('frontend.include.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="main">
        <div class="container py-5">
            <h1 class="text-center fw-bold mb-5" style="font-family: 'Times New Roman', serif; font-size: 3rem;">Blogs</h1>

            <!-- Filters -->
            <div class="row mb-5">
                <div class="col-lg-3 col-md-4 mb-3">
                    <div class="position-relative">
                        <input type="text" name="search" class="form-control rounded-pill px-3" 
                               style="border: 2px solid #ff5c5c; height: 38px; color: #ff5c5c; font-size: 0.85rem;" 
                               placeholder="Search posts..." value="<?php echo e(request('search')); ?>">
                        <i class="bi bi-search position-absolute end-0 top-50 translate-middle-y me-3" style="color: #ff5c5c; font-size: 0.8rem;"></i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 mb-3">
                    <div class="dropdown">
                        <button class="btn w-100 rounded-pill text-start px-3 d-flex justify-content-between align-items-center" 
                                type="button" id="categoryFilter" data-bs-toggle="dropdown" aria-expanded="false"
                                style="border: 2px solid #ff5c5c; height: 38px; color: #ff5c5c; background: white; font-size: 0.85rem;">
                            <span style="color: #ff5c5c;">Filter By Category</span>
                            <i class="bi bi-funnel" style="font-size: 0.8rem;"></i>
                        </button>
                        <ul class="dropdown-menu w-100 shadow-sm border-orange" aria-labelledby="categoryFilter">
                            <li><a class="dropdown-item py-1 category-filter-item" data-slug="" style="font-size: 0.85rem;" href="#">All Categories</a></li>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="dropdown-header fw-bold text-dark pt-2 pb-1" style="font-size: 0.9rem;"><?php echo e($category->name); ?></li>
                                <li><a class="dropdown-item py-1 category-filter-item ps-4" data-slug="<?php echo e($category->slug); ?>" style="font-size: 0.85rem;" href="#">- Show All <?php echo e($category->name); ?></a></li>
                                <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a class="dropdown-item py-1 category-filter-item ps-4" data-slug="<?php echo e($child->slug); ?>" style="font-size: 0.85rem;" href="#"><?php echo e($child->name); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Blog Container for AJAX -->
            <div id="blog-container" style="transition: opacity 0.3s ease;">
                <?php echo $__env->make('frontend.include.blog_list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </main>

    <?php echo $__env->make('frontend.include.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
        $(document).ready(function() {
            let searchTimer;
            let currentCategory = "<?php echo e(request('category')); ?>";
            let currentSearch = "<?php echo e(request('search')); ?>";

            function fetchBlogs(page = 1) {
                let url = "<?php echo e(route('blogs')); ?>?page=" + page;
                if (currentCategory) url += "&category=" + currentCategory;
                if (currentSearch) url += "&search=" + currentSearch;

                $('#blog-container').css('opacity', '0.5');

                $.ajax({
                    url: url,
                    type: "GET",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(data) {
                        $('#blog-container').html(data).css('opacity', '1');
                        // Re-initialize any components if needed (e.g., AOS)
                        if (typeof AOS !== 'undefined') {
                            AOS.refresh();
                        }
                    },
                    error: function() {
                        $('#blog-container').css('opacity', '1');
                    }
                });
            }

            // Live Search
            $('input[name="search"]').on('keyup', function() {
                clearTimeout(searchTimer);
                currentSearch = $(this).val();
                searchTimer = setTimeout(function() {
                    fetchBlogs(1);
                }, 500);
            });

            // Category Filter
            $(document).on('click', '.category-filter-item', function(e) {
                e.preventDefault();
                currentCategory = $(this).data('slug');
                let catText = $(this).text().replace('- Show All ', '');
                $('#categoryFilter span').text(catText);
                fetchBlogs(1);
            });

            // AJAX Pagination
            $(document).on('click', '.page-link-ajax', function(e) {
                e.preventDefault();
                let urlStr = $(this).attr('href');
                if(!urlStr || urlStr === '#') return;
                
                let url = new URL(urlStr);
                let page = url.searchParams.get('page');
                fetchBlogs(page);
                $('html, body').animate({ scrollTop: $('#blog-container').offset().top - 100 }, 200);
            });
        });
    </script>

    <style>
        .text-orange { color: #ff5c5c !important; }
        .border-orange { border: 2px solid #ff5c5c !important; }
        .bg-orange { background-color: #ff5c5c !important; }
        .dropdown-menu { border: 2px solid #ff5c5c !important; border-radius: 15px; padding: 10px 0; }
        .dropdown-item:hover { background-color: #fce8e6; color: #ff5c5c; }
        .dropdown-header { color: #ff5c5c !important; border-bottom: 1px solid #eee; margin-top: 5px; }
        #blog-container { min-height: 400px; }
    </style>

</body>
</html>
<?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/frontend/blogs.blade.php ENDPATH**/ ?>