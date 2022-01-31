<?php
namespace Clocker\Controllers;

global $APP_SERVICES;
global $APP_CONTROLLERS;

require ($APP_SERVICES. "ClientRepository.php");
require ($APP_SERVICES. "UserRepository.php");
require ($APP_SERVICES. "ProjectRepository.php");
require ($APP_SERVICES. "TaskRepository.php");

use Clocker\Controllers\ClockerResponse;
use Clocker\Services\ProjectRepository;
use Clocker\Services\TaskRepository;
use Clocker\Services\UserRepository;
use Clocker\Services\ClientRepository;

require_once ($APP_CONTROLLERS. "ClockerResponse.php");

class ClockerControllers {
    public static function getMessage($resp, $errorType) {
        $msg = "";

        if ( !empty($resp) ) {
            if ( !empty($resp->message[$errorType]) ) {
                $msg = $resp->message[$errorType];
            }
        }

        return $msg;
    }

    public static function loginController($login, $passwd) {
        global $APP_VIEWS;
        unset($_SESSION["userID"]);

        $user = UserRepository::loginUser($login);

        if ( $user == null || ($user != null && $user->getPassword() != $passwd) ) {
            $resp = ClockerControllers::statisticController();
            $resp->statusCode = 404;
            $resp->message["loginErrorMessage"] = "Podano błędne dane podczas logowania!";
        } else {
            $resp = new ClockerResponse();

            $resp->redirect = $APP_VIEWS."TaskView.php";
            $resp->statusCode = 200;
            $_SESSION["userID"] = $user->getId();
            $resp->redirect = $APP_VIEWS."TaskView.php";
        }

        return $resp;
    }

    public static function statisticController() {
        global $APP_VIEWS;

        $resp = new ClockerResponse();
        $resp->redirect = $APP_VIEWS."HomeView.php";
        $resp->statusCode = 200;
        $resp->message = [];

        $resp->value["countUsers"] = UserRepository::countUser();;
        $resp->value["countTasks"] = TaskRepository::countTask();
        $resp->value["countProjects"] = ProjectRepository::countProject();
        $resp->value["countClients"] = ClientRepository::countClient();

        return $resp;
    }
}