<?php

namespace Clocker\Services;
use PDO;
require_once __DIR__ . '/../../cfg/config_db.php';

class PdoConnection {
    /**
     * @return PDO
     */
    public static function getPdoConnection() {
        global $config;
        $pdo = new PDO($config['dsn'], $config['username'], $config['password']);
        // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    /**
     * @param $pdo
     * @return void
     */
    public static function closePdoConnection($pdo) {
        $pdo = NULL;
    }
}