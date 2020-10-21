<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
        $mail = new PHPMailer(true);
        try {

                       // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host = 'mail.xxxxxxxxxxx.kz';                    // Set the SMTP server to send through
                        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
                        $mail->Username = 'boot@xxxxxxx';                     // SMTP username
                        $mail->Password = 'xxxxxxxxxxxxx';                               // SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                        $mail->Port = 25;    // TCP port to connect to
                        $mail->CharSet = 'UTF-8';
                        $mail->Encoding = 'base64';
                        $mail->SMTPOptions = array(
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            )
                        );
            $mail->setFrom('boot@xxxxxxxxx.kz', "smm");
            $mail->addAddress('xxxxxxxxx@mail.ru', 'sMM');     // Add a recipient
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "test";
            $mail->Body = "<h1>test</h1> <i>ИМЯ</i> : <b>test</b>";
            $mail->AltBody = '';

            $mail->send();
         //   echo "Сообщение успешно отправлено!";
        } catch (Exception $e) {
         //   echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
?>
