<?php

use Clocker\Controllers\FrontController;

//TODO: dodać autoloader

// session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], -1);
parse_str($uri['query'], $params);

//TODO: Wywołać front-controller

FrontController::routeToSite('');

// router

// print_r($uri['query']);
//$action = isset($_GET['action']) ? $_GET['action'] : null;
//print_r($action);