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

                    $item_for_page = 10;

                    $post_count = "SELECT * FROM posts WHERE post_status = 'published'";
                    $find_count = mysqli_query($connection, $post_count);
                    $count = mysqli_num_rows($find_count); // estraggo il numero di risultati
                    $pager_count = ceil($count / $item_for_page); // divido il numero risultati per "$item_for_page" e arrotondo per eccesso

                    $page_filter = 0;
                    if( isset($_GET['page']) ){
                        $page_current = escape(intval($_GET['page']));
                        $page_filter = ( $page_current * $item_for_page ) - $item_for_page;
                    }



                    $select = "SELECT * FROM posts WHERE post_status = 'published' LIMIT {$page_filter},{$item_for_page}";
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
                            by <a href="author_posts.php?p_author=<?php echo $post_author_info[0]['id'] ?>"><?php echo $post_author_info[0]['user_name'] ?></a>
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

                <!-- /.row -->
                <?php if($pager_count > 1): ?>
                    <ul class="pager">
                        <?php
                            $page = '';
                            for($i=1; $i <= $pager_count; $i++) {

                                $active = (isset($_GET['page']) && escape(intval($_GET['page'])) == $i ) ? 'class="active"' : '';

                                $page .= "<li><a {$active} href=\"index.php?page={$i}\">{$i}</a></li>";
                            }
                            echo $page;
                        ?>
                    </ul>
                <?php endif; ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->

            <?php include "includes/sidebar.php"; ?>


        </div>

        <hr>

<?php include "includes/footer.php"; ?>
