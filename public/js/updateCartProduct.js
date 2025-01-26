$(document).ready(function() {
    $('input[type="number"].cart-quant').on('change', function() {
        let productId = $(this).attr('name');
        let quantity = $(this).val();

        if (!productId || !quantity) {
            console.log("Invalid product ID or quantity");
            return;
        }
        $.ajax({
            url: 'update-cart',
            method: 'POST',
            data: {
                productId: productId,
                quantity: quantity
            },
            success: function(response) {
                console.log('Cart updated');
                updateCartUI();
            },
            error: function() {
                alert('Error updating the cart');
            }
        });
    });
});
