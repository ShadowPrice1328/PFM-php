<form autocomplete="off" method="post">
    <?php if (!empty($errors['summary'])): ?>
        <div class="text-bad"><?= htmlspecialchars($errors['summary']) ?></div>
    <?php endif; ?>
    <div class="form-group">
        <label for="firstDate" class="control-label">From
            <input name="firstDate" id="firstDate" type="date" max="<?= htmlspecialchars(date('Y-m-d')) ?>"
                   value="<?= isset($model) ? htmlspecialchars($model->firstDate->format('Y-m-d')) : '' ?>" class="form-control" required />
        </label>
        <?php if (!empty($errors['firstDate'])): ?>
            <div class="text-bad"><?= htmlspecialchars($errors['firstDate']) ?></div>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="lastDate" class="control-label">To
            <input name="lastDate" id="lastDate" type="date" max="<?= htmlspecialchars(date('Y-m-d')) ?>"
                   value="<?= isset($model) ? htmlspecialchars($model->lastDate->format('Y-m-d')) : '' ?>" class="form-control" required />
        </label>
        <?php if (!empty($errors['lastDate'])): ?>
            <div class="text-bad"><?= htmlspecialchars($errors['lastDate']) ?></div>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="type" class="control-label">Type</label>
        <div class="select-wrapper">
            <label>
                <select name="type" class="form-control" id="type">
                    <option value="Expense" <?= (!isset($model->type) || $model->type === "Expense") ? 'selected' : ''?>>Expense</option>
                    <option value="Revenue" <?= (isset($model->type) && $model->type === "Revenue") ? 'selected' : ''?>>Revenue</option>
                </select>
            </label>
            <?php if (!empty($errors['type'])): ?>
                <div class="text-bad"><?= htmlspecialchars($errors['type']) ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group">
        <label for="category" class="control-label text-muted">Category (optional)</label>
        <div class="select-wrapper">
            <?php if (!empty($category_names)): ?>
                <label>
                    <select class="form-control" name="category" id="category">
                        <option value="" <?= (!isset($model->category)) ? 'selected' : '' ?>>Select Category</option>
                        <?php foreach ($category_names as $category_name): ?>
                            <option value="<?= htmlspecialchars($category_name) ?>" <?= (isset($model->category) && $model->category === $category_name) ? 'selected' : ''?>>
                                <?= htmlspecialchars($category_name) ?>
                            </option>
                        <?php endforeach;?>
                    </select>
                </label>
            <?php else:?>
                <label>
                    <select class="form-control" disabled>
                        <option value="">No categories available</option>
                    </select>
                </label>
            <?php endif;?>
            <?php if (!empty($errors['category'])): ?>
                <div class="text-bad"><?= htmlspecialchars($errors['category']) ?></div>
            <?php endif; ?>
        </div>
    </div>
    <div class="form-group mt-3">
        <input type="submit" value="Generate" class="btn btn-primary" />
    </div>
</form>