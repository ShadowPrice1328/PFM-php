<?php
$pageTitle = "Shop";
ob_start();
?>
<h2>Shop page</h2>

<script src='js/addToCart.js'></script>
<script src='js/showInfo.js'></script>
<script src='js/closeModal.js'></script>

<div class="dashboard" id="shop">
    <?php foreach ($viewModel->products as $product): ?>
        <div class="card" onclick="showInfo('<?= htmlspecialchars($product->name); ?>', '<?= htmlspecialchars($product->description); ?>', '<?= htmlspecialchars($product->price->getValue()); ?>', '<?= htmlspecialchars($product->quantity); ?>')">
            <h3><?= htmlspecialchars($product->name); ?></h3>
            <p>Price: <?= htmlspecialchars($product->price->getValue()); ?> zł</p>
            <img src="<?= htmlspecialchars($product->image); ?>" alt="" width="50%">
            <button class="btn-create" onclick="addToCart('<?= $product->id ?>', 1)">Add to Cart</button>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal for showing the image -->
<div id="imageModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3 id="modalTitle"></h3>
        <p id="modalDescription"></p>
        <p id="modalPrice"></p>
        <p id="modalQuantity"></p>
    </div>
</div>

<?php
$content = ob_get_clean();
include_once __DIR__ . "/../layouts/layout.php";
?>