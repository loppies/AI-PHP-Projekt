<?php

namespace Clocker\Controllers;

require (__DIR__ . "/../Services/UserRepository.php");
require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\UserRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  $userID = $_SESSION['user_id'];
  $users_id = $_POST["users_id"];
  $users_role = $_POST["user_role"];
  $users_new_login = $_POST["users_new_login"];
  $users_new_email = $_POST["users_new_email"];
  $delete_permission = $_POST["delete_permission"];


  if ($users_id != "" && $users_role != ""){
    $userID = intval($userID);
    $users_id = intval($users_id);
    $users_role = intval($users_role);
    $searched_user = UserRepository::changeUserRole($userID, $users_id, $users_role); 
  }

  if ($users_id != "" && $users_new_login != ""){
    $users_id = intval($users_id);
    $do_function = UserRepository::changeUserLogin($users_id, $users_new_login);
  }

  if ($users_id != "" && $users_new_email != ""){
    $users_id = intval($users_id);
    $do_function = UserRepository::changeUserEmail($users_id, $users_new_email);
  }

  if ($users_id != "" && $delete_permission == "true"){
    $users_id = intval($users_id);
    $do_function = UserRepository::deleteUser($users_id);
  }
//   file_put_contents( 'debug' . time() . '.log', var_export( $_POST, true));
  header("Location: /admin_page.php");
}
