<?php
require (__DIR__ . "/src/Services/TaskRepository.php");
require (__DIR__ . "/src/Services/ProjectRepository.php");
//require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\TaskRepository;
use Clocker\Services\ProjectRepository;

session_start();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_login'];
$projects = ProjectRepository::getAllProjects($user_id);
$tasks = TaskRepository::getAllTasks($user_id);

$counter = 0;
$project_id = array();
$name = array();
$start = array();
$stop = array();
$task_id = array();
if ($tasks != NULL){
foreach ($tasks as $row)
{
    $counter += 1;
    $name[] = $row->getName();
    $project_id[] = $row->getProjectId();
    $start[] = $row->getStart();
    $stop[] = $row->getStop();
    $task_id[] = $row->getId();
}
}

$name_json = json_encode($name);
$project_id_json = json_encode($project_id);
$start_json = json_encode($start);
$stop_json = json_encode($stop);
$task_id_json = json_encode($task_id);
$html = <<<EOT

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Clocker</title>
        <link rel="stylesheet" href="/css/admin-task.css">
        <script src="/js/clocker.js"></script>
    </head>
    <body>
    <script>
      window.onload = makeDivs;

      function makeDivs() {
        var user_name = document.getElementById('user_name');
        user_name.innerHTML = "$user_name";
        var names = JSON.parse('$name_json');
        var projects_id = JSON.parse('$project_id_json');
        var starts = JSON.parse('$start_json');
        var stops = JSON.parse('$stop_json');
        var tasks_id = JSON.parse('$task_id_json');
        var table = document.getElementById('divTableBody');

        for (var i = 0; i < $counter; i++) {
          var newTableRow = document.createElement('div');
          newTableRow.id = "divTableRow" + i;
          newTableRow.className = "divTableRow";
          var newDivLp = document.createElement('div');
          newDivLp.className = "divTableCell";
          newDivLp.innerHTML = i;
          newDivLp.id = "divLp" + i;
          newTableRow.appendChild(newDivLp);
          table.append(newTableRow);

          var newDivNazwa = document.createElement('div');
          newDivNazwa.className = "divTableCell";
          newDivNazwa.id = "divNazwa" + i;
          newDivNazwa.innerHTML = names[i];
          newTableRow.appendChild(newDivNazwa);
          table.append(newTableRow);

          var newDivProjectId = document.createElement('div');
          newDivProjectId.className = "divTableCell";
          newDivProjectId.id = "divProjectId" + i;
          newDivProjectId.innerHTML = projects_id[i];
          newTableRow.appendChild(newDivProjectId);
          table.append(newTableRow);

          var newDivStart = document.createElement('div');
          newDivStart.className = "divTableCell";
          newDivStart.id = "divStart" + i;
          newDivStart.innerHTML = starts[i];
          newTableRow.appendChild(newDivStart);
          table.append(newTableRow);

          var newDivStop = document.createElement('div');
          newDivStop.className = "divTableCell";
          newDivStop.id = "divStop" + i;
          if (stops[i] != null) {
            newDivStop.innerHTML = stops[i];
          } else {
            newDivStop.innerHTML = "----";
          }
          newTableRow.appendChild(newDivStop);
          table.append(newTableRow);


          var newDivTime = document.createElement('div');
          newDivTime.className = "divTableCell";
          newDivTime.id = "divTime" + i;
          let start = document.getElementById('divStart' + i);
          let stop = document.getElementById('divStop' + i);
          startDate = new Date(start.innerHTML);
          stopDate = new Date(stop.innerHTML);
          if (stop.innerHTML != "----") {
            var diffTime = Math.abs(stopDate - startDate);
            var diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
            diffTime = diffTime / 1000;
            var hours = diffTime / 3600;
            var minutes = diffTime / 60;
            var seconds = diffTime;
            newDivTime.innerHTML = diffDays + " dni " + parseInt(hours) + " H " + parseInt(minutes) + " m " + parseInt(seconds) + " s";
          } else {
            newDivTime.innerHTML = "----";
          }
          newTableRow.appendChild(newDivTime);
          table.append(newTableRow);


          var newDivUsun = document.createElement('div');
          var newButtonUsun = document.createElement('button');
          var newImgUsun = document.createElement('img');
          newImgUsun.className = "deletIcon";
          newImgUsun.src = "/img/delete.png";
          newDivUsun.id = "divUsun" + i;
          newDivUsun.className = "divTableCell";
          newButtonUsun.addEventListener("click", deleteTaskFunction);
          newButtonUsun.id = "deleteBtn" + i;
          newButtonUsun.className = "deleteButt";
          newButtonUsun.appendChild(newImgUsun);
          newDivUsun.appendChild(newButtonUsun);
          newTableRow.appendChild(newDivUsun);
          table.append(newTableRow);

          var newDivEdytuj = document.createElement('div');
          newDivEdytuj.className = "divTableCell";
          var newImgEdit = document.createElement('img');
          newImgEdit.src = "/img/edit.png";
          newDivEdytuj.id = "divEdytuj" + i;
          var newButtonEdytuj = document.createElement('button');
          newButtonEdytuj.className = "editClass editButt";
          newButtonEdytuj.addEventListener("click", editTaskFunction);
          newButtonEdytuj.id = "editBtn" + i;
          newButtonEdytuj.appendChild(newImgEdit);
          newDivEdytuj.appendChild(newButtonEdytuj);
          newTableRow.appendChild(newDivEdytuj);
          table.append(newTableRow);

          var newDivTaskId = document.createElement('div');
          newDivTaskId.className = "divTableCell";
          newDivTaskId.id = "divTaskId" + i;
          newDivTaskId.innerHTML = tasks_id[i];
          newTableRow.appendChild(newDivTaskId);
          table.append(newTableRow);
        }
      }
    </script>  
        <div class="container">
<div class="logo">CLOCKER</div>
<div class="name">
<img  class = 'profil' src="/img/profile.png">
<p id='user_name'>Nazwa</p>
</div>
<div class="logB1"><button class="logButt">Wyloguj się</button></div>
<div class="lista">
<ul>
<li><button class="listButt projects">Projekty</button></li>
<li><button class="listButt tasks">Zadania</button></li>
<li><button class="listButt clients">Klienci</button></li>
<li><button class="listButt raports">Raporty</button></li>
<li><button class="listButt users">Użytkownicy</button></li>
</ul>
</div>
<div class="tabela">
<input id="searchbar" type="text" name="search" placeholder="Szukaj.." onkeyup="search()"><div class="buttony"><button class="startButt" onclick="start()"></button>

<form method="POST" action="/src/Controllers/TaskController.php" onsubmit="return endTaskFunction()">
    <input type="hidden" id="seconds_full" name="seconds_full"></input>
<button class="stopButt" name="stopButt" onclick="reset()"></button>
    </form>
</div>

  <form method="POST" action="/src/Controllers/TaskController.php" onsubmit="return deleteTaskFunction()">
   <input type="hidden" id="delete_id" name="delete_id"></input>
   <button hidden id="delete_submit" name="delete_submit">Potwierdz</button>
   </form>

<div id='time'>
 <form method="POST">
<span id="hour">00</span>:<span id="minute">00</span>:<span id="second">00</span>
</form>
</div>
   
<div class="divTable">
<div class="divTableBody" id="divTableBody">
    <div class="divTableRow header">
        <div class="divTableCell lp">&nbsp;Lp</div>
        <div class="divTableCell nazwa">&nbsp;Nazwa</div>
        <div class="divTableCell id_projektu">&nbsp;Id projektu</div>
        <div class="divTableCell start">&nbsp;Czas rozpoczęcia</div>
        <div class="divTableCell stop">&nbsp;Czas zakończenia</div>
        <div class="divTableCell time">&nbsp;Laczny czas</div>
        <div class="divTableCell delete">&nbsp;Usuń</div>
        <div class="divTableCell edit">&nbsp;Edytuj</div>
        <div class="divTableCell task_id" >&nbsp;Task id</div>
        <form method="POST" action="/src/Controllers/TaskController.php">
        <input type="hidden" id="edit_id" name="edit_id"></input>
        <input type="hidden" id="edit_name" name="edit_name"></input>
        <button hidden id="edit_submit" name="edit_submit">Potwierdz</button>
        </form>
        
    </div>
    
</div>
</div>
EOT;
$html2 = <<<EOT
  </div>
</div>
</body>
</html>
EOT;
echo $html;
echo '<form method="POST" action="/src/Controllers/TaskController.php" onsubmit="return addTaskFunction()">
<p class="newTask">Dodaj nowe zadanie:</p>
<p class="nameTask">Nazwa:<input id="taskName" type="text" name="taskName"></p>';
echo '<p class="chooseProject">Wybierz projekt  <select name="projectID" id="projectID">';
foreach ($projects as $row){
    echo '<option value="' . htmlspecialchars($row->getId()) . '">'
      . htmlspecialchars($row->getName())
      . '</option>';
}
echo '</select></p> <button class="addT" type="submit" id="addTask">Dodaj</button>';
echo '</form>';

echo $html2;
