<?php
    $pageTitle = 'Create new category';
?>

<div class="container" id="create-container">
    <div class="crud-form">
        <div class="form-head">
            <h1>Create</h1>
            <i class="fa-solid fa-circle-plus"></i>
        </div>
        <form method="post" autocomplete="off" style="margin-top: -30px;">
            <?php if (!empty($errors['summary'])): ?>
                <div class="text-bad"><?= htmlspecialchars($errors['summary']) ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="name"> Name
                    <input type="text" name="name" class="form-control" placeholder="Enter category name" />
                </label>
                <?php if (!empty($errors['name'])): ?>
                    <span class="text-bad"><?= htmlspecialchars($errors['name']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group" style="margin-top: -30px;">
                <label for="description" class="control-label"> Description
                    <input type="text" name="description" class="form-control" placeholder="Enter category description" />
                </label>
                <?php if (!empty($errors['description'])): ?>
                    <span class="text-bad"><?= htmlspecialchars($errors['description']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group btn-group">
                <input type="submit" value="Create" class="btn btn-create" />
                <a href="/categories" class="btn btn-custom">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
    $content = ob_get_clean();
    include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
?>