<?php

    if(!isset($connection)) {
        include "../config/db.php";
    }

    function redirect($location){
        header("Location:" . $location);
        exit;
    }

    function ifItIsMethod($method = null){
        return ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) ? true : false;
    }

    function ifLoggedIn(){
        return ( isset($_SESSION['user_role']) && isset($_SESSION['username']) ) ? true : false;
    }

    function checkUserLoggedAndRedirect($location = null){
        if(ifLoggedIn()){
            redirect($location);
        }
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

                $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUE(?)");
                mysqli_stmt_bind_param($stmt, 's', $cat_title);
                mysqli_stmt_execute($stmt);

                if(!$stmt){
                    die('QUERY FAILED' . mysqli_error($connection));
                }else{
                    echo "<div class=\"alert alert-success\" role=\"alert\">Category added</div>";
                }

            }

            mysqli_stmt_close($stmt);
        }

    }

    function findAllCategories(){

        global $connection;

        $stmt = mysqli_prepare($connection, "SELECT * FROM categories");
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $list = "";
        while ($arr = mysqli_fetch_assoc($result)){
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
            $stmt = mysqli_prepare($connection, "DELETE FROM categories WHERE cat_id = ? ");
            mysqli_stmt_bind_param($stmt,"i", $delete_cat_id);
            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);

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

    function is_admin($username){
        global $connection;
        $query = "SELECT user_role FROM users WHERE user_name = '{$username}'";

        $execute = mysqli_query($connection, $query);
        confirmQuery($execute);

        $row = mysqli_fetch_assoc($execute);

        return $row['user_role'] == 'admin'  ? TRUE : FALSE;

    }

    function username_exists($username){
        global $connection;
        $query = "SELECT user_name FROM users WHERE user_name = '{$username}'";

        $execute = mysqli_query($connection, $query);
        confirmQuery($execute);

        return ( mysqli_num_rows($execute) > 0) ? TRUE : FALSE;

    }

    function email_exists($email){
        global $connection;
        $query = "SELECT user_email FROM users WHERE user_email = '{$email}'";

        $execute = mysqli_query($connection, $query);
        confirmQuery($execute);

        return ( mysqli_num_rows($execute) > 0) ? TRUE : FALSE;

    }

    function password_token_exists($token){
        global $connection;

        $stmt = mysqli_prepare($connection, "SELECT user_id FROM users WHERE token = ? ");
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $result = (mysqli_stmt_num_rows($stmt) >= 1) ? true : false;
        mysqli_stmt_close($stmt);
        return $result;
    }

    function register_user($username, $email, $password){
        global $connection;

        $username   = escape($username);
        $email      = escape($email);
        $password   = escape($password);



        if(!empty($username) && !empty($email) && !empty($password) ){

            $passwordSalt = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

            $query = "INSERT INTO users(user_name, user_email, user_password, user_role) VALUES ('$username', '$email', '$passwordSalt', 'subscriber')";
            $execute = mysqli_query($connection, $query);
            confirmQuery($execute);

            $options = array(
                'cluster' => getenv('APP_CLUSTER'),
                'encrypted' => getenv('APP_ENCRYPTED')
            );
            $pusher = new Pusher\Pusher(
                getenv('APP_KEY'),
                getenv('APP_SECRET'),
                getenv('APP_ID'),
                $options
            );

            $data['message'] = $username . ' just created an account.';
            $pusher->trigger('my-channel', 'user-register', $data);

        }
    }

    function login_user($username, $password){
        global $connection;

        $username = escape($username);
        $password = escape($password);

        $select = "SELECT * from users WHERE user_name = '{$username}'";
        $query = mysqli_query($connection, $select);
        confirmQuery($query);

        if($arr = mysqli_fetch_assoc($query)){
            extract($arr);

            if(password_verify($password, $user_password)) {
                $_SESSION['username'] = $user_name;
                $_SESSION['firstname'] = $user_firstname;
                $_SESSION['lastname'] = $user_lastname;
                $_SESSION['user_role'] = $user_role;
                redirect("/cms/admin");
            }
        }
        redirect($_SERVER['PHP_SELF']);
    }

