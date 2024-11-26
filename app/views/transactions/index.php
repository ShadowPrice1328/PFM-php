<?php
$pageTitle = "Transactions";
ob_start();
?>

<h2>Transaction list:</h2>
<div class="row flex-nowrap">
    <div class="col-md-4">
        <div class="form-group">
            <div class="select-wrapper">
                <?php if (!empty($model->category_names)): ?>
                    <label for="category-selector">
                        <select class="form-control" id="category-selector" name="selectedCategory" style="margin-right: 0.5rem">
                            <option value="" disabled selected hidden>Select Category</option>
                            <?php foreach ($model->category_names as $category_name): ?>
                                <option value="<?= htmlspecialchars($category_name) ?>">
                                    <?= htmlspecialchars($category_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <a class="btn btn-create" href="/transactions/create">Create</a>
                <?php else: ?>
                    <label>
                        <select class="form-control" disabled>
                            <option value="">No categories available</option>
                        </select>
                    </label>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<table class="table">
    <thead>
    <tr>
        <th scope="col">
            <?= htmlspecialchars($column_names['Category'] ?? 'Category'); ?>
        </th>
        <th scope="col">
            <?= htmlspecialchars($column_names['Type'] ?? 'Type'); ?>
        </th>
        <th scope="col">
            <?= htmlspecialchars($column_names['Cost'] ?? 'Cost'); ?>
        </th>
        <th scope="col">
            <?= htmlspecialchars($column_names['Date'] ?? 'Date'); ?>
        </th>
        <th scope="col">
            <?= htmlspecialchars($column_names['Description'] ?? 'Description'); ?>
        </th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody id="transactions-body">
    <?php foreach ($model->transactions as $transaction): ?>
        <tr>
            <td>
                <?= htmlspecialchars($transaction['Category']) ?>
            </td>
            <td>
                <?= htmlspecialchars($transaction['Type'])?>
            </td>
            <td>
                <?= htmlspecialchars($transaction['Cost']) ?>
            </td>
            <td>
                <?= htmlspecialchars(date('Y-m-d', strtotime($transaction['Date']))) ?>
            </td>
            <td>
                <?= htmlspecialchars($transaction['Description']) ?>
            </td>
            <td class="actions">
                <a href="/transactions/edit?id=<?= urlencode($transaction['Id']) ?>"><i class="fa-solid fa-pen"></i></a> <span class="separator">|</span>
                <a href="/transactions/details?id=<?= urlencode($transaction['Id']) ?>"><i class="fa-solid fa-circle-info"></i></a> <span class="separator">|</span>
                <a href="/transactions/delete?id=<?= urlencode($transaction['Id']) ?>"><i class="fa-solid fa-trash trash-action"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<p>
    <span style="display:none" id="back-to-list">
        <a class="btn-custom">Back</a>
    </span>
</p>

<input type="hidden" id="link" value="/transactions" />

<script src="/js/transactions.js"></script>
<script src="/js/back-to-list.js"></script>

<?php
    $content = ob_get_clean();
    include_once __DIR__ . "/../layouts/layout.php";
?>