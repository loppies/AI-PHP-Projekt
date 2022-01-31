<?php ob_start() ?>
<!-- Begin page content-->
<div class="logo">CLOCKER</div>
<div class="name">
    <img  class = 'profil' src="/img/profile.png">
    <p id='user_name'>
        Nazwa użytkownika
    </p>
</div>
<div class="logB1"><button class="logButt">Wyloguj się</button></div>
<!-- End page content-->
<?php $pageHeader = ob_get_clean() ?>
