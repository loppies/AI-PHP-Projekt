<?php ob_start() ?>
    <!-- Begin page content-->

    <h1>Zabłądziłem i nie wiem gdzie jestem :-(</h1>

    <!-- End page content-->
<?php $pageContent = ob_get_clean() ?>

<?php $pageTitle = '404 :-(' ?>
<?php $jsFile = "/js/clocker.js" ?>
<?php $cssFile = "/css/clocker.css" ?>
<?php $pageHeader = "" ?>
<?php $pageMenu = "" ?>
<?php $pageFooter = "" ?>
<?php include "LayoutView.php" ?>

