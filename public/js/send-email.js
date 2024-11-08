$(document).ready(function() {
    $('#contactForm').on('submit', function(event) {
        event.preventDefault();
        console.log("Clicked!");

        $.ajax({
            url: 'contact/submit', // Ваша action URL контролера
            type: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                console.log("Success!");
                $('#thankYouMessage').html(data).show();
                $('#contactForm')[0].reset();
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
});