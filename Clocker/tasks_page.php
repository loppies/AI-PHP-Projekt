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
        <link rel="stylesheet" href="/css/tasks-css.css">
        <script src="/js/clocker.js"></script>
    </head>
    <body>
    
    <script>
    window.onload = makeDivs;
    function makeDivs()
    {
      var names = JSON.parse('$name_json');
      var projects_id = JSON.parse('$project_id_json');
      var starts = JSON.parse('$start_json');
      var stops = JSON.parse('$stop_json');
      
      var divLp = document.getElementById('lp');
      var divProjectId = document.getElementById('id_projektu');
      var divNazwa = document.getElementById('nazwa');
      var divStart = document.getElementById('start');
      var divStop = document.getElementById('stop');
      var divUsun = document.getElementById('usun');
      var divEdytuj = document.getElementById('edytuj');

      for (var i = 0; i < $counter; i++){
        var newDivLp = document.createElement('div');
        newDivLp.className = "lp";
        newDivLp.innerHTML = i;
        newDivLp.id = "divLp" + i;
        divLp.appendChild(newDivLp);

        var newDivNazwa = document.createElement('div');
        newDivNazwa.className = "nazwa";
        newDivNazwa.id = "divNazwa" + i;
        newDivNazwa.innerHTML = names[i];
        divNazwa.appendChild(newDivNazwa);
        
        var newDivProjectId = document.createElement('div');
        newDivProjectId.className = "id_projektu";
        newDivProjectId.id = "divProjectId" + i;
        newDivProjectId.innerHTML = projects_id[i];
        divProjectId.appendChild(newDivProjectId);

        var newDivStart = document.createElement('div');
        newDivStart.className = "start";
        newDivStart.id = "divStart" + i;
        newDivStart.innerHTML = starts[i];
        divStart.appendChild(newDivStart);

        var newDivStop = document.createElement('div');
        newDivStop.className = "stop";
        newDivStop.id = "divStop" + i;
        if (stops[i] != null){
          newDivStop.innerHTML = stops[i];
        }
        else {
          newDivStop.innerHTML = "----";
        }
        divStop.appendChild(newDivStop);

        var newDivUsun = document.createElement('div');
        var newButtonUsun = document.createElement('button');
        newDivUsun.id = "divUsun" + i;
        newButtonUsun.scr = "/img/delete.png";
        newDivUsun.className = "delete";
        divUsun.appendChild(newDivUsun);
        newDivUsun.appendChild(newButtonUsun);
        
        var newDivEdytuj = document.createElement('div');
        newDivEdytuj.className = "edit";
        newDivEdytuj.id = "divEdytuj" + i;
        var newButtonEdytuj = document.createElement('button');
        newButtonEdytuj.scr = "/img/edit.png";
        divEdytuj.appendChild(newDivEdytuj);
        newDivEdytuj.appendChild(newButtonEdytuj);
      }
    }
    </script>
<div class="container">
  <div class="logo">CLOCKER</div>
  <div class="name"><img class='profil' src="/img/profile.png">Nazwa</div>
  <div class="logB1"><button class="logButt" onclick="wyloguj()">Wyloguj się</button></div>
  <div class="lista">
    <ul>
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
      <li><button class="listButt clients">Klienci</button></li>
      <li><button class="listButt raports">Raporty</button></li>
    </ul>
  </div>
  <div class="tabela">
    <input id="searchbar" type="text" name="search" placeholder="Szukaj.." onkeyup="search()">
    <div class="buttony">
    <button class="startButt" onclick="start()"></button>
    <form method="POST" action="/src/Controllers/TaskController.php" onsubmit="return endTask()">
    <input type="hidden" id="seconds_full" name="seconds_full"></input>
    <button name="stopButt" class="stopButt" onclick="reset()"></button>
    
    </form>
    </div>
   
    
    <div>
    <form method="POST">
      <span id="hour" name="hour">00</span>:
      <span id="minute" name="minute">00</span>:
      <span id="second" name="second">00</span>
      </form>
    </div>
    <div class="divTable">
      <div class="divTableBody">
        <div class="divTableRow" id="firstDiv">
          <div class="divTableCell lp" id="lp">&nbsp;Lp</div>
          <div class="divTableCell nazwa" id="nazwa">&nbsp;Nazwa</div>
          <div class="divTableCell id_projektu" id="id_projektu">&nbsp;Id projektu</div>
          <div class="divTableCell start" id="start">&nbsp;Czas rozpoczęcia</div>
          <div class="divTableCell stop" id="stop">&nbsp;Czas zakończenia</div>
          <div class="divTableCell delete" id="usun">&nbsp;Usuń</div>
          <div class="divTableCell edit" id="edytuj">&nbsp;Edytuj</div>
        </div>
        
      </div>
    </div>
    
    <form method="POST" action="/src/Controllers/TaskController.php" onsubmit="return addTask()">
      <p class="newTask">Dodaj nowe zadanie</p>
      <p class="nameTask">Nazwa:<input id="taskName" type="text" name="taskName"></p>
      <p class="chooseProject">Wybierz projekt   </p>
      <button class="addT" type="submit" id="addTask">Dodaj</button>
    </form>  

EOT;
$html2 = <<<EOT
      
  </div>
</div>
</body>

</html>
EOT;
echo $html;
echo '<select name="projectID" id="projectID">';
foreach ($projects as $row)
{
    echo '<option value="' . htmlspecialchars($row->getId()) . '">'
      . htmlspecialchars($row->getName())
      . '</option>';
}
echo $html2;
