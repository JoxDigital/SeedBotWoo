jQuery(document).ready(function($) {
    $('#seedbot-test-api').on('click', function(e) {
        e.preventDefault();

        var apiKey = $('input[name="seedbot_api_key"]').val();

        $.ajax({
            type: 'POST',
            url: ajaxurl, // WordPress AJAX handler URL
            data: {
                action: 'seedbot_test_api_connection',
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

