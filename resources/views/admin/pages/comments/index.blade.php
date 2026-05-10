@extends('admin.layouts.admin')

@section('title', 'Comment Manager')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Comment Manager</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3" style="width: 200px;">Comenter Name</th>
                            <th class="py-3">Comment</th>
                            <th class="py-3">Post</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-center">Date</th>
                            <th class="pe-4 py-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr id="comment-row-{{ $comment->id }}"
                                style="{{ !$comment->is_read ? 'background-color: #fff5f5;' : '' }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="position-relative">
                                            <div class="avatar avatar-sm rounded-circle bg-danger-subtle d-flex align-items-center justify-content-center fw-bold text-danger"
                                                style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            @if(!$comment->is_read)
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                                            @endif
                                        </div>
                                        <div class="fw-bold" style="font-size: 0.85rem;">
                                            {{ $comment->user->name ?? 'Unknown User' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-wrap" style="max-width: 250px;">
                                        <p class="mb-0 text-dark" style="font-size: 0.85rem;">{{ $comment->body }}</p>
                                        @if($comment->parent_id)
                                            <span class="badge bg-light text-dark border py-1"
                                                style="font-size: 0.65rem;">Reply</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('blog.show', $comment->post->slug) }}" target="_blank"
                                        class="text-decoration-none text-danger fw-bold" style="font-size: 0.85rem;">
                                        {{ Str::limit($comment->post->title, 25) }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column align-items-center gap-1">
                                        <div class="form-check form-switch m-0">
                                            <input class="form-check-input status-toggle" type="checkbox"
                                                data-id="{{ $comment->id }}" {{ $comment->status ? 'checked' : '' }}
                                                style="cursor: pointer; width: 40px; height: 20px;">
                                        </div>
                                        <span
                                            class="status-label badge {{ $comment->status ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' }}"
                                            style="font-size: 0.7rem;">
                                            {{ $comment->status ? 'Visible' : 'Hidden' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-block text-center">
                                        <div class="fw-bold text-dark" style="font-size: 0.85rem; line-height: 1.2;">
                                            {{ $comment->created_at->format('d M, Y') }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            {{ $comment->created_at->format('h:i A') }}</div>
                                    </div>
                                </td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-light btn-sm rounded-circle delete-comment"
                                        data-id="{{ $comment->id }}" style="width: 32px; height: 32px; padding: 0;">
                                        <i class="ti ti-trash text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No comments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($comments->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $comments->links() }}
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Toggle Status
            $(document).on('change', '.status-toggle', function () {
                const id = $(this).data('id');
                const $label = $(this).closest('td').find('.status-label');
                const isChecked = $(this).is(':checked');

                $.ajax({
                    url: "{{ route('admin.comments.toggle', ['id' => ':id']) }}".replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.status) {
                            $label.removeClass('bg-warning-subtle text-warning').addClass('bg-success-subtle text-success').text('Visible');
                        } else {
                            $label.removeClass('bg-success-subtle text-success').addClass('bg-warning-subtle text-warning').text('Hidden');
                        }

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                    },
                    error: function (xhr) {
                        Swal.fire('Error', 'Something went wrong while updating status', 'error');
                        // Revert switch on error
                        $(this).prop('checked', !isChecked);
                    }
                });
            });

            // Delete Comment
            $(document).on('click', '.delete-comment', function () {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This comment will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('/dashboard/comments') }}/" + id,
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                $(`#comment-row-${id}`).fadeOut(300, function () {
                                    $(this).remove();
                                });
                                Swal.fire('Deleted!', response.message, 'success');
                            },
                            error: function () {
                                Swal.fire('Error', 'Failed to delete comment', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection