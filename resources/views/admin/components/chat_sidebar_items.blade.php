@forelse($conversations as $user)
    @php
        $lastMsg = $user->last_message;
        $timeStr = $lastMsg ? (\Carbon\Carbon::parse($lastMsg->created_at)->isToday() ? \Carbon\Carbon::parse($lastMsg->created_at)->format('g:i A') : (\Carbon\Carbon::parse($lastMsg->created_at)->isYesterday() ? 'Yesterday' : \Carbon\Carbon::parse($lastMsg->created_at)->format('l'))) : '';
        $msgText = $lastMsg ? ($lastMsg->message ?: ($lastMsg->file_name ?: 'Attachment')) : '';
        $isOut = $lastMsg && $lastMsg->sender_id === auth()->id();
    @endphp

<button class="list-group-item list-group-item-action p-3 border-0 border-bottom select-user user-item" 
        data-id="{{ $user->id }}" 
        data-name="{{ $user->name }}" 
        data-unread="{{ $user->unread_count > 0 ? 'true' : 'false' }}"
        data-image="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}">
    
    <div class="d-flex align-items-center gap-3">
        <img src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" 
             class="rounded-circle object-fit-cover" width="48" height="48">
        
        <div class="flex-grow-1 overflow-hidden">
            <div class="d-flex justify-content-between align-items-baseline mb-1">
                <h6 class="mb-0 text-truncate {{ $user->unread_count > 0 ? 'fw-bold text-dark' : 'text-dark' }}" style="font-size: 1.05rem;">{{ $user->name }}</h6>
                <span class="small {{ $user->unread_count > 0 ? 'text-success fw-bold' : 'text-muted' }}" style="font-size: 0.75rem;">{{ $timeStr }}</span>
            </div>
            
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0 small text-muted text-truncate pe-2" style="font-size: 0.85rem;">
                    @if($lastMsg)
                        @if($isOut)
                            <span class="{{ $lastMsg->is_read ? 'text-info' : 'text-muted' }}" style="font-size: 0.9rem;">
                                {!! $lastMsg->is_read ? '&#10003;&#10003;' : '&#10003;' !!}
                            </span> 
                        @endif
                        {{ Str::limit($msgText, 40) }}
                    @else
                        <span class="fst-italic text-black-50">No messages yet</span>
                    @endif
                </p>
                @if($user->unread_count > 0)
                    <span class="badge rounded-pill bg-success text-white d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; font-size: 0.7rem;">{{ $user->unread_count }}</span>
                @endif
            </div>
        </div>
    </div>
</button>
@empty
<div class="p-4 text-center text-muted">No active conversations.</div>
@endforelse
