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

    // Make an API request to OpenAI and get the chatbot response
    $api_url = 'https://api.openai.com/v1/engines/davinci/completions'; // Updated API endpoint
    $response = wp_safe_remote_post($api_url, array(
        'headers' => array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $api_key,
        ),
        'body' => wp_json_encode(array(
            'messages' => array(
                array('role' => 'system', 'content' => 'You are a helpful assistant.'),
                array('role' => 'user', 'content' => $user_message)
            ),
        )),
    ));

    if (!is_wp_error($response)) {
        $response_body = wp_remote_retrieve_body($response);
        $response_data = json_decode($response_body, true);

        // Debugging: Output the full API response
        var_dump($response_data);

        // Extract the chatbot's reply from the response and return it
        $chatbot_reply = isset($response_data['choices'][0]['message']['content'])
            ? $response_data['choices'][0]['message']['content']
            : 'Chatbot encountered an issue.';

        echo $chatbot_reply;
    } else {
        echo 'Chatbot encountered an error.';
    }
}
?>

