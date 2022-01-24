<?php

namespace Clocker\Controllers;

require (__DIR__ . "/../Services/ClientRepository.php");
require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\ClientRepository;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  $userID = $_SESSION['user_id'];
  $client_name = $_POST["add"];
  
  if (isset($_POST['delete_submit'])){
  $clientId = intval($_POST["delete_id"]);
  ClientRepository::deleteClient($clientId);
  }

  if($client_name != ""){
    $do_function = ClientRepository::addClient($userID, $client_name);
  }
  
  header("Location: /clients_page.php");
}
