<?php
require (__DIR__ . "/src/Services/TaskRepository.php");
require (__DIR__ . "/src/Services/UserRepository.php");
require (__DIR__ . "/src/Services/ProjectRepository.php");
require (__DIR__ . "/src/Services/ClientRepository.php");
//require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\TaskRepository;
use Clocker\Services\UserRepository;
use Clocker\Services\ProjectRepository;
use Clocker\Services\ClientRepository;
$task_count = TaskRepository::countTask();
$user_count = UserRepository::countUser();
$project_count = ProjectRepository::countProject();
$client_count = ClientRepository::countClient();
$html = <<<EOT

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Clocker</title>
    <script src="/js/clocker.js"></script>
    <link rel="stylesheet" href="/css/clocker.css">
</head>

<body onload="getErrorMessage()">
<script>
    window.onload = updateStats;
   
    function updateStats()
    {
    let tasks = document.getElementById("tasks_stat");
    tasks.innerHTML = "Ilosc zadan: " + "$task_count";
    let projects = document.getElementById("projects_stat");
    projects.innerHTML = "Ilosc projektow: " + "$project_count";
    let users = document.getElementById("users_stat");
    users.innerHTML = "Ilosc uzytkownikow: " + "$user_count";
    let clients = document.getElementById("clients_stat");
    clients.innerHTML = "Ilosc klientow: " + "$client_count";
    
    }
    </script>
    <h1>CLOCKER</h1>
    
    <div id="login" class="one">
        <form method="POST" action="/src/Controllers/LoginController.php" onsubmit="return login()">
            <p class="ll">Logowanie</p>
            <div class="errorMessage" id="loginErrorMessage"></div>
            <label class="log">Login: </label><input type="text" id="username" name="username" required>
            <p class='wrongUsername'></p>
            <label class="log">Hasło: </label><input type="password" id="passwd" name="passwd" required>
            <p class='wrongPasswd'></p>
            <div class="wrap">
                <button type="submit" id="logButton">Zaloguj się</button>
            </div>
        </form>
    </div>
    <div id='same-line'>
        <div id="register">
            <form method="POST" action="/src/Controllers/RegisterController.php" onsubmit="return register()">
                <p class="ll">Załóż konto</p>
                <div class="errorMessage" id="registerErrorMessage"></div>
                <label class="reg">Email: </label><input type="text" id="reg_email" name="reg_email" required>
                <p class = 'wrongEmail'></p>
                <label class="reg">Login: </label><input type="text" id="reg_username" name="reg_username" required>
                <p class = 'wrongRegUser'></p>
                <label class="reg">Hasło: </label><input type="password" id="reg_passwd" name="reg_passwd" required>
                <p class = 'wrongPasswd'></p>
                <label class="reg">Powtórz hasło: </label><input type="password" id="reg_passwd_rep" name="reg_passwd_rep" required>
                <p class = 'wrongPasswd'></p>
                <div class="wrap">
                    <button type="submit" id="regButton">Zarejestruj się</button>
                </div>
            </form>
        </div>
        <div id="stats" class="one">
            <p class="ll">Statystyki</p>
            <p class="users_stat" id="users_stat">Ilosc uzytkownikow: </p>
            <p class="tasks_stat" id="tasks_stat">Ilosc zadan: </p>
            <p class="projects_stat" id="projects_stat">Ilosc projektow: </p>
            <p class="clients_stat" id="clients_stat">Ilosc klientow: </p>
            
        </div>
    </div>
</body>
</html>

EOT;
echo $html;
