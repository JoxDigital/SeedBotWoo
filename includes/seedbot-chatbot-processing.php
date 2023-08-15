<?php
// Include WordPress core
define('WP_USE_THEMES', false);
require_once(ABSPATH . 'wp-load.php');

// Get the user message
$user_message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';

// Ensure the user message is not empty
if (!empty($user_message)) {
    // Your OpenAI API key
    $api_key = get_option('seedbot_api_key'); // Make sure you have a function to retrieve the API key

    // API endpoint
    $api_url = 'https://api.openai.com/v1/completions';

    // Prepare the data for the API request
    $data = array(
        'prompt' => $user_message,
        'max_tokens' => 50, // Adjust as needed
        'model' => 'davinci' // Use 'davinci' model for chat completions
    );

    // Initialize cURL session
    $ch = curl_init($api_url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Execute cURL session and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Chatbot encountered an issue.';
    } else {
        $response_data = json_decode($response, true);

        // Extract the chatbot's reply from the response and return it
        $chatbot_reply = isset($response_data['choices'][0]['text'])
            ? $response_data['choices'][0]['text']
            : 'Chatbot encountered an issue.';

        echo $chatbot_reply;
    }

    // Close cURL session
    curl_close($ch);
} else {
    echo 'No message provided.';
}
?>
