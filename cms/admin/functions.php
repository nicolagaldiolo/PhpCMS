<?php

    if(!isset($connection)) {
        include "../includes/db.php";
    }

    function escape($string){
        global $connection;
        return mysqli_real_escape_string($connection, $string);

    }

    function user_online(){
        if(!isset($_SESSION)) {
            session_start();
        }
        $session = session_id();
        $time = time();
        $timeout = $time - 60;

        //estraggo l'elenco degli utenti loggati
        $query = "SELECT * FROM users_online WHERE session = '{$session}'";
        $execute = execute_query($query);
        $count = mysqli_num_rows($execute);

        //se non trovo utente legato a questa sessione lo creo o aggiorno il timestamp
        if ($count < 1) {
            $query = "INSERT INTO users_online(session, time) VALUES('{$session}', '{$time}')";
        } else {
            $query = "UPDATE users_online SET time = '{$time}' WHERE session = '{$session}'";
        }
        execute_query($query);

        //estraggo gli utenti loggati e con timeout NON scaduto
        $query = "SELECT * FROM users_online WHERE time > '{$timeout}'";
        $execute = execute_query($query);
        $count_user = mysqli_num_rows($execute);

        echo $count_user;
    }

    // richiesta scatenata via ajax (se la richiesta arriva via get)
    if(isset($_GET['onlineusers']) && $_GET['onlineusers'] == 'result'){
        user_online();
    }

    function execute_query($query){
        global $connection;
        if ($query) {
            $execute = mysqli_query($connection, $query);
            confirmQuery($execute);
        }
        return $execute;
    }

    function confirmQuery($result){
        global $connection;

        if(!$result){
            die("Query Failed" . mysqli_error($connection));
        }
    }

    function getPostAuthor($post_author = NUll){
        global $connection;

        $author_info = array();
        $where = ($post_author) ? "WHERE user_id = {$post_author}" : '';
        $select = "SELECT user_id, user_name FROM users {$where}";
        $qry_author = mysqli_query($connection, $select);
        confirmQuery($qry_author);

        while($arr = mysqli_fetch_assoc($qry_author)){
            extract($arr);
            $author_info[] = array(
                'id' => $user_id,
                'user_name' => $user_name
            );
        }
        return $author_info;
    }

    function insert_categories(){
        global $connection;

        if(isset($_POST['add_category'])){
            $cat_title = escape($_POST['cat_title']);
            if($cat_title == ""){
                echo "<div class=\"alert alert-warning\" role=\"alert\">The field should not be empty</div>";
            }else{
                $query = "INSERT INTO categories(cat_title) VALUE('{$cat_title}')";
                $create_cat = mysqli_query($connection, $query);
                if(!$create_cat){
                    die('QUERY FAILED' . mysqli_error($connection));
                }else{
                    echo "<div class=\"alert alert-success\" role=\"alert\">Category added</div>";
                }
            }
        }

    }

    function findAllCategories(){

        global $connection;

        $select = "SELECT * FROM categories";
        $qry_admincat = mysqli_query($connection, $select);
        $list = "";
        while ($arr = mysqli_fetch_assoc($qry_admincat)){
            extract($arr);
            $list .= "<tr>";
            $list .= "  <td>{$cat_id}</td>";
            $list .= "  <td>{$cat_title}</td>";
            $list .= "  <td><a href='?edit={$cat_id}'>Edit</a></td>";
            $list .= "  <td><a class='confirmDeleteModal' href='#' data-toggle=\"modal\" data-target=\"#myModal\" rel='?delete={$cat_id}'>Delete</a></td>";
            $list .= "<tr>";
        }
        return $list;
    }

    function deleteCategories(){

        global $connection;

        if(isset($_GET['delete']) && escape(intval($_GET['delete'])) > 0){
            $delete_cat_id = $_GET['delete'];
            $query = "DELETE FROM categories WHERE cat_id = {$delete_cat_id}";
            $execute = mysqli_query($connection, $query);
            header("Location: {$_SERVER['PHP_SELF']}");
        }
    }

    function intvalFunction($i){
        return intval($i);
    }

    function recordCount($field = '*', $table){
        global $connection;
        if($table){
            $select = "SELECT {$field} FROM {$table}";
            $query = mysqli_query($connection, $select);
            confirmQuery($query);
            return mysqli_num_rows($query);
        }
    }