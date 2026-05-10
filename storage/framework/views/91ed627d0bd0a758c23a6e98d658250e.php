<?php $__env->startSection('title', 'Admin Messenger'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Persistent Back Button -->
        <div class="d-flex justify-content-end mb-3">
            <a href="<?php echo e(route('page')); ?>" class="btn btn-light btn-sm px-3 border shadow-sm">
                <i class="ti ti-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="row page-titles mx-0 mb-4" id="pageHeader">
            <div class="col-sm-12 p-md-0">
                <div class="welcome-text text-center text-sm-start">
                    <h4>Messenger</h4>
                    <p class="mb-0 text-muted">Real-time chat with your site users</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar: User List -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden" id="conversationSidebar" style="height: 80vh; background-color: #ffffff;">
                    
                    <!-- Sidebar Header & Search -->
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-center mb-3">
                            <h5 class="fw-bold mb-0 flex-grow-1">Chats</h5>
                        </div>
                        
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light border-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="ti ti-search"></i></span>
                            <input type="text" id="chatSearch" class="form-control bg-light border-0 shadow-none" placeholder="Search or start a new chat" style="border-radius: 0 8px 8px 0; font-size: 0.95rem;">
                        </div>

                        <div class="d-flex gap-2 filter-pills">
                            <button class="btn btn-sm btn-dark rounded-pill px-3" id="filterAll">All</button>
                            <button class="btn btn-sm btn-light rounded-pill px-3 fw-medium text-muted border" id="filterUnread">Unread</button>
                        </div>
                    </div>

                    <!-- Conversation List -->
                    <div class="list-group list-group-flush overflow-auto" id="userList" style="height: calc(80vh - 145px);">
                        <?php echo $__env->make('admin.components.chat_sidebar_items', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
            </div>

        <!-- Chat Area -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden" id="mainChatCard" style="height: 80vh;">
                <!-- Initial Welcome State -->
                <div id="chatPlaceholder" class="h-100 d-flex align-items-center justify-content-center text-center p-5">
                    <div>
                        <i class="ti ti-message-dots fs-1 text-primary opacity-25" style="font-size: 5rem;"></i>
                        <h4 class="fw-bold mt-4">Welcome to Messenger</h4>
                        <p class="text-muted">Select a user from the left to start a conversation.</p>
                    </div>
                </div>

                <!-- Active Chat State (Hidden by default) -->
                <div id="activeChatContent" class="h-100 d-none flex-column">
                    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center gap-3">
                        <img id="activeUserImg" src="" class="rounded-circle shadow-sm" width="40" height="40">
                        <div>
                            <h6 id="activeUserName" class="mb-0 fw-bold">Select a user</h6>
                            <span class="badge bg-success-subtle text-success p-1 px-2" style="font-size: 0.65rem;">Active Now</span>
                        </div>
                    </div>
                    <div class="card-body bg-light overflow-y-auto p-3 d-flex flex-column gap-1 flex-grow-1" id="chatBody" style="min-height: 0;">
                        <!-- Messages will be loaded here -->
                    </div>
                    <div class="card-footer bg-white border-top p-0">
                        <!-- Reply Preview Bar -->
                        <div class="reply-preview-bar" id="replyPreview">
                            <div class="flex-grow-1 overflow-hidden">
                                <small class="fw-bold text-primary d-block">Replying to <span id="replyToUser"></span></small>
                                <small class="text-muted text-truncate d-block" id="replyToText"></small>
                            </div>
                            <button type="button" class="btn btn-sm btn-link text-danger p-0" id="cancelReply"><i class="ti ti-x"></i></button>
                        </div>

                        <div class="p-3">
                            <form id="replyForm" class="d-flex align-items-center gap-2" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="reply_to_id" id="replyToId">
                                <input type="file" name="attachment" id="fileInput" class="d-none" accept="*/*">
                                
                                <button type="button" class="btn btn-attachment p-0 fs-4" id="btnAttach" title="Attach File">
                                    <i class="ti ti-paperclip"></i>
                                </button>
                                <button type="button" class="btn btn-attachment p-0 fs-4" id="btnVoice" title="Record Voice">
                                    <i class="ti ti-microphone"></i>
                                </button>

                                <input type="text" name="message" id="replyInput" class="form-control rounded-pill border-0 bg-light px-4" placeholder="Type a message..." autocomplete="off">
                                
                                <button type="submit" class="btn btn-primary rounded-circle p-2 px-3 shadow-sm">
                                    <i class="ti ti-send"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ── Messenger Layout ─────────────────────────────── */
    .message-wrapper {
        position: relative;
        width: 100%;
        display: flex;
        flex-direction: column;
        margin-bottom: 3px;
    }
    .swipe-indicator {
        position: absolute;
        left: -36px;
        top: 50%;
        transform: translateY(-50%);
        color: #0084ff;
        font-size: 1rem;
        transition: opacity 0.2s;
        opacity: 0;
        pointer-events: none;
    }

    /* ── Bubble ────────────────────────────────────────── */
    .message-item {
        max-width: 72%;
        padding: 6px 9px 4px 9px;
        border-radius: 7.5px;
        font-size: 14px;
        line-height: 19px;
        position: relative;
        cursor: pointer;
        word-break: break-word;
        transition: filter 0.1s;
    }
    .message-item:active { filter: brightness(0.95); }
    .message-in {
        align-self: flex-start;
        background: #fff;
        color: #111;
        border-top-left-radius: 0;
        box-shadow: 0 1px 0.5px rgba(0,0,0,.13);
    }
    .message-out {
        align-self: flex-end;
        background: #d9fdd3;
        color: #111;
        border-top-right-radius: 0;
        box-shadow: 0 1px 0.5px rgba(0,0,0,.13);
    }

    /* ── Message text + tail timestamp ────────────────── */
    .message-body {
        display: inline;
        word-break: break-word;
        font-size: 14px;
        line-height: 19px;
    }
    /* Invisible spacer so timestamp never overlaps text */
    .message-body::after {
        content: '\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0\00a0';
        display: inline;
    }
    .msg-timestamp {
        float: right;
        font-size: 11px;
        line-height: 15px;
        color: rgba(0,0,0,.45);
        margin-left: 6px;
        margin-top: 3px;
        white-space: nowrap;
        clear: right;
    }

    /* ── Reply Quote ───────────────────────────────────── */
    .reply-quote {
        border-left: 4px solid #0084ff;
        background: rgba(0,0,0,0.04);
        border-radius: 4px;
        padding: 5px 9px;
        margin-bottom: 4px;
        font-size: 12.5px;
        line-height: 17px;
        color: #555;
        cursor: pointer;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        transition: background 0.15s;
    }
    .reply-quote:hover { background: rgba(0,0,0,0.08); }
    .message-out .reply-quote {
        border-left-color: #25d366;
        background: rgba(0,0,0,0.06);
        color: #333;
    }

    /* ── Media ─────────────────────────────────────────── */
    .attachment-img {
        max-width: 220px;
        max-height: 200px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 4px;
        cursor: pointer;
        display: block;
    }

    /* ── Highlight animation ────────────────────────────── */
    .message-highlight {
        animation: admin-msg-highlight 2s;
    }
    @keyframes admin-msg-highlight {
        0%   { background-color: rgba(255,213,0,0.4); }
        100% { background-color: transparent; }
    }

    /* ── Read receipt ticks ─────────────────────────────── */
    .msg-tick {
        display: inline-flex;
        align-items: center;
        gap: 1px;
        vertical-align: middle;
        font-size: 13px;
        margin-left: 3px;
        color: rgba(0,0,0,0.35);
    }
    .msg-tick.read {
        color: #53bdeb; /* WhatsApp blue ticks */
    }
    .reply-preview-bar {
        background: #f0f2f5;
        border-left: 4px solid #0084ff;
        padding: 8px 14px;
        display: none;
        align-items: center;
        gap: 12px;
        border-top: 1px solid #eee;
    }
</style>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    let activeUserId = null;
    let mediaRecorder;
    let audioChunks = [];

    // We must use event delegation since the sidebar is re-rendered dynamically
    $('#userList').on('click', '.select-user', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const img = $(this).data('image');
        activeUserId = id;

        $('#userList .select-user').removeClass('active bg-light border-start border-primary border-4');
        $(this).addClass('active bg-light border-start border-primary border-4');
        $(this).find('.badge').fadeOut();

        $('#activeUserName').text(name);
        $('#activeUserImg').attr('src', img);
        
        $('#pageHeader').fadeOut(300);
        $('#chatPlaceholder').addClass('d-none');
        $('#activeChatContent').removeClass('d-none').addClass('d-flex');

        loadMessages(id, true); // force scroll to bottom on user select
    });

    let userScrolledUp = false; // track if user has manually scrolled up

    // Detect user scroll intent
    $('#chatBody').on('scroll', function() {
        const el = this;
        const atBottom = el.scrollHeight - el.scrollTop - el.clientHeight < 60;
        userScrolledUp = !atBottom;
    });

    function loadMessages(id, forceScroll = false) {
        $.get(`/dashboard/chats/${id}`, function(messages) {
            const body = $('#chatBody')[0];
            const prevScrollTop = body.scrollTop;
            const prevScrollHeight = body.scrollHeight;

            let hasNewMessages = false;
            
            // If switching user, clear out first
            if (forceScroll) {
                $('#chatBody').empty();
            }

            messages.forEach(msg => {
                const existingMsg = $(`#msg-${msg.id}`);
                if (existingMsg.length === 0) {
                    $('#chatBody').append(renderMessage(msg));
                    hasNewMessages = true;
                } else {
                    // Update read receipt dynamically if changed
                    const isOut = msg.sender_id != activeUserId;
                    if (isOut && msg.is_read) {
                        const tick = existingMsg.find('.msg-tick');
                        if (!tick.hasClass('read')) {
                            tick.addClass('read').attr('title', 'Seen').html('&#10003;&#10003;');
                        }
                    }
                }
            });

            if (forceScroll || (!userScrolledUp && hasNewMessages)) {
                // Force scroll on new user, or if at bottom and new msg arrived
                body.scrollTop = body.scrollHeight;
            } else if (hasNewMessages) {
                // Maintain position if user is scrolled up and new message arrived
                body.scrollTop = prevScrollTop + (body.scrollHeight - prevScrollHeight);
            }
        });
    }

    function renderMessage(msg) {
        const isOut = msg.sender_id != activeUserId;
        const type = isOut ? 'out' : 'in';
        let content = '';

        // Reply quote
        if (msg.reply_to) {
            const quoted = msg.reply_to.message
                ? msg.reply_to.message.substring(0, 80)
                : (msg.reply_to.file_type || 'Attachment');
            content += `<div class="reply-quote" data-target-id="${msg.reply_to_id}">${quoted}</div>`;
        }

        // Attachment
        if (msg.attachment) {
            const url = `/storage/${msg.attachment}`;
            if (msg.file_type === 'image') {
                content += `<img src="${url}" class="attachment-img" onclick="window.open('${url}')"><br>`;
            } else if (msg.file_type === 'video') {
                content += `<video src="${url}" controls style="max-width:220px;display:block;border-radius:6px;margin-bottom:4px;"></video>`;
            } else if (msg.file_type === 'audio') {
                content += `<audio src="${url}" controls style="max-width:220px;display:block;margin-bottom:4px;"></audio>`;
            } else {
                content += `<div style="display:flex;align-items:center;gap:8px;background:rgba(0,0,0,.05);border-radius:6px;padding:6px 8px;margin-bottom:4px;max-width:220px;">
                    <i class="ti ti-file" style="font-size:1.3rem;"></i>
                    <a href="${url}" target="_blank" style="font-size:12px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;text-decoration:none;color:inherit;">${msg.file_name}</a>
                </div>`;
            }
        }

        // Message text + tail timestamp + tick (WhatsApp style)
        const time = msg.created_at
            ? new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
            : '';

        // Tick mark for outgoing messages only
        let tick = '';
        if (isOut) {
            if (msg.is_read) {
                // Double tick = seen
                tick = `<span class="msg-tick read" title="Seen">&#10003;&#10003;</span>`;
            } else {
                // Single tick = sent but not read
                tick = `<span class="msg-tick" title="Sent">&#10003;</span>`;
            }
        }

        if (msg.message) {
            content += `<span class="message-body">${msg.message}</span>`;
        }
        content += `<span class="msg-timestamp">${time}${tick}</span>`;

        return `
            <div class="message-wrapper" id="msg-${msg.id}">
                <div class="swipe-indicator"><i class="ti ti-arrow-back-up"></i></div>
                <div class="message-item message-${type}" data-id="${msg.id}" data-text="${(msg.message || '').replace(/"/g, '&quot;')}">
                    ${content}
                </div>
            </div>`;
    }

    // Interaction Listeners
    let touchStartX = 0;
    let currentSwipeItem = null;

    function initInteractions() {
        // Double Click to Reply
        $(document).on('dblclick', '.message-item', function() {
            triggerReply($(this));
        });

        // Single Click - ONLY for Quotes (navigate to original message)
        $(document).on('click', '.message-item', function(e) {
            const $quote = $(e.target).closest('.reply-quote');
            if ($quote.length) {
                e.stopPropagation();
                const targetId = $quote.attr('data-target-id');
                const $target = $(`#msg-${targetId}`);
                if ($target.length) {
                    userScrolledUp = true; // prevent polling from jumping back
                    $target[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    $target.find('.message-item').addClass('message-highlight');
                    setTimeout(() => {
                        $target.find('.message-item').removeClass('message-highlight');
                    }, 2000);
                } else {
                    console.warn('Original message not found in current view.');
                }
            }
        });

        // Swipe logic
        $(document).on('touchstart', '.message-item', function(e) {
            touchStartX = e.originalEvent.touches[0].clientX;
            currentSwipeItem = $(this);
        });

        $(document).on('touchmove', '.message-item', function(e) {
            if (!currentSwipeItem) return;
            let touchX = e.originalEvent.touches[0].clientX;
            let diff = touchX - touchStartX;

            if (diff > 0 && diff < 80) {
                currentSwipeItem.css('transform', `translateX(${diff}px)`);
                let indicator = currentSwipeItem.parent().find('.swipe-indicator');
                if (diff > 40) indicator.css('opacity', '1');
                else indicator.css('opacity', '0');
            }
        });

        $(document).on('touchend', '.message-item', function(e) {
            if (!currentSwipeItem) return;
            let touchX = e.originalEvent.changedTouches[0].clientX;
            let diff = touchX - touchStartX;

            if (diff > 60) {
                triggerReply(currentSwipeItem);
            }

            currentSwipeItem.css('transform', 'translateX(0)');
            currentSwipeItem.parent().find('.swipe-indicator').css('opacity', '0');
            currentSwipeItem = null;
        });
    }

    function triggerReply(item) {
        const id = item.data('id');
        const text = item.clone().find('.reply-quote').remove().end().text().trim() || 'Attachment';
        const sender = item.hasClass('message-out') ? 'You' : $('#activeUserName').text();

        $('#replyToId').val(id);
        $('#replyToUser').text(sender);
        $('#replyToText').text(text.substring(0, 100));
        $('#replyPreview').css('display', 'flex').hide().fadeIn(200);
        $('#replyInput').focus();
    }

    initInteractions();

    $('#cancelReply').on('click', function() {
        $('#replyToId').val('');
        $('#replyPreview').fadeOut(200);
    });

    // File Upload
    $('#btnAttach').on('click', () => $('#fileInput').click());
    $('#fileInput').on('change', function() {
        if (this.files[0] && this.files[0].size > 50 * 1024 * 1024) {
            alert('File size exceeds 50MB');
            this.value = '';
        } else if (this.files[0]) {
            $('#replyForm').submit();
        }
    });

    // Voice Recording
    $('#btnVoice').on('click', async function() {
        if (!mediaRecorder || mediaRecorder.state === 'inactive') {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];

                mediaRecorder.ondataavailable = e => audioChunks.push(e.data);
                mediaRecorder.onstop = async () => {
                    const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                    const file = new File([audioBlob], "voice_message.webm", { type: 'audio/webm' });
                    
                    const formData = new FormData($('#replyForm')[0]);
                    formData.set('attachment', file);
                    sendFormData(formData);
                    
                    stream.getTracks().forEach(track => track.stop());
                };

                mediaRecorder.start();
                $(this).addClass('text-danger');
            } catch (err) { alert('Mic access blocked.'); }
        } else {
            mediaRecorder.stop();
            $(this).removeClass('text-danger');
        }
    });

    // Search & Filter Logic
    $('#chatSearch').on('input', function() {
        const term = $(this).val().toLowerCase();
        $('.user-item').each(function() {
            const name = $(this).data('name').toLowerCase();
            if (name.includes(term)) $(this).show();
            else $(this).hide();
        });
    });

    $('#filterAll').on('click', function() {
        $(this).removeClass('btn-light text-muted border').addClass('btn-dark');
        $('#filterUnread').removeClass('btn-dark').addClass('btn-light text-muted border');
        $('.user-item').show();
        $('#chatSearch').trigger('input'); // re-apply search
    });

    $('#filterUnread').on('click', function() {
        $(this).removeClass('btn-light text-muted border').addClass('btn-dark');
        $('#filterAll').removeClass('btn-dark').addClass('btn-light text-muted border');
        $('.user-item').each(function() {
            if ($(this).data('unread') === true || $(this).data('unread') === "true") $(this).show();
            else $(this).hide();
        });
        $('#chatSearch').trigger('input'); // re-apply search
    });

    $('#replyForm').on('submit', function(e) {
        e.preventDefault();
        if (!activeUserId) return;
        
        const formData = new FormData(this);
        sendFormData(formData);
    });

    function sendFormData(formData) {
        $.ajax({
            url: `/dashboard/chats/${activeUserId}/reply`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(msg) {
                $('#replyInput').val('');
                $('#fileInput').val('');
                $('#cancelReply').click();
                $('#chatBody').append(renderMessage(msg)).scrollTop($('#chatBody')[0].scrollHeight);
            },
            error: function(err) {
                alert('Error sending message: ' + (err.responseJSON.error || 'Unknown error'));
            }
        });
    }

    // Auto-select from URL or select first conversation by default
    const urlParams = new URLSearchParams(window.location.search);
    const userIdParam = urlParams.get('user');
    if (userIdParam) {
        $(`.select-user[data-id="${userIdParam}"]`).click();
    } else {
        // Click the first user in the list if it exists
        $('#userList .select-user').first().click();
    }

    function pollSidebar() {
        $.get('<?php echo e(route("admin.chats.sidebar")); ?>', function(html) {
            const list = $('#userList');
            const prevScroll = list[0].scrollTop;
            
            list.html(html);
            
            // Re-apply active class
            if (activeUserId) {
                const activeBtn = list.find(`.select-user[data-id="${activeUserId}"]`);
                if (activeBtn.length) {
                    activeBtn.addClass('active bg-light border-start border-primary border-4');
                    // We don't want the badge to show if we are currently looking at them
                    activeBtn.find('.badge').remove();
                }
            }
            
            list[0].scrollTop = prevScroll;
            $('#chatSearch').trigger('input'); // Re-apply current search/filters
        });
    }

    // Polling
    setInterval(() => { 
        if(activeUserId) loadMessages(activeUserId); 
        pollSidebar();
    }, 5000);
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/admin/pages/chats.blade.php ENDPATH**/ ?>