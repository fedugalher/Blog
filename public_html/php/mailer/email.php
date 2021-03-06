<?php

require('./routes.php');                   //importar rutas, ahi se guarda la ruta del localhost
require('vendor/autoload.php');             //Load Composer's autoloader
require($host_root.'vendor/autoload.php');  //Requerir la libreria Dotenv instalada con composer para usar variables de entorno de archivo .env

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable($host_root);
$dotenv->load();

$mail = new PHPMailer(true);    //Create an instance; passing `true` enables exceptions

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $_ENV['MAIL_HOST'];                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_ENV['MAIL_USERNAME'];                 //SMTP username
    $mail->Password   = $_ENV['MAIL_PASSWORD'];                 //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($_ENV['MAIL_USERNAME'], 'Fedugalher Blog');
    $mail->addAddress("{$this->email}", "{$this->username}");     //Add a recipient
    // $mail->addAddress('ellen@example.com');                    //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');              //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');         //Optional name

    //Content
    $mail->isHTML(true);                                          //Set email format to HTML

    $mail->Subject = 'Activa tu cuenta';

    $mail->Body    = "Hola <b>{$this->username}:</b> <br> 
                    Gracias por registrarte en el blog de Fedugalher, 
                    por favor da clic en el siguiente enlace para validar tu cuenta y activarla: <br><br>                    
                    <a href='$host_dir/user_validation.php?method=activate&email={$this->email}&token={$this->token}'>Activar Cuenta</a>";
    
    $mail->AltBody = "Hola <b>{$this->username}</b> <br> 
                    Gracias por registrarte en el blog de Fedugalher, 
                    por favor da clic en el siguiente enlace para validar tu cuenta y activarla: <br><br>
                    $host_dir/user_validation.php?method=activate&email={$this->email}&token={$this->token}'>Activar Cuenta</a>";

    $mail->CharSet = 'UTF-8';
    
    $mail->send();
    array_push($this->message, ['msg'=>'El mensaje ha sido enviado', 'msgType'=>'succes']);
    
} catch (Exception $e) {    
    array_push($this->message, ['msg'=>"El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}", 'msgType'=>'error']);    
}

?>