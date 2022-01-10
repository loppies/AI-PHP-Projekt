<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Clocker</title>
    <script src="/Clocker/js/clocker.js"></script>
    <link rel="stylesheet" href="/Clocker/css/clocker.css">
</head>

<body>
    Strona administratora:
    <?php
    session_start();
    if (isset($_SESSION['user_login'])) {
        echo $_SESSION['user_login'];
    } else {
        echo "Błąd czytania użytkownika z sesji";
    }
    ?>
</body>
