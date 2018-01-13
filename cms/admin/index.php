<?php include "includes/admin_header.php"; ?>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small>
                                <?php if(isset($_SESSION['username'])) {
                                    echo $_SESSION['username'];
                                } ?>
                            </small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <?php
                                            $select = "SELECT post_id FROM posts";
                                            $query = mysqli_query($connection, $select);
                                            $record_count = mysqli_num_rows($query);
                                            if($record_count) {
                                                echo "<div class='huge'>{$record_count}</div>";
                                            }
                                        ?>


                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                            $select = "SELECT comment_id FROM comments";
                                            $query = mysqli_query($connection, $select);
                                            $record_count = mysqli_num_rows($query);
                                            if($record_count) {
                                                echo "<div class='huge'>{$record_count}</div>";
                                            }
                                        ?>
                                        <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                            $select = "SELECT user_id FROM users";
                                            $query = mysqli_query($connection, $select);
                                            $record_count = mysqli_num_rows($query);
                                            if($record_count) {
                                                echo "<div class='huge'>{$record_count}</div>";
                                            }
                                        ?>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                            $select = "SELECT cat_id FROM categories";
                                            $query = mysqli_query($connection, $select);
                                            $record_count = mysqli_num_rows($query);
                                            if($record_count) {
                                                echo "<div class='huge'>{$record_count}</div>";
                                            }
                                        ?>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <?php

                    $select = "SELECT post_status FROM posts";
                    $query = mysqli_query($connection,$select);
                    $posts = mysqli_num_rows($query);
                    $post_published = $post_draft = 0;
                    while ($arr = mysqli_fetch_assoc($query)){
                        extract($arr);
                        if($post_status == 'published'){
                            $post_published ++;
                        }
                        if($post_status == 'draft'){
                            $post_draft ++;
                        }
                    }

                    $select = "SELECT comment_status FROM comments";
                    $query = mysqli_query($connection,$select);
                    $comments = mysqli_num_rows($query);
                    $comments_pending = 0;
                    while ($arr = mysqli_fetch_assoc($query)){
                        extract($arr);
                        if($comment_status == 'unapproved'){
                            $comments_pending ++;
                        }
                    }

                    $select = "SELECT user_role FROM users";
                    $query = mysqli_query($connection,$select);
                    $users = mysqli_num_rows($query);
                    $subscriber = 0;
                    while ($arr = mysqli_fetch_assoc($query)){
                        extract($arr);
                        if($user_role == 'subscriber'){
                            $subscriber ++;
                        }
                    }

                    $select = "SELECT cat_id FROM categories";
                    $query = mysqli_query($connection,$select);
                    $categories = mysqli_num_rows($query);



                ?>



                <div class="row">
                    <div class="col-md-12">
                        <script type="text/javascript">
                        google.load("visualization", "1.1", {packages:["bar"]});
                        google.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Data', 'Count'],
                                <?php

                                $element_text = ['All Posts','Active Posts','Draft Posts', 'Comments','Pending Comments','Users','Subscribers','Categories'];
                                $element_count = [$posts,$post_published,$post_draft,$comments,$comments_pending,$users,$subscriber,$categories];

                                for($i =0;$i < 8; $i++) {
                                    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                                }

                                ?>


                            ]);

                            var options = {
                                chart: {
                                    title: 'Company Perfoarmance',
                                    subtitle: 'Sales, Expenses, and Profit: 2014-1017',
                                }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, options);
                        }
                    </script>


                        <div id="columnchart_material" style="width:auto; height: 500px;"></div>

                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include "includes/admin_footer.php"; ?>