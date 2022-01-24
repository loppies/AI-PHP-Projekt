<?php
require(__DIR__ . "/src/Services/ProjectRepository.php");
require(__DIR__ . "/src/Services/UserRepository.php");
require(__DIR__ . "/src/Services/ClientRepository.php");
require(__DIR__ . "/src/Services/TaskRepository.php");
//require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\ProjectRepository;
use Clocker\Services\UserRepository;
use Clocker\Services\ClientRepository;
use Clocker\Services\TaskRepository;

session_start();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_login'];
$projects = ProjectRepository::getAllProjects($user_id);
$clients = ClientRepository::getAllClients($user_id);
$tasks = TaskRepository::getAllTasks($user_id);
$client_id = array();
$client_name = array();
$name = array();
$project_id = array();
$user_clients_names = array();
$user_clients_id = array();
$starts = array();
$stops = array();
$task_id = array();
$user = UserRepository::getUser($user_id);
$is_admin = $user->getIsAdmin();
if ($projects != NULL) {
    foreach ($projects as $row) {
        $name[] = $row->getName();
        $client_id[] = $row->getClientId();
        if ($row->getClientId() != NULL) {
            $client_name[] = ClientRepository::getClient($row->getClientId())->getName();
        } else {
            $client_name[] = "";
        }
        $project_id[] = $row->getId();
    }
}
if ($clients != null) {
    foreach ($clients as $client) {
        $user_clients_names[] = $client->getName();
        $user_clients_id[] = $client->getId();
    }
}
if ($tasks != null) {
    foreach ($tasks as $task) {
        try {
            if ($task->getStop() != null) {
                $starts[] = $task->getStart();
                $stops[] = $task->getStop();
                $task_id[] = $task->getProjectId();
            }
        } catch (Exception $e) {
            continue;
        }
    }
}

$name_json = json_encode($name);
$client_name_json = json_encode($client_name);
$project_id_json = json_encode($project_id);

$user_clients_names_json = json_encode($user_clients_names);
$user_clients_id_json = json_encode($user_clients_id);

$starts_json = json_encode($starts);
$stops_json = json_encode($stops);
$task_id_json = json_encode($task_id);

$html = <<<EOT


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Clocker</title>
        <link rel="stylesheet" href="css/project-css.css">
    </head>
    <body>
        <div class="container">
            <div class="logo">CLOCKER</div>
            <div class="name"><img class = 'profil'src="img/profile.png">$user_name</div>
            <div class="logB1"><button class="logButt">Wyloguj się</button></div>
            <div class="lista"><ul>
            <li>
                <form method="POST" action="/src/Controllers/ChangeSitesProjects.php" onsubmit="return to_projects()">
                    <button class="listButt projects">Projekty</button>
                </form>
            </li>
            <li>
                <form method="POST" action="/src/Controllers/ChangeSitesTasks.php" onsubmit="return to_tasks()">
                    <button class="listButt tasks">Zadania</button>
                </form>
            </li>
            <li>
                <form method="POST" action="/src/Controllers/ChangeSitesClients.php" onsubmit="return to_clients()">
                    <button class="listButt clients">Klienci</button>
                </form>
            </li>
            <li><button class="listButt raports">Raporty</button></li>
            <li><button id="adm" class="listButt users" style="display:none;">Użytkownicy</button></li>
            </ul></div>
            <div class="tabela">
                <input id="searchbar" type="text" name="search" placeholder="Szukaj..">
                <div class="divTable">
                    <div class="divTableBody" id="divTableBody">
                        <div class="divTableRow main header">
                            <div class="divTableCell lp">&nbsp;Lp</div>
                            <div class="divTableCell nazwa">&nbsp;Nazwa</div>
                            <div class="divTableCell stats">&nbsp;Statystyki</div>
                            <div class="divTableCell clients1">&nbsp;Klienci</div>
                            <div class="divTableCell delete">&nbsp;Usuń</div>
                            <div class="divTableCell edit">&nbsp;Edytuj</div>
                            <div class="divTableCell ids" style="display:none;">&nbsp;Id</div>
                        </div>
                    </div>
                </div>
                <p class="newProject">Dodaj nowy projekt</p>
                <form method="POST" id="on_submission">
                    <p id="p_to_submit" class="nameProject">Nazwa:<input id="projectAdd" type="text" name="add"></p>
                    <div id="div_to_submit" class="chooseClient">Wybierz klienta <select id="select"><option value="XYZxyz">Wybierz klienta...</option></select> </div>
                    <button class="addP" id="addP" name="addP">Dodaj</button>
                </form>
            </div>
          </div>
    </body>
    <script>
        if ('$is_admin' == 1){
            let adm = document.getElementById("adm");
            adm.removeAttribute("style");
        }
        var data = [];
        var names = JSON.parse('$name_json');
        var clients_id = JSON.parse('$client_name_json');
        var project_id = JSON.parse('$project_id_json');
        var starts = JSON.parse('$starts_json');
        var stops = JSON.parse('$stops_json');
        var task_id = JSON.parse('$task_id_json');
        var stats = [];
        for (let i = 0; i < project_id.length; i++){
            var diffTime = 0;
            for (let j = 0; j < task_id.length; j++){
                if (project_id[i] == task_id[j]){
                    var begin = new Date(starts[j]);
                    var end = new Date(stops[j]);
                    var diffTime = diffTime + Math.abs(end - begin);
                }
            }
            var diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
            diffTime = diffTime / 1000;
            var hours = (diffTime / 3600) - (24 * diffDays);
            var minutes = (diffTime / 60) - (1440 * diffDays) - (60 * parseInt(hours));
            var seconds = Math.round((minutes - parseInt(minutes))*60);
            var result = diffDays + " dni " + parseInt(hours) + " H " + parseInt(minutes) + " m " + parseInt(seconds) + " s";
            stats.push(result);
        }
        var amount = [...Array(names.length+1).keys()];
        amount.splice(0,1);
        var user_client_names = JSON.parse('$user_clients_names_json');
        var user_client_id = JSON.parse('$user_clients_id_json');

        var select = document.getElementById("select");
        for (let i = 0; i < user_client_names.length; i++){
            var option = document.createElement("option");
            option.text = user_client_names[i];
            select.add(option);
        }

        data.push(amount);
        data.push(names);
        data.push(stats);
        data.push(clients_id);

        let table = document.getElementById("divTableBody");
        for (let i = 0; i < data[0].length; i++){
            let new_row = document.createElement("div");
            new_row.setAttribute("class", "divTableRow inner");
            new_row.setAttribute("id", String("r"+i));

            for (let j = 0; j < 4; j++){
                let elem = document.createElement("div");
                elem.setAttribute("class", "divTableCell")
                if (j == 1){
                    elem.setAttribute("id", String("nazwa"+i))
                }
                elem.innerText = String(data[j][i]);
                new_row.appendChild(elem);
            }
            let trash_elem = document.createElement("div");
            trash_elem.setAttribute("class", "divTableCell");

            let trash_button = document.createElement("button");
            trash_button.setAttribute("class", "deleteButt");
            trash_button.setAttribute("id", String("trash"+i));

            let trash_img = document.createElement("img");
            trash_img.setAttribute("class", "deletIcon");
            trash_img.setAttribute("src", "img/delete.png");

            trash_button.appendChild(trash_img);
            trash_elem.appendChild(trash_button);
            new_row.appendChild(trash_elem);

            let edit_elem = document.createElement("div");
            edit_elem.setAttribute("class", "divTableCell");

            let edit_button = document.createElement("button");
            edit_button.setAttribute("class", "editButt IconDelete");
            edit_button.setAttribute("id", String("edit"+i));

            let edit_img = document.createElement("img");
            edit_img.setAttribute("src", "img/edit.png");

            let edit_form = document.createElement("form");
            edit_form.setAttribute("method", "POST");
            edit_form.setAttribute("class", "forms_to_change");
            edit_form.setAttribute("id", String("forms_to_change"+i));

            edit_button.appendChild(edit_img);
            edit_form.appendChild(edit_button);
            edit_elem.appendChild(edit_form);
            new_row.appendChild(edit_elem);

            let elem = document.createElement("div");
            elem.setAttribute("class", "divTableCell");
            elem.setAttribute("id", String("project"+i));
            elem.setAttribute("style", "display:none;");
            elem.innerText = String(project_id[i]);
            new_row.appendChild(elem);

            table.appendChild(new_row);
        }
    </script>
    <script src="/js/projects.js"></script>
</html>
EOT;
echo $html;
