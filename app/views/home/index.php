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

echo "<div class='container text-center'>";

// Connection status
echo "<p class='status-message'>" . htmlspecialchars($viewModel['connectionStatus']) . "</p>";

// Output categories
if (isset($viewModel['categories'])) {
    echo "<div class='dashboard'>";
    echo "<div class='card'>";
    echo "<h2>Categories (" . count($viewModel['categories']) . ")</h2>";
    echo "<ul>";
    foreach ($viewModel['categories'] as $category) {
        echo "<li>" . htmlspecialchars($category['Name']) . "</li>";
    }
    echo "</ul>";
    echo "</div>"; // End of card for categories

    // Output transactions
    if (isset($viewModel['transactions'])) {
        echo "<div class='card'>";
        echo "<h2>Transactions</h2>";
        echo "<ul>";
        foreach ($viewModel['transactions'] as $transaction) {
            echo "<li>" . htmlspecialchars($transaction['Description']) . " - " . htmlspecialchars($transaction['Cost']) . "</li>";
        }
        echo "</ul>";
        echo "</div>"; // End of card for transactions
    }
    echo "</div>"; // End of dashboard
}

echo "</div>";
?>
</body>
</html>
