<?php
require_once './includes/config.php';
require_once './includes/classes/FormSanitizer.php';
require_once './includes/classes/Account.php';

$account = new Account($connexion);

if (isset($_POST["firstName"]) &&
    isset($_POST["lastName"]) &&
    isset($_POST["username"]) &&
    isset($_POST["email"]) &&
    isset($_POST["confirmEmail"]) &&
    isset($_POST["password"]) &&
    isset($_POST["confirmPassword"])
) {

    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $confirmEmail = FormSanitizer::sanitizeFormEmail($_POST["confirmEmail"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $confirmPassword = FormSanitizer::sanitizeFormPassword($_POST["confirmPassword"]);

    $inputs = [
        $firstName,
        $lastName,
        $username,
        $email,
        $confirmEmail,
        $password,
        $confirmPassword,
    ];
    echo "<pre>";
    print_r(($inputs));
    echo "</pre>";

    $user = $account->register($firstName, $lastName, $username, $email, $confirmEmail, $password, $confirmPassword);
    if ($user) {
        unset($user['password']);
        $_SESSION['user'] = $user;
        header('Location: index.php');
        die();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
    <div class="signInContainer">
        <div class="column">
            <div class="formHeader">
                <!--h1 class="netflixclone icon">NetflixClone</h1-->
                <img class="icon" src="./assets/images/logo.png" title="Logo" alt="logo">
                <p class="title">Sign Up</p>
                <p class="description">to continue to VideoTube</p>
            </div>
            <form action="" method="post">
                <div class="formGroup">
                    <label for="firstName">First Name</label>
                    <input type="text" placeholder="Fist Name" name="firstName" id="firstName" value="<?=isset($firstName) ? $firstName : ''?>" required>
                    <?=$account->getError('firstName')?>
                </div>
                <div class="formGroup">
                    <label for="lastName">Last Name</label>
                    <input type="text" placeholder="Last Name" name="lastName" id="lastName" value="<?=isset($lastName) ? $lastName : ''?>" required>
                    <?=$account->getError('lastName')?>
                </div>
                <div class="formGroup">
                    <label for="username">Username</label>
                    <input type="text" placeholder="Username" name="username" id="username" value="<?=isset($username) ? $username : ''?>" required>
                    <?=$account->getError('username')?>
                </div>
                <div class="formGroup">
                    <label for="email">Email</label>
                    <input type="email" placeholder="Email" name="email" id="email" value="<?=isset($email) ? $email : ''?>" required>
                    <?=$account->getError('email')?>
                </div>
                <div class="formGroup">
                    <label for="confirmEmail">Confirm Email</label>
                    <input type="email" placeholder="Confirm Email" name="confirmEmail" id="confirmEmail" value="<?=isset($confirmEmail) ? $confirmEmail : ''?>" required>
                    <?=$account->getError('confirmEmail')?>
                </div>
                <div class="formGroup">
                    <label for="password">Password</label>
                    <input type="password" placeholder="Password" name="password" id="password" required>
                    <?=$account->getError('password')?>
                </div>
                <div class="formGroup">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" placeholder="Confirm Password" name="confirmPassword" id="confirmPassword" required>
                    <?=$account->getError('confirmPassword')?>
                </div>

                <br>
                <button class="submit-btn" type="submit">Continue</button>
                <?=$account->getError('system')?>
            </form>
            <p>Already have an account? <a href="./login.php">Sign in here!</a></p>
        </div>
    </div>
</body>
</html>