<?php



require 'phpmailerANDvortex\vendor\phpmailer\phpmailer\src\Exception.php'; 
require 'phpmailerANDvortex\vendor\phpmailer\phpmailer\src\PHPMailer.php'; 
require 'phpmailerANDvortex\vendor\phpmailer\phpmailer\src\SMTP.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function envoyer_mail_verification($email, $token) {
    $mail = new PHPMailer(true);

    try {
        
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'wyll509@gmail.com';
        $mail->Password   = 'htdj grqu nxnf lfxy'; 
        $mail->SMTPSecure = 'tls'; 
        $mail->Port       = 587;

        // Destinataire
        $mail->setFrom('no-reply@votre-site.com', 'Nom de votre site');
        $mail->addAddress($email);

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = "Vérification de votre compte";
        $mail->Body    = "
            <html>
            <head>
            <title>Vérification de votre compte</title>
            </head>
            <body>
            <p>Merci de vous être inscrit. Cliquez sur le lien ci-dessous pour vérifier votre compte :</p>
            <a href='http://localhost/Game_shop/verification.php?email=$email&token=$token'>Vérifier mon compte</a>
            </body>
            </html>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'e-mail: {$mail->ErrorInfo}";
        return false;
    }
}
?>
