<?php

namespace Clocker\Controllers;

require (__DIR__ . "/../Services/TaskRepository.php");
require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\TaskRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  $userID = $_SESSION['user_id'];
  $task = $_POST["taskName"];
  $project = $_POST["projectID"];
  $full_seconds = intval($_POST["seconds_full"]);
  
  $alltasks = TaskRepository::getAllTasks($userID);
  if (isset($_POST['stopButt'])){
      $timeStart = end($alltasks)->getStart();
      $timestamp1 = strtotime($timeStart);
      $time = $timestamp1 + $full_seconds;
      $time2 = date('Y-m-d H:i:s', $time);
      TaskRepository::updateTaskStopTime(end($alltasks)->getId(),$time2);
  }
  else {
    if (end($alltasks)->getStop() != null){
      $task = TaskRepository::addTask($userID,$task, 1);
  }
}

header("Location: /tasks_page.php");

}
