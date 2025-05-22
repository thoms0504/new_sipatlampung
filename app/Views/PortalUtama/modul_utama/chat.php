<?= $this->extend('PortalUtama/layout/template'); ?>
<?= $this->section('content'); ?>

<div class="bg-section-title pt-5"></div>
<section>
    <div class="section-title">
        <h2>Konsultasi Data AI</h2>
    </div>
    <div class="konsultasi">
        <!-- Chat Sessions Sidebar -->
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Chat Sessions</h6>
                        <button class="btn btn-sm btn-primary" id="new-session-btn">
                            <i class="bi bi-plus"></i> New
                        </button>
                    </div>
                    <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                        <div id="sessions-list">
                            <?php if (!empty($user_sessions)): ?>
                                <?php foreach ($user_sessions as $session): ?>
                                    <div class="session-item p-2 border-bottom cursor-pointer <?= $session['status'] == 'active' ? 'bg-light' : '' ?>" 
                                         data-session-id="<?= $session['id'] ?>">
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted"><?= date('M d, H:i', strtotime($session['created_at'])) ?></small>
                                            <span class="badge badge-<?= $session['status'] == 'active' ? 'success' : 'secondary' ?> badge-sm">
                                                <?= ucfirst($session['status']) ?>
                                            </span>
                                        </div>
                                        <div class="mt-1">
                                            <small><?= strlen($session['session_title']) > 30 ? substr($session['session_title'], 0, 30) . '...' : $session['session_title'] ?></small>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="p-3 text-center text-muted">
                                    <small>No chat sessions yet</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Chat Area -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">AI Assistant BPS Lampung</h4>
                            <small class="text-success" id="bot-status">
                                <i class="bi bi-circle-fill"></i> Online
                            </small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-gear"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" id="clear-chat">Clear Chat</a></li>
                                <li><a class="dropdown-item" href="#" id="export-chat">Export Chat</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="chat-box" style="min-height: 450px; max-height: 450px; overflow-y: auto; padding: 1rem;">
                            <div class="text-center text-muted mb-3">
                                <i class="bi bi-robot fs-1"></i>
                                <p class="mb-0">Selamat datang! Saya siap membantu Anda dengan informasi statistik BPS Lampung.</p>
                                <small>Ketik pesan Anda untuk memulai percakapan...</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex form-group mb-0">
                            <div class="form-control chat-area me-2" contenteditable style="min-height: 38px; max-height: 100px; overflow-y: auto;">
                            </div>
                            <button class="btn btn-primary send-button" type="button" disabled>
                                <i class="bi bi-send fs-6"></i>
                            </button>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-lightbulb"></i> 
                                Tip: Tanyakan tentang data statistik, demografi, ekonomi, atau informasi lainnya terkait Lampung
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Typing Indicator -->
<div id="typing-indicator" class="d-none">
    <div class="d-flex justify-content-start">
        <div class="badge bg-secondary text-wrap border border-secondary mb-2" style="height: auto; max-width: 75%; text-align: start;">
            <p class="fw-normal fs-6 p-1 mb-0">
                <span class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                AI sedang mengetik...
            </p>
        </div>
    </div>
</div>

<!--Sweet Alert-->
<?= $this->include('PortalUtama/layout/sweetalert'); ?>

<style>
.session-item:hover {
    background-color: #f8f9fa !important;
}

.session-item.active {
    background-color: #e3f2fd !important;
    border-left: 3px solid #2196f3;
}

.cursor-pointer {
    cursor: pointer;
}

.typing-dots {
    display: inline-block;
}

.typing-dots span {
    display: inline-block;
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background-color: #999;
    margin: 0 1px;
    animation: typing 1.4s infinite ease-in-out;
}

.typing-dots span:nth-child(1) {
    animation-delay: -0.32s;
}

.typing-dots span:nth-child(2) {
    animation-delay: -0.16s;
}

@keyframes typing {
    0%, 80%, 100% {
        transform: scale(0);
        opacity: 0.5;
    }
    40% {
        transform: scale(1);
        opacity: 1;
    }
}

.chat-area:empty:before {
    content: "Ketik pesan Anda...";
    color: #aaa;
}
</style>

<script>
$(function() {
    let client = {
        user_id: <?= session()->get("id"); ?>,
        nama_lengkap: '<?= session()->get("nama_lengkap"); ?>',
        recipient_id: 2, // AI Bot ID
        type: 'chat',
        session_id: <?= $session_id ?? 'null' ?>,
        message: null
    };

    let isTyping = false;

    function addMessage(data, lastDate, send = true) {
        let chatBox = $('.chat-box');
        let createdAt = new Date(data.created_at);
        let el = '';
        
        if (lastDate !== createdAt.toLocaleDateString('id-ID')) {
            el += `<div class='m-2 d-flex justify-content-center date' style='font-size:0.8rem;'>
                     <div class='badge bg-success p-2'>${createdAt.toLocaleDateString('id-ID')}</div>
                   </div>`;
        }
        
        let icon = `<i class="bi bi-check2-all read-status"></i>`;
        if (send) {
            if (data.message_status == 1) {
                icon = `<i class="bi bi-check2-all text-primary read-status"></i>`;
            }
            el += (`<div class="text-start d-flex justify-content-end mb-2">
                      <div class="badge bg-primary text-wrap border border-primary" style="height: auto; max-width: 75%; text-align: start; margin-right: 16px;">
                        <p class="fw-normal fs-6 p-1 mb-0">${data.message}</p>
                        <div class='mb-0 mt-1 text-end' style='font-size:0.65rem'>
                          <p class="text-white-50 d-inline me-1">${createdAt.toLocaleTimeString('en-US')}</p>
                          ${icon}
                        </div>
                      </div>
                    </div>`);
        } else {
            // Bot message
            let botIcon = data.message_type === 'bot' ? '<i class="bi bi-robot me-1"></i>' : '';
            el += (`<div class="d-flex justify-content-start mb-2">
                      <div class="badge bg-light text-dark text-wrap border" style="height: auto; max-width: 75%; text-align: start;">
                        <p class="fw-normal fs-6 p-1 mb-0">${botIcon}${data.message}</p>
                        <div class='mb-0 mt-1 text-end' style='font-size:0.65rem'>
                          <p class="text-muted d-inline me-1">${createdAt.toLocaleTimeString('en-US')}</p>
                        </div>
                      </div>
                    </div>`);
        }
        chatBox.append(el);
        chatBox.scrollTop(chatBox[0].scrollHeight);
    }

    function showTypingIndicator() {
        if (!isTyping) {
            isTyping = true;
            let chatBox = $('.chat-box');
            let typingEl = $('#typing-indicator').html();
            chatBox.append('<div id="temp-typing">' + typingEl + '</div>');
            chatBox.scrollTop(chatBox[0].scrollHeight);
        }
    }

    function hideTypingIndicator() {
        if (isTyping) {
            isTyping = false;
            $('#temp-typing').remove();
        }
    }

    // Send message
    $(document).on('click', '.send-button', function() {
        client.message = $.trim($('.chat-area').html());

        if (client.message != '') {
            // Clean up HTML formatting
            if (client.message.indexOf("<div>") === 0) {
                client.message = client.message.substring(5);
            }
            if (client.message.slice(-6) === "</div>") {
                client.message = client.message.substring(0, client.message.length - 6);
            }
            client.message = client.message.replace(/<\/div><div>/g, "<br/>");
            client.message = client.message.replace(/<div>/g, "<br/>");
            client.message = client.message.replace(/<br\s*\/?>/gi, '\n').replace(/&nbsp;/g, ' ');

            let chatBox = $('.chat-box');
            let lastDate = $('.date').last().text() || new Date().toLocaleDateString('id-ID');
            
            client.created_at = new Date();
            let userMessageData = {
                message: client.message,
                created_at: client.created_at,
                message_type: 'user'
            };

            // Add user message immediately
            addMessage(userMessageData, lastDate, true);
            $('.chat-area').empty();
            $('.send-button').prop('disabled', true);

            // Show typing indicator
            showTypingIndicator();

            $.ajax({
                url: "/chat/send",
                method: "POST",
                data: {
                    'recipient_id': client.recipient_id,
                    'message': client.message,
                    'session_id': client.session_id
                },
                success: function(response) {
                    hideTypingIndicator();
                    if (response.success) {
                        // Reload messages to get AI response
                        setTimeout(function() {
                            loadChatData(true);
                        }, 1000);
                    } else {
                        console.error('Send message error:', response.error);
                    }
                },
                error: function() {
                    hideTypingIndicator();
                    console.error('Send message failed');
                }
            });
        }
    });

    // Enable send button when typing
    $('.chat-area').on('input', function() {
        let content = $.trim($(this).html());
        $('.send-button').prop('disabled', content === '');
    });

    // Handle Enter key
    $('.chat-area').on('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            $('.send-button').click();
        }
    });

    // New session
    $('#new-session-btn').click(function() {
        $.ajax({
            url: "/chat/newSession",
            method: "POST",
            success: function(response) {
                if (response.success) {
                    client.session_id = response.session_id;
                    $('.chat-box').html(`
                        <div class="text-center text-muted mb-3">
                            <i class="bi bi-robot fs-1"></i>
                            <p class="mb-0">Sesi chat baru dimulai!</p>
                            <small>Ketik pesan Anda untuk memulai percakapan...</small>
                        </div>
                    `);
                    location.reload(); // Reload to update sessions list
                }
            }
        });
    });

    // Load session
    $(document).on('click', '.session-item', function() {
        let sessionId = $(this).data('session-id');
        
        $('.session-item').removeClass('active');
        $(this).addClass('active');
        
        $.ajax({
            url: "/chat/loadSession/" + sessionId,
            method: "POST",
            success: function(response) {
                if (response.success) {
                    client.session_id = sessionId;
                    displayMessages(response.messages);
                }
            }
        });
    });

    function displayMessages(messages) {
        let chatBox = $('.chat-box');
        let lastDate = new Date().toLocaleDateString('id-ID');
        let el = '';
        
        if (messages.length === 0) {
            el = `<div class="text-center text-muted mb-3">
                    <i class="bi bi-robot fs-1"></i>
                    <p class="mb-0">Selamat datang! Saya siap membantu Anda dengan informasi statistik BPS Lampung.</p>
                    <small>Ketik pesan Anda untuk memulai percakapan...</small>
                  </div>`;
        } else {
            $.each(messages, function(index, value) {
                let createdAt = new Date(value.created_at);
                if (lastDate !== createdAt.toLocaleDateString('id-ID')) {
                    el += `<div class='m-2 d-flex justify-content-center date' style='font-size:0.8rem;'>
                             <div class='badge bg-success p-2'>${createdAt.toLocaleDateString('id-ID')}</div>
                           </div>`;
                }
                
                let icon = `<i class="bi bi-check2-all read-status"></i>`;
                if (value.message_type == 'user') {
                    if (value.message_status == 1) {
                        icon = `<i class="bi bi-check2-all text-primary read-status"></i>`;
                    }
                    el += (`<div class="text-start d-flex justify-content-end mb-2">
                              <div class="badge bg-primary text-wrap border border-primary" style="height: auto; max-width: 75%; text-align: start; margin-right: 16px;">
                                <p class="fw-normal fs-6 p-1 mb-0">${value.message}</p>
                                <div class='mb-0 mt-1 text-end' style='font-size:0.65rem'>
                                  <p class="text-white-50 d-inline me-1">${createdAt.toLocaleTimeString('en-US')}</p>
                                  ${icon}
                                </div>
                              </div>
                            </div>`);
                } else {
                    let botIcon = value.message_type === 'bot' ? '<i class="bi bi-robot me-1"></i>' : '';
                    el += (`<div class="d-flex justify-content-start mb-2">
                              <div class="badge bg-light text-dark text-wrap border" style="height: auto; max-width: 75%; text-align: start;">
                                <p class="fw-normal fs-6 p-1 mb-0">${botIcon}${value.message}</p>
                                <div class='mb-0 mt-1 text-end' style='font-size:0.65rem'>
                                  <p class="text-muted d-inline me-1">${createdAt.toLocaleTimeString('en-US')}</p>
                                </div>
                              </div>
                            </div>`);
                }
                lastDate = createdAt.toLocaleDateString('id-ID');
            });
        }
        
        chatBox.html(el);
        chatBox.scrollTop(chatBox[0].scrollHeight);
    }

    function loadChatData(update = false) {
        $.ajax({
            url: "/chat/message",
            method: "POST",
            data: {
                'recipient_id': client.recipient_id,
                'update': update
            },
            dataType: 'json',
            success: function(data) {
                displayMessages(data);
            }
        });
    }

    // Initial load
    if (client.session_id) {
        loadChatData(true);
    }

    // Auto-refresh messages every 5 seconds
    setInterval(function() {
        if (client.session_id && !isTyping) {
            loadChatData(true);
        }
    }, 5000);

    // Clear chat
    $('#clear-chat').click(function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to clear this chat?')) {
            $('#new-session-btn').click();
        }
    });
});
</script>

<?= $this->endSection('content'); ?>