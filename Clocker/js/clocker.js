"use strict";

var hour = 0;
var minute = 0;
var second = 0;
var millisecond = 0;
var cron = 0;



function timer() {
  if ((millisecond += 10) == 1000) {
    millisecond = 0;
    second++;
  }
  if (second == 60) {
    second = 0;
    minute++;
  }
  if (minute == 60) {
    minute = 0;
    hour++;
  }
  document.getElementById('hour').innerText = returnData(hour);
  document.getElementById('minute').innerText = returnData(minute);
  document.getElementById('second').innerText = returnData(second);
}


function start() {
  pause();
  cron = setInterval(() => {
    timer();
  }, 10);
}

function pause() {
  clearInterval(cron);
}

function reset() {
  pause();
  hour = 0;
  minute = 0;
  second = 0;
  millisecond = 0;
  document.getElementById('hour').innerText = '00';
  document.getElementById('minute').innerText = '00';
  document.getElementById('second').innerText = '00';
}


function returnData(input) {
  return input > 10 ? input : `0${input}`
}

function search() {
  var input, filter, txtValue;
  input = document.getElementById("searchbar");
  filter = input.value.toUpperCase();
  var div_names = [];
  var div_dates_start = [];
  var div_rows = document.getElementsByClassName("divTableRow");
  var rows = [];
  for (let i = 0; i < div_rows.length - 1; i++) {
    let names = document.getElementById("divNazwa" + i).innerHTML;
    let dates_start = document.getElementById("divStart" + i).innerHTML;
    rows.push(document.getElementById("divTableRow" + i));
    div_names.push(names);
    div_dates_start.push(dates_start);
  }
  for (let i = 0; i < div_names.length; i++) {
    let a = div_names[i];
    let b = div_dates_start[i];
    txtValue = a.textContent || a.innerText;
    if (
      a.toUpperCase().indexOf(filter) > -1 ||
      b.toUpperCase().indexOf(filter) > -1
    ) {
      rows[i].style.display = "";
    } else {
      rows[i].style.display = "none";
    }
  }
}

function register() {
  email = document.getElementById('reg_email').value;
  username = document.getElementById('reg_username').value;
  password = document.getElementById('reg_passwd').value;
  rep_password = document.getElementById('reg_passwd_rep').value;

  if (email.includes("@") && email.includes(".") && email.length != 0 &&
    username.length != 0 && password.length != 0) {
    if (password != rep_password) {
      alert("Podane hasła nie zgadzają sie ze sobą!");
      return false;
    }

    return true;
  } else {
    alert("Podano niepoprawne dane!");
    return false;
  }
}

function login() {
  username = document.getElementById('username').value;
  password = document.getElementById('passwd').value;

  if (username.length == 0 || password.length == 0) {
    alert("Login i haslo nie moga byc puste!");
    return false;
  }

  return true;
}

function addTaskFunction() {
  taskname = document.getElementById('taskname').value;
  if (taskname.length == 0) {
    alert("Nazwa zadania nie moze byc pusta!");
    return false;
  }
  return true;
}

function endTaskFunction() {
  let h = document.getElementById('hour').innerHTML;
  let m = document.getElementById('minute').innerHTML;
  let s = document.getElementById('second').innerHTML;
  var seconds = (parseInt(h) * 3600) + (parseInt(m) * 60) + parseInt(s);
  document.getElementById('seconds_full').value = seconds;
}

function deleteTaskFunction() {
  var id = this.id.slice(-1);
  var taskId = document.getElementById('divTaskId' + id);
  taskId = taskId.innerHTML;
  document.getElementById('delete_id').value = taskId;
  document.getElementById('delete_submit').click();
}


function getCopy(id) {
  var taskNameCopy = document.getElementById('divNazwa' + id);
  return taskNameCopy.innerHTML;
}

function editTaskFunction() {
  var id = this.id.slice(-1);
  var taskId = document.getElementById('divTaskId' + id);
  var taskName = document.getElementById('divNazwa' + id);
  var taskNameCopy = getCopy(id);
  var editButtons = document.getElementsByClassName("editClass");
  for (var i = 0; i < editButtons.length; i++) {
    editButtons[i].disabled = true;
  }
  taskId = taskId.innerHTML;
  taskName.contentEditable = "true";
  taskName.style.fontWeight = "bold";
  document.getElementById('edit_id').value = taskId;
  taskName.addEventListener('dblclick', function () {
    taskName.contentEditable = "false";
    taskName.style.fontWeight = "normal";
    taskName = document.getElementById('divNazwa' + id);
    if (taskName.innerHTML.length != 0) {
      document.getElementById('edit_name').value = taskName.innerHTML;
      document.getElementById('edit_submit').click();
    }
    if (taskName.innerHTML.length == 0) {
      document.getElementById('edit_name').value = taskNameCopy;
      document.getElementById('edit_submit').click();
    }
  })

}


function getErrorMessage() {
  const queryString = window.location.search;
  const urlParameters = new URLSearchParams(queryString);

  message = document.getElementById(urlParameters.get('type'));
  message.innerHTML = urlParameters.get('message');
}

function edit(curr_id){
  let flag = 0;
  curr_id = curr_id[curr_id.length-1];
  name_field = document.getElementById("nazwa"+curr_id);
  let new_name = prompt(`Wpisz nową nazwę projektu dla ${name_field.innerText}`);
  var value = select.options[select.selectedIndex].value;
  let client_id = user_client_names.indexOf(value,0);
  if (new_name != "" || new_name != null){
    flag = 1;
  }
  if (new_name == null || new_name == ""){
    flag = 0;
  }
  if (client_id == -1 && flag != 1){
    flag = 2
  }
  else{
    if (flag == 1){
      if (value != "XYZxyz"){
        flag = 4
      }
    }
    else{
      flag = 3
    }
  }
  if (flag == 1){
    if (new_name != null){
      let bar = confirm(`Czy napewno chcesz zmienić nazwę projektu na ${new_name}`);
      if (bar == true){
        let get_form = document.getElementById("forms_to_change"+curr_id);
        let hidden_project_id = document.createElement("input");
        hidden_project_id.setAttribute("type", "text");
        hidden_project_id.setAttribute("name", "projects_id");
        hidden_project_id.setAttribute("style", "display:none;");
        hidden_project_id.setAttribute("id", "hidden_project_id");

        let hidden_project_new_name = document.createElement("input");
        hidden_project_new_name.setAttribute("type", "text");
        hidden_project_new_name.setAttribute("name", "project_new_name");
        hidden_project_new_name.setAttribute("style", "display:none;");
        hidden_project_new_name.setAttribute("id", "hidden_project_new_name");

        get_form.appendChild(hidden_project_id);
        get_form.appendChild(hidden_project_new_name);

        document.getElementById("hidden_project_id").value = document.getElementById("project"+curr_id).innerText;
        document.getElementById("hidden_project_new_name").value = new_name;
        document.getElementById("projectAdd").value = "";
        get_form.setAttribute("action", "/src/Controllers/ProjectController.php");
      }
    }
  }
  if (flag == 2){
    return;
  }
  if (flag == 3){
    let bar = confirm(`Czy napewno chcesz zmienić klienta na ${value}`);
    if (bar == true){
      let get_form = document.getElementById("forms_to_change"+curr_id);

      let hidden_project_id = document.createElement("input");
      hidden_project_id.setAttribute("type", "text");
      hidden_project_id.setAttribute("name", "projects_id");
      hidden_project_id.setAttribute("style", "display:none;");
      hidden_project_id.setAttribute("id", "hidden_project_id");

      let hidden_place = document.createElement("input");
      hidden_place.setAttribute("type", "text");
      hidden_place.setAttribute("name", "bbb");
      hidden_place.setAttribute("style", "display:none;");
      hidden_place.setAttribute("id", "hidden_place");

      get_form.appendChild(hidden_place);
      get_form.appendChild(hidden_project_id);
      document.getElementById("hidden_project_id").value = document.getElementById("project"+curr_id).innerText;
      document.getElementById("hidden_place").value = String(user_client_id[client_id]);
      get_form.setAttribute("action", "/src/Controllers/ProjectController.php");
    }
  }
  if (flag == 4){
    let bar = confirm(`Czy napewno chcesz zmienić nazwę projektu na ${new_name} i klienta na ${value}`);
    if (bar == true){
      let get_form = document.getElementById("forms_to_change"+curr_id);

      let hidden_place = document.createElement("input");
      hidden_place.setAttribute("type", "text");
      hidden_place.setAttribute("name", "bbb");
      hidden_place.setAttribute("style", "display:none;");
      hidden_place.setAttribute("id", "hidden_place");

      let hidden_project_id = document.createElement("input");
      hidden_project_id.setAttribute("type", "text");
      hidden_project_id.setAttribute("name", "projects_id");
      hidden_project_id.setAttribute("style", "display:none;");
      hidden_project_id.setAttribute("id", "hidden_project_id");

      let hidden_project_new_name = document.createElement("input");
      hidden_project_new_name.setAttribute("type", "text");
      hidden_project_new_name.setAttribute("name", "project_new_name");
      hidden_project_new_name.setAttribute("style", "display:none;");
      hidden_project_new_name.setAttribute("id", "hidden_project_new_name");

      get_form.appendChild(hidden_place);
      get_form.appendChild(hidden_project_id);
      get_form.appendChild(hidden_project_new_name);

      document.getElementById("hidden_project_id").value = document.getElementById("project"+curr_id).innerText;
      document.getElementById("hidden_project_new_name").value = new_name;
      document.getElementById("hidden_place").value = String(user_client_id[client_id]);
      document.getElementById("projectAdd").value = "";
      get_form.setAttribute("action", "/src/Controllers/ProjectController.php");
    }
  }
}

function submit(){
  let get_form = document.getElementById("on_submission");
  var value = select.options[select.selectedIndex].value;
  let hidden_place = document.createElement("input");
  hidden_place.setAttribute("type", "text");
  hidden_place.setAttribute("name", "client_searched_id");
  hidden_place.setAttribute("style", "display:none;");
  get_form.appendChild(hidden_place);
  let client_id = user_client_names.indexOf(value,0);
  if (client_id == -1){
    hidden_place.value = "";
  }
  else{
    hidden_place.value = String(user_client_id[client_id]);
  }
  get_form.setAttribute("action", "/src/Controllers/ProjectController.php");
}

let edit_buts = document.getElementsByClassName("editButt IconDelete");
for (let i = 0; i < edit_buts.length; i++){
  edit_buts[i].setAttribute("onclick", "edit(this.id)");
}
