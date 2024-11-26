<table class="table">
    <tbody id="categories-body">
    <?php foreach ($categories as $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item->name); ?></td>
            <td><?php echo htmlspecialchars($item->description); ?></td>
            <td>
                <a href="/categories/edit?id=<?php echo urlencode($item->id); ?>">
                    <i class="fa-solid fa-pen"></i>
                </a> <span class="separator">|</span>
                <a href="/categories/details?id=<?php echo urlencode($item->id); ?>">
                    <i class="fa-solid fa-circle-info"></i>
                </a> <span class="separator">|</span>
                <a href="/categories/delete?id=<?php echo urlencode($item->id); ?>">
                    <i class="fa-solid fa-trash trash-action-categories"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

