<?php
function seedbot_woocommerce_options_page() {
    ?>
    <div class="wrap">
        <h2>WooCommerce Options</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('seedbot-woocommerce');
            do_settings_sections('seedbot-woocommerce');
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
