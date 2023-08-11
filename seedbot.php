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
    wp_enqueue_script( 'seedbot-admin', plugin_dir_url( __FILE__ ) . 'admin-settings/js/seedbot-admin.js', array( 'jquery' ), '1.0', true );

    // Localize the script with the API URL
    wp_localize_script('seedbot-admin-script', 'seedbotAdmin', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'seedbot_enqueue_scripts');

// Include admin settings pages toa com
require_once plugin_dir_path(__FILE__) . 'admin-settings/api-key-settings.php';
require_once plugin_dir_path(__FILE__) . 'admin-settings/woocommerce-options.php';
require_once plugin_dir_path(__FILE__) . 'admin-settings/bot-styling.php';
require_once plugin_dir_path(__FILE__) . 'admin-settings/performance-analytics.php';
// require_once plugin_dir_path(__FILE__) . 'includes/seedbot-shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/seedbot-chat-interface.php';

// Create admin menu
function seedbot_admin_menu() {
    $parent_slug = 'seedbot-settings';
    $page_title = 'SeedBot Settings';
    $menu_title = 'SeedBot';
    $capability = 'read';
    $menu_slug = 'seedbot-settings';
    $function = 'seedbot_settings_page';

    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function);

    // Add submenus for SeedBot settings
    $submenu_title = 'API Key';
    $submenu_slug = 'seedbot-settings';
    $submenu_function = 'seedbot_settings_page';

    add_submenu_page($parent_slug, $page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);

    $submenu_title = 'WooCommerce';
    $submenu_slug = 'seedbot-woocommerce-options';
    $submenu_function = 'seedbot_woocommerce_options_page';

    add_submenu_page($parent_slug, $page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);

    $submenu_title = 'Bot Styling';
    $submenu_slug = 'seedbot-bot-styling';
    $submenu_function = 'seedbot_bot_styling_page';

    add_submenu_page($parent_slug, $page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);

    $submenu_title = 'Analytics';
    $submenu_slug = 'seedbot-performance-analytics';
    $submenu_function = 'seedbot_performance_analytics_page';

    add_submenu_page($parent_slug, $page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);
}
add_action('admin_menu', 'seedbot_admin_menu');


// Bot Styling page callback
function seedbot_bot_styling_page() {
    ?>
    <div class="wrap">
        <h1>SeedBot Bot Styling</h1>
        <p>This is the Bot Styling page under SeedBot settings.</p>
        <h2 class="nav-tab-wrapper">
            <a href="?page=seedbot-settings" class="nav-tab">API Key</a>
            <a href="?page=seedbot-woocommerce-options" class="nav-tab">WooCommerce Options</a>
            <a href="?page=seedbot-bot-styling" class="nav-tab nav-tab-active">Bot Styling</a>
            <a href="?page=seedbot-performance-analytics" class="nav-tab">Performance Analytics</a>
        </h2>
    </div>
    <?php
}

// Performance Analytics page callback
function seedbot_performance_analytics_page() {
    ?>
    <div class="wrap">
        <h1>SeedBot Performance Analytics</h1>
        <p>This is the Performance Analytics page under SeedBot settings.</p>
        <h2 class="nav-tab-wrapper">
            <a href="?page=seedbot-settings" class="nav-tab">API Key</a>
            <a href="?page=seedbot-woocommerce-options" class="nav-tab">WooCommerce Options</a>
            <a href="?page=seedbot-bot-styling" class="nav-tab">Bot Styling</a>
            <a href="?page=seedbot-performance-analytics" class="nav-tab nav-tab-active">Performance Analytics</a>
        </h2>
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
            <a href="?page=seedbot-settings" class="nav-tab <?php echo (isset($_GET['page']) && $_GET['page'] === 'seedbot-settings') ? 'nav-tab-active' : ''; ?>">API Key</a>
            <a href="?page=seedbot-woocommerce-options" class="nav-tab <?php echo (isset($_GET['page']) && $_GET['page'] === 'seedbot-woocommerce-options') ? 'nav-tab-active' : ''; ?>">WooCommerce Options</a>
            <a href="?page=seedbot-bot-styling" class="nav-tab <?php echo (isset($_GET['page']) && $_GET['page'] === 'seedbot-bot-styling') ? 'nav-tab-active' : ''; ?>">Bot Styling</a>
            <a href="?page=seedbot-performance-analytics" class="nav-tab <?php echo (isset($_GET['page']) && $_GET['page'] === 'seedbot-performance-analytics') ? 'nav-tab-active' : ''; ?>">Performance Analytics</a>
        </h2>

        <?php
        // Display the content of the current tab
        if (isset($_GET['page'])) {
            $current_tab = sanitize_text_field($_GET['page']);
            if ($current_tab === 'seedbot-woocommerce-options') {
                seedbot_woocommerce_options_page();
            } elseif ($current_tab === 'seedbot-bot-styling') {
                seedbot_bot_styling_page();
            } elseif ($current_tab === 'seedbot-performance-analytics') {
                seedbot_performance_analytics_page();
            } else {
                seedbot_api_key_settings_page(); // Display the API Key content
            }
        } else {
            seedbot_api_key_settings_page(); // Display the API Key content as default
        }
        ?>
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

    $api_url = 'https://api.openai.com/v1/chat/completions'; // Replace with the actual API endpoint

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

// Function to display product filtering options
function seedbot_woocommerce_product_filter_options() {
    ?>
    <h2>Product Filtering Options</h2>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Minimum Price:</th>
            <td><input type="text" name="seedbot_min_price" value="<?php echo esc_attr(get_option('seedbot_min_price', '')); ?>" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Maximum Price:</th>
            <td><input type="text" name="seedbot_max_price" value="<?php echo esc_attr(get_option('seedbot_max_price', '')); ?>" /></td>
        </tr>
        <tr valign="top">
            <th scope="row">Category:</th>
            <td>
                <?php
                $categories = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false));
                if ($categories) {
                    echo '<select name="seedbot_product_category">';
                    echo '<option value="">Select Category</option>';
                    foreach ($categories as $category) {
                        echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                    }
                    echo '</select>';
                }
                ?>
            </td>
        </tr>
    </table>
    <?php
}

// Register product filtering settings
function seedbot_register_product_filter_settings() {
    register_setting('seedbot-woocommerce', 'seedbot_min_price', 'intval');
    register_setting('seedbot-woocommerce', 'seedbot_max_price', 'intval');
    register_setting('seedbot-woocommerce', 'seedbot_product_category', 'intval');
}
add_action('admin_init', 'seedbot_register_product_filter_settings');

// Shortcode to load chatbot
function seedbot_chat_interface_shortcode() {
    ob_start(); // Start output buffering

    // Include the chatbot interface code here
    include plugin_dir_path(__FILE__) . 'includes/seedbot-chat-interface.php';

    // Get the buffered content
    $output = ob_get_clean();

    return $output;
}
add_shortcode('seedbot_chat_interface', 'seedbot_chat_interface_shortcode');
