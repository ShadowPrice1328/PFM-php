<!DOCTYPE html>
<html lang="EN" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title>Contact Us</title>
</head>
<body>
    <?php
    $authenticated = \services\SessionManager::isLoggedIn();
    $pageTitle = 'Contact';

    ob_start(); // Start output buffering
    ?>

    <div class="container">
        <div style="margin-top: 5rem;">
            <a href="https://www.vecteezy.com/free-vector/postman">
                <img src="/images/postman_vecteezy.jpg" alt="Smiling postman"
                     width="550px"/>
            </a>
            <p style="font-size: xx-small">Postman Vectors by Vecteezy</p>
        </div>

        <div class="form-box" id="contact-form">
            <h1>Contact Us</h1>
            <p>Please fill this form in a decent manner</p>
            <form method="post" id="contactForm">
                <div class="form-group">
                    <label for="name" class="control-label">
                        <input type="text" name="name" class="form-control" required placeholder="Name" maxlength="50"/>
                    </label>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">
                        <input type="email" name="email" class="form-control" required placeholder="Email address" />
                    </label>
                </div>
                <div class="form-group">
                    <label for="phone" class="control-label">
                        <input type="tel" name="phone" class="form-control" placeholder="Phone number" pattern="^[\d\s\-\(\)\+]*$"/>
                    </label>
                </div>
                <div class="form-group">
                    <label for="message" class="control-label">
                        <textarea name="message" placeholder="Enter your message here" required class="message"></textarea>
                    </label>
                </div>
                <div class="form-group" style="margin-top:0">
                    <input type="submit" class="btn btn-custom" value="Send"/>
                </div>
            </form>
            <div id="thankYouMessage" style="display: none; margin-top: 1rem;"></div>
        </div>
    </div>

    <input type="hidden" value="<?php echo $authenticated ? 'true' : 'false'; ?>" id="authenticated"/>
    <input type="hidden" value="contact-form" id="formToSlide"/>

    <?php
    $content = ob_get_clean(); // Get the buffered content
    include (__DIR__ . '/../../views/layouts/layout.php'); // Include the layout
    ?>

    <script src="js/form-slide.js"></script>
    <script src="js/send-email.js"></script>
</body>
</html>
