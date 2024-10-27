<?php
    $pageTitle = "Edit " . $category->name . " category";
    $authenticated = false;
    ob_start();
    ?>
    <div class="container">
        <div class="crud-form">
            <div class="form-head">
                <h1>Edit</h1>
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <form method="post" autocomplete="off" style="margin-top: -40px;">
                <?php if (!empty($errors['summary'])): ?>
                    <div class="text-bad"><?= htmlspecialchars($errors['summary']) ?></div>
                <?php endif; ?>

                <input type="hidden" name="id" value="<?= htmlspecialchars($category->id)?>" />
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($category->name)?>" id="name" class="form-control" />
                    <?php if (!empty($errors['name'])): ?>
                        <span class="text-bad"><?= htmlspecialchars($errors['name']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group" style="margin-top: -30px;">
                    <label for="description">Description</label>
                    <input name="description" type="text" value="<?= htmlspecialchars($category->description)?>" id="description" class="form-control" />
                    <?php if (!empty($errors['description'])): ?>
                        <span class="text-bad"><?= htmlspecialchars($errors['description']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group btn-group">
                    <input type="submit" value="Save" class="btn btn-create" />
                    <a href="/categories" class="btn btn-custom">Back</a>
                </div>
            </form>
        </div>
    </div>

<?php
    $content = ob_get_clean(); // Get the buffered content
    include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
?>