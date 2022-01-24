<?php

namespace Clocker\Services;

require_once __DIR__ . './PdoConnection.php';
require_once __DIR__ . '/../Entities/Task.php';

use Clocker\Entities\User;
use PDO;
use Clocker\Entities\Task;

class TaskRepository {
    /**
     * @param $userId
     * @return array|null
     */
    public static function getAllTasks($userId) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT * FROM tasks WHERE user_id = :user_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( array('user_id' => $userId) );
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

        PdoConnection::closePdoConnection($pdo);

        if (!$rows) {
            return null;
        }

        $tasks = [];
        foreach ($rows as $row) {
            $task = new Task();
            $task
                ->setId($row['id'])
                ->setUserId($row['user_id'])
                ->setProjectId($row['project_id'])
                ->setName($row['name'])
                ->setStart($row['start'])
                ->setStop($row['stop']);

            $tasks[] = $task;
        }

        return $tasks;
    }

    /**
     * @param $taskId
     * @return Task|null
     */
    public static function getTask($taskId) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT * FROM tasks WHERE id = :task_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( array('task_id' => $taskId) );
        $row = $stm->fetch(PDO::FETCH_ASSOC);

        PdoConnection::closePdoConnection($pdo);

        if (!$row) {
            return null;
        }

        $task = new Task();
        $task
            ->setId($row['id'])
            ->setUserId($row['user_id'])
            ->setProjectId($row['project_id'])
            ->setName($row['name'])
            ->setStart($row['start'])
            ->setStop($row['stop']);

        return $task;
    }

    /**
     * @param $userId
     * @param $taskName
     * @param $projectId
     * @return Task|null
     */
    public static function addTask($userId, $taskName, $projectId = NULL) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "INSERT INTO tasks (user_id, project_id, name, start) VALUES (:user_id, :project_id, :name, NOW())";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute([
            ':user_id' => $userId,
            ':project_id' => $projectId,
            ':name' => $taskName
        ]);

        $task = self::getTask($pdo->lastInsertId());

        PdoConnection::closePdoConnection($pdo);

        return $task;
    }

    /**
     * @param $taskId
     * @param $projectId
     * @return Task|null
     */
    public static function updateTaskProject($taskId, $projectId) {
        $pdo = PdoConnection::getPdoConnection();

        $task = self::getTask($taskId);
        print_r($task);

        $sql = "UPDATE tasks SET project_id = :project_id WHERE id = :task_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( [
            ':project_id' => $projectId,
            ':task_id' => $taskId
        ] );

        $task = self::getTask($taskId);

        PdoConnection::closePdoConnection($pdo);

        return $task;
    }

    /**
     * @param $taskId
     * @param $taskName
     * @return Task|null
     */
    public static function updateTaskName($taskId, $taskName) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "UPDATE tasks SET name = :task_name WHERE id = :task_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( [
            ':task_name' => $taskName,
            ':task_id' => $taskId
        ] );

        $task = self::getTask($taskId);

        PdoConnection::closePdoConnection($pdo);

        return $task;
    }

    /**
     * @param $taskId
     * @return Task|null
     */
    public static function updateTaskStopTime($taskId) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "UPDATE tasks SET stop = NOW() WHERE id = :task_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( [
            ':task_id' => $taskId
        ] );

        $task = self::getTask($taskId);

        PdoConnection::closePdoConnection($pdo);

        return $task;
    }

    /**
     * @return array|null
     */
    public static function getAllTasksForAllUsers() {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT * FROM tasks";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute();
        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

        PdoConnection::closePdoConnection($pdo);

        if (!$rows) {
            return null;
        }

        $tasks = [];
        foreach ($rows as $row) {
            $task = new Task();
            $task
                ->setId($row['id'])
                ->setUserId($row['user_id'])
                ->setProjectId($row['project_id'])
                ->setName($row['name'])
                ->setStart($row['start'])
                ->setStop($row['stop']);

            $tasks[] = $task;
        }

        return $tasks;
    }

    /**
     * @return mixed|null
     */
    public static function countTask() {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "SELECT count(*) as counter FROM tasks";
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
     * @param $taskId
     * @return void
     */
    public static function deleteTask($taskId) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "DELETE FROM tasks WHERE id = :task_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( array('task_id' => $taskId) );

        PdoConnection::closePdoConnection($pdo);
    }
}