<?php

    if(isset($_POST['checkBoxArray']) && isset($_POST['bulk_options'])){
        $checkBoxArray = $_POST['checkBoxArray'];
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options){
            case 'published':
                $query = "UPDATE posts set post_status = '{$bulk_options}' WHERE `post_id` IN (" . implode(',', array_map('intvalFunction', $checkBoxArray)) . ")";
                $execute = execute_query($query);
            break;
            case 'draft':
                $query = "UPDATE posts set post_status = '{$bulk_options}' WHERE `post_id` IN (" . implode(',', array_map('intvalFunction', $checkBoxArray)) . ")";
                $execute = execute_query($query);
            break;
            case 'delete':
                $query = "DELETE FROM posts WHERE `post_id` IN (" . implode(',', array_map('intvalFunction', $checkBoxArray)) . ")";
                $execute = execute_query($query);
            break;
            case 'clone':
                $query = "SELECT * FROM posts WHERE `post_id` IN (" . implode(',', array_map('intvalFunction', $checkBoxArray)) . ")";
                $execute = execute_query($query);

                $result = array();
                while($arr = mysqli_fetch_assoc($execute)){
                    extract($arr);
                    array_push($result, $arr);
                }

                foreach ($result as $item){

                    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) 
                              VALUES({$item['post_category_id']}, '{$item['post_title']}', '{$item['post_author']}', '{$item['post_date']}', '{$item['post_image']}', '{$item['post_content']}', '{$item['post_tags']}', '{$item['post_status']}' )";
                    $execute = execute_query($query);
                }

            break;
        }


    }
?>

<form action="" method="post">

    <div class="row">
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>

        </div>
        <div id="bulkOptionsContainer" class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>
    </div>

    <br>
    <table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>Id</th>
        <th>Author</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Comments</th>
        <th>Date</th>
        <th>Post views</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>

    <tbody>
    <?php

    $select = <<<SQL
        SELECT p.*, cat.cat_title, (SELECT COUNT(comment_id) FROM comments WHERE comment_post_id = p.post_id) AS post_comment_count
        FROM posts p 
        LEFT JOIN categories cat ON cat.cat_id = p.post_category_id
        ORDER BY p.post_id
SQL;

    $query = mysqli_query($connection, $select);
    $result = '';
    while($arr = mysqli_fetch_assoc($query)){
        extract($arr);

        if($post_comment_count >= 1){
            $post_comment_count = "<a href='comments.php?p_id={$post_id}'>{$post_comment_count}</a>";
        }

        $post_author = getPostAuthor($post_author);

        $result .= "<tr>";
        $result .= "  <td><input name='checkBoxArray[]' class='checkBoxes' type='checkbox' value='{$post_id}'></td>";
        $result .= "  <td>{$post_id}</td>";
        $result .= "  <td>{$post_author[0]['user_name']}</td>";
        $result .= "  <td>{$post_title}</td>";
        $result .= "  <td>{$cat_title}</td>";
        $result .= "  <td>{$post_status}</td>";
        $result .= "  <td><img width=\"150\" src=\"../images/{$post_image}\" alt=\"\"></td>";
        $result .= "  <td>{$post_tags}</td>";
        $result .= "  <td>{$post_comment_count}</td>";
        $result .= "  <td>{$post_date}</td>";
        $result .= "  <td>{$post_views_count}</td>";
        $result .= "  <td><a href='../post.php?&p_id={$post_id}'>View post</a></td>";
        $result .= "  <td><a href='?source=edit_post&p_id={$post_id}'>Edit</a></td>";
        $result .= "  <td><a class='confirmDeletePostModal' href='#' data-toggle=\"modal\" data-target=\"#myModalPost\" rel='{$post_id}'>Delete</a></td>";
        $result .= "</tr>";
    }

    echo $result;



    if(isset($_POST['delete'])){
        $delete_post_id = escape($_POST['id']);
        $query = "DELETE FROM posts WHERE post_id = {$delete_post_id}";
        $execute = mysqli_query($connection, $query);
        header("Location: {$_SERVER['PHP_SELF']}");
    }



    ?>



    </tbody>
    </table>

</form>