@extends('admin.layouts.admin')

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col-md-4">
            <h2 class="h3 mb-0 text-gray-800 fw-bold">User List</h2>
        </div>
        <div class="col-md-8 text-md-end d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
            <div class="input-group" style="max-width: 350px;">
                <span class="input-group-text bg-white border-end-0" id="search-addon"><i
                        class="ti ti-search text-muted"></i></span>
                <input type="text" id="userSearch" class="form-control border-start-0 ps-0 shadow-none" placeholder="Search name or email..." value="{{ request('search') }}">
            </div>
            
            <select id="userTypeFilter" class="form-select shadow-none" style="max-width: 150px;">
                <option value="all">All Types</option>
                <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ request('user_type') == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0" id="userTableContainer">
            @include('admin.partials.user-table')
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            let searchTimer;
            const container = $('#userTableContainer');
            
            function fetchUsers(page = 1) {
                const search = $('#userSearch').val();
                const userType = $('#userTypeFilter').val();
                const perPage = $('.per-page-select').val() || 10;

                container.css('opacity', '0.5'); // Visual feedback

                $.ajax({
                    url: "{{ route('user') }}",
                    data: {
                        page: page,
                        search: search,
                        user_type: userType,
                        per_page: perPage
                    },
                    success: function(data) {
                        container.html(data);
                        container.css('opacity', '1');
                    },
                    error: function() {
                        console.error('Error fetching users');
                        container.css('opacity', '1');
                    }
                });
            }

            // Search input listener
            $('#userSearch').on('input', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    fetchUsers(1);
                }, 300);
            });

            // Type filter listener
            $('#userTypeFilter').on('change', function() {
                fetchUsers(1);
            });

            // Pagination listener (delegated)
            $(document).on('click', '.pagination-links a', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'));
                const page = url.searchParams.get('page');
                fetchUsers(page);
            });

            // Per page listener (delegated)
            $(document).on('change', '.per-page-select', function() {
                fetchUsers(1);
            });

            // Refresh listener (delegated)
            $(document).on('click', '.refresh-btn', function() {
                fetchUsers();
            });
        });
    </script>
    @endpush
@endsection