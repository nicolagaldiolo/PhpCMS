<?php include "includes/header.php"; ?>
<?php include "includes/db.php"; ?>

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

                if(isset($_POST['search'])){
                    $search = $_POST['search'];
                    $select = "SELECT * FROM posts WHERE post_tags LIKE '%{$search}%'";

                    $qry = mysqli_query($connection, $select);
                    $count = mysqli_num_rows($qry);

                    if($count == 0){
                        echo "<div class=\"alert alert-info\" role=\"alert\">No Result</div>";
                    }else{

                        while ($arr = mysqli_fetch_assoc($qry)) :
                            extract($arr);
                        ?>

                            <h2>
                                <a href="#"><?php echo $post_title ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="search.php"><?php echo $post_author ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                            <hr>
                            <p><?php echo $post_content ?></p>
                            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                            <hr>

                        <?php endwhile; ?>

                    <?php } ?>
                <?php } ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->

            <?php include "includes/sidebar.php"; ?>


        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>