<?php include "includes/header.php"; ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php if(isset($_GET['category'])) :
                    $cat_id = escape(intval($_GET['category']));
                ?>

                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- Blog Post -->
                    <?php

                    $where = '';
                    if(!isset($_SESSION['user_role'])){
                        $where .= "AND post_status = 'published'";
                    }

                    $select = "SELECT * FROM posts WHERE post_category_id = {$cat_id} {$where}";
                    $qry = mysqli_query($connection, $select);
                    $record_num = mysqli_num_rows($qry);
                    if($record_num <= 0){
                        echo "<div class=\"alert alert-info\" role=\"alert\">No posts found</div>";
                    }else{
                        while ($arr = mysqli_fetch_assoc($qry)) :
                            extract($arr);

                            $post_content = substr($post_content, 0,200);
                            $post_author_info = getPostAuthor($post_author);
                        ?>

                            <h2>
                                <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="author_posts.php?p_author=<?php echo $post_author_info[0]['id']; ?>"><?php echo $post_author_info[0]['user_name']; ?></a>
                                <?php if($post_status == 'draft') : ?>
                                    <span class="label label-info">Draft</span>
                                <?php endif; ?>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                            <hr>
                            <p><?php echo $post_content ?></p>
                            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                            <hr>
                        <?php endwhile; ?>

                    <?php } ?>
                <?php endif; ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->

            <?php include "includes/sidebar.php"; ?>


        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>
