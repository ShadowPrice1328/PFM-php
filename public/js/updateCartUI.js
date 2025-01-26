function updateCartUI() {
    $.ajax({
        url: '/get-cart-info',
        method: 'GET',
        success: function(response) {
            console.log('Cart UI updated successfully');

            const cartData = Object.values(JSON.parse(response)); // Convert object to array

            cartData.forEach(function(item) {
                $(`#name-${item.id}`).text(item.name);
                $(`#price-${item.id}`).text(item.price + 'zł');
                $(`#quantity-${item.id}`).val(item.quantity);
                $(`#total-${item.id}`).text(item.total + 'zł'); // Update the total
            });

            console.log(cartData[cartData.length - 1]);
            $('#total-cart').text('Total: ' + cartData[cartData.length - 1] + 'zł');
        },
        error: function() {
            alert('Error updating the cart');
        }
    });
}
