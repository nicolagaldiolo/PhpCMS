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

                        <?php include 'partials/view_all_comments.php'; ?>

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