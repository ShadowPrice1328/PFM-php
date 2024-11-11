<?php
    $pageTitle = "Create a new account";
    $authenticated = false;

    var_dump($email ?? '');
    var_dump($username ?? '');
    var_dump($password ?? '');


ob_start();
?>

<div class="container text-center">
    <div>
        <a href="https://www.vecteezy.com/free-vector/registration">
            <img src="/images/signup_vecteezy.jpg" alt="Vecteezy.com Isometric flat 3d illustration concept of man filling registration form on screen Free Vector"
                 width="450px" />
        </a>
        <p style="font-size: xx-small">Registration Vectors by Vecteezy</p>
    </div>

    <form method="post" action="/register" class="form-box" style="right: 0; margin-left:3rem" id="registrationForm">
        <h2>Create an PFM account</h2>
        <p class="sub-heading">Create a free account or
            <a href="/">log in</a>.
        </p>

        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" class="form-control" required />
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your name" class="form-control" autocomplete="off" required />
        </div>
        <div class="form-group">
            <div class="row-between">
                <label for="password">Password</label>
                <i class="fa-solid fa-eye" id="pass-eye" style="cursor:pointer;padding-right:2px;" onclick="showpassword()"></i>
            </div>
            <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-custom">Sign Up</button>
    </form>
</div>

<script src="/js/password.js"></script>

<?php
    $content = ob_get_clean();
    include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
?>