<?php

namespace Clocker\Controllers;

require (__DIR__ . "/../Services/ProjectRepository.php");
require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\ProjectRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  $userID = $_SESSION['user_id'];
  $project_name = $_POST["add"];
  $client_id = $_POST["client_searched_id"];
  $client_new_id = $_POST["bbb"];
  $project_id = $_POST["projects_id"];

  if($project_id != "" && $client_new_id != ""){
    $project_id = intval($project_id);
    $client_new_id = intval($client_new_id);
    $do_function = ProjectRepository::updateProjectClient($project_id, $client_new_id);
  }
  if ($client_id != "" && $project_name != ""){
    $client_id = intval($client_id);
    $do_function = ProjectRepository::addProject($userID, $project_name, $client_id);
  }
  elseif ($client_id == "" && $project_name != ""){
    $do_function = ProjectRepository::addProject($userID, $project_name);
  }

  $project_id = $_POST["projects_id"];
  $project_new_name = strval($_POST["project_new_name"]);
  if($project_id != "" && $project_new_name != ""){
    $project_id = intval($_POST["projects_id"]);
    $do_function = ProjectRepository::updateProjectName($project_id, $project_new_name);
  }
  header("Location: /projects_page.php");
//   file_put_contents( 'debug' . time() . '.log', var_export( $_POST, true));
}