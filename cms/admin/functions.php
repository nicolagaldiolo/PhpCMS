<?php

    function confirmQuery($result){
        global $connection;

        if(!$result){
            die("Query Failed" . mysqli_error($connection));
        }
    }

    function insert_categories(){
        global $connection;

        if(isset($_POST['add_category'])){
            $cat_title = addslashes($_POST['cat_title']);
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
            $list .= "  <td><a class='confirmDelete' href='?delete={$cat_id}'>Delete</a></td>";
            $list .= "<tr>";
        }
        return $list;
    }

    function deleteCategories(){

        global $connection;

        if(isset($_GET['delete'])){
            $delete_cat_id = $_GET['delete'];
            $query = "DELETE FROM categories WHERE cat_id = {$delete_cat_id}";
            $execute = mysqli_query($connection, $query);
            header("Location: {$_SERVER['PHP_SELF']}");
        }
    }