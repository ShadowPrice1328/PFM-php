function addToCart(productId, quantity) {
    $.ajax({
        url: '/add-to-cart.php',
        type: 'POST',
        data: {
            productId: productId,
            quantity: quantity
        },
        success: function(response) {
            let data = JSON.parse(response);

            if (data.status === 'success') {
                alert(data.message);
            } else {
                alert('Error adding product to cart');
            }
        },
        error: function() {
            alert('Error adding product to cart');
        }
    });
}

function updateCartUI(cart) {
    // Оновити кількість товарів у корзині на сторінці
    let cartCount = 0;
    for (let productId in cart) {
        cartCount += cart[productId].quantity;
    }

    // Показати кількість товарів у корзині
    document.getElementById('cart-count').textContent = cartCount;
}