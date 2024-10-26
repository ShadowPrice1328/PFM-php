<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/jquery-3.7.1.min.js"></script>

    <script src="js/categories.js"></script>
    <script src="js/back-to-list.js"></script>
</head>
<body>

<?php
$authenticated = false;
ob_start(); // Start output buffering
?>

<div class="page-content">

</div>
<h2>List of categories</h2>

<div>
    <input type="text" name="input" id="search-field" class="search-control" placeholder="Enter a name of category..."
           autocomplete="off" style="margin-right: 0.5rem"/>
    <button id="search-button" class="btn-custom">Search</button>
    <a class="btn btn-create" href="/categories/create">Create</a>
    <span class="text-muted" style="margin-left: 0.5rem;" id="message"></span>
</div>

<div>
    <table class="table">
        <thead>
        <tr>
            <th>
                <?php echo htmlspecialchars(isset($columnNames['name']) ? $columnNames['name'] : 'Name'); ?>
            </th>
            <th>
                <?php echo htmlspecialchars(isset($columnNames['description']) ? $columnNames['description'] : 'Description'); ?>
            </th>

            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="categories-body">
        <?php foreach ($categories as $item): ?>
            <tr>
                <td>
                    <?php echo htmlspecialchars($item->name); ?>
                </td>
                <td>
                    <?php echo htmlspecialchars($item->description); ?>
                </td>
                <td>
                    <a href="/categories/edit?id=<?php echo urlencode($item->id); ?>">
                        <i class="fa-solid fa-pen"></i>
                    </a> |
                    <a href="/categories/details?id=<?php echo urlencode($item->id); ?>">
                        <i class="fa-solid fa-circle-info"></i>
                    </a> |
                    <a href="/categories/delete?id=<?php echo urlencode($item->id); ?>">
                        <i class="fa-solid fa-trash"></i>
                    </a>
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
</div>

<input type="hidden" id="link" value="categories/search" />

<?php
$content = ob_get_clean(); // Get the buffered content
include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
?>
</body>
