<!DOCTYPE html>
<html lang="EN">
<head>
    <meta charset="utf-8">
    <title>Contact Us</title>
</head>
<body>
    <?php
    $authenticated = true;
    $pageTitle = 'Contact';

    ob_start(); // Start output buffering
    ?>
    <h1>Contact Page</h1>
    <?php
    $content = ob_get_clean(); // Get the buffered content
    include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
    ?>
</body>
</html>
