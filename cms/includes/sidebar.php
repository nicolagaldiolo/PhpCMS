<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control" <?php if(isset($_POST['search'])){ echo "value=\"{$_POST['search']}\""; } ?>>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
            <!-- /.input-group -->
        </form>
    </div>

    <!-- Login -->
    <div class="well">
        <?php if(isset($_SESSION['user_role']) && isset($_SESSION['username'])) : ?>
            <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
            <a href="includes/logout.php" class="btn btn-primary">Logout</a>
        <?php else: ?>
            <h4>Login</h4>
            <form action="includes/login.php" method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" name="login" type="submit">Submit</button>
                </div>

                <!-- /.input-group -->
            </form>

        <?php endif; ?>
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>

        <ul class="list-unstyled">
            <?php

            $select = "SELECT * FROM categories";
            $qry_sidecat = mysqli_query($connection, $select);
            $list = "";
            while ($arr = mysqli_fetch_assoc($qry_sidecat)){
                extract($arr);
                $list .= "<li><a href=\"category.php?category={$cat_id}\">{$cat_title}</a>";
            }
            echo $list;
            ?>
        </ul>

    </div>

    <!-- Side Widget Well -->
    <?php include 'widget.php' ?>

</div>