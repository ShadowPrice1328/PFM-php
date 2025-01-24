<?php
$pageTitle = "Shop";
ob_start();
?>

<h2>Shop page</h2>

<div class="dashboard">

</div>

<?php
$content = ob_get_clean();
include_once __DIR__ . "/../layouts/layout.php";
?>