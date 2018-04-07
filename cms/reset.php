<?php
    include "config/config.php";
    include "partials/header.php";
    include "partials/navigation.php";

    if( !isset($_GET['token']) && !isset($_GET['email'])) {
        redirect("/cms/");
    }else{
        $token = escape($_GET['token']);
        $email = escape($_GET['email']);

        if( isset($_POST['recover-submit']) ){

            $password       = escape($_POST['password']);
            $newpassword    = escape($_POST['newpassword']);

            $error = array(
                'password' => '',
                'newpassword' => '',
            );

            if($password == '') {
                $error['password'] = 'Password cannot be empty';
            }

            if($password !== $newpassword) {
                $error['newpassword'] = 'Password don\'t match';
            }

            foreach ($error as $key => $value){
                if(empty($value)){
                    unset($error[$key]);
                }
            }

            if(empty($error)){
                $passwordSalt = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

                if( $stmt = mysqli_prepare($connection, "UPDATE users set token = '', user_password = '{$passwordSalt}' WHERE user_email = ?")){
                    mysqli_stmt_bind_param($stmt, 's', $email);
                    mysqli_stmt_execute($stmt);

                    if(mysqli_stmt_affected_rows($stmt) >= 1){
                        redirect('/cms/login.php');
                    }

                    mysqli_stmt_close($stmt);
                }
            }

        }
    }

?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>

    <?php if(password_token_exists($token)): ?>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Reset password</h2>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                                <input type="password" name="password" class="form-control" placeholder="Enter the new password">
                                            </div>
                                            <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                                <input type="password" name="newpassword" class="form-control" placeholder="Retype the new password">
                                            </div>
                                            <p><?php echo isset($error['newpassword']) ? $error['newpassword'] : '' ?></p>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="email" value="<?php echo $email; ?>">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                    </form>

                                </div><!-- Body-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php else: ?>
        <h2 class="text-center">Token non valido</h2>
        <?php endif; ?>

    <hr>

    <?php include "partials/footer.php";?>

</div> <!-- /.container -->

