<?php include "db.php"; ?>
<?php include "../admin/functions.php"; ?>
<?php session_start(); ?>

<?php

    if(isset($_POST['login'])){
        $username = escape($_POST['username']);
        $password = escape($_POST['password']);


        $select = "SELECT * from users WHERE user_name = '{$username}'";
        $query = mysqli_query($connection, $select);
        if(!$query){
            die('Query Failed' . mysqli_error($connection));
        }

        if($arr = mysqli_fetch_assoc($query)){
            extract($arr);
        }

        if(password_verify($password, $user_password)) {
            $_SESSION['username'] = $user_name;
            $_SESSION['firstname'] = $user_firstname;
            $_SESSION['lastname'] = $user_lastname;
            $_SESSION['user_role'] = $user_role;
            header("Location: ../admin");
        }else{
            header("Location: ../index.php");
        }
    }else{
        header("Location: ../index.php");
    }

?>