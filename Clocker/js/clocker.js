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
  input = document.getElementById('searchbar');
  filter = input.value.toUpperCase();
  var div_names = [];
  var div_dates_start = [];
  var div_rows = document.getElementsByClassName("divTableRow");
  var rows = [];
  for (let i = 0; i < div_rows.length - 1; i++) {
    let names = document.getElementById('divNazwa' + i).innerHTML;
    let dates_start = document.getElementById('divStart' + i).innerHTML;
    rows.push(document.getElementById('divTableRow' + i));
    div_names.push(names);
    div_dates_start.push(dates_start);
  }
  for (let i = 0; i < div_names.length; i++) {
    let a = div_names[i];
    let b = div_dates_start[i];
    txtValue = a.textContent || a.innerText;
    if ((a.toUpperCase().indexOf(filter) > -1) || (b.toUpperCase().indexOf(filter) > -1)) {
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
