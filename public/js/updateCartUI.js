function updateCartUI() {
    $.ajax({
        url: '/get-cart-info',
        method: 'GET',
        success: function(response) {
            console.log((response));
            console.log('Cart UI updated successfully');

            const cartData = Object.values(JSON.parse(response)); // Convert object to array
            console.log(cartData);

            cartData.forEach(function(item) {
                $(`#name-${item.id}`).text(item.name);
                $(`#price-${item.id}`).text(item.price + 'zł');
                $(`#quantity-${item.id}`).val(item.quantity);
                $(`#total-${item.id}`).text(item.total + 'zł');
            });

            let totalCartPrice = 0;
            cartData.forEach(function(item) {
                totalCartPrice += item.total;
            });
            $('#total-cart').text('Total: ' + totalCartPrice + 'zł');
        },
        error: function() {
            alert('Error updating the cart');
        }
    });
}
