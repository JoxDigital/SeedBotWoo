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
});
