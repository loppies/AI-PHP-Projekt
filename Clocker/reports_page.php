<?php
require (__DIR__ . "/src/Services/TaskRepository.php");
require (__DIR__ . "/src/Services/ProjectRepository.php");
require (__DIR__ . "/src/Services/UserRepository.php");
require (__DIR__ . "/src/Services/ClientRepository.php");
//require (__DIR__ . "./ErrorBuilder.php");

use Clocker\Services\ClientRepository;
use Clocker\Services\TaskRepository;
use Clocker\Services\ProjectRepository;
use Clocker\Services\UserRepository;

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


# -- RAPORTY --

$clients = ClientRepository::getAllClients($user_id);
if ($clients != null){
    foreach($clients as $client){
        $user_clients_names[] = $client->getName();
        $user_clients_id[] = $client->getId();
    }
}
$user_clients_names_json = json_encode($user_clients_names);
$user_clients_id_json = json_encode($user_clients_id);

$projects = ProjectRepository::getAllProjects($user_id);
if ($projects != null){
    foreach($projects as $project){
        $user_projects_names[] = $project->getName();
        $user_projects_id[] = $project->getId();
    }
}
$user_projects_names_json = json_encode($user_projects_names);
$user_projects_id_json = json_encode($user_projects_id);

# --

$html = <<<EOT

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Clocker</title>
        <link rel="stylesheet" href="/css/reports-css.css">
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
          newDivWynagrodzenie.innerHTML = parseFloat((diffTime*wypelnionaStawka.innerHTML)/3600).toFixed(2) + " zl";
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
  <button class="logButt">Wyloguj się</button>
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
    <button id="adm" class="listButt users" style="display:none;">Użytkownicy</button>
</form>    </ul>
  </div>
  <div class="tabela">
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
  </div>
  <div class="divTable">
    <div class="divTableBody" id="divTableBody">
      <div class="divTableRow header" id="firstDiv">
        <div class="divTableCell lp" >&nbsp;Lp</div>
        <div class="divTableCell nazwa">&nbsp;Nazwa</div>
        <div class="divTableCell id_projektu">&nbsp;Projekt</div>
        <div class="divTableCell id_klienta"> Klient</div>
        <div class="divTableCell start"> Czas rozpoczęcia</div>
        <div class="divTableCell stop">&nbsp;Czas zakończenia</div>
        <div class="divTableCell time"> Łączny czas</div>
        <div class="divTableCell stawka" >&nbsp;Stawka (zł/h)</div>
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
echo $html;
$html2 = <<<EOT
    <p class="makeRaport">Wygeneruj raport:</p>
    <div id="div_to_submit_prj" class="chooseProject">Wybierz projekt <select id="select_prj" onchange="selectProject()"><option value="">Wybierz projekt...</option></select> </div>
    <div id="div_to_submit" class="chooseClient">Wybierz klienta <select id="select" onchange="selectClient()"><option value="">Wybierz klienta...</option></select> </div>
    <div class="Calendar">
        <input class="date_control" id="start_date" type="datetime-local" onchange="selectDate()">
        <input class="date_control" id="stop_date" type="datetime-local" onchange="selectDate()">
    </div>   
    <button class="addG" onclick="saveToFile()">Generuj CSV</button>
 
    <script>           
        function selectClient() {
           let projectControl = document.getElementById("select_prj");
           projectControl.value = "";
           let startDate = document.getElementById("start_date");
           startDate.value = "";
           let stopDate = document.getElementById("stop_date");
           stopDate.value = "";
           
           let client = document.getElementById("select").value;
           
           let rows = [];      
           for (let i = 0; i < $counter; i++) {
               rows.push( document.getElementById('divTableRow' + i ) );
           }
           
           if (client !== "") {
               for (let i = 0; i < $counter; i++) {             
                   if ( document.getElementById("divClientId" + i).innerHTML === client ) {
                        rows[i].style.display = "";
                   } else {
                        rows[i].style.display = "none";
                   }
               }           
           } else {
               for (let i = 0; i < $counter; i++) {
                    rows[i].style.display = "";
               } 
               
           }
        }
        
        function selectProject() {
           let clientControl = document.getElementById("select");
           clientControl.value = "";
           let startDate = document.getElementById("start_date");
           startDate.value = "";
           let stopDate = document.getElementById("stop_date");
           stopDate.value = "";
           
           let project = document.getElementById("select_prj").value;         
           let rows = [];      
           for (let i = 0; i < $counter; i++) {
               rows.push( document.getElementById('divTableRow' + i ) );
               console.log(rows[i]);
           }
                  
           if (project !== "") {
               for (let i = 0; i < $counter; i++) {                
                   if ( document.getElementById("divProjectId" + i).innerHTML === project ) {
                        rows[i].style.display = "";
                   } else {
                        rows[i].style.display = "none";
                   }
               }           
           } else {
               for (let i = 0; i < $counter; i++) {
                    rows[i].style.display = "";
               }           
           }
        }
        
        function selectDate() {
            let clientControl = document.getElementById("select");
            clientControl.value = "";
            let projectControl = document.getElementById("select_prj");
            projectControl.value = "";
           
            let startDate = document.getElementById("start_date").value;
            let stopDate = document.getElementById("stop_date").value;
                        
            let rows = [];      
            for (let i = 0; i < $counter; i++) {
                rows.push( document.getElementById('divTableRow' + i ) );
            }
                        
            if (stopDate === "" && startDate === "") {
                for (let i = 0; i < $counter; i++) {                         
                    rows[i].style.display = "";    
                }
            }
            
            if (startDate !== "" && stopDate === "") {
                for (let i = 0; i < $counter; i++) {
                   let date = document.getElementById("divStart" + i).innerHTML;
                   date = date.replace(" ", "T");
                   date = date.slice(0, -3);
                                      
                   if ( Date.parse(date) >= Date.parse(startDate) ) {
                        rows[i].style.display = "";
                   } else {
                        rows[i].style.display = "none";
                   }
                }
            }
            
            if (startDate === ""  && stopDate !== "") {
                for (let i = 0; i < $counter; i++) {
                   let date = document.getElementById("divStart" + i).innerHTML;
                   date = date.replace(" ", "T");
                   date = date.slice(0, -3);
                   
                   if ( Date.parse(date) <= Date.parse(stopDate) ) {
                        rows[i].style.display = "";
                   } else {
                        rows[i].style.display = "none";
                   }
                }            
            }
            
            if (startDate !== ""  && stopDate !== "") {
                for (let i = 0; i < $counter; i++) {
                   let date = document.getElementById("divStart" + i).innerHTML;
                   date = date.replace(" ", "T");
                   date = date.slice(0, -3);
                   
                   if ( Date.parse(date) <= Date.parse(stopDate) && Date.parse(date) >= Date.parse(startDate) ) {
                        rows[i].style.display = "";
                   } else {
                        rows[i].style.display = "none";
                   }
                }               
            }
        }     
    
        function saveToFile() {              
           let rows = [];      
           for (let i = 0; i < $counter; i++) {
               rows.push( document.getElementById('divTableRow' + i ) );
           }
          
          const rowsToFile = [
            ["Lp", "Nazwa", "Projekt", "Klient", "Czas rozpoczecia", "Czas zakonczenia", "Laczny czas", "Stawka (zl/h)", "Wynagrodzenie"],
          ];
          
          for (let i = 0; i < $counter; i++) {                         
              if (rows[i].style.display === "") {
                    rowsToFile.push(
                        [
                            document.getElementById("divLp" + i).innerHTML,
                            document.getElementById("divNazwa" + i).innerHTML,
                            document.getElementById("divProjectId" + i).innerHTML,
                            document.getElementById("divClientId" + i).innerHTML,
                            document.getElementById("divStart" + i).innerHTML,
                            document.getElementById("divStop" + i).innerHTML,
                            document.getElementById("divTime" + i).innerHTML,
                            document.getElementById("divStawka" + i).innerHTML,
                            document.getElementById("newDivWynagrodzenie" + i).innerHTML
                        ]
                    );
              }         
          }

          let csvContent = "data:text/csv;charset=utf-8," + rowsToFile.map(e => e.join(";")).join("\\r\\n");
          var encodedUri = encodeURI(csvContent);
          var link = document.createElement("a");
          link.setAttribute("href", encodedUri);
          link.setAttribute("download", "my_data.csv");
          document.body.appendChild(link);

          link.click();
        }
   
        var user_client_names = JSON.parse('$user_clients_names_json');
        var user_client_id = JSON.parse('$user_clients_id_json');
        var select = document.getElementById("select");
        for (let i = 0; i < user_client_names.length; i++){
            var option = document.createElement("option");
            option.text = user_client_names[i];
            select.add(option);
        }
        
        var user_project_names = JSON.parse('$user_projects_names_json');
        var user_project_id = JSON.parse('$user_projects_id_json');
        var select_prj = document.getElementById("select_prj");
        for (let i = 0; i < user_project_names.length; i++){
            var option = document.createElement("option");
            option.text = user_project_names[i];
            select_prj.add(option);
        }
    </script>  
EOT;

echo $html2;
