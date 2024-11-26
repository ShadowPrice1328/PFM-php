<table class="table">
    <tbody id="transactions-body">
    <?php foreach ($filtered_transactions as $transaction): ?>
        <tr>
            <td>
                <?= htmlspecialchars($transaction->category) ?>
            </td>
            <td>
                <?= htmlspecialchars($transaction->type) ?>
            </td>
            <td>
                <?= htmlspecialchars($transaction->cost) ?>
            </td>
            <td>
                <?= htmlspecialchars(date('Y-m-d', strtotime($transaction->date))) ?>
            </td>
            <td>
                <?= htmlspecialchars($transaction->description) ?>
            </td>
            <td>
                <a href="/transactions/edit?id=<?= urlencode($transaction->id) ?>"><i class="fa-solid fa-pen"></i></a> <span class="separator">|</span>
                <a href="/transactions/details?id=<?= urlencode($transaction->id) ?>"><i class="fa-solid fa-circle-info"></i></a> <span class="separator">|</span>
                <a href="/transactions/delete?id=<?= urlencode($transaction->id) ?>"><i class="fa-solid fa-trash trash-action"></i></a> <span class="separator">|</span>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>