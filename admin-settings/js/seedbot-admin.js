jQuery(document).ready(function($) {
    $('#seedbot-test-api').on('click', function(e) {
        e.preventDefault();

        var apiKey = $('input[name="seedbot_api_key"]').val();

        // Use the correct action hook and endpoint URL
        var action = 'seedbot_test_api_connection';
        var ajaxUrl = seedbotAdmin.ajax_url; // Use the localized variable for AJAX URL

        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            data: {
                action: action,
                api_key: apiKey
            },
            success: function(response) {
                $('#seedbot-test-response').text(response);
            },
            error: function(xhr, textStatus, errorThrown) {
                $('#seedbot-test-response').text('Error: ' + textStatus + ' - ' + errorThrown);
            }
        });
    });

    // Inside jQuery(document).ready(function($) {...});

// WooCommerce product filtering
function fetchFilteredProducts() {
    var minPrice = parseInt($('input[name="seedbot_min_price"]').val()) || 0;
    var maxPrice = parseInt($('input[name="seedbot_max_price"]').val()) || Infinity;
    var category = $('select[name="seedbot_product_category"]').val();

    $.ajax({
        type: 'POST',
        url: seedbotAdmin.woocommerce_ajax_url, // Use WooCommerce AJAX URL
        data: {
            action: 'seedbot_woocommerce_filter',
            min_price: minPrice,
            max_price: maxPrice,
            category: category
        },
        success: function(response) {
            $('#seedbot-product-list').html(response);
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log('Error: ' + textStatus + ' - ' + errorThrown);
        }
    });
}

// Bind the filter function to change events
$('input[name="seedbot_min_price"], input[name="seedbot_max_price"], select[name="seedbot_product_category"]').on('change', function() {
    fetchFilteredProducts();
});

// Add event listeners for real-time product filtering and updates
$('#seedbot_min_price, #seedbot_max_price, #seedbot_product_category').on('change', function() {
    updateProductList();
});

// Function to update the product list in real-time
function updateProductList() {
    var minPrice = $('#seedbot_min_price').val();
    var maxPrice = $('#seedbot_max_price').val();
    var category = $('#seedbot_product_category').val();

    // AJAX request to update product list
    $.ajax({
        url: seedbotAdmin.ajax_url,
        method: 'POST',
        data: {
            action: 'seedbot_update_product_list',
            min_price: minPrice,
            max_price: maxPrice,
            category: category
        },
        success: function(response) {
            $('#seedbot-product-list').html(response);
        },
        error: function() {
            $('#seedbot-product-list').html('<p>An error occurred while updating the product list.</p>');
        }
    });
}
});
