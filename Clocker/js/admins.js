function get_id(curr_id){
    let new_id = NaN;
    let iterator = 1;
    while (isNaN(new_id)){
      new_id = parseInt(curr_id.slice(-(curr_id.length - iterator)));
      iterator += 1;
    }
    return new_id;
}

function create_user_id_field(){
    let hidden_user_id = document.createElement("input");
    hidden_user_id.setAttribute("type", "text");
    hidden_user_id.setAttribute("name", "users_id");
    hidden_user_id.setAttribute("style", "display:none;");
    hidden_user_id.setAttribute("id", "hidden_user_id");
    return hidden_user_id;
}

function create_second_field(_name, _id){
    let second_field = document.createElement("input");
    second_field.setAttribute("type", "text");
    second_field.setAttribute("name", _name);
    second_field.setAttribute("style", "display:none;");
    second_field.setAttribute("id", _id);
    return second_field;
}

function change_role(curr_id){
    curr_id = get_id(curr_id);
    if (document.getElementById("usersId" + curr_id).innerText == curr_user){
        let bar = confirm(`Czy jesteś pewien, że chcesz zmienić sobie rolę? Może to spowodować niezamierzone skutki.`);
        if (!bar){
            let select = document.getElementById("select" + curr_id);
            select[0].selected = true;
            return;
        }
    }
    let get_form = document.getElementById("forms_select" + curr_id);
    let select = document.getElementById("select" + curr_id);
    let hidden_user_id = create_user_id_field();
    let hidden_user_role = create_second_field("user_role", "hidden_user_role");

    let submit_button = document.createElement("button");
    submit_button.setAttribute("style", "display:none;");
    submit_button.setAttribute("id", "submit_button");

    get_form.appendChild(hidden_user_id);
    get_form.appendChild(hidden_user_role);
    get_form.appendChild(submit_button);

    document.getElementById("hidden_user_id").value = document.getElementById("usersId" + curr_id).innerText;
    document.getElementById("hidden_user_role").value = select.value;
    get_form.setAttribute("action", "/src/Controllers/AdminController.php");
    submit_button.click();
}

function edit_login(curr_id){
    curr_id = get_id(curr_id);
    let edit_text = document.getElementById("text_login" + curr_id);
    let new_name = prompt(`Wpisz nowy login dla ${edit_text.innerText}`);
    if (new_name == null || new_name == "") {
        return
    }
    let bar = confirm(`Czy napewno chcesz zmienić login na ${new_name}`);
    if (bar){
        let get_form = document.getElementById("forms_login" + curr_id);
        let hidden_user_id = create_user_id_field();
        let hidden_new_login = create_second_field("users_new_login", "hidden_new_login");

        get_form.appendChild(hidden_user_id);
        get_form.appendChild(hidden_new_login);

        document.getElementById("hidden_user_id").value = document.getElementById("usersId" + curr_id).innerText;
        document.getElementById("hidden_new_login").value = new_name;
        get_form.setAttribute("action", "/src/Controllers/AdminController.php");
    }
}

function edit_email(curr_id){
    curr_id = get_id(curr_id);
    let edit_text = document.getElementById("text_email" + curr_id);
    let new_name = prompt(`Wpisz nowy email dla ${edit_text.innerText}`);
    if (new_name == null || new_name == "") {
        return
    }
    let bar = confirm(`Czy napewno chcesz zmienić email na ${new_name}`);
    if (bar){
        let get_form = document.getElementById("forms_email" + curr_id);
        let hidden_user_id = create_user_id_field();
        let hidden_new_email = create_second_field("users_new_email", "hidden_new_email");

        get_form.appendChild(hidden_user_id);
        get_form.appendChild(hidden_new_email);

        document.getElementById("hidden_user_id").value = document.getElementById("usersId" + curr_id).innerText;
        document.getElementById("hidden_new_email").value = new_name;
        get_form.setAttribute("action", "/src/Controllers/AdminController.php");
    }
}

function delete_user(curr_id){
    curr_id = get_id(curr_id);
    let name = document.getElementById("text_login" + curr_id).innerText;
    let bar = confirm(`Czy napewno chcesz trwale usunąć użytkownika ${name}`);
    if (bar){
        let get_form = document.getElementById("forms_trash" + curr_id);
        let hidden_user_id = create_user_id_field();
        let hidden_delete_permission = create_second_field("delete_permission", "hidden_delete_permission");

        get_form.appendChild(hidden_user_id);
        get_form.appendChild(hidden_delete_permission);

        document.getElementById("hidden_user_id").value = document.getElementById("usersId" + curr_id).innerText;
        document.getElementById("hidden_delete_permission").value = "true";
        get_form.setAttribute("action", "/src/Controllers/AdminController.php");
    }
}

function searchUsers() {
    var input, filter, txtValue;
    input = document.getElementById('searchbar');
    filter = input.value.toUpperCase();
    var div_names = [];
    var div_rows = document.getElementsByClassName("divTableRow");
    var rows = [];
    for (let i = 0; i < div_rows.length - 1; i++) {
      let names = document.getElementById('text_login' + i).innerHTML;
      rows.push(document.getElementById('r' + i));
      div_names.push(names);
    }
    console.log(div_names);
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

let login_edit_buts = document.getElementsByClassName("editButt IconDelete editLogin");
let email_edit_buts = document.getElementsByClassName("editButt IconDelete editEmail");
let delete_buts = document.getElementsByClassName("deleteButt");
for (let i = 0; i < login_edit_buts.length; i++) {
    login_edit_buts[i].setAttribute("onclick", "edit_login(this.id)");
    email_edit_buts[i].setAttribute("onclick", "edit_email(this.id)");
    delete_buts[i].setAttribute("onclick", "delete_user(this.id)");
}

selects = document.getElementsByClassName("selects");
for(let i = 0; i < selects.length; i++){
    selects[i].setAttribute("onChange", "change_role(this.id)");
}