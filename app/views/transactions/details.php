<?php
    $pageTitle = 'Transaction Details';
    $authenticated = false;

    ob_start();
?>

<div class="container" style="margin-top: 2rem;">
    <div class="crud-form">
        <div class="form-head">
            <h1>Details</h1>
            <i class="fa-solid fa-circle-info"></i>
        </div>

        <div class="details-section">
            <dl>
                <dt>
                    <?= htmlspecialchars($columnNames['Category'] ?? 'Category') ?>
                </dt>
                <dd>
                    <?= htmlspecialchars($transaction->category)?>
                </dd>
                <dt>
                    <?= htmlspecialchars($columnNames['Type'] ?? 'Type') ?>
                </dt>
                <dd>
                    <?= htmlspecialchars($transaction->type)?>
                </dd>
                <dt>
                    <?= htmlspecialchars($columnNames['Cost'] ?? 'Cost') ?>
                </dt>
                <dd>
                    <?= htmlspecialchars($transaction->cost)?>
                </dd>
                <dt>
                    <?= htmlspecialchars($columnNames['Date'] ?? 'Date') ?>
                </dt>
                <dd>
                    <?= htmlspecialchars(date('Y-m-d', strtotime($transaction->date)))?>
                </dd>
                <dt>
                    <?= htmlspecialchars($columnNames['Description'] ?? 'Description') ?>
                </dt>
                <dd>
                    <?= htmlspecialchars($transaction->description)?>
                </dd>
            </dl>
            <div class="form-group btn-group">
                <a href="/transactions/edit?id=<?= urlencode($transaction->id) ?>" class="btn btn-primary">Edit</a>
                <a href="/transactions" class="btn btn-custom">Back</a>
            </div>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
?>