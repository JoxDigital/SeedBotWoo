<script>
jQuery(document).ready(function ($) {
    // API Test button click event
    $('#seedbot-test-api').on('click', function () {
        const apiKey = $('input[name="seedbot_api_key"]').val();
        $.ajax({
            url: 'https://api.openai.com/v1/engines',
            type: 'GET',
            headers: {
                'Authorization': `Bearer ${apiKey}`,
            },
            success: function (response) {
                $('#seedbot-test-response').text('API connection successful!');
                console.log('test ffail');
            },
            error: function () {
                $('#seedbot-test-response').text('API connection failed.');
            }
        });
    });
});

</script>