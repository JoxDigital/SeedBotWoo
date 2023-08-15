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
                console.log('API connection has failed! SEEDBOT DOT JS');
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
            $.ajax({
                url: 'your-backend-processing-url', // Replace with your actual backend URL
                type: 'POST',
                data: { message: userMessage },
                success: function (response) {
                    appendChatbotMessage(response); // Append chatbot's response
                },
                error: function () {
                    // Handle error if the backend request fails
                }
            });
    
            // Clear user input
            userMessageInput.value = '';
        }
    });
    
    function appendChatbotMessage(message) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('seedbot-chatbot-message');
        messageElement.textContent = message;
        chatMessages.appendChild(messageElement);
    }
    
    function appendUserMessage(message) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('seedbot-user-message');
        messageElement.textContent = message;
        chatMessages.appendChild(messageElement);
        userMessageInput.value = '';
    }

    // Add more JavaScript logic for handling the chatbot's responses and other features

        // Function to update the product list
        function updateProductList() {
            var minPrice = $('input[name="seedbot_min_price"]').val();
            var maxPrice = $('input[name="seedbot_max_price"]').val();
            var category = $('select[name="seedbot_product_category"]').val();
    
            $.ajax({
                type: 'POST',
                url: seedbotAdmin.ajax_url,
                data: {
                    action: 'seedbot_update_product_list', // Create a new AJAX action hook
                    min_price: minPrice,
                    max_price: maxPrice,
                    category: category
                },
                success: function(response) {
                    $('#seedbot-product-list').html(response); // Update the product list content
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('Error:', textStatus, errorThrown);
                }
            });
        }
    
        // Bind updateProductList function to change event of filtering inputs
        $('input[name="seedbot_min_price"], input[name="seedbot_max_price"], select[name="seedbot_product_category"]').on('change', function() {
            updateProductList();
        });

            // Function to update the product list
    function updateProductList() {
        var minPrice = $('input[name="seedbot_min_price"]').val();
        var maxPrice = $('input[name="seedbot_max_price"]').val();
        var category = $('select[name="seedbot_product_category"]').val();

        $.ajax({
            type: 'POST',
            url: seedbotAdmin.ajax_url,
            data: {
                action: 'seedbot_update_product_list', // Create a new AJAX action hook
                min_price: minPrice,
                max_price: maxPrice,
                category: category
            },
            success: function(response) {
                $('#seedbot-product-list').html(response); // Update the product list content
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log('Error:', textStatus, errorThrown);
            }
        });
    }

    // Bind updateProductList function to change event of filtering inputs
    $('input[name="seedbot_min_price"], input[name="seedbot_max_price"], select[name="seedbot_product_category"]').on('change', function() {
        updateProductList();
    });
});
