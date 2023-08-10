<?php
// Check if pae is accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// API Key settings page
function seedbot_api_key_settings_page() {
    ?>
    <div class="wrap">
        <h2>SeedBot Settings - API Key</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('seedbot_api_key');
            do_settings_sections('seedbot_api_key');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register API Key settings
function seedbot_register_api_key_settings() {
    register_setting('seedbot_api_key', 'seedbot_api_key');

    add_settings_section(
        'seedbot_api_key_section',
        'API Key Settings',
        'seedbot_api_key_section_callback',
        'seedbot_api_key'
    );

    add_settings_field(
        'seedbot_api_key_field',
        'Enter your API Key:',
        'seedbot_api_key_field_callback',
        'seedbot_api_key',
        'seedbot_api_key_section'
    );
}
add_action('admin_init', 'seedbot_register_api_key_settings');

// API Key section callback
function seedbot_api_key_section_callback() {
    echo '<p>Enter your OpenAI API Key below:</p>';
}

// API Key field callback
function seedbot_api_key_field_callback() {
    $api_key = get_option('seedbot_api_key');
    echo '<input type="text" name="seedbot_api_key" value="' . esc_attr($api_key) . '" />';
    echo '<button id="seedbot-test-api" class="button">Test API Connection</button>';
    echo '<p id="seedbot-test-response"></p>';
}

// Enqueue scripts
function seedbot_enqueue_admin_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('seedbot-admin-script', plugin_dir_url(__FILE__) . 'js/seedbot-admin.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'seedbot_enqueue_admin_scripts');
