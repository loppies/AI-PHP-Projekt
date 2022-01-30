<?php
namespace Clocker\Controllers;
require (__DIR__ . "/../Services/UserRepository.php");
use Clocker\Services\UserRepository;

session_start();
$user_id = $_SESSION['user_id'];
$user = UserRepository::getUser($user_id);
$is_admin = $user->getIsAdmin();
if ($is_admin){
    header("Location: /admin_page.php");
}
else{
    header("Location: /home_page.php");
}
