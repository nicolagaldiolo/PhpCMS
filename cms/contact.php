<?php  include "includes/header.php"; ?>

<?php
    $response = "";
    if(isset($_POST['submit'])){

        $name       = escape($_POST['name']);
        $email      = escape($_POST['email']);
        $subject    = escape($_POST['subject']);
        $message    = escape($_POST['message']);

        $sender = "galdiolo.nicola@gmail.com";
        $destinatario = "Nicola Galdiolo <galdiolo.nicola@gmail.com>";

        $messaggio = <<<HTML
        <html>
            <head>
                <title>{$subject}</title>
            </head>
            <body>
                <table>
                     <tr>
                      <td>Nome: </td><td>{$name}</td>
                     </tr>
                     <tr>
                      <td>Email: </td><td>{$email}</td>
                     </tr>
                     <tr>
                      <td>Soggetto: </td><td>{$subject}</td>
                     </tr>
                     <tr>
                      <td>Messaggio: </td><td>{$message}</td>
                     </tr>
                </table>
            </body>
        </html>
HTML;

        /* Per inviare email in formato HTML, si deve impostare l'intestazione Content-type. */
        $intestazioni  = "MIME-Version: 1.0\r\n";
        $intestazioni .= "Content-type: text/html; charset=iso-8859-1\r\n";

        /* intestazioni addizionali */
        $intestazioni .= "Reply-To: {$name} <{$email}>\r\n";

        /* ed infine l'invio */
        if (mail($destinatario, $subject, $messaggio, $intestazioni)) {
            $response = "<div class=\"alert alert-success\" role=\"alert\">Messaggio inviato con successo</div>";
        }else{
            $response = "<div class=\"alert alert-info\" role=\"alert\">Erroe nell'invio del messaggio</div>";
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
                        <h1>Contact</h1>
                            <?php echo $response; ?>
                            <form role="form" action="" method="post" id="login-form">

                                <div class="form-group">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="subject" class="form-control" placeholder="Enter your subject">
                                </div>
                                 <div class="form-group">
                                     <textarea class="form-control" name="message" rows="10"></textarea>
                                </div>

                                <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Submit">
                            </form>

                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>


        <hr>



<?php include "includes/footer.php";?>