<table class="table">
    <tbody id="transactions-body">
    <?php foreach ($filtered_transactions as $transaction): ?>
        <tr>
            <td>
                <?= htmlspecialchars($transaction['Category']) ?>
            </td>
            <td>
                <?= htmlspecialchars($transaction['Type']) ?>
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
            <td>
                <a href="/transactions/edit?id=<?= urlencode($transaction['Id']) ?>"><i class="fa-solid fa-pen"></i></a> |
                <a href="/transactions/details?id=<?= urlencode($transaction['Id']) ?>"><i class="fa-solid fa-circle-info"></i></a> |
                <a href="/transactions/delete?id=<?= urlencode($transaction['Id']) ?>"><i class="fa-solid fa-trash"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>