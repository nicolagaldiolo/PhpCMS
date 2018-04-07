<?php

    if(isset($_POST['update_post'])){

        $post_id            = escape(intval($_POST['post_id']));
        $post_title         = escape($_POST['title']);
        $post_author        = escape($_POST['author']);
        $post_category_id   = escape(intval($_POST['post_category_id']));
        $post_status        = escape($_POST['post_status']);

        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        move_uploaded_file($post_image_temp, "../images/{$post_image}");

        if(empty($post_image)){
            $select = "SELECT post_image FROM posts WHERE post_id = {$post_id}";
            $query_image = mysqli_query($connection, $select);

            if($row = mysqli_fetch_assoc($query_image)){
                $post_image = $row['post_image'];
            }
        }

        $post_tags = escape($_POST['post_tags']);
        $post_content = escape($_POST['post_content']);

        $query = "UPDATE posts SET post_title = '{$post_title}',
                                   post_category_id = {$post_category_id},
                                   post_date = now(),
                                   post_author = '{$post_author}',
                                   post_status = '{$post_status}',
                                   post_tags = '{$post_tags}',
                                   post_content = '{$post_content}',
                                   post_image = '{$post_image}' 
                                   WHERE post_id = {$post_id} ";

        $update_post = mysqli_query($connection, $query);
        confirmQuery($update_post);

        echo "<div class=\"alert alert-success\" role=\"alert\">Post Updated <a href=\"../post.php?p_id={$post_id}\">View Post</a> or <a href=\"posts.php\">Edit More Posts</a></div>";

    }

    if(isset($_GET['p_id'])){
        $post_id = $_GET['p_id'];

        $select = "SELECT * FROM posts WHERE post_id = {$post_id}";
        $query = mysqli_query($connection, $select);
        confirmQuery($query);

        if ($arr = mysqli_fetch_assoc($query)) {
            extract($arr);

            $select = "SELECT * FROM categories";
            $qry_admincat = mysqli_query($connection, $select);
            confirmQuery($qry_admincat);
            $cat_list = "";
            while ($arrCat = mysqli_fetch_assoc($qry_admincat)){
                extract($arrCat);

                $selected = ($post_category_id == $cat_id) ? 'selected ' : '';

                $cat_list .= "<option value='{$cat_id}' {$selected}>{$cat_title}</option>";
            }

            $author_list = getPostAuthor();
            $authors = '';
            foreach($author_list as $item){
                $selected = ($item['id'] == $post_author) ? 'selected ' : '';
                $authors .= "<option value='{$item['id']}' {$selected}>{$item['user_name']}</option>";
            }


            // Option for post_status
            $post_status_option = '';
            $selected = ($post_status == 'draft') ? 'selected' : '';
            $post_status_option .= "<option value='draft' {$selected}>Draft</option>";
            $selected = ($post_status == 'published') ? 'selected' : '';
            $post_status_option .= "<option value='published' {$selected}>Published</option>";

            echo $html = <<<HTML
                <form action="" method="post" enctype="multipart/form-data">
            
                <div class="form-group">
                    <label for="title">Post Title</label>
                    <input type="text" class="form-control" name="title" value="{$post_title}">
                </div>
            
                <div class="form-group">
                    <label for="category">Post Category Id</label>
                    <select name="post_category_id" class="form-control">
                        {$cat_list}
                    </select>
                </div>
            
                <div class="form-group">
                    <label for="title">Post Author</label>
                    <select name="author" class="form-control">
                        {$authors}
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="title">Post Status</label>
                    <select name="post_status" class="form-control">
                        {$post_status_option}
                    </select>
                </div>
            
                <div class="form-group">
                    <label for="post_image">Post Image</label>
                    <div>
                        <img width="200" src="../images/{$post_image}">
                    </div>
                    <input type="file" name="image">
                </div>
                
                <div class="form-group">
                    <label for="post_tags">Post Tags</label>
                    <input type="text" class="form-control" name="post_tags" value="{$post_tags}">
                </div>
            
                <div class="form-group">
                    <label for="post_content">Post Content</label>
                    <textarea class="form-control "name="post_content" id="" cols="30" rows="10">{$post_content}</textarea>
                </div>
            
                <div class="form-group">
                    <input type="hidden" name="post_id" value="{$post_id}">
                    <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
                </div>
            
            </form>
HTML;
        }
    }

?>