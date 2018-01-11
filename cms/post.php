<?php include "includes/header.php"; ?>
<?php include "includes/db.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">


            <?php if(isset($_GET['p_id'])) :
                $post_id = intval( $_GET['p_id'] );

                $select = "SELECT * FROM posts WHERE post_id = {$post_id}";
                $qry = mysqli_query($connection, $select);
                if ($arr = mysqli_fetch_assoc($qry)) :
                    extract($arr);
            ?>

                <h1 class="page-header"> <?php echo $post_title ?></h1>

                <p class="lead">
                    by <a href="search.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>

                <hr>

                <!-- Blog Comments -->

                <?php
                    if(isset($_POST['create_comment'])){
                        $comment_author = addslashes($_POST['comment_author']);
                        $comment_email = addslashes($_POST['comment_email']);
                        $comment_content = addslashes($_POST['comment_content']);

                        if( !empty($comment_author) && !empty($comment_author) && !empty($comment_author) ){
                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) 
                                  VALUES ( {$post_id}, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";
                            $execute = mysqli_query($connection, $query);

                            if(!$execute){
                                die("Query Failed" . mysqli_error($connection));
                            }

                            $query = "UPDATE posts SET post_comment_count = (post_comment_count + 1) WHERE post_id = {$post_id} ";
                            $update_post = mysqli_query($connection, $query);
                        }else{
                            echo "The Follow field not be empty";
                        }

                    }
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                        <div class="form-group">
                            <label>Author</label>
                            <input type="text" name="comment_author" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="comment_email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php

                    $select = "SELECT * FROM comments WHERE comment_post_id = {$post_id} AND comment_status = 'approved' ORDER BY comment_date";
                    $query = mysqli_query($connection, $select);
                    $list = "";
                    while($arr = mysqli_fetch_assoc($query)){

                        extract($arr);

                        $list .= <<<HTML
                            <div class="media">
                                <a class="pull-left">
                                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">{$comment_author}
                                    <small>{$comment_date}</small>
                                    </h4>
                                    {$comment_content}
                                </div>
                            </div>
HTML;
                    }

                    echo $list;

                ?>

                <!-- Comment -->


            <?php endif; endif; ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->

        <?php include "includes/sidebar.php"; ?>


    </div>
    <!-- /.row -->

    <hr>
    <?php include "includes/footer.php"; ?>