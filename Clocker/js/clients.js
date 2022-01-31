function edit(curr_id) {
    let new_id = NaN;
    let iterator = 1;
    while (isNaN(new_id)){
      new_id = parseInt(curr_id.slice(-(curr_id.length - iterator)));
      iterator += 1;
    }
    curr_id = new_id;
    name_field = document.getElementById("nazwa" + curr_id);
    let new_name = prompt(`Wpisz nową nazwę klienta dla ${name_field.innerText}`);
    if (new_name == null || new_name == "") {
        return
    }
    let bar = confirm(`Czy napewno chcesz zmienić nazwę klienta na ${new_name}`);
    if (bar == true) {
        let get_form = document.getElementById("forms_to_change" + curr_id);
        let hidden_client_id = document.createElement("input");
        hidden_client_id.setAttribute("type", "text");
        hidden_client_id.setAttribute("name", "clients_id");
        hidden_client_id.setAttribute("style", "display:none;");
        hidden_client_id.setAttribute("id", "hidden_client_id");

        let hidden_client_new_name = document.createElement("input");
        hidden_client_new_name.setAttribute("type", "text");
        hidden_client_new_name.setAttribute("name", "client_new_name");
        hidden_client_new_name.setAttribute("style", "display:none;");
        hidden_client_new_name.setAttribute("id", "hidden_client_new_name");

        get_form.appendChild(hidden_client_id);
        get_form.appendChild(hidden_client_new_name);

        document.getElementById("hidden_client_id").value = document.getElementById("clientId" + curr_id).innerText;
        document.getElementById("hidden_client_new_name").value = new_name;
        document.getElementById("clientAdd").value = "";
        get_form.setAttribute("action", "/src/Controllers/ClientController.php");
    }
  }

function deleteClientFunction() {
    let bar = confirm(`Czy napewno chcesz usunąć tego klienta?`);
    if (bar == true){
      let new_id = NaN;
      let iterator = 1;
      while (isNaN(new_id)){
        new_id = parseInt(this.id.slice(-(this.id.length - iterator)));
        iterator += 1;
      }
      var clientId = document.getElementById('clientId' + new_id);
      clientId = clientId.innerHTML;
      document.getElementById('delete_id').value = clientId;
      document.getElementById('delete_submit').click();
    }
  }


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

let edit_buts = document.getElementsByClassName("editButt IconDelete");
for (let i = 0; i < edit_buts.length; i++) {
    edit_buts[i].setAttribute("onclick", "edit(this.id)");
}

let delete_buts = document.getElementsByClassName("deleteButt");
for (let i = 0; i < delete_buts.length; i++) {
    delete_buts[i].addEventListener("click", deleteClientFunction);
}