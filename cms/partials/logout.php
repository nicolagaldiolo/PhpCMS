<?php session_start(); ?>
<?php include "../config/config.php"; ?>

<?php

    unset($_SESSION['username']);
    unset($_SESSION['firstname']);
    unset($_SESSION['lastname']);
    unset($_SESSION['user_role']);

    redirect("../index.php");

?>