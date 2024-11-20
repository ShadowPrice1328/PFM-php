<?php
    $authenticated = \services\SessionManager::isLoggedIn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Home Page'; ?></title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/assets/fontawesome-free-6.6.0-web/css/fontawesome.css" />
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/js/setactive.js"></script>
    <script src="/assets/fontawesome-free-6.6.0-web/js/all.js"> </script>
    <script src="js/password.js"></script>
    <script src="js/login.js"></script>
</head>
<body>
<header>
    <div class="burger-menu" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <ul class="menu">
        <li><a href='/'>Home</a></li>
        <li><a href="/categories" class="<?php echo $authenticated ? '' : 'text-muted'; ?>">Categories</a></li>
        <li><a href="/transactions" class="<?php echo $authenticated ? '' : 'text-muted'; ?>">Transactions</a></li>
        <li><a href="/overview" class="<?php echo $authenticated ? '' : 'text-muted'; ?>">Overview</a></li>
        <li><a href="/daily" class="<?php echo $authenticated ? '' : 'text-muted'; ?>">Daily Report</a></li>
        <li><a href="/contact">Contact</a></li>
        <li style="float: right;">
            <?php if (!$authenticated): ?>
                <a href="/register"><i class="fa-solid fa-user-plus" style="padding-right: 12px"></i>Create a new account</a>
            <?php else: ?>
                <a href="#" onclick="logout()">Logout</a>
            <?php endif; ?>
        </li>
    </ul>
    <div class="mobile-icon">
        <i class="fa-solid fa-coins"></i>
    </div>
</header>


<main>
    <?php echo isset($content) ? $content : ''; ?>
</main>

<footer class="text-muted">
    <div class="text-center">
        &copy; Personal Finance Manager <?php echo date("Y");?>
    </div>
</footer>
</body>
</html>

<script>
    function logout() {
        $.ajax({
            url: '/logout',
            type: 'POST',
            success: function(response) {
                window.location.href = '/';
            },
            error: function(error) {
                console.error('Error logging out:', error);
            }
        });
    }
</script>

<script src="js/toggleMenu.js"></script>
<script src="js/form-slide.js"></script>
