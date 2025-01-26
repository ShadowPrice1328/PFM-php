function addToCart(productId, quantity) {
    event.stopPropagation();

    $.ajax({
        url: '/add-to-cart',
        type: 'POST',
        data: {
            productId: productId,
            quantity: quantity
        },
        success: function(response) {
            let data = JSON.parse(response);

            if (data.status === 'success') {
                console.log(data.message);
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
