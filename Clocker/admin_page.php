<?php
require (__DIR__ . "/src/Services/UserRepository.php");

use Clocker\Services\UserRepository;

session_start();
if (!isset($_SESSION['user_login'])){
    header("Location: /home_page.php");
}
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_login'];
$user = UserRepository::getUser($user_id);
$is_admin = $user->getIsAdmin();
$users = "";
$users_id = array();
$user_login = array();
$user_email = array();
$admins = array();
if ($is_admin){
    $users = UserRepository::getAllUsers($user_id);
}
if ($users != "" && $users != null){
    foreach ($users as $user){
        $users_id[] = $user->getId();
        $user_login[] = $user->getLogin();
        $user_email[] = $user->getEmail();
        $admins[] = $user->getIsAdmin();
  }
}
$users_id_json = json_encode($users_id);
$user_login_json = json_encode($user_login);
$user_email_json = json_encode($user_email);
$admins_json = json_encode($admins);

$html = <<<EOT
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Clocker</title>
        <link rel="stylesheet" href="css/admin-css.css">
    </head>
    <body>
        <div class="container">
            <div class="logo">CLOCKER</div>
            <div class="name"><img  class = 'profil' src="img/profile.png">$user_name</div>
            <div class="logB1">
                <form method="POST" action="/src/Controllers/LogOut.php">
                    <button class="logButt">Wyloguj się</button>
                </form>
            </div>
            <div class="lista"><ul>
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
            <li>
                <form method="POST" action="/src/Controllers/ChangeSitesAdmin.php" onsubmit="return to_admin()">
                    <button id="adm" class="listButt users">Użytkownicy</button>
                </form>
            </li>
            </ul></div>
            <div class="tabela">
                <input id="searchbar" type="text" name="search" placeholder="Szukaj.." onkeyup="searchUsers()">
                <div class="divTable">
                    <div class="divTableBody" id="divTableBody">
                        <div class="divTableRow header">
                            <div class="divTableCell lp">&nbsp;Lp</div>
                            <div class="divTableCell login">&nbsp;Login</div>
                            <div class="divTableCell email">&nbsp;Email</div>
                            <div class="divTableCell role">&nbsp;Rola</div>
                            <div class="divTableCell delete">&nbsp;Usuń</div>
                        </div>
                    </div>
                </div>
            </div>
            </br>
          </div>
    </body>
    <script>
        var data = [];
        var curr_user = $user_id;
        var user_login = JSON.parse('$user_login_json');
        var user_email = JSON.parse('$user_email_json');
        var users_id = JSON.parse('$users_id_json');
        var admins = JSON.parse('$admins_json');
        var roles = ["User", "Admin"];
        var amount = [...Array(user_login.length+1).keys()];
        amount.splice(0,1);
        data.push(amount);
        data.push(user_login);
        data.push(user_email);
        let table = document.getElementById("divTableBody");
        for (let i = 0; i < data[0].length; i++){
            let new_row = document.createElement("div");
            new_row.setAttribute("class", "divTableRow inner");
            new_row.setAttribute("id", String("r"+i));
            for (let j = 0; j < 3; j++){
                let elem = document.createElement("div");
                elem.setAttribute("class", "divTableCell");
                if (j == 0){
                    elem.innerText = String(data[j][i]);
                }
                if (j == 1){
                    elem.setAttribute("id", String("login"+i));

                    let inside_text = document.createElement("div");
                    inside_text.setAttribute("id", String("text_login"+i));
                    inside_text.innerText = String(data[j][i]);
                    elem.appendChild(inside_text);

                    let edit_button = document.createElement("button");
                    edit_button.setAttribute("class", "editButt IconDelete editLogin");
                    edit_button.setAttribute("id", String("edit_login"+i));

                    let edit_img = document.createElement("img");
                    edit_img.setAttribute("src", "img/edit.png");

                    let edit_form = document.createElement("form");
                    edit_form.setAttribute("method", "POST");
                    edit_form.setAttribute("class", "forms_login");
                    edit_form.setAttribute("id", String("forms_login"+i));

                    edit_button.appendChild(edit_img);
                    edit_form.appendChild(edit_button);
                    elem.appendChild(edit_form);
                }
                if (j == 2){
                    elem.setAttribute("id", String("email"+i));
                    let inside_text = document.createElement("div");
                    inside_text.setAttribute("id", String("text_email"+i));
                    inside_text.innerText = String(data[j][i]);
                    elem.appendChild(inside_text);

                    let edit_button = document.createElement("button");
                    edit_button.setAttribute("class", "editButt IconDelete editEmail");
                    edit_button.setAttribute("id", String("edit_email"+i));

                    let edit_img = document.createElement("img");
                    edit_img.setAttribute("src", "img/edit.png");

                    let edit_form = document.createElement("form");
                    edit_form.setAttribute("method", "POST");
                    edit_form.setAttribute("class", "forms_email");
                    edit_form.setAttribute("id", String("forms_email"+i));

                    edit_button.appendChild(edit_img);
                    edit_form.appendChild(edit_button);
                    elem.appendChild(edit_form);
                }
                new_row.appendChild(elem);
            }
            let new_elem = document.createElement("div");
            new_elem.setAttribute("class", "divTableCell");

            let new_select = document.createElement("select");
            new_select.setAttribute("class", "selects");
            new_select.setAttribute("id", String("select"+i));
            new_select.setAttribute("name", String("select"+i));
            let new_option1 = document.createElement("option");
            new_option1.innerText = roles[admins[i]];
            new_option1.value = admins[i];
            let new_option2 = document.createElement("option");
            new_option2.innerText = roles[Math.abs(admins[i] - 1)];
            new_option2.value = Math.abs(admins[i] - 1);
            new_select.appendChild(new_option1);
            new_select.appendChild(new_option2);

            let select_form = document.createElement("form");
            select_form.setAttribute("method", "POST");
            select_form.setAttribute("class", "forms_select");
            select_form.setAttribute("id", String("forms_select"+i));
            select_form.appendChild(new_select);

            new_elem.appendChild(select_form);
            new_row.appendChild(new_elem);


            let trash_elem = document.createElement("div");
            trash_elem.setAttribute("class", "divTableCell");

            let trash_button = document.createElement("button");
            trash_button.setAttribute("class", "deleteButt");
            trash_button.setAttribute("id", String("trash"+i));

            let trash_img = document.createElement("img");
            trash_img.setAttribute("class", "deletIcon");
            trash_img.setAttribute("src", "img/delete.png");

            let trash_form = document.createElement("form");
            trash_form.setAttribute("method", "POST");
            trash_form.setAttribute("class", "forms_trash");
            trash_form.setAttribute("id", String("forms_trash"+i));

            trash_button.appendChild(trash_img);
            trash_form.appendChild(trash_button);
            trash_elem.appendChild(trash_form);
            new_row.appendChild(trash_elem);


            let elem = document.createElement("div");
            elem.setAttribute("class", "divTableCell");
            elem.setAttribute("id", String("usersId"+i));
            elem.setAttribute("style", "display:none;");
            elem.innerText = String(users_id[i]);
            new_row.appendChild(elem);
            table.appendChild(new_row);
        }
    </script>
    <script src="/js/admins.js"></script>
</html>
EOT;
echo $html;