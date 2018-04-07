<?php
$message = "";
if(isset($_POST['submit'])){

    $user_id                = escape(intval($_POST['user_id']));
    $old_password           = escape($_POST['old_password']);
    $new_password           = escape($_POST['new_password']);
    $new_password_repeat    = escape($_POST['new_password_repeat']);

    if(!empty($old_password) && !empty($new_password) && !empty($new_password_repeat) ){
        if($new_password === $new_password_repeat) {
            $select = "SELECT user_password FROM users WHERE user_id = {$user_id}";
            $query = mysqli_query($connection, $select);
            confirmQuery($query);
            if($arr = mysqli_fetch_assoc($query)){
                extract($arr);
                if(password_verify($old_password, $user_password)) {
                    $passwordSalt = password_hash($new_password, PASSWORD_BCRYPT, array('cost' => 12));
                    $query = "UPDATE users SET user_password = '{$passwordSalt}'";
                    $update_user = mysqli_query($connection, $query);
                    confirmQuery($update_user);

                    $message = "<div class=\"alert alert-success\" role=\"alert\">Password Change Successful</div>";

                }else{
                    $message = "<div class=\"alert alert-info\" role=\"alert\">User Not Found</div>";
                }
            }else{
                $message = "<div class=\"alert alert-info\" role=\"alert\">User Not Found</div>";
            }
        }else{
            $message = "<div class=\"alert alert-info\" role=\"alert\">Password not be identical</div>";
        }

    }else{
        $message = "<div class=\"alert alert-info\" role=\"alert\">The field can no be empty</div>";
    }
}
?>


    <?php
        echo $message;

        if(isset($_GET['p_id']) && escape(intval($_GET['p_id'])) > 0){
            $user_id = $_GET['p_id'];

            echo $html = <<<HTML
                <form role="form" action="" method="post" id="login-form" autocomplete="off">
                    <div class="form-group">
                        <input type="password" name="old_password" class="form-control" placeholder="Enter Older password">
                    </div>
                    <div class="form-group">
                        <input type="password" name="new_password" class="form-control" placeholder="Enter New password">
                    </div>
                    <div class="form-group">
                        <input type="password" name="new_password_repeat" class="form-control" placeholder="Repeat New password">
                    </div>
                    <input type="hidden" name="user_id" value="{$user_id}">
                    <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Edit password">
                </form>
HTML;

        }