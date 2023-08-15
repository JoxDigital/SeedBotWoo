jQuery(document).ready(function ($) {
    // API Test button click event
    $('#seedbot-test-api').on('click', function () {
        const apiKey = $('input[name="seedbot_api_key"]').val();
        $.ajax({
            url: 'https://api.openai.com/v1/chat/completions',
            type: 'GET',
            headers: {
                'Authorization': `Bearer ${apiKey}`,
            },
            success: function (response) {
                $('#seedbot-test-response').text('API connection successful!');
                console.log('API connection successful!');
            },
            error: function () {
                $('#seedbot-test-response').text('API connection failed.');
            }
        });
    });

    // Chat interface logic
    const chatMessages = document.getElementById('seedbot-chat-messages');
    const userMessageInput = document.getElementById('seedbot-user-message');
    const sendButton = document.getElementById('seedbot-send-button');

    sendButton.addEventListener('click', function () {
        const userMessage = userMessageInput.value;
        if (userMessage.trim() !== '') {
            appendUserMessage(userMessage);
            // Send user message to the backend for processing
            // ...
            // Receive and append the chatbot's response
            // ...
        }
    });

    function appendUserMessage(message) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('seedbot-user-message');
        messageElement.textContent = message;
        chatMessages.appendChild(messageElement);
        userMessageInput.value = '';
    }

    // Add more JavaScript logic for handling the chatbot's responses and other features
});
