<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



require '/var/www/html/phpmailerANDvortex/vendor/phpmailer/phpmailer/src/Exception.php'; 
require '/var/www/html/phpmailerANDvortex/vendor/phpmailer/phpmailer/src/PHPMailer.php'; 
require '/var/www/html/phpmailerANDvortex/vendor/phpmailer/phpmailer/src/SMTP.php'; 


$dbname = "bddp";
$username = "root";
$password = "root";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];  
    $message = $_POST['message'];  
    $sql = "SELECT email FROM clients";  
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $mail = new PHPMailer(true);

        try {
       
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;
            $mail->Username = 'wyll509@gmail.com';  
            $mail->Password = 'mwia nazw hotc rrxs';  //mot de passe app
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('wyll509@gmail.com', 'wyllem');
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AltBody = strip_tags($message);  

            while ($row = $result->fetch_assoc()) {
                $mail->addAddress($row['email']);  
                $mail->send();  
                $mail->clearAddresses(); 
            }
            $sql_insert = "INSERT INTO newsletters (subject, message) VALUES ('$subject', '$message')";
            $conn->query($sql_insert);
            echo "Newsletter envoyée avec succès à tous les clients.";
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de la newsletter : {$mail->ErrorInfo}";
        }
     else {
        echo "Aucun client trouv�.";
    }
    $conn->close();
} else {
    echo "M�thode de requête invalide.";
}
?>
