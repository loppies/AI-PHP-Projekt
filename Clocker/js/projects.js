function edit(curr_id) {
  let flag = 0;
  let iterator = 1;
  let new_id = NaN;
  while (isNaN(new_id)){
    new_id = parseInt(curr_id.slice(-(curr_id.length - iterator)));
    iterator += 1;
  }
  curr_id = new_id;
  name_field = document.getElementById("nazwa" + curr_id);
  let new_name = prompt(`Wpisz nową nazwę projektu dla ${name_field.innerText}`);
  var value = select.options[select.selectedIndex].value;
  let client_id = user_client_names.indexOf(value, 0);
  if (new_name != "" || new_name != null) {
    flag = 1;
  }
  if (new_name == null || new_name == "") {
    flag = 0;
  }
  if (client_id == -1 && flag != 1) {
    flag = 2
  } else {
    if (flag == 1) {
      if (value != "XYZxyz") {
        flag = 4
      }
    } else {
      flag = 3
    }
  }
  if (flag == 1) {
    if (new_name != null) {
      let bar = confirm(`Czy napewno chcesz zmienić nazwę projektu na ${new_name}`);
      if (bar == true) {
        let get_form = document.getElementById("forms_to_change" + curr_id);
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

        document.getElementById("hidden_project_id").value = document.getElementById("project" + curr_id).innerText;
        document.getElementById("hidden_project_new_name").value = new_name;
        document.getElementById("projectAdd").value = "";
        get_form.setAttribute("action", "/src/Controllers/ProjectController.php");
      }
    }
  }
  if (flag == 2) {
    return;
  }
  if (flag == 3) {
    let bar = confirm(`Czy napewno chcesz zmienić klienta na ${value}`);
    if (bar == true) {
      let get_form = document.getElementById("forms_to_change" + curr_id);

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
      document.getElementById("hidden_project_id").value = document.getElementById("project" + curr_id).innerText;
      document.getElementById("hidden_place").value = String(user_client_id[client_id]);
      get_form.setAttribute("action", "/src/Controllers/ProjectController.php");
    }
  }
  if (flag == 4) {
    let bar = confirm(`Czy napewno chcesz zmienić nazwę projektu na ${new_name} i klienta na ${value}`);
    if (bar == true) {
      let get_form = document.getElementById("forms_to_change" + curr_id);

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

      document.getElementById("hidden_project_id").value = document.getElementById("project" + curr_id).innerText;
      document.getElementById("hidden_project_new_name").value = new_name;
      document.getElementById("hidden_place").value = String(user_client_id[client_id]);
      document.getElementById("projectAdd").value = "";
      get_form.setAttribute("action", "/src/Controllers/ProjectController.php");
    }
  }
}

document.getElementById("on_submission").onsubmit = function () {
  submit()
};

function searchProjects() {
  var input, filter, txtValue;
  input = document.getElementById('searchbar');
  filter = input.value.toUpperCase();
  var div_names = [];
  var div_rows = document.getElementsByClassName("divTableRow");
  var rows = [];
  for (let i = 0; i < div_rows.length - 1; i++) {
    let names = document.getElementById('nazwa' + i).innerHTML;
    rows.push(document.getElementById('r' + i));
    div_names.push(names);
  }
  for (let i = 0; i < div_names.length; i++) {
    let a = div_names[i];
    txtValue = a.textContent || a.innerText;
    if (a.toUpperCase().indexOf(filter) > -1) {
      rows[i].style.display = "";
    } else {
      rows[i].style.display = "none";
    }
  }
}

function deleteProjectFunction() {
  let bar = confirm(`Czy napewno chcesz usunąć ten projekt?`);
  if (bar == true){
    let new_id = NaN;
    let iterator = 1;
    while (isNaN(new_id)){
      new_id = parseInt(this.id.slice(-(this.id.length - iterator)));
      iterator += 1;
    }
    var projectId = document.getElementById('project' + new_id);
    projectId = projectId.innerHTML;
    document.getElementById('delete_id').value = projectId;
    document.getElementById('delete_submit').click();
  }
}

function submit() {
  let get_form = document.getElementById("on_submission");
  var value = select.options[select.selectedIndex].value;
  let hidden_place = document.createElement("input");
  hidden_place.setAttribute("type", "text");
  hidden_place.setAttribute("name", "client_searched_id");
  hidden_place.setAttribute("style", "display:none;");
  get_form.appendChild(hidden_place);
  let client_id = user_client_names.indexOf(value, 0);
  if (client_id == -1) {
    hidden_place.value = "";
  } else {
    hidden_place.value = String(user_client_id[client_id]);
  }
  get_form.setAttribute("action", "/src/Controllers/ProjectController.php");
}

let edit_buts = document.getElementsByClassName("editButt IconDelete");
for (let i = 0; i < edit_buts.length; i++) {
  edit_buts[i].setAttribute("onclick", "edit(this.id)");
}

let delete_buts = document.getElementsByClassName("deleteButt");
for (let i = 0; i < delete_buts.length; i++) {
    delete_buts[i].addEventListener("click", deleteProjectFunction);
}
