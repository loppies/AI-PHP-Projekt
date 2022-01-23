<?php

namespace Clocker\Controllers;

require (__DIR__ . "/../Services/UserRepository.php");
require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\UserRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST["username"];
    $passwd = $_POST["passwd"];
    $user = UserRepository::loginUser($login);

    $error = null;
    $errorType = 'loginErrorMessage';
    if($user == null) {
        $error = ErrorBuilder::buildUrlQuery("Podano błędne dane podczas logowania!", $errorType);
    } else if($user->getPassword() != $passwd) {
        $error = ErrorBuilder::buildUrlQuery("Podano błędne dane podczas logowania!", $errorType);
    }

    if($error != null) {
        header("Location: /home_page.php" . $error);
    } else {
        if ( !isset($_SESSION['user_login']) ) {
            session_start();
            $_SESSION['user_login'] = $user->getLogin();
            $_SESSION['user_id'] = $user->getId();
            
        }

//        if ($user->getIsAdmin() == true) {
//            header("Location: /admin_page.php");
//        } else {
//            header("Location: /user_page.php");
//        }
      
              if ($user->getIsAdmin() == true) {
            header("Location: /tasks_page.php");
        } else {
            header("Location: /tasks_page.php");
        }
    }
}
