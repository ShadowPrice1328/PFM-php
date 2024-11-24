<?php
    $pageTitle = "Create new Transaction";
    $authenticated = false;
    ob_start();
?>

<div class="container" id="create-container">
    <div class="crud-form" id="transactions">
        <div class="form-head">
            <h1>Create</h1>
            <i class="fa-solid fa-circle-plus"></i>
        </div>
        <form method="post" autocomplete="off">
            <?php if (!empty($errors['summary'])): ?>
                <div class="text-bad"><?= htmlspecialchars($errors['summary']) ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="category">Category</label>
                <div class="select-wrapper">
                    <?php if (!empty($category_names)) : ?>
                        <label>
                            <select name="category" class="form-control">
                                <?php foreach ($category_names as $category_name): ?>
                                    <option value="<?= htmlspecialchars($category_name)?>"><?= htmlspecialchars($category_name)?></option>
                                <?php endforeach;?>
                            </select>
                        </label>
                    <?php else: ?>
                        <label>
                            <select name="category" class="form-control" disabled>
                                <option value="">No categories available</option>
                            </select>
                        </label>
                    <?php endif;?>
                </div>

                <?php if (!empty($errors['category'])): ?>
                    <span class="text-bad"><?= htmlspecialchars($errors['category']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="type" class="control-label">Type</label>
                <div class="select-wrapper">
                    <label>
                        <select name="type" class="form-control">
                            <option value="Expense" selected>Expense</option>
                            <option value="Revenue">Revenue</option>
                        </select>
                    </label>
                </div>
                <?php if (!empty($errors['type'])): ?>
                    <span class="text-bad"><?= htmlspecialchars($errors['type']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group" style="position: relative;">
                <label for="cost" class="control-label">Cost
                    <input name="cost" class="form-control" />
                </label>
                <?php if (!empty($errors['cost'])): ?>
                    <span class="text-bad"><?= htmlspecialchars($errors['cost']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="date" class="control-label">Date
                    <input name="date" type="date" max="<?=htmlspecialchars(date('Y-m-d')) ?>"
                           class="form-control" value="<?=htmlspecialchars(date('Y-m-d')) ?>" />
                </label>
                <?php if (!empty($errors['date'])): ?>
                    <span class="text-bad"><?= htmlspecialchars($errors['date']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Description
                    <input name="description" class="form-control" />
                </label>
                <?php if (!empty($errors['description'])): ?>
                    <span class="text-bad"><?= htmlspecialchars($errors['description']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group btn-group">
                <input type="submit" value="Create" class="btn btn-create" />
                <a href="/transactions" class="btn btn-custom">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
    $content = ob_get_clean();
    include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
?>
