<?php
    $pageTitle = "Edit Transaction";
    $authenticated = false;

    ob_start();
?>

<div class="container">
    <div class="crud-form" id="transactions">
        <div class="form-head">
            <h1>Edit</h1>
            <i class="fa-solid fa-pen-to-square"></i>
        </div>
        <form autocomplete="off" method="post">
            <?php if (!empty($errors['summary'])): ?>
                <div class="text-bad"><?= htmlspecialchars($errors['summary']) ?></div>
            <?php endif; ?>

            <input type="hidden" name="id" value="<?= htmlspecialchars($transaction->id)?>"/>
            <div class="form-group">
                <label for="category" class="control-label">Category</label>
                <div class="select-wrapper">
                    <label>
                        <select name="category" class="form-control">
                            <?php foreach ($category_names as $category_name): ?>
                                <option value="<?php echo htmlspecialchars($category_name); ?>"><?php echo htmlspecialchars($category_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
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
                            <option value="Expense" <?= htmlspecialchars($transaction->type === "Expense" ? 'selected' : '')?>>Expense</option>
                            <option value="Revenue"><?= htmlspecialchars($transaction->type === "Revenue" ? 'selected' : '')?>Revenue</option>
                        </select>
                    </label>
                </div>
                <?php if (!empty($errors['type'])): ?>
                    <span class="text-bad"><?= htmlspecialchars($errors['type']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="cost" class="control-label">Cost
                    <input name="cost" class="form-control" value="<?= htmlspecialchars($transaction->cost) ?>"/>
                </label>
                <?php if (!empty($errors['cost'])): ?>
                    <span class="text-bad"><?= htmlspecialchars($errors['cost']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="date" class="control-label">Date
                    <input name="date" type="date" max="<?php echo date('Y-m-d'); ?>" class="form-control"
                           value="<?= htmlspecialchars((new DateTime($transaction->date))->format('Y-m-d')) ?>"
                </label>
                <?php if (!empty($errors['date'])): ?>
                    <span class="text-bad"><?= htmlspecialchars($errors['date']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Description
                    <input name="description" class="form-control" value="<?= htmlspecialchars($transaction->description)?>"/>
                </label>
                <?php if (!empty($errors['description'])): ?>
                    <span class="text-bad"><?= htmlspecialchars($errors['description']) ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group btn-group">
                <input type="submit" value="Save" class="btn btn-create" />
                <a href="/transactions" class="btn btn-custom">Back</a>
            </div>
        </form>
    </div>
</div>

<?php
    $content = ob_get_clean();
    include_once __DIR__ . "/../layouts/layout.php";
?>