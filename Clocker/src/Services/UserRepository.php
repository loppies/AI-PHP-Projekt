<?php

namespace Clocker\Services;

require_once __DIR__ . './PdoConnection.php';
require_once __DIR__ . '/../Entities/User.php';

use PDO;
use Clocker\Entities\User;

class UserRepository {
    /**
     * @param $userLogin
     * @param $password
     * @param $email
     * @return User|null
     */
    public static function registerUser($userLogin, $password, $email) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "INSERT INTO users (login, password, email, is_admin) VALUES (:login, :password, :email, :is_admin)";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( [
            ':login' => $userLogin,
            ':password' => $password,
            ':email' => $email,
            ':is_admin' => 0
        ] );

        $user = self::loginUser($userLogin);

        PdoConnection::closePdoConnection($pdo);

        return $user;
    }

    /**
     * @param $userLogin
     * @return User|null
     */
    public static function loginUser($userLogin) {
        $pdo = PdoConnection::getPdoConnection();

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

        PdoConnection::closePdoConnection($pdo);

        return $user;
    }
}