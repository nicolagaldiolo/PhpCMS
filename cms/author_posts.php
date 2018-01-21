<?php
    if(!isset($_GET['p_author']) || intval($_GET['p_author']) <= 0){
        header("Location: index.php");
    }else{
        $post_author = intval($_GET['p_author']);
    }
?>

    <?php include "config/config.php"; ?>
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

                    $where = '';
                    if(!isset($_SESSION['user_role'])){
                        $where .= "AND post_status = 'published'";
                    }

                    $select = "SELECT * FROM posts WHERE post_author = {$post_author} {$where}";
                    $qry = mysqli_query($connection, $select);

                    if(!$qry){
                        echo mysqli_error($connection);
                    }
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
                            <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="/cms/author_posts/<?php echo $post_author_info[0]['id']; ?>"><?php echo $post_author_info[0]['user_name']; ?></a>
                            <?php if($post_status == 'draft') : ?>
                                <span class="label label-info">Draft</span>
                            <?php endif; ?>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                        <hr>
                        <a href="/cms/post/<?php echo $post_id; ?>">
                            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        </a>
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>

                    <?php endwhile; ?>
                <?php } ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->

            <?php include "includes/sidebar.php"; ?>


        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>
