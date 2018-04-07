<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms">CMS Front</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php

                    $cat_page_id = (isset($_GET['category']) && intval($_GET['category']) > 0) ? escape(intval($_GET['category'])) : '';

                    $select = "SELECT * FROM categories";
                    $qry = mysqli_query($connection, $select);
                    $list = "";
                    while ($arr = mysqli_fetch_assoc($qry)){
                        extract($arr);
                        $class = ($cat_id == $cat_page_id) ? 'class="active"' : '';
                        $list .= "<li {$class}><a href=\"/cms/category/{$cat_id}\">{$cat_title}</a></li>";
                    }

                    echo $list;
                ?>
            </ul>

            <ul class="nav nav navbar-nav navbar-right">
                <li><a href="/cms/contact">Contact</a></li>
                <?php
                if(ifLoggedIn()){
                    echo "<li><a href=\"/cms/admin\">Admin</a></li>";

                    //if(isset($_GET['p_id'])){
                    //    $the_post_id = $_GET['p_id'];
                    //    echo "<li><a href=\"/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}\">Edit Post</a></li>";
                    //}

                    echo "<li><a href=\"/cms/partials/logout.php\">Logout</a></li>";

                }else{
                    echo "<li><a href=\"/cms/registration\">Registration</a></li>";
                    echo "<li><a href=\"/cms/login\">Login</a></li>";
                };
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>