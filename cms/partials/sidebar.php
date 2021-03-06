<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="/cms/search" method="post">
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
                $list .= "<li><a href=\"/cms/category/{$cat_id}\">{$cat_title}</a>";
            }
            echo $list;
            ?>
        </ul>

    </div>

    <!-- Side Widget Well -->
    <?php include 'widget.php' ?>

</div>