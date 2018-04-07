<?php include "config/config.php"; ?>
<?php include "partials/header.php"; ?>

    <!-- Navigation -->
    <?php include "partials/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php if(isset($_GET['category'])) {
                    $post_category_id = escape(intval($_GET['category'])); ?>

                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- Blog Post -->
                    <?php


                    if (isset($_SESSION['username']) && is_admin($_SESSION['username'])) {
                        $stmt = mysqli_prepare($connection, "SELECT * FROM posts WHERE post_category_id = ?");
                        mysqli_stmt_bind_param($stmt, 'i', $post_category_id);
                    } else {
                        $stmt = mysqli_prepare($connection, "SELECT * FROM posts WHERE post_category_id = ? AND post_status = ? ");
                        $published = 'published';
                        mysqli_stmt_bind_param($stmt, 'is', $post_category_id, $published);
                    }

                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);


                    if (mysqli_num_rows($result) > 0) {
                        while ($arr = mysqli_fetch_assoc($result)) {
                            extract($arr);
                            $post_content = substr($post_content, 0, 200);
                            $post_author_info = getPostAuthor($post_author);
                            ?>

                            <h2>
                                <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                            </h2>
                            <p class="lead">
                                by
                                <a href="author_posts.php?p_author=<?php echo $post_author_info[0]['id']; ?>"><?php echo $post_author_info[0]['user_name']; ?></a>
                                <?php if ($post_status == 'draft') : ?>
                                    <span class="label label-info">Draft</span>
                                <?php endif; ?>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                            <hr>
                            <p><?php echo $post_content ?></p>
                            <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <span
                                        class="glyphicon glyphicon-chevron-right"></span></a>
                            <hr>

                            <?php
                        }

                    }else{
                        echo "<div class=\"alert alert-info\" role=\"alert\">No posts found</div>";
                    }

                    mysqli_stmt_close($stmt);
                }
                ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->

            <?php include "partials/sidebar.php"; ?>


        </div>
        <!-- /.row -->

        <hr>

<?php include "partials/footer.php"; ?>
