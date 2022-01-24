<?php

namespace Clocker\Controllers;

class FrontController {
    public static function routeToSite($params = []) {
        $action = $params['action'];

        switch ($action) {
            case 'login':
                $login = $params['username'];
                $passwd = $params['passwd'];
                break;
            default:
                header('HTTP/1.1 404 Not Found');
                echo '<html><body><h1>Page Not Found</h1></body></html>';
        }

        return;
    }
}