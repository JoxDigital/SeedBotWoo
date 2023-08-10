<?php

// includes/seedbot-logic.php

// Assuming this is your bot code where you gather WooCommerce product information
function get_bot_product_data() {
    // Retrieve product filtering options from settings
    $min_price = get_option('seedbot_min_price');
    $max_price = get_option('seedbot_max_price');
    $category_id = get_option('seedbot_product_category');

    // Set up arguments for querying WooCommerce products
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    );

    // Apply product filtering options if set
    if ($min_price) {
        $args['meta_query'][] = array(
            'key' => '_price',
            'value' => $min_price,
            'compare' => '>=',
            'type' => 'NUMERIC',
        );
    }

    if ($max_price) {
        $args['meta_query'][] = array(
            'key' => '_price',
            'value' => $max_price,
            'compare' => '<=',
            'type' => 'NUMERIC',
        );
    }

    if ($category_id) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $category_id,
        );
    }

    // Query WooCommerce products
    $products = new WP_Query($args);

    // Process product data and return
    $product_data = array();
    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            $product_data[] = array(
                'title' => get_the_title(),
                'price' => get_post_meta(get_the_ID(), '_price', true),
                // Add more product data as needed
            );
        }
    }

    wp_reset_postdata();

    return $product_data;
}

