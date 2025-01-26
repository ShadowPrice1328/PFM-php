document.querySelector('.btn-create').addEventListener('click', function() {
    let cartItems = document.querySelectorAll('.cart-quant');
    let isCartEmpty = Array.from(cartItems).every(input => input.value == 0); // Check if all quantities are 0

    if (!isCartEmpty) {
        // Perform an AJAX request to fetch the delivery form
        $.ajax({
            url: '/delivery_form',  // Update the URL to the PHP file that returns the form
            method: 'GET',
            success: function(response) {
                document.getElementById('delivery-form').innerHTML = response.content;
                document.getElementById('delivery-form').style.display = 'block';
            },
            error: function() {
                alert('Error loading the delivery form.');
            }
        });
    } else {
        alert('Please add items to the cart before checking out.');
    }
});
