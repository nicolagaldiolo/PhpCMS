<?php include "../config/config.php"; ?>
<?php include "partials/admin_header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "partials/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>

                        <?php

                        $source = isset($_GET['source']) ? $_GET['source'] : '';

                        switch ($source){
                            case 'add_post':
                                include 'partials/add_post.php';
                                break;
                            case 'edit_post':
                                include 'partials/edit_post.php';
                                break;
                            default :
                                include 'partials/view_all_posts.php';
                                break;
                        }

                        ?>

                    </div>

                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "partials/admin_footer.php"; ?>