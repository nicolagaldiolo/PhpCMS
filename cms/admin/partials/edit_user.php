<?php

    if(isset($_POST['update_user'])){

        $user_id            = escape(intval($_POST['user_id']));
        $user_firstname     = escape($_POST['user_firstname']);
        $user_lastname      = escape($_POST['user_lastname']);
        $user_email         = escape($_POST['user_email']);
        $user_name          = escape($_POST['user_name']);
        $user_role          = escape($_POST['user_role']);

        $user_image = $_FILES['user_image']['name'];
        $user_image_temp = $_FILES['user_image']['tmp_name'];
        move_uploaded_file($user_image_temp, "../images/{$user_image}");

        if(empty($user_image)){
            $select = "SELECT user_image FROM users WHERE user_id = {$user_id}";
            $query_image = mysqli_query($connection, $select);

            if($row = mysqli_fetch_assoc($query_image)){
                $user_image = $row['user_image'];
            }
        }

        $query = "UPDATE users SET user_name = '{$user_name}',
                                   user_firstname = '{$user_firstname}',
                                   user_lastname = '{$user_lastname}',
                                   user_email = '{$user_email}',
                                   user_image = '{$user_image}',
                                   user_role = '{$user_role}' 
                                   WHERE user_id = {$user_id}";
        $update_user = mysqli_query($connection, $query);
        confirmQuery($update_user);

        echo "<div class=\"alert alert-success\" role=\"alert\">User Updated <a href=\"users.php\">View Users</a></div>";

    }

    if(isset($_GET['p_id']) && escape(intval($_GET['p_id'])) > 0){
        $user_id = $_GET['p_id'];

        $select = "SELECT * FROM users WHERE user_id = {$user_id}";
        $query = mysqli_query($connection, $select);
        confirmQuery($query);

        if ($arr = mysqli_fetch_assoc($query)) {
            extract($arr);

            $user_roles_option = '';
            $selected = ($user_role == 'subscriber') ? 'selected' : '';
            $user_roles_option .= "<option value='subscriber' {$selected}>Subscriber</option>";
            $selected = ($user_role == 'admin') ? 'selected' : '';
            $user_roles_option .= "<option value='admin' {$selected}>Admin</option>";

            echo $html = <<<HTML
            
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>User Image</label>
                        <div>
                            <img width="100" src="../images/{$user_image}">
                        </div>
                        <input type="file" name="user_image">
                     </div>
                
                    <div class="form-group">
                        <label>Firstname</label>
                        <input type="text" class="form-control" name="user_firstname" value="{$user_firstname}">
                    </div>
                
                    <div class="form-group">
                        <label>Lastname</label>
                        <input type="text" class="form-control" name="user_lastname" value="{$user_lastname}">
                    </div>
                
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="user_email" value="{$user_email}">
                    </div>
                
                    <div class="form-group">
                       <label>Username</label>
                        <input type="text" class="form-control" name="user_name" value="{$user_name}">
                    </div>
                
                    <div class="form-group">
                        <label>Role</label>
                        <select name="user_role" class="form-control">
                            {$user_roles_option}
                        </select>
                    </div>
                
                    <div class="form-group">
                        <input type="hidden" name="user_id" value="{$user_id}">
                        <input class="btn btn-primary" type="submit" name="update_user" value="Update User">
                    </div>
                
                </form>
HTML;
        }
    }else{
        header("Location: index.php");
    }

?>