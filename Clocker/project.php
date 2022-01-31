<?php
require (__DIR__ . "/src/Services/TaskRepository.php");
//require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\TaskRepository;

session_start();
$user_id = $_SESSION['user_id'];
$projects = TaskRepository::getAllTasks($user_id);
$tasks = TaskRepository::getAllTasks($user_id);
$counter = 0;
$project_id = array();
$name = array();
$start = array();
$stop = array();
if ($tasks != NULL)
{
  foreach ($tasks as $row)
  {
      $counter += 1;
      $name[] = $row->getName();
      $project_id[] = $row->getProjectId();
      $start[] = $row->getStart();
      $stop[] = $row->getStop();
  }
}

$name_json = json_encode($name);
$project_id_json = json_encode($project_id);
$start_json = json_encode($start);
$stop_json = json_encode($stop);
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
            <div class="name"><img class = 'profil'src="img/profile.png">Nazwa</div>
            <div class="logB1"><button class="logButt">Wyloguj się</button></div>
            <div class="lista"><ul>
                <li><button class="listButt projects">Projekty</button></li>
                <li><button class="listButt tasks">Zadania</button></li>
                <li><button class="listButt clients">Klienci</button></li>
                <li><button class="listButt raports">Raporty</button></li>
            </ul></div>
            <div class="tabela">
                <input id="searchbar" type="text" name="search" placeholder="Szukaj..">
                <div class="divTable">
                    <div class="divTableBody" id="divTableBody">
                        <div class="divTableRow">
                            <div class="divTableCell lp">&nbsp;Lp</div>
                            <div class="divTableCell nazwa">&nbsp;Nazwa</div>
                            <div class="divTableCell stats">&nbsp;Statystyki</div>
                            <div class="divTableCell clients1">&nbsp;Klienci</div>
                            <div class="divTableCell delete">&nbsp;Usuń</div>
                            <div class="divTableCell edit">&nbsp;Edytuj</div>
                        </div>
                        <div class="divTableRow">
                            <div class="divTableCell">&nbsp;</div>
                            <div class="divTableCell">&nbsp;</div>
                            <div class="divTableCell">&nbsp;</div>
                            <div class="divTableCell">&nbsp;</div>
                            <div class="divTableCell">&nbsp;<button class="deleteButt"><img class='deletIcon' src="img/delete.png"></button></div>
                            <div class="divTableCell">&nbsp;<button class="editButt IconDelete"><img src="img/edit.png"></button></div>
                        </div>
                    </div>
                </div>
                <p class="newProject">Dodaj nowy projekt</p>
                <p class="nameProject">Nazwa:<input id="projectAdd" type="text" name="add"></p>
                <button class="addP">Dodaj</button>
            </div>
          </div>
    </body>
    <script src="proba.js"></script> 
</html>
EOT;
echo $html;