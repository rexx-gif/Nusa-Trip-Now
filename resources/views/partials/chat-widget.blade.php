<div id="chat-widget-container">
    <div id="chat-bubble">
        <i class="fas fa-comment-dots"></i>
    </div>
    <div id="chat-box" class="hidden">
        <div class="chat-header">
            <h3>NusaTripNow Assistant</h3>
            <button id="close-chat">&times;</button>
        </div>
        <div class="chat-mode-selection">
            <p>Chat with:</p>
            <button class="chat-mode-btn active" data-mode="ai">🤖 AI Assistant</button>
            <button class="chat-mode-btn" data-mode="live">👩‍💼 Live Agent</button>
        </div>
        <div id="chat-messages">
            <div class="message ai">Halo! Ada yang bisa saya bantu?</div>
        </div>
        <form id="chat-form">
            <input type="text" id="chat-input" placeholder="Ketik pesan Anda..." autocomplete="off">
            <button type="submit"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
</div>