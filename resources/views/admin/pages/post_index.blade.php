@extends('admin.layouts.admin')

@section('title', 'Post List')

@section('content')
<style>
    .post-table-container {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    .post-header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .search-filter-group {
        display: flex;
        gap: 15px;
        align-items: center;
    }
    .search-input-wrapper {
        position: relative;
    }
    .search-input-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #333;
        font-size: 1.1rem;
    }
    .search-input {
        border: 1px solid #777;
        border-radius: 20px;
        padding: 6px 15px 6px 35px;
        outline: none;
        width: 220px;
        font-size: 0.95rem;
    }
    .status-select {
        border: 1px solid #777;
        border-radius: 6px;
        padding: 6px 30px 6px 10px;
        outline: none;
        background-color: white;
        font-size: 0.95rem;
        cursor: pointer;
    }
    .reset-btn {
        background-color: #8f959e;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 6px 15px;
        text-decoration: none;
        font-size: 0.95rem;
    }
    .reset-btn:hover {
        background-color: #798089;
        color: white;
    }
    .new-post-btn {
        background-color: #ff5c5c;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 20px;
        font-weight: 500;
        text-decoration: none;
        font-size: 0.95rem;
    }
    .new-post-btn:hover {
        background-color: #e64a4a;
        color: white;
    }
    .post-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }
    .post-table th {
        background-color: #ff5c5c;
        color: white;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        border: none;
    }
    .post-table td {
        padding: 12px 15px;
        vertical-align: middle;
        border: none;
    }
    .post-table tr:nth-child(even) {
        background-color: #e8f4f8; /* Light cyan-blue */
    }
    .post-table tr:nth-child(odd) {
        background-color: #ffffff;
    }
    .post-table th.text-center, .post-table td.text-center {
        text-align: center;
    }
    .post-title-text {
        font-size: 1.05rem;
        color: #444;
        margin-bottom: 2px;
    }
    .post-slug {
        display: block;
        color: #ff5c5c;
        font-style: italic;
        font-size: 0.9rem;
    }
    .status-published {
        color: #00b300;
        font-weight: 700;
    }
    .status-draft {
        color: #ff5c5c;
        font-weight: 700;
    }
    .action-icons {
        display: flex;
        gap: 15px;
        justify-content: center;
        align-items: center;
    }
    .action-icons a, .action-icons button {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-size: 1.3rem;
        text-decoration: none;
    }
    .icon-view { color: #0088cc; }
    .icon-edit { color: #5a6268; }
    .icon-delete { color: #ff5c5c; }
    
    .thumbnail-img {
        width: 60px;
        height: 45px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    .thumbnail-placeholder {
        width: 60px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #b771e5;
        color: #b771e5;
        background-color: transparent;
        font-size: 1.5rem;
        border-radius: 3px;
    }
    
    .pagination-wrapper .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 30px;
        gap: 5px;
    }
    .pagination-wrapper .page-link {
        color: #ff5c5c;
        border: none;
        background: transparent;
        font-size: 1.2rem;
        padding: 5px 10px;
    }
    .pagination-wrapper .page-item.active .page-link {
        background: transparent;
        color: #ff5c5c;
        font-weight: bold;
    }
    .pagination-wrapper .page-item.disabled .page-link {
        color: #ffaaaa;
        background: transparent;
    }
</style>

<div class="container-fluid post-table-container">
    <h3 class="mb-4" style="color: #333; font-weight: 500;">Post List</h3>

    <div class="post-header-top">
        <form action="{{ route('admin.posts') }}" method="GET" class="search-filter-group m-0">
            <div class="search-input-wrapper">
                <i class="ti ti-search"></i>
                <input type="text" name="search" class="search-input" value="{{ request('search') }}">
            </div>
            <select name="status" class="status-select">
                <option value="">Status</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
            <a href="{{ route('admin.posts') }}" class="reset-btn">Reset</a>
        </form>

        <a href="{{ route('admin.posts.create') }}" class="new-post-btn">+New Post</a>
    </div>

    <table class="post-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Thumbnail</th>
                <th>Title</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody id="post-table-body">
            @include('admin.pages.partials.post_table_rows')
        </tbody>
    </table>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let searchTimer;
    const searchInput = $('input[name="search"]');
    const statusSelect = $('select[name="status"]');
    const tableBody = $('#post-table-body');

    function fetchPosts(page = 1) {
        const search = searchInput.val();
        const status = statusSelect.val();
        const url = "{{ route('admin.posts') }}";

        $.ajax({
            url: url,
            method: 'GET',
            data: { search: search, status: status, page: page },
            success: function(html) {
                tableBody.html(html);
            }
        });
    }

    // Live Search (Debounced)
    searchInput.on('keyup', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            fetchPosts();
        }, 300);
    });

    // Live Filter
    statusSelect.on('change', function() {
        fetchPosts();
    });

    // Reset Button
    $('.reset-btn').on('click', function(e) {
        e.preventDefault();
        searchInput.val('');
        statusSelect.val('');
        fetchPosts();
    });

    // AJAX Pagination
    $(document).on('click', '.ajax-pagination a', function(e) {
        e.preventDefault();
        const page = $(this).attr('href').split('page=')[1];
        fetchPosts(page);
    });

    // Delete Post Logic (Must use delegation for AJAX rows)
    $(document).on('click', '.delete-post', function() {
        const id = $(this).data('id');
        const deleteUrl = $(this).data('url');
        Swal.fire({
            title: 'Are you sure?',
            text: "This post will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff5c5c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire('Deleted!', res.message, 'success');
                            fetchPosts(); // Refresh list via AJAX
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message ?? 'Could not delete post.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
@endsection
