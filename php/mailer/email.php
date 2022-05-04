<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'fedugalher.blog@gmail.com';                     //SMTP username
    $mail->Password   = 'Enjambre.1989';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('fedugalher.blog@gmail.com', 'Fedugalher Blog');
    $mail->addAddress("{$this->email}", "{$this->username}");     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Activa tu cuenta';
    $mail->Body    = `
                    Para activar tu cuenta ingresa al siguiente enlace: <br>
                    <a href="http://localhost/FedugalherBlog/public/index.php?user={$this->username}&token={$this->token}">Activar Cuenta</a>`;
    $mail->AltBody = 'Activa tu cuenta ingresando a este enlace';

    $mail->send();
    // echo 'El mensaje ha sido enviado';
} catch (Exception $e) {
    // echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
}

?>