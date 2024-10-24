<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your stylesheet -->
</head>
<body>
<?php
// Include the config and environment loading code
require_once (__DIR__. '/../../../config/config.php');

// Set up page-specific variables
//$authenticated = !User::isAuthenticated();
$authenticated = true;
$pageTitle = 'Home Page';

ob_start(); // Start output buffering
?>
<div class='container text-center'>
    <p class='status-message'>Connection status: <?php echo htmlspecialchars($viewModel['connectionStatus']); ?></p>

    <div class='dashboard'>
        <div class='card'>
            <h2>Categories (<?php echo count($viewModel['categories']); ?>)</h2>
            <ul>
                <?php foreach ($viewModel['categories'] as $category): ?>
                    <li><?php echo htmlspecialchars($category['Name']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php if (isset($viewModel['transactions'])): ?>
            <div class='card'>
                <h2>Transactions</h2>
                <ul>
                    <?php foreach ($viewModel['transactions'] as $transaction): ?>
                        <li><?php echo htmlspecialchars($transaction['Description']) . ' - ' . htmlspecialchars($transaction['Cost']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean(); // Get the buffered content
include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
?>
</body>
</html>
