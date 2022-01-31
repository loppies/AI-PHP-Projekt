<?php $pageTitle = 'Tasks' ?>

<?php ob_start() ?>
    <!-- Begin page content-->

    <h3>Lista zadań</h3>

    <!-- End page content-->
<?php $pageContent = ob_get_clean() ?>

<?php require_once (__DIR__ ."/HeaderView.php"); ?>
<?php require_once (__DIR__ ."/FooterView.php"); ?>
<?php include "LayoutView.php" ?><?php
