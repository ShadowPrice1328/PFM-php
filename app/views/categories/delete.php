<?php
    $pageTitle = "Delete " . $category->name . " category";
    $authenticated = false;
    ob_start();
?>

<div class="container">
    <div class="crud-form">
        <div class="form-head">
            <h1>Delete</h1>
            <i class="fa-solid fa-trash"></i>
        </div>

        <div class="details-section">
            <dl>
                <dt>
                    <?php echo(htmlspecialchars($columnNames['name'] ?? 'Name'))?>
                </dt>
                <dd>
                    <?php echo(htmlspecialchars($category->name))?>
                </dd>
                <dt>
                    <?php echo(htmlspecialchars($columnNames['description'] ?? 'Description'))?>
                </dt>
                <dd>
                    <?php echo(htmlspecialchars($category->description))?>
                </dd>
            </dl>

            <form method="post" class="form-group btn-group"
                  style="width: 80%; margin-left: 10%; margin-top: -10%;">

                <input type="hidden" name="id" value="<?= htmlspecialchars($category->id)?>"/>
                <input type="submit" value="Delete" class="btn btn-danger" id="delete-btn"/>
                <a href="/categories" class="btn btn-custom" id="back-to-list-btn">Back</a>
            </form>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
?>

<script src="/js/confirm-deletion.js"></script>
