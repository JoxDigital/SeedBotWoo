jQuery(document).ready(function($) {
    $('#seedbot-test-api').on('click', function(e) {
        e.preventDefault();

        var apiKey = $('input[name="seedbot_api_key"]').val();

        $.ajax({
            type: 'POST',
            url: seedbotAdmin.ajax_url, // Use the localized AJAX URL
            data: {
                action: 'seedbot_test_api_connection',
                api_key: apiKey
            },
            success: function(response) {
                $('#seedbot-test-response').text(response);
                if (response.indexOf('failed') !== -1) {
                    $('#seedbot-test-response').addClass('seedbot-error');
                } else {
                    $('#seedbot-test-response').removeClass('seedbot-error');
                }
            },
            error: function() {
                $('#seedbot-test-response').text('An error occurred. Please try again.');
                $('#seedbot-test-response').addClass('seedbot-error');
            }
        });
    });
});
