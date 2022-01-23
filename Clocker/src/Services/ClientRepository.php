<?php

namespace Clocker\Services;

require_once __DIR__ . './PdoConnection.php';
require_once __DIR__ . '/../Entities/Client.php';

use PDO;
use Clocker\Entities\Client;

class ClientRepository {
    /**
     * @param $userId
     * @return array|null
     */
    public static function getAllClients($userId) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT * FROM clients WHERE user_id = :user_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( array('user_id' => $userId) );
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return null;
        }

        $clients = [];
        foreach ($rows as $row) {
            $client = new Client();
            $client
                ->setId($row['id'])
                ->setUserId($row['user_id'])
                ->setName($row['name']);

            $clients[] = $client;
        }

        PdoConnection::closePdoConnection($pdo);

        return $clients;
    }

    /**
     * @param $clientId
     * @return Client|null
     */
    public static function getClient($clientId) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT * FROM clients WHERE id = :client_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( array('client_id' => $clientId) );
        $row = $stm->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $client = new Client();
        $client
            ->setId($row['id'])
            ->setUserId($row['user_id'])
            ->setName($row['name']);

        PdoConnection::closePdoConnection($pdo);

        return $client;
    }

    /**
     * @param $userId
     * @param $clientName
     * @return Client|void|null
     */
    public static function addClient($userId, $clientName) {
        try {
            $pdo = PdoConnection::getPdoConnection();

            print_r($userId, $clientName);

            $sql = "INSERT INTO clients (user_id, name) VALUES (:user_id, :name)";
            $stm = $pdo->prepare($sql);
            $result = $stm->execute([
                ':user_id' => $userId,
                ':name' => $clientName
            ]);

            $client = self::getClient($pdo->lastInsertId());

            PdoConnection::closePdoConnection($pdo);

            return $client;
        } catch (PDOException $exception) {
            echo $exception->getCode();
        }
    }

    /**
     * @param $clientId
     * @param $clientName
     * @return Client|null
     */
    public static function updateClientName($clientId, $clientName) {
        $pdo = PdoConnection::getPdoConnection();

        $client = self::getClient($clientId);
        print_r($client);

        $sql = "UPDATE clients SET name = :client_name WHERE id = :client_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( [
            ':client_name' => $clientName,
            ':client_id' => $clientId
        ] );

        $client = self::getClient($clientId);

        PdoConnection::closePdoConnection($pdo);

        return $client;
    }
}