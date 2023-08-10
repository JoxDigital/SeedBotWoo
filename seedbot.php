<?php
/*
Plugin Name: SeedBot
Description: A cheerful chatbot plugin with API key and WooCommerce options.
Version: 1.0
Author: joxdigital.com
*/

// Enqueue styles and scripts
function seedbot_enqueue_scripts() {
    // Enqueue CSS file
    wp_enqueue_style('seedbot-style', plugin_dir_url(__FILE__) . 'assets/css/seedbot.css');

    // Enqueue jQuery and JS file
    wp_enqueue_script('jquery');

    // Enqueue SeedBot script
    wp_enqueue_script('seedbot-script', plugin_dir_url(__FILE__) . 'assets/js/seedbot.js', array('jquery'), '1.0', true);
    wp_enqueue_script('seedbot-admin-script', plugin_dir_url(__FILE__) . 'assets/js/seedbot-admin.js', array('jquery'), '1.0', true);

    // Localize the script with the API URL
    wp_localize_script('seedbot-admin-script', 'seedbotAdmin', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'seedbot_enqueue_scripts');

// Create admin menu
function seedbot_admin_menu() {
    $parent_slug = 'seedbot-settings';
    $page_title = 'SeedBot Settings';
    $menu_title = 'SeedBot';
    $capability = 'read';
    $menu_slug = 'seedbot-settings';
    $function = 'seedbot_settings_page';

    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function);

    // Add a submenu under SeedBot settings
    $submenu_title = 'Submenu Page';
    $submenu_slug = 'seedbot-submenu';
    $submenu_function = 'seedbot_submenu_page';

    add_submenu_page($parent_slug, $page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);
}
add_action('admin_menu', 'seedbot_admin_menu');

// Submenu page callback
function seedbot_submenu_page() {
    ?>
    <div class="wrap">
        <h1>SeedBot Submenu Page</h1>
        <p>This is a submenu page under SeedBot settings.</p>
    </div>
    <?php
}


// Settings page callback
function seedbot_settings_page() {
    ?>
    <div class="wrap">
        <h1>SeedBot Settings</h1>
        <?php settings_errors(); ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=seedbot-settings" class="nav-tab nav-tab-active">API Key</a>
            <a href="?page=seedbot-woocommerce" class="nav-tab">WooCommerce Options</a>
        </h2>

        <form method="post" action="options.php">
            <?php
            settings_fields('seedbot-api-key');
            do_settings_sections('seedbot-api-key');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register API Key settings
function seedbot_register_settings() {
    register_setting('seedbot-api-key', 'seedbot_api_key');
    add_settings_section('seedbot-api-key-section', 'API Key', 'seedbot_api_key_section_cb', 'seedbot-api-key');
    add_settings_field('seedbot-api-key-field', 'Enter your API Key:', 'seedbot_api_key_field_cb', 'seedbot-api-key', 'seedbot-api-key-section');
}
add_action('admin_init', 'seedbot_register_settings');

// API Key section callback
function seedbot_api_key_section_cb() {
    echo '<p>Enter your OpenAI API Key below:</p>';
}

// API Key field callback
function seedbot_api_key_field_cb() {
    $api_key = get_option('seedbot_api_key');
    echo '<input type="text" name="seedbot_api_key" value="' . esc_attr($api_key) . '" />';
    echo '<button id="seedbot-test-api" class="button">Test API Connection</button>';
    echo '<p id="seedbot-test-response"></p>';
}

// AJAX action for testing API connection
add_action('wp_ajax_seedbot_test_api_connection', 'seedbot_test_api_connection');
add_action('wp_ajax_nopriv_seedbot_test_api_connection', 'seedbot_test_api_connection');

function seedbot_test_api_connection() {
    $api_key = sanitize_text_field($_POST['api_key']);

    // Perform the API connection test
    // Call OpenAI API with the provided API key and check the response
    // Replace the following placeholder logic with the actual API connection test

    $api_url = 'https://api.openai.com/v1/your-endpoint'; // Replace with the actual API endpoint

    $response = wp_safe_remote_get($api_url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key
        )
    ));

    if (is_wp_error($response)) {
        echo 'API connection failed. Please check your API key.';
    } else {
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code === 200) {
            echo 'API connection successful!';
        } else {
            echo 'API connection failed. Please check your API key.';
        }
    }

    wp_die(); // Required to terminate the AJAX request
}

