<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Author</th>
        <th>Comment</th>
        <th>Email</th>
        <th>Status</th>
        <th>In response to</th>
        <th>Date</th>
        <th></th>
        <th></th>
    </tr>
    </thead>

    <tbody>
    <?php

    if(isset($_GET['p_id']) && escape(intval($_GET['p_id'] > 0))){
        $post_id = escape(intval(($_GET['p_id'])));
        $where = "WHERE comment_post_id = {$post_id}";
    }else{
        $where = '';
    }

    $select = "SELECT * FROM comments {$where}";

    $query = mysqli_query($connection, $select);
    $result = '';
    while($arr = mysqli_fetch_assoc($query)){
        extract($arr);

        $select = "SELECT post_id, post_title FROM posts WHERE post_id = {$comment_post_id}";

        $qry_getpost = mysqli_query($connection, $select);

        if($arrPost = mysqli_fetch_assoc($qry_getpost)){
          $post_id = $arrPost['post_id'];
          $post_title = $arrPost['post_title'];
          $post_link = "<a href=\"../post.php?p_id={$post_id}\">{$post_title}</a>";
        };

        $result .= "<tr>";
        $result .= "  <td>{$comment_id}</td>";
        $result .= "  <td>{$comment_author}</td>";
        $result .= "  <td>{$comment_content}</td>";
        $result .= "  <td>{$comment_email}</td>";
        $result .= "  <td>{$comment_status}</td>";
        $result .= "  <td>{$post_link}</td>";
        $result .= "  <td>{$comment_date}</td>";
        if($comment_status == 'approved') {
            $result .= "  <td><a href='comments.php?status=unapproved&c_id={$comment_id}'>Unapprove</a></td>";
        }else{
            $result .= "  <td><a href='comments.php?status=approved&c_id={$comment_id}'>Approve</a></td>";
        }
        $result .= "  <td><a class='confirmDeleteModal' href='#' data-toggle=\"modal\" data-target=\"#myModal\" rel='comments.php?delete={$comment_id}'>Delete</a></td>";
        $result .= "</tr>";
    }

    echo $result;

    if(isset($_GET['status']) && isset($_GET['c_id'])){

        $comment_status = $_GET['status'];
        $comment_id = $_GET['c_id'];
        $query = "UPDATE COMMENTS SET comment_status = '{$comment_status}' WHERE comment_id = {$comment_id}";
        $execute = mysqli_query($connection, $query);
        confirmQuery($execute);
        header("Location: {$_SERVER['PHP_SELF']}");
    }

    if(isset($_GET['delete'])){

        $delete_comment_id = $_GET['delete'];

        // DECREMENT IL CAMPO POST_COMMENT_COUNT
        $select = "SELECT comment_post_id FROM comments WHERE comment_id = {$delete_comment_id}";
        $qry_getpost_id = mysqli_query($connection, $select);
        if($row = mysqli_fetch_assoc($qry_getpost_id)){
            $post_id = $row['comment_post_id'];
            $query = "UPDATE posts SET post_comment_count = (post_comment_count - 1) WHERE post_id = {$post_id} ";
            $update_post = mysqli_query($connection, $query);
        }
        // DECREMENT IL CAMPO POST_COMMENT_COUNT

        $query = "DELETE FROM comments WHERE comment_id = {$delete_comment_id}";
        $execute = mysqli_query($connection, $query);
        confirmQuery($execute);

        header("Location: {$_SERVER['PHP_SELF']}");
    }



    ?>



    </tbody>
</table>