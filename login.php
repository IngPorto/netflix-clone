<?php
    if(isset($_POST["username"])){
        echo "Submited";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
    <div class="signInContainer">
        <div class="column">
            <div class="formHeader">
                <img class="icon" src="./assets/images/logo.png" title="Logo" alt="logo">
                <p class="title">Sign In</p>
                <p class="description">to continue to VideoTube</p>
            </div>
            <form action="" method="post">
                <div class="formGroup">
                    <label for="username">Username</label>
                    <input type="text" placeholder="Username" name="username" id="username" required>
                </div>
                <div class="formGroup">
                    <label for="password">Password</label>
                    <input type="password" placeholder="Password" name="password" id="password" required>
                </div>

                <br>
                <button class="submit-btn" type="submit">Continue</button>
            </form>
            <p>Need an account? <a href="./register.php">Sign up here!</a></p>
        </div>
    </div>
</body>
</html>