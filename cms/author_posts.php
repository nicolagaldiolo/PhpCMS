<?php include "includes/header.php"; ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- Blog Post -->
                <?php
                    if($_GET['p_author']){
                        $post_author = escape($_GET['p_author']);
                        $where = " AND post_author = '{$post_author}'";
                    }

                    $select = "SELECT * FROM posts WHERE post_status = 'published' {$where}";
                    $qry = mysqli_query($connection, $select);
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
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>

                <?php endwhile; ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->

            <?php include "includes/sidebar.php"; ?>


        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>
