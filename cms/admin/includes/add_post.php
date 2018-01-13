<?php

    $select = "SELECT * FROM categories";
    $qry_admincat = mysqli_query($connection, $select);
    confirmQuery($qry_admincat);
    $cat_list = "";
    while ($arrCat = mysqli_fetch_assoc($qry_admincat)){
        extract($arrCat);
        $cat_list .= "<option value='{$cat_id}'>{$cat_title}</option>";
    }

    $author_list = getPostAuthor();
    $authors = '';
    foreach($author_list as $item){
        $authors .= "<option value='{$item['id']}'>{$item['user_name']}</option>";
    }

    if(isset($_POST['create_post'])){

        $post_title         = escape($_POST['title']);
        $post_author        = escape($_POST['author']);
        $post_category_id   = escape(intval($_POST['post_category_id']));
        $post_status        = escape($_POST['post_status']);

        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        move_uploaded_file($post_image_temp, "../images/{$post_image}");

        $post_tags = escape($_POST['post_tags']);
        $post_content = escape($_POST['post_content']);
        $post_date = date('d-m-y');

        $query = "INSERT INTO posts(post_category_id, 
                                    post_title, 
                                    post_author, 
                                    post_date, 
                                    post_image, 
                                    post_content, 
                                    post_tags, 
                                    post_status) 
                                    VALUES({$post_category_id}, 
                                    '{$post_title}',
                                    '{$post_author}', 
                                    now(), 
                                    '{$post_image}', 
                                    '{$post_content}',
                                    '{$post_tags}',
                                    '{$post_status}' )";

        $create_post_query = mysqli_query($connection, $query);
        confirmQuery($create_post_query);

        $post_id = mysqli_insert_id($connection); // torna l'ultimo id inserito.

        echo "<div class=\"alert alert-success\" role=\"alert\">Post Created <a href=\"../post.php?p_id={$post_id}\">View Post</a> or <a href=\"posts.php?source=edit_post&p_id={$post_id}\">Edit Post</a></div>";
    }
?>


<form action="" method="post" enctype="multipart/form-data">


    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="category">Post Category Id</label>
        <select class="form-control" name="post_category_id">
            <?php echo $cat_list; ?>
        </select>
    </div>

    <div class="form-group">
       <label for="title">Post Author</label>
        <select class="form-control" name="author">
            <?php echo $authors; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="title">Post Status</label>
        <select name="post_status" class="form-control">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file"  name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control "name="post_content" id="" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>

</form>