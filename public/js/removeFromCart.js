function removeFromCart(productId) {
    // Send AJAX request to remove product from cart
    $.ajax({
        url: 'remove-from-cart',  // Replace with your actual endpoint
        method: 'POST',
        data: {
            productId: productId
        },
        success: function(response) {
            console.log('Product removed successfully', response);
            $(`#product-row-${productId}`).remove();

            updateCartUI();
        },
        error: function() {
            alert('Error removing the product from the cart');
        }
    });
}
