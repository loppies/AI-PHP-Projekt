<?php
$APP_MAIN = __DIR__;
$APP_CONTROLLERS = $APP_MAIN."/src/Controllers/";
$APP_ENTITIES = $APP_MAIN."/src/Entities/";
$APP_SERVICES = $APP_MAIN."/src/Services/";
$APP_VIEWS = $APP_MAIN."/src/Views/";

require ($APP_CONTROLLERS . "FrontController.php");

use Clocker\Controllers\FrontController;

//TODO: dodać autoloader
//Autoloader()
session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], -1);
if (!empty($uri['query'])) {
    parse_str($uri['query'], $params);
} else {
    $params = [];
}

FrontController::routeToSite($params);
