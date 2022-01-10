<?php

namespace Clocker\Controllers;

require (__DIR__ . "/../Services/UserRepository.php");
require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Entities\User;
use Clocker\Services\UserRepository;
use Clocker\Controllers\ErrorBuilder;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST["username"];
    $passwd = $_POST["passwd"];
    $user = UserRepository::loginUser($login);

    $error = null;
    $errorType = 'loginErrorMessage';
    if($user == null) {
        $error = ErrorBuilder::buildUrlQuery("Błędna nazwa użytkownika!", $errorType);
    } else if($user->getPassword() != $passwd) {
        $error = ErrorBuilder::buildUrlQuery("Błędne hasło!", $errorType);
    }

    if($error != null) {
        header("Location: /home_page.php" . $error);
    } else {
        if ( !isset($_SESSION['user_login']) ) {
            session_start();
            $_SESSION['user_login'] = $user->getLogin();
        }

        if ($user->getIsAdmin() == true) {
            header("Location: /admin_page.php");
        } else {
            header("Location: /user_page.php");
        }
    }
}
