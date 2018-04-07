<?php include "../config/config.php"; ?>
<?php include "partials/admin_header.php"; ?>

<?php if(!is_admin($_SESSION['username'])) {
    header("Location: index.php");
}
?>

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
                            case 'add_user':
                                include 'partials/add_user.php';
                                break;
                            case 'edit_user':
                                include 'partials/edit_user.php';
                                break;
                            case 'edit_password':
                                include 'partials/edit_password.php';
                                break;
                            default :
                                include 'partials/view_all_users.php';
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