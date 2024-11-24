<?php
require_once (__DIR__. '/../../../config/config.php');
$authenticated = \services\SessionManager::isLoggedIn();
$pageTitle = "Home Page";

ob_start(); // Start output buffering
?>
<div class='container text-center' id="home-container">
    <?php if (isset($viewModel['errorMessage'])): ?>
        <p class='status-message'>Connection status: <?php echo htmlspecialchars($viewModel['connectionStatus']); ?></p>
    <?php endif; ?>

    <?php if ($authenticated): ?>
    <div>
        <h1 id="welcome-back-h1">Welcome back, <?php echo $username ?> </h1>
        <div class='dashboard'>
            <div class='card' onclick="redirectTo('/categories')">
                <h2>Categories (<?php echo count($viewModel['categories']); ?>)</h2>
                <ul>
                    <?php foreach (array_slice($viewModel['categories'], 0, 5) as $category): ?>
                        <li><p><?php echo htmlspecialchars($category->name); ?></p></li>
                    <?php endforeach; ?>
                    <li>. . .</li>
                </ul>
            </div>

            <?php if (isset($viewModel['transactions'])): ?>
                <div class='card' onclick="redirectTo('/transactions')">
                    <h2>Recent Transactions</h2>
                    <ul>
                        <?php foreach (array_slice($viewModel['transactions'], 0, 5) as $transaction): ?>
                            <li>
                                <p>
                                    <?= htmlspecialchars($transaction['Category']) . ' - ' . htmlspecialchars($transaction['Cost']) . ' - '; ?>
                                    <?=
                                        htmlspecialchars(strlen($transaction['Description']) > 15
                                        ? substr($transaction['Description'], 0, 15)
                                        : $transaction['Description']);
                                    ?>
                                </p>
                            </li>
                        <?php endforeach; ?>
                        <li>. . .</li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
        <div style="padding-right: 10rem;" id="welcome-text">
            <h1>Welcome to PFM</h1>
            <h3>Manage your personal finances <span class="cool-text">effortlessly</span>.</h3>
        </div>

        <div class="form-box" id="slideForm">
            <h1>Sign In <i class="fa-solid fa-right-to-bracket" style="padding-right: 10px"></i></h1>

            <form method="post" id="loginForm">
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

                <button type="submit" class="btn btn-custom">Login</button>
                <div id="error" class="text-bad"></div>
            </form>

            <input type="hidden" value="<?php echo $authenticated ? 'true' : 'false'; ?>" id="authenticated"/>
            <input type="hidden" value="slideForm" id="formToSlide"/>

            <?php endif; ?>
        </div>
<?php
$content = ob_get_clean(); // Get the buffered content
include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
?>

<script>
    function redirectTo(url) {
        window.location.href = url;
    }
</script>