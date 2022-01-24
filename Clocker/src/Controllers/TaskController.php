<?php

namespace Clocker\Controllers;

require (__DIR__ . "/../Services/TaskRepository.php");
require (__DIR__ . "/../Services/ProjectRepository.php");
require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\TaskRepository;
use Clocker\Services\ProjectRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  $userID = $_SESSION['user_id'];
  $task = $_POST["taskName"];
  $project = $_POST["projectID"];
  
  
  $alltasks = TaskRepository::getAllTasks($userID);
  
  if (isset($_POST['stopButt'])){
      $full_seconds = intval($_POST["seconds_full"]);
      $timeStart = end($alltasks)->getStart();
      $timeStop = end($alltasks)->getStop();
      $timestamp1 = strtotime($timeStart);
      $time = $timestamp1 + $full_seconds;
      $time2 = date('Y-m-d H:i:s', $time);
      if ($timeStop == null){
      TaskRepository::updateTaskStopTime(end($alltasks)->getId());
      }
  }
  elseif (isset($_POST['edit_submit'])){
    $taskId = intval($_POST["edit_id"]);
    $taskName = $_POST["edit_name"];
    $editTask = TaskRepository::updateTaskName($taskId,$taskName);
  }
  elseif (isset($_POST['delete_submit'])){
  $taskId = intval($_POST["delete_id"]);
  TaskRepository::deleteTask($taskId);
  }
  
  else {
    if (strlen($task) != 0){
    if ($alltasks != null && end($alltasks)->getStop() != null ){
      if ($project == "empty"){
      TaskRepository::addTask($userID,$task, null);
      }
      else {
        TaskRepository::addTask($userID,$task, $project);
      }
  }
    elseif ($alltasks == null) {
      if ($project == "empty"){
      TaskRepository::addTask($userID,$task, null);
      }
      else {
        TaskRepository::addTask($userID,$task, $project);
      }
    }
    }
}

header("Location: /tasks_page.php");

}
