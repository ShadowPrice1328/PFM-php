<?php
$pageTitle = "Cart";
ob_start();
?>

<script src='js/updateCartProduct.js'></script>
<script src='js/removeFromCart.js'></script>
<script src='js/updateCartUI.js'></script>

<h2>Confirm your order</h2>

<table class="table">
    <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
    </tr>
    <?php foreach ($addedProducts as $item): ?>
    <tr id="product-row-<?= $item->id ?>">
        <?php if ($item !== null && is_object($item) && property_exists($item, 'name')): ?>
            <td id="name-<?= $item->id ?>"><?= htmlspecialchars($item->name) ?></td>
            <td id="price-<?= $item->id ?>"><?= htmlspecialchars($item->price->getValue()) . 'zł'?></td>
            <td>
                <label>
                    <input type="number" class="cart-quant" id="quantity-<?= $item->id ?>" name="<?= $item->id ?>" value="<?= htmlspecialchars($cart[$item->id]['quantity']) ?>" min="1">
                </label>
            </td>
            <td><b id="total-<?= $item->id ?>"><?= htmlspecialchars($item->price->getValue() * $cart[$item->id]['quantity']) . 'zł' ?></b>
                <span class="close" onclick="removeFromCart('<?= htmlspecialchars($item->id) ?>')">&times;</span>
            </td>
        <?php endif; ?>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <b id="total-cart">Total: <?= htmlspecialchars($totalPrice) ?>zł</b>
        </td>
    </tr>
</table>
<button class="btn-create" style="float: right">Checkout</button><br/>

<div id="delivery-form"></div>

<?php //include_once __DIR__ . "/../shop/checkout_form.php";?>

<?php
$content = ob_get_clean();
include_once __DIR__ . "/../layouts/layout.php";
?>

<script>
    $(".cart-quant").on("input", function() {
        if (/^0/.test(this.value)) {
            this.value = this.value.replace(/^0/, "")
        }
    })
</script>

<script src='/js/loadDeliveryForm.js'></script>

