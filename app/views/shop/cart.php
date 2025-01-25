<?php
$pageTitle = "Cart";
ob_start();
?>

<h2>Confirm your order</h2>

<?php foreach ($addedProducts as $item): ?>
    <?php if ($item !== null && is_object($item) && property_exists($item, 'name')): ?>
        <b>Name: </b><?= htmlspecialchars($item->name) ?>
        <p><b>Quantity: </b><?= htmlspecialchars($cart[$item->id]['quantity']) ?></p>
        <p><b>Price: </b><?= htmlspecialchars($item->price->getValue() * intval($cart[$item->id]['quantity']))?></p>
        <br>
    <?php endif; ?>
<?php endforeach; ?>


<?php
$content = ob_get_clean();
include_once __DIR__ . "/../layouts/layout.php";
?>
