<?php if(auth()->guard()->check()): ?>
    <!-- Floating Chat Button -->
    <div id="chat-button"
        class="position-fixed shadow-lg rounded-circle d-flex align-items-center justify-content-center text-white cursor-pointer"
        style="width: 50px; height: 50px; z-index: 1050; cursor: pointer; bottom: 20px !important; right: 80px !important;">
        <i class="bi bi-chat-dots fs-4"></i>
    </div>

    <!-- Chat Window -->
    <div id="chat-window" class="position-fixed shadow-lg rounded-4 overflow-hidden flex-column"
        style="width: 350px; height: 450px; z-index: 1051; display: none; border: 1px solid #eee; bottom: 80px !important; right: 20px !important;">

        <?php if(auth()->user()->is_site_owner): ?>

            <!-- Admin Messenger List View -->
            <div id="adminChatList" class="h-100 d-flex flex-column"
                style="background: var(--surface-color); color: var(--default-color);">
                <div class="p-3 pb-2 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold mb-0" style="letter-spacing: -0.5px; color: var(--default-color);">messenger</h4>
                    <div class="d-flex gap-3 align-items-center" style="color: var(--accent-color);">
                        <i class="bi bi-pencil-square fs-5"></i>
                        <i class="bi bi-x-lg cursor-pointer fs-5" id="close-admin-chat" style="cursor: pointer;"></i>
                    </div>
                </div>

                <div class="px-3 pb-2">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text border-0 px-3"
                            style="background: var(--background-color); color: var(--default-color); border-radius: 20px 0 0 20px; opacity: 0.7;"><i
                                class="bi bi-search"></i></span>
                        <input type="text" id="adminWidgetSearch" class="form-control border-0 shadow-none" placeholder="Search"
                            style="background: var(--background-color); color: var(--default-color); border-radius: 0 20px 20px 0;">
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm border-0 px-3 py-1" id="filterWidgetAll"
                            style="background: rgba(128,128,128,0.2); color: var(--default-color); border-radius: 15px; font-weight: 500;">All</button>
                        <button class="btn btn-sm border-0 px-3 py-1" id="filterWidgetUnread"
                            style="background: transparent; color: var(--default-color); border-radius: 15px; font-weight: 500;">Unread</button>
                    </div>
                </div>

                <div class="flex-grow-1 overflow-auto px-2" id="adminWidgetConversations">
                    <!-- Loaded via JSON -->
                </div>
            </div>

            <!-- Admin Active Chat View -->
            <div id="adminChatView" class="h-100 d-none flex-column"
                style="background: var(--surface-color); color: var(--default-color);">
                <div class="p-2 px-3 d-flex align-items-center gap-2" style="border-bottom: 1px solid rgba(128,128,128,0.1);">
                    <i class="bi bi-arrow-left fs-4 cursor-pointer" id="back-to-list" style="color: var(--accent-color);"></i>
                    <img id="adminWidgetActiveUserImg" src="" class="rounded-circle" width="32" height="32">
                    <div class="flex-grow-1">
                        <h6 id="adminWidgetActiveUserName" class="mb-0 fw-bold" style="font-size: 0.95rem;">User</h6>
                    </div>
                    <i class="bi bi-telephone-fill fs-5" style="color: var(--accent-color);"></i>
                    <i class="bi bi-camera-video-fill fs-5 ms-2" style="color: var(--accent-color);"></i>
                </div>

                <div class="chat-body p-3 overflow-auto d-flex flex-column gap-2 flex-grow-1" id="adminWidgetChatBody"
                    style="background: var(--background-color);">
                    <!-- Messages -->
                </div>

                <div class="chat-footer p-0 border-top"
                    style="border-color: rgba(128,128,128,0.1) !important; background: var(--surface-color);">
                    <div class="p-2">
                        <form id="adminWidgetChatForm" class="d-flex align-items-center gap-2" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="reply_to_id" id="adminWidgetReplyId">
                            <input type="file" name="attachment" id="adminWidgetFileInput" class="d-none">

                            <button type="button" class="btn btn-link p-0" id="adminWidgetBtnAttach"
                                style="color: var(--accent-color);"><i class="bi bi-plus-circle-fill fs-4"></i></button>

                            <div class="flex-grow-1 rounded-pill px-3 py-1 d-flex align-items-center"
                                style="background: var(--background-color);">
                                <input type="text" name="message" id="adminWidgetInput"
                                    class="form-control border-0 bg-transparent p-1 shadow-none" placeholder="Message"
                                    autocomplete="off" style="color: var(--default-color);">
                                <i class="bi bi-emoji-smile fs-5 cursor-pointer" style="color: rgba(128,128,128,0.8);"></i>
                            </div>

                            <button type="submit" class="btn btn-link p-0" style="color: var(--accent-color);">
                                <i class="bi bi-send-fill fs-4"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- Standard User Widget Layout -->
            <div class="chat-header p-3 text-white d-flex justify-content-between align-items-center flex-shrink-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-white rounded-circle p-1 d-flex align-items-center justify-content-center"
                        style="width: 30px; height: 30px;">
                        <i class="bi bi-person-fill" style="color: var(--accent-color);"></i>
                    </div>
                    <span class="fw-bold">Chat with <?php echo e($siteOwner->name ?? 'Meher Kanti Sarkar'); ?></span>
                </div>
                <i class="bi bi-x-lg cursor-pointer" id="close-chat" style="cursor: pointer;"></i>
            </div>

            <div class="chat-body p-3 overflow-auto d-flex flex-column gap-2 flex-grow-1" id="userChatBody"
                style="background: var(--background-color);">
                <!-- Messages -->
            </div>

            <div class="chat-footer p-0 border-top" style="background: var(--surface-color);">
                <!-- Reply Preview Bar -->
                <div class="public-reply-preview" id="publicReplyPreview">
                    <div class="flex-grow-1 overflow-hidden">
                        <small class="fw-bold d-block" style="color: var(--accent-color);">Replying to <span
                                id="publicReplyUser"></span></small>
                        <small class="text-muted text-truncate d-block" id="publicReplyText"></small>
                    </div>
                    <i class="bi bi-x fs-6 cursor-pointer" id="cancelPublicReply"></i>
                </div>

                <div class="p-2">
                    <form id="userChatForm" class="d-flex align-items-center gap-1" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="reply_to_id" id="publicReplyId">
                        <input type="file" name="attachment" id="publicFileInput" class="d-none">

                        <button type="button" class="btn btn-link text-secondary p-1" id="publicBtnAttach"><i
                                class="bi bi-paperclip fs-5"></i></button>
                        <button type="button" class="btn btn-link text-secondary p-1" id="publicBtnVoice"><i
                                class="bi bi-mic fs-5"></i></button>

                        <input type="text" name="message" id="userChatInput"
                            class="form-control rounded-pill border-0 px-3 py-1 small" placeholder="Type a message..."
                            autocomplete="off" style="background: var(--background-color); color: var(--default-color);">

                        <button type="submit" class="btn rounded-circle p-2 px-3 shadow-sm"
                            style="background: var(--accent-color); color: var(--contrast-color);">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
    </div>

    <style>
        #chat-button {
            background-color: var(--accent-color) !important;
        }

        #chat-window {
            background-color: var(--surface-color) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
        }

        .chat-header {
            background-color: var(--accent-color) !important;
        }

        .user-msg {
            max-width: 80%;
            padding: 7px 11px;
            border-radius: 15px;
            font-size: 0.85rem;
            line-height: 1.4;
            position: relative;
            cursor: pointer;
            transition: transform 0.1s ease-out;
            word-break: break-word;
            display: inline-block;
            box-sizing: border-box;
        }

        .user-msg:hover {
            transform: scale(1.01);
        }

        .public-message-wrapper {
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
            margin-bottom: 6px;
        }

        .public-swipe-indicator {
            position: absolute;
            left: -30px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-color);
            font-size: 1.2rem;
            transition: opacity 0.2s;
            opacity: 0;
            pointer-events: none;
        }

        .msg-out {
            align-self: flex-end;
            background: var(--accent-color);
            color: var(--contrast-color, #fff);
            border-bottom-right-radius: 2px;
        }

        .msg-in {
            align-self: flex-start;
            background: var(--background-color);
            color: var(--default-color);
            border-bottom-left-radius: 2px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .chat-attachment-img {
            max-width: 180px;
            height: auto;
            display: block;
            border-radius: 8px;
            margin-bottom: 4px;
            cursor: pointer;
        }

        .chat-reply-quote {
            background: rgba(128, 128, 128, 0.1);
            border-left: 3px solid var(--accent-color);
            padding: 4px 8px;
            border-radius: 4px;
            margin-bottom: 4px;
            font-size: 0.75rem;
            color: var(--default-color);
            opacity: 0.8;
            cursor: pointer;
            transition: background 0.2s;
        }

        .chat-reply-quote:hover {
            background: rgba(128, 128, 128, 0.2);
        }

        .public-highlight {
            animation: public-msg-highlight 2s;
        }

        @keyframes public-msg-highlight {
            0% {
                background-color: var(--accent-color);
                opacity: 0.3;
            }

            100% {
                background-color: transparent;
                opacity: 1;
            }
        }

        .public-swipe-indicator {
            position: absolute;
            left: -30px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-color);
            font-size: 1.2rem;
            transition: opacity 0.2s;
            opacity: 0;
            pointer-events: none;
        }

        .public-reply-preview {
            background: var(--surface-color);
            border-left: 3px solid var(--accent-color);
            padding: 5px 10px;
            display: none;
            align-items: center;
            justify-content: space-between;
            font-size: 0.75rem;
            color: var(--default-color);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .recording-pulse {
            color: var(--accent-color) !important;
            animation: chat-pulse 1.5s infinite;
        }

        @keyframes chat-pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        /* Read receipts */
        .public-tick {
            display: inline-flex;
            align-items: center;
            font-size: 12px;
            margin-left: 3px;
            color: rgba(0, 0, 0, 0.4);
            vertical-align: middle;
        }

        .public-tick.read {
            color: #53bdeb;
        }

        /* Bubble timestamp */
        .public-msg-time {
            float: right;
            font-size: 10px;
            color: rgba(0, 0, 0, 0.45);
            margin-left: 6px;
            margin-top: 3px;
            white-space: nowrap;
        }

        .msg-out .public-msg-time {
            color: rgba(0, 0, 0, 0.45);
        }

        /* Scrollbar for chat body */
        #userChatBody::-webkit-scrollbar,
        #adminWidgetChatBody::-webkit-scrollbar,
        #adminWidgetConversations::-webkit-scrollbar {
            width: 4px;
        }

        #userChatBody::-webkit-scrollbar-track,
        #adminWidgetChatBody::-webkit-scrollbar-track,
        #adminWidgetConversations::-webkit-scrollbar-track {
            background: transparent;
        }

        #userChatBody::-webkit-scrollbar-thumb,
        #adminWidgetChatBody::-webkit-scrollbar-thumb,
        #adminWidgetConversations::-webkit-scrollbar-thumb {
            background: rgba(128, 128, 128, 0.5);
            border-radius: 10px;
        }

        /* Admin Widget specific */
        .admin-widget-item {
            transition: background 0.2s;
        }

        .admin-widget-item:hover {
            background: rgba(128, 128, 128, 0.1);
        }

        .admin-widget-item .unread-dot {
            width: 12px;
            height: 12px;
            background: var(--accent-color);
            border-radius: 50%;
            display: inline-block;
        }

        .admin-widget-item .name-text {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--default-color);
        }

        .admin-widget-item .msg-text {
            font-size: 0.85rem;
            color: rgba(128, 128, 128, 0.8);
            max-width: 190px;
        }

        .admin-widget-item .time-text {
            font-size: 0.75rem;
            color: rgba(128, 128, 128, 0.8);
        }

        .admin-widget-item.unread .name-text {
            font-weight: 700;
            color: var(--default-color) !important;
        }

        .admin-widget-item.unread .msg-text {
            font-weight: 600;
            color: var(--default-color);
        }

        .admin-widget-item.unread .time-text {
            font-weight: 600;
            color: var(--default-color);
        }

        .admin-widget-msg-out {
            align-self: flex-end;
            background: var(--accent-color);
            color: var(--contrast-color, #fff);
            border-radius: 18px;
            padding: 8px 12px;
            max-width: 75%;
            font-size: 0.9rem;
            margin-bottom: 2px;
        }

        .admin-widget-msg-in {
            align-self: flex-start;
            background: var(--surface-color);
            border: 1px solid rgba(128, 128, 128, 0.2);
            color: var(--default-color);
            border-radius: 18px;
            padding: 8px 12px;
            max-width: 75%;
            font-size: 0.9rem;
            margin-bottom: 2px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatBtn = document.getElementById('chat-button');
            const chatWindow = document.getElementById('chat-window');
            const closeChat = document.getElementById('close-chat');
            const chatForm = document.getElementById('userChatForm');
            const chatBody = document.getElementById('userChatBody');
            let mediaRecorder;
            let audioChunks = [];

            let publicUserScrolledUp = false;

            // Check if the user is admin
            const isAdmin = <?php echo e(auth()->user()->is_site_owner ? 'true' : 'false'); ?>;

            if (!isAdmin) {
                // --- STANDARD USER WIDGET LOGIC ---
                const chatForm = document.getElementById('userChatForm');
                const closeChat = document.getElementById('close-chat');

                closeChat.addEventListener('click', () => {
                    chatWindow.style.display = 'none';
                    chatBtn.style.display = 'flex';
                });

                // Track user scroll intent
                chatBody.addEventListener('scroll', function () {
                    const atBottom = chatBody.scrollHeight - chatBody.scrollTop - chatBody.clientHeight < 60;
                    publicUserScrolledUp = !atBottom;
                });

                chatBtn.addEventListener('click', () => {
                    chatWindow.style.display = 'flex';
                    chatBtn.style.display = 'none';
                    loadUserMessages(true); // force scroll on open
                });

                function loadUserMessages(forceScroll = false) {
                    const prevScrollTop = chatBody.scrollTop;
                    const prevScrollHeight = chatBody.scrollHeight;

                    fetch('<?php echo e(route('chat.index')); ?>')
                        .then(res => res.json())
                        .then(messages => {
                            let hasNewMessages = false;

                            if (forceScroll) {
                                chatBody.innerHTML = ''; // Clear on open
                            }

                            messages.forEach(msg => {
                                const existingMsg = document.getElementById(`public-msg-${msg.id}`);
                                if (!existingMsg) {
                                    chatBody.innerHTML += renderPublicMessage(msg);
                                    hasNewMessages = true;
                                } else {
                                    // Dynamically update read receipt
                                    const isOut = msg.sender_id == '<?php echo e(auth()->id()); ?>';
                                    if (isOut && msg.is_read) {
                                        const tick = existingMsg.querySelector('.public-tick');
                                        if (tick && !tick.classList.contains('read')) {
                                            tick.classList.add('read');
                                            tick.title = 'Seen';
                                            tick.innerHTML = '&#10003;&#10003;';
                                        }
                                    }
                                }
                            });

                            if (forceScroll || (!publicUserScrolledUp && hasNewMessages)) {
                                chatBody.scrollTop = chatBody.scrollHeight;
                            } else if (hasNewMessages) {
                                // Maintain position adjusted for new content
                                chatBody.scrollTop = prevScrollTop + (chatBody.scrollHeight - prevScrollHeight);
                            }
                        });
                }

                function renderPublicMessage(msg) {
                    const isOut = msg.sender_id == '<?php echo e(auth()->id()); ?>';
                    const type = isOut ? 'out' : 'in';
                    let content = '';

                    if (msg.reply_to) {
                        content += `<div class="chat-reply-quote" data-target-id="${msg.reply_to_id}">${msg.reply_to.message ? msg.reply_to.message.substring(0, 50) : 'Attachment'}</div>`;
                    }

                    if (msg.attachment) {
                        const url = `/storage/${msg.attachment}`;
                        if (msg.file_type === 'image') content += `<img src="${url}" class="chat-attachment-img shadow-sm" onclick="window.open('${url}')">`;
                        else if (msg.file_type === 'video') content += `<video src="${url}" controls style="max-width: 180px;" class="rounded mb-1"></video>`;
                        else if (msg.file_type === 'audio') content += `<audio src="${url}" controls style="max-width: 180px;" class="mb-1"></audio>`;
                        else content += `<div class="p-2 bg-light rounded small border mb-1" style="max-width: 180px;"><a href="${url}" target="_blank" class="text-danger text-decoration-none text-truncate d-block"><i class="bi bi-file-earmark"></i> ${msg.file_name}</a></div>`;
                    }

                    if (msg.message) content += `<span class="message-body">${msg.message}</span>`;

                    // Timestamp + tick
                    const time = msg.created_at
                        ? new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
                        : '';
                    let tick = '';
                    if (isOut) {
                        tick = msg.is_read
                            ? `<span class="public-tick read" title="Seen">&#10003;&#10003;</span>`
                            : `<span class="public-tick" title="Sent">&#10003;</span>`;
                    }
                    content += `<span class="public-msg-time">${time}${tick}</span>`;

                    return `
                        <div class="public-message-wrapper" id="public-msg-${msg.id}">
                            <div class="public-swipe-indicator"><i class="bi bi-reply-fill"></i></div>
                            <div class="user-msg msg-${type} mb-1" data-id="${msg.id}" data-text="${(msg.message || '').replace(/"/g, '&quot;')}">${content}</div>
                        </div>
                    `;
                }

                // Interaction Listeners
                let touchStartX = 0;
                let currentSwipeItem = null;

                document.addEventListener('touchstart', function (e) {
                    const item = e.target.closest('.user-msg');
                    if (item) {
                        touchStartX = e.touches[0].clientX;
                        currentSwipeItem = item;
                    }
                });

                document.addEventListener('touchmove', function (e) {
                    if (!currentSwipeItem) return;
                    let touchX = e.touches[0].clientX;
                    let diff = touchX - touchStartX;

                    if (diff > 0 && diff < 60) {
                        currentSwipeItem.style.transform = `translateX(${diff}px)`;
                        let indicator = currentSwipeItem.parentElement.querySelector('.public-swipe-indicator');
                        if (diff > 30) indicator.style.opacity = '1';
                        else indicator.style.opacity = '0';
                    }
                });

                document.addEventListener('touchend', function (e) {
                    if (!currentSwipeItem) return;
                    let touchX = e.changedTouches[0].clientX;
                    let diff = touchX - touchStartX;

                    if (diff > 45) {
                        triggerPublicReply(currentSwipeItem);
                    }

                    currentSwipeItem.style.transform = 'translateX(0)';
                    currentSwipeItem.parentElement.querySelector('.public-swipe-indicator').style.opacity = '0';
                    currentSwipeItem = null;
                });

                document.addEventListener('dblclick', function (e) {
                    const item = e.target.closest('.user-msg');
                    if (item) triggerPublicReply(item);
                });

                document.addEventListener('click', function (e) {
                    const quote = e.target.closest('.chat-reply-quote');
                    if (quote) {
                        e.stopPropagation();
                        const targetId = quote.dataset.targetId;
                        const target = document.getElementById(`public-msg-${targetId}`);
                        if (target) {
                            publicUserScrolledUp = true; // prevent polling from jumping back
                            target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            const bubble = target.querySelector('.user-msg');
                            bubble.classList.add('public-highlight');
                            setTimeout(() => bubble.classList.remove('public-highlight'), 2000);
                        }
                        return;
                    }

                    const msgItem = e.target.closest('.user-msg');
                    if (msgItem) {
                        triggerPublicReply(msgItem);
                    }
                });

                function triggerPublicReply(msgItem) {
                    const id = msgItem.dataset.id;
                    const text = msgItem.dataset.text || 'Attachment';
                    const sender = msgItem.classList.contains('msg-out') ? 'You' : 'Admin';

                    document.getElementById('publicReplyId').value = id;
                    document.getElementById('publicReplyUser').innerText = sender;
                    document.getElementById('publicReplyText').innerText = text.substring(0, 60);
                    document.getElementById('publicReplyPreview').style.display = 'flex';
                    document.getElementById('userChatInput').focus();
                }

                document.getElementById('cancelPublicReply').onclick = () => {
                    document.getElementById('publicReplyId').value = '';
                    document.getElementById('publicReplyPreview').style.display = 'none';
                };

                // Media Triggers
                document.getElementById('publicBtnAttach').onclick = () => document.getElementById('publicFileInput').click();
                document.getElementById('publicFileInput').onchange = function () {
                    if (this.files[0] && this.files[0].size > 50 * 1024 * 1024) {
                        alert('File size exceeds 50MB');
                        this.value = '';
                    } else if (this.files[0]) {
                        sendPublicChat();
                    }
                };

                // Voice Recording
                document.getElementById('publicBtnVoice').onclick = async function () {
                    if (!mediaRecorder || mediaRecorder.state === 'inactive') {
                        try {
                            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                            mediaRecorder = new MediaRecorder(stream);
                            audioChunks = [];
                            mediaRecorder.ondataavailable = e => audioChunks.push(e.data);
                            mediaRecorder.onstop = () => {
                                const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                                const file = new File([audioBlob], "voice.webm", { type: 'audio/webm' });
                                const formData = new FormData(chatForm);
                                formData.set('attachment', file);
                                postPublicChat(formData);
                                stream.getTracks().forEach(t => t.stop());
                            };
                            mediaRecorder.start();
                            this.classList.add('recording-pulse');
                        } catch (err) { alert('Mic blocked'); }
                    } else {
                        mediaRecorder.stop();
                        this.classList.remove('recording-pulse');
                    }
                };

                chatForm.onsubmit = (e) => { e.preventDefault(); sendPublicChat(); };

                function sendPublicChat() {
                    const formData = new FormData(chatForm);
                    postPublicChat(formData);
                }

                function postPublicChat(formData) {
                    fetch('<?php echo e(route('chat.store')); ?>', { method: 'POST', body: formData })
                        .then(res => res.json())
                        .then(msg => {
                            if (msg.error) return alert(msg.error);
                            chatForm.reset();
                            document.getElementById('cancelPublicReply').click();
                            chatBody.innerHTML += renderPublicMessage(msg);
                            chatBody.scrollTop = chatBody.scrollHeight;
                        });
                }

                setInterval(() => { if (chatWindow.style.display === 'flex') loadUserMessages(); }, 5000);

            } else {
                // --- ADMIN WIDGET LOGIC ---
                const closeAdminChat = document.getElementById('close-admin-chat');
                const adminChatList = document.getElementById('adminChatList');
                const adminChatView = document.getElementById('adminChatView');
                const backToList = document.getElementById('back-to-list');
                const adminListBody = document.getElementById('adminWidgetConversations');
                const adminChatBodyContainer = document.getElementById('adminWidgetChatBody');
                const adminForm = document.getElementById('adminWidgetChatForm');
                let currentAdminActiveUserId = null;
                let adminWidgetScrolledUp = false;

                chatBtn.addEventListener('click', () => {
                    chatWindow.style.display = 'flex';
                    chatBtn.style.display = 'none';
                    if (currentAdminActiveUserId) {
                        adminChatList.classList.add('d-none');
                        adminChatView.classList.remove('d-none');
                        loadAdminWidgetMessages(currentAdminActiveUserId, true);
                    } else {
                        adminChatList.classList.remove('d-none');
                        adminChatView.classList.add('d-none');
                        loadAdminWidgetSidebar();
                    }
                });

                closeAdminChat.addEventListener('click', () => {
                    chatWindow.style.display = 'none';
                    chatBtn.style.display = 'flex';
                });

                backToList.addEventListener('click', () => {
                    currentAdminActiveUserId = null;
                    adminChatView.classList.add('d-none');
                    adminChatList.classList.remove('d-none');
                    loadAdminWidgetSidebar();
                });

                function loadAdminWidgetSidebar() {
                    fetch('<?php echo e(route("admin.chats.json")); ?>')
                        .then(res => res.json())
                        .then(users => {
                            let html = '';
                            users.forEach(u => {
                                const unread = u.unread_count > 0;
                                const msgText = u.last_message ? (u.last_message.message || u.last_message.file_name) : 'No messages yet';
                                let prefix = '';
                                if (u.last_message && u.last_message.sender_id == '<?php echo e(auth()->id()); ?>') {
                                    prefix = `You: `;
                                } else if (u.last_message && !u.last_message.message) {
                                    prefix = `${u.name} sent an attachment.`;
                                }

                                let timeStr = '';
                                if (u.last_message) {
                                    const d = new Date(u.last_message.created_at);
                                    const now = new Date();
                                    if (d.toDateString() === now.toDateString()) {
                                        timeStr = d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                                    } else {
                                        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                                        timeStr = days[d.getDay()];
                                    }
                                }

                                html += `
                                    <div class="d-flex align-items-center gap-3 p-2 rounded admin-widget-item cursor-pointer ${unread ? 'unread' : ''}" data-id="${u.id}" data-name="${u.name}" data-img="${u.profile_image}" onclick="openAdminWidgetChat(${u.id}, '${u.name.replace(/'/g, "\\'")}', '${u.profile_image}')">
                                        <img src="${u.profile_image}" class="rounded-circle" width="50" height="50">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="name-text text-truncate d-block ${unread ? '' : 'accent-color'}">${u.name}</span>
                                                <span class="time-text">${timeStr}</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="msg-text text-truncate d-block">${prefix}${msgText}</span>
                                                ${unread ? '<span class="unread-dot"></span>' : ''}
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                            adminListBody.innerHTML = html || '<div class="text-center text-muted p-4">No conversations.</div>';
                            if (typeof window.applyAdminFilters === 'function') window.applyAdminFilters();
                        });
                }

                window.openAdminWidgetChat = function (id, name, img) {
                    currentAdminActiveUserId = id;
                    document.getElementById('adminWidgetActiveUserName').innerText = name;
                    document.getElementById('adminWidgetActiveUserImg').src = img;
                    adminChatList.classList.add('d-none');
                    adminChatView.classList.remove('d-none');
                    loadAdminWidgetMessages(id, true);
                };

                adminChatBodyContainer.addEventListener('scroll', function () {
                    const atBottom = adminChatBodyContainer.scrollHeight - adminChatBodyContainer.scrollTop - adminChatBodyContainer.clientHeight < 60;
                    adminWidgetScrolledUp = !atBottom;
                });

                function loadAdminWidgetMessages(id, forceScroll = false) {
                    const prevScrollTop = adminChatBodyContainer.scrollTop;
                    const prevScrollHeight = adminChatBodyContainer.scrollHeight;

                    fetch(`/dashboard/chats/${id}`)
                        .then(res => res.json())
                        .then(messages => {
                            let hasNew = false;
                            if (forceScroll) adminChatBodyContainer.innerHTML = '';

                            messages.forEach(msg => {
                                const existingMsg = document.getElementById(`aw-msg-${msg.id}`);
                                if (!existingMsg) {
                                    adminChatBodyContainer.innerHTML += renderAdminWidgetMessage(msg);
                                    hasNew = true;
                                }
                            });

                            if (forceScroll || (!adminWidgetScrolledUp && hasNew)) {
                                adminChatBodyContainer.scrollTop = adminChatBodyContainer.scrollHeight;
                            } else if (hasNew) {
                                adminChatBodyContainer.scrollTop = prevScrollTop + (adminChatBodyContainer.scrollHeight - prevScrollHeight);
                            }
                        });
                }

                function renderAdminWidgetMessage(msg) {
                    const isOut = msg.sender_id == '<?php echo e(auth()->id()); ?>';
                    const cls = isOut ? 'admin-widget-msg-out' : 'admin-widget-msg-in';
                    let content = '';
                    if (msg.attachment) {
                        const url = `/storage/${msg.attachment}`;
                        if (msg.file_type === 'image') content += `<img src="${url}" style="max-width: 150px; border-radius: 8px;" class="mb-1 d-block cursor-pointer" onclick="window.open('${url}')">`;
                        else content += `<a href="${url}" target="_blank" class="text-white text-decoration-underline mb-1 d-block small">${msg.file_name}</a>`;
                    }
                    if (msg.message) content += `<span>${msg.message}</span>`;
                    return `<div id="aw-msg-${msg.id}" class="${cls}">${content}</div>`;
                }

                adminForm.onsubmit = (e) => {
                    e.preventDefault();
                    if (!currentAdminActiveUserId) return;
                    const formData = new FormData(adminForm);
                    fetch(`/dashboard/chats/${currentAdminActiveUserId}/reply`, {
                        method: 'POST', body: formData,
                        headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' }
                    })
                        .then(res => res.json())
                        .then(msg => {
                            adminForm.reset();
                            adminChatBodyContainer.innerHTML += renderAdminWidgetMessage(msg);
                            adminChatBodyContainer.scrollTop = adminChatBodyContainer.scrollHeight;
                        });
                };

                // Admin Filter Listeners
                const adminSearch = document.getElementById('adminWidgetSearch');
                const btnAll = document.getElementById('filterWidgetAll');
                const btnUnread = document.getElementById('filterWidgetUnread');

                window.applyAdminFilters = function () {
                    const term = adminSearch.value.toLowerCase();
                    const isUnread = btnUnread.style.background !== 'transparent' && btnUnread.style.background !== '';
                    document.querySelectorAll('.admin-widget-item').forEach(item => {
                        const matchName = item.dataset.name.toLowerCase().includes(term);
                        const matchUnread = !isUnread || item.classList.contains('unread');
                        if (matchName && matchUnread) {
                            item.classList.remove('d-none');
                            item.classList.add('d-flex');
                        } else {
                            item.classList.remove('d-flex');
                            item.classList.add('d-none');
                        }
                    });
                };

                adminSearch.addEventListener('input', window.applyAdminFilters);

                btnAll.addEventListener('click', function () {
                    this.style.background = 'rgba(128,128,128,0.2)';
                    btnUnread.style.background = 'transparent';
                    window.applyAdminFilters();
                });

                btnUnread.addEventListener('click', function () {
                    this.style.background = 'rgba(128,128,128,0.2)';
                    btnAll.style.background = 'transparent';
                    window.applyAdminFilters();
                });

                setInterval(() => {
                    if (chatWindow.style.display === 'flex') {
                        if (currentAdminActiveUserId) loadAdminWidgetMessages(currentAdminActiveUserId);
                        else loadAdminWidgetSidebar();
                    }
                }, 5000);
            }
        });
    </script>
<?php endif; ?><?php /**PATH E:\LocalServer\htdocs\myPortfolio\resources\views/frontend/include/chat_widget.blade.php ENDPATH**/ ?>