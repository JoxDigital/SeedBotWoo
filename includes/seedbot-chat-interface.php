<?php
// Include any necessary PHP files or initialize variables here

// Start output buffering to capture any output
ob_start();
?>
<div id="seedbot-chat-interface" class="seedbot-chat-interface">
    <div id="seedbot-chat-container" class="seedbot-chat-container">
        <div class="seedbot-chat-header" id="seedbot-chat-header">
            <div id="seedbot-avatar" class="seedbot-avatar">
                <img src="https://dev.joxdigital.com/wp-content/uploads/2023/08/seedbotavatar-scaled-1.png" alt="ChatBot Avatar"/>
            </div>
            <div id="seedbot-header-content">
                <div id="seedbot-title">
                    <h3>SeedBot GPT-4</h3>
                    <!-- Toggle button -->
                    <button id="seedbot-toggle-button" class="seedbot-toggle-button"></button>
                </div>
                <!-- Remove the <p> tag below the title -->
            </div>
        </div>
        <div class="seedbot-chat-messages" id="seedbot-chat-messages">
            <!-- Chat messages will be appended here -->
        </div>
        <div class="seedbot-input-container" id="seedbot-input-container">
            <div class="seedbot-user-input">
                <input type="text" id="seedbot-user-message" placeholder="Type your message...">
                <button id="seedbot-send-button">Send</button>
            </div>
            <div id="seedbot-emoji-pad" class="eedbot-emoji-pad">
                <!-- Emojis come here  -->
            </div>
        </div>
    </div>
</div>

<?php
// Get the buffered content and send it to the browser
echo ob_get_clean();
?>
