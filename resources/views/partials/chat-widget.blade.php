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
    // Ensure the chat widget exists before running the script
    const chatContainer = document.getElementById('chat-widget-container');
    if (!chatContainer) return;

    const chatBubble = document.getElementById('chat-bubble');
    const chatBox = document.getElementById('chat-box');
    const closeChatBtn = document.getElementById('close-chat');
    const chatInput = document.getElementById('chat-input');
    const sendButton = document.getElementById('send-button');
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    
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

        chatInput.disabled = true;
        sendButton.disabled = true;

        try {
            const response = await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            });

            if (response.ok) {
                // User's message is sent, clear the input field.
                // The message will not be displayed until the admin replies.
                chatInput.value = '';
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

    // Load chat history from a dedicated route
    async function loadChatHistory() {
        try {
            const userId = {{ Auth::id() }};
            const response = await fetch(`/chat/history/${userId}`);

            // Tambahkan pengecekan respons server untuk debugging
            if (!response.ok) {
                const errorText = await response.text();
                console.error('Gagal memuat riwayat chat. Status:', response.status, 'Respons Server:', errorText);
                throw new Error(`Server merespons dengan status: ${response.status}`);
            }
            
            const data = await response.json();

            chatMessages.innerHTML = '';

            if (data.length === 0) {
                chatMessages.innerHTML = '<div class="message system">Belum ada pesan. Mulai percakapan sekarang!</div>';
            } else {
                data.forEach(msg => {
                    appendMessage(msg.message, msg.sender);
                });
            }
        } catch (error) {
            console.error('Terjadi kesalahan pada fungsi loadChatHistory:', error);
            // Don't show error for empty history, just show welcome message
            if (error.message.includes('404') || error.message.includes('No messages found')) {
                chatMessages.innerHTML = '<div class="message system">Belum ada pesan. Mulai percakapan sekarang!</div>';
            } else {
                chatMessages.innerHTML = '<div class="message system">Gagal memuat riwayat chat. Silakan coba lagi nanti.</div>';
            }
        }
    }

    // Append a new message to the chat window
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

    // Listen for new messages via Echo
    if (typeof Echo !== 'undefined' && {{ Auth::id() }}) {
        Echo.private('livechat.' + {{ Auth::id() }})
            .listen('.NewChatMessage', (e) => {
                // When a new message arrives, reload the entire chat history
                // This ensures both the admin's reply and the user's original message are shown
                loadChatHistory();
            });
    }
});
</script>

