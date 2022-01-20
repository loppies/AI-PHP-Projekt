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
  document.getElementById('hour').innerText = '0r30';
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
  var d_name = document.getElementsByClassName("nazwa");
  var d_lp = document.getElementsByClassName("lp");
  var d_id = document.getElementsByClassName("id_projektu");
  var d_start = document.getElementsByClassName("start");
  var d_stop = document.getElementsByClassName("stop");
  var d_usun = document.getElementsByClassName("delete");
  var d_edytuj = document.getElementsByClassName("edit");
  for (let i = 1; i < d_name.length; i++) {
    div_names.push(d_name[i].innerHTML);
  }
  for (let i = 0; i < div_names.length; i++) {
    let a = div_names[i];
    txtValue = a.textContent || a.innerText;
    if (a.toUpperCase().indexOf(filter) > -1) {
      d_lp[i + 1].style.display = "";
      d_name[i + 1].style.display = "";
      d_id[i + 1].style.display = "";
      d_start[i + 1].style.display = "";
      d_stop[i + 1].style.display = "";
      d_usun[i + 1].style.display = "";
      d_edytuj[i + 1].style.display = "";
    } else {
      d_lp[i + 1].style.display = "none";
      d_name[i + 1].style.display = "none";
      d_id[i + 1].style.display = "none";
      d_start[i + 1].style.display = "none";
      d_stop[i + 1].style.display = "none";
      d_usun[i + 1].style.display = "none";
      d_edytuj[i + 1].style.display = "none";
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

function addTask() {
  taskname = document.getElementById('taskname').value;
  if (taskname.length == 0) {
    alert("Nazwa zadania nie moze byc pusta!");
    return false;
  }
  return true;
}

function endTask() {
  let h = document.getElementById('hour').innerHTML;
  let m = document.getElementById('minute').innerHTML;
  let s = document.getElementById('second').innerHTML;
  var seconds = (h * 3600) + (m * 60) + s;
  document.getElementById('seconds_full').value = seconds;
}


function getErrorMessage() {
  const queryString = window.location.search;
  const urlParameters = new URLSearchParams(queryString);

  message = document.getElementById(urlParameters.get('type'));
  message.innerHTML = urlParameters.get('message');
}
