<?php
// Check if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function seedbot_woocommerce_options_page() {
    ?>
        <div class="wrap">
        <h1>SeedBot WooCommerce Options</h1>
        <p>This is the WooCommerce Options page under SeedBot settings.</p>
        <h2 class="nav-tab-wrapper">
            <a href="?page=seedbot-settings" class="nav-tab">API Key</a>
            <a href="?page=seedbot-woocommerce-options" class="nav-tab nav-tab-active">WooCommerce Options</a>
            <a href="?page=seedbot-bot-styling" class="nav-tab">Bot Styling</a>
            <a href="?page=seedbot-performance-analytics" class="nav-tab">Performance Analytics</a>
        </h2>
        <h2>WooCommerce Options</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('seedbot-woocommerce');
            do_settings_sections('seedbot-woocommerce');
            submit_button();
            ?>fox
        </form>

         <!-- New section for product filtering options -->
         <form method="post" action="options.php">
            <?php
            settings_fields('seedbot-woocommerce');
            do_settings_sections('seedbot-woocommerce');

            // Call the function to display product filtering options
            seedbot_woocommerce_product_filter_options();

            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function seedbot_register_woocommerce_settings() {
    register_setting('seedbot-woocommerce', 'seedbot_woocommerce_option');
    add_settings_section('seedbot-woocommerce-section', 'WooCommerce Options', 'seedbot_woocommerce_section_cb', 'seedbot-woocommerce');
    add_settings_field('seedbot-woocommerce-field', 'WooCommerce Option 1', 'seedbot_woocommerce_field_cb', 'seedbot-woocommerce', 'seedbot-woocommerce-section');
}

function seedbot_woocommerce_section_cb() {
    echo '<p>Configure WooCommerce options below:</p>';
}

function seedbot_woocommerce_field_cb() {
    $option_value = get_option('seedbot_woocommerce_option');
    echo '<input type="text" name="seedbot_woocommerce_option" value="' . esc_attr($option_value) . '" />';
}

add_action('admin_init', 'seedbot_register_woocommerce_settings');
add_action('admin_menu', 'seedbot_add_woocommerce_options_page');

function seedbot_add_woocommerce_options_page() {
    add_submenu_page('seedbot-settings', 'WooCommerce Options', 'WooCommerce Options', 'manage_options', 'seedbot-woocommerce-options', 'seedbot_woocommerce_options_page');
}
