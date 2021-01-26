<?php
require_once './includes/config.php';
require_once './includes/classes/FormSanitizer.php';
require_once './includes/classes/Account.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix Clone - Welcome</title>
</head>
<body>
    <h1>Hello</h1>
    <br>
    <?php if (!isset($_SESSION['user'])): ?>
        <a href="login.php">Login</a>
        <a href="register.php">Sing Up</a>
        <hr>
        <p>Session data:</p>
    <?php
    echo "NO DATA";
    else: ?>
        <a href="logout.php">Logout</a>
        <hr>
        <p>Session data:</p>
        <pre>
            <?= print_r($_SESSION['user']) ?>
        </pre>
    <?php endif; ?>
</body>
</html>