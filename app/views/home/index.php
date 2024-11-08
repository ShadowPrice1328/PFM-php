<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/password.js"></script>
    <script src="js/login.js"></script>
</head>
<body>
<?php
require_once (__DIR__. '/../../../config/config.php');

$authenticated = false;

ob_start(); // Start output buffering
?>
<div class='container text-center'>
    <?php if (isset($viewModel['errorMessage'])): ?>
        <p class='status-message'>Connection status: <?php echo htmlspecialchars($viewModel['connectionStatus']); ?></p>
    <?php endif; ?>

    <?php if ($authenticated): ?>
    <div>
        <h1>Welcome back, <?php echo '[name of user]' ?> </h1>
        <div class='dashboard'>
            <div class='card' onclick="redirectTo('/categories')">
                <h2>Categories (<?php echo count($viewModel['categories']); ?>)</h2>
                <ul>
                    <?php foreach ($viewModel['categories'] as $category): ?>
                        <li><?php echo htmlspecialchars($category['Name']); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php if (isset($viewModel['transactions'])): ?>
                <div class='card' onclick="redirectTo('/transactions')">
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
    <?php else: ?>
        <div style="padding-right: 10rem;">
            <h1>Welcome to PFM</h1>
            <h3>Manage your personal finances <span class="cool-text">effortlessly</span>.</h3>
        </div>

        <div class="form-box" id="slideForm">
            <h1>Sign In <i class="fa-solid fa-right-to-bracket" style="padding-right: 10px"></i></h1>

        <!-- Login form starts here -->
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" class="form-control" required />
            </div>

            <div class="form-group">
                <div class="row-between">
                    <label for="password">Password</label>
                    <i class="fa-solid fa-eye" id="pass-eye" style="cursor:pointer;padding-right:2px;" onclick="showpassword()"></i>
                </div>
                <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control" required />
            </div>

            <button onclick="login()" class="btn btn-custom">Login</button>
        </div>

        <input type="hidden" value="<?php echo $authenticated ? 'true' : 'false'; ?>" id="authenticated"/>
        <input type="hidden" value="slideForm" id="formToSlide"/>

    <?php endif; ?>
</div>
<?php
$content = ob_get_clean(); // Get the buffered content
include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
?>
</body>
</html>

<script src="js/form-slide.js"></script>

<script>
    function redirectTo(url) {
        window.location.href = url;
    }
</script>