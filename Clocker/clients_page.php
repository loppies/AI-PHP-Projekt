<?php
require (__DIR__ . "/src/Services/ProjectRepository.php");
require (__DIR__ . "/src/Services/UserRepository.php");
require (__DIR__ . "/src/Services/ClientRepository.php");
require (__DIR__ . "/src/Services/TaskRepository.php");
//require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\ProjectRepository;
use Clocker\Services\UserRepository;
use Clocker\Services\ClientRepository;
use Clocker\Services\TaskRepository;

session_start();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_login'];
$clients = ClientRepository::getAllClients($user_id);
$projects = ProjectRepository::getAllProjects($user_id);
$client_name = array();
$client_id = array();
$project_client_id = array();
$project_name = array();
if ($clients != NULL){
    foreach ($clients as $client){
        $client_name[] = $client->getName();
        $client_id[] = $client->getId();
  }
}
if ($projects != NULL){
    foreach ($projects as $project){
        $project_client_id[] = $project->getClientId();
        $project_name[] = $project->getName();
    }
}

$client_name_json = json_encode($client_name);
$client_id_json = json_encode($client_id);
$project_client_id_json = json_encode($project_client_id);
$project_name_json = json_encode($project_name);

$html = <<<EOT

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Clocker</title>
        <link rel="stylesheet" href="css/clients-css.css">
    </head>
    <body>
        <div class="container">
            <div class="logo">CLOCKER</div>
            <div class="name"><img  class = 'profil' src="img/profile.png">$user_name</div>
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
            </ul></div>
            <div class="tabela">
                <input id="searchbar" type="text" name="search" placeholder="Szukaj..">
                <div class="divTable">
                    <div class="divTableBody" id="divTableBody">
                        <div class="divTableRow header">
                            <div class="divTableCell lp">&nbsp;Lp</div>
                            <div class="divTableCell nazwa">&nbsp;Nazwa klienta</div>
                            <div class="divTableCell start">&nbsp;Projekty</div>
                            <div class="divTableCell delete">&nbsp;Usuń</div>
                            <div class="divTableCell edit">&nbsp;Edytuj</div>
                            <div class="divTableCell ids" style="display:none;">&nbsp;Id</div>
                        </div>
                    </div>
                </div>
                <form method="POST" id="add_new_client" action="/src/Controllers/ClientController.php">
                    <p class="newClient">Dodaj nowego klienta:</p>
                    <p class="nameClient">Nazwa:<input id="clientAdd" type="text" name="add"></p>
                    <button class="addC">Dodaj</button>
                </form>
            </br>
            </div>
          </div>
    </body>
    <script>
        var data = [];
        var names = JSON.parse('$client_name_json');
        var clients_id = JSON.parse('$client_id_json');
        var project_id = JSON.parse('$project_client_id_json');
        var project_name = JSON.parse('$project_name_json');
        var amount = [...Array(names.length+1).keys()];
        amount.splice(0,1);

        data.push(amount);
        data.push(names);
        console.log(clients_id);
        console.log(project_id);
        var projects = [];
        for (let i = 0; i < clients_id.length; i++){
            var project = ""
            for (let j = 0; j < project_id.length; j++){
                if (clients_id[i] == project_id[j]){
                    project = project + project_name[j] + "\\n";
                }
            }
            projects.push(project);
        }
        data.push(projects);

        let table = document.getElementById("divTableBody");
        for (let i = 0; i < data[0].length; i++){
            let new_row = document.createElement("div");
            new_row.setAttribute("class", "divTableRow inner");
            new_row.setAttribute("id", String("r"+i));

            for (let j = 0; j < 3; j++){
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
</html>
EOT;
echo $html;