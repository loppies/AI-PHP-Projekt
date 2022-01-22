<?php

namespace Clocker\Services;

require_once __DIR__ . './PdoConnection.php';
require_once __DIR__ . '/../Entities/Task.php';

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

        PdoConnection::closePdoConnection($pdo);

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

        PdoConnection::closePdoConnection($pdo);

        return $task;
    }
  
  public static function countTask() {
  $pdo = PdoConnection::getPdoConnection();

  $sql = "SELECT count(*) as counter FROM tasks";
  $stm = $pdo->prepare($sql);
  $result = $stm->execute();
  $count = $stm->fetch(PDO::FETCH_ASSOC);

  if (!$count) {
  return null;
  }
  PdoConnection::closePdoConnection($pdo);
  return $count["counter"];
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
  
 public static function deleteTask($taskId) {
 $pdo = PdoConnection::getPdoConnection();

 $sql = "DELETE from tasks where id = :task_id";
 $stm = $pdo->prepare($sql);
 $result = $stm->execute( [
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
    public static function updateTaskStopTime($taskId, $time) {
        $pdo = PdoConnection::getPdoConnection();

        $sql = "UPDATE tasks SET stop = :time WHERE id = :task_id";
        $stm = $pdo->prepare($sql);
        $result = $stm->execute( [
            ':task_id' => $taskId,
            ':time' => $time  
        ] );

        $task = self::getTask($taskId);

        PdoConnection::closePdoConnection($pdo);

        return $task;
    }
}

// $test_task = TaskRepository::getAllTasks(10);
// $test_task = TaskRepository::getTask(2);
// $test_task = TaskRepository::updateTaskStopTime(1);
// $test_task = TaskRepository::updateTaskName(1, "Zmieniona nazwa");
// $test_task = TaskRepository::updateTaskProject(1, 11);
// $test_task = TaskRepository::addTask(10, "Task 4", 11);
// print_r($test_task);
