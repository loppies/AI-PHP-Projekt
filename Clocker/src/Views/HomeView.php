<?php ob_start() ?>
<!-- Begin page content-->
    <h1>CLOCKER</h1>

    <div id="login" class="one">
        <form `method="GET" action="./index.php" onsubmit="return login()">
            <p class="ll">Logowanie</p>
            <div hidden class="log"><input type="text" id="action" name="action" value="login"></div>
            <div class="errorMessage" id="loginErrorMessage"><?= Clocker\Controllers\ClockerControllers::getMessage($resp, "loginErrorMessage"); ?></div>
            <label class="log">Login: </label><input type="text" id="username" name="username" required>
            <p class='wrongUsername'></p>
            <label class="log">Hasło: </label><input type="password" id="passwd" name="passwd" required>
            <p class='wrongPasswd'></p>
            <div class="wrap">
                <button type="submit" id="logButton">Zaloguj się</button>
            </div>
        </form>
    </div>
    <div id='same-line'>
        <div id="register">
            <form method="POST" action="index.php?action=login" onsubmit="return register()">
                <p class="ll">Załóż konto</p>
                <div class="errorMessage" id="registerErrorMessage"></div>
                <label class="reg">Email: </label><input type="text" id="reg_email" name="reg_email" required>
                <p class = 'wrongEmail'></p>
                <label class="reg">Login: </label><input type="text" id="reg_username" name="reg_username" required>
                <p class = 'wrongRegUser'></p>
                <label class="reg">Hasło: </label><input type="password" id="reg_passwd" name="reg_passwd" required>
                <p class = 'wrongPasswd'></p>
                <label class="reg">Powtórz hasło: </label><input type="password" id="reg_passwd_rep" name="reg_passwd_rep" required>
                <p class = 'wrongPasswd'></p>
                <div class="wrap">
                    <button type="submit" id="regButton">Zarejestruj się</button>
                </div>
            </form>
        </div>

        <div id="stats" class="one">
            <p class="ll">Statystyki</p>
            <p class="users_stat" id="users_stat">Ilosc uzytkownikow: <?= $resp->value["countUsers"] ?> </p>
            <p class="tasks_stat" id="tasks_stat">Ilosc zadan: <?= $resp->value["countTasks"] ?></p>
            <p class="projects_stat" id="projects_stat">Ilosc projektow: <?= $resp->value["countProjects"] ?></p>
            <p class="clients_stat" id="clients_stat">Ilosc klientow: <?= $resp->value["countClients"] ?></p>

        </div>
    </div>
    <div id="desc">
        <span id = 'descSpan'>Clocker to...</span>
    </div>
<!-- End page content-->
<?php $pageContent = ob_get_clean() ?>

<?php $pageTitle = "Welcome in Clocker" ?>
<?php $jsFile = "/js/clocker.js" ?>
<?php $cssFile = "/css/clocker.css" ?>
<?php $pageHeader = "" ?>
<?php $pageMenu = "" ?>
<?php $pageFooter = "" ?>
<?php include "LayoutView.php" ?>