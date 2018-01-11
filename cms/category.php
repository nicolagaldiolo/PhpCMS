<?php include "includes/header.php"; ?>
<?php include "includes/db.php"; ?>

    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php if(isset($_GET['category'])) :
                    $cat_id = intval($_GET['category']);
                ?>

                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- Blog Post -->
                    <?php

                    $select = "SELECT * FROM posts WHERE post_category_id = {$cat_id} AND post_status = 'published'";
                    $qry = mysqli_query($connection, $select);
                    while ($arr = mysqli_fetch_assoc($qry)) :
                        extract($arr);

                        $post_content = substr($post_content, 0,200);
                    ?>

                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="search.php"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>
                    <?php endwhile; ?>

                <?php endif; ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->

            <?php include "includes/sidebar.php"; ?>


        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>
