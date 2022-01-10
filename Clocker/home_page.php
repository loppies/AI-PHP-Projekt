<?php

$html = <<<EOT

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Clocker</title>
    <script src="/js/clocker.js"></script>
    <link rel="stylesheet" href="/css/clocker.css">
</head>

<body onload="getErrorMessage()">
    <h1>CLOCKER</h1>
    
    <div id="login" class="one">
        <form method="POST" action="/src/Controllers/LoginController.php" onsubmit="return login()">
            <p class="ll">Logowanie</p>
            <div class="errorMessage" id="loginErrorMessage"></div>
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
            <form method="POST" action="/src/Controllers/RegisterController.php" onsubmit="return register()">
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
        </div>
    </div>
    <div id="desc">
        <span id = 'descSpan'>Clocker to...</span>
    </div>
</body>
</html>

EOT;
echo $html;
