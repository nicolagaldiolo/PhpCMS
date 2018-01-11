<?php

    if(isset($_POST['create_user'])){

        $user_firstname     = addslashes($_POST['user_firstname']);
        $user_lastname      = addslashes($_POST['user_lastname']);
        $user_email         = addslashes($_POST['user_email']);
        $user_name          = addslashes($_POST['user_name']);
        $user_password      = addslashes($_POST['user_password']);
        $user_role          = addslashes($_POST['user_role']);

        $user_image = $_FILES['user_image']['name'];
        $user_image_temp = $_FILES['user_image']['tmp_name'];
        move_uploaded_file($user_image_temp, "../images/{$user_image}");

        $passwordSalt = password_hash($user_password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users(user_name, 
                                    user_password, 
                                    user_firstname, 
                                    user_lastname, 
                                    user_email, 
                                    user_image, 
                                    user_role) 
                                    VALUES('{$user_name}', 
                                    '{$passwordSalt}',
                                    '{$user_firstname}', 
                                    '{$user_lastname}', 
                                    '{$user_email}', 
                                    '{$user_image}',
                                    '{$user_role}')";

        $create_user_query = mysqli_query($connection, $query);
        confirmQuery($create_user_query);

        echo "<div class=\"alert alert-success\" role=\"alert\">User Created <a href=\"users.php\">View Users</a></div>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label>User Image</label>
        <input type="file" name="user_image">
    </div>

    <div class="form-group">
        <label>Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label>Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
       <label>Username</label>
        <input type="text" class="form-control" name="user_name">
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <label>Role</label>
        <select name="user_role" class="form-control">
            <option value="subscriber">Subscriber</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Create User">
    </div>

</form>