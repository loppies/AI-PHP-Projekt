<?php
require (__DIR__ . "/src/Services/TaskRepository.php");
require (__DIR__ . "/src/Services/ProjectRepository.php");
require (__DIR__ . "/src/Services/UserRepository.php");
require (__DIR__ . "/src/Services/ClientRepository.php");
//require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\TaskRepository;
use Clocker\Services\ProjectRepository;
use Clocker\Services\UserRepository;
use Clocker\Services\ClientRepository;

session_start();
if (!isset($_SESSION['user_login'])) {
 header("Location: /home_page.php");
}


$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_login'];

$user = UserRepository::getUser($user_id);
$is_admin = $user->getIsAdmin();

$projects = ProjectRepository::getAllProjects($user_id);
$tasks = TaskRepository::getAllTasks($user_id);

$counter = 0;
$project_id = array();
$project_name = array();
$name = array();
$start = array();
$stop = array();
$task_id = array();
// ---------------------
$stawka = array();
// ---------------------
if ($tasks != NULL){
    foreach ($tasks as $row) {
        $counter += 1;
        $name[] = $row->getName();
        $one_project_id = $row->getProjectId();
        $project_id[] = $row->getProjectId();
        $start[] = $row->getStart();
        $stop[] = $row->getStop();
        $task_id[] = $row->getId();
        // ---------------------
        $stawka[] = $row->getRate();
        // ---------------------
        $one_project= ProjectRepository::getProject($one_project_id);
        if ($one_project == null){
            $project_name[] = "";
        }
        else {
            $project_name[] = $one_project->getName();

            $client = ClientRepository::getClient($one_project->getClientId());
            if ($client != null) {
                $client_name[$counter - 1] = $client->getName();
            } else {
                $client_name[$counter - 1] = "";
            }
        }
    }
}

if ($client_name != null) {
    $cnt = 0;
    foreach ($client_name as $signle_name) {
        if (!isset($client_name[$cnt])) {
            $client_name[$cnt] = "";
        }

        $cnt++;
    }
}

$name_json = json_encode($name);
$project_id_json = json_encode($project_id);
$start_json = json_encode($start);
$stop_json = json_encode($stop);
$task_id_json = json_encode($task_id);
$project_names_json = json_encode($project_name);
$client_names_json = json_encode($client_name);
// ---------------------
$stawka_json = json_encode($stawka);
// ---------------------

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

      function makeDivs() {
      
      if ('$is_admin' == 1){
            let adm = document.getElementById("adm");
            adm.removeAttribute("style");
        }
        var user_name = document.getElementById('user_name');
        user_name.innerHTML = "$user_name";
        var names = JSON.parse('$name_json');
        var projects_id = JSON.parse('$project_id_json');
        var starts = JSON.parse('$start_json');
        var stops = JSON.parse('$stop_json');
        var tasks_id = JSON.parse('$task_id_json');
        var projects_name = JSON.parse('$project_names_json');
        var clients_name = JSON.parse('$client_names_json');

        var stawki = JSON.parse('$stawka_json');

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
          newDivProjectId.innerHTML = projects_name[i];
          newTableRow.appendChild(newDivProjectId);
          table.append(newTableRow);

          var newDivClientId = document.createElement('div');
          newDivClientId.className = "divTableCell";
          newDivClientId.id = "divClientId" + i;
          newDivClientId.innerHTML = clients_name[i];
          newTableRow.appendChild(newDivClientId);
          table.append(newTableRow);
          
          var newDivStart = document.createElement('div');
          newDivStart.className = "divTableCell";
          newDivStart.id = "divStart" + i;
          newDivStart.innerHTML = starts[i];
          newTableRow.appendChild(newDivStart);
          table.append(newTableRow);

          var newDivStop = document.createElement('div');
          newDivStop.className = "divTableCell divStop";
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
          var diffTime = Math.abs(stopDate-startDate);
          var diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
          diffTime = diffTime / 1000;
          var hours = (diffTime / 3600) - (24 * diffDays);
          var minutes = (diffTime / 60) - (1440 * diffDays) - (60 * parseInt(hours));
          var seconds = Math.round((minutes - parseInt(minutes))*60);
          var result = diffDays + " dni " + parseInt(hours) + " H " + parseInt(minutes) + " m " + parseInt(seconds) + " s";
          newDivTime.innerHTML = result;
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
          
          var newDivStawka = document.createElement('div');
          newDivStawka.className = "divTableCell";
          newDivStawka.id = "divStawka" + i;

          
          if (stawki[i] != null) {
            newDivStawka.innerHTML = stawki[i];
          }
          else {
            newDivStawka.innerHTML = "00.00";
          }
          newTableRow.appendChild(newDivStawka);
          table.append(newTableRow);
          
          var newDivWynagrodzenie = document.createElement('div');
          newDivWynagrodzenie.className = "divTableCell";
          newDivWynagrodzenie.id = "newDivWynagrodzenie" + i;
          var wypelnionaStawka = document.getElementById('divStawka'+i);
          if (wypelnionaStawka.innerHTML != "00.00"){
          newDivWynagrodzenie.innerHTML = parseFloat((diffTime*wypelnionaStawka.innerHTML)/3600).toFixed(2) + " z??";
          }
          else {
          newDivWynagrodzenie.innerHTML = "00.00";
          }
          newTableRow.appendChild(newDivWynagrodzenie);
          table.append(newTableRow);

          var newDivTaskId = document.createElement('div');
          newDivTaskId.className = "divTableCell";
          newDivTaskId.id = "divTaskId" + i;
          newDivTaskId.innerHTML = tasks_id[i];
          newDivTaskId.style.display = "none";
          newTableRow.appendChild(newDivTaskId);
          table.append(newTableRow);
        }
        
        var timeEnd = document.getElementsByClassName('divStop');
        if (timeEnd.length != 0 && timeEnd[timeEnd.length - 1].innerHTML == "----" ) {
          start();
        }
        
      }
    </script>  
<div class="container">
  <div class="logo">CLOCKER</div>
  <div class="name">
  <img class='profil' src="/img/profile.png">
  <p id='user_name'>User</p>
  </div>
  
  <div class="logB1">
  <form method="POST" action="/src/Controllers/LogOut.php">
  <button class="logButt">Wyloguj si??</button>
  </form>
  </div>
  
  
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
<li>
<form method="POST" action="/src/Controllers/ChangeSitesClients.php" onsubmit="return to_clients()">
    <button class="listButt clients">Klienci</button>
</form>
</li>
<li>
<form method="POST" action="/src/Controllers/ChangeSitesReports.php" onsubmit="return to_clients()">
    <button class="listButt clients">Raport</button>
</form>
</li>
<form method="POST" action="/src/Controllers/ChangeSitesAdmin.php" onsubmit="return to_admin()">
    <button id="adm" class="listButt users" style="display:none;">U??ytkownicy</button>
</form>    </ul>
  </div>
  <div class="tabela">
    <input id="searchbar" type="text" name="search" placeholder="Szukaj.." onkeyup="search()">
    <div class="buttony">
    
    
    <form method="POST" action="/src/Controllers/TaskController.php" onsubmit="return endTaskFunction()">
    <input type="hidden" id="seconds_full" name="seconds_full"></input>
    <button name="stopButt" class="stopButt" onclick="reset()"></button>
    </form>
  </div>
    
   <form method="POST" action="/src/Controllers/TaskController.php" onsubmit="return deleteTaskFunction()">
   <input type="hidden" id="delete_id" name="delete_id"></input>
   <button hidden id="delete_submit" name="delete_submit">Potwierdz</button>
   </form>

    
  <div>
  <form method="POST">
      <div id='time'>
        <span id="hour">00</span>:<span id="minute">00</span>:<span id="second">00</span>
      </div>
    </form>
  </div>
  <div class="divTable">
    <div class="divTableBody" id="divTableBody">
      <div class="divTableRow header" id="firstDiv">
        <div class="divTableCell lp" >&nbsp;Lp</div>
        <div class="divTableCell nazwa">&nbsp;Nazwa</div>
        <div class="divTableCell id_projektu">&nbsp;Projekt</div>
        <div class="divTableCell id_klienta"> Klient</div>
        <div class="divTableCell start">&nbsp;Czas rozpocz??cia</div>
        <div class="divTableCell stop">&nbsp;Czas zako??czenia</div>
        <div class="divTableCell time"> ????czny czas</div>
        <div class="divTableCell delete">&nbsp;Usu??</div>
        <div class="divTableCell edit">&nbsp;Edytuj</div>
        <div class="divTableCell stawka" >&nbsp;Stawka (z??/h)</div>
        <div class="divTableCell wynagrodzenie" >&nbsp;Wynagrodzenie</div>
        <div class="divTableCell task_id" style="display: none">&nbsp;Task id</div>
        
        <form method="POST" action="/src/Controllers/TaskController.php">
        <input type="hidden" id="edit_id" name="edit_id"></input>
        <input type="hidden" id="edit_name" name="edit_name"></input>
        
        <input type="hidden" id="edit_stawka" name="edit_stawka"></input>
        
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
      <p class="newTask">Dodaj nowe zadanie</p>
      <p class="nameTask">Nazwa:<input id="taskAdd" type="text" name="add"></p>
     ';

echo '<p class="chooseProject">Wybierz projekt  <select name="projectID" id="projectID">';
foreach ($projects as $row){
    echo '<option value="' . htmlspecialchars($row->getId()) . '">'
      . htmlspecialchars($row->getName())
      ;
}
echo '<option value="empty">Pusty projekt</option></select></p> <button class="addT" type="submit" id="addTask">Dodaj</button>';
echo '</form>';

echo $html2;
