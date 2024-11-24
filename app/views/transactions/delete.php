<?php
    $pageTitle = "Delete Transaction";
    $authenticated = false;
?>

<div class="container" id="delete-container">
    <div class="crud-form" style="margin-top: 3rem;" id="transactions">
        <div class="form-head">
            <h1>Delete</h1>
            <i class="fa-solid fa-trash"></i>
        </div>

        <div class="details-section">
            <dl>
                <dt>
                    <?= htmlspecialchars($columnNames['Category'] ?? 'Category'); ?>
                </dt>
                <dd>
                    <?= htmlspecialchars($transaction->category) ?>
                </dd>
                <dt>
                    <?= htmlspecialchars($columnNames['Type'] ?? 'Type'); ?>
                </dt>
                <dd>
                    <?= htmlspecialchars($transaction->type) ?>
                </dd>
                <dt>
                    <?= htmlspecialchars($columnNames['Cost'] ?? 'Cost'); ?>
                </dt>
                <dd>
                    <?= htmlspecialchars($transaction->cost) ?>
                </dd>
                <dt>
                    <?= htmlspecialchars($columnNames['Date'] ?? 'Date'); ?>
                </dt>
                <dd>
                    <?= htmlspecialchars(date('Y-m-d', strtotime($transaction->date))) ?>
                </dd>
                <dt>
                    <?= htmlspecialchars($columnNames['Description'] ?? 'Description'); ?>
                </dt>
                <dd>
                    <?= htmlspecialchars($transaction->description) ?>
                </dd>
            </dl>
        </div>

        <form method="post" class="form-group btn-group"
              style="width: 80%; margin-top: -10%; margin-bottom: 10%;">

            <input type="hidden" name="id" />
            <input type="submit" value="Delete" class="btn btn-danger" id="delete-btn"/>
            <a href="/transactions" class="btn btn-custom" id="back-to-list-btn">Back</a>
        </form>
    </div>
</div>

<script src="/js/confirm-deletion.js"></script>

<?php
    $content = ob_get_clean();
    include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
?>