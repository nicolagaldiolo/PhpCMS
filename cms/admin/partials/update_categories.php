<?php

// UPDATE CATEGORY
if(isset($_POST['update_category'])){
    $cat_id     = escape($_POST['cat_id']);
    $cat_title  = escape($_POST['cat_title']);

    $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $cat_id);
    mysqli_stmt_execute($stmt);

    if(!$stmt){
        die("QUERY FAILED" . mysqli_error($connection));
    }

    mysqli_stmt_close($stmt);
    redirect($_SERVER['PHP_SELF']);

}

if(isset($_GET['edit'])){
    $cat_id = $_GET['edit'];

    $stmt = mysqli_prepare($connection, "SELECT * FROM categories WHERE cat_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $cat_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($arr = mysqli_fetch_assoc($result)){
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

    mysqli_stmt_close($stmt);

}




?>
