<?php

namespace Clocker\Controllers;

require (__DIR__ . "/../Services/UserRepository.php");
require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Entities\User;
use Clocker\Services\UserRepository;
use Clocker\Controllers\ErrorBuilder;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST["reg_email"];
    $login = $_POST["reg_username"];
    $passwd = $_POST["reg_passwd"];

    $user = UserRepository::loginUser($login);

    $error = null;
    $errorType = 'registerErrorMessage';
    if($user != null) {
        $error = ErrorBuilder::buildUrlQuery("Użytkownik o podanym loginie już istnieje!", $errorType);
    } else {
        $user = UserRepository::registerUser($login, $passwd, $email);

        if ($user == null) {
            $error = ErrorBuilder::buildUrlQuery("Nieudana rejestracja użytkowika!", $errorType);
        }
    }

    if($error != null) {
        header("Location: /home_page.php" . $error);
    } else {
        if ( !isset($_SESSION['user_login']) ) {
            session_start();
            $_SESSION['user_login'] = $user->getLogin();
        }

        header("Location: /user_page.php");
    }
}
