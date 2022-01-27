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

        PdoConnection::closePdoConnection($pdo);

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

        PdoConnection::closePdoConnection($pdo);

        if (!$row) {
            return null;
        }

        $client = new Client();
        $client
            ->setId($row['id'])
            ->setUserId($row['user_id'])
            ->setName($row['name']);

        return $client;
    }

    /**
     * @param $userId
     * @param $clientName
     * @return Client|null
     */
    public static function addClient($userId, $clientName) {
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

    /**
     * @return mixed|null
     */
    public static function countClient() {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT count(*) as counter FROM clients";
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
     * @param $clientId
     * @return void
     */
    public static function deleteClient($clientId) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "DELETE FROM clients WHERE id = :client_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( array('client_id' => $clientId) );

        PdoConnection::closePdoConnection($pdo);
    }
}
