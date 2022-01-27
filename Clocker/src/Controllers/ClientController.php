<?php

namespace Clocker\Controllers;

require (__DIR__ . "/../Services/ClientRepository.php");
require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\ClientRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  $userID = $_SESSION['user_id'];
  $client_name = $_POST["add"];
  $client_id = $_POST["clients_id"];
  $client_new_name = $_POST["client_new_name"];
  
  if (isset($_POST['delete_submit'])){
  $clientId = intval($_POST["delete_id"]);
  ClientRepository::deleteClient($clientId);
  }

  if ($client_name != ""){
    $do_function = ClientRepository::addClient($userID, $client_name);
  }

  if ($client_id != "" && $client_new_name != ""){
      $client_id = intval($client_id);
      $do_function = ClientRepository::updateClientName($client_id, $client_new_name);
  }
  
  header("Location: /clients_page.php");
}
