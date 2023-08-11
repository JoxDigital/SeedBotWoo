<?php
// Define SeedBot shortcode
function seedbot_shortcode($atts, $content = null) {
    // Extract shortcode attributes
    $atts = shortcode_atts(array(
        'gpt_model' => 'gpt-3.5-turbo', // Default GPT model
        'placeholder' => 'Ask me something...', // Default placeholder text
    ), $atts);

    // Output SeedBot chat interface
    ob_start();
    include plugin_dir_path(__FILE__) . 'seedbot-chat-interface.php';
    $output = ob_get_clean();

    return $output;
}
add_shortcode('seedbot', 'seedbot_shortcode');
