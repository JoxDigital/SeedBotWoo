<?php
// Include any necessary PHP files or initialize variables here

// Start output buffering to capture any output
ob_start();
?>
<div class="seedbot-chat-interface">
    <div class="chat-container">
        <div class="chat-messages" id="chat-messages">
            <!-- Chat messages will be appended here -->
        </div>
        <div class="user-input">
            <input type="text" id="user-message" placeholder="Type your message...">
            <button id="send-button">Send</button>
        </div>
    </div>
</div>

<!-- JavaScript for chatbot functionality -->
<script>
    // Your JavaScript code for chatbot interaction
</script>
<?php
// Get the buffered content and send it to the browser
echo ob_get_clean();
?>
