<?php

namespace Clocker\Services;

require_once __DIR__ . './PdoConnection.php';
require_once __DIR__ . '/../Entities/Project.php';

use PDO;
use Clocker\Entities\Project;

class ProjectRepository {
    /**
     * @param $userId
     * @return array|null
     */
    public static function getAllProjects($userId) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT * FROM projects WHERE user_id = :user_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( array('user_id' => $userId) );
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

        PdoConnection::closePdoConnection($pdo);

        if (!$rows) {
            return null;
        }

        $projects = [];
        foreach ($rows as $row) {
            $project = new Project();
            $project
                ->setId($row['id'])
                ->setClientId($row['client_id'])
                ->setUserId($row['user_id'])
                ->setName($row['name']);

            $projects[] = $project;
        }

        return $projects;
    }

    /**
     * @param $projectId
     * @return Project|null
     */
    public static function getProject($projectId) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT * FROM projects WHERE id = :project_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( array('project_id' => $projectId) );
        $row = $stm->fetch(PDO::FETCH_ASSOC);

        PdoConnection::closePdoConnection($pdo);

        if (!$row) {
            return null;
        }

        $project = new Project();
        $project
            ->setId($row['id'])
            ->setClientId($row['client_id'])
            ->setUserId($row['user_id'])
            ->setName($row['name']);

        return $project;
    }

    /**
     * @param $userId
     * @param $projectName
     * @param $clientId
     * @return Project|null
     */
    public static function addProject($userId, $projectName, $clientId = NULL) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "INSERT INTO projects (user_id, client_id, name) VALUES (:user_id, :client_id, :name)";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute([
            ':user_id' => $userId,
            ':client_id' => $clientId,
            ':name' => $projectName
        ]);

        $project = self::getProject($pdo->lastInsertId());

        PdoConnection::closePdoConnection($pdo);

        return $project;
    }

    /**
     * @param $projectId
     * @param $projectName
     * @return Project|null
     */
    public static function updateProjectName($projectId, $projectName) {
        $pdo = PdoConnection::getPdoConnection();

        $project = self::getProject($projectId);
        print_r($project);

        $sql = "UPDATE projects SET name = :project_name WHERE id = :project_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( [
            ':project_name' => $projectName,
            ':project_id' => $projectId
        ] );

        $project = self::getProject($projectId);

        PdoConnection::closePdoConnection($pdo);

        return $project;
    }

    /**
     * @param $projectId
     * @param $clientId
     * @return Project|null
     */
    public static function updateProjectClient($projectId, $clientId) {
        $pdo = PdoConnection::getPdoConnection();

        $project = self::getProject($projectId);
        print_r($project);

        $sql = "UPDATE projects SET client_id = :client_id WHERE id = :project_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( [
            ':client_id' => $clientId,
            ':project_id' => $projectId
        ] );

        $project = self::getProject($projectId);

        PdoConnection::closePdoConnection($pdo);

        return $project;
    }

    /**
     * @return mixed|null
     */
    public static function countProject() {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT count(*) as counter FROM projects";
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
     * @param $projectId
     * @return void
     */
    public static function deleteProject($projectId) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "DELETE FROM projects WHERE id = :project_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( array('project_id' => $projectId) );

        PdoConnection::closePdoConnection($pdo);
    }
}