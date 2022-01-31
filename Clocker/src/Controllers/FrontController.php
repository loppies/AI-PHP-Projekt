<?php

namespace Clocker\Controllers;
global $APP_CONTROLLERS;

require ($APP_CONTROLLERS . "ClockerResponse.php");
require ($APP_CONTROLLERS . "ClockerControllers.php");

class FrontController {

    public static function routeToSite($params) {
        global $APP_VIEWS;

        if (!empty($params['action'])) {
            $action = $params['action'];
        } else {
            $action = "home";
        }

        if ( !empty($action) ) {

            switch ($action) {
                case 'login':
                    print_r($action);
                    $userLogin = $params["username"];
                    $userPass = $params["passwd"];
                    $resp = ClockerControllers::loginController($userLogin, $userPass);
                    print_r($resp);
                    break;

                case 'tasks':
                    print_r($action);
                    // Tu będzie właściwy kontroler
                    $resp = new ClockerResponse();
                    $resp->redirect = $APP_VIEWS."TasksView.php";
                    break;

                case 'clients':
                    print_r($action);
                    // Tu będzie właściwy kontroler
                    $resp = new ClockerResponse();
                    $resp->redirect = $APP_VIEWS."ClientsView.php";
                    break;

                case 'projects':
                    print_r($action);
                    // Tu będzie właściwy kontroler
                    $resp = new ClockerResponse();
                    $resp->redirect = $APP_VIEWS."ProjectsView.php";
                    break;

                case 'reports':
                    print_r($action);
                    // Tu będzie właściwy kontroler
                    $resp = new ClockerResponse();
                    $resp->redirect = $APP_VIEWS."ReportsView.php";
                    break;

                case 'home':
                case 'logout':
                    print_r($action);
                    $resp = ClockerControllers::statisticController();
                    break;

                default:
                    // Tu będzie właściwy kontroler
                    print_r("defasult");
                    $resp = new ClockerResponse();
                    $resp->redirect = $APP_VIEWS."404View.php";
                    break;
            }
        }

        require_once ($resp->redirect);
        return;
    }
}