<?php
require_once './includes/config.php';

if(isset($_SESSION['user'])){
    unset($_SESSION['user']);
}

header('Location: index.php');