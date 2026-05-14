const currentUserId = parseInt(document.querySelector('meta[name="user-id"]').getAttribute('content'));
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let currentConversationId = null;
let currentReceiverId = null;
let typingTimer;

$(document).ready(function() {
    // Setup AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    loadConversations();
    setupEchoListeners();

    // Check for user_id in URL to start chat automatically
    const urlParams = new URLSearchParams(window.location.search);
    const targetUserId = urlParams.get('user_id');
    const targetUserName = urlParams.get('user_name');
    const targetUserRole = urlParams.get('user_role');

    if (targetUserId) {
        // Delay slightly to allow conversations to load or UI to stabilize
        setTimeout(() => {
            startNewConversation(targetUserId, targetUserName || 'User', targetUserRole || '');
        }, 500);
    }

    // Search Users
    $('#user-search').on('input', function() {
        let query = $(this).val();
        if(query.length > 2) {
            $.get('/chat/users/search', {q: query}, function(data) {
                let html = '';
                data.forEach(user => {
                    html += `
                    <div class="search-result-item" data-id="${user.id}" data-name="${user.name}" data-role="${user.role}">
                        <div class="d-flex align-items-center">
                            <div class="chat-avatar bg-primary text-white me-2" style="width:30px; height:30px; font-size:0.9rem;">
                                ${user.name.charAt(0).toUpperCase()}
                            </div>
                            <div>
                                <h6 class="mb-0 text-dark" style="font-size:0.9rem;">${user.name}</h6>
                                <small class="text-muted" style="font-size:0.7rem;">${user.role}</small>
                            </div>
                        </div>
                    </div>`;
                });
                if(data.length === 0) html = '<div class="p-2 text-muted small text-center">No users found</div>';
                $('#search-results').html(html).removeClass('d-none');
            });
        } else {
            $('#search-results').addClass('d-none');
        }
    });

    // Click on search result to start chat
    $(document).on('click', '.search-result-item', function() {
        let userId = $(this).data('id');
        let userName = $(this).data('name');
        let userRole = $(this).data('role');
        
        $('#search-results').addClass('d-none');
        $('#user-search').val('');
        
        startNewConversation(userId, userName, userRole);
    });

    // Click on conversation to open
    $(document).on('click', '.chat-conversation-item', function() {
        $('.chat-conversation-item').removeClass('active');
        $(this).addClass('active');
        
        let convId = $(this).data('id');
        let receiverId = $(this).data('receiver-id');
        let name = $(this).data('name');
        let role = $(this).data('role');

        openConversation(convId, receiverId, name, role);

        if($(window).width() <= 768) {
            $('.chat-sidebar').addClass('hide-mobile');
            $('.back-to-list').show();
        }
    });

    // Mobile back button
    $(document).on('click', '.back-to-list', function() {
        $('.chat-sidebar').removeClass('hide-mobile');
        $(this).hide();
    });

    // Send Message
    $('#chat-form').on('submit', function(e) {
        e.preventDefault();
        
        let message = $('#message-input').val();
        let files = $('#attachment-input')[0].files;

        if(!message.trim() && files.length === 0) return;

        let formData = new FormData(this);
        if(currentConversationId) {
            formData.append('conversation_id', currentConversationId);
        } else {
            formData.append('receiver_id', currentReceiverId);
        }
        formData.append('message', message);

        $('#message-input').val('');
        $('#attachment-input').val('');
        $('#attachment-preview').html('');
        
        // Append optimistic UI bubble
        appendMessage({
            sender_id: currentUserId,
            message: message,
            created_at: new Date().toISOString(),
            is_seen: false,
            attachments: Array.from(files).map(f => ({file_name: f.name, file_type: f.type.startsWith('image') ? 'image' : 'doc'}))
        }, true);
        scrollToBottom();

        $.ajax({
            url: '/chat/messages',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // If it was a new conversation, update current ID
                if(!currentConversationId && response.conversation_id) {
                    currentConversationId = response.conversation_id;
                    loadConversations();
                }
                // We could replace optimistic bubble with real one, but usually it's fine
            },
            error: function(err) {
                console.error(err);
                alert("Failed to send message.");
            }
        });
    });

    // Attachment Preview
    $('#attachment-input').on('change', function() {
        let html = '';
        Array.from(this.files).forEach(f => {
            html += `<span class="file-preview-badge"><i class="fas fa-file"></i> ${f.name}</span>`;
        });
        $('#attachment-preview').html(html);
    });

    // Typing Indicator Logic
    $('#message-input').on('keydown', function() {
        if(currentReceiverId && window.Echo) {
            window.Echo.private('chat.' + currentReceiverId)
                .whisper('typing', {
                    user_id: currentUserId,
                    conversation_id: currentConversationId
                });
        }
    });
});

function loadConversations() {
    $.get('/chat/conversations', function(data) {
        let html = '';
        data.forEach(conv => {
            let badge = conv.unread_count > 0 ? `<span class="badge unread-badge">${conv.unread_count}</span>` : '';
            let isActive = currentConversationId === conv.id ? 'active' : '';
            html += `
            <div class="chat-conversation-item ${isActive}" data-id="${conv.id}" data-receiver-id="${conv.user.id}" data-name="${conv.user.name}" data-role="${conv.user.role}">
                <div class="chat-avatar text-white me-2">
                    ${conv.user.name.charAt(0).toUpperCase()}
                </div>
                <div class="chat-conversation-info">
                    <h6>${conv.user.name}</h6>
                    <p>${conv.last_message || (conv.last_message_time ? 'Attachment' : 'No messages yet')}</p>
                </div>
                <div class="chat-conversation-meta">
                    <span class="time">${conv.last_message_time || ''}</span>
                    ${badge}
                </div>
            </div>`;
        });
        if(data.length === 0) html = '<div class="text-center text-muted p-4">No conversations yet</div>';
        $('#conversation-list').html(html);
    });
}

function startNewConversation(userId, name, role) {
    currentConversationId = null;
    currentReceiverId = userId;
    
    // Check if we already have this conversation loaded
    let existingItem = $(`.chat-conversation-item[data-receiver-id="${userId}"]`);
    if(existingItem.length > 0) {
        existingItem.click();
        return;
    }

    setupChatHeader(name, role);
    $('#chat-body').html('');
    showActiveChat();
}

function openConversation(convId, receiverId, name, role) {
    currentConversationId = convId;
    currentReceiverId = receiverId;
    
    setupChatHeader(name, role);
    showActiveChat();
    
    // Fetch Messages
    $('#chat-body').html('<div class="text-center text-muted p-3"><i class="fas fa-spinner fa-spin"></i> Loading messages...</div>');
    $.get(`/chat/conversations/${convId}/messages`, function(messages) {
        $('#chat-body').html('');
        messages.forEach(msg => appendMessage(msg));
        scrollToBottom();
        
        // Mark as read
        markAsRead(convId);
    });
}

function setupChatHeader(name, role) {
    $('#active-user-name').text(name);
    $('#active-user-role').text(role.replace('_', ' ').toUpperCase());
    $('#active-user-avatar').text(name.charAt(0).toUpperCase());
    
    // add back button for mobile
    if($('.back-to-list').length === 0) {
        $('#active-user-name').parent().parent().prepend('<i class="fas fa-arrow-left back-to-list"></i>');
    }
}

function showActiveChat() {
    $('#chat-empty').removeClass('d-flex').addClass('d-none');
    $('#chat-active').removeClass('d-none').addClass('d-flex');
}

function appendMessage(msg, isOptimistic = false) {
    let isSent = msg.sender_id === currentUserId;
    let wrapperClass = isSent ? 'sent' : 'received';
    
    let time = msg.created_at ? new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '';
    
    let tick = '';
    if(isSent) {
        tick = `<i class="fas fa-check-double message-seen-icon ${msg.is_seen ? 'seen' : ''} ms-1"></i>`;
    }

    let attachmentHtml = '';
    if(msg.attachments && msg.attachments.length > 0) {
        msg.attachments.forEach(att => {
            if(att.file_type === 'image') {
                attachmentHtml += `<div class="attachment-preview"><img src="/storage/${att.file_path}" class="attachment-img" onerror="this.src='https://via.placeholder.com/150'"></div>`;
            } else {
                attachmentHtml += `<a href="/storage/${att.file_path}" target="_blank" class="attachment-doc mt-1"><i class="fas fa-file-alt me-2"></i> ${att.file_name}</a>`;
            }
        });
    }

    let textHtml = msg.message ? `<div class="message-text">${escapeHtml(msg.message)}</div>` : '';

    let html = `
    <div class="message-wrapper ${wrapperClass}">
        <div class="message-bubble">
            ${textHtml}
            ${attachmentHtml}
            <div class="message-time">
                ${time} ${tick}
            </div>
        </div>
    </div>`;

    $('#chat-body').append(html);
}

function scrollToBottom() {
    let chatBody = $('#chat-body');
    chatBody.scrollTop(chatBody[0].scrollHeight);
}

function markAsRead(convId) {
    $.post(`/chat/conversations/${convId}/read`, function() {
        // update sidebar unread count
        let item = $(`.chat-conversation-item[data-id="${convId}"]`);
        item.find('.unread-badge').remove();
    });
}

function setupEchoListeners() {
    if(typeof window.Echo === 'undefined') return;

    window.Echo.private('chat.' + currentUserId)
        .listen('MessageSent', (e) => {
            let msg = e.message;
            
            // If message is for currently open conversation
            if(msg.conversation_id == currentConversationId) {
                // If it's not sent by me (syncing my own message from other tab)
                if(msg.sender_id !== currentUserId) {
                    appendMessage(msg);
                    scrollToBottom();
                    markAsRead(currentConversationId);
                }
            } else {
                // Update sidebar, play sound, etc
                loadConversations();
            }
        })
        .listen('MessageSeen', (e) => {
            if(e.conversationId == currentConversationId) {
                $('.message-seen-icon').addClass('seen');
            }
        })
        .listenForWhisper('typing', (e) => {
            if(e.conversation_id == currentConversationId) {
                $('#typing-indicator').removeClass('d-none');
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => {
                    $('#typing-indicator').addClass('d-none');
                }, 3000);
            }
        });
}

function escapeHtml(unsafe) {
    return (unsafe||"").replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
}
