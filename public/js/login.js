$(document).ready(function() {
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();
        console.log("Clicked!");

        $.ajax({
            url: '/login',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                if (data.success) {
                    window.location.href = '/';
                } else {
                    $('#error').html(data.message).show();
                }
            },
            error: function(error) {
                $('#error').html('Error during login process.').show();
                console.error('Error:', error);
            }
        });
    });
});