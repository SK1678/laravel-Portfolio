@forelse($messages as $msg)
<tr id="message-row-{{ $msg->id }}" style="{{ !$msg->is_read ? 'background-color: #fff5f5;' : '' }}">
    <td class="ps-4">
        <div class="d-flex align-items-center gap-2">
            @if($msg->type == 'user')
                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="ti ti-message-circle fs-5"></i>
                </div>
            @else
                <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="ti ti-mail fs-5"></i>
                </div>
            @endif
            <div>
                <div class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $msg->name }}</div>
                <div class="text-muted" style="font-size: 0.75rem;">{{ $msg->email }}</div>
            </div>
        </div>
    </td>
    <td>
        <div class="fw-bold {{ $msg->type == 'user' ? 'text-primary' : 'text-danger' }}" style="font-size: 0.85rem;">
            {{ $msg->subject }}
            @if($msg->type == 'user')
                <span class="badge bg-primary-subtle text-primary ms-1" style="font-size: 0.6rem;">Messenger</span>
            @endif
        </div>
    </td>
    <td>
        <div class="text-muted text-wrap" style="max-width: 300px; font-size: 0.8rem;">
            {{ Str::limit($msg->message, 100) }}
        </div>
    </td>
    <td class="text-center">
        <span class="badge {{ $msg->is_read ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}" style="font-size: 0.7rem;">
            {{ $msg->is_read ? 'Read' : 'Unread' }}
        </span>
    </td>
    <td class="text-center">
        <div class="fw-bold" style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($msg->created_at)->format('d M, Y') }}</div>
        <div class="text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($msg->created_at)->format('h:i A') }}</div>
    </td>
    <td class="pe-4 text-end">
        @if($msg->type == 'user')
            <a href="{{ route('admin.chats') }}?user={{ $msg->user_id }}" class="btn btn-primary btn-sm rounded-pill px-3">
                Open Chat
            </a>
        @else
            <button class="btn btn-light btn-sm rounded-pill px-3 view-message" 
                    data-id="{{ $msg->id }}" 
                    data-name="{{ $msg->name }}" 
                    data-email="{{ $msg->email }}" 
                    data-subject="{{ $msg->subject }}" 
                    data-body="{{ $msg->message }}">
                View
            </button>
        @endif
        
        @if($msg->type == 'guest')
        <button class="btn btn-light btn-sm rounded-circle delete-message ms-1" data-id="{{ $msg->id }}">
            <i class="ti ti-trash text-danger"></i>
        </button>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center py-5 text-muted">No messages found.</td>
</tr>
@endforelse
