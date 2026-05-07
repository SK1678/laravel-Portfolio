<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="text-muted small bg-white border-bottom">
            <tr>
                <th class="ps-4 py-3 fw-medium border-0 text-center">Id</th>
                <th class="py-3 fw-medium border-0">Image</th>
                <th class="py-3 fw-medium border-0">Name</th>
                <th class="py-3 fw-medium border-0">Email</th>
                <th class="py-3 fw-medium border-0">User type</th>
                <th class="py-3 fw-medium border-0">Status</th>
                <th class="pe-4 py-3 fw-medium border-0 text-end">Actions</th>
            </tr>
        </thead>
        <tbody class="border-top-0">
            @forelse($users as $user)
                <tr>
                    <td class="ps-4 py-3 text-secondary text-center small">#{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td class="py-3">
                        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('/dashboard_assets/images/avatar/avatar-1.jpg') }}" 
                             alt="" class="avatar avatar-xs rounded-circle shadow-sm" style="width: 32px; height: 32px; object-fit: cover;">
                    </td>
                    <td class="py-3">
                        <span class="fw-medium text-dark">{{ $user->name }}</span>
                    </td>
                    <td class="py-3 text-secondary small">{{ $user->email }}</td>
                    <td class="py-3">
                        <span class="badge {{ $user->user_type == 'admin' ? 'bg-primary-subtle text-primary' : 'bg-light text-muted' }} px-2 py-1 rounded-2 fw-medium small">
                            {{ ucfirst($user->user_type) }}
                        </span>
                    </td>
                    <td class="py-3">
                        @if($user->status == 'active')
                            <span class="badge px-2 py-1 rounded-pill fw-medium"
                                style="background-color: #e5f4ec; color: #3e8869;">Active</span>
                        @else
                            <span class="badge px-2 py-1 rounded-pill fw-medium"
                                style="background-color: #fff4e5; color: #88693e;">Disabled</span>
                        @endif
                    </td>
                    <td class="pe-4 py-3 text-end">
                        <div class="d-inline-flex gap-1">
                            <a href="{{ route('user.show', $user->id) }}" class="btn btn-sm btn-light bg-opacity-50 border-0 rounded-2 text-muted px-2 py-1" title="View"><i class="ti ti-eye"></i></a>
                            
                            @if(auth()->id() != $user->id)
                                <form action="{{ route('user.toggleStatus', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-light bg-opacity-50 border-0 rounded-2 {{ $user->status == 'active' ? 'text-success' : 'text-warning' }} px-2 py-1" title="{{ $user->status == 'active' ? 'Disable' : 'Enable' }}">
                                        <i class="ti {{ $user->status == 'active' ? 'ti-circle-check' : 'ti-circle-x' }}"></i>
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-sm btn-light bg-opacity-50 border-0 rounded-2 text-muted px-2 py-1 disabled" title="You cannot disable yourself">
                                    <i class="ti ti-circle-check"></i>
                                </button>
                            @endif

                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-light bg-opacity-50 border-0 rounded-2 text-muted px-2 py-1" title="Edit"><i class="ti ti-pencil"></i></a>

                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light bg-opacity-50 border-0 rounded-2 text-danger px-2 py-1" title="Delete" {{ auth()->id() == $user->id ? 'disabled' : '' }}><i class="ti ti-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="ti ti-user-exclamation fs-1 d-block mb-2"></i>
                        No users found matching your criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->total() > 0)
    <!-- Pagination -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 border-top bg-white rounded-bottom-3">
        <div class="d-flex align-items-center gap-1 mb-3 mb-md-0 pagination-links">
            <a href="{{ $users->url(1) }}" class="btn btn-sm btn-light text-muted border-0 bg-transparent px-2 {{ $users->onFirstPage() ? 'disabled' : '' }}"><i class="ti ti-player-skip-back-filled" style="font-size: 0.8rem;"></i></a>
            <a href="{{ $users->previousPageUrl() }}" class="btn btn-sm btn-light text-muted border-0 bg-transparent px-2 {{ $users->onFirstPage() ? 'disabled' : '' }}"><i class="ti ti-caret-left-filled" style="font-size: 0.8rem;"></i></a>
            <div class="d-flex gap-1">
                @for ($i = 1; $i <= $users->lastPage(); $i++)
                    @if($i <= 5)
                        <a href="{{ $users->url($i) }}" class="btn btn-sm rounded-2 border-0 fw-medium px-3 {{ $users->currentPage() == $i ? 'text-dark' : 'text-muted bg-transparent' }}" style="{{ $users->currentPage() == $i ? 'background-color: #e6edd6;' : '' }}">{{ $i }}</a>
                    @endif
                @endfor
            </div>
            <a href="{{ $users->nextPageUrl() }}" class="btn btn-sm btn-light text-muted border-0 bg-transparent px-2 {{ !$users->hasMorePages() ? 'disabled' : '' }}"><i class="ti ti-caret-right-filled" style="font-size: 0.8rem;"></i></a>
            <a href="{{ $users->url($users->lastPage()) }}" class="btn btn-sm btn-light text-muted border-0 bg-transparent px-2 {{ !$users->hasMorePages() ? 'disabled' : '' }}"><i class="ti ti-player-skip-forward-filled" style="font-size: 0.8rem;"></i></a>
        </div>

        <div class="d-flex align-items-center gap-4">
            <div class="d-flex align-items-center gap-2 bg-light rounded-2 px-2 py-1">
                <select class="form-select form-select-sm border-0 bg-transparent py-0 fw-medium text-dark shadow-none per-page-select" style="width: auto; cursor: pointer;">
                    <option value="5" {{ $users->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $users->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $users->perPage() == 25 ? 'selected' : '' }}>25</option>
                </select>
            </div>
            <span class="text-muted small fw-medium">Items per page</span>
            <span class="text-muted small fw-medium ms-md-4">Items {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }}</span>
            <button class="btn btn-sm btn-light text-dark border-0 bg-transparent ms-2 refresh-btn"><i class="ti ti-refresh fw-bold"></i></button>
        </div>
    </div>
@endif
