<?php include "db.php"; ?>
<?php session_start(); ?>

<?php

    unset($_SESSION['username']);
    unset($_SESSION['firstname']);
    unset($_SESSION['lastname']);
    unset($_SESSION['user_role']);

    header("Location: ../index.php");

?>