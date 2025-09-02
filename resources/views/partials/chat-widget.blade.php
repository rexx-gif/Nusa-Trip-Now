<!-- Chat Widget for User to Admin Communication -->
<link rel="stylesheet" href="{{ asset('css/chat-widget.css') }}">

@auth
<div id="chat-widget-container" data-user-name="{{ Auth::user()->name }}">
    <div id="chat-bubble">
        <i class="fas fa-comment-dots"></i>
    </div>
    <div id="chat-box" class="hidden">
        <div class="chat-header">
            <div class="header-info">
                <h3>Hubungi Admin</h3>
                <div class="online-status">
                    <span class="status-dot"></span>
                    <span>Online</span>
                </div>
            </div>
            <button id="close-chat" title="Tutup Chat">&times;</button>
        </div>

        <div id="chat-messages">
            <!-- Messages will load here dynamically -->
        </div>

        <form id="chat-form">
            @csrf
            <div class="input-container">
                <input type="text" id="chat-input" placeholder="Ketik pesan Anda..." autocomplete="off">
                <button type="submit" id="send-button" disabled>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endauth

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatBubble = document.getElementById('chat-bubble');
    const chatBox = document.getElementById('chat-box');
    const closeChatBtn = document.getElementById('close-chat');
    const chatInput = document.getElementById('chat-input');
    const sendButton = document.getElementById('send-button');
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const chatContainer = document.getElementById('chat-widget-container');
    const userName = chatContainer ? chatContainer.getAttribute('data-user-name') : 'User';

    let historyLoaded = false;

    // Toggle chat box visibility
    chatBubble.addEventListener('click', async () => {
        chatBox.classList.remove('hidden');
        chatBubble.classList.add('hidden');

        if (!historyLoaded) {
            await loadChatHistory();
            historyLoaded = true;
        }

        chatInput.focus();
    });

    closeChatBtn.addEventListener('click', () => {
        chatBox.classList.add('hidden');
        chatBubble.classList.remove('hidden');
    });

    // Enable/disable send button based on input
    chatInput.addEventListener('input', () => {
        sendButton.disabled = chatInput.value.trim().length === 0;
    });

    // Handle form submission
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = chatInput.value.trim();

        if (!message) return;

        // Disable input while sending
        chatInput.disabled = true;
        sendButton.disabled = true;

        try {
            // Send message to server
            const response = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message: message,
                    mode: 'live' // Always use live mode for admin chat
                })
            });

            if (response.ok) {
                // Add message to chat immediately
                appendMessage(message, 'user');
                chatInput.value = '';

                // Load updated history to show any new messages
                setTimeout(() => loadChatHistory(), 1000);
            } else {
                throw new Error('Failed to send message');
            }
        } catch (error) {
            console.error('Error sending message:', error);
            appendMessage('Gagal mengirim pesan. Silakan coba lagi.', 'system');
        } finally {
            chatInput.disabled = false;
            sendButton.disabled = chatInput.value.trim().length === 0;
        }
    });

    // Load chat history
    async function loadChatHistory() {
        try {
            const response = await fetch('/chat/history/user?mode=live');
            const data = await response.json();

            chatMessages.innerHTML = '';

            if (data.length === 0) {
                chatMessages.innerHTML = '<div class="message system">Belum ada pesan. Mulai percakapan sekarang!</div>';
            } else {
                data.forEach(msg => {
                    appendMessage(msg.message, msg.sender_type);
                });
            }
        } catch (error) {
            console.error('Error loading chat history:', error);
            chatMessages.innerHTML = '<div class="message system">Gagal memuat riwayat chat.</div>';
        }
    }

    // Append message to chat
    function appendMessage(message, sender) {
        const msgDiv = document.createElement('div');
        msgDiv.classList.add('message');

        if (sender === 'user') {
            msgDiv.classList.add('sent');
        } else if (sender === 'admin') {
            msgDiv.classList.add('received');
        } else {
            msgDiv.classList.add('system');
        }

        msgDiv.textContent = message;
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Listen for new messages via Echo (if available)
    if (typeof Echo !== 'undefined') {
        Echo.private('livechat.' + {{ Auth::id() }})
            .listen('.NewChatMessage', (e) => {
                if (e.sender !== 'user') {
                    appendMessage(e.message, e.sender);
                }
            });
    }
});
</script>
