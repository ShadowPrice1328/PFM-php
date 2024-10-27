<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Home Page'; ?></title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/assets/fontawesome-free-6.6.0-web/css/fontawesome.css" />
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/fontawesome-free-6.6.0-web/js/all.js"> </script>

</head>
<body>
<header>
    <ul>
        <li><a href='/'>Home</a></li>
        <li><a href="/categories" class="<?php echo !$authenticated ? '' : 'text-muted'; ?>">Categories</a></li>
        <li><a href="/transactions" class="<?php echo !$authenticated ? '' : 'text-muted'; ?>">Transactions</a></li>
        <li><a href="/reports" class="<?php echo !$authenticated ? '' : 'text-muted'; ?>">Overview</a></li>
        <li><a href="/daily_report" class="<?php echo !$authenticated ? '' : 'text-muted'; ?>">Daily Report</a></li>
        <li><a href="/contact">Contact</a></li>
        <li style="float: right;">
            <?php if (!$authenticated): ?>
                <a href="/register"><i class="fa-solid fa-user-plus" style="padding-right: 12px"></i>Create a new account</a>
            <?php else: ?>
                <a href="#" onclick="logout()">Logout</a>
            <?php endif; ?>
        </li>
    </ul>
</header>

<main>
    <?php echo isset($content) ? $content : ''; ?>
</main>

<footer class="text-muted">
    <div class="text-center">
        &copy; 2024 - Personal Finance Manager
    </div>
</footer>
</body>
</html>
