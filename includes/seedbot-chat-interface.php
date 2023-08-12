<?php
// Include any necessary PHP files or initialize variables here

// Start output buffering to capture any output
ob_start();
?>
<div id="seedbot-chat-interface" class="seedbot-chat-interface">
    <div class="seedbot-chat-container">
        <div class="seedbot-chat-header" id="seedbot-chat-header">
            <div id="seedbot-title">
                <div id="seedbot-avatar"></div>
                <div id="seedbot-name"></div>
            </div>
            <div id="seedbot-options">
                <div class="seedbot-option">Option 1</div>
                <div class="seedbot-option">Option Too</div>
                <div class="seedbot-option">Option 3</div>
                <div class="seedbot-option">Option 4</div>
            </div>
        </div>
        <div class="seedbot-chat-messages" id="seedbot-seedbot-chat-messages">
            <!-- Chat messages will be appended here -->
        </div>
        <div class="seedbot-user-input">
            <input type="text" id="seedbot-user-message" placeholder="Type your message...">
            <button id="seedbot-send-button">Send</button>
        </div>
    </div>
</div>

<?php
// Get the buffered content and send it to the browser
echo ob_get_clean();
?>
