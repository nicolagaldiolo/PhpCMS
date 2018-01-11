<?php

// UPDATE CATEGORY
if(isset($_POST['update_category'])){
    $cat_id     = $_POST['cat_id'];
    $cat_title  = $_POST['cat_title'];
    $query = "UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = {$cat_id}";
    $update_query = mysqli_query($connection, $query);
    if(!$update_query){
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

if(isset($_GET['edit'])){
    $cat_id = $_GET['edit'];

    $select = "SELECT * FROM categories WHERE cat_id = {$cat_id}";
    $qry_editcat = mysqli_query($connection, $select);

    if ($arr = mysqli_fetch_assoc($qry_editcat)){
        extract($arr);
        echo $html = <<<HTML
        <form action="" method="post">
            <div class="form-group">
                <label for="cat_title">Edit Category</label>
                <input value="{$cat_title}" type="text" class="form-control" name="cat_title">
                <input type="hidden" value="{$cat_id}" name="cat_id">
            </div>
            <div class="form-group">
                <input class="btn btn-primary" name="update_category" type="submit" value="Edit">
            </div>
        </form>    
HTML;
    }

}




?>