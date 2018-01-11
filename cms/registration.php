<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>

<?php
    $message = "";
    if(isset($_POST['submit'])){
        $username   = addslashes($_POST['username']);
        $email      = addslashes($_POST['email']);
        $password   = addslashes($_POST['password']);

        if(!empty($username) && !empty($email) && !empty($password) ){

            $passwordSalt = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users(user_name, user_email, user_password, user_role) VALUES ('$username', '$email', '$passwordSalt', 'subscriber')";
            $execute = mysqli_query($connection, $query);
            if(!$execute){
                die("QUERY FAILED" . mysqli_error($connection));
            }

            $message = "<div class=\"alert alert-success\" role=\"alert\">Registration complete</div>";

        }else{
            $message = "<div class=\"alert alert-info\" role=\"alert\">The field can no be empty</div>";
        }
    }
?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                        <h1>Register</h1>
                            <?php echo $message; ?>
                            <form role="form" action="" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                                </div>
                                 <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                                </div>
                                 <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                </div>

                                <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">
                            </form>

                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>


        <hr>



<?php include "includes/footer.php";?>