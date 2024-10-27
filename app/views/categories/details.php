<?php
    $pageTitle = "Details about " . $category->name . " category";
    $authenticated = false;
    ob_start();
?>

<div class="container">
    <div class="crud-form">
        <div class="form-head">
            <h1>Details</h1>
            <i class="fa-solid fa-circle-info"></i>
        </div>

        <div class="details-section">
            <dl>
                <dt>
                    <?php echo htmlspecialchars($columnNames['name'] ?? 'Name')?>
                </dt>
                <dd>
                    <?php echo htmlspecialchars($category->name)?>
                </dd>
                <dt>
                    <?php echo htmlspecialchars($columnNames['description'] ?? 'Description')?>
                </dt>
                <dd>
                    <?php echo htmlspecialchars($category->description)?>
                </dd>
            </dl>
            <div class="form-group btn-group" style="margin-top: 0; width: 80%; margin-left: 10%">
                <a href="/categories/edit?id=<?php echo urlencode($category->id); ?>" class="btn btn-primary">Edit</a>
                <a href="/categories" class="btn btn-custom">Back</a>
            </div>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
?>


