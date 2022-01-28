<?php

namespace Clocker\Services;

require_once __DIR__ . './PdoConnection.php';
require_once __DIR__ . '/../Entities/User.php';

use Clocker\Entities\Task;
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
     * @param $userId
     * @return array|null
     */
    public static function getAllUsers($userId) {
        $user = self::getUser($userId);
        $is_admin = $user->getIsAdmin();
        if (!$is_admin){
            return null;
        }
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT * FROM users";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute();
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

        PdoConnection::closePdoConnection($pdo);

        if (!$rows) {
            return null;
        }

        $users = [];
        foreach ($rows as $row) {
            $user = new User();
            $user
                ->setId($row['id'])
                ->setLogin($row['login'])
                ->setPassword($row['password'])
                ->setEmail($row['email'])
                ->setIsAdmin($row['is_admin']);
            $users[] = $user;
        }

        return $users;
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

        PdoConnection::closePdoConnection($pdo);

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

    /**
     * @param $userId
     * @return User|null
     */
    public static function getUser($userId) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT * FROM users WHERE id = :user_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( array('user_id' => $userId) );
        $row = $stm->fetch(PDO::FETCH_ASSOC);

        PdoConnection::closePdoConnection($pdo);

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

    /**
     * @return mixed|null
     */
    public static function countUser() {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT count(*) as counter FROM users";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute();
        $count = $stm->fetch(PDO::FETCH_ASSOC);

        PdoConnection::closePdoConnection($pdo);

        if (!$count) {
            return null;
        }

        return $count["counter"];
    }

    /**
     * @param $userId
     * @param $userNewRole
     * @return User|null
     */
    public static function changeUserRole($userId, $userToChangeId, $userNewRole) {
        $user = self::getUser($userId);
        $is_admin = $user->getIsAdmin();
        if (!$is_admin){
            return null;
        }

        $pdo = PdoConnection::getPdoConnection();
        $sql = "UPDATE users SET is_admin = :user_new_role WHERE id = :user_id;";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( [
            ':user_id' => $userToChangeId,
            ':user_new_role' => $userNewRole
        ] );

        PdoConnection::closePdoConnection($pdo);

        $user = self::getUser($userToChangeId);

        return $user;
    }

    /**
     * @param $userId
     * @return void
     */
    public static function deleteUser($userId) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "DELETE FROM users WHERE id = :user_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( array('user_id' => $userId) );

        PdoConnection::closePdoConnection($pdo);
    }
}