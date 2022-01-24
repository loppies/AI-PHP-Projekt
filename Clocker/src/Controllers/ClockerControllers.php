<?php

use Clocker\Controllers\ErrorBuilder;
use Clocker\Services\UserRepository;

class ClockerControllers {
    public static function loginController($login, $passwd) {
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
            }

            if ($user->getIsAdmin() == true) {
                header("Location: /admin_page.php");
            } else {
                header("Location: /user_page.php");
            }
        }
    }
}