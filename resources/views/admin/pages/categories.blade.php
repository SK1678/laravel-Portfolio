@extends('admin.layouts.admin')

@section('title', 'Category Manager')

@section('content')
<div class="container-fluid">
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="welcome-text">
                <h4>Category Manager</h4>
                <p class="mb-3">Organize your blog posts and portfolio items</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Add Category Form -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold"><i class="ti ti-plus-circle hs-primary-text me-1"></i> Add New Category</h5>
                </div>
                <div class="card-body p-4">
                    <form id="addCategoryForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Category Name</label>
                            <input type="text" name="name" id="catName" class="form-control form-control-lg bg-light border-0 hs-focus-primary" placeholder="e.g. Brand Design" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Slug</label>
                            <input type="text" name="slug" id="catSlug" class="form-control bg-light border-0 hs-focus-primary" placeholder="e.g. brand-design" required>
                            <div class="form-text small text-muted">Auto-generated. Must be unique.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Parent Category</label>
                            <select name="parent_id" class="form-select bg-light border-0 hs-focus-primary">
                                <option value="">— None (Top Level) —</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text small text-muted">Set parent to <strong>Portfolio</strong> to show as a portfolio filter.</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold hs-save-btn">
                            <i class="ti ti-plus me-1"></i> Add Category
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Category List -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="ti ti-tag hs-primary-text me-1"></i> All Categories</h5>
                    <span class="badge hs-primary-bg rounded-pill">{{ $categories->count() }} total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small uppercase">
                                <tr>
                                    <th class="ps-4 border-0">Name</th>
                                    <th class="border-0">Slug</th>
                                    <th class="border-0">Parent</th>
                                    <th class="text-end pe-4 border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr class="{{ $category->parent_id ? 'bg-light-subtle' : '' }}">
                                        <td class="ps-4">
                                            @if($category->parent_id)
                                                <span class="text-muted me-2 small">↳</span>
                                            @endif
                                            <span class="fw-bold">{{ $category->name }}</span>
                                        </td>
                                        <td><code class="hs-primary-text" style="font-size: 0.85rem;">{{ $category->slug }}</code></td>
                                        <td>
                                            @if($category->parent)
                                                <span class="badge border text-dark fw-medium px-2 py-1">{{ $category->parent->name }}</span>
                                            @else
                                                <span class="badge bg-light-info text-info px-2 py-1">Root</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            @if($category->is_protected)
                                                <span class="text-muted small italic">Protected</span>
                                            @else
                                                <button type="button" class="btn btn-outline-danger btn-sm border-0 rounded-circle" onclick="deleteCategory({{ $category->id }})" title="Delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light-subtle { background-color: rgba(0,0,0,0.01) !important; }
    .bg-light-info { background-color: #e7f6f8; }
    .text-info { color: #0dcaf0; }
    
    /* Symmetric Theme Colors */
    .hs-primary-text { color: #E66239 !important; }
    .hs-primary-bg { background-color: #E66239 !important; }
    
    .hs-save-btn { 
        background: #E66239 !important; 
        border: 0; 
        transition: all 0.2s; 
        color: white !important;
    }
    .hs-save-btn:hover { 
        background: #d45630 !important; 
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(230, 98, 57, 0.2);
    }
    
    .hs-focus-primary:focus {
        border-color: #E66239 !important;
        box-shadow: 0 0 0 0.25 rbg(230, 98, 57, 0.1);
    }
</style>

<script>
    // Auto-generate slug
    document.getElementById('catName').addEventListener('input', function() {
        const name = this.value;
        const slug = name.toLowerCase()
            .replace(/[^\w ]+/g, '')
            .replace(/ +/g, '-');
        document.getElementById('catSlug').value = slug;
    });

    // Add Category AJAX
    document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('.hs-save-btn');
        const origText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="ti ti-loader rotate-infinite"></i> Adding...';

        $.ajax({
            url: "{{ route('admin.categories.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: res => {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 1500, showConfirmButton: false })
                        .then(() => location.reload());
                }
            },
            error: xhr => {
                btn.disabled = false;
                btn.innerHTML = origText;
                Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message ?? 'Failed to add category' });
            }
        });
    });

    // Delete Category
    function deleteCategory(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "All child categories (if any) will also be affected!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ url('admin/categories') }}/${id}`,
                    method: 'DELETE',
                    data: { _token: "{{ csrf_token() }}" },
                    success: res => {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 1500, showConfirmButton: false })
                                .then(() => location.reload());
                        } else {
                            Swal.fire({ icon: 'error', title: 'Denied', text: res.message });
                        }
                    }
                });
            }
        });
    }
</script>
@endsection
