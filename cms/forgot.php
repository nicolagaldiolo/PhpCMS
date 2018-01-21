<?php
    include "config/config.php";
    include "includes/header.php";
    include "includes/navigation.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $message = '';

if( !isset($_GET['forgot']) || escape(trim($_GET['forgot'])) == '') {
        redirect("/cms/");
    }

    if(isset($_POST['email']) && escape(trim($_POST['email'])) != ''){
        $email = escape(trim($_POST['email']));

        if(email_exists($email)){
            if($stmt = mysqli_prepare($connection, "UPDATE users SET token = ? WHERE user_email = ?")){
                $lenght = 50;
                $token = bin2hex(openssl_random_pseudo_bytes($lenght));
                mysqli_stmt_bind_param($stmt, "ss", $token, $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

                /*
                 * Configure PHPMAILER
                 *
                 *
                 */

                $mail = new PHPMailer(true);                     // Passing `true` enables exceptions
                try {
                    //Server settings
                    //$mail->SMTPDebug = 2;
                    $mail->isSMTP();                                        // Set mailer to use SMTP
                    $mail->Host = getenv('SMTP_HOST');                        // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                                 // Enable SMTP authentication
                    $mail->Username = getenv('SMTP_USERNAME');                // SMTP username
                    $mail->Password = getenv('SMTP_PASSWORD');                // SMTP password
                    $mail->SMTPSecure = 'tls';                              // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = getenv('SMTP_PORT');                        // TCP port to connect to
                    $mail->CharSet = "UTF-8";

                    //Recipients
                    $mail->setFrom('from@example.com', 'Mailer');
                    $mail->addAddress($email);     // Add a recipient
                    //$mail->addAddress('ellen@example.com');               // Name is optional
                    $mail->addReplyTo('info@example.com', 'Information');
                    $mail->addCC('cc@example.com');
                    $mail->addBCC('bcc@example.com');

                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Set a new password';
                    $mail->Body    = "Please click on the following url to setup a new password: <br><a href='{$actual_link}/cms/reset.php?email={$email}&token={$token}'>Reset password</a>";
                    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    $message = "<div class=\"alert alert-success\" role=\"alert\">Message has been sent.<br>Please check you email</div>";
                } catch (Exception $e) {
                    $message = "<div class=\"alert alert-info\" role=\"alert\">Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
                }

            }else{
                confirmQuery($connection);
            }
        }



    }

?>


<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <?php echo $message; ?>
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

