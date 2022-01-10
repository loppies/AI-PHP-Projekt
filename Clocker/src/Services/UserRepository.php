<?php

namespace Clocker\Services;

use Clocker\Entities\User;
use PDO;

require_once __DIR__ . '/../Entities/User.php';
require_once __DIR__ . '/../../cfg/config_db.php';

class UserRepository {
    /**
     * @param $userLogin
     * @param $password
     * @param $email
     * @return User|null
     */
    public static function registerUser($userLogin, $password, $email) {
        global $config;
        $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

        $sql = "INSERT INTO users (login, password, email, is_admin) VALUES (:login, :password, :email, :is_admin)";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( [
            ':login' => $userLogin,
            ':password' => $password,
            ':email' => $email,
            ':is_admin' => 0
        ] );

        $user = self::loginUser($userLogin);

        return $user;
    }

    /**
     * @param $userLogin
     * @return User|null
     */
    public static function loginUser($userLogin) {
        global $config;
        $pdo = new PDO($config['dsn'], $config['username'], $config['password']);

        $sql = "SELECT * FROM users WHERE login = :userLogin";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( array('userLogin' => $userLogin) );
        $row = $stm->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $user = new User();
        $user
            ->setId($row['id'])
            ->setLogin($row['login'])
            ->setPassword($row['password'])
            ->setEmail($row['email'])
            ->setIsAdmin($row['is_admin']);

        return $user;
    }
}